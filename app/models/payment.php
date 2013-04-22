<?php
class Payment extends AppModel
{
    var $useTable = false;
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'negotiation_discount' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and conditions')
            ) ,
        );
    }
	function CustomizePaymentPage($payKey)
	{
		$PaypalPlatform = $this->_getPaypalPlatformObject();
		$options['headerImageUrl'] = Router::url('/', true) . 'img/logo.png';
		$options['businessName'] = Configure::read('site.name');
		$PaypalPlatform->CallSetPaymentOptions($payKey, $options);
	}
    function getBalance() 
    {
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $resArray = $this->PaypalPlatform->CallGetBalance();
        $return = 0;
		if (!empty($resArray)) {
			$ack = strtoupper($resArray["ACK"]);
			if ($ack == "SUCCESS") {
				foreach($resArray as $k => $v) {
					if (strtoupper($v) == strtoupper(Configure::read('site.currency_code'))) {
						$pos = strpos($k, 'L_CURRENCYCODE');
					}
				}
				$return = $resArray['L_AMT' . $pos];
			}
		}
        return $return;
    }
    function processSendMoneyPayment($sendmoney_id)
    {
        $this->_saveIPNLog();
        App::import('Model', 'User');
        $this->User = new User();
        $sendMoney = $this->User->SendMoney->find('first', array(
            'conditions' => array(
                'SendMoney.id = ' => $sendmoney_id
            ) ,
            'recursive' => -1
        ));
        if (empty($sendMoney)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentDetails = $this->getPaymentDetails($sendMoney['SendMoney']['pay_key']);
        if ($paymentDetails['status'] == 'COMPLETED' && empty($sendMoney['SendMoney']['is_success'])) {
            $data['Transaction']['user_id'] = $sendMoney['SendMoney']['user_id'];
            $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
            $data['Transaction']['class'] = 'SendMoney';
            $data['Transaction']['amount'] = $sendMoney['SendMoney']['amount'];
            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::SendMoneyToUser;
            $transaction_id = $this->User->Transaction->log($data);
            $data['SendMoney']['id'] = $sendmoney_id;
            $data['SendMoney']['is_success'] = 1;
            $this->User->SendMoney->save($data['SendMoney'], false);
        }
        $this->_savePaidLog($sendmoney_id, $paymentDetails, 'SendMoney', 1);
    }
    function processPropertyPayment($property_id, $view)
    {
        $this->_saveIPNLog();
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Message');
        $this->Message = new Message();
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
            ) ,
            'contain' => array(
                'User',
            ) ,
            'recursive' => 1,
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentDetails = $this->getPaymentDetails($property['Property']['pay_key']);
        if ($view == 'listing_fee') {
            if ($paymentDetails['status'] == 'COMPLETED' && $property['Property']['is_paid'] == 0) {
                $data['Transaction']['foreign_id'] = $property['Property']['id'];
                $data['Transaction']['class'] = 'Property';
                $data['Transaction']['user_id'] = $property['Property']['user_id'];
                $data['Transaction']['amount'] = $paymentDetails['paymentInfoList.paymentInfo(0).receiver.amount'];
                $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyListingFee;
                $host_username = $property['User']['username'];
                $host_email = $property['User']['email'];
                $host_id = $property['User']['id'];
                $this->Property->User->Transaction->create();
                if ($this->Property->User->Transaction->save($data)) {
                    if (Configure::read('property.is_auto_approve')) {
                        $mail_template = 'New Property Activated';
                        if (!empty($mail_template)) {
                            $template = $this->EmailTemplate->selectTemplate($mail_template);
                            $emailFindReplace = array(
                                '##USERNAME##' => $host_username,
                                '##PROPERTY_NAME##' => $property['Property']['title'],
                                '##PROPERTY_URL##' => Router::url(array(
                                    'controller' => 'properties',
                                    'action' => 'view',
                                    $property['Property']['slug'],
                                    'admin' => false,
                                ) , true) ,
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
                            $email_message = __l('Your property has been activated');
                            $message = strtr($template['email_content'], $emailFindReplace);
                            $subject = strtr($template['subject'], $emailFindReplace);
                            if (Configure::read('messages.is_send_internal_message') && Configure::read('property.is_auto_approve')) {
                                $message_id = $this->Message->sendNotifications($host_id, $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                                if (Configure::read('messages.is_send_email_on_new_message')) {
                                    $content['subject'] = $subject;
                                    $content['message'] = $message;
                                    if (!empty($host_email)) {
                                        $this->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                                    }
                                }
                            }
                        }
                    }
                    $_Data['Property']['id'] = $property['Property']['id'];
                    $_Data['Property']['is_paid'] = 1;
                    $_Data['Property']['is_active'] = 1;
                    $_Data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
                    $_Data['Property']['user_id'] = $property['Property']['user_id'];
                    $_Data['Property']['name'] = $property['Property']['title'];
                    $this->Property->save($_Data);
                }
            }
        } else if ($view == 'verify') {
            if ($paymentDetails['status'] == 'COMPLETED' && $property['Property']['is_verified'] === null) {
                $data['Transaction']['foreign_id'] = $property['Property']['id'];
                $data['Transaction']['class'] = 'Property';
                $data['Transaction']['user_id'] = $property['Property']['user_id'];
                $data['Transaction']['amount'] = $paymentDetails['paymentInfoList.paymentInfo(0).receiver.amount'];
                $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyVerifyFee;
                $this->Property->User->Transaction->create();
                if ($this->Property->User->Transaction->save($data)) {
                    $_Data['Property']['id'] = $property['Property']['id'];
                    $_Data['Property']['is_verified'] = 2; // waiting for confirmation
                    $_Data['Property']['user_id'] = $property['Property']['user_id'];
                    $_Data['Property']['name'] = $property['Property']['title'];
                    //$_Data['Property']['fee_amount'] = $data['Transaction']['amount'];
                    $this->Property->save($_Data);
                }
            }
        }
        $this->_savePaidLog($property_id, $paymentDetails, 'Property', 1);
    }
    function processUserSignupPayment($user_id)
    {
        $this->_saveIPNLog();
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $user_id,
            ) ,
            'recursive' => -1,
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentDetails = $this->getPaymentDetails($user['User']['pay_key']);
        if ((!empty($paymentDetails['status']) && $paymentDetails['status'] == 'COMPLETED') && $user['User']['is_paid'] == 0) {
            $data['Transaction']['foreign_id'] = $user['User']['id'];
            $data['Transaction']['class'] = 'User';
            $data['Transaction']['user_id'] = $user['User']['id'];
            $data['Transaction']['amount'] = $paymentDetails['paymentInfoList.paymentInfo(0).receiver.amount'];
            $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::SignupFee;
            $this->User->Transaction->create();
            if ($this->User->Transaction->save($data)) {
                $_Data['User']['id'] = $user['User']['id'];
                $_Data['User']['is_paid'] = 1; // waiting for confirmation
                $_Data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                //$_Data['Property']['fee_amount'] = $data['Transaction']['amount'];
                $this->User->save($_Data);
            }
        }
        $this->_savePaidLog($user_id, $paymentDetails, 'User', 1);
    }
    function payProperty($data)
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        $return = '';
        if (!empty($data['payment_type_id']) && $data['payment_type_id'] == ConstPaymentGateways::PayPal) {
            App::import('Vendor', 'adaptive_paypal/paypal_platform');
            $this->PaypalPlatform = new PaypalPlatform();
            $payment_gateway_id = ConstPaymentGateways::PayPal;
            $paymentGateway = $this->Property->User->Transaction->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => $payment_gateway_id,
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
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                    $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
            }
            $gateway_settings_options['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
            $this->PaypalPlatform->settings($gateway_settings_options);
            $Property_id = $data['property_id'];
            // Request specific required fields
            $actionType = "PAY";
            $cancelUrl = Router::url('/', true) . 'payments/cancel_propertypayment/' . $Property_id . '/' . $data['from'];
            $returnUrl = Router::url('/', true) . 'payments/success_propertypayment/' . $Property_id . '/' . $data['from'];
            $ipnNotificationUrl = Router::url('/', true) . 'payments/processpropertypayment/' . $Property_id . '/' . $data['from'];
            $currencyCode = Configure::read('site.currency_code');
            $receiverEmailArray = array(
                $gateway_settings_options['payee_account']
            );
            $receiverAmountArray = array(
                $data['amount']
            );
            $receiverPrimaryArray = array();
            $receiverInvoiceIdArray = array(
                md5('PropertyPay_' . date('YmdHis'))
            );
            $senderEmail = '';
            $feesPayer = 'EACHRECEIVER';
            if ($data['from'] == 'listing_fee') {
                if (Configure::read('property.listing_fee_payer') == ConstPaymentGatewayFee::Host) {
                    $feesPayer = 'SENDER';
                }
            } elseif ($data['from'] == 'verify') {
                if (Configure::read('property.verify_fee_payer') == ConstPaymentGatewayFee::Host) {
                    $feesPayer = 'SENDER';
                }
            }
            $memo = '';
            $pin = '';
            $preapprovalKey = '';
            if (!empty($data['user_paypal_connection_id'])) {
                $userPaypalConnection = $this->Property->User->UserPaypalConnection->find('first', array(
                    'conditions' => array(
                        'UserPaypalConnection.id' => $data['user_paypal_connection_id']
                    ) ,
                    'recursive' => -1
                ));
                $preapprovalKey = trim($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
                $senderEmail = trim($userPaypalConnection['UserPaypalConnection']['sender_email']);
                if ($data['from'] == 'listing_fee') {
                    $Propertydata['listing_user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                } elseif ($data['from'] == 'verify') {
                    $Propertydata['verify_user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                }
            }
            $reverseAllParallelPaymentsOnError = '';
            $trackingId = $this->PaypalPlatform->generateTrackingID();
            // Make the Pay API call
            $resArray = $this->PaypalPlatform->CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId);
            $ack = strtoupper($resArray["responseEnvelope.ack"]);
            $return['error'] = 0;
            if ($ack == "SUCCESS") {
                $Propertydata['id'] = $Property_id;
                $Propertydata['pay_key'] = $resArray["payKey"];
                $this->Property->Behaviors->detach('Logable');
                $this->Property->save($Propertydata, false);
				if ('' == $preapprovalKey) {
					$this->CustomizePaymentPage($resArray["payKey"]);
					$cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
					$embedded = false;
					if (Configure::read('paypal.is_embedded_payment_enabled')) {
						$embedded = true;
					}
					$this->PaypalPlatform->RedirectToPayPal($cmd, $embedded);
				} else {
					$payKey = urldecode($resArray["payKey"]);
					$paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
				}
            } else {
                $ErrorMsg = urldecode($resArray["error(0).message"]);
                $return['error_message'] = $ErrorMsg;
                $return['error'] = 1;
            }
        } elseif ($data['payment_type_id'] == ConstPaymentGateways::Wallet) {
            $buyer_info = $this->Property->User->find('first', array(
                'conditions' => array(
                    'User.id' => $_SESSION['Auth']['User']['id']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username',
                    'User.email',
                    'User.available_wallet_amount',
                ) ,
                'recursive' => -1
            ));
            // Updating buyer balance //
            $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-$data['amount'];
            $this->Property->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
            ) , array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ));
            $property = $this->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $data['property_id']
                ) ,
                'recursive' => -1
            ));
            if ($data['from'] == 'listing_fee') {
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                App::import('Model', 'Message');
                $this->Message = new Message();
                $data['Transaction']['foreign_id'] = $property['Property']['id'];
                $data['Transaction']['class'] = 'Property';
                $data['Transaction']['user_id'] = $property['Property']['user_id'];
                $data['Transaction']['amount'] = $data['amount'];
                $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyListingFee;
                $host_username = $buyer_info['User']['username'];
                $host_email = $buyer_info['User']['email'];
                $host_id = $buyer_info['User']['id'];
                $this->Property->User->Transaction->create();
                if ($this->Property->User->Transaction->save($data)) {
                    $mail_template = 'New Property Activated';
                    if (!empty($mail_template)) {
                        $template = $this->EmailTemplate->selectTemplate($mail_template);
                        $emailFindReplace = array(
                            '##USERNAME##' => $host_username,
                            '##PROPERTY_NAME##' => $property['Property']['title'],
                            '##PROPERTY_URL##' => Router::url(array(
                                'controller' => 'properties',
                                'action' => 'view',
                                $property['Property']['slug']
                            ) , true) ,
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
                        $email_message = __l('Your property has been activated');
                        $message = strtr($template['email_content'], $emailFindReplace);
                        $subject = strtr($template['subject'], $emailFindReplace);
                        if (Configure::read('messages.is_send_internal_message') && Configure::read('property.is_auto_approve')) {
                            $message_id = $this->Message->sendNotifications($host_id, $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $content['subject'] = $subject;
                                $content['message'] = $message;
                                if (!empty($host_email)) {
                                    $this->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                                }
                            }
                        }
                    }
                    $_Data['Property']['id'] = $property['Property']['id'];
                    $_Data['Property']['is_paid'] = 1;
                    $_Data['Property']['is_active'] = 1;
                    $_Data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
                    $_Data['Property']['user_id'] = $property['Property']['user_id'];
                    $_Data['Property']['name'] = $property['Property']['title'];
                    $this->Property->save($_Data);
                }
            } elseif ($data['from'] == 'verify') {
                $data['Transaction']['foreign_id'] = $property['Property']['id'];
                $data['Transaction']['class'] = 'Property';
                $data['Transaction']['user_id'] = $property['Property']['user_id'];
                $data['Transaction']['amount'] = $data['amount'];
                $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyVerifyFee;
                $this->Property->User->Transaction->create();
                if ($this->Property->User->Transaction->save($data)) {
                    $_Data['Property']['id'] = $data['property_id'];
                    $_Data['Property']['is_verified'] = 2; // waiting for confirmation
                    $_Data['Property']['user_id'] = $_SESSION['Auth']['User']['id'];
                    $this->Property->save($_Data);
                }
            }
        }
        return $return;
    }
    function payUser($data)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $return = '';
        if (!empty($data['payment_type_id']) && $data['payment_type_id'] == ConstPaymentGateways::PayPal) {
            App::import('Vendor', 'adaptive_paypal/paypal_platform');
            $this->PaypalPlatform = new PaypalPlatform();
            $payment_gateway_id = ConstPaymentGateways::PayPal;
            $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => $payment_gateway_id,
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
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                    $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
            }
            $gateway_settings_options['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
            $this->PaypalPlatform->settings($gateway_settings_options);
            $User_id = $data['user_id'];
            // Request specific required fields
            $actionType = "PAY";
            $cancelUrl = Router::url('/', true) . 'payments/cancel_user_payment/' . $User_id;
            $returnUrl = Router::url('/', true) . 'payments/success_user_payment/' . $User_id;
            $ipnNotificationUrl = Router::url('/', true) . 'payments/process_user_payment/' . $User_id . '/' . $data['from'];
            $currencyCode = Configure::read('site.currency_code');
            $receiverEmailArray = array(
                $gateway_settings_options['payee_account']
            );
            $receiverAmountArray = array(
                $data['amount']
            );
            $receiverPrimaryArray = array();
            $receiverInvoiceIdArray = array(
                md5('PropertyPay_' . date('YmdHis'))
            );
            $senderEmail = '';
            $feesPayer = 'SENDER';
            $memo = '';
            $pin = '';
            $preapprovalKey = '';
            if (!empty($data['user_paypal_connection_id'])) {
                $userPaypalConnection = $this->User->UserPaypalConnection->find('first', array(
                    'conditions' => array(
                        'UserPaypalConnection.id' => $data['user_paypal_connection_id']
                    ) ,
                    'recursive' => -1
                ));
                $preapprovalKey = trim($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
                $senderEmail = trim($userPaypalConnection['UserPaypalConnection']['sender_email']);
                if ($data['from'] == 'listing_fee') {
                    $Propertydata['listing_user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                } elseif ($data['from'] == 'verify') {
                    $Propertydata['verify_user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                }
            }
            $reverseAllParallelPaymentsOnError = '';
            $trackingId = $this->PaypalPlatform->generateTrackingID();
            // Make the Pay API call
            $resArray = $this->PaypalPlatform->CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId);
            $ack = strtoupper($resArray["responseEnvelope.ack"]);
            $return['error'] = 0;
            if ($ack == "SUCCESS") {
                $Userdata['id'] = $User_id;
                $Userdata['pay_key'] = $resArray["payKey"];
                $this->User->Behaviors->detach('Logable');
                $this->User->save($Userdata, false);
                if ('' == $preapprovalKey) {
                    $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
                    $embedded = false;
                    if (Configure::read('paypal.is_embedded_payment_enabled')) {
                        $embedded = true;
                    }
                    $this->PaypalPlatform->RedirectToPayPal($cmd, $embedded);
                } else {
                    $payKey = urldecode($resArray["payKey"]);
                    $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
                }
            } else {
                $ErrorMsg = urldecode($resArray["error(0).message"]);
                $return['error_message'] = $ErrorMsg;
                $return['error'] = 1;
            }
        }
        return $return;
    }
    function sendMoney($data)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $data['user_id']
            ) ,
            'contain' => array(
                'UserProfile' => array(
                    'fields' => array(
                        'UserProfile.paypal_account',
                    ) ,
                )
            ) ,
            'recursive' => 0
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $SendMoney['user_id'] = $data['user_id'];;
        $SendMoney['amount'] = $data['amount'];
        $this->User->SendMoney->create();
        $this->User->SendMoney->save($SendMoney, false);
        $sendmoney_id = $this->User->SendMoney->id;
        // Request specific required fields
        $actionType = "PAY";
        $cancelUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'cancel_sendmoney',
            $sendmoney_id,
            'admin' => false
        ) , true);
        $returnUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'success_sendmoney',
            $sendmoney_id,
            'admin' => false
        ) , true);
        $ipnNotificationUrl = Router::url(array(
            'controller' => 'payments',
            'action' => '	',
            $sendmoney_id,
            'admin' => false
        ) , true);
        $currencyCode = Configure::read('site.currency_code');
        $receiverEmailArray = array(
            $user['UserProfile']['paypal_account']
        );
        $receiverAmountArray = array(
            $data['amount']
        );
        $receiverPrimaryArray = array();
        $receiverInvoiceIdArray = array(
            md5('sendmoney_' . date('YmdHis'))
        );
        $senderEmail = '';
        $feesPayer = 'EACHRECEIVER';
        if ($data['fee_payer'] == 2) {
            $feesPayer = 'SENDER';
        }
        $memo = '';
        $pin = '';
        $preapprovalKey = '';
        $reverseAllParallelPaymentsOnError = '';
        $trackingId = $this->PaypalPlatform->generateTrackingID();
        // Make the Pay API call
        $resArray = $this->PaypalPlatform->CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId);
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        $return['error'] = 0;
        if ($ack == "SUCCESS") {
			$this->CustomizePaymentPage($resArray["payKey"]);
            $SendMoney['id'] = $sendmoney_id;
            $SendMoney['pay_key'] = $resArray["payKey"];
            $this->User->SendMoney->save($SendMoney, false);
            $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
            $embedded = false;
            if (Configure::read('paypal.is_embedded_payment_enabled')) {
                $embedded = true;
            }
            $this->PaypalPlatform->RedirectToPayPal($cmd, $embedded);
        } else {
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $return['error_message'] = $ErrorMsg;
            $return['error'] = 1;
        }
        return $return;
    }
    function getMerchantReferralURL()
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $payment_gateway_id = ConstPaymentGateways::PayPal;
        $paymentGateway = $this->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id,
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
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
            }
        }
        if (!empty($paymentGateway['PaymentGateway']['is_test_mode'])) {
            return 'https://www.sandbox.paypal.com/us/mrb/pal=' . $gateway_settings_options['MRB_ID'];
        } else {
            return 'https://www.paypal.com/us/mrb/pal=' . $gateway_settings_options['MRB_ID'];
        }
    }
    function createPaypalAccount($paypalAccount)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $cancelUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'cancel_account',
            'admin' => false
        ) , true);
        $returnUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'success_account',
            'admin' => false
        ) , true);
        $referralId = '';
        $notificationURL = '';
        $preferredLanguageCode = 'en_US';
        $accountType = $paypalAccount['PaypalAccount']['payment_types'];
        $firstName = $paypalAccount['PaypalAccount']['first_name'];
        $lastName = $paypalAccount['PaypalAccount']['last_name'];
        $dateOfBirth = $paypalAccount['PaypalAccount']['dob'];
        $address1 = $paypalAccount['PaypalAccount']['address1'];
        $address2 = $paypalAccount['PaypalAccount']['address2'];
        $city = $paypalAccount['PaypalAccount']['city'];
        $state = $paypalAccount['PaypalAccount']['state'];
        $zip = $paypalAccount['PaypalAccount']['zip'];
        $countryCode = $paypalAccount['PaypalCountry']['code'];
        $citizenshipCountryCode = $paypalAccount['PaypalCitizenshipCountry']['code'];
        $contactPhoneNumber = $paypalAccount['PaypalAccount']['phone'];
        $currencyCode = $paypalAccount['PaypalAccount']['currency_code'];
        $emailAddress = $paypalAccount['PaypalAccount']['email'];
        $resArray = $PaypalPlatform->CallCreateAccount($preferredLanguageCode, $accountType, $firstName, $lastName, $dateOfBirth, $address1, $address2, $city, $state, $zip, $countryCode, $citizenshipCountryCode, $contactPhoneNumber, $currencyCode, $emailAddress, $returnUrl, $cancelUrl, $notificationURL, $referralId);
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        $return['error'] = 0;
        if ($ack == "SUCCESS") {
            $data['PaypalAccount']['id'] = $paypalAccount['PaypalAccount']['id'];
            $data['PaypalAccount']['create_account_key'] = $resArray["createAccountKey"];
            $this->User->PaypalAccount->save($data, false);
            header('Location: ' . $resArray["redirectURL"]);
            exit;
        } else {
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $return['error_message'] = $ErrorMsg;
            $return['error'] = 1;
        }
        return $return;
    }
    function getVerifiedStatus($data)
    {
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $paymentDetails = $PaypalPlatform->CallGetVerifiedStatus($data['paypal_account'], $data['paypal_first_name'], $data['paypal_last_name']);
        return $paymentDetails;
    }
    function _getPaypalPlatformObject()
    {
        App::import('Vendor', 'adaptive_paypal/paypal_platform');
        $this->PaypalPlatform = new PaypalPlatform();
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $payment_gateway_id = ConstPaymentGateways::PayPal;
        $paymentGateway = $this->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id,
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
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
            }
        }
        $gateway_settings_options['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
        $this->PaypalPlatform->settings($gateway_settings_options);
        return $this->PaypalPlatform;
    }
    function cancelPreapproval($preapprovalKey)
    {
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $paymentDetails = $PaypalPlatform->CallCancelPreapproval($preapprovalKey);
        return $paymentDetails;
    }
    function _executeProcessOrder($order_id)
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        $propertyInfo = $this->Property->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $order_id,
            ) ,
            'contain' => array(
                'Property' => array(
                    'User' => array(
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.paypal_account',
                            )
                        )
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($propertyInfo)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $itemDetail['payKey'] = $propertyInfo['PropertyUser']['pay_key'];
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $rsArray = $PaypalPlatform->CallExecutePayment($itemDetail['payKey']);
        $ack = strtoupper($rsArray["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
            if (strtoupper($rsArray['paymentExecStatus']) == 'COMPLETED') {
                $return['error'] = 0;
            } else {
                $return['error'] = 1;
            }
        } else {
            $return['error'] = 1;
        }
        return $return;
    }
    function _refundProcessOrder($order_id)
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        $propertyInfo = $this->Property->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $order_id,
            ) ,
            'contain' => array(
                'Property' => array(
                    'User' => array(
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.paypal_account',
                            )
                        )
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        if (empty($propertyInfo)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $itemDetail['payKey'] = $propertyInfo['PropertyUser']['pay_key'];
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $receiverEmailArray = array();
        $receiverAmountArray = array();
        $currencyCode = Configure::read('site.currency_code');
        $transactionId = '';
        $trackingId = '';
        $paymentDetails = $PaypalPlatform->CallRefund($itemDetail['payKey'], $transactionId, $trackingId, $receiverEmailArray, $receiverAmountArray, $currencyCode);
        $ack = strtoupper($paymentDetails["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
            $this->_saveRefundLog($order_id, $paymentDetails);
            if (strtoupper($paymentDetails['refundInfoList.refundInfo(0).refundStatus']) == 'REFUNDED' || strtoupper($paymentDetails['refundInfoList.refundInfo(0).refundStatus']) == 'ALREADY_REVERSED_OR_REFUNDED') {
                $return['error'] = 0;
            } else {
                $return['error'] = 1;
            }
        } else {
            $return['error'] = 1;
        }
        return $return;
    }
    function _saveRefundLog($order_id, $paymentDetails)
    {
        App::import('Model', 'AdaptiveTransactionLog');
        $this->AdaptiveTransactionLog = new AdaptiveTransactionLog();
        $adaptiveTransactionLog['foreign_id'] = $order_id;
        $adaptiveTransactionLog['class'] = 'PropertyUser';
        $adaptiveTransactionLog['timestamp'] = $paymentDetails['responseEnvelope.timestamp'];
        $adaptiveTransactionLog['ack'] = $paymentDetails['responseEnvelope.ack'];
        $adaptiveTransactionLog['correlation_id'] = $paymentDetails['responseEnvelope.correlationId'];
        $adaptiveTransactionLog['build'] = $paymentDetails['responseEnvelope.build'];
        $adaptiveTransactionLog['currency_code'] = $paymentDetails['currencyCode'];
        $paypal_post_vars_in_str = '';
        foreach($paymentDetails as $key => $value) {
            $value = urlencode(stripslashes($value));
            $paypal_post_vars_in_str.= "&$key=$value";
        }
        $adaptiveTransactionLog['paypal_post_vars'] = $paypal_post_vars_in_str;
        for ($i = 0; $i < 2; $i++) {
            $adaptiveTransactionLog['amount'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').receiver.amount'];
            $adaptiveTransactionLog['email'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').receiver.email'];
            $adaptiveTransactionLog['refund_status'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundStatus'];
            $adaptiveTransactionLog['refund_net_amount'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundNetAmount'];
            $adaptiveTransactionLog['refund_fee_amount'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundFeeAmount'];
            $adaptiveTransactionLog['refund_gross_amount'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundGrossAmount'];
            $adaptiveTransactionLog['total_of_alll_refunds'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').totalOfAllRefunds'];
            $adaptiveTransactionLog['refund_has_become_full'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundHasBecomeFull'];
            $adaptiveTransactionLog['encrypted_refund_transaction_id'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').encryptedRefundTransactionId'];
            $adaptiveTransactionLog['refund_transaction_status'] = $paymentDetails['refundInfoList.refundInfo(' . $i . ').refundTransactionStatus'];
            $this->AdaptiveTransactionLog->create();
            $this->AdaptiveTransactionLog->save($adaptiveTransactionLog);
        }
    }
    function _parse_array_query($array, $convention = '%s')
    {
        if (count($array) == 0) {
            return '';
        } else {
            $query = '';
            foreach($array as $key => $value) {
                if (is_array($value)) {
                    $new_convention = sprintf($convention, $key) . '[%s]';
                    $query.= $this->_parse_array_query($value, $new_convention);
                } else {
                    $key = urlencode($key);
                    $value = urlencode($value);
                    $query.= sprintf($convention, $key) . "=$value&";
                }
            }
            return $query;
        }
    }
    function _saveIPNLog()
    {
        App::import('Model', 'AdaptiveIpnLog');
        $this->AdaptiveIpnLog = new AdaptiveIpnLog();
        $paypal_post_vars_in_str = $this->_parse_array_query($_POST);
        $adaptiveIpnLog['post_variable'] = $paypal_post_vars_in_str;
        // @todo "IP table logic"
        $adaptiveIpnLog['ip'] = RequestHandlerComponent::getClientIP();
        $this->AdaptiveIpnLog->create();
        $this->AdaptiveIpnLog->save($adaptiveIpnLog);
    }
    function processOrderPayment($order_id)
    {
        $transaction_id = '0';
        $this->_saveIPNLog();
        $paymentDetails = array();
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $propertyUser = $this->Property->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $order_id
            ) ,
            'recursive' => -1
        ));
        if (empty($propertyUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $property_id = $propertyUser['PropertyUser']['property_id'];
        $propertyInfo = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $property_booker_account = $this->Property->PropertyUser->User->find('first', array(
            'conditions' => array(
                'User.id' => $propertyUser['PropertyUser']['user_id']
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.email',
                'User.blocked_amount'
            ) ,
            'recursive' => -1
        ));
        if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal) {
            $paymentDetails = $this->getPaymentDetails($propertyUser['PropertyUser']['pay_key']);
            if (isset($paymentDetails['status']) && ($paymentDetails['status'] == 'INCOMPLETE' || $paymentDetails['status'] == 'COMPLETED')) {
                $this->_savePaidLog($order_id, $paymentDetails);
                if (isset($paymentDetails['paymentInfoList.paymentInfo(0).transactionStatus']) && isset($paymentDetails['paymentInfoList.paymentInfo(1).transactionStatus']) && $paymentDetails['paymentInfoList.paymentInfo(0).transactionStatus'] == 'REFUNDED' || isset($paymentDetails['paymentInfoList.paymentInfo(1).transactionStatus']) && $paymentDetails['paymentInfoList.paymentInfo(1).transactionStatus'] == 'REFUNDED') {
                    if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::CanceledByAdmin) {
                        $this->Property->PropertyUser->processOrder($propertyUser['PropertyUser']['id'], 'admin_cancel');
                    }
                }
                if (empty($propertyUser['PropertyUser']['property_user_status_id']) || $propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
                    $data['Transaction']['user_id'] = $property_booker_account['User']['id'];
                    $data['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
                    $data['Transaction']['class'] = 'PropertyUser';
                    $data['Transaction']['amount'] = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
                    $data['Transaction']['payment_gateway_id'] = $propertyUser['PropertyUser']['payment_gateway_id'];
                    $data['Transaction']['description'] = 'Payment Success';
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::BookProperty;
                    $transaction_id = $this->Property->PropertyUser->User->Transaction->log($data);
                    $this->_doOrderProcess($property_booker_account, $propertyInfo, $property_id, $propertyUser, $order_id, $paymentDetails, $transaction_id);
                }
            }
        } elseif ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
            $this->_doOrderProcess($property_booker_account, $propertyInfo, $property_id, $propertyUser, $order_id, $paymentDetails, $transaction_id);
        } elseif ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet || $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
            if (empty($propertyUser['PropertyUser']['property_user_status_id']) || $propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
                $data['Transaction']['user_id'] = $property_booker_account['User']['id'];
                $data['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
                $data['Transaction']['class'] = 'PropertyUser';
                $data['Transaction']['amount'] = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
                $data['Transaction']['payment_gateway_id'] = $propertyUser['PropertyUser']['payment_gateway_id'];
                $data['Transaction']['description'] = 'Payment Success';
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::BookProperty;
                $transaction_id = $this->Property->PropertyUser->User->Transaction->log($data);
                $this->_doOrderProcess($property_booker_account, $propertyInfo, $property_id, $propertyUser, $order_id, $paymentDetails, $transaction_id);
            }
        }
    }
    function _doOrderProcess($property_booker_account, $propertyInfo, $property_id, $propertyUser, $order_id, $paymentDetails, $transaction_id)
    {
        $_propertyUser['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforAcceptance;
        $_propertyUser['PropertyUser']['owner_user_id'] = $propertyInfo['Property']['user_id'];
        $_propertyUser['PropertyUser']['user_id'] = $_SESSION['Auth']['User']['id'];
        $_propertyUser['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
        $this->Property->PropertyUser->save($_propertyUser, false);
        $update_seller_balance = $propertyInfo['User']['blocked_amount']+($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']); // Owner blocked amount + (actual property amount - commision amount)
        $this->Property->PropertyUser->User->updateAll(array(
            'User.blocked_amount' => "'" . $update_seller_balance . "'"
        ) , array(
            'User.id' => $propertyInfo['Property']['user_id']
        ));
        $hostInfo = $this->Property->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $propertyInfo['Property']['user_id']
            ) ,
            'recursive' => -1
        ));
        $TravelerInfo = $this->Property->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $_SESSION['Auth']['User']['id']
            ) ,
            'recursive' => 1
        ));
        // Notification Message //
        $to = $propertyInfo['Property']['user_id'];
        $to_Traveler = $_SESSION['Auth']['User']['id'];
        $sender_email = $hostInfo['User']['email'];
        $buyer_email = $TravelerInfo['User']['email'];
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'MessageContent');
        $this->MessageContent = new MessageContent();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        //
        // Get Seller Rating //
        $getHostrating = $this->getRatingCount($propertyInfo['Property']['user_id']);
        $template = $this->EmailTemplate->selectTemplate('New booking notification');
        $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'];
        $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
        $emailFindReplace = array(
            '##USERNAME##' => $hostInfo['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##PROPERTY_NAME##' => "<a href=" . Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                $propertyInfo['Property']['slug'],
            ) , true) . ">" . $propertyInfo['Property']['title'] . "</a>",
            '##PROPERTY_ID##' => $propertyInfo['Property']['id'],
            '##TRAVELER_USERNAME##' => $TravelerInfo['User']['username'],
            '##ACCEPT_URL##' => "<a href=" . Router::url(array(
                'controller' => 'property_users',
                'action' => 'update_order',
                $order_id,
                __l('accept') ,
            ) , true) . ">" . __l('Accept your booking') . "</a>",
            '##REJECT_URL##' => "<a href=" . Router::url(array(
                'controller' => 'property_users',
                'action' => 'update_order',
                $order_id,
                __l('reject') ,
            ) , true) . ">" . __l('Reject your booking') . "</a>",
            '##CANCEL_URL##' => "<a href=" . Router::url(array(
                'controller' => 'property_users',
                'action' => 'update_order',
                $order_id,
                __l('cancel') ,
            ) , true) . ">" . __l('Cancel your booking') . "</a>",
            '##BALANCE_LINK##' => "<a href=" . Router::url(array(
                'controller' => 'property_users',
                'action' => 'index',
                'type' => 'balance'
            ) , true) . ">" . Configure::read('site.name') . ' ' . __l('balance') . "</a>",
            '##ORDER_NO##' => $order_id,
            '##PROPERTY_FULL_NAME##' => "<a href=" . Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                $propertyInfo['Property']['slug']
            ) , true) . ">" . $propertyInfo['Property']['title'] . "</a>",
            '##PROPERTY_DESCRIPTION##' => $propertyInfo['Property']['description'],
            '##CONTACT_LINK##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
                'admin' => false
            ) , true) ,
            '##CONTACT_LINK##' => "<a href=" . Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
            ) , true) . ">" . Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
            ) , true) . "</a>",
            '##HOST_NAME##' => $hostInfo['User']['username'],
            '##HOST_RATING##' => (!empty($getHostrating) && is_numeric($getHostrating)) ? $getHostrating . '% ' . __l('Positive') : __l('Not Rated Yet') ,
            '##HOST_CONTACT_LINK##' => Router::url(array(
                'controller' => 'messages',
                'action' => 'compose',
                'type' => 'contact',
                'to' => $hostInfo['User']['username'],
                'slug' => $propertyInfo['Property']['slug'],
            ) , true),
            '##PROPERTY_ALT_NAME##' => __l('Property') ,
            '##CHECK_IN_DATE##' => $propertyUser['PropertyUser']['checkin'],
            '##CHECK_OUT_DATE##' => $propertyUser['PropertyUser']['checkout'],
            '##PROPERTY_AUTO_EXPIRE_DATE##' => Configure::read('property.auto_expire') ,
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
        $this->Property->PropertyUser->User->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
        if (Configure::read('messages.is_send_internal_message')) {
            $message_id = $this->Property->PropertyUser->User->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $propertyInfo['Property']['id'], ConstPropertyUserStatus::WaitingforAcceptance);
            if (Configure::read('messages.is_send_email_on_new_message')) {
                $content['subject'] = __l('You have a new booking');
                $content['message'] = __l('You have a new booking');
                if (!empty($sender_email)) {
                    if ($this->_checkUserNotifications($to, ConstPropertyUserStatus::WaitingforAcceptance, 0)) { // (to_user_id, order_status,is_sender);
                        $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Booking Alert Mail');
                    }
                }
            }
            $template = $this->EmailTemplate->selectTemplate('New booking Traveler notification');
            $emailFindReplace['##USERNAME##'] = $TravelerInfo['User']['username'];
            $message_for_buyer = strtr($template['email_content'], $emailFindReplace);
            $subject_for_buyer = strtr($template['subject'], $emailFindReplace);
            if (Configure::read('messages.send_notification_mail_for_sender')) {
                $message_id_buyer = $this->Property->PropertyUser->User->Message->sendNotifications($to_Traveler, $subject_for_buyer, $message_for_buyer, $order_id, $is_review = 0, $propertyInfo['Property']['id'], ConstPropertyUserStatus::SenderNotification);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $content['subject'] = __l('Your booking has been placed');
                    $content['message'] = __l('Your booking has been placed');
                    if (!empty($buyer_email)) {
                        if ($this->_checkUserNotifications($to_Traveler, ConstPropertyUserStatus::WaitingforAcceptance, 1)) { // (to_user_id, order_status,is_sender);
                            $this->_sendAlertOnNewMessage($buyer_email, $content, $message_id_buyer, 'Booking Alert Mail');
                        }
                    }
                }
            }
        }
        if (!empty($transaction_id)) {
            $transaction['Transaction']['id'] = $transaction_id;
            $transaction['Transaction']['foreign_id'] = $order_id;
            $transaction['Transaction']['class'] = 'PropertyUser';
            $this->Property->PropertyUser->User->Transaction->save($transaction);
        }
        // Updating transaction again for seller //
        $transaction['Transaction']['id'] = '';
        $transaction['Transaction']['user_id'] = $propertyInfo['Property']['user_id'];
        $transaction['Transaction']['foreign_id'] = $order_id;
        $transaction['Transaction']['class'] = 'PropertyUser';
        $transaction['Transaction']['amount'] = $propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount'];
        $transaction['Transaction']['description'] = 'Updating payment status for seller';
        $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::AmountTransferredForHost;
        $this->Property->PropertyUser->User->Transaction->save($transaction);
        return true;
    }
    function processUserPayment($add_to_wallet_id)
    {
        $this->_saveIPNLog();
        App::import('Model', 'UserAddWalletAmount');
        $this->UserAddWalletAmount = new UserAddWalletAmount();
        App::import('Model', 'User');
        $this->User = new User();
        $addWalletAmount = $this->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id' => $add_to_wallet_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.available_wallet_amount',
                        'User.total_amount_deposited',
                    ) ,
                ) ,
            ) ,
            'recursive' => 0
        ));
        if (empty($addWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentDetails = $this->getPaymentDetails($addWalletAmount['UserAddWalletAmount']['pay_key']);
        if ($paymentDetails['status'] == 'INCOMPLETE' || $paymentDetails['status'] == 'COMPLETED') {
            $this->_savePaidLog($add_to_wallet_id, $paymentDetails);
            if (empty($addWalletAmount['UserAddWalletAmount']['is_success'])) {
                $data['Transaction']['user_id'] = $addWalletAmount['UserAddWalletAmount']['user_id'];
                $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                $data['Transaction']['class'] = 'SecondUser';
                $data['Transaction']['amount'] = $addWalletAmount['UserAddWalletAmount']['amount'];
                $data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                $data['Transaction']['description'] = 'Payment Success';
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                $transaction_id = $this->User->Transaction->log($data);
                $User['id'] = $addWalletAmount['UserAddWalletAmount']['user_id'];
                $User['available_wallet_amount'] = $addWalletAmount['User']['available_wallet_amount']+$addWalletAmount['UserAddWalletAmount']['amount'];
                $User['total_amount_deposited'] = $addWalletAmount['User']['total_amount_deposited']+$addWalletAmount['UserAddWalletAmount']['amount'];
                $this->User->save($User, false);
                $addWalletAmountUpdate['UserAddWalletAmount']['id'] = $add_to_wallet_id;
                $addWalletAmountUpdate['UserAddWalletAmount']['is_success'] = 1;
                $this->UserAddWalletAmount->save($addWalletAmountUpdate, false);
                return true;
            }
        }
    }
    function _savePaidLog($order_id, $paymentDetails, $class = 'PropertyUser', $receiver_count = 2)
    {
        App::import('Model', 'AdaptiveTransactionLog');
        $this->AdaptiveTransactionLog = new AdaptiveTransactionLog();
        $adaptiveTransactionLog['foreign_id'] = $order_id;
        $adaptiveTransactionLog['class'] = $class;
        $adaptiveTransactionLog['timestamp'] = $paymentDetails['responseEnvelope.timestamp'];
        $adaptiveTransactionLog['ack'] = $paymentDetails['responseEnvelope.ack'];
        $adaptiveTransactionLog['correlation_id'] = $paymentDetails['responseEnvelope.correlationId'];
        $adaptiveTransactionLog['build'] = $paymentDetails['responseEnvelope.build'];
        $adaptiveTransactionLog['currency_code'] = $paymentDetails['currencyCode'];
        $adaptiveTransactionLog['sender_email'] = $paymentDetails['senderEmail'];
        $adaptiveTransactionLog['status'] = $paymentDetails['status'];
        $adaptiveTransactionLog['tracking_id'] = $paymentDetails['trackingId'];
        $adaptiveTransactionLog['pay_key'] = $paymentDetails['payKey'];
        $adaptiveTransactionLog['action_type'] = $paymentDetails['actionType'];
        $adaptiveTransactionLog['fees_payer'] = $paymentDetails['feesPayer'];
        $adaptiveTransactionLog['reverse_all_parallel_payments_on_error'] = $paymentDetails['reverseAllParallelPaymentsOnError'];;
        for ($i = 0; $i < $receiver_count; $i++) {
            if (isset($paymentDetails['paymentInfoList.paymentInfo(' . $i . ').transactionId'])) {
                $adaptiveTransactionLog['transaction_id'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').transactionId'];
                $adaptiveTransactionLog['transaction_status'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').transactionStatus'];
                $adaptiveTransactionLog['amount'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').receiver.amount'];
                $adaptiveTransactionLog['email'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').receiver.email'];
                $adaptiveTransactionLog['primary'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').receiver.primary'];
                $adaptiveTransactionLog['invoice_id'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').receiver.invoiceId'];
                $adaptiveTransactionLog['refunded_amount'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').refundedAmount'];
                $adaptiveTransactionLog['pending_refund'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').pendingRefund'];
                $adaptiveTransactionLog['sender_transaction_id'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').senderTransactionId'];
                $adaptiveTransactionLog['sender_transaction_status'] = $paymentDetails['paymentInfoList.paymentInfo(' . $i . ').senderTransactionStatus'];
                $this->AdaptiveTransactionLog->create();
                $this->AdaptiveTransactionLog->save($adaptiveTransactionLog);
            }
        }
    }
    function updateUserConnection($paypalConnection, $userPaypalConnection)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $defaultUserPaypalConnection = $this->User->UserPaypalConnection->find('first', array(
            'conditions' => array(
                'UserPaypalConnection.user_id' => $userPaypalConnection['UserPaypalConnection']['user_id'],
                'UserPaypalConnection.is_default' => 1
            ) ,
            'fields' => array(
                'COUNT(UserPaypalConnection.id) AS default_count'
            ) ,
            'recursive' => -1
        ));
        if (empty($defaultUserPaypalConnection[0]['default_count'])) {
            $this->data['UserPaypalConnection']['is_default'] = 1;
        }
        $this->data['UserPaypalConnection']['sender_email'] = $paypalConnection['senderEmail'];
        $this->data['UserPaypalConnection']['amount'] = $paypalConnection['maxTotalAmountOfAllPayments'];
        $this->data['UserPaypalConnection']['is_active'] = 1;
        $this->data['UserPaypalConnection']['id'] = $userPaypalConnection['UserPaypalConnection']['id'];
        $this->User->UserPaypalConnection->save($this->data, false);
    }
    function getPaymentDetails($payKey)
    {
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $transactionId = '';
        $trackingId = '';
        $paymentDetails = $PaypalPlatform->CallPaymentDetails($payKey, $transactionId, $trackingId);
        return $paymentDetails;
    }
    function getPreapprovalDetails($preapprovalKey)
    {
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $paypalConnection = $PaypalPlatform->CallPreapprovalDetails($preapprovalKey);
        return $paypalConnection;
    }
    function processPaypalConnect($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $property = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $PaypalPlatform = $this->_getPaypalPlatformObject();
        $currencyCode = Configure::read('site.currency_code');
        $startingDate = date('c');
        $endingDate = date('c', strtotime('+1 year'));
        $this->data['UserPaypalConnection']['user_id'] = $user_id;
        $this->data['UserPaypalConnection']['valid_from'] = $startingDate;
        $this->data['UserPaypalConnection']['valid_to'] = $endingDate;
        $this->User->UserPaypalConnection->save($this->data);
        $user_paypal_connection_id = $this->data['UserPaypalConnection']['id'] = $this->User->UserPaypalConnection->id;
        $maxTotalAmountOfAllPayments = "2000";
        $senderEmail = "";
        $maxNumberOfPayments = "";
        $paymentPeriod = "";
        $dateOfMonth = "";
        $dayOfWeek = "";
        $maxAmountPerPayment = "";
        $maxNumberOfPaymentsPerPeriod = "";
        $pinType = "";
        $cancelUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'cancel_connect',
            $user_paypal_connection_id,
            'admin' => false
        ) , true);
        $returnUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'success_connect',
            $user_paypal_connection_id,
            'admin' => false
        ) , true);
        $ipnNotificationUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'processconnect',
            $user_paypal_connection_id,
            'admin' => false
        ) , true);
        $resArray = $PaypalPlatform->CallPreapproval($returnUrl, $cancelUrl, $currencyCode, $startingDate, $endingDate, $maxTotalAmountOfAllPayments, $senderEmail, $maxNumberOfPayments, $paymentPeriod, $dateOfMonth, $dayOfWeek, $maxAmountPerPayment, $maxNumberOfPaymentsPerPeriod, $pinType, $ipnNotificationUrl);
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
			$this->CustomizePaymentPage($resArray["preapprovalKey"]);
            $this->User->UserPaypalConnection->updateAll(array(
                'UserPaypalConnection.pre_approval_key' => "AES_ENCRYPT('" . $resArray["preapprovalKey"] . "', '" . Configure::read('Security.salt') . "')",
            ) , array(
                'UserPaypalConnection.id' => $user_paypal_connection_id
            ));
            $cmd = "cmd=_ap-preapproval&preapprovalkey=" . urldecode($resArray["preapprovalKey"]);
            $PaypalPlatform->RedirectToPayPal($cmd, false);
        } else {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            //TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
            $ErrorCode = urldecode($resArray["error(0).errorId"]);
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $ErrorDomain = urldecode($resArray["error(0).domain"]);
            $ErrorSeverity = urldecode($resArray["error(0).severity"]);
            $ErrorCategory = urldecode($resArray["error(0).category"]);
            $return['error_message'] = $ErrorMsg;
            $return['error'] = 1;
            return $return;
        }
    }
    function processOrder($data)
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'User');
        $this->User = new User();
        switch ($data['type']) {
            case 'property':
                $property = $this->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $data['item_id']
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'UserProfile' => array()
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                if (empty($property)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($data['order_id'])) {
                    $propertyUser['id'] = $data['order_id'];
                } else {
                    $this->Property->PropertyUser->create();
                }
                $propertyUser = $this->Property->PropertyUser->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $data['order_id']
                    ) ,
                    'recursive' => -1
                ));
                $days = (strtotime($propertyUser['PropertyUser']['checkout']) -strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24);
                if ($days == 0) {
                    $days = 1;
                } else {
                    $days = $days+1;
                }
                $service_fee = $propertyUser['PropertyUser']['traveler_service_amount'];
                $booking_price = $propertyUser['PropertyUser']['price'];
				$security_deposit = 0;
				if(Configure::read('property.is_enable_security_deposit'))
				{
				$security_deposit = $propertyUser['PropertyUser']['security_deposit'];
				}
                if (!empty($propertyUser['PropertyUser']['negotiate_amount'])) {
                    $booking_price = $booking_price+$propertyUser['PropertyUser']['negotiate_amount'];
                }
                $hosting_fee = round($booking_price*(Configure::read('property.host_commission_amount') /100) , 2);
                $amount = $propertyUser['PropertyUser']['price'];
                $property_user = array();
                $property_user['id'] = $data['order_id'];
                $property_user['amount'] = $amount;
                if (!empty($data['message'])) {
                    $property_user['message'] = $data['message'];
                }
                $property_user['traveler_service_amount'] = $service_fee; // Modified
                $property_user['host_service_amount'] = $hosting_fee; // Modified
                $property_user['owner_user_id'] = $property['Property']['user_id']; // Modified
                $property_user['payment_gateway_id'] = $data['payment_type_id'];
                $this->Property->PropertyUser->save($property_user, false);
                $order_id = $this->Property->PropertyUser->id;
                $itemDetail['price_per_night'] = $amount+$service_fee;
                $itemDetail['seller_amount'] = $amount-$hosting_fee;
                $itemDetail['site_amount'] = $service_fee+$hosting_fee;
                $itemDetail['seller_paypal_account'] = $property['User']['UserProfile']['paypal_account'];
                break;
        }
        if (!empty($data['payment_type_id']) && $data['payment_type_id'] == ConstPaymentGateways::PayPal) {
            App::import('Vendor', 'adaptive_paypal/paypal_platform');
            $this->PaypalPlatform = new PaypalPlatform();
            $payment_gateway_id = ConstPaymentGateways::PayPal;
            $paymentGateway = $this->Property->User->Transaction->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => $payment_gateway_id,
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
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                    $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
            }
            $gateway_settings_options['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
            $this->PaypalPlatform->settings($gateway_settings_options);
            // Request specific required fields
            if (!empty($propertyUser['PropertyUser']['is_delayed_chained_payment'])) {
                $actionType = "PAY_PRIMARY";
            } else {
                $actionType = "PAY";
            }
            $cancelUrl = Router::url(array(
                'controller' => 'payments',
                'action' => 'cancel_order',
                $data['type'],
                $order_id,
                'admin' => false
            ) , true);
            $returnUrl = Router::url(array(
                'controller' => 'payments',
                'action' => 'success_order',
                $data['type'],
                $order_id,
                'admin' => false
            ) , true);
            $ipnNotificationUrl = Router::url(array(
                'controller' => 'payments',
                'action' => 'processpayment',
                $data['type'],
                $order_id,
                'admin' => false
            ) , true);
            $currencyCode = Configure::read('site.currency_code');
            if (!empty($propertyUser['PropertyUser']['is_delayed_chained_payment'])) {
                if (Configure::read('property.payment_gateway_flow_id') == ConstPaymentGatewayFlow::TravelerHostSite) {
                    $receiverEmailArray = array(
                        $itemDetail['seller_paypal_account'],
                        $gateway_settings_options['payee_account']
                    );
                    $receiverAmountArray = array(
                        $itemDetail['amount'],
                        $itemDetail['site_amount'],
                    );
                } else {
                    $receiverEmailArray = array(
                        $gateway_settings_options['payee_account'],
                        $itemDetail['seller_paypal_account'],

                    );
                    $receiverAmountArray = array(
                        $itemDetail['price_per_night']+$security_deposit,
                        $itemDetail['seller_amount'],

                    );
                }
                $receiverPrimaryArray = array(
                    'true',
                    false
                );
                $receiverInvoiceIdArray = array(
                    md5('primary_' . date('YmdHis')) ,
                    md5('secondary_' . date('YmdHis'))
                );
                $senderEmail = '';
                $feesPayer = $this->_gatewayFeeSettings();
            } else {
                $receiverEmailArray = array(
                    $gateway_settings_options['payee_account']
                );
                $receiverAmountArray = array(
                    $itemDetail['price_per_night']+$security_deposit
                );
                $receiverPrimaryArray = array();
                $receiverInvoiceIdArray = array(
                    md5('PropertyPay_' . date('YmdHis'))
                );
                $senderEmail = '';
                $feesPayer = 'EACHRECEIVER';
            }
            $memo = '';
            $pin = '';
            $preapprovalKey = '';
            $reverseAllParallelPaymentsOnError = '';
            $trackingId = $this->PaypalPlatform->generateTrackingID();
            if (!empty($data['user_paypal_connection_id'])) {
                $userPaypalConnection = $this->Property->User->UserPaypalConnection->find('first', array(
                    'conditions' => array(
                        'UserPaypalConnection.id' => $data['user_paypal_connection_id']
                    ) ,
                    'recursive' => -1
                ));
                $preapprovalKey = trim($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
                $senderEmail = trim($userPaypalConnection['UserPaypalConnection']['sender_email']);
                $PropertyUser['user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
            }
            // Make the Pay API call
            $resArray = $this->PaypalPlatform->CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId);
            $ack = strtoupper($resArray["responseEnvelope.ack"]);
            $return['error'] = 0;
            if ($ack == "SUCCESS") {
                switch ($data['type']) {
                    case 'property':
                        $PropertyUser['id'] = $order_id;
                        $PropertyUser['pay_key'] = $resArray["payKey"];
                        $this->Property->PropertyUser->save($PropertyUser, false);
                }
                if ('' == $preapprovalKey) {
					$this->CustomizePaymentPage($resArray["payKey"]);
                    $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
                    $embedded = false;
                    if (Configure::read('paypal.is_embedded_payment_enabled')) {
                        $embedded = true;
                    }
                    $this->PaypalPlatform->RedirectToPayPal($cmd, $embedded);
                } else {
                    $payKey = urldecode($resArray["payKey"]);
                    $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
                }
            } else {
                $ErrorCode = urldecode($resArray["error(0).errorId"]);
                $ErrorMsg = urldecode($resArray["error(0).message"]);
                $ErrorDomain = urldecode($resArray["error(0).domain"]);
                $ErrorSeverity = urldecode($resArray["error(0).severity"]);
                $ErrorCategory = urldecode($resArray["error(0).category"]);
                $return['error_message'] = $ErrorMsg;
                $return['error'] = 1;
            }
        } elseif ($data['payment_type_id'] == ConstPaymentGateways::Wallet) {
            $buyer_info = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $_SESSION['Auth']['User']['id']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.available_wallet_amount',
                ) ,
                'recursive' => -1
            ));
            // Updating buyer balance //
			if(Configure::read('property.is_enable_security_deposit'))
			{
            $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-($propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit']);
			}
			else
			{
            $update_buyer_balance = $buyer_info['User']['available_wallet_amount']-($propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']);
			}
            $this->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
            ) , array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ));
            // Writing transactions //
            $update_transaction['Transaction']['user_id'] = $_SESSION['Auth']['User']['id'];
            $update_transaction['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
            $update_transaction['Transaction']['class'] = 'PropertyUser';
			if(Configure::read('property.is_enable_security_deposit'))
			{
            $update_transaction['Transaction']['amount'] = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
			}
			else
			{
            $update_transaction['Transaction']['amount'] = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount'];
			}
            $update_transaction['Transaction']['payment_gateway_id'] = $data['payment_type_id'];
            $update_transaction['Transaction']['description'] = 'Payment Success';
            $update_transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::BookProperty;
            $transaction_id = $this->Property->PropertyUser->User->Transaction->log($update_transaction);
        } elseif ($data['payment_type_id'] == ConstPaymentGateways::AuthorizeNet) {
            $cim = $this->_getCimObject();
            if (!empty($cim)) {
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $_SESSION['Auth']['User']['id']
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.cim_profile_id',
                        'User.username',
                        'User.email'
                    )
                ));
				if(Configure::read('property.is_enable_security_deposit'))
				{
                $amount = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
				}else
				{
				$amount = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount'];
				}
                $cim->setParameter('refId', time());
                $cim->setParameter('amount', $amount);
                $cim->setParameter('customerProfileId', $user['User']['cim_profile_id']);
                $cim->setParameter('customerPaymentProfileId', $data['payment_profile_id']);
                $title = Configure::read('site.name') . ' - Booking Amount Authorized';
                $description = 'Authorize booking amount in ' . Configure::read('site.name');
                // CIM accept only 30 character in title
                if (strlen($title) > 30) {
                    $title = substr($title, 0, 27) . '...';
                }
                $days = (strtotime($propertyUser['PropertyUser']['checkout']) -strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24);
                if ($days == 0) {
                    $days = 1;
                } else {
                    $days = $days+1;
                }
                $unit_amount = $propertyUser['PropertyUser']['price']/$days;
                $unit_amount = round($unit_amount, 2);
                $cim->setLineItem($propertyUser['PropertyUser']['property_id'], $title, $description, $days, $unit_amount);
                $cim->createCustomerProfileTransaction('profileTransAuthOnly');
                $response = $cim->getDirectResponse();
                $response_array = explode(',', $response);
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['property_user_id'] = $propertyUser['PropertyUser']['id'];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['user_id'] = $_SESSION['Auth']['User']['id'];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response_array[32];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
                $this->User->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                $return['error'] = 0;
                if ($cim->isSuccessful()) {
                    switch ($data['type']) {
                        case 'property':
                            $PropertyUser['id'] = $order_id;
                            $PropertyUser['cim_approval_code'] = $cim->getAuthCode();
                            $PropertyUser['cim_transaction_id'] = $cim->getTransactionID();
                            $PropertyUser['payment_profile_id'] = $data['payment_profile_id'];
                            $this->Property->PropertyUser->save($PropertyUser, false);
                    }
                } else {
                    $return['error_message'] = $cim->getResponse();
                    $return['error'] = 1;
                }
            }
        }
        $return['order_id'] = $order_id;
        return $return;
    }
    function processUserOrder($data)
    {
        App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'UserAddWalletAmount');
        $this->UserAddWalletAmount = new UserAddWalletAmount();
        switch ($data['type']) {
            case 'user':
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id = ' => $data['user_id']
                    ) ,
                    'contain' => array(
                        'UserPaypalConnection'
                    ) ,
                    'recursive' => 1
                ));
                if (empty($user)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($data['add_to_wallet_id'])) {
                    $UserAddWalletAmount['id'] = $data['add_to_wallet_id'];
                } else {
                    $this->UserAddWalletAmount->create();
                }
                $UserAddWalletAmount['user_id'] = $data['user_id'];
                $UserAddWalletAmount['amount'] = $data['amount'];
                $UserAddWalletAmount['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                $this->UserAddWalletAmount->create();
                $this->UserAddWalletAmount->save($UserAddWalletAmount, false);
                $add_to_wallet_id = $this->UserAddWalletAmount->id;
                break;
        }
        App::import('Vendor', 'adaptive_paypal/paypal_platform');
        $this->PaypalPlatform = new PaypalPlatform();
        $payment_gateway_id = ConstPaymentGateways::PayPal;
        $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id,
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
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                $gateway_settings_options[$paymentGatewaySetting['key']] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
            }
        }
        $gateway_settings_options['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
        $this->PaypalPlatform->settings($gateway_settings_options);
        // Request specific required fields
        $actionType = "PAY";
        $cancelUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'cancel_order',
            $data['type'],
            $add_to_wallet_id,
            'admin' => false
        ) , true);
        $returnUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'success_order',
            $data['type'],
            $add_to_wallet_id,
            'admin' => false
        ) , true);
        $ipnNotificationUrl = Router::url(array(
            'controller' => 'payments',
            'action' => 'processpayment',
            $data['type'],
            $add_to_wallet_id,
            'admin' => false
        ) , true);
        $currencyCode = Configure::read('site.currency_code');
        $receiverEmailArray = array(
            $gateway_settings_options['payee_account']
        );
        $receiverAmountArray = array(
            $data['amount']
        );
        $receiverPrimaryArray = array();
        $receiverInvoiceIdArray = array(
            md5('addtowallet_' . date('YmdHis'))
        );
        $senderEmail = '';
        $feesPayer = 'EACHRECEIVER';
        //        $feesPayer = 'SENDER';
        $memo = '';
        $pin = '';
        $preapprovalKey = '';
        $reverseAllParallelPaymentsOnError = '';
        $trackingId = $this->PaypalPlatform->generateTrackingID();
        if (!empty($data['user_paypal_connection_id'])) {
            $userPaypalConnection = $this->User->UserPaypalConnection->find('first', array(
                'conditions' => array(
                    'UserPaypalConnection.id' => $data['user_paypal_connection_id']
                ) ,
                'recursive' => -1
            ));
            $preapprovalKey = trim($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
            $senderEmail = trim($userPaypalConnection['UserPaypalConnection']['sender_email']);
            $UserAddWalletAmount['user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
        }
        // Make the Pay API call
        $resArray = $this->PaypalPlatform->CallPay($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId);
        $ack = strtoupper($resArray["responseEnvelope.ack"]);
        $return['error'] = 0;
        if ($ack == "SUCCESS") {
            //Update payKey value to user add wallet amount table.
            $update_userwallet = $this->UserAddWalletAmount->updateAll(array(
                'UserAddWalletAmount.pay_key' => "'" . $resArray["payKey"] . "'",
            ) , array(
                'UserAddWalletAmount.id' => $add_to_wallet_id,
            ));
            if ('' == $preapprovalKey) {
				$this->CustomizePaymentPage($resArray["payKey"]);
                $cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]);
                $embedded = false;
                if (Configure::read('paypal.is_embedded_payment_enabled')) {
                    $embedded = true;
                }
                $this->PaypalPlatform->RedirectToPayPal($cmd, $embedded);
                exit;
            } else {
                $payKey = urldecode($resArray["payKey"]);
                $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);
            }
            switch ($data['type']) {
                case 'user':
                    $UserAddWalletAmount['id'] = $add_to_wallet_id;
                    $UserAddWalletAmount['pay_key'] = $resArray["payKey"];
                    $this->UserAddWalletAmount->save($UserAddWalletAmount, false);
                    break;
            }
        } else {
            $ErrorCode = urldecode($resArray["error(0).errorId"]);
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $ErrorDomain = urldecode($resArray["error(0).domain"]);
            $ErrorSeverity = urldecode($resArray["error(0).severity"]);
            $ErrorCategory = urldecode($resArray["error(0).category"]);
            $return['error_message'] = $ErrorMsg;
            $return['error'] = 1;
        }
        $return['add_to_wallet_id'] = $add_to_wallet_id;
        return $return;
    }
    function _gatewayFeeSettings()
    {
        $feesPayer = '';
        if (Configure::read('property.payment_gateway_flow_id') == ConstPaymentGatewayFlow::TravelerHostSite) {
            if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::Host) {
                $feesPayer = 'PRIMARYRECEIVER';
            } else if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::Site) {
                $feesPayer = 'SECONDARYONLY';
            } else if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::SiteAndHost) {
                $feesPayer = 'EACHRECEIVER';
            }
        } else if (Configure::read('property.payment_gateway_flow_id') == ConstPaymentGatewayFlow::TravelerHostSite) {
            if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::Host) {
                $feesPayer = 'SECONDARYONLY';
            } else if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::Site) {
                $feesPayer = 'PRIMARYRECEIVER';
            } else if (Configure::read('property.payment_gateway_fee_id') == ConstPaymentGatewayFee::SiteAndHost) {
                $feesPayer = 'EACHRECEIVER';
            }
        }
        return $feesPayer;
    }
    function _getCimObject()
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        require_once (APP . 'vendors' . DS . 'CIM' . DS . 'AuthnetCIM.class.php');
        $paymentGateway = $this->Transaction->PaymentGateway->getPaymentSettings(ConstPaymentGateways::AuthorizeNet);
        if (!empty($paymentGateway) && !empty($paymentGateway['PaymentGateway']['authorize_net_api_key']) && !empty($paymentGateway['PaymentGateway']['authorize_net_trans_key'])) {
            if ($paymentGateway['PaymentGateway']['is_test_mode']) {
                $cim = new AuthnetCIM($paymentGateway['PaymentGateway']['authorize_net_api_key'], $paymentGateway['PaymentGateway']['authorize_net_trans_key'], true);
            } else {
                $cim = new AuthnetCIM($paymentGateway['PaymentGateway']['authorize_net_api_key'], $paymentGateway['PaymentGateway']['authorize_net_trans_key']);
            }
            return $cim;
        }
        return false;
    }
    function _createCimProfile($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.email',
                'User.id',
                'User.username',
                'User.cim_profile_id',
            ) ,
            'recursive' => -1
        ));
		if (empty($user['User']['cim_profile_id'])) {
			$cim = $this->_getCimObject();
			if (!empty($cim) && !empty($user['User']['email'])) {
				$cim->setParameter('email', $user['User']['email']);
				$cim->setParameter('description', 'Profile for ' . $user['User']['username']); // Optional
				$cim->setParameter('merchantCustomerId', $user['User']['id']);
				$cim->createCustomerProfile();
				$profile_id = $cim->getProfileID();
				$this->User->updateAll(array(
					'User.cim_profile_id' => $profile_id,
				) , array(
					'User.id' => $user['User']['id']
				));
			}
		}
    }
    function _createCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('billToCompany', Configure::read('site.name'));
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('billToFirstName', $data['firstName']);
            $cim->setParameter('billToLastName', $data['lastName']);
            $cim->setParameter('billToAddress', $data['address']);
            $cim->setParameter('billToCity', $data['city']);
            $cim->setParameter('billToState', $data['state']);
            $cim->setParameter('billToZip', $data['zip']);
            $cim->setParameter('billToCountry', $data['country']);
            $cim->setParameter('cardNumber', $data['creditCardNumber']);
            $cim->setParameter('cardCode', $data['cvv2Number']);
            $cim->setParameter('expirationDate', $data['expirationDate']);
            $cim->createCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                $payment_profile_id = $cim->getPaymentProfileId();
                $profile_info = array_reverse(explode(',', $cim->validationDirectResponse()));
                if (end($profile_info) == 1) {
                    $return['payment_profile_id'] = $payment_profile_id;
                    $return['masked_cc'] = $profile_info[16] . ' ' . $profile_info[17];
                } else {
                    $return = $profile_info[3];
                }
            } else {
                $return['message'] = $cim->getResponse();
            }
            return $return;
        }
        return false;
    }
    function _updateCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('company', Configure::read('site.name'));
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->setParameter('firstName', $data['firstName']);
            $cim->setParameter('lastName', $data['lastName']);
            $cim->setParameter('address', $data['address']);
            $cim->setParameter('city', $data['city']);
            $cim->setParameter('state', $data['state']);
            $cim->setParameter('zip', $data['zip']);
            $cim->setParameter('country', $data['country']);
            $cim->setParameter('cardNumber', $data['creditCardNumber']);
            $cim->setParameter('expirationDate', $data['expirationDate']);
            $cim->updateCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                return true;
            } else {
                $return['message'] = $cim->getResponse();
            }
        }
        return false;
    }
    function _deleteCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->deleteCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                return true;
            }
        }
        return false;
    }
    function _getCimPaymentProfile($data)
    {
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $cim->setParameter('refId', time());
            $cim->setParameter('customerProfileId', $data['customerProfileId']);
            $cim->setParameter('customerPaymentProfileId', $data['customerPaymentProfileId']);
            $cim->getCustomerPaymentProfile();
            if ($cim->isSuccessful()) {
                $return = $cim->getPaymentProfile();
            }
            return $return;
        }
        return false;
    }
    function _createCustomerProfileTransaction($data, $type)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $_SESSION['Auth']['User']['id']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.cim_profile_id',
                    'User.username',
                    'User.email'
                )
            ));
            $cim->setParameter('refId', time());
            $cim->setParameter('amount', $data['Payment']['payment_profile_id']);
            $cim->setParameter('customerProfileId', $user['User']['cim_profile_id']);
            $cim->setParameter('customerPaymentProfileId', $data['Payment']['payment_profile_id']);
            if ($type == 'profileTransAuthOnly') {
                $title = Configure::read('site.name') . ' - Booking Amount Authorized';
                $description = 'Authorize booking amount in ' . Configure::read('site.name');
            } else {
                $title = Configure::read('site.name') . ' - Booked';
                $description = 'Booked in ' . Configure::read('site.name');
            }
            // CIM accept only 30 character in title
            if (strlen($title) > 30) {
                $title = substr($title, 0, 27) . '...';
            }
            $unit_amount = $data['Payment']['amount']/$data['Payment']['quantity'];
            $unit_amount = round($unit_amount, 2);
            $cim->setLineItem($data['Payment']['property_id'], $title, $description, $data['Payment']['quantity'], $unit_amount);
            $cim->createCustomerProfileTransaction($type);
            $response = $cim->getDirectResponse();
            $response_array = explode(',', $response);
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['property_user_id'] = $data['Payment']['property_user_id'];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response_array[32];
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
            $this->User->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
            $get_authorize_id = $this->User->AuthorizenetDocaptureLog->getLastInsertId();
            if ($cim->isSuccessful()) {
                $outputResponse['cim_approval_code'] = $cim->getAuthCode();
                $outputResponse['cim_transaction_id'] = $cim->getTransactionID();
                if ($type == 'profileTransAuthCapture') {
                    $outputResponse['capture'] = 1;
                }
                $outputResponse['pr_authorize_id'] = $get_authorize_id;
            } else {
                $outputResponse['message'] = $cim->getResponse();
            }
            return $outputResponse;
        }
        return false;
    }
    public function _amountFromAuthorizeNet($data)
    {
        App::import('Model', 'User');
        $this->User = new User();
        if (!empty($data['Payment'])) {
            $_tmpData = $data['Payment'];
        } elseif (!empty($data['User'])) {
            $_tmpData = $data['User'];
        }
        $return = array();
        if (!empty($_tmpData)) {
            $cim = $this->_getCimObject();
            if (!empty($cim)) {
				$user_id = !empty($_SESSION['Auth']['User']['id']) ? $_SESSION['Auth']['User']['id'] : $data['User']['id'];
				$user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $user_id,
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.cim_profile_id',
                        'User.username',
                        'User.email'
                    )
                ));
                $cim->setParameter('amount', $_tmpData['amount']);
                $cim->setParameter('refId', time());
                $cim->setParameter('customerProfileId', $user['User']['cim_profile_id']);
                $cim->setParameter('customerPaymentProfileId', $_tmpData['payment_profile_id']);
                if ($_tmpData['from'] == 'wallet') {
                    $title = Configure::read('site.name') . ' - added to wallet';
                    $description = 'Amount added to wallet in ' . Configure::read('site.name');
                } elseif ($_tmpData['from'] == 'verify') {
                    $title = Configure::read('site.name') . ' - property verification fee';
                    $description = 'property verification fee - ' . Configure::read('site.name');
                } elseif ($_tmpData['from'] == 'listing') {
                    $title = Configure::read('site.name') . ' - property listing fee';
                    $description = 'property listing fee - ' . Configure::read('site.name');
                } elseif ($_tmpData['from'] == 'signup') {
                    $title = Configure::read('site.name') . ' - signup fee';
                    $description = 'signup fee - ' . Configure::read('site.name');
                }
                // CIM accept only 30 character in title
                if (strlen($title) > 30) {
                    $title = substr($title, 0, 27) . '...';
                }
                $cim->setLineItem($user_id, $title, $description, 1, $_tmpData['amount']);
                $cim->createCustomerProfileTransaction();
                $response = $cim->getDirectResponse();
                $approval_code = $cim->getAuthCode();
                $response_array = explode(',', $response);
                if (!empty($approval_code) && !empty($response)) {
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response[32];
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['user_id'] = $user_id;
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['property_id'] = !empty($data['Property']['id']) ? $data['Property']['id'] : 0;
                    $this->User->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                    if ($response_array[0] == 1) {
                        $capture = 1;
                    }
                }
                if (!empty($capture)) {
                    // @todo "Registration fee"
                    if ($_tmpData['from'] == 'wallet') {
                        $_data['Transaction']['user_id'] = $_SESSION['Auth']['User']['id'];
                        $_data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                        $_data['Transaction']['class'] = 'SecondUser';
                        $_data['Transaction']['amount'] = $_tmpData['amount'];
                        $_data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                        $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                        $this->User->Transaction->save($_data);
                        $this->User->updateAll(array(
                            'User.available_wallet_amount' => 'User.available_wallet_amount +' . $_tmpData['amount'],
							'User.total_amount_deposited' => 'User.total_amount_deposited +' . $_tmpData['amount']
                        ) , array(
                            'User.id' => $_SESSION['Auth']['User']['id']
                        ));
                    } elseif ($_tmpData['from'] == 'verify') {
                        $_data['Transaction']['foreign_id'] = $data['Property']['id'];
                        $_data['Transaction']['class'] = 'Property';
                        $_data['Transaction']['user_id'] = $_SESSION['Auth']['User']['id'];
                        $_data['Transaction']['amount'] = $_tmpData['amount'];
                        $_data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                        $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyVerifyFee;
                        $this->User->Transaction->create();
                        if ($this->User->Transaction->save($_data)) {
                            $_Data['Property']['id'] = $data['Property']['id'];
                            $_Data['Property']['is_verified'] = 2; // waiting for confirmation
                            $this->User->Property->save($_Data);
                        }
                    } elseif ($_tmpData['from'] == 'signup') {
                        $_data['Transaction']['foreign_id'] = $data['User']['id'];
                        $_data['Transaction']['class'] = 'User';
                        $_data['Transaction']['user_id'] = $data['User']['id'];
                        $_data['Transaction']['amount'] = $_tmpData['amount'];
                        $_data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                        $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::SignupFee;
                        $this->User->Transaction->create();
                        if ($this->User->Transaction->save($_data)) {
                            $_Data['User']['id'] = $data['User']['id'];
                            $_Data['User']['is_paid'] = 1; // waiting for confirmation
                            $_Data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                            $this->User->save($_Data);
                        }
                    } elseif ($_tmpData['from'] == 'listing') {
                        $property = $this->User->Property->find('first', array(
                            'conditions' => array(
                                'Property.id' => $data['Property']['id']
                            ) ,
                            'recursive' => -1
                        ));
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        App::import('Model', 'Message');
                        $this->Message = new Message();
                        $_data['Transaction']['foreign_id'] = $property['Property']['id'];
                        $_data['Transaction']['class'] = 'Property';
                        $_data['Transaction']['user_id'] =$user_id;
                        $_data['Transaction']['amount'] = $_tmpData['amount'];
                        $_data['Transaction']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                        $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyListingFee;
                        $host_username = $user['User']['username'];
                        $host_email = $user['User']['email'];
                        $host_id = $user['User']['id'];
                        $this->User->Transaction->create();
                        if ($this->User->Transaction->save($_data)) {
                            $mail_template = 'New Property Activated';
                            if (!empty($mail_template)) {
                                $template = $this->EmailTemplate->selectTemplate($mail_template);
                                $emailFindReplace = array(
                                    '##USERNAME##' => $host_username,
                                    '##PROPERTY_NAME##' => $property['Property']['title'],
                                    '##PROPERTY_URL##' => Router::url(array(
                                        'controller' => 'properties',
                                        'action' => 'view',
                                        $property['Property']['slug']
                                    ) , true) ,
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
                                $email_message = __l('Your property has been activated');
                                $message = strtr($template['email_content'], $emailFindReplace);
                                $subject = strtr($template['subject'], $emailFindReplace);
                                if (Configure::read('messages.is_send_internal_message') && Configure::read('property.is_auto_approve')) {
                                    $message_id = $this->Message->sendNotifications($host_id, $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                                    if (Configure::read('messages.is_send_email_on_new_message')) {
                                        $content['subject'] = $subject;
                                        $content['message'] = $message;
                                        if (!empty($host_email)) {
                                            $this->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                                        }
                                    }
                                }
                            }
                            $_Data['Property']['id'] = $property['Property']['id'];
                            $_Data['Property']['is_paid'] = 1;
                            $_Data['Property']['is_active'] = 1;
                            $_Data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
                            $this->User->Property->save($_Data);
                        }
                    }
                } else {
                    $return['error_message'] = $response_array[3];
                }
            }
        }
        return $return;
    }
    function _voidProcessOrder($order_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            App::import('Model', 'Property');
            $this->Property = new Property();
            $propertyInfo = $this->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $order_id,
                ) ,
                'contain' => array(
                    'AuthorizenetDocaptureLog' => array(
                        'fields' => array(
                            'AuthorizenetDocaptureLog.id',
                            'AuthorizenetDocaptureLog.authorize_amt',
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.cim_profile_id'
                        )
                    )
                ) ,
                'recursive' => 1,
            ));
            if (empty($propertyInfo)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $cim->setParameter('customerProfileId', $propertyInfo['User']['cim_profile_id']);
            $cim->setParameter('customerPaymentProfileId', $propertyInfo['PropertyUser']['payment_profile_id']);
            $cim->setParameter('transId', $propertyInfo['PropertyUser']['cim_transaction_id']);
            $cim->voidCustomerProfileTransaction();
            if ($cim->isSuccessful()) {
                $return['error'] = 0;
                if (!empty($propertyInfo['AuthorizenetDocaptureLog']['id'])) {
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['id'] = $propertyInfo['AuthorizenetDocaptureLog']['id'];
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Cancelled';
                    $this->Property->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                }
            } else {
                $return['error'] = 1;
            }
            return $return;
        }
        return false;
    }
    function _captureProcessOrder($order_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $cim = $this->_getCimObject();
        if (!empty($cim)) {
            App::import('Model', 'Property');
            $this->Property = new Property();
            $propertyInfo = $this->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $order_id,
                ) ,
                'contain' => array(
                    'AuthorizenetDocaptureLog' => array(
                        'fields' => array(
                            'AuthorizenetDocaptureLog.id',
                            'AuthorizenetDocaptureLog.authorize_amt',
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.cim_profile_id'
                        )
                    )
                ) ,
                'recursive' => 1,
            ));
            if (empty($propertyInfo)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $amount = $propertyInfo['PropertyUser']['price']+$propertyInfo['PropertyUser']['traveler_service_amount']+$propertyInfo['PropertyUser']['security_deposit'];
            $cim->setParameter('refId', time());
            $cim->setParameter('amount', $amount);
            $cim->setParameter('customerProfileId', $propertyInfo['User']['cim_profile_id']);
            $cim->setParameter('customerPaymentProfileId', $propertyInfo['PropertyUser']['payment_profile_id']);
            $cim->setParameter('approvalCode', $propertyInfo['PropertyUser']['cim_approval_code']);
            $title = Configure::read('site.name') . ' - Booking amount captured';
            $description = 'Booking amount captured in ' . Configure::read('site.name');
            // CIM accept only 30 character in title
            if (strlen($title) > 30) {
                $title = substr($title, 0, 27) . '...';
            }
            $days = (strtotime($propertyInfo['PropertyUser']['checkout']) -strtotime($propertyInfo['PropertyUser']['checkin'])) /(60*60*24);
            if ($days == 0) {
                $days = 1;
            } else {
                $days = $days+1;
            }
            $unit_amount = $propertyInfo['PropertyUser']['price']/$days;
            $cim->setLineItem($propertyInfo['PropertyUser']['id'], $title, $description, $days, $unit_amount);
            $cim->createCustomerProfileTransaction('profileTransAuthCapture');
            $response = $cim->getDirectResponse();
            $response_array = explode(',', $response);
            if ($cim->isSuccessful() && $response_array[0] == 1) {
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['id'] = $propertyInfo['AuthorizenetDocaptureLog']['id'];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response[32];
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
                $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
                if (!empty($capture)) {
                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Completed';
                }
                $this->Property->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
            } else {
                $return['error'] = 1;
            }
            return $return;
        }
        return false;
    }
}
?>