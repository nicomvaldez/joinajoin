<?php
class UserFriendsController extends AppController
{
    public $name = 'UserFriends';
    public $components = array(
        'Email'
    );
    public $uses = array(
        'UserFriend',
        'User',
        'TempContact',
        'EmailTemplate'
    );
    public function beforeFilter() 
    {
        $this->Security->validatePost = false;
        parent::beforeFilter();
    }
    public function myfriends($user_id = null, $status = null) 
    {
        $total_friends = $this->UserFriend->find('count', array(
            'conditions' => array(
                'UserFriend.user_id' => $user_id,
                'UserFriend.friend_status_id' => $status
            )
        ));
        $this->paginate = array(
            'conditions' => array(
                'UserFriend.user_id' => $user_id,
                'UserFriend.friend_status_id' => $status
            ) ,
            'contain' => array(
                'FriendUser'
            ) ,
            'limit' => 12
        );
        $this->UserFriend->recursive = 0;
        $this->set('userFriends', $this->paginate());
        $this->set('total_friends', $total_friends);
    }
    public function index($status = 2, $type = 'received') 
    {
        if (is_null($status)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (isset($this->request->params['named']['type'])) {
            $type = $this->request->params['named']['type'];
        }
        // Set page titles
        if ($status == ConstUserFriendStatus::Approved) {
            $this->pageTitle = __l('Accepted');
        } elseif ($status == ConstUserFriendStatus::Pending) {
            $this->pageTitle = __l('Pending');
        } elseif ($status == ConstUserFriendStatus::Rejected) {
            $this->pageTitle = __l('Rejected');
        } else {
            $this->pageTitle = __l('My Friends');
        }
        if ($type != 'user') {
            if ($type == 'received') {
                $conditions = array(
                    'UserFriend.friend_user_id' => $this->Auth->user('id') ,
                    'UserFriend.friend_status_id' => $status
                );
            } elseif ($type == 'sent') {
                $conditions = array(
                    'UserFriend.user_id' => $this->Auth->user('id') ,
                    'UserFriend.friend_status_id' => $status
                );
            }
        } else {
            $conditions = array(
                'UserFriend.user_id' => $this->request->params['named']['user'],
                'UserFriend.friend_status_id' => ConstUserFriendStatus::Approved
            );
        }
        if (ConstUserFriendType::IsTwoWay) {
            $conditions[] = array(
                'UserFriend.is_requested' => 1
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'FriendUser'
            ) ,
            'order' => array(
                'UserFriend.id DESC'
            ) ,
            'limit' => 12
        );
        $this->UserFriend->recursive = 0;
        $this->set('userFriends', $this->paginate());
        $this->set('status', $status);
        $this->set('type', $type);
        if ($type != 'user') {
            $this->autoRender = false;
            $this->render('index-compact');
        }
    }
    public function lst() 
    {
        $this->pageTitle = __l('Friends');
		$user = $this->UserFriend->User->find('first', array(
			'conditions' => array(
				'User.id' => $this->Auth->user('id')
			) ,
			'recursive' => -1,
		));
		$this->set('user', $user);
    }
    public function add($username = null) 
    {
        $this->pageTitle = __l('Add User Friend');
        // check is user exists
        $user = $this->UserFriend->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email'
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check is already added
        $friend = $this->UserFriend->find('first', array(
            'conditions' => array(
                'UserFriend.user_id' => $this->Auth->user('id') ,
                'UserFriend.friend_user_id' => $user['User']['id']
            ) ,
            'fields' => array(
                'UserFriend.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($friend)) {
            $friend_status = Configure::read('friend.is_accept') ? (ConstUserFriendStatus::Approved) : (ConstUserFriendStatus::Pending);
            $this->request->data['UserFriend']['user_id'] = $this->Auth->user('id');
            $this->request->data['UserFriend']['friend_user_id'] = $user['User']['id'];
            $this->request->data['UserFriend']['friend_status_id'] = $friend_status;
            $this->request->data['UserFriend']['is_requested'] = 1;
            $this->UserFriend->create();
            if ($this->UserFriend->save($this->request->data)) {
                // To send email to user about friend request
                if (Configure::read('friend.is_send_email_on_friend_request')) {
                    $template = (ConstUserFriendType::IsTwoWay) ? 'Two Way New Friend' : 'One Way New Friend';
                    $this->_sendFriendRequestMail($template, $user['User']['email']);
                }
                if (Configure::read('friend.is_accept') and ConstUserFriendType::IsTwoWay) {
                    $this->request->data['UserFriend']['friend_user_id'] = $this->Auth->user('id');
                    $this->request->data['UserFriend']['user_id'] = $user['User']['id'];
                    $this->request->data['UserFriend']['friend_status_id'] = ConstUserFriendStatus::Approved;
                    $this->request->data['UserFriend']['is_requested'] = 1;
                    $this->UserFriend->create();
                    $this->UserFriend->save($this->request->data);
                }
                if (!$this->RequestHandler->isAjax()) {
                    $this->Session->setFlash(__l('Friend has been added.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'user_friends',
                        'action' => 'lst'
                    ));
                } else {
                    $this->set('username', $username);
                }
            }
        } else {
            if (!$this->RequestHandler->isAjax()) {
                $this->Session->setFlash(__l('Already added in your friend\'s list.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_friends',
                    'action' => 'lst'
                ));
            } else {
                $this->set('username', $username);
            }
        }
    }
    public function _sendFriendRequestMail($template, $email) 
    {
		// @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
		$email_message = $this->EmailTemplate->selectTemplate($template);
        $emailFindReplace = array(
            '##USERNAME##' => $this->Auth->user('username') ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##PROFILE_LINK##' => Router::url(array(
                'controller' => 'users',
                'action' => 'view',
                $this->Auth->user('username') ,
                'admin' => false
            ) , true) ,
            '##REPLY_TO_EMAIL##' =>($email_message['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email_message['reply_to'],
            '##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add'
			), true),
			'##SITE_LINK##' => Router::url('/', true) ,
           '##FROM_EMAIL##' =>($email_message['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email_message['from'],
           '##CONTACT_URL##' => Router::url(array(
			   'controller' => 'contacts',
			   'action' => 'add'
            ), true),
           '##SITE_LOGO##' => Router::url(array(
			   'controller' => 'img',
			   'action' => 'logo.png',
			   'admin' => false
            ) , true) ,
        );
        $email_message['email_content'] = strtr($email_message['email_content'], $emailFindReplace);
        $email_message['subject'] = strtr($email_message['subject'], $emailFindReplace);
        $email_message['from'] = strtr($email_message['from'], $emailFindReplace);
        $email_message['reply_to'] = strtr($email_message['from'], $emailFindReplace);
        // Send e-mail to users
        $this->Email->from = $email_message['from'];
        $this->Email->to = $email;
        $this->Email->subject = $email_message['subject'];
        $this->Email->sendAs = ($email_message['is_html']) ? 'html' : 'text';
        $this->Email->send($email_message['email_content']);
    }
    public function edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Friend');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserFriend->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend has been updated') , $this->request->data['UserFriend']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend could not be updated. Please, try again.') , $this->request->data['UserFriend']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserFriend->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserFriend']['id'];
        $users = $this->UserFriend->User->find('list');
        $friendStatuses = $this->UserFriend->FriendStatus->find('list');
        $this->set(compact('users', 'friendStatuses'));
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFriend->delete($id)) {
            $this->Session->setFlash(__l('User Friend deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function reject($username = null, $type = 'received') 
    {
        if (is_null($type)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // check is user exists
        $user = $this->UserFriend->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($type == 'received') {
            // Check for is friend added
            $friend = $this->UserFriend->find('first', array(
                'conditions' => array(
                    'UserFriend.friend_user_id' => $this->Auth->user('id') ,
                    'UserFriend.user_id' => $user['User']['id']
                ) ,
                'fields' => array(
                    'UserFriend.id'
                ) ,
                'recursive' => -1
            ));
            $this->UserFriend->updateAll(array(
                'friend_status_id' => ConstUserFriendStatus::Rejected
            ) , array(
                'friend_user_id' => $this->Auth->user('id') ,
                'user_id' => $user['User']['id']
            ));
            if (ConstUserFriendType::IsTwoWay) {
                $friend = $this->UserFriend->find('first', array(
                    'conditions' => array(
                        'UserFriend.user_id' => $this->Auth->user('id') ,
                        'UserFriend.friend_user_id' => $user['User']['id']
                    ) ,
                    'fields' => array(
                        'UserFriend.id'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($friend)) {
                    $this->request->data['UserFriend']['id'] = $friend['UserFriend']['id'];
                }
                // Add another record for reject for two way friendships
                $this->request->data['UserFriend']['user_id'] = $this->Auth->user('id');
                $this->request->data['UserFriend']['friend_user_id'] = $user['User']['id'];
                $this->request->data['UserFriend']['friend_status_id'] = ConstUserFriendStatus::Rejected;
                if ($this->UserFriend->save($this->request->data));
            }
        } else if ($type == 'sent') {
            // Check for is friend added
            $friend = $this->UserFriend->find('first', array(
                'conditions' => array(
                    'UserFriend.user_id' => $this->Auth->user('id') ,
                    'UserFriend.friend_user_id' => $user['User']['id']
                ) ,
                'fields' => array(
                    'UserFriend.id'
                ) ,
                'recursive' => -1
            ));
            $this->UserFriend->updateAll(array(
                'friend_status_id' => ConstUserFriendStatus::Rejected
            ) , array(
                'user_id' => $this->Auth->user('id') ,
                'friend_user_id' => $user['User']['id']
            ));
            if (ConstUserFriendType::IsTwoWay) {
                $friend = $this->UserFriend->find('first', array(
                    'conditions' => array(
                        'UserFriend.friend_user_id' => $this->Auth->user('id') ,
                        'UserFriend.user_id' => $user['User']['id']
                    ) ,
                    'fields' => array(
                        'UserFriend.id'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($friend)) {
                    $this->request->data['UserFriend']['id'] = $friend['UserFriend']['id'];
                }
                // Add another record for reject for two way friendships
                $this->request->data['UserFriend']['user_id'] = $user['User']['id'];
                $this->request->data['UserFriend']['friend_user_id'] = $this->Auth->user('id');
                $this->request->data['UserFriend']['friend_status_id'] = ConstUserFriendStatus::Rejected;
                if ($this->UserFriend->save($this->request->data));
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->Session->setFlash('Friend has been rejected.', 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'user_friends',
                'action' => 'lst'
            ));
        } else {
            $this->set('status', __l('Rejected'));
        }
    }
    public function accept($username = null) 
    {
        $this->pageTitle = __l('Add User Friend');
        // check is user exists
        $user = $this->UserFriend->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check is already added
        $friend = $this->UserFriend->find('first', array(
            'conditions' => array(
                'UserFriend.friend_user_id' => $this->Auth->user('id') ,
                'user_id' => $user['User']['id'],
                'UserFriend.friend_status_id' => ConstUserFriendStatus::Pending
            ) ,
            'fields' => array(
                'UserFriend.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($friend)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($friend)) {
            // To update the pending friend status
            $this->UserFriend->updateAll(array(
                'friend_status_id' => ConstUserFriendStatus::Approved
            ) , array(
                'user_id' => $user['User']['id'],
                'friend_user_id' => $this->Auth->user('id')
            ));
            // To add an another record for two way friendships
            if (ConstUserFriendType::IsTwoWay) {
                $this->request->data['UserFriend']['friend_user_id'] = $user['User']['id'];
                $this->request->data['UserFriend']['user_id'] = $this->Auth->user('id');
                $this->request->data['UserFriend']['friend_status_id'] = ConstUserFriendStatus::Approved;
                $this->UserFriend->save($this->request->data);
            }
            if (!$this->RequestHandler->isAjax()) {
                $this->Session->setFlash('Friend has been accepted.', 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_friends',
                    'action' => 'lst'
                ));
            } else {
                $this->set('status', __l('Accepted'));
            }
        }
    }
    public function remove($username = null, $type = null) 
    {
        if (is_null($type)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserFriend->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($type == 'received') {
            $friend = $this->UserFriend->find('first', array(
                'conditions' => array(
                    'UserFriend.user_id' => $user['User']['id'],
                    'UserFriend.friend_user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'UserFriend.id'
                ) ,
                'recursive' => -1
            ));
        } else if ($type == 'sent') {
            $friend = $this->UserFriend->find('first', array(
                'conditions' => array(
                    'UserFriend.friend_user_id' => $user['User']['id'],
                    'UserFriend.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'UserFriend.id'
                ) ,
                'recursive' => -1
            ));
        }
        if (!empty($friend)) {
            if ($this->UserFriend->delete($friend['UserFriend']['id'])) {
                if (!$this->RequestHandler->isAjax()) {
                    $this->Session->setFlash('Friend has been removed.', 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'user_friends',
                        'action' => 'lst'
                    ));
                } else {
                    $this->set('status', __l('Removed'));
                }
            }
        }
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('User Friends');
        $this->UserFriend->recursive = 0;
        $this->set('userFriends', $this->paginate());
    }
    public function admin_view($id = null) 
    {
        $this->pageTitle = __l('User Friend');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userFriend = $this->UserFriend->find('first', array(
            'conditions' => array(
                'UserFriend.id = ' => $id
            ) ,
            'fields' => array(
                'UserFriend.id',
                'UserFriend.created',
                'UserFriend.modified',
                'UserFriend.user_id',
                'UserFriend.friend_user_id',
                'UserFriend.friend_status_id',
                'User.id',
                'User.created',
                'User.modified',
                'User.username',
                'User.email',
                'User.password',
                'User.display_name',
                'User.first_name',
                'User.last_name',
                'User.dob',
                'User.gender_id',
                'User.slug',
                'User.helper_rating_count',
                'User.total_helper_rating',
                'User.photo_album_count',
                'User.photo_count',
                'User.cookie_hash',
                'User.cookie_time_modified',
                'User.is_active',
                'FriendStatus.id',
                'FriendStatus.created',
                'FriendStatus.modified',
                'FriendStatus.name',
            ) ,
            'recursive' => 0,
        ));
        if (empty($userFriend)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userFriend['UserFriend']['id'];
        $this->set('userFriend', $userFriend);
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add User Friend');
        if (!empty($this->request->data)) {
            $this->UserFriend->create();
            if ($this->UserFriend->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend has been added') , $this->request->data['UserFriend']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend could not be added. Please, try again.') , $this->request->data['UserFriend']['id']) , 'default', null, 'error');
            }
        }
        $users = $this->UserFriend->User->find('list');
        $friendStatuses = $this->UserFriend->FriendStatus->find('list');
        $this->set(compact('users', 'friendStatuses'));
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit User Friend');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserFriend->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend has been updated') , $this->request->data['UserFriend']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" User Friend could not be updated. Please, try again.') , $this->request->data['UserFriend']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserFriend->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserFriend']['id'];
        $users = $this->UserFriend->User->find('list');
        $friendStatuses = $this->UserFriend->FriendStatus->find('list');
        $this->set(compact('users', 'friendStatuses'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFriend->delete($id)) {
            $this->Session->setFlash(__l('User Friend deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function import($domain = '') 
    {
        $this->pageTitle = __l('Friends Import');
        $enabled = false;
        //Yahoo response
        if (isset($this->request->data['UserFriend']['domain']) and $this->request->data['UserFriend']['domain'] == 'yahoo' or (isset($_GET['oauth_token']) and isset($_GET['oauth_verifier']))) {
            $emails = $this->UserFriend->getYahooContacts();
            $enabled = true;
            $this->set('contacts_source', 'yahoo');
        }
        //Google response
        else if (isset($_GET['token'])) {
            $emails = $this->UserFriend->getGmailContacts($_GET['token']);
            $this->set('contacts_source', 'gmail');
        }
        //Msn response
        else if (isset($_POST['ConsentToken'])) {
            $emails = $this->UserFriend->get_msn_contacts($_POST);
            $this->set('contacts_source', 'msn');
        } //csv export
        else if (!empty($this->request->data['Attachment'])) {
            if (!empty($this->request->data['Attachment']['filename']['tmp_name'])) {
                $file_info = pathinfo($this->request->data['Attachment']['filename']['name']);
                if ($file_info['extension'] == 'csv') {
                    if (!empty($this->request->data['Attachment']['filename']['tmp_name'])) {
                        $emails = array();
                        if ($fp = @fopen($this->request->data['Attachment']['filename']['tmp_name'], 'r')) {
                            while ($buffer = fgetcsv($fp)) {
                                if (!empty($buffer[0]) and $this->UserFriend->validEmail($buffer[0])) {
                                    $emails[$buffer[0]] = $buffer[1] ? $buffer[1] : $buffer[1];
                                }
                            }
                        }
                        fclose($fp);
                    }
                    $this->set('contacts_source', 'csv file');
                } else {
                    $this->Session->setFlash(__l('Plesae select a valid CSV file') , 'default', null, 'error');
                }
            }
            $this->set('contacts_source', 'csv file');
        }
        $exist_friend_arr = array();
        $add_friend_arr = array();
        $invite_friend_arr = array();
        if ((isset($_GET['appid']) and isset($_GET['token'])) or (isset($_GET['token'])) or (isset($_POST['ConsentToken'])) or !empty($this->request->data['Attachment']) or $enabled) {
            if (isset($emails) and (!empty($emails))) {
                $temp_contact = $this->TempContact->find('all', array(
                    'conditions' => array(
                        'TempContact.user_id = ' => $this->Auth->user('id')
                    ) ,
                    'recursive' => -1
                ));
                foreach($temp_contact as $temp) {
                    $this->TempContact->delete($temp['TempContact']['id']);
                }
                foreach($emails as $email => $name) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email = ' => $email
                        ) ,
                        'fields' => array(
                            'User.id'
                        ) ,
                        'recursive' => -1
                    ));
                    $friend = $this->UserFriend->find('first', array(
                        'conditions' => array(
                            'UserFriend.friend_user_id = ' => $user['User']['id'],
                            'UserFriend.user_id = ' => $this->Auth->user('id')
                        ) ,
                        'fields' => array(
                            'UserFriend.id'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($user) && !empty($friend)) {
                        $this->TempContact->create();
                        $this->request->data['TempContact']['user_id'] = $this->Auth->user('id');
                        $this->request->data['TempContact']['contact_id'] = $user['User']['id'];
                        $this->request->data['TempContact']['contact_name'] = $name;
                        $this->request->data['TempContact']['contact_email'] = $email;
                        $this->request->data['TempContact']['is_member'] = '1';
                        $this->TempContact->save($this->request->data);
                        unset($this->request->data['TempContact']);
                        $exist_friend_ids[] = $user['User']['id'];
                    } else if (!empty($user)) {
                        $this->TempContact->create();
                        $this->request->data['TempContact']['user_id'] = $this->Auth->user('id');
                        $this->request->data['TempContact']['contact_id'] = $user['User']['id'];
                        $this->request->data['TempContact']['contact_name'] = $name;
                        $this->request->data['TempContact']['contact_email'] = $email;
                        $this->request->data['TempContact']['is_member'] = '2';
                        $this->TempContact->save($this->request->data);
                        unset($this->request->data['TempContact']);
                        $add_friend_ids[] = $user['User']['id'];
                    } else {
                        $this->TempContact->create();
                        $this->request->data['TempContact']['user_id'] = $this->Auth->user('id');
                        $this->request->data['TempContact']['contact_name'] = $name;
                        $this->request->data['TempContact']['contact_email'] = $email;
                        $this->request->data['TempContact']['is_member'] = '3';
                        $this->TempContact->save($this->request->data);
                        unset($this->request->data['TempContact']);
                        $invite_friend_arr[$name] = $email;
                    }
                }
                if (!empty($exist_friend_ids)) {
                    $exist_friend_ids = implode(',', $exist_friend_ids);
                    $this->set('exist_friend_arr', $exist_friend_arr);
                }
                if (!empty($add_friend_ids)) {
                    $add_friend_ids = implode(',', $add_friend_ids);
                    $this->set('add_friend_arr', $add_friend_arr);
                }
                if (!empty($invite_friend_arr)) {
                    $this->set('invite_friend_arr', $invite_friend_arr);
                }
            } else {
                $this->redirect(array(
                    'controller' => 'user_friends',
                    'action' => 'import'
                ));
            }
        } else if (!empty($this->request->data)) {
            if (isset($this->request->data['UserFriend']['domain']) and $this->request->data['UserFriend']['domain'] == 'gmail') {
                $this->redirect($this->UserFriend->getGmailUrl());
            } else if (isset($this->request->data['UserFriend']['domain']) and $this->request->data['UserFriend']['domain'] == 'msn') {
                $this->redirect($this->UserFriend->getLiveUrl());
            }
        }
        $this->set('current_user', $this->Auth->User('id'));
    }
    public function importfriends() 
    {
        if (!empty($this->request->data)) {
            //prd($this->request->data);
            foreach($this->request->data['UserFriend'] as $temp_id => $option) {
                if ($option == 1) {
                    $temp_contact = $this->TempContact->find('first', array(
                        'conditions' => array(
                            'TempContact.id' => $temp_id
                        ) ,
                        'recursive' => -1
                    ));
                    if ($temp_contact['TempContact']['is_member'] == 1) {
                        $friend = $this->UserFriend->find('first', array(
                            'conditions' => array(
                                'UserFriend.user_id' => $this->Auth->user('id') ,
                                'UserFriend.friend_user_id' => $temp_contact['TempContact']['contact_id']
                            ) ,
                            'recursive' => -1
                        ));
                        $this->UserFriend->delete($friend['UserFriend']['id']);
                        if (Configure::read('friend.is_two_way')) {
                            $other_friend = $this->UserFriend->find('first', array(
                                'conditions' => array(
                                    'UserFriend.user_id' => $temp_contact['TempContact']['contact_id'],
                                    'UserFriend.friend_user_id' => $this->Auth->user('id')
                                ) ,
                                'recursive' => -1
                            ));
                            $this->UserFriend->delete($other_friend['UserFriend']['id']);
                        }
                    } else if ($temp_contact['TempContact']['is_member'] == 2) {
                        $this->UserFriend->create();
                        $friend_status = Configure::read('friend.is_accept') ? (ConstUserFriendStatus::Approved) : (ConstUserFriendStatus::Pending);
                        $this->request->data['UserFriend']['user_id'] = $this->Auth->user('id');
                        $this->request->data['UserFriend']['friend_user_id'] = $temp_contact['TempContact']['contact_id'];
                        $this->request->data['UserFriend']['friend_status_id'] = $friend_status;
                        $this->request->data['UserFriend']['is_requested'] = 1;
                        $this->UserFriend->create();
                        $this->UserFriend->save($this->request->data);
                        if (Configure::read('friend.is_accept') and Configure::read('friend.is_two_way')) {
                            $this->request->data['UserFriend']['friend_user_id'] = $this->Auth->user('id');
                            $this->request->data['UserFriend']['user_id'] = $temp_contact['TempContact']['contact_id'];
                            $this->request->data['UserFriend']['friend_status_id'] = ConstUserFriendStatus::Approved;
                            $this->request->data['UserFriend']['is_requested'] = 0;
                            $this->UserFriend->create();
                            $this->UserFriend->save($this->request->data);
                        }
                    } else if ($temp_contact['TempContact']['is_member'] == 3) {
                        $this->_sendInviteMail($temp_contact['TempContact']['contact_email']);
                    }
                    $this->TempContact->delete($temp_contact['TempContact']['id']);
                }
            }
            $this->Session->setFlash(__l('Your friend has been invited.') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'temp_contacts',
                'action' => 'index',
                $this->request->data['UserFriend']['member'],
                $this->request->data['UserFriend']['contacts_source']
            ));
        }
        exit;
    }
    public function _sendInviteMail($contact_email) 
    {
        $template = $this->EmailTemplate->selectTemplate('Invite User');
        $emailFindReplace = array(
            '##USERNAME##' => $this->Auth->user('username') ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' =>($template['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $template['from'],
            '##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add'
			), true),
            '##SITE_LOGO##' => Router::url(array(
				'controller' => 'img',
				'action' => 'logo.png',
				'admin' => false
            ) , true) ,
        );
        $emailFindReplace['##REFER_LINK##'] = Router::url(array(
            'controller' => 'users',
            'action' => 'register'
        ) , true);
        $message = strtr($template['email_content'], $emailFindReplace);
        // Send e-mail to users
        $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
        $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        $this->Email->to = $contact_email;
        $this->Email->subject = strtr($template['subject'], $emailFindReplace);
        $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
        $this->Email->send($message);
    }
    public function invite_friend() 
    {
        if (!empty($this->request->data)) {
            $this->UserFriend->set($this->request->data);
            if ($this->UserFriend->validates()) {
                $friend_email = explode(',', $this->request->data['UserFriend']['friends_email']);
                foreach($friend_email as $to_email) {
                    $this->_sendInviteMail($to_email);
                }
                $this->Session->setFlash(__l('Your friend has been invited.') , 'default', null, 'success');
                $this->request->data = array();
            } else {
                $this->Session->setFlash(__l('Problem in inviting.') , 'default', null, 'error');
            }
        }
    }
}
?>