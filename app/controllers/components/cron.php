<?php
class CronComponent extends Component
{
    var $controller;
    public function main()
    {
		$this->auto_refund_security_deposit();
        $this->update_for_checkin();
        $this->update_for_checkout();
        $this->update_cleared();
		// @todo "Auto review"
        $this->auto_expire();
		$this->request_expire();
		// city count update for properties
        App::import('Model', 'Property');
        $this->Property = new Property();
        $this->Property->_updateCityPropertyCount();
        // city count update for requests
        App::import('Model', 'Request');
        $this->Request = new Request();
        $this->Request->_updateCityRequestCount();
		if (Configure::read('affiliate.is_enabled')) {
	        App::import('Model', 'Affiliate');
    	    $this->Affiliate = new Affiliate();
			$this->Affiliate->update_affiliate_status();
		}
    }
	public function currency_conversion($is_update = 0)
    {
		if (!empty($is_update)) {
			App::import('Model', 'Currency');
			$this->Currency = new Currency();	
			$this->Currency->rate_conversion();		
		}
	}
    public function clear_permanent_cache()
    {
        $cacheDir = array(
            CACHE . DS . 'views' . DS . 'user',
            CACHE . DS . 'views' . DS . 'public'
        );
        foreach($cacheDir as $dir) {
            $r = array();
            $dh = @opendir($dir);
            if ($dh) {
                while (($fname = readdir($dh)) !== false) {
                    if ($fname != '.' && $fname != '..') {
                        $r[$fname] = fileatime($dir . DS . $fname);
                    }
                }
                closedir($dh);
                if (!empty($r)) {
                    asort($r);
                    $r = array_keys($r);
                    if (sizeof($r) >= 100) {
                        for ($i = 100; $i < sizeof($r); $i++) {
                            @unlink($dir . DS . $r[$i]);
                        }
                    }
                }
            }
        }
        @unlink(APP . WEBROOT_DIR . DS . 'index.html');
    }
    public function crushPng($dir, $dir_count)
    {
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    ++$dir_count;
                    $this->crushPng($path, $dir_count);
                }
                if (is_file($path)) {
                    $info = pathinfo($path);
                    if (!empty($info['extension']) && $info['extension'] == 'png') {
                        exec('pngcrush -reduce -brute ' . $path . ' ' . $path);
                    }
                }
            }
        }
        closedir($handle);
    }
    // On Checkin' Date, The status will be changed to "Arrived" //
    public function update_for_checkin($conditions = array())
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $propertyUsers = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                ) ,
                'PropertyUser.is_auto_checkin' => 0,
            ) ,
            'fields' => array(
                'PropertyUser.id',
                'PropertyUser.created',
                'PropertyUser.user_id',
                'PropertyUser.property_id',
                'PropertyUser.property_user_status_id',
                'PropertyUser.price',
                'PropertyUser.payment_gateway_id',
                'PropertyUser.traveler_service_amount',
                'PropertyUser.message',
                'PropertyUser.accepted_date',
                'PropertyUser.checkin',
                'PropertyUser.checkout',
                'PropertyUser.actual_checkin_date',
                'PropertyUser.actual_checkout_date',
                'PropertyUser.guests',
                'DATEDIFF(CURDATE(), PropertyUser.checkin) as expected_date_diff'
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($propertyUsers as $propertyUser) {
            if ($propertyUser['0']['expected_date_diff'] != '') {
                if ($propertyUser['0']['expected_date_diff'] >= 0) {
                    if (($propertyUser['Property']['checkin'] == '00:00:00') || ($propertyUser['Property']['checkin'] <= date('H:i:s'))) {
                        $property_user['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                        $property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Arrived;
                        $property_user['PropertyUser']['actual_checkin_date'] = date('Y-m-d H:i:s');
                        $property_user['PropertyUser']['is_auto_checkin'] = 1;
                        $property_user['PropertyUser']['auto_checkin_date'] = date('Y-m-d H:i:s');
                        $this->PropertyUser->save($property_user);
                        // Only if not already sent //
                        if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::Arrived) {
                            // Send Notification Message //
                            $users = array(
                                $propertyUser['Property']['User']['id'] => $propertyUser['Property']['User']['username'], // HOST
                                $propertyUser['User']['id'] => $propertyUser['User']['username'] // TRAVELER

                            );
                            $mail_template[$propertyUser['Property']['User']['id']] = 'Checkin host notification mail';
                            $mail_template[$propertyUser['User']['id']] = 'Checkin welcome mail';
                            foreach($users as $key => $value) {
                                unset($message);
                                unset($subject);
                                $template = $this->EmailTemplate->selectTemplate($mail_template[$key]);
                                $emailFindReplace = array(
                                    '##USERNAME##' => $value,
                                    '##PROPERTY##' => $propertyUser['Property']['title'],
                                    '##PROPERTY_NAME##' => $propertyUser['Property']['title'],
                                    '##TRAVELER##' => $propertyUser['User']['username'],
                                    '##MESSAGE##' => '',
                                    '##SITE_NAME##' => Configure::read('site.name'),
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
									'##SITE_LINK##' => Router::url('/', true) ,
                                );
                                $message = strtr($template['email_content'], $emailFindReplace);
                                $subject = strtr($template['subject'], $emailFindReplace);
                                $message_id = $this->PropertyUser->User->Message->sendNotifications($key, $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], ConstPropertyUserStatus::Arrived);
                                if (Configure::read('messages.is_send_email_on_new_message')) {
                                    $sender_emails = array(
                                        $propertyUser['Property']['User']['id'] => $propertyUser['Property']['User']['email'],
                                        $propertyUser['User']['id'] => $propertyUser['User']['email']
                                    );
                                    $content['message'] = 'Checkin date has arrived.';
                                    $content['subject'] = 'Checkin date has arrived.';
                                    $content['cache_site_name'] = $cache_site_name;
                                    if ($propertyUser['Property']['User']['id'] == $propertyUser['Property']['user_id']) {
                                        $notification_check = '0';
                                    }
                                    if ($propertyUser['PropertyUser']['user_id'] == $propertyUser['User']['id']) {
                                        $notification_check = '1';
                                    }
                                    if ($this->PropertyUser->_checkUserNotifications($key, ConstPropertyUserStatus::Arrived, $notification_check)) {
                                        $this->PropertyUser->_sendAlertOnNewMessage($sender_emails[$key], $content, $message_id, 'Booking Alert Mail');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    // After Traveler Arrival, and cleared date set by admin, the hosts will be given money, the status will be chagned to "PaymentCleared" //
    public function update_cleared($conditions = array())
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
		// @todo "Auto review" add condition CompletedAndClosedByAdmin
        $propertyUsers = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.is_under_dispute' => 0,
				'TO_DAYS(NOW()) - TO_DAYS(PropertyUser.checkin) >=' => Configure::read('property.days_after_amount_withdraw'),
				'PropertyUser.property_user_status_id'=>array(
							ConstPropertyUserStatus::Arrived,
							ConstPropertyUserStatus::Confirmed,
							ConstPropertyUserStatus::WaitingforReview,
							ConstPropertyUserStatus::Completed,
				),
				'PropertyUser.is_payment_cleared' => 0,
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.title',
                        'Property.user_id',
                        'Property.slug',
                        'Property.address',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_wallet_amount',
                        )
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_wallet_amount',
                    )
                ) ,
				'PropertyFeedback'
            ) ,
            'fields' => array(
                'PropertyUser.id',
                'PropertyUser.created',
                'PropertyUser.user_id',
                'PropertyUser.property_id',
                'PropertyUser.property_user_status_id',
                'PropertyUser.price',
                'PropertyUser.payment_gateway_id',
                'PropertyUser.traveler_service_amount',
                'PropertyUser.message',
                'PropertyUser.accepted_date',
                'PropertyUser.checkin',
                'PropertyUser.checkout',
                'PropertyUser.actual_checkin_date',
                'PropertyUser.actual_checkout_date',
                'PropertyUser.guests',
                'PropertyUser.host_service_amount',
                'PropertyUser.is_delayed_chained_payment',
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($propertyUsers as $propertyUser) {
			$this->PropertyUser->_clearAmount($propertyUser);
        }
    }
    public function update_for_checkout($conditions = array())
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $propertyUsers = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::PaymentCleared,
                    ConstPropertyUserStatus::WaitingforReview,
                ) ,
                'PropertyUser.is_under_dispute' => 0,
                'PropertyUser.is_auto_checkout' => 0,
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.title',
                        'Property.user_id',
                        'Property.slug',
                        'Property.checkin',
                        'Property.checkout',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_wallet_amount',
                        )
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_wallet_amount',
                    )
                ) ,
                'PropertyFeedback'
            ) ,
            'fields' => array(
                'PropertyUser.id',
                'PropertyUser.created',
                'PropertyUser.user_id',
                'PropertyUser.property_id',
                'PropertyUser.property_user_status_id',
                'PropertyUser.price',
                'PropertyUser.payment_gateway_id',
                'PropertyUser.traveler_service_amount',
                'PropertyUser.message',
                'PropertyUser.accepted_date',
                'PropertyUser.checkin',
                'PropertyUser.checkout',
                'PropertyUser.actual_checkin_date',
                'PropertyUser.actual_checkout_date',
                'PropertyUser.guests',
                'PropertyUser.host_service_amount',
                'PropertyUser.is_delayed_chained_payment',
                'DATEDIFF(now(), PropertyUser.actual_checkout_date) as expected_date_diff'
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($propertyUsers as $propertyUser) {
            if ($propertyUser['0']['expected_date_diff'] != '') {
                if ($propertyUser['0']['expected_date_diff'] >= 0) {
                    // If Host not cleared, we clear the amount and change to review status -> This case happens, if the checkin and out are same //
                    if (($propertyUser['Property']['checkout'] == '00:00:00') || ($propertyUser['Property']['checkout'] <= date('H:i:s'))) {
                        $property_user['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
						if (empty($propertyUser['PropertyFeedback'])) {
	                        $property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
						}
                        $property_user['PropertyUser']['actual_checkout_date'] = date('Y-m-d H:i:s');
                        $property_user['PropertyUser']['is_auto_checkout'] = 1;
                        $property_user['PropertyUser']['auto_checkout_date'] = date('Y-m-d H:i:s');
                        $this->PropertyUser->save($property_user);
                        // Only if not already sent //
                        if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::WaitingforReview) {
                            // Send Notification Message //
                            $user = $propertyUser['User']['id'];
                            $username = $propertyUser['User']['username'];
                            $template = $this->EmailTemplate->selectTemplate('Traveler review notification');
                            $emailFindReplace = array(
                                '##USERNAME##' => $username,
                                '##PROPERTY_NAME##' => "<a href=" . Router::url(array(
                                    'controller' => 'properties',
                                    'action' => 'view',
                                    $propertyUser['Property']['slug'],
                                    'admin' => false
                                ) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
                                '##ORDERNO##' => $propertyUser['PropertyUser']['id'],
                                '##REVIEW_URL##' => "<a href=" . Router::url(array(
                                    'controller' => 'property_feedbacks',
                                    'action' => 'add',
                                    'property_order_id' => $propertyUser['PropertyUser']['id'],
                                    'admin' => false
                                ) , true) . ">" . __l('review link') . "</a>",
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
								'##SITE_LINK##' => Router::url('/', true) ,
                            );
                            $message = strtr($template['email_content'], $emailFindReplace);
                            $subject = strtr($template['subject'], $emailFindReplace);
                            $message_id = $this->PropertyUser->User->Message->sendNotifications($user, $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 1, $propertyUser['Property']['id'], ConstPropertyUserStatus::WaitingforReview);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $sender_email = $propertyUser['User']['email'];
                                $content['subject'] = 'Your booking has been completed';
                                $content['message'] = 'Your booking has been completed';
                                $content['cache_site_name'] = $cache_site_name;
                                if (!empty($sender_email)) {
                                    if ($this->PropertyUser->_checkUserNotifications($user, ConstPropertyUserStatus::WaitingforReview, 0)) {
                                        $this->PropertyUser->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Booking Alert Mail');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function request_expire()
    {
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyInfo = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                'TO_DAYS(NOW()) - TO_DAYS(PropertyUser.checkout) >' => 0 ,
            ) ,
            'recursive' => -1,
        ));
        foreach($propertyInfo as $propertyUser) {
				// Update Property order Status //
				$property_user= array();
				$property_user['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
				$property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Expired;
				$this->PropertyUser->save($property_user,false);
        }
    }
    public function auto_expire()
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        $propertyInfo = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance,
                'TO_DAYS(NOW()) - TO_DAYS(PropertyUser.created) >=' => Configure::read('property.auto_expire') ,
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.title',
                        'Property.user_id',
                        'Property.slug',
                        'Property.address',
                        'Property.cancellation_policy_id',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_wallet_amount',
                        )
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_wallet_amount',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($propertyInfo as $propertyUser) {
			if (!empty($propertyUser['PropertyUser']['payment_gateway_id']) && $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && !empty($propertyUser['PropertyUser']['is_delayed_chained_payment'])) {
				$refund = $this->Payment->_refundProcessOrder($propertyUser['PropertyUser']['id']);
			}
			if (!empty($propertyUser['PropertyUser']['payment_gateway_id']) && $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
				$refund = $this->Payment->_voidProcessOrder($propertyUser['PropertyUser']['id']);
			}
			if (empty($refund['error'])) {
				$return_amount['traveler_balance'] = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'] + $propertyUser['PropertyUser']['security_deposit'];
				$return_amount['host_balance'] = $propertyUser['PropertyUser']['price'] - $propertyUser['PropertyUser']['host_service_amount'];
				$update_seller_balance = $propertyUser['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
				$update_buyer_balance = $propertyUser['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
				if (!empty($propertyUser['PropertyUser']['payment_gateway_id']) && (($propertyUser['PropertyUser']['payment_gateway_id'] != ConstPaymentGateways::PayPal && $propertyUser['PropertyUser']['payment_gateway_id'] != ConstPaymentGateways::AuthorizeNet) || ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && empty($propertyUser['PropertyUser']['is_delayed_chained_payment'])))) {
					// Update Buyer //
					$this->PropertyUser->User->updateAll(array(
						'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
					) , array(
						'User.id' => $propertyUser['User']['id']
					));
					// Update Seller //
					$this->PropertyUser->User->updateAll(array(
						'User.blocked_amount' =>  "'" . $update_seller_balance . "'"
					) , array(
						'User.id' => $propertyUser['Property']['User']['id']
					));
				}
				// Update Property order Status //
				$property_user['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
				$property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Expired;
				$this->PropertyUser->save($property_user);
				// Updating transaction again for buyer //
				$transaction['Transaction']['id'] = '';
				$transaction['Transaction']['user_id'] = $propertyUser['User']['id'];
				$transaction['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
				$transaction['Transaction']['class'] = 'PropertyUser';
				$transaction['Transaction']['amount'] = $return_amount['traveler_balance'];
				$transaction['Transaction']['description'] = "Booking has been expired";
				$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::RefundForExpiredProperty;
				$this->Transaction->save($transaction);
				// Updating transaction again for buyer //
				$transaction['Transaction']['id'] = '';
				$transaction['Transaction']['user_id'] = $propertyUser['Property']['User']['id'];
				$transaction['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
				$transaction['Transaction']['class'] = 'PropertyUser';
				$transaction['Transaction']['amount'] = $return_amount['host_balance'];
				$transaction['Transaction']['description'] = "Booking has been expired";
				$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostDeductedForExpiredProperty;
				$this->Transaction->save($transaction);
				// Send Notification Message //
				$users = array(
					$propertyUser['Property']['User']['id'] => $propertyUser['Property']['User']['username'], // SELLER
					$propertyUser['User']['id'] => $propertyUser['User']['username'] // BUYER

				);
				$mail_template = 'Auto expired notification';
				$days_check = Configure::read('property.auto_expire');
				$i=1;
				foreach($users as $key => $value) {
					unset($message);
					unset($subject);
					$template = $this->EmailTemplate->selectTemplate($mail_template);
					$emailFindReplace = array(
						'##USERNAME##' => $value,
						'##PROPERTY_NAME##' => "<a href=" . Router::url(array(
							'controller' => 'properties',
							'action' => 'view',
							$propertyUser['Property']['slug'],
							'admin' => false
						) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
						'##ORDERNO##' => $propertyUser['PropertyUser']['id'],
						'##EXPIRE_DATE##' => (empty($days_check) || ($days_check == '1')) ? $days_check . ' ' . __l('day') : $days_check . ' ' . __l('days') ,
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
						'##SITE_LINK##' => Router::url('/', true) ,
						'##SITE_NAME##' => Configure::read('site.name'),
					);
					$message = strtr($template['email_content'], $emailFindReplace);
					$subject = strtr($template['subject'], $emailFindReplace);
					$property_user_status = ($i==1) ? ConstPropertyUserStatus::Expired : ConstPropertyUserStatus::SenderNotification;
					$message_id = $this->PropertyUser->User->Message->sendNotifications($key, $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'],$property_user_status);
					if (Configure::read('messages.is_send_email_on_new_message')) {
						$sender_emails = array(
							$propertyUser['Property']['User']['id'] => $propertyUser['Property']['User']['email'],
							$propertyUser['User']['id'] => $propertyUser['User']['email']
						);
						$content['subject'] = 'Your booking has been auto expired';
						$content['message'] = 'Your booking has been auto expired';
						$content['cache_site_name'] = $cache_site_name;
						if ($propertyUser['Property']['User']['id'] == $propertyUser['Property']['user_id']) {
							$notification_check = '0';
						}
						if ($propertyUser['PropertyUser']['user_id'] == $propertyUser['User']['id']) {
							$notification_check = '1';
						}
						if ($this->PropertyUser->_checkUserNotifications($key, ConstPropertyUserStatus::Expired, $notification_check)) {
							$this->PropertyUser->_sendAlertOnNewMessage($sender_emails[$key], $content, $message_id, 'Booking Alert Mail');
						}
					}
					$i++;
				}
			}
        }
    }
	public function auto_refund_security_deposit()
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
		if(Configure::read('property.is_enable_security_deposit'))
		{
        $propertyInfo = $this->PropertyUser->find('all', array(
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::PaymentCleared,
					ConstPropertyUserStatus::Completed
				) ,
				'PropertyUser.is_under_dispute' => 0,
                'PropertyUser.security_deposit_status' => 0,
                'TO_DAYS(NOW()) - TO_DAYS(PropertyUser.checkout) >=' => Configure::read('property.auto_refund_security_deposit') ,
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.title',
                        'Property.user_id',
                        'Property.slug',
                        'Property.address',
                        'Property.cancellation_policy_id',
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.email',
                            'User.blocked_amount',
                            'User.cleared_amount',
                            'User.available_wallet_amount',
                        )
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.cleared_amount',
                        'User.available_wallet_amount',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
        foreach($propertyInfo as $propertyUser) {
			$update_traveler_balance = $propertyUser['User']['available_wallet_amount'] + $propertyUser['PropertyUser']['security_deposit']; // host security deposit amount
            // Change order status //
            if ($propertyUser['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
                $PropertyUserList['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                $PropertyUserList['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::RefundedToTraveler;
                $this->PropertyUser->save($PropertyUserList,false);
            }
            $this->PropertyUser->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_traveler_balance . "'"
            ) , array(
                'User.id' => $propertyUser['User']['id']
            )); 
            // Update Transactions //
            $transaction['Transaction']['user_id'] = $propertyUser['User']['id'];
            $transaction['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = $propertyUser['PropertyUser']['security_deposit'];
            $transaction['Transaction']['description'] = "Security Deposit - Amount Refunded";
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::RefundedToTraveler;
           $this->Transaction->save($transaction,false);

			 //notification
			 $mail_template = 'Auto refund notification';
			 $template = $this->EmailTemplate->selectTemplate($mail_template);
					$emailFindReplace = array(
						'##USERNAME##' => $propertyUser['User']['username'],
						'##PROPERTY_NAME##' => "<a href=" . Router::url(array(
							'controller' => 'properties',
							'action' => 'view',
							$propertyUser['Property']['slug'],
							'admin' => false
						) , true) . ">" . $propertyUser['Property']['title'] . "</a>",
						'##AMOUNT##' => Configure::read('site.currency'). $propertyUser['PropertyUser']['security_deposit'],
						'##SITE_NAME##' => Configure::read('site.name'),
						'##SITE_LINK##' => Router::url('/',true),
						'##ORDERNO##' => $propertyUser['PropertyUser']['id'],
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
					$message = strtr($template['email_content'], $emailFindReplace);
					$subject = strtr($template['subject'], $emailFindReplace);
					$key=0;
					$message_id = $this->PropertyUser->User->Message->sendNotifications($propertyUser['User']['id'], $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], ConstPropertyUserStatus::SecurityDepositRefund);
        }
	}
    }
}
?>