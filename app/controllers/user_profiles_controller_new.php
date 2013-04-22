<?php
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $uses = array(
        'UserProfile',
        'Attachment',
        'EmailTemplate',
        'Payment'
    );
    public $components = array(
        'Email'
    );
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id',
            'UserProfile.country_id',
			'UserProfile.gender_id',
            'State.name',
            'City.name',	
        );
        parent::beforeFilter();
    }
    public function edit($user_id = null) 
    {
        $this->pageTitle = __l('Edit Profile');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
		if($this->Auth->user('user_type_id') == ConstUserTypes::Admin)
		{
			unset($this->UserProfile->validate['paypal_account']);
			unset($this->UserProfile->validate['paypal_first_name']);
			unset($this->UserProfile->validate['paypal_last_name']);
			unset($this->UserProfile->validate['dob']);
			unset($this->UserProfile->validate['address']);
			unset($this->UserProfile->validate['gender_id']);
		}
	if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.paypal_account',
                            'UserProfile.paypal_first_name',
                            'UserProfile.paypal_last_name',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
			if (empty($this->request->data['UserProfile']['gender_id'])) {
				$this->request->data['UserProfile']['gender_id'] = '';
			}
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->State->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
			$paypal_account = 1;
            if (!empty($this->data['UserProfile']['paypal_account']) && ($user['UserProfile']['paypal_account'] != $this->data['UserProfile']['paypal_account'] || $user['UserProfile']['paypal_first_name'] != $this->data['UserProfile']['paypal_first_name'] || $user['UserProfile']['paypal_last_name'] != $this->data['UserProfile']['paypal_last_name']) && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $this->loadModel('Payment');
                $rsPayStatus = $this->Payment->getVerifiedStatus($this->data['UserProfile']);
           /*     if (strtoupper($rsPayStatus['responseEnvelope.ack']) != 'SUCCESS' || strtoupper($rsPayStatus['accountStatus']) != 'VERIFIED') 
				{
                    $this->Session->setFlash(__l('Enter verified PayPal email and the name associated with it') , 'default', null, 'error');
                    $paypal_account = 0;
                    $this->UserProfile->validationErrors['paypal_account'] = __l('Enter verified PayPal email and the name associated with it');
                }*/
            }
            if ($this->UserProfile->User->validates() &$this->UserProfile->validates() &$this->UserProfile->User->UserAvatar->validates() && $ini_upload_error && $paypal_account) {
                if (!empty($this->request->data['UserProfile']['country_id'])) {
                    $this->request->data['UserProfile']['country_id'] = $this->UserProfile->Country->findCountryId($this->request->data['UserProfile']['country_id']);
                }
                $this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name']);
                $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name']);
                $paypal_account = 1;
                /*if (isset($this->request->data['UserProfile']['paypal_account']) &!empty($this->request->data['UserProfile']['paypal_account']) &$user['UserProfile']['paypal_account'] != $this->request->data['UserProfile']['paypal_account']) {
                    $this->loadModel('Payment');
                    $rsPayStatus = $this->Payment->getVerifiedStatus($this->request->data['UserProfile']);
                    if (strtoupper($rsPayStatus['responseEnvelope.ack']) != 'SUCCESS' || strtoupper($rsPayStatus['accountStatus']) != 'VERIFIED') {
                        $this->Session->setFlash(__l('Enter PayPal verification email and name associated with your PayPal') , 'default', null, 'error');
                        $paypal_account = 0;
                        $this->UserProfile->validationErrors['paypal_account'] = __l('Enter PayPal verification email and name associated with your PayPal');
                    }
                }*/
                if ($paypal_account && $this->UserProfile->save($this->request->data)) {
					// @todo "Language Filter"
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                        $this->request->data['User']['attachment_id'] = $this->Attachment->id;
                    }
                    $this->UserProfile->User->save($this->request->data['User']);
                }
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
                    $email = $this->EmailTemplate->selectTemplate('Admin User Edit');
                    $emailFindReplace = array(
                        '##USERNAME##' => $user['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
                    );
                    $this->Email->from = $email['from'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                }
            } else {
                if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['User']['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
			if (empty($user_id)) {
				$user_id = $this->Auth->user('id');
			}
            $user = $this->UserProfile->find('first', array(
                'conditions' => array(
                    'UserProfile.user_id' => $user_id
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'Habit' => array(
                        'fields' => array(
                            'Habit.id',
                            'Habit.name',
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    )
                ) ,
                'fields' => array(
                    'UserProfile.first_name',
                    'UserProfile.id',
                    'UserProfile.user_id',
                    'UserProfile.last_name',
                    'UserProfile.middle_name',
                    'UserProfile.gender_id',
                    'UserProfile.about_me',
                    'UserProfile.address',
                    'UserProfile.country_id',
                    'UserProfile.school',
                    'UserProfile.work',
                    'UserProfile.state_id',
                    'UserProfile.city_id',
                    'UserProfile.zip_code',
                    'UserProfile.dob',
                    'UserProfile.paypal_account',
                    'UserProfile.paypal_first_name',
                    'UserProfile.paypal_last_name',
                    'UserProfile.language_id',
					'UserProfile.user_education_id',
					'UserProfile.user_employment_id',
					'UserProfile.user_incomerange_id',
					'UserProfile.user_relationship_id',
					'UserProfile.own_home',
					'UserProfile.have_children',
                ) ,
                'recursive' => 2
            ));
            if (empty($user)) {
                if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                    $user_id = $this->Auth->user('id');
                }
                $user = $this->UserProfile->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $user_id
                    ) ,
                    'contain' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
            }
            $this->request->data = $user;
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
		        $userEducations = $this->UserProfile->UserEducation->find('list', array(
            'fields' => array(
                'UserEducation.education'
            )
        ));
        $userEmployments = $this->UserProfile->UserEmployment->find('list', array(
            'fields' => array(
                'UserEmployment.employment'
            )
        ));
        $userIncomeranges = $this->UserProfile->UserIncomeRange->find('list', array(
            'fields' => array(
                'UserIncomeRange.income'
            )
        ));
        $userRelationships = $this->UserProfile->UserRelationship->find('list', array(
            'fields' => array(
                'UserRelationship.relationship'
            )
        ));
        $habits = $this->UserProfile->Habit->find('list');
        $countries = $this->UserProfile->Country->find('list');
        $languages = $this->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            )
        ));
        $this->set(compact('genders', 'userEducations', 'userEmployments', 'userIncomeranges', 'userRelationships','countries', 'languages', 'habits'));
    }
    public function admin_edit($id = null) 
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
    function test() 
    {
        $users = $this->UserProfile->User->find('all', array(
            'contain' => array(
                'UserAvatar',
            ) ,
        ));
        foreach($users as $user) {
            if (!empty($user['UserAvatar'])) {
                $this->request->data['User']['id'] = $user['User']['id'];
                $this->request->data['User']['attachment_id'] = $user['UserAvatar']['id'];
                $this->UserProfile->User->save($this->request->data['User']);
            }
        }
        exit;
    }
}
?>