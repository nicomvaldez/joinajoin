<?php
class UsersController extends AppController
{
    public $name = 'Users';
    public $components = array(
        'Email',
        'OauthConsumer',
    );
    public $uses = array(
        'User',        		'UserProfile',
        'EmailTemplate',
        'TempPaymentLog',
        'Payment',
		'PropertyUser',
    );
    public $helpers = array(
        'Csv',
        'PagSeguro',
    );
    public $permanentCacheAction = array(
        'view' => array(
            'is_public_url' => true,
            'is_user_specific_url' => true,
            'is_view_count_update' => true
        )
    );		//creo usuario unico y sin espacios ni caracteres especiales		public function crea_username($cadena, $largo = 20) {		$cadena = trim($cadena);		$cadena = strtr($cadena,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");		$cadena = strtr($cadena,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");		$cadena = preg_replace('#([^.a-z0-9]+)#i', '-', $cadena);	        $cadena = preg_replace('#-{2,}#','-',$cadena);	        $cadena = preg_replace('#-$#','',$cadena);	        $cadena = preg_replace('#^-#','',$cadena);			$cadena = $cadena . md5(uniqid(mt_rand(), false));				$cadena = substr($cadena, 0, $largo);		return $cadena;	}
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'User.send_to_user_id',
            'User.referred_by_user_id',
            'User.adaptive_normal',
            'User.adaptive_connect',
            'User.payment_type',
            'User.is_show_new_card',
        );
        parent::beforeFilter();
    }
    public function show_header()
    {
    }
    public function view($username = null)
    {
        $this->pageTitle = __l('User');
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username = ' => $username
            ) ,
            'contain' => array(
                'UserProfile' => array(
                    'fields' => array(
                        'UserProfile.created',
                        'UserProfile.about_me',                        						'UserProfile.first_name',												'UserProfile.last_name'
                    ) ,
                ) ,
            ) ,
            'recursive' => 2
        ));
        $friend = $this->User->UserFriend->find('first', array(
            'conditions' => array(
                'UserFriend.user_id' => $this->Auth->user('id') ,
                'UserFriend.friend_user_id' => $user['User']['id'],
                'UserFriend.friend_status_id' => ConstUserFriendStatus::Approved
            ) ,
            'recursive' => -1
        ));
        $this->set('friend', $friend);
        if ($this->RequestHandler->prefers('kml')) {
            $this->set('user', $user);
        } else {
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->User->UserView->create();
            $this->request->data['UserView']['user_id'] = $user['User']['id'];
            $this->request->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
            $this->request->data['UserView']['ip_id'] = $this->User->UserView->toSaveIp();;
            $this->User->UserView->save($this->request->data);
            $this->pageTitle.= ' - ' . $username;
            $this->set('user', $user);
        }
    }
    public function register()
    {        $this->UserProfile->create();
        $this->pageTitle = __l('User Registration');
        $fbuser = $this->Session->read('fbuser');
        $user_type_check = $this->Session->read('user_type');		        if (!empty($fbuser['fb_user_id'])) {        	            $this->request->data['User']['username'] = $fbuser['username'];
            $this->request->data['User']['email'] = '';
            $this->request->data['User']['fb_user_id'] = $fbuser['fb_user_id'];
            $this->request->data['User']['fb_access_token'] = $fbuser['fb_access_token'];
            $this->request->data['User']['is_facebook_register'] = 1;
            if (!empty($user_type_check) && $user_type_check == 'merchant') {
                $type = 'merchant';
            }
            $this->Session->delete('fbuser');
        } 
         if (empty($this->data) and Configure::read('facebook.is_enabled_facebook_connect') && !$this->Auth->user() && !empty($fbuser)) {
            $this->_facebook_login();
            $facebook_connect = true;
            $this->set('facebook_connect', $facebook_connect);
        }
        // Twitter modified registration: Comes for registration from oauth //
        $twuser = $this->Session->read('twuser');
        if (empty($this->request->data)) {
            if (!empty($twuser)) {
                $this->request->data['User']['username'] = $twuser['username'];
                $this->request->data['User']['email'] = '';
                $this->request->data['User']['twitter_user_id'] = $twuser['twitter_user_id'];
                $this->request->data['User']['twitter_access_token'] = $twuser['twitter_access_token'];
                $this->request->data['User']['twitter_access_key'] = $twuser['twitter_access_key'];
                $this->request->data['User']['is_twitter_register'] = 1;
                $twitter_connect = true;
                $this->set('twitter_connect', $twitter_connect);
                if (Configure::read('affiliate.is_enabled')) {
                    //user id will be set in cookie
                    $cookie_value = $this->Cookie->read('referrer');
                    if (!empty($cookie_value)) {
                        $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
                    }
                }
                $this->Session->delete('twuser');
            }
        }
        //open id component included
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        //App::import('Component', 'Openid');
        //$this->Openid = null;// new OpenidComponent($collection);
        $openid = $this->Session->read('openid');
        if (!empty($openid['openid_url'])) {
            if (isset($openid['email'])) {
                $this->request->data['User']['email'] = $openid['email'];
                $this->request->data['User']['username'] = $openid['username'];
                $this->request->data['User']['openid_url'] = $openid['openid_url'];
                $openid_connect = true;
                $this->set('openid_connect', $openid_connect);
                if (!empty($openid['is_gmail_register'])) {
                    $this->request->data['User']['is_gmail_register'] = $openid['is_gmail_register'];
                }
                if (!empty($openid['is_yahoo_register'])) {
                    $this->request->data['User']['is_yahoo_register'] = $openid['is_yahoo_register'];
                }
                $this->Session->delete('openid');
            }
        }
        // handle the fields return from openid
        if (count($_GET) > 1) {
            $returnTo = Router::url(array(
                'controller' => 'users',
                'action' => 'register'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                // Required Fields
                if ($user = $this->User->UserOpenid->find('first', array(
                    'conditions' => array(
                        'UserOpenid.openid' => $response->identity_url
                    )
                ))) {
                    //Already existing user need to do auto login
                    $this->request->data['User']['email'] = $user['User']['email'];
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user['User']['password'];
                    if ($this->Auth->login($this->request->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        if ($this->RequestHandler->isAjax()) {
                            echo 'success';
                            exit;
                        } else {
                            $this->redirect(array(
                                'controller' => 'user_profiles',
                                'action' => 'edit'
                            ));
                        }
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    if (Configure::read('affiliate.is_enabled')) {
                        //user id will be set in cookie
                        $cookie_value = $this->Cookie->read('referrer');
                        if (!empty($cookie_value)) {
                            $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
                        }
                    }
                    $sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                    $sreg = $sregResponse->contents();
                    $this->request->data['User']['username'] = isset($sreg['nickname']) ? $sreg['nickname'] : '';
                    $this->request->data['User']['email'] = isset($sreg['email']) ? $sreg['email'] : '';
                    $this->request->data['User']['openid_url'] = $response->identity_url;
                }
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // send to openid public function  with open id url and redirect page
        if (!empty($this->request->data['User']['openid']) && preg_match('/^(http|https)?:\/\/+[a-z]/', $this->request->data['User']['openid'])) {
            $this->User->set($this->request->data);
            unset($this->User->validate[Configure::read('user.using_to_login') ]);
            unset($this->User->validate['passwd']);
            unset($this->User->validate['email']);
            if ($this->User->validates()) {
                $this->request->data['User']['redirect_page'] = 'register';
                $this->_openid();
            } else {
                $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
            }
        } else {
            if (!empty($this->request->data)) {
                $this->User->set($this->request->data);				$this->UserProfile->set($this->request->data['UserProfile']);
                if ($this->User->validates() && $this->UserProfile->validates()) {											                    $this->User->create();					$this->UserProfile->create();					
                    if (!empty($this->request->data['User']['openid_url']) or !empty($this->request->data['User']['fb_user_id'])) {
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['email'] . Configure::read('Security.salt'));
                        //For open id register no need for email confirm, this will override is_email_verification_for_register setting
                        $this->request->data['User']['is_agree_terms_conditions'] = 1;
                        // @todo "User activation"
                        $this->request->data['User']['is_email_confirmed'] = 1;
                        if (empty($this->request->data['User']['fb_user_id']) && empty($this->request->data['User']['is_gmail_register']) && empty($this->request->data['User']['is_yahoo_register'])) {
                            $this->request->data['User']['is_openid_register'] = 1;
                        }
                    } elseif (!empty($this->request->data['User']['twitter_user_id'])) { // Twitter modified registration: password  -> twitter user id and salt //
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['twitter_user_id'] . Configure::read('Security.salt'));
                        // @todo "User activation"
                        $this->request->data['User']['is_email_confirmed'] = 1;
                    } else {
                        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
                        // @todo "User activation"
                        $this->request->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
                    }
                    if (!Configure::read('user.signup_fee')) {
                        $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                    }
                    $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
                    // @todo "IP table logic"
                    $this->request->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();										//creo un username unico					$this->request->data['User']['username'] = $this->crea_username($this->request->data['UserProfile']['first_name'], 20);					                    if ($this->User->save($this->request->data, false)) {						//salvo e perfil						$this->request->data['UserProfile']['user_id'] = $this->User->id;												$this->UserProfile->save($this->request->data);						
                        // send to admin mail if is_admin_mail_after_register is true
                        $email = $this->EmailTemplate->selectTemplate('New User Join');
                        if (Configure::read('user.is_admin_mail_after_register')) {
                            $emailFindReplace = array(
                                '##USERNAME##' => $this->request->data['User']['first_name'],
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_LINK##' => Router::url('/', true) ,
                                '##USEREMAIL##' => $this->request->data['User']['email'],
                                // @todo "IP table logic"
                                '##SIGNUPIP##' => $this->request->data['User']['signup_ip'],
                                '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
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
                            
                            // Send e-mail to users
                              
                            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
                            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
                            $this->Email->to = Configure::read('site.admin_email');
                            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        }
                        $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                        // Twitter modified registration: conditions added for twitter login after registration //
                        if (!empty($this->request->data['User']['openid_url']) || !empty($this->request->data['User']['fb_user_id']) || !empty($this->request->data['User']['twitter_user_id'])) {
                            // send welcome mail to user if is_welcome_mail_after_register is true
                            if (Configure::read('user.is_welcome_mail_after_register')) {
                                $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                            }
                            if (empty($this->request->data['User']['fb_user_id']) && empty($this->request->data['User']['twitter_user_id'])) {
                                $this->request->data['UserOpenid']['openid'] = $this->request->data['User']['openid_url'];
                                $this->request->data['UserOpenid']['user_id'] = $this->User->id;
                                $this->User->UserOpenid->create();
                                $this->User->UserOpenid->save($this->request->data);
                            }
							$this->_checkOrderPlaced($this->User->id);
                            if (Configure::read('user.signup_fee')) {
                                $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                                App::import('Model', 'Payment');
                                $this->Payment = new Payment();
                                $this->Payment->_createCimProfile($this->User->id);
                                $this->Session->setFlash(__l(' You have successfully registered with our site after paying only login to site.') , 'default', null, 'success');
                                $this->redirect(array(
                                    'controller' => 'payments',
                                    'action' => 'membership_pay_now',
                                    $this->User->id,
                                    $this->User->getActivateHash($this->User->id)
                                ));
                            }
                            if ($this->Auth->login($this->request->data)) {
                                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                if ($this->RequestHandler->isAjax()) {
                                    echo 'success';
                                    exit;
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'user_profiles',
                                        'action' => 'edit'
                                    ));
                                }
                            }
                        } else {
                            //For openid register no need to send the activation mail, so this code placed in the else
                            // @todo "User activation" check setting (Yahoo, Gmail, Openid & Normal) and send "Activation Request" mail
                            if (Configure::read('user.is_email_verification_for_register')) {
                                $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                $this->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                            }
							$this->_checkOrderPlaced($this->User->id);
                            if (Configure::read('user.signup_fee')) {
                                $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                                App::import('Model', 'Payment');
                                $this->Payment = new Payment();
                                $this->Payment->_createCimProfile($this->User->id);
                                $this->Session->setFlash(__l(' You have successfully registered with our site after paying only login to site.') , 'default', null, 'success');
                                $this->redirect(array(
                                    'controller' => 'payments',
                                    'action' => 'membership_pay_now',
                                    $this->User->id,
                                    $this->User->getActivateHash($this->User->id)
                                ));
                            }
                        }
                        // send welcome mail to user if is_welcome_mail_after_register is true
                        if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                            $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                        }
                        // @todo "User activation" check setting (Yahoo, Gmail, Openid & Normal) and do auto login
                        if (!Configure::read('user.is_email_verification_for_register') and Configure::read('user.is_auto_login_after_register')) {
                            $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                            if ($this->Auth->login($this->request->data)) {
                                $cookie_value = $this->Cookie->read('referrer');
                                if (!empty($cookie_value) && (!Configure::read('affiliate.is_enabled'))) {
                                    $this->Cookie->delete('referrer'); // Delete referer cookie

                                }
                                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                if ($this->RequestHandler->isAjax()) {
                                    echo 'success';
                                    exit;
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'collections'
                                    ));
                                }
                            }
                        }
                        if ($this->RequestHandler->isAjax()) {
                            echo 'success';
                            exit;
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'login'
                            ));
                        }
                    }
                } else {
                    if (empty($this->request->data['User']['openid_url'])) {
                        $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                        unset($this->request->data['User']['captcha']);
                        unset($this->request->data['User']['ajax_captcha']);
                    } else {
                        if (!empty($this->request->data['User']['is_gmail_register'])) {
                            $flash_verfy = 'Gmail';
                        } elseif (!empty($this->request->data['User']['is_yahoo_register'])) {
                            $flash_verfy = 'Yahoo';
                        } else {
                            $flash_verfy = 'OpenID';
                        }
                        $this->Session->setFlash($flash_verfy . ' ' . __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'error');
                    }
                }
            }
        }
        //for user referral system
        if (empty($this->request->data) && Configure::read('affiliate.is_enabled')) {
            //user id will be set in cookie
            $cookie_value = $this->Cookie->read('referrer');
            if (!empty($cookie_value)) {
                $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
            }
        }
        unset($this->request->data['User']['passwd']);
        // When already logged user trying to access the registration page we are redirecting to site home page
        if ($this->Auth->user()) {
            $this->redirect(Router::url('/collections', true));
        }
        if ($this->RequestHandler->isAjax()) {
            $this->render('register_ajax');
        }
    }
    // <-- For iPhone App code
    public function validate_user()
    {
        if ((Configure::read('user.using_to_login') == 'email') && isset($this->request->data['User']['username'])) {
            $this->request->data['User']['email'] = $this->request->data['User']['username'];
            unset($this->request->data['User']['username']);
        }
        $this->request->data['User'][Configure::read('user.using_to_login') ] = trim($this->request->data['User'][Configure::read('user.using_to_login') ]);
        $this->request->data['User']['password'] = $_GET['data']['User']['passwd'];
        $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
        if ($this->Auth->login($this->request->data)) {
            $resonse = array(
                'status' => 0,
                'message' => __l('Success')
            );
        } else {
            $resonse = array(
                'status' => 1,
                'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
            );
        }
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
        }
    }
    // For iPhone App code -->
    function oauth_facebook()
    {
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.app_id') ,
            'secret' => Configure::read('facebook.secrect_key') ,
            'cookie' => true
        ));
        $this->autoRender = false;
        if (!empty($_REQUEST['code'])) {
            $tokens = $this->facebook->setAccessToken(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'code' => $_REQUEST['code']
            ));
            $fb_return_url = $this->Session->read('fb_return_url');
            $this->redirect($fb_return_url);
        } else {
            $this->Session->setFlash(__l('Invalid Facebook Connection.') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        exit;
    }
	public function _checkOrderPlaced($user_id)
	{
		if(!empty($_SESSION['order_id']))
		{
			$order_id=$_SESSION['order_id'];
			 $propertyUser = $this->PropertyUser->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $order_id,
                        ) ,
                    'recursive' => -1
                ));
			  if(empty($propertyUser['PropertyUser']['user_id']))
			  {
				  $data=array();
				  $data['PropertyUser']['id']=$order_id;
				  $data['PropertyUser']['user_id']=$user_id;
				  $this->PropertyUser->save($data,false);
				  unset($_SESSION['order_id']);
			  }
		}
	}
    // For iPhone App code -->
    public function dashboard()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Property',
                'PropertyUser'
            ) ,
            'recursive' => 1
        ));
        $this->pageTitle = __l('Dashboard');
        $purchase_conditions['PropertyUser.user_id'] = $this->Auth->user('id');
        $purchase_conditions['NOT']['PropertyUser.property_user_status_id'] = array(
            ConstPropertyUserStatus::Canceled,
            ConstPropertyUserStatus::Rejected,
            ConstPropertyUserStatus::Expired,
            ConstPropertyUserStatus::CanceledByAdmin,
        );
        $total_purchased = $this->User->PropertyUser->find('first', array(
            'conditions' => $purchase_conditions,
            'fields' => array(
                'SUM(PropertyUser.price) as total_amount'
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('total_purchased', $total_purchased);
        // Buyer Orders //
        $filter_count = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $all_count = ($filter_count['User']['travel_expired_count']+$filter_count['User']['travel_rejected_count']+$filter_count['User']['travel_canceled_count']+$filter_count['User']['travel_review_count']+$filter_count['User']['travel_completed_count']+$filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']+$filter_count['User']['travel_waiting_for_acceptance_count']+$filter_count['User']['travel_negotiation_count']+$filter_count['User']['travel_payment_pending_count']+$filter_count['User']['travel_arrived_count']);
        $this->set('all_count', $all_count);
        $status = array(
            __l('Arrived / Confirmed') => array(
                'in_progress',
                ($filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']) ,
                'arrivedconfirmed'
            ) ,
            __l('Pending Host Accept') => array(
                'waiting_for_acceptance',
                $filter_count['User']['travel_waiting_for_acceptance_count'],
                'pendinghostaccept'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['travel_arrived_count'],
                'arrived'
            ) ,
            __l('Waiting For Your Review') => array(
                'waiting_for_review',
                $filter_count['User']['travel_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['travel_completed_count'],
                'completed'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['travel_canceled_count'],
                'cancelled'
            ) ,
            __l('Host Rejected') => array(
                'rejected',
                $filter_count['User']['travel_rejected_count'],
                'hostrejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['travel_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['travel_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Pending') => array(
                'payment_pending',
                $filter_count['User']['travel_payment_pending_count'],
                'paymentpending'
            ) ,
        );
        $this->set('moreActions', $status);
        $host_all_count = ($filter_count['User']['host_expired_count']+$filter_count['User']['host_canceled_count']+$filter_count['User']['host_rejected_count']+$filter_count['User']['host_completed_count']+$filter_count['User']['host_review_count']+$filter_count['User']['host_arrived_count']+$filter_count['User']['host_confirmed_count']+$filter_count['User']['host_waiting_for_acceptance_count']+$filter_count['User']['host_negotiation_count']+$filter_count['User']['host_payment_cleared_count']);
        $this->set('host_all_count', $host_all_count);
        $host_status = array(
            __l('Confirmed') => array(
                'confirmed',
                ($filter_count['User']['host_confirmed_count']) ,
                'confirmed'
            ) ,
            __l('Waiting for Acceptance') => array(
                'waiting_for_acceptance',
                $filter_count['User']['host_waiting_for_acceptance_count'],
                'waitingforacceptance'
            ) ,
            __l('Waiting for Traveler Review') => array(
                'waiting_for_review',
                $filter_count['User']['host_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['host_completed_count'],
                'completed'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['host_arrived_count'],
                'arrived'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['host_canceled_count'],
                'cancelled'
            ) ,
            __l('Rejected') => array(
                'rejected',
                $filter_count['User']['host_rejected_count'],
                'rejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['host_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['host_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Cleared') => array(
                'payment_cleared',
                $filter_count['User']['host_payment_cleared_count'],
                'payment_cleared '
            ) ,
        );
        $this->set('host_moreActions', $host_status);
    }


	public function joiner_dashboard()
	{
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Property',
                'PropertyUser',                                'UserProfile'
            ) ,
            'recursive' => 1
        ));
        $this->pageTitle = __l('Dashboard');
        $purchase_conditions['PropertyUser.user_id'] = $this->Auth->user('id');
        $purchase_conditions['NOT']['PropertyUser.property_user_status_id'] = array(
            ConstPropertyUserStatus::Canceled,
            ConstPropertyUserStatus::Rejected,
            ConstPropertyUserStatus::Expired,
            ConstPropertyUserStatus::CanceledByAdmin,
        );
        $total_purchased = $this->User->PropertyUser->find('first', array(
            'conditions' => $purchase_conditions,
            'fields' => array(
                'SUM(PropertyUser.price) as total_amount'
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
        $this->set('total_purchased', $total_purchased);
        // Buyer Orders //
        $filter_count = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $all_count = ($filter_count['User']['travel_expired_count']+$filter_count['User']['travel_rejected_count']+$filter_count['User']['travel_canceled_count']+$filter_count['User']['travel_review_count']+$filter_count['User']['travel_completed_count']+$filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']+$filter_count['User']['travel_waiting_for_acceptance_count']+$filter_count['User']['travel_negotiation_count']+$filter_count['User']['travel_payment_pending_count']+$filter_count['User']['travel_arrived_count']);
        $this->set('all_count', $all_count);
        $status = array(
            __l('Arrived / Confirmed') => array(
                'in_progress',
                ($filter_count['User']['travel_arrived_count']+$filter_count['User']['travel_confirmed_count']) ,
                'arrivedconfirmed'
            ) ,
            __l('Pending Host Accept') => array(
                'waiting_for_acceptance',
                $filter_count['User']['travel_waiting_for_acceptance_count'],
                'pendinghostaccept'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['travel_arrived_count'],
                'arrived'
            ) ,
            __l('Waiting For Your Review') => array(
                'waiting_for_review',
                $filter_count['User']['travel_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['travel_completed_count'],
                'completed'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['travel_canceled_count'],
                'cancelled'
            ) ,
            __l('Host Rejected') => array(
                'rejected',
                $filter_count['User']['travel_rejected_count'],
                'hostrejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['travel_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['travel_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Pending') => array(
                'payment_pending',
                $filter_count['User']['travel_payment_pending_count'],
                'paymentpending'
            ) ,
        );
        $this->set('moreActions', $status);
        $host_all_count = ($filter_count['User']['host_expired_count']+$filter_count['User']['host_canceled_count']+$filter_count['User']['host_rejected_count']+$filter_count['User']['host_completed_count']+$filter_count['User']['host_review_count']+$filter_count['User']['host_arrived_count']+$filter_count['User']['host_confirmed_count']+$filter_count['User']['host_waiting_for_acceptance_count']+$filter_count['User']['host_negotiation_count']+$filter_count['User']['host_payment_cleared_count']);
        $this->set('host_all_count', $host_all_count);
        $host_status = array(
            __l('Confirmed') => array(
                'confirmed',
                ($filter_count['User']['host_confirmed_count']) ,
                'confirmed'
            ) ,
            __l('Waiting for Acceptance') => array(
                'waiting_for_acceptance',
                $filter_count['User']['host_waiting_for_acceptance_count'],
                'waitingforacceptance'
            ) ,
            __l('Waiting for Traveler Review') => array(
                'waiting_for_review',
                $filter_count['User']['host_review_count'],
                'waitingforyourreview'
            ) ,
            __l('Completed') => array(
                'completed',
                $filter_count['User']['host_completed_count'],
                'completed'
            ) ,
            __l('Arrived') => array(
                'arrived',
                $filter_count['User']['host_arrived_count'],
                'arrived'
            ) ,
            __l('Canceled') => array(
                'canceled',
                $filter_count['User']['host_canceled_count'],
                'cancelled'
            ) ,
            __l('Rejected') => array(
                'rejected',
                $filter_count['User']['host_rejected_count'],
                'rejected'
            ) ,
            __l('Expired') => array(
                'expired',
                $filter_count['User']['host_expired_count'],
                'expired'
            ) ,
            __l('Negotiation') => array(
                'negotiation',
                $filter_count['User']['host_negotiation_count'],
                'negotiationrequested'
            ) ,
            __l('Payment Cleared') => array(
                'payment_cleared',
                $filter_count['User']['host_payment_cleared_count'],
                'payment_cleared '
            ) ,
        );
        $this->set('host_moreActions', $host_status);
    }


    public function hosting_panel()
    {
        $user_id = $this->request->params['named']['user_id'];
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 0,
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 7,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 30,
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Cleared') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUser',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.is_payment_cleared' => 1
                    ) ,
                    'alias' => 'ClearedRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-cleared'
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Pipeline') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUsers',
                    'colspan' => 1
                )
            );
            // @todo "Auto review" add condition CompletedAndClosedByAdmin
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.property_user_status_id' => array(
							ConstPropertyUserStatus::Confirmed,
							ConstPropertyUserStatus::Arrived,
							ConstPropertyUserStatus::WaitingforReview,
							ConstPropertyUserStatus::Completed
						) ,
						'PropertyUser.is_payment_cleared' => 0,
                    ) ,
                    'alias' => 'PipelineRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-pipeline'
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => __l('Lost') ,
                    'isNeedLoop' => false,
                    'alias' => 'PropertyUsers',
                    'colspan' => 1
                )
            );
            $models[] = array(
                'PropertyUser' => array(
                    'display' => '',
                    'conditions' => array(
                        'PropertyUser.owner_user_id' => $user_id,
                        'PropertyUser.property_user_status_id' => array(
                            ConstPropertyUserStatus::Canceled,
                            ConstPropertyUserStatus::Rejected,
                            ConstPropertyUserStatus::Expired,
                            ConstPropertyUserStatus::CanceledByAdmin,
                        )
                    ) ,
                    'alias' => 'LostRevenueAmountRecieved',
                    'type' => 'cInt',
                    'isSub' => 'PropertyUsers',
                    'class' => 'highlight-lost'
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'PropertyUser') {
                            $RevenueRecieved = $this->User->PropertyUser->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'COUNT(PropertyUser.id) as total_count'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_count']);
                        }
                    }
                }
            }
        }
        $this->set(compact('periods', 'models'));
    }
    public function _openid()
    {
        //open id component included
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Openid');
        $this->Openid = new OpenidComponent($collection);
        $returnTo = Router::url(array(
            'controller' => 'users',
            'action' => $this->request->data['User']['redirect_page']
        ) , true);
        $siteURL = Router::url('/', true);
        // send openid url and fields return to our server from openid
        if (!empty($this->request->data)) {
            try {
                $this->Openid->authenticate($this->request->data['User']['openid'], $returnTo, $siteURL, array(
                    'email',
                    'nickname'
                ) , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash($e->getMessage());
            }
        }
    }
    public function _sendActivationMail($user_email, $user_id, $hash)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
        $email = $this->EmailTemplate->selectTemplate('Activation Request');
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user_id,
                $hash
            ) , true) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
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
        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
        $this->Email->to = $user_email;
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
		$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
            return true;
        }
    }
    public function _sendMembershipMail($user_id, $hash)
    {
        //send membership mail to users
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $email = $this->EmailTemplate->selectTemplate('Membership Fee');
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##MEMBERSHIP_URL##' => Router::url(array(
                'controller' => 'payments',
                'action' => 'membership_pay_now',
                $this->User->id,
                $hash,
                'admin' => false,
            ) , true) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
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
        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
        $this->Email->to = $user['User']['email'];
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
		$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
            return true;
        }
    }
    public function _sendWelcomeMail($user_id, $user_email, $username)
    {
    $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##USERNAME##' => $username,
            '##CONTACT_MAIL##' => Configure::read('site.contact_email') ,
            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
            '##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add'
			), true),
            '##SITE_LINK##' => Router::url('/', true),
            '##SITE_LOGO##' => Router::url(array(
            'controller' => 'img',
            'action' => 'logo.png',
            'admin' => false
            ) , true) ,
            
        );
        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
        $this->Email->to = $user_email;
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }
    public function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getResendActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->request->data['User']['id'] = $user_id;
            $this->request->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            if (!Configure::read('user.signup_fee')) {
                $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            }
            $this->User->save($this->request->data);
            // active is false means redirect to home page with message
            if (!$user['User']['is_active']) {
                if ((Configure::read('user.signup_fee') && $user['User']['is_paid'] == 0) || !Configure::read('user.is_admin_activate_after_register')) {
                    App::import('Model', 'Payment');
                    $this->Payment = new Payment();
                    $this->Payment->_createCimProfile($user['User']['id']);
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after pay the membership fee.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'membership_pay_now',
                        $user['User']['id'],
                        $this->User->getActivateHash($user['User']['id'])
                    ));
                } else {
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                }
                $this->redirect(Router::url('/', true));
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->request->data['User']['email'] = $user['User']['email'];
                $this->request->data['User']['username'] = $user['User']['username'];
                $this->request->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login($this->request->data)) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit'
                    ));
                }
            }
            // user is active but auto login is false then the user will redirect to login page with message
            $this->Session->setFlash(sprintf(__l('You have successfully activated your account. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin || $this->User->isValidResendActivateHash($user_id, $hash)) {
            $hash = $this->User->getActivateHash($user_id);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'recursive' => -1
            ));
            if ($this->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                    $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
            }
        } else {
            $this->Session->setFlash(__l('Invalid resend activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function _facebook_login()
    {
        $me = $this->Session->read('fbuser');
        if (empty($me)) {
            $this->Session->setFlash(__l('Problem in Facebook connect. Please try again') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.fb_user_id' => $me['id']
            ) ,
            'fields' => array(
                'User.fb_user_id',
                'User.password',
                'User.username',
                'User.email'
            ) ,
        ));
        $this->Auth->fields['username'] = 'username';
        //create new user
        if (empty($user)) {
			$checkFacebookEmail = $this->User->find('first', array(
				'conditions' => array(
					'User.email' => $me['email']
				) ,
				'fields' => array(
					'User.id',
					'User.email',
					'User.username',
					'User.password',
					'User.fb_user_id',
					'User.is_active',
				) ,
				'recursive' => -1
			));
			if (!empty($checkFacebookEmail)) {
				$this->Session->delete('fbuser');
				if (empty($checkFacebookEmail['User']['is_active'])) {
					$this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'login',
						'admin' => false
					));
				}
				$_data['User']['username'] = $checkFacebookEmail['User']['username'];
				$_data['User']['email'] = $checkFacebookEmail['User']['email'];
				$_data['User']['password'] = $checkFacebookEmail['User']['password'];
				if ($this->Auth->login($_data)) {
					$this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
					if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
						$this->Session->delete('Auth.redirectUrl');
						$this->redirect(Router::url('/', true) . $redirectUrl);
					} else {
						$this->redirect(array(
                            'controller' => 'users',
                            'action' => 'joiner_dashboard',
                        ));
					}
				}
			}
            App::import('Core', 'HttpSocket');
            $HttpSocket = new HttpSocket();
            $friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $me['access_token']);
            $friends = json_decode($friends->body);
            $allow_login = 1;
            if (count($friends->data) < Configure::read('facebook.login_allow_friends_count')) {
                $allow_login = 0;
            }
            $this->User->create();
            $this->request->data['UserProfile']['first_name'] = !empty($me['first_name']) ? $me['first_name'] : '';
            $this->request->data['UserProfile']['middle_name'] = !empty($me['middle_name']) ? $me['middle_name'] : '';
            $this->request->data['UserProfile']['last_name'] = !empty($me['last_name']) ? $me['last_name'] : '';
            $this->request->data['UserProfile']['about_me'] = !empty($me['about_me']) ? $me['about_me'] : '';
            if (empty($this->request->data['User']['username']) && strlen($me['first_name']) > 2) {
                $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name']));
            }
            if (empty($this->request->data['User']['username']) && strlen($me['first_name'] . $me['last_name']) > 2) {
                $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name'] . $me['last_name']));
            }
            if (empty($this->request->data['User']['username']) && strlen($me['first_name'] . $me['middle_name'] . $me['last_name']) > 2) {
                $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($me['first_name'] . $me['middle_name'] . $me['last_name']));
            }
            $this->request->data['User']['username'] = str_replace(' ', '', $this->request->data['User']['username']);
            $this->request->data['User']['username'] = str_replace('.', '_', $this->request->data['User']['username']);
            // A condtion to avoid unavilability of user username in our sites
            if (strlen($this->request->data['User']['username']) <= 2) {
                $this->request->data['User']['username'] = !empty($me['first_name']) ? str_replace(' ', '', strtolower($me['first_name'])) : 'fbuser';
                $i = 1;
                $created_user_name = $this->request->data['User']['username'] . $i;
                while (!$this->User->checkUsernameAvailable($created_user_name)) {
                    $created_user_name = $this->request->data['User']['username'] . $i++;
                }
                $this->request->data['User']['username'] = $created_user_name;
            }
            // Removes email, when facebook registration email id already present in users table.
            $this->request->data['User']['email'] = !empty($me['email']) ? $me['email'] : '';
            if (!empty($this->request->data['User']['email'])) {
                $check_user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email' => $this->request->data['User']['email']
                    ) ,
                    'recursive' => -1
                ));
            }
            if (!empty($check_user['User']['email'])) {
                unset($this->request->data['User']['email']);
            }
            $this->request->data['User']['fb_user_id'] = $me['id'];
            $this->request->data['User']['fb_access_token'] = $me['access_token'];
            $this->request->data['User']['password'] = $this->Auth->password($me['id'] . Configure::read('Security.salt'));
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
             $this->request->data['User']['is_facebook_register'] = 1;
            // @todo "User activation"
            $this->request->data['User']['is_email_confirmed'] = 1;
            if (!Configure::read('user.signup_fee')) {
                $this->request->data['User']['is_active'] = 1;
            }
            $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
            // @todo "IP table logic"
            $this->request->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
            //for user referral system
            if (Configure::read('affiliate.is_enabled')) {
                //user id will be set in cookie
                $cookie_value = $this->Cookie->read('referrer');
                if (!empty($cookie_value)) {
                    $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
                }
            }
            //end
            if ($allow_login) {
                $this->User->save($this->request->data, false);
                $this->request->data['UserProfile']['user_id'] = $this->User->id;
                $this->User->UserProfile->save($this->request->data);
                if (!empty($friends->data)) {
                    foreach($friends->data as $friend) {
                        $this->request->data['UserFacebookFriend']['user_id'] = $this->User->id;
                        $this->request->data['UserFacebookFriend']['facebook_friend_name'] = $friend->name;
                        $this->request->data['UserFacebookFriend']['facebook_friend_id'] = $friend->id;
                        $this->User->UserFacebookFriend->create();
                        $this->User->UserFacebookFriend->save($this->request->data['UserFacebookFriend']);
                    }
                }
                $this->User->updateAll(array(
                    'User.is_facebook_friends_fetched' => 1,
                    'User.fb_access_token' => "'" . $me['access_token'] . "'",
                    'User.network_fb_user_id' => "'" . $me['id'] . "'",
                    'User.last_facebook_friend_fetched_date' => "'" . date('Y-m-d') . "'",
                    'User.user_facebook_friend_count' => count($friends->data) ,
                ) , array(
                    'User.id' => $this->User->id
                ));
                // @todo "User activation" check settings & send "Activation Request" mail
                // @todo "User activation" check settings and do auto login
				$this->_checkOrderPlaced($this->User->id);
                if (Configure::read('user.signup_fee')) {
                    $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                    $this->Session->delete('fbuser');
                    App::import('Model', 'Payment');
                    $this->Payment = new Payment();
                    $this->Payment->_createCimProfile($this->User->id);
                    $this->Session->setFlash(__l(' You have successfully registered with our site after paying membership fee only you can login to site.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'membership_pay_now',
                        $this->User->id,
                        $this->User->getActivateHash($this->User->id)
                    ));
                }
                if ($this->Auth->login($this->request->data)) {
                    $cookie_value = $this->Cookie->read('referrer');
                    if (!empty($cookie_value) && (!Configure::read('affiliate.is_enabled'))) {
                        $this->Cookie->delete('referrer'); // Delete referer cookie

                    }
                    $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                    // send welcome mail to user if is_welcome_mail_after_register is true
                    if (Configure::read('user.is_welcome_mail_after_register')) {
                        $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                    }
                    if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                        $this->Session->delete('Auth.redirectUrl');
                        $this->redirect(Router::url('/', true) . $redirectUrl);
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'joiner_dashboard',
                        ));
                    }
                }
            } else {
                $this->Session->delete('fbuser');
                $this->Session->setFlash(__l('You should have minimum ') . Configure::read('facebook.login_allow_friends_count') . ' facebook friends to connect via facebook, please try with our registration', 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register',
                ));
            }
        } else {
            $this->request->data['User']['fb_user_id'] = $me['id'];
            $this->User->updateAll(array(
                'User.fb_access_token' => '\'' . $me['access_token'] . '\'',
                'User.fb_user_id' => '\'' . $me['id'] . '\'',
            ) , array(
                'User.id' => $user['User']['id']
            ));
            $this->request->data['User']['email'] = $user['User']['email'];
            $this->request->data['User']['username'] = $user['User']['username'];
            $this->request->data['User']['password'] = $user['User']['password'];
            if ($this->Auth->login($this->request->data)) {
                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                    $this->Session->delete('Auth.redirectUrl');
                    $this->redirect(Router::url('/', true) . $redirectUrl);
                } else {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'joiner_dashboard',
                    ));
                }
            }
        }
    }
    public function genreteFBName($fb_user)
    {
        if (!empty($fb_user[0]['name'])) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(str_replace('.', '_', $fb_user[0]['name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name'] . $fb_user[0]['last_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name'] . $fb_user[0]['last_name']));
        }
        if (empty($this->request->data['User']['username']) && strlen($fb_user[0]['first_name'] . $fb_user[0]['middle_name'] . $fb_user[0]['last_name']) > 2) {
            $this->request->data['User']['username'] = $this->User->checkUsernameAvailable(strtolower($fb_user[0]['first_name'] . $fb_user[0]['middle_name'] . $fb_user[0]['last_name']));
        }
        $this->request->data['User']['username'] = str_replace(' ', '', $this->request->data['User']['username']);
        $this->request->data['User']['username'] = str_replace('.', '_', $this->request->data['User']['username']);
        // A condtion to avoid unavilability of user username in our sites
        if (strlen($this->request->data['User']['username']) <= 2) {
            $this->request->data['User']['username'] = !empty($fb_user[0]['first_name']) ? str_replace(' ', '', strtolower($fb_user[0]['first_name'])) : 'fbuser';
            $i = 1;
            $created_user_name = $this->request->data['User']['username'] . $i;
            while (!$this->User->checkUsernameAvailable($created_user_name)) {
                $created_user_name = $this->request->data['User']['username'] . $i++;
            }
            $this->request->data['User']['username'] = $created_user_name;
        }
        return low($this->request->data['User']['username']);
    }
    public function login()
    {
        unset($this->User->validate['email']['rule3']);
        unset($this->User->validate['email']['rule4']);
        unset($this->User->validate['username']['rule3']);
        $fb_sess_check = $this->Session->read('fbuser');
        if (empty($this->data) and Configure::read('facebook.is_enabled_facebook_connect') && !$this->Auth->user() && !empty($fb_sess_check) && !$this->Session->check('is_fab_session_cleared')) {
            $this->_facebook_login();
        }
        $this->pageTitle = __l('Login');
        // Twitter Login //
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'twitter' && Configure::read('twitter.is_enabled_twitter_connect')) {
            $twitter_return_url = Router::url(array(
                'controller' => 'users',
                'action' => 'oauth_callback',
                'admin' => false
            ) , true);
            $requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'https://api.twitter.com/oauth/request_token', $twitter_return_url);
            $this->Session->write('requestToken', serialize($requestToken));
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $this->redirect('http://twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
            } else {
                $this->set('redirect_url', 'http://twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
                $this->set('authorize_name', 'twitter');
                $this->layout = 'redirect_page';
                $this->pageTitle.= ' - ' . __l('Twitter');
                $this->render('authorize');
            }
        }
        // Facebook Login //
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'facebook') {
            $fb_return_url = Router::url(array(
                'controller' => 'users',
                'action' => 'register',
                'admin' => false
            ) , true);
            $this->Session->write('fb_return_url', $fb_return_url);
            $redirect_url = $this->facebook->getLoginUrl(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'scope' => 'email,publish_stream'
            ));
            $this->set('redirect_url', $redirect_url);
            $this->set('authorize_name', 'facebook');
            $this->layout = 'redirect_page';
            $this->pageTitle.= ' - ' . __l('Facebook');
            $this->render('authorize');
        }
        // yahoo Login //
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'yahoo') {
            $this->request->data['User']['email'] = '';
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['redirect_page'] = 'login';
            $this->request->data['User']['openid'] = 'http://yahoo.com/';
            $this->_openid();
        }
        // gmail Login //
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'gmail') {
            $this->request->data['User']['email'] = '';
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['redirect_page'] = 'login';
            $this->request->data['User']['openid'] = 'https://www.google.com/accounts/o8/id';
            $this->_openid();
        }
        //open id component included
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        //App::import('Component', 'Openid');
        //$this->Openid = new OpenidComponent($collection);
        // handle the fields return from openid
        if (!empty($_GET['openid_identity'])) {
            $returnTo = Router::url(array(
                'controller' => 'users',
                'action' => 'login'
            ) , true);
            $response = $this->Openid->getResponse($returnTo);
            if ($response->status == Auth_OpenID_SUCCESS) {
                // Required Fields
                if ($user = $this->User->UserOpenid->find('first', array(
                    'conditions' => array(
                        'UserOpenid.openid' => $response->identity_url
                    )
                ))) {
                    //Already existing user need to do auto login
                    $this->request->data['User']['email'] = $user['User']['email'];
                    $this->request->data['User']['username'] = $user['User']['username'];
                    $this->request->data['User']['password'] = $user['User']['password'];
                    if ($this->Auth->login($this->request->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        if ($redirectUrl = $this->Session->read('Auth.redirectUrl')) {
                            $this->Session->delete('Auth.redirectUrl');
                            $this->redirect(Router::url('/', true) . $redirectUrl);
                        } else {
                            if ($this->RequestHandler->isAjax()) {
                                echo 'success';
                                exit;
                            } else {
                                $this->redirect(array(
                                    'controller' => 'user_profiles',
                                    'action' => 'edit'
                                ));
                            }
                        }
                    } else {
                        $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    $sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                    $sreg = $sregResponse->contents();
                    $temp['username'] = isset($sreg['nickname']) ? $sreg['nickname'] : '';
                    $temp['email'] = isset($sreg['email']) ? $sreg['email'] : '';
                    $temp['openid_url'] = $response->identity_url;
                    $respone_url = $response->identity_url;
                    $respone_url = parse_url($respone_url);
                    if (!empty($respone_url['host']) && $respone_url['host'] == 'www.google.com') {
                        $temp['is_gmail_register'] = 1;
                    } elseif (!empty($respone_url['host']) && $respone_url['host'] == 'me.yahoo.com') {
                        $temp['is_yahoo_register'] = 1;
                    }
                    $this->Session->write('openid', $temp);
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'register'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Authenticated failed or you may not have profile in your OpenID account'));
            }
        }
        // check open id is given or not
        if (!empty($this->request->data['User']['openid']) && preg_match('/^(http|https)?:\/\/+[a-z]/', $this->request->data['User']['openid'])) {
            // Fix for given both email and openid url in login page....
            $this->Auth->logout();
            $this->request->data['User']['email'] = '';
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['redirect_page'] = 'login';
            $this->_openid();
        } else {
            // remember me for user
            if (!empty($this->request->data) && empty($this->request->data['User']['openid'])) {
                $this->request->data['User'][Configure::read('user.using_to_login') ] = trim($this->request->data['User'][Configure::read('user.using_to_login') ]);
                //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
                unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
                    if ($this->Auth->login($this->request->data)) {
                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                        if ($this->Auth->user()) {
                            if (!empty($this->request->data['User']['is_remember']) and $this->request->data['User']['is_remember'] == 1) {
                                $this->Cookie->delete('User');
                                $cookie = array();
                                $remember_hash = md5($this->request->data['User'][Configure::read('user.using_to_login') ] . $this->request->data['User']['password'] . Configure::read('Security.salt'));
                                $cookie['cookie_hash'] = $remember_hash;
                                $this->Cookie->write('User', $cookie, true, $this->cookieTerm);
                                $this->User->updateAll(array(
                                    'User.cookie_hash' => '\'' . md5($remember_hash) . '\'',
                                    'User.cookie_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
                                ) , array(
                                    'User.id' => $this->Auth->user('id')
                                ));
                            } else {
                                $this->Cookie->delete('User');
                            }
                            if (!empty($this->request->data['User']['f']) and !$this->RequestHandler->isAjax()) {
                                if (!empty($this->request->data['User']['order_id'])) {
                                    App::import('Model', 'PropertyUser');
                                    $PropertyUser = new PropertyUser;
                                    $PropertyUser->updateAll(array(
                                        'PropertyUser.user_id' => $this->Auth->user('id') ,
                                    ) , array(
                                        'PropertyUser.id' => $this->request->data['User']['order_id']
                                    ));
                                }
                                $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
                            } else if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                                if ($this->RequestHandler->isAjax()) {
                                    echo 'success';
                                    exit;
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'stats',
                                        'admin' => true
                                    ));
                                }
                            } else {
                                if ($this->RequestHandler->isAjax()) {
                                    echo 'success';
                                    exit;
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'joiner_dashboard',
                                        'admin' => false
                                    ));
                                }
                            }
                        }
                    } else {
                        $this->User->validationErrors['passwd'] = __l('Sorry, login failed. Your ') . Configure::read('user.using_to_login') . __l(' or password are incorrect');
                        if (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') {
                            $this->Session->setFlash(sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login')) , 'default', null, 'error');
                        } else {
                            $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                        }
                    }
                } else {
                    $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                }
            }
        }
        //When already logged user trying to access the login page we are redirecting to site home page
        if ($this->Auth->user()) {
            if ($this->RequestHandler->isAjax()) {
                echo 'success';
                exit;
            } else {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'joiner_dashboard',
                    'admin' => false
                ));
            }
        }
        if (!empty($this->request->data['User']['type']) && $this->request->data['User']['type'] == 'openid') {
            $this->request->params['named']['type'] = 'openid';
        }
        if (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'openid') {
            if (!empty($this->request->data) && (empty($this->request->data['User']['openid']) || $this->request->data['User']['openid'] == "Click to Sign In")) {
                $this->User->validationErrors['openid'] = __l('Required');
                $this->Session->setFlash(__l('Invalid OpenID entered. Please enter valid OpenID') , 'default', null, 'error');
            }
            $this->render('login_ajax_openid');
        }
        if ($this->RequestHandler->isAjax()) {
            if (!(!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'openid')) {
                $this->request->data['User']['passwd'] = '';
                $this->render('login_ajax');
            }
        }
        $this->request->data['User']['passwd'] = '';
    }
    public function oauth_callback()
    {
        $this->autoRender = false;
        App::import('Xml');
        // Fix to avoid the mail validtion for  Twitter
        $this->Auth->fields['username'] = 'username';
        $requestToken = $this->Session->read('requestToken');
        $requestToken = unserialize($requestToken);
        $accessToken = $this->OauthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);
        $this->Session->write('accessToken', $accessToken);
        if (empty($accessToken->key) && empty($accessToken->secret)) {
            $this->Session->setFlash(__l('Problem in Twitter connect. Please try again') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $oauth_xml = $this->OauthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'https://twitter.com/account/verify_credentials.xml');
        $this->request->data['User']['twitter_access_token'] = (isset($accessToken->key)) ? $accessToken->key : '';
        $this->request->data['User']['twitter_access_key'] = (isset($accessToken->secret)) ? $accessToken->secret : '';
        $data = Xml::toArray(Xml::build($oauth_xml['body']));
        $data['User'] = $data['user'];
        unset($data['user']);
        // So this to check whether it is  admin login to get its twiiter acces tocken
        if ($this->Auth->user('id') and $this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            App::import('Model', 'Setting');
            $setting = new Setting;
            $setting->updateAll(array(
                'Setting.value' => "'" . $this->request->data['User']['twitter_access_token'] . "'",
            ) , array(
                'Setting.name' => 'twitter.site_user_access_token'
            ));
            $setting->updateAll(array(
                'Setting.value' => "'" . $this->request->data['User']['twitter_access_key'] . "'"
            ) , array(
                'Setting.name' => 'twitter.site_user_access_key'
            ));
            $this->Session->setFlash(__l('Your Twitter credentials are updated') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'settings',
                'admin' => true
            ));
        }
        $allowed_to_login = 1;
        if ($data['User']['followers_count'] < Configure::read('twitter.login_allow_follower_count')) {
            $allowed_to_login = 0;
        }
        $d1 = strtotime($data['User']['created_at']);
        $d2 = time();
        $months = floor(($d2-$d1) /2628000);
        if ($months < Configure::read('twitter.login_allow_created_month')) {
            $allowed_to_login = 0;
        }
        if (empty($data['User']['id'])) {
            $this->Session->setFlash(__l('Problem in Twitter connect. Please try again') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.twitter_user_id' => $data['User']['id']
            ) ,
            'fields' => array(
                'User.id',
                'UserProfile.id',
                'User.user_type_id',
                'User.username',
                'User.email',
            ) ,
            'recursive' => 0
        ));
        if (!$allowed_to_login && empty($user)) {
            $this->Session->setFlash(__l('Twitter login/register allows only twitter user must have ') . Configure::read('twitter.login_allow_follower_count') . __l(' followers count or account registered ') . Configure::read('twitter.login_allow_created_month') . __l(' month ago') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (empty($user)) {
            // Twitter modified registration: Prompts for email after regisration. Redirects to register method //
            if (Configure::read('twitter.prompt_for_email_after_register')) {
                $temp['first_name'] = empty($data['User']['name']) ? $data['User']['name'] : '';
                $temp['last_name'] = empty($data['User']['name']) ? $data['User']['name'] : '';
                $temp['username'] = $this->genreteTWName($data); // Twitter modified registration: Generate autoname from this method //
                $temp['twitter_user_id'] = !empty($data['User']['id']) ? $data['User']['id'] : '';
                $temp['twitter_access_token'] = (isset($accessToken->key)) ? $accessToken->key : '';
                $temp['twitter_access_key'] = (isset($accessToken->secret)) ? $accessToken->secret : '';
                $this->Session->write('twuser', $temp);
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            } else {
                // @todo "User activation"
                $this->request->data['User']['is_email_confirmed'] = 1;
                $this->request->data['User']['is_twitter_register'] = 1;
                $this->request->data['User']['is_active'] = 1;
                $this->request->data['User']['is_agree_terms_conditions'] = '1';
                $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
                // @todo "IP table logic"
                $this->request->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
                $this->request->data['User']['twitter_user_id'] = $data['User']['id'];
                $created_user_name = $this->User->checkUsernameAvailable($data['User']['screen_name']);
                if (strlen($created_user_name) <= 2) {
                    $this->request->data['User']['username'] = !empty($data['User']['screen_name']) ? $data['User']['screen_name'] : 'twuser';
                    $i = 1;
                    $created_user_name = $this->request->data['User']['username'] . $i;
                    while (!$this->User->checkUsernameAvailable($created_user_name)) {
                        $created_user_name = $this->request->data['User']['username'] . $i++;
                    }
                }
                $this->request->data['User']['username'] = $created_user_name;
            }
        } else {
            $this->request->data['User']['id'] = $user['User']['id'];
            $this->request->data['User']['username'] = $user['User']['username'];
        }
        unset($this->User->validate['username']['rule2']);
        unset($this->User->validate['username']['rule3']);
        $this->request->data['User']['password'] = $this->Auth->password($data['User']['id'] . Configure::read('Security.salt'));
        $this->request->data['User']['avatar_url'] = $data['User']['profile_image_url'];
        $this->request->data['User']['twitter_url'] = (isset($data['User']['url'])) ? $data['User']['url'] : '';
        $this->request->data['User']['description'] = (isset($data['User']['description'])) ? $data['User']['description'] : '';
        $this->request->data['User']['location'] = (isset($data['User']['location'])) ? $data['User']['location'] : '';
        if (Configure::read('affiliate.is_enabled')) {
            $cookie_value = $this->Cookie->read('referrer');
            if (!empty($cookie_value)) {
                $this->request->data['User']['referred_by_user_id'] = $cookie_value['refer_id'];
            }
        }
        if ($this->User->save($this->request->data, false)) {
            $cookie_value = $this->Cookie->read('referrer');
            if (!empty($cookie_value) && (!Configure::read('affiliate.is_enabled'))) {
                $this->Cookie->delete('referrer'); // Delete referer cookie

            }
            // @todo "User activation" check settings & send "Activation Request" mail
            // @todo "User activation" check settings and do auto login
            if ($this->Auth->login($this->request->data)) {
                $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'joiner_dashboard',
                ));
            }
        }
        if (!empty($this->request->data['User']['f'])) {
            $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
        }
        $this->redirect(Router::url('/', true));
    }
    public function genreteTWName($data)
    {
        $created_user_name = $this->User->checkUsernameAvailable($data['User']['screen_name']);
        if (strlen($created_user_name) <= 2) {
            $this->request->data['User']['username'] = !empty($data['User']['screen_name']) ? $data['User']['screen_name'] : 'twuser';
            $i = 1;
            $created_user_name = $this->request->data['User']['username'] . $i;
            while (!$this->User->checkUsernameAvailable($created_user_name)) {
                $created_user_name = $this->request->data['User']['username'] . $i++;
            }
        }
        return $created_user_name;
    }
    public function logout()
    {
        if ($this->Auth->user('fb_user_id')) {
            // Quick fix for facebook redirect loop issue.
            $this->Session->write('is_fab_session_cleared', 1);
            $this->Session->delete('fbuser');
        }
        unset($_SESSION['network_level']);
        $this->Auth->logout();
        $this->Cookie->delete('User');
        $this->Cookie->delete('user_language');
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->redirect(Router::url('/', true));
    }
    public function forgot_password()
    {
        unset($this->User->validate['email']['rule3']);
        unset($this->User->validate['email']['rule4']);
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            $this->redirect(Router::url('/', true));
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            unset($this->User->validate['email']['rule4']);
            if ($this->User->validates()) {
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.email =' => $this->request->data['User']['email'],
                        'User.is_active' => 1
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.email'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($user['User']['email'])) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $user['User']['email']
                        ) ,
                        'contain' => array(
                            'UserProfile'
                        ) ,
                        'recursive' => 1
                    ));
                    $email = $this->EmailTemplate->selectTemplate('Forgot Password');
                    $emailFindReplace = array(
                        '##USERNAME##' => (isset($user['User']['username'])) ? $user['User']['username'] : '',
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##RESET_URL##' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'reset',
                            $user['User']['id'],
                            $this->User->getResetPasswordHash($user['User']['id'])
                        ) , true) ,
                        '##CONTACT_MAIL##' => Configure::read('site.contact_email') ,
                        '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
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
                  
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
                    $this->Email->to = $this->User->formatToAddress($user);
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    $this->Session->setFlash(__l('An email has been sent with a link where you can change your password') , 'default', null, 'success');
                    if ($this->RequestHandler->isAjax()) {
                        echo 'success';
                        exit;
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                } else {
                    $this->User->validationErrors['email'] = __l('There is no user registered with the email ') . $this->request->data['User']['email'];
                    $this->Session->setFlash(sprintf(__l('There is no user registered with the email %s or admin deactivated your account. If you spelled the address incorrectly or entered the wrong address, please try again.') , $this->request->data['User']['email']) , 'default', null, 'error');
                }
            }
        }
        if ($this->RequestHandler->isAjax()) {
            $this->render('forgot_password_ajax');
        }
    }
    public function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        if (!empty($this->request->data)) {
            if ($this->User->isValidResetPasswordHash($this->request->data['User']['user_id'], $this->request->data['User']['hash'])) {
                $this->User->set($this->request->data);
                if ($this->User->validates()) {
                    $this->User->updateAll(array(
                        'User.password' => '\'' . $this->Auth->password($this->request->data['User']['passwd']) . '\'',
                    ) , array(
                        'User.id' => $this->request->data['User']['user_id']
                    ));
                    $this->Session->setFlash(__l('Your password has been changed successfully, Please login now') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
                $this->request->data['User']['passwd'] = '';
                $this->request->data['User']['confirm_password'] = '';
            } else {
                $this->Session->setFlash(__l('Invalid change password request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
        } else {
            if (is_null($user_id) or is_null($hash)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.is_active' => 1,
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash)) {
                $this->Session->setFlash(__l('Invalid change password request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->request->data['User']['user_id'] = $user_id;
            $this->request->data['User']['hash'] = $hash;
        }
    }
    public function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        // No change password for facebook, twitter or openid //
        if ($this->Auth->user('is_openid_register') || $this->Auth->user('fb_user_id') || $this->Auth->user('twitter_user_id')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if ($this->User->updateAll(array(
                    'User.password' => '\'' . $this->Auth->password($this->request->data['User']['passwd']) . '\'',
                ) , array(
                    'User.id' => $this->request->data['User']['user_id']
                ))) {
                    if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                        $this->Auth->logout();
                        $this->Session->setFlash(__l('Your password has been changed successfully. Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->request->data['User']['user_id']
                            ) ,
                            'contain' => array(
                                'UserProfile'
                            ) ,
                            'recursive' => 1
                        ));
                        $email = $this->EmailTemplate->selectTemplate('Admin Change Password');
                        $emailFindReplace = array(
                            '##PASSWORD##' => $this->request->data['User']['passwd'],
                            '##USERNAME##' => $user['User']['username'],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##SITE_LINK##' => Router::url('/', true) ,
                            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
                            '##CONTACT_URL##'=> Router::url(array(
                				'controller' => 'contacts',
                				'action' => 'add'
                			), true),
                            '##SITE_LOGO##' => Router::url(array(
								'controller' => 'img',
								'action' => 'logo.png',
								'admin' => false
                            ) , true) ,
                        );
                        // Send e-mail to users
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
                        $this->Email->to = $this->User->formatToAddress($user);
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    }
                    $this->Session->setFlash(__l('Password has been changed successfully') , 'default', null, 'success');
                    if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                        $this->redirect(array(
                            'action' => 'index'
                        ));
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
            }
            unset($this->request->data['User']['old_password']);
            unset($this->request->data['User']['passwd']);
            unset($this->request->data['User']['confirm_password']);
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $conditions = array();
            $conditions[] = array(
                'OR' => array(
                    'User.fb_user_id IS NULL',
                    'User.fb_user_id' => 0
                )
            );
            $conditions[] = array(
                'User.is_openid_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_gmail_register' => 0
            );
            $conditions[] = array(
                'OR' => array(
                    'User.twitter_user_id IS NULL',
                    'User.twitter_user_id' => 0
                )
            );
            $users = $this->User->find('list', array(
                'conditions' => $conditions,
            ));
            $this->set(compact('users'));
        }
        $this->request->data['User']['user_id'] = (!empty($this->request->data['User']['user_id'])) ? $this->request->data['User']['user_id'] : $user_id;
    }
    public function refer()
    {
        $cookie_value = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($this->request->params['named']['r'])) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r']
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername) && (empty($cookie_value) || (!empty($cookie_value) && (!empty($user_refername)) && ($cookie_value['refer_id'] != $user_refername['User']['id'])))) {
            $this->Cookie->delete('referrer');
            $referrer['refer_id'] = $user_refername['User']['id'];
            $referrer['type'] = 'User';
            $referrer['slug'] = '';
            if (Configure::read('affiliate.is_enabled')) {
                $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
            }
            $cookie_value = $this->Cookie->read('referrer');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register'
        ));
    }
    public function top_rated()
    {
        $conditions = array();
        $order = array();
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'top_seller') {
                $order['User.actual_rating'] = 'desc';
                $conditions['User.actual_rating !='] = '0';
            }
            $users = $this->User->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1,
                'order' => $order,
                'limit' => 5
            ));
            $this->set('users', $users);
        }
    }
    public function add_to_wallet()
    {
        $this->pageTitle = __l('Add Amount to Wallet');
        $this->User->create();
        if (!empty($this->request->data)) {
            //for conflict credit card and user city
            unset($this->User->validate['city']);
            $is_valid = true;
            // <!-- common code for payment
            if (($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['User']['payment_profile_id']) && empty($this->request->data['User']['payment_profile_id']))) {
                $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
                if ($this->request->data['User']['is_show_new_card'] == 0) {
                    $payment_gateway_id_validate = array(
                        'payment_profile_id' => array(
                            'rule1' => array(
                                'rule' => 'notempty',
                                'message' => __l('Required')
                            )
                        )
                    );
                    $this->User->validate = array_merge($this->User->validate, $payment_gateway_id_validate);
                }
            } else if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['User']['payment_profile_id']))) {
                $this->User->validate = array_merge($this->User->validate, $this->User->validateCreditCard);
            } else if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::PayPal) {
                // For PayPal connect and normal PayPal
                if (!empty($this->request->data['User']['adaptive_connect']) || !empty($this->request->data['User']['adaptive_normal'])) {
                    if (!empty($this->request->data['User']['adaptive_normal'])) {
                        // Unsetting connect for other paypal process
                        unset($this->request->data['User']['user_paypal_connection_id']);
                    }
                }
                if (!empty($this->request->data['User']['user_paypal_connection_id'])) {
                    $userPaypalConnection = $this->User->UserPaypalConnection->find('first', array(
                        'conditions' => array(
                            'UserPaypalConnection.id' => $this->request->data['User']['user_paypal_connection_id']
                        ) ,
                        'recursive' => -1
                    ));
                    if (empty($userPaypalConnection)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (($userPaypalConnection['UserPaypalConnection']['amount']-$userPaypalConnection['UserPaypalConnection']['charged_amount'] < $this->request->data['User']['amount'])) {
                        $this->Session->setFlash(__l('Selected PayPal connection have insufficient money to book this property') , 'default', null, 'error');
                        $is_valid = false;
                    }
                }
            }
            $this->User->set($this->request->data);
            $this->User->_checkAmount($this->request->data['User']['amount']);
            $gateway_options = array();
            if (!$this->User->validates() || !$is_valid) {
                if ($is_valid) {
					unset($this->User->validate['firstName']);
					unset($this->User->validate['lastName']);
					unset($this->User->validate['creditCardNumber']);
					unset($this->User->validate['expiration_month']);
					unset($this->User->validate['expiration_year']);
					unset($this->User->validate['cvv2Number']);
					unset($this->User->validate['zip']);
					unset($this->User->validate['address']);
					unset($this->User->validate['city']);
					unset($this->User->validate['state']);
					unset($this->User->validate['country']);
					unset($this->User->validate['payment_profile_id']);
                    $this->Session->setFlash(__l('Amount could not be added to wallet') , 'default', null, 'error');
                }
            } else {
                if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($this->request->data['User']['creditCardNumber'])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        //create payment profile
                        $data = $this->request->data['User'];
                        $data['expirationDate'] = $this->request->data['expDateYear']['year'] . '-' . $this->request->data['expDateMonth']['month'];
                        $data['customerProfileId'] = $user['User']['cim_profile_id'];
                        $payment_profile_id = $this->Payment->_createCimPaymentProfile($data);
                        if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                            $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                            $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                            $payment['UserPaymentProfile']['is_default'] = 0;
                            $this->User->UserPaymentProfile->save($payment);
                            $this->request->data['User']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                        } else {
                            $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                            $return['error_message'] = 1;
                            $return['error'] = 1;
                        }
                    }
                    if (!empty($this->request->data['User']['payment_profile_id'])) {
                        $this->request->data['User']['from'] = 'wallet';
                        $return = $this->Payment->_amountFromAuthorizeNet($this->request->data);
                    }
                } else if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                    $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                        'conditions' => array(
                            'PaymentGateway.id' => $this->request->data['User']['payment_gateway_id'],
                        ) ,
                        'contain' => array(
                            'PaymentGatewaySetting' => array(
                                'fields' => array(
                                    'PaymentGatewaySetting.key',
                                    'PaymentGatewaySetting.test_mode_value',
                                    'PaymentGatewaySetting.live_mode_value',
                                ) ,
                            ) ,
                        ) ,
                        'recursive' => 1
                    ));
                    $action = strtolower(str_replace(' ', '', $paymentGateway['PaymentGateway']['name']));
                    Configure::write('PagSeguro.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                    if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                        foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                            if ($paymentGatewaySetting['key'] == 'pagseguro_payee_account') {
                                $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                        }
                    }
                    $amount_user = $this->request->data['User']['amount'];
                    if (!is_int($amount_user)) {
                        $user_amount = $amount_user*100;
                    } else {
                        $user_amount = $amount_user;
                    }
                    //gateway options set
                    $ref = time();
                    $gateway_options['init'] = array(
                        'pagseguro' => array( // Array com informa��es pertinentes ao pagseguro
                            'email' => $email,
                            'type' => 'CBR', // Obrigat�rio passagem para pagseguro:tipo
                            'reference' => $ref, // Obrigat�rio passagem para pagseguro:ref_transacao
                            'freight_type' => 'EN', // Obrigat�rio passagem para pagseguro:tipo_frete
                            'theme' => 1, // Opcional Este parametro aceita valores de 1 a 5, seu efeito � a troca dos bot�es padr�es do pagseguro
                            'currency' => 'BRL', // Obrigat�rio passagem para pagseguro:moeda,
                            'extra' => 0
                            // Um valor extra que voc� queira adicionar no valor total da venda, obs este valor pode ser negativo

                        ) ,
                        'definitions' => array( // Array com informa��es para manusei das informa��es
                            'currency_type' => 'real', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                            'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                            'encode' => 'utf-8'
                            // Especifica o encode n�o implementado

                        ) ,
                        'format' => array(
                            'item_id' => $this->Auth->user('id') ,
                            'item_descr' => __l('carteira') ,
                            'item_quant' => '1',
                            'item_valor' => $user_amount,
                            'item_frete' => '0',
                            'item_peso' => '20'
                        ) ,
                        'customer_info'
                    );
                    $transaction_data['TempPaymentLog'] = array(
                        'trans_id' => $ref,
                        'payment_method' => 'wallet',
                        'user_id' => $this->Auth->user('id') ,
                        // @todo "IP table logic"
                        'ip' => $this->RequestHandler->getClientIP() ,
                        'amount_needed' => $amount_user,
                        'payment_gateway_id' => $this->request->data['User']['payment_gateway_id'],
                        'currency_code' => 'BRL',
                    );
                    $this->TempPaymentLog->save($transaction_data);
                } else {
                    $return = $this->process_order($this->request->data);
                }
                if (empty($return['error']) && $this->request->data['User']['payment_gateway_id'] != ConstPaymentGateways::PagSeguro) {
                    if (empty($return['error_message'])) {
                        $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'add_to_wallet',
                        ));
                    } else {
                        $return['error_message'].= '. ';
                        $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed') , 'default', null, 'error');
                    }
                }
            }
            if (!empty($this->request->data['User']['payment_gateway_id']) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                $this->set('gateway_options', $gateway_options);
                $this->set('action', $action);
                $this->set('amount', $this->data['User']['amount']);
                $this->autoRender = false;
                $this->layout = 'redirect_page';
                $this->render('../payments/do_payment');
            }
            // common code for payment -->

        }
        $all_userPaypalConnections = $this->User->UserPaypalConnection->find('all', array(
            'conditions' => array(
                'UserPaypalConnection.is_active' => 1,
                'UserPaypalConnection.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $user_info = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        $userPaypalConnections = array();
        if (!empty($all_userPaypalConnections)) {
            foreach($all_userPaypalConnections as $userPaypalConnection) {
                $userPaypalConnections[$userPaypalConnection['UserPaypalConnection']['id']] = $userPaypalConnection['UserPaypalConnection']['sender_email'];
                if (!empty($userPaypalConnection['UserPaypalConnection']['is_default'])) {
                    $this->request->data['User']['user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                }
            }
        }
        $this->set('userPaypalConnections', $userPaypalConnections);
        $this->request->data['User']['type'] = 'user';
        $this->set('user_info', $user_info);
        // <!-- common code for payment
        $payment_options = $this->User->getGatewayTypes('is_enable_for_add_to_wallet');
        unset($payment_options[ConstPaymentGateways::Wallet]);
        if (empty($this->request->data['User']['payment_gateway_id'])) {
            if (!empty($payment_options[ConstPaymentGateways::PayPal])) {
                $this->request->data['User']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
            } elseif (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $this->request->data['User']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
            } elseif (!empty($payment_options[ConstPaymentGateways::PagSeguro])) {
                $this->request->data['User']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
            }
        }
        $gateway_options['paymentGateways'] = $payment_options;
        $gateway_options['countries'] = $this->User->UserProfile->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'asc'
            ) ,
        ));
        $gateway_options['creditCardTypes'] = array(
            'Visa' => __l('Visa') ,
            'MasterCard' => __l('MasterCard') ,
            'Discover' => __l('Discover') ,
            'Amex' => __l('Amex')
        );
        $Paymentprofiles = $this->User->UserPaymentProfile->find('all', array(
            'fields' => array(
                'UserPaymentProfile.masked_cc',
                'UserPaymentProfile.cim_payment_profile_id',
                'UserPaymentProfile.is_default'
            ) ,
            'conditions' => array(
                'UserPaymentProfile.user_id' => $this->Auth->user('id')
            ) ,
        ));
        foreach($Paymentprofiles as $pay_profile) {
            $gateway_options['Paymentprofiles'][$pay_profile['UserPaymentProfile']['cim_payment_profile_id']] = $pay_profile['UserPaymentProfile']['masked_cc'];
            if ($pay_profile['UserPaymentProfile']['is_default']) {
                $this->request->data['User']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
            }
        }
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->request->data['User']['is_show_new_card'] = 1;
        }
        $states = $this->User->UserProfile->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'fields' => array(
                'State.code',
                'State.name'
            ) ,
            'order' => array(
                'State.name' => 'asc'
            )
        ));
        $this->set('states', $states);
        $this->set('gateway_options', $gateway_options);
        $this->request->data['User']['cvv2Number'] = $this->request->data['User']['creditCardNumber'] = '';
        // common code for payment -->

    }
    public function process_order($data)
    {
        $this->autoRender = false;
        if (empty($data)) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            $return = $this->Payment->processUserOrder($data['User']);
            if (empty($return['error'])) {
                if (!empty($data['User']['user_paypal_connection_id'])) {
                    $this->Payment->processUserPayment($return['add_to_wallet_id']);
                }
            }
            return $return;
        }
    }
    public function social()
    {
        $this->pageTitle = __l('Social Networks');
        if ($this->Auth->user('id')) {
            if (!empty($this->request->data)) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
                $this->User->save($this->request->data);
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    ) ,
                    'recursive' => -1
                ));
                $this->Session->write('Auth.user', $user);
                $_SESSION['Auth']['User']['is_show_facebook_friends'] = $this->request->data['User']['is_show_facebook_friends'];
                $this->Session->setFlash(__l('Social networks settings updated successfully.') , 'default', null, 'success');
            }
            $this->request->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.app_id') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            $fb_return_url = Router::url(array(
                'controller' => 'users',
                'action' => 'fb_update',
                'admin' => false
            ) , true);
            $this->Session->write('fb_return_url', $fb_return_url);
            $fb_login_url = $this->facebook->getLoginUrl(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'scope' => 'email,offline_access,publish_stream'
            ));
            $this->set('fb_login_url', $fb_login_url);
        }
    }
    public function fb_update()
    {
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.api_id') ,
            'secret' => Configure::read('facebook.secrect_key') ,
            'cookie' => true
        ));
        if ($fb_session = $this->Session->read('fbuser')) {
            App::import('Core', 'HttpSocket');
            $HttpSocket = new HttpSocket();
            $friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $fb_session['access_token']);
            $friends = json_decode($friends->body);
            if (!empty($friends->data)) {
                foreach($friends->data as $friend) {
                    $this->request->data['UserFacebookFriend']['user_id'] = $this->Auth->user('id');
                    $this->request->data['UserFacebookFriend']['facebook_friend_name'] = $friend->name;
                    $this->request->data['UserFacebookFriend']['facebook_friend_id'] = $friend->id;
                    $this->User->UserFacebookFriend->create();
                    $this->User->UserFacebookFriend->save($this->request->data['UserFacebookFriend']);
                }
            }
            $this->User->updateAll(array(
                'User.is_facebook_friends_fetched' => 1,
                'User.fb_access_token' => "'" . $fb_session['access_token'] . "'",
                'User.network_fb_user_id' => "'" . $fb_session['id'] . "'",
                'User.last_facebook_friend_fetched_date' => "'" . date('Y-m-d') . "'",
                'User.user_facebook_friend_count' => count($friends->data) ,
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
            $_SESSION['Auth']['User']['is_facebook_friends_fetched'] = 1;
            $_SESSION['Auth']['User']['is_show_facebook_friends'] = 1;
            $_SESSION['Auth']['User']['network_fb_user_id'] = $fb_session['id'];
            $this->Session->setFlash(__l('You have successfully connected with Facebook.') , 'default', null, 'success');
            $this->Session->delete('fbuser');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'social'
        ));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_type_id',
            'filter_id',
            'q'
        ));
        $this->pageTitle = __l('Users');
        // total approved users list
        $this->set('pending', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 0,
            ) ,
            'recursive' => -1
        )));
        // total approved users list
        $this->set('approved', $this->User->find('count', array(
            'conditions' => array(
                'User.is_active = ' => 1,
            ) ,
            'recursive' => -1
        )));
        // total openid users list
        $this->set('openid', $this->User->find('count', array(
            'conditions' => array(
                'User.is_openid_register = ' => 1,
                'User.user_type_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Gmail users list
        $this->set('gmail', $this->User->find('count', array(
            'conditions' => array(
                'User.is_gmail_register = ' => 1,
                'User.user_type_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        // total Yahoo users list
        $this->set('yahoo', $this->User->find('count', array(
            'conditions' => array(
                'User.is_yahoo_register = ' => 1,
                'User.user_type_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('facebook', $this->User->find('count', array(
            'conditions' => array(
                'User.is_facebook_register' => 1,
                'User.user_type_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $this->set('twitter', $this->User->find('count', array(
            'conditions' => array(
                'User.is_twitter_register' => 1,
                'User.user_type_id = ' => ConstUserTypes::User
            ) ,
            'recursive' => -1
        )));
        $conditions = array();
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['User']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 0;
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 7;
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(User.created) <= '] = 30;
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (!empty($this->request->data['User']['filter_id'])) {
            if ($this->request->data['User']['filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_gmail_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Gmail ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.is_twitter_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Twitter ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.is_facebook_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['User']['filter_id'] == ConstMoreAction::NotifiedInactiveUsers) {
                $conditions['User.last_sent_inactive_mail !='] = NULL;
                $this->pageTitle.= __l(' - Notified Inactive Users ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['User']['filter_id'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['User']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->set('page_title', $this->pageTitle);
        $this->request->data['User']['user_type_id'] = empty($this->request->params['named']['user_type_id']) ? array(
            ConstUserTypes::User,
            ConstUserTypes::Admin
        ) : $this->request->params['named']['user_type_id'];
        // condition to list users only
        $conditions['User.user_type_id'] = $this->request->data['User']['user_type_id'];
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['User']['q'])) {
                $this->set('q', $this->request->data['User']['q']);
            }
            $this->set('contain', $contain);
        } else {
			$this->User->recursive = 2;
			$this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                       'UserProfile' => array(
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso2',
                            )
                        )
                    ) ,
                  ) ,
                'order' => array(
                    'User.id' => 'desc'
                )
            );
            if (isset($this->request->data['User']['q'])) {
                $this->paginate = array_merge($this->paginate, array(
                    'search' => $this->request->data['User']['q']
                ));
            }
            $this->set('users', $this->paginate());
            $filters = $this->User->isFilterOptions;
            $moreActions = $this->User->moreActions;
            $userTypes = $this->User->UserType->find('list');
            $this->request->data['User']['user_type_id'] = !empty($this->request->params['named']['user_type_id']) ? $this->request->params['named']['user_type_id'] : '';
            $this->set(compact('filters', 'moreActions', 'userTypes'));
        }
    }
    public function sales_revenues()
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.sales_cleared_amount',
                'User.sales_pipeline_amount',
                'User.sales_lost_amount',
            ) ,
            'recursive' => -1
        ));
        $this->set('user', $user);
    }
    public function admin_export_filtered($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidIdHash($ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserProfile',
                'ReferredByUser',
            )
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'Referred by' => (!empty($user['ReferredByUser']['username'])) ? $user['ReferredByUser']['username'] : '',
                    'Active' => ($user['User']['is_active']) ? __l('Active') : __l('Inactive') ,
                    'Email confirmed' => ($user['User']['is_email_confirmed']) ? __l('Yes') : __l('No') ,
                    'OpenID count' => $user['User']['user_openid_count'],
                    'Login count' => $user['User']['user_login_count'],
                    'View count' => $user['User']['user_view_count'],
                    'Reffered count' => $user['User']['user_referred_count'],
                    'Facebook user id' => $user['User']['fb_user_id'],
                    'twitter user id' => $user['User']['twitter_user_id'],
                    // @todo "IP table logic"
                    'Signup IP' => $user['User']['signup_ip'],
                    'Created' => $user['User']['created'],
                );
            }
        }
        $this->set('data', $data);
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add New User/Admin');
        if (!empty($this->request->data)) {
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
            // @todo "User activation"
            $this->request->data['User']['is_email_confirmed'] = 1;
            $this->request->data['User']['is_active'] = 1;
            // @todo "IP table logic"
            $this->request->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                // Send mail to user to activate the account and send account details
                $email = $this->EmailTemplate->selectTemplate('Admin User Add');
                $emailFindReplace = array(
                    '##USERNAME##' => $this->request->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##SITE_LINK##' => Router::url('/', true) ,
                    '##PASSWORD##' => $this->request->data['User']['passwd'],
                    '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
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
                $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
                $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
                $this->Email->to = $this->request->data['User']['email'];
                $this->Email->subject = strtr($email['subject'], $emailFindReplace);
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                $this->Session->setFlash(__l('User has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->request->data['User']['passwd']);
                $this->Session->setFlash(__l('User could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $userTypes = $this->User->UserType->find('list');
        $this->set(compact('userTypes'));
        if (!isset($this->request->data['User']['user_type_id'])) {
            $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->_sendAdminActionMail($id, 'Admin User Delete');
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__l('User has been deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data['User'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['User'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $userIds[] = $user_id;
                }
            }
            if ($actionid && !empty($userIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->User->updateAll(array(
                        'User.is_active' => 0
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked users has been inactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->User->updateAll(array(
                        'User.is_active' => 1
                    ) , array(
                        'User.id' => $userIds
                    ));
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked users has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($userIds as $key => $user_id) {
                        $this->_sendAdminActionMail($user_id, 'Admin User Delete');
                    }
                    $this->User->deleteAll(array(
                        'User.id' => $userIds
                    ));
                    $this->Session->setFlash(__l('Checked users has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Export) {
                    $user_ids = implode(',', $userIds);
                    $hash = $this->User->getUserIdHash($user_ids);
                    $_SESSION['user_export'][$hash] = $userIds;
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'export',
                        'ext' => 'csv',
                        $hash,
                        'admin' => true
                    ));
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function _sendAdminActionMail($user_id, $email_template)
    {
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 1
        ));
        $email = $this->EmailTemplate->selectTemplate($email_template);
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
            '##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add'
			), true),
			'##SITE_LOGO##' => Router::url(array(
				'controller' => 'img',
				'action' => 'logo.png',
				'admin' => false
            ) , true)
		);
        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
        $this->Email->to = $this->User->formatToAddress($user);
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }
    public function admin_stats()
    {
        $this->pageTitle = __l('Site Stats');
        $this->loadModel('User');
        $this->loadModel('Property');
        $this->loadModel('PropertyFeedback');
        $this->loadModel('PropertyFlag');
        $this->loadModel('PropertyView');
        $this->loadModel('PropertyUser');
        $this->loadModel('PropertyFavorite');
        $this->loadModel('Request');
        $this->loadModel('RequestFavorite');
        $this->loadModel('RequestView');
        $this->loadModel('RequestFlag');
        $this->loadModel('Contact');
        $this->loadModel('UserLogin');
        $this->loadModel('Transaction');
        $this->loadModel('UserPaypalConnection');
        $this->loadModel('PropertyUserDispute');
        $conditions = array();
        $periods = array(
            'day' => array(
                'display' => __l('Today') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 0,
                )
            ) ,
            'week' => array(
                'display' => __l('This week') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 7,
                )
            ) ,
            'month' => array(
                'display' => __l('This month') ,
                'conditions' => array(
                    'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 30,
                )
            ) ,
            'total' => array(
                'display' => __l('Total') ,
                'conditions' => array()
            )
        );
        $transaction_colspan = 9;
        $transaction_cleared_colspan = 4;
        if (Configure::read('property.is_property_verification_enabled')) {
            $transaction_colspan = 10;
            $transaction_cleared_colspan = 5;
        }
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Transactions') . ' (' . Configure::read('site.currency') . ')',
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index'
                ) ,
                'colspan' => $transaction_colspan
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Cleared') ,
                'isNeedLoop' => false,
                'alias' => 'PropertyUser',
                'colspan' => $transaction_cleared_colspan
            )
        );
        $models[] = array(
            'RevenueReceived' => array(
                'display' => __l('Revenue from traveler commission') ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'traveler_cleared'
                ) ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => array(
                        ConstPropertyUserStatus::Confirmed,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::Arrived,
                        ConstPropertyUserStatus::WaitingforReview,
                        ConstPropertyUserStatus::PaymentCleared,
                        ConstPropertyUserStatus::Completed,
                    ) ,
                ) ,
                'alias' => 'ClearedRevenueAmountRecieved',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-cleared'
            )
        );
        // @todo "Auto review" add condition CompletedAndClosedByAdmin
        $models[] = array(
            'RevenueCommission' => array(
                'display' => __l('Revenue from host commission') ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'host_cleared'
                ) ,
                'conditions' => array(
                    'PropertyUser.is_payment_cleared' => 1
                ) ,
                'alias' => 'ClearedRevenueCommissionAmount',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-cleared'
            )
        );
        $models[] = array(
            'ListingFee' => array(
                'display' => __l('Revenue from listing fee') ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'type' => 'listing_fee'
                ) ,
                'conditions' => array(
                    'Transaction.class' => 'Property',
                    'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyListingFee,
                ) ,
                'alias' => 'ListingFee',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-cleared'
            )
        );
        if (Configure::read('property.is_property_verification_enabled')) {
            $models[] = array(
                'VerifyFee' => array(
                    'display' => __l('Revenue from verify fee') ,
                    'link' => array(
                        'controller' => 'properties',
                        'action' => 'index',
                        'type' => 'verify_fee'
                    ) ,
                    'conditions' => array(
                        'Transaction.class' => 'Property',
                        'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyVerifyFee,
                    ) ,
                    'alias' => 'VerifyFee',
                    'type' => 'cCurrency',
                    'isSub' => 'Revenue',
                    'class' => 'highlight-cleared'
                )
            );
        }
        $models[] = array(
            'TotalRevenue' => array(
                'display' => __l('Total Revenue') ,
                'link' => array() ,
                'conditions' => array() ,
                'alias' => 'TotalRevenue',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-cleared'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Pipeline') ,
                'isNeedLoop' => false,
                'alias' => 'PropertyUsers',
                'colspan' => 2
            )
        );
        $models[] = array(
            'RevenueReceived' => array(
                'display' => __l('Revenue from traveler commission') ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'traveler_pipeline'
                ) ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance,
                ) ,
                'alias' => 'PipelineRevenueAmountRecieved',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-pipeline'
            )
        );
        $models[] = array(
            'RevenueCommission' => array(
                'display' => __l('Revenue from host commission') ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'host_pipeline'
                ) ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => array(
                        ConstPropertyUserStatus::Confirmed,
                        ConstPropertyUserStatus::Arrived,
                        ConstPropertyUserStatus::WaitingforReview,
                    ) ,
                    'PropertyUser.is_payment_cleared' => 0
                ) ,
                'alias' => 'PipelineRevenueCommissionAmount',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-pipeline'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Lost') ,
                'isNeedLoop' => false,
                'alias' => 'PropertyUser',
                'colspan' => 2
            )
        );
        $models[] = array(
            'RevenueCommission' => array(
                'display' => __l('Revenue from host commission') ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'host_lost'
                ) ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => array(
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::Expired,
                        ConstPropertyUserStatus::CanceledByAdmin,
                    )
                ) ,
                'alias' => 'LostRevenueCommissionAmount',
                'type' => 'cCurrency',
                'isSub' => 'Revenue',
                'class' => 'highlight-lost'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index'
                ) ,
                'colspan' => 15
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Signups') ,
                'isNeedLoop' => false,
                'alias' => 'Users',
                'colspan' => 7
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Active Users') ,
                'conditions' => array(
                    'User.is_active' > 1
                ) ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                ) ,
                'alias' => 'UserActive',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Facebook Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Facebook
                ) ,
                'conditions' => array(
                    'User.fb_user_id !=' => 0,
                ) ,
                'alias' => 'UserFacebook',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Twitter Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Twitter
                ) ,
                'conditions' => array(
                    'User.twitter_user_id !=' => 0,
                ) ,
                'alias' => 'UserTwitter',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('OpenID Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::OpenID
                ) ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                ) ,
                'alias' => 'UserOpendId',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Gmail Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Gmail
                ) ,
                'conditions' => array(
                    'User.is_gmail_register' => 1,
                ) ,
                'alias' => 'UserGmail',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('Yahoo Users') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Yahoo
                ) ,
                'conditions' => array(
                    'User.is_yahoo_register' => 1,
                ) ,
                'alias' => 'UserYahoo',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'User' => array(
                'display' => __l('All') ,
                'link' => array(
                    'controller' => 'users',
                    'action' => 'index',
                ) ,
                'alias' => 'UserAll',
                'isSub' => 'User'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Logins') ,
                'isNeedLoop' => false,
                'alias' => 'Users',
                'colspan' => 7
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Normal Users') ,
                'conditions' => array(
                    'User.fb_user_id' => 0,
                    'User.twitter_user_id' => 0,
                    'User.is_openid_register' => 0,
                ) ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Normal
                ) ,
                'alias' => 'UserLoginNormal',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Facebook Users') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Facebook
                ) ,
                'conditions' => array(
                    'User.fb_user_id !=' => 0,
                ) ,
                'alias' => 'UserLoginFacebook',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Twitter Users') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Twitter
                ) ,
                'conditions' => array(
                    'User.twitter_user_id !=' => 0,
                ) ,
                'alias' => 'UserLoginTwitter',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('OpenID Users') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::OpenID
                ) ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                ) ,
                'alias' => 'UserLoginOpendId',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Gmail Users') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Gmail
                ) ,
                'conditions' => array(
                    'User.is_gmail_register' => 1,
                ) ,
                'alias' => 'UserLoginGmail',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('Yahoo Users') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Yahoo
                ) ,
                'conditions' => array(
                    'User.is_yahoo_register' => 1,
                ) ,
                'alias' => 'UserLoginYahoo',
                'isSub' => 'UserLogin'
            )
        );
        $models[] = array(
            'UserLogin' => array(
                'display' => __l('All') ,
                'link' => array(
                    'controller' => 'user_logins',
                    'action' => 'index',
                ) ,
                'alias' => 'UserLoginAll',
                'isSub' => 'UserLogin'
            )
        );
        $properties_colspan = 16;
        $properties_inner_colspan = 4;
        if (Configure::read('property.is_property_verification_enabled')) {
            $properties_colspan = 17;
            $properties_inner_colspan = 5;
        }
        $models[] = array(
            'Property' => array(
                'display' => __l('Properties') ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index'
                ) ,
                'colspan' => $properties_colspan
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Properties') ,
                'isNeedLoop' => false,
                'alias' => 'properties',
                'colspan' => $properties_inner_colspan
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Waiting for approval') ,
                'conditions' => array(
                    'Property.is_approved' => 1
                ) ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Disapproved
                ) ,
                'alias' => 'PropertyApproved',
                'isSub' => 'Property',
                'class' => 'highlight-lost'
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Active') ,
                'conditions' => array(
                    'Property.is_active' => 1
                ) ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Active
                ) ,
                'alias' => 'PropertyActive',
                'isSub' => 'Property'
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Inactive') ,
                'conditions' => array(
                    'Property.is_active' => 0
                ) ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Inactive
                ) ,
                'alias' => 'PropertyInActive',
                'isSub' => 'Property'
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Imported from AirBnB') ,
                'conditions' => array(
                    'Property.is_imported_from_airbnb' => 1
                ) ,
                'link' => array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Imported
                ) ,
                'alias' => 'PropertyImported',
                'isSub' => 'Property'
            )
        );
        if (Configure::read('property.is_property_verification_enabled')) {
            $models[] = array(
                'Property' => array(
                    'display' => __l('Waiting for verification review') ,
                    'conditions' => array(
                        'Property.is_verified' => 2
                    ) ,
                    'link' => array(
                        'controller' => 'properties',
                        'action' => 'index',
                        'filter_id' => ConstMoreAction::WaitingForVerification
                    ) ,
                    'alias' => 'PropertyVerification',
                    'isSub' => 'Property',
                    'class' => 'highlight-lost'
                )
            );
        }
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Booking') ,
                'isNeedLoop' => false,
                'alias' => 'PropertyUser',
                'colspan' => 7
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Waiting for confirm') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::WaitingforAcceptance
                ) ,
                'alias' => 'WaitingForConfirm',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Confirmed') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Confirmed
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::Confirmed
                ) ,
                'alias' => 'Confirmed',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Canceled') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Canceled
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::Canceled
                ) ,
                'alias' => 'Canceled',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Rejected') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Rejected
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::Rejected
                ) ,
                'alias' => 'Rejected',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Expired') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Expired
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::Expired
                ) ,
                'alias' => 'Expired',
                'isSub' => 'PropertyUser'
            )
        );
        // @todo "Auto review" add condition CompletedAndClosedByAdmin
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Completed') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Completed
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::Completed
                ) ,
                'alias' => 'Completed',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyUser' => array(
                'display' => __l('Waiting for review') ,
                'conditions' => array(
                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforReview
                ) ,
                'link' => array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'filter_id' => ConstPropertyUserStatus::WaitingforReview
                ) ,
                'alias' => 'review',
                'isSub' => 'PropertyUser'
            )
        );
        $models[] = array(
            'PropertyFeedback' => array(
                'display' => __l('Feedbacks') ,
                'link' => array(
                    'controller' => 'property_feedbacks',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'PropertyFeedback' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'property_feedbacks',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'PropertyFeedback',
                'isSub' => 'PropertyFeedback'
            )
        );
        $models[] = array(
            'PropertyFlag' => array(
                'display' => __l('Flags') ,
                'link' => array(
                    'controller' => 'property_flags',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'PropertyFlag' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'property_flags',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'PropertyFlag',
                'isSub' => 'PropertyFlag',
                'class' => 'highlight-flagged'
            )
        );
        $models[] = array(
            'PropertyView' => array(
                'display' => __l('Views') ,
                'link' => array(
                    'controller' => 'property_views',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'PropertyView' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'property_views',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'PropertyView',
                'isSub' => 'PropertyView'
            )
        );
        $models[] = array(
            'PropertyFavorite' => array(
                'display' => __l('Favorites') ,
                'link' => array(
                    'controller' => 'property_favorites',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'PropertyFavorite' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'property_favorites',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'PropertyFavorite',
                'isSub' => 'PropertyFavorite'
            )
        );
        $models[] = array(
            'Property' => array(
                'display' => __l('Requests') ,
                'link' => array(
                    'controller' => 'Requests',
                    'action' => 'index'
                ) ,
                'colspan' => 6
            )
        );
        $models[] = array(
            'Request' => array(
                'display' => __l('Requests') ,
                'isNeedLoop' => false,
                'alias' => 'requests',
                'colspan' => 2
            )
        );
        $models[] = array(
            'Request' => array(
                'display' => __l('Active') ,
                'conditions' => array(
                    'Request.is_active' => 1
                ) ,
                'link' => array(
                    'controller' => 'requests',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Active,
                ) ,
                'alias' => 'RequestActive',
                'isSub' => 'Request'
            )
        );
        $models[] = array(
            'Request' => array(
                'display' => __l('Inactive') ,
                'conditions' => array(
                    'Request.is_active' => 0
                ) ,
                'link' => array(
                    'controller' => 'requests',
                    'action' => 'index',
                    'filter_id' => ConstMoreAction::Inactive,
                ) ,
                'alias' => 'RequestInActive',
                'isSub' => 'Request'
            )
        );
        $models[] = array(
            'RequestFlag' => array(
                'display' => __l('Flags') ,
                'link' => array(
                    'controller' => 'request_flags',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'RequestFlag' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'request_flags',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'RequestFlag',
                'isSub' => 'RequestFlag',
                'class' => 'highlight-flagged'
            )
        );
        $models[] = array(
            'RequestView' => array(
                'display' => __l('Views') ,
                'link' => array(
                    'controller' => 'request_views',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'RequestView' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'request_views',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'RequestView',
                'isSub' => 'RequestView'
            )
        );
        $models[] = array(
            'RequestFavorite' => array(
                'display' => __l('Favorites') ,
                'link' => array(
                    'controller' => 'request_favorites',
                    'action' => 'index'
                ) ,
                'colspan' => 1
            )
        );
        $models[] = array(
            'RequestFavorite' => array(
                'display' => '',
                'link' => array(
                    'controller' => 'request_favorites',
                    'action' => 'index',
                ) ,
                'conditions' => $conditions,
                'alias' => 'RequestFavorite',
                'isSub' => 'RequestFavorite'
            )
        );
        $models[] = array(
            'UserPaypalConnection' => array(
                'display' => __l('PayPal Connections') ,
                'link' => array(
                    'controller' => 'user_paypal_connections',
                    'action' => 'index'
                ) ,
                'colspan' => 2
            )
        );
        //dummy array
        $models[] = array(
            'UserPaypalConnection' => array(
                'display' => '',
                'isNeedLoop' => false,
                'alias' => 'UserPaypalConnection',
                'colspan' => 1
            )
        );
        $models[] = array(
            'UserPaypalConnection' => array(
                'display' => __l('All') ,
                'link' => array(
                    'controller' => 'user_paypal_connections',
                    'action' => 'index'
                ) ,
                'alias' => 'UserPaypalConnectionAll',
                'isSub' => 'UserPaypalConnection'
            )
        );
        $disputeStatus = $this->PropertyUserDispute->DisputeStatus->find('list');
        $disputeStatus_count = count($disputeStatus);
        $models[] = array(
            'PropertyUserDispute' => array(
                'display' => __l('Property Booking Disputes') ,
                'link' => array(
                    'controller' => 'property_user_disputes',
                    'action' => 'index'
                ) ,
                'colspan' => $disputeStatus_count+2
            )
        );
        $models[] = array(
            'PropertyUserDispute' => array(
                'display' => '',
                'isNeedLoop' => false,
                'alias' => 'PropertyUserDispute',
                'colspan' => $disputeStatus_count+1
            )
        );
        foreach($disputeStatus as $id => $val) {
            $models[] = array(
                'PropertyUserDispute' => array(
                    'display' => $val,
                    'conditions' => array(
                        'dispute_status_id' => $id
                    ) ,
                    'link' => array(
                        'controller' => 'property_user_disputes',
                        'action' => 'index',
                        'filter_id' => $id
                    ) ,
                    'alias' => Inflector::camelize($val . 'PropertyUserDispute') ,
                    'isSub' => 'PropertyUserDisputes',
                    'class' => ($id == 1 || $id == 3) ? 'highlight-lost' : ''
                ) ,
            );
        }
        $models[] = array(
            'PropertyUserDispute' => array(
                'display' => __l('All') ,
                'conditions' => array() ,
                'link' => array(
                    'controller' => 'property_user_disputes',
                    'action' => 'index',
                ) ,
                'alias' => 'TotalPropertyUserDispute',
                'isSub' => 'PropertyUserDisputes'
            ) ,
        );
        //recently registered users
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.username',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        //recently logged in users
        $loggedUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'DISTINCT User.username',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        //online users
        $onlineUsers = $this->User->CkSession->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                )
            ) ,
            'fields' => array(
                'DISTINCT(CkSession.user_id)',
            ) ,
            'recursive' => 0,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        foreach($models as $unique_model) {
            foreach($unique_model as $model => $fields) {
                foreach($periods as $key => $period) {
                    $conditions = $period['conditions'];
                    if (!empty($fields['conditions'])) {
                        $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                    }
                    $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                    if ($model == 'RevenueReceived') {
                        $RevenueRecieved = $this->PropertyUser->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(PropertyUser.traveler_service_amount) as traveler_service_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $this->set($aliasName . $key, $RevenueRecieved['0']['traveler_service_amount']);
                    } else if ($model == 'RevenueCommission') {
                        $RevenueCommission = $this->PropertyUser->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(PropertyUser.host_service_amount) as host_service_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $this->set($aliasName . $key, $RevenueCommission['0']['host_service_amount']);
                    } else if ($model == 'ListingFee') {
                        $RevenueCommission = $this->Transaction->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(Transaction.amount) as fee_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $PaidAmount = $RevenueCommission['0']['fee_amount'];
                        $this->set($aliasName . $key, $PaidAmount);
                    } else if ($model == 'VerifyFee') {
                        $RevenueCommission = $this->Transaction->find('first', array(
                            'conditions' => $conditions,
                            'fields' => array(
                                'SUM(Transaction.amount) as amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $PaidAmount = $RevenueCommission['0']['amount'];
                        $this->set($aliasName . $key, $PaidAmount);
                    } elseif ($model == 'TotalRevenue') {
                        $travelerconditions = array(
                            'PropertyUser.property_user_status_id !=' => ConstPropertyUserStatus::PaymentPending,
                        );
                        $travelerconditions = array_merge($travelerconditions, $conditions);
                        // @todo "Auto review" add condition CompletedAndClosedByAdmin
                        $hostconditions = array(
                            'or' => array(
                                array(
                                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Completed,
                                ) ,
                                array(
                                    'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentCleared,
                                ) ,
                            )
                        );
                        $hostconditions = array_merge($hostconditions, $conditions);
                        $listingconditions = array(
                            'Transaction.class' => 'Property',
                            'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyListingFee,
                        );
                        $listingconditions = array_merge($listingconditions, $conditions);
                        $verifyconditions = array(
                            'Transaction.class' => 'Property',
                            'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyVerifyFee,
                        );
                        $verifyconditions = array_merge($verifyconditions, $conditions);
                        $TravelerrevenueCommission = $this->PropertyUser->find('first', array(
                            'conditions' => $travelerconditions,
                            'fields' => array(
                                'SUM(PropertyUser.traveler_service_amount) as traveler_service_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $RevenueCommission = $this->PropertyUser->find('first', array(
                            'conditions' => $hostconditions,
                            'fields' => array(
                                'SUM(PropertyUser.host_service_amount) as host_service_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $projectRevenueCommission = $this->Transaction->find('first', array(
                            'conditions' => $listingconditions,
                            'fields' => array(
                                'SUM(Transaction.amount) as fee_amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $userSignupCommission = $this->Transaction->find('first', array(
                            'conditions' => $verifyconditions,
                            'fields' => array(
                                'SUM(Transaction.amount) as amount'
                            ) ,
                            'recursive' => -1
                        ));
                        $toalRevenueAmount = $projectRevenueCommission['0']['fee_amount']+$TravelerrevenueCommission['0']['traveler_service_amount']+$RevenueCommission['0']['host_service_amount']+$userSignupCommission['0']['amount'];
                        $this->set($aliasName . $key, $toalRevenueAmount);
                    } else {
                        $new_periods = $period;
                        foreach($new_periods['conditions'] as $p_key => $p_value) {
                            unset($new_periods['conditions'][$p_key]);
                            $new_periods['conditions'][str_replace('created', $model . '.created', $p_key) ] = $p_value;
                        }
                        $conditions = $new_periods['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($new_periods['conditions'], $fields['conditions']);
                        }
                        $this->set($aliasName . $key, $this->{$model}->find('count', array(
                            'conditions' => $conditions,
                        )));
                    }
                }
            }
        }
        // Cache file read
        $error_log_path = APP . '/tmp/logs/error.log';
        $error_log = $debug_log = '';
        if (file_exists($error_log_path)) {
            $handle = fopen($error_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $error_log = fread($handle, 10240);
            fclose($handle);
        }
        $debug_log_path = APP . '/tmp/logs/debug.log';
        if (file_exists($debug_log_path)) {
            $handle = fopen($debug_log_path, "r");
            fseek($handle, -10240, SEEK_END);
            $debug_log = fread($handle, 10240);
            fclose($handle);
        }
        $this->set('error_log', $error_log);
        $this->set('debug_log', $debug_log);
        $this->set('tmpCacheFileSize', bytes_to_higher(dskspace(TMP . 'cache')));
        $this->set('tmpLogsFileSize', bytes_to_higher(dskspace(TMP . 'logs')));
        $this->set(compact('loggedUsers', 'recentUsers', 'onlineUsers', 'periods', 'models'));
    }
    public function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    public function admin_send_mail()
    {
        $this->pageTitle = __l('Email to users');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $conditions = $emails = array();
                $notSendCount = $sendCount = 0;
                if (!empty($this->request->data['User']['send_to'])) {
                    $sendTo = explode(',', $this->request->data['User']['send_to']);
                    foreach($sendTo as $email) {
                        $email = trim($email);
                        if (!empty($email)) {
                            if ($this->User->find('count', array(
                                'conditions' => array(
                                    'User.email' => $email
                                )
                            ))) {
                                $emails[] = $email;
                                $sendCount++;
                            } else {
                                $notSendCount++;
                            }
                        }
                    }
                }
                if (!empty($this->request->data['User']['bulk_mail_option_id'])) {
                    if ($this->request->data['User']['bulk_mail_option_id'] == 2) {
                        $conditions['User.is_active'] = 0;
                    }
                    if ($this->request->data['User']['bulk_mail_option_id'] == 3) {
                        $conditions['User.is_active'] = 1;
                    }
                    // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
                    $users = $this->User->find('all', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($users)) {
                        $sendCount++;
                        foreach($users as $user) {
                            $emails[] = $user['User']['email'];
                        }
                    }
                }
                $this->request->data['User']['message'].= "\n\n";
                $this->request->data['User']['message'].= Configure::read('site.name') . "\n";
                $this->request->data['User']['message'].= Router::url('/', true);
                if (!empty($emails)) {
                    foreach($emails as $email) {
                        if (!empty($email)) {
                            $this->Email->from = Configure::read('site.from_email');
                            $this->Email->replyTo = Configure::read('site.reply_to_email');
                            $this->Email->to = trim($email);
                            $this->Email->subject = $this->request->data['User']['subject'];
                            $this->Email->send($this->request->data['User']['message']);
                        }
                    }
                }
                if ($sendCount && !$notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully') , 'default', null, 'success');
                    if (!empty($this->request->data['Contact']['id'])) {
                        $this->User->Contact->updateAll(array(
                            'Contact.is_replied' => 1
                        ) , array(
                            'Contact.id' => $this->request->data['Contact']['id']
                        ));
                        $this->redirect(array(
                            'controller' => 'contacts',
                            'action' => 'index'
                        ));
                    }
                } elseif ($sendCount && $notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully. Some emails are not sent') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('No email send') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Email couldn\'t be sent! Enter all required fields') , 'default', null, 'error');
                if (!empty($this->request->data['Contact']['id'])) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'send_mail',
                        'contact' => $this->request->data['Contact']['id']
                    ));
                }
            }
        }
        // Just to do the admin conatact us repay mangement
        if (!empty($this->request->params['named']['contact'])) {
            $contact_deatil = $this->User->Contact->find('first', array(
                'conditions' => array(
                    'Contact.id' => $this->request->params['named']['contact'],
                ) ,
                'contain' => array(
                    'ContactType'
                ) ,
                'recursive' => 0
            ));
            if (!empty($contact_deatil['Contact']['subject'])) {
                $subject = $contact_deatil['Contact']['subject'];
            } else {
                $subject = $contact_deatil['ContactType']['name'];
            }
            $this->pageTitle = __l('Contact us - Reply');
            $this->request->data['Contact']['id'] = $this->request->params['named']['contact'];
            $this->request->data['User']['subject'] = __l('Re:') . $subject;
            $this->request->data['User']['message'] = "\n\n\n";
            $this->request->data['User']['message'].= '------------------------------';
            $this->request->data['User']['message'].= "\n" . $contact_deatil['Contact']['message'];
            $this->request->data['User']['send_to'] = $contact_deatil['Contact']['email'];
        }
        $bulkMailOptions = $this->User->bulkMailOptions;
        $this->set(compact('bulkMailOptions'));
    }
    public function admin_login()
    {
        $this->setAction('login');
    }
    public function admin_logout()
    {
        $this->setAction('logout');
    }
    public function admin_export($hash = null)
    {
        $conditions = array();
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        Configure::write('debug', 0);
        if (!empty($users)) {
            foreach($users as $user) {
                $data[]['User'] = array(
                    'Username' => $user['User']['username'],
                    'Email' => $user['User']['email'],
                    'Available Wallet Amount' => $user['User']['available_wallet_amount'],
                    'Property Count' => $user['User']['property_count'],
                    'Total Bookings as Traveler' => $user['User']['travel_total_booked_count'],
                    'Site Revenue' => $user['User']['travel_total_site_revenue'] + $user['User']['host_total_site_revenue'],
                    'Login count' => $user['User']['user_login_count'],
                );
            }
        }
        $this->set('data', $data);
    }
    public function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    public function admin_clear_cache()
    {
        App::import('Folder');
        $folder = new Folder();
        $folder->delete(CACHE . DS . 'models');
        $folder->delete(CACHE . DS . 'persistent');
        $folder->delete(CACHE . DS . 'views');
        $this->Session->setFlash(__l('Cache Files has been cleared') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'admin_stats'
        ));
    }
    public function admin_diagnostics()
    {
        $this->pageTitle = __l('Diagnostics');
		$this->set('pageTitle', $this->pageTitle);
    }
    public function admin_recent_users()
    {
        //recently registered users
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.user_type_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        $this->set(compact('recentUsers'));
    }
    public function admin_online_users()
    {
        //online users
        $onlineUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.user_type_id != ' => ConstUserTypes::Admin
            ) ,
            'contain' => array(
                'CkSession' => array(
                    'fields' => array(
                        'CkSession.user_id'
                    )
                )
            ) ,
            'fields' => array(
                'DISTINCT User.username',
                'User.user_type_id',
                'User.id',
            ) ,
            'recursive' => 1,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        $this->set(compact('onlineUsers'));
    }
}
?>