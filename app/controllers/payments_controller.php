<?php
class PaymentsController extends AppController
{
    public $name = 'Payments';
    public $uses = array(
        'Payment',
        'PaypalAccount',
        'EmailTemplate',
        'Email',
        'TempPaymentLog',
        'PagseguroTransactionLog',
        'PaymentGateway'
    );
    public $components = array(
        'Email',
        'PagSeguro',
    );
    public $helpers = array(
        'PagSeguro',
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Payment.connect',
            'Payment.contact',
            'Payment.accept',
            'Payment.negotiation_discount',
            'PropertyUser.message',
            'Payment.wallet',
            'Payment.normal',
            'Payment.is_agree_terms_conditions',
            'Payment.payment_gateway_id',
            'Payment.payment_type',
            'Payment.is_show_new_card',
        );
        parent::beforeFilter();
    }
    public function pagseguro_callback()
    {
        $this->loadModel('User');
        $this->loadModel('Property');
        $return_details = $_REQUEST;
        $gateway = array(
            'pagseguro' => ConstPaymentGateways::PagSeguro
        );
        $gateway_id = ConstPaymentGateways::PagSeguro;
        $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $gateway_id
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                if ($paymentGatewaySetting['key'] == 'pagseguro_payee_account') {
                    $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
                if ($paymentGatewaySetting['key'] == 'pagseguro_token') {
                    $token = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                }
            }
        }
        $post_array = $_POST;
        if (empty($_POST)) {
            $this->Session->setFlash(__l('Your transaction has been completed.') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard'
            ));
        }
        if (!empty($post_array) && $post_array['Referencia']) {
            $temp_ary = $this->TempPaymentLog->find('first', array(
                'conditions' => array(
                    'TempPaymentLog.trans_id' => $post_array['Referencia']
                )
            ));
            $transaction_data = $temp_ary['TempPaymentLog'];
        }
        if ($transaction_data['property_id'] != '') {
            $property_name = $this->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $transaction_data['property_id'],
                ) ,
                'fields' => array(
                    'Property.title'
                ) ,
                'recursive' => -1
            ));
        }
        $this->PagSeguro->init(array(
            'pagseguro' => array(
                'email' => $email,
                'token' => $token,
            ) ,
            'format' => array(
                'item_id' => $transaction_data['property_id'],
                'item_descr' => 'Oferta Comprada: ' . $property_name['Property']['title'],
                'item_quant' => $transaction_data['quantity'],
                'item_valor' => $transaction_data['amount_needed'],
            )
        ));
        $allow_to_process = 1;
        $verified = 0;
        $pagseguro_data = $return_details;
        $verificado = $this->PagSeguro->confirm();
        if (!empty($post_array['user_id'])) {
            $userId = $post_array['user_id'];
        } else {
            $userId = $transaction_data['user_id'];
        }
        $transaction_data['buyer_email'] = $post_array['CliEmail'];
        $transaction_data['transaction_id'] = $post_array['TransacaoID'];
        $transaction_data['transaction_date'] = $post_array['DataTransacao'];
        $transaction_data['payment_status'] = $post_array['StatusTransacao'];
        $transaction_data['name'] = $post_array['CliNome'];
        $transaction_data['address'] = $post_array['CliEndereco'];
        $transaction_data['number'] = $post_array['CliNumero'];
        $transaction_data['quarter'] = $post_array['CliBairro'];
        $transaction_data['city'] = $post_array['CliCidade'];
        $transaction_data['state'] = $post_array['CliEstado'];
        $transaction_data['zip'] = $post_array['CliCEP'];
        $transaction_data['phone'] = $post_array['phone'];
        $transaction_data['user_id'] = $userId;
        $transaction_data['payment_type'] = $transaction_data['payment_type'];
        $transaction_data['company_address_id'] = $transaction_data['company_address_id'];
        $transaction_data['payment_method_new'] = $post_array['CliBairro'];
        $transaction_data['transaction_fee'] = ($transaction_data['amount_needed']*$paymentGateway['PaymentGateway']['transaction_fee']) +$paymentGateway['PaymentGateway']['fixed_fee'];
        if ($verificado == 'VERIFICADO') {
            $verified = 1;
            $result = $this->PagSeguro->getDataPayment();
            $log_data = array_merge($pagseguro_data, $transaction_data);
        } elseif ($verificado == 'FALSO') {
            $verified = 0;
            $log_data = array_merge($pagseguro_data, $transaction_data);
        }
        $pagseguro_transaction_log_id = $this->PagseguroTransactionLog->logPagSeguroTransactions($log_data);
        $paystatus = $post_array['StatusTransacao'];
        $transactionID = $post_array['TransacaoID'];
        if (!empty($verified)) {
			$paystatus_to_check = (!empty($paymentGateway['PaymentGateway']['is_test_mode']) ? 'Aguardando Pagto' : 'Aprovado');
            // @todo "Registration fee"
            if ($transaction_data['payment_type'] == 'book') {
                if ($paystatus == $paystatus_to_check) {
                    $this->Payment->processOrderPayment($transaction_data['property_user_id']);
                }
            } elseif ($transaction_data['payment_type'] == 'wallet') {
                if ($paystatus == $paystatus_to_check) {
                    $paid_amount = $transaction_data['amount_needed'];
                    $_data['Transaction']['user_id'] = $transaction_data['user_id'];
                    $_data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                    $_data['Transaction']['class'] = 'SecondUser';
                    $_data['Transaction']['amount'] = $transaction_data['amount_needed'];
                    $_data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                    $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                    if ($this->User->Transaction->save($_data)) {
                        $this->User->updateAll(array(
                            'User.available_wallet_amount' => 'User.available_wallet_amount +' . $transaction_data['amount_needed'],
							'User.total_amount_deposited' => 'User.total_amount_deposited +' . $transaction_data['amount_needed']
                        ) , array(
                            'User.id' => $transaction_data['user_id']
                        ));
                    }
                }
            } elseif ($transaction_data['payment_type'] == 'verification_fee') {
                if ($paystatus == $paystatus_to_check) {
                    $_data['Transaction']['foreign_id'] = $transaction_data['property_id'];
                    $_data['Transaction']['class'] = 'Property';
                    $_data['Transaction']['user_id'] = $transaction_data['user_id'];
                    $_data['Transaction']['amount'] = $transaction_data['amount_needed'];
                    $_data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                    $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyVerifyFee;
                    $this->User->Transaction->create();
                    if ($this->User->Transaction->save($_data)) {
                        $_Data['Property']['id'] = $transaction_data['property_id'];
                        $_Data['Property']['is_verified'] = ConstVerification::WaitingForVerification;
                        $this->User->Property->save($_Data);
                    }
                }
            } elseif ($transaction_data['payment_type'] == 'listing_fee') {
                if ($paystatus == $paystatus_to_check) {
                    $property = $this->User->Property->find('first', array(
                        'conditions' => array(
                            'Property.id' => $transaction_data['property_id']
                        ) ,
                        'contain' => array(
                            'User' => array(
                                'User.id',
                                'User.username',
                                'User.email'
                            )
                        ) ,
                        'recursive' => 0
                    ));
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    App::import('Model', 'Message');
                    $this->Message = new Message();
                    $_data['Transaction']['foreign_id'] = $property['Property']['id'];
                    $_data['Transaction']['class'] = 'Property';
                    $_data['Transaction']['user_id'] = $transaction_data['user_id'];
                    $_data['Transaction']['amount'] = $transaction_data['amount_needed'];
                    $_data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                    $_data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PropertyListingFee;
                    $host_username = $property['User']['username'];
                    $host_email = $property['User']['email'];
                    $host_id = $property['User']['id'];
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
                                        $this->Payment->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
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
            }
        }
		$this->autoRender = false;
    }
    public function property_verify_now($property_id = null)
    {
        if (!Configure::read('property.is_property_verification_enabled')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Property');
        $this->loadModel('User');
        if (!empty($this->request->data['Property']['id'])) {
            $property_id = $this->request->data['Property']['id'];
        }
        if (is_null($property_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $Property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
                'Property.is_verified = ' => null,
            ) ,
            'contain' => array(
                'Attachment',
                'Country',
                'User'
            ) ,
            'recursive' => 2,
        ));
        if (empty($Property) || (!empty($Property) && $Property['Property']['user_id'] != $this->Auth->user('id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Pay Verification Fee - ') . $Property['Property']['title'];
        if (Configure::read('property.verify_fee') > 0) {
            $total_amount = Configure::read('property.verify_fee');
            $total_amount = round($total_amount, 2);
            if (!empty($this->request->data)) {
                $gateway_options = array();
                if (($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['Payment']['payment_profile_id']) && empty($this->request->data['Payment']['payment_profile_id']))) {
                    $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
                    if ($this->request->data['Payment']['is_show_new_card'] == 0) {
                        $payment_gateway_id_validate = array(
                            'payment_profile_id' => array(
                                'rule1' => array(
                                    'rule' => 'notempty',
                                    'message' => __l('Required')
                                )
                            )
                        );
                        $this->Payment->validate = array_merge($this->Payment->validate, $payment_gateway_id_validate);
                    }
                } else if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['Payment']['payment_profile_id']))) {
                    $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
                }
                $this->request->data['Payment']['payment_type_id'] = $this->request->data['Payment']['payment_gateway_id'];
                $this->Payment->set($this->request->data);
                if (!$this->Payment->validates()) {
                    $this->Session->setFlash(__l('Please enter proper credit card details') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'property_verify_now',
                        $this->request->data['Property']['id'],
                        'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                    ));
                }
                if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($this->request->data['Payment']['creditCardNumber'])) {
                        $user = $this->Property->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        //create payment profile
                        $data = $this->request->data['Payment'];
                        $data['expirationDate'] = $this->request->data['expDateYear']['year'] . '-' . $this->request->data['expDateMonth']['month'];
                        $data['customerProfileId'] = $user['User']['cim_profile_id'];
                        $payment_profile_id = $this->Payment->_createCimPaymentProfile($data);
                        if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                            $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                            $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                            $payment['UserPaymentProfile']['is_default'] = 0;
                            $this->Property->User->UserPaymentProfile->save($payment);
                            $this->request->data['Payment']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                        } else {
                            $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'payments',
                                'action' => 'property_verify_now',
                                $this->request->data['Property']['id'],
                                'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                            ));
                        }
                    }
                    if (!empty($this->request->data['Payment']['payment_profile_id'])) {
                        $this->request->data['Payment']['from'] = 'verify';
                        $this->request->data['Payment']['amount'] = $total_amount;
                        $return = $this->Payment->_amountFromAuthorizeNet($this->request->data);
                        if (empty($return['error_message'])) {
                            $this->Session->setFlash(__l('Property verification fee payment has done successfully and property successfully submitted for verification.') , 'default', null, 'success');
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'index',
                                'type' => 'myproperties',
                            ));
                        } else {
                            $return['error_message'].= '. ';
                            $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed') , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'payments',
                                'action' => 'property_verify_now',
                                $this->request->data['Property']['id'],
                                'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                            ));
                        }
                    } else {
                        $this->Session->setFlash(__l('Your payment could not be completed') , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'payments',
                            'action' => 'property_verify_now',
                            $this->request->data['Property']['id'],
                            'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                        ));
                    }
                } elseif (!empty($this->request->data['Payment']['payment_type_id']) && ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet || $this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PayPal)) {
                    if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet) {
                        $user = $this->Property->User->find('first', array(
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
                        if (empty($user)) {
                            throw new NotFoundException(__l('Invalid request'));
                        }
                        if ($user['User']['available_wallet_amount'] < ($total_amount)) {
                            $this->Session->setFlash(__l('Your wallet has insufficient money') , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'payments',
                                'action' => 'property_verify_now',
                                $this->request->data['Property']['id'],
                                'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                            ));
                        }
                    }
                    $data['property_id'] = $this->request->data['Property']['id'];
                    $data['payment_gateway_id'] = $this->request->data['Payment']['payment_gateway_id'];
                    $data['payment_type_id'] = $this->request->data['Payment']['payment_gateway_id'];
                    $data['amount'] = $total_amount;
                    $data['from'] = 'verify';
                    $return = $this->Payment->payProperty($data);
                    if (!empty($return['error'])) {
                        $this->Session->setFlash(__l('Payment could not be completed.') , 'default', null, 'error');
                    } else {
                        if (!empty($this->request->data['Payment']['user_paypal_connection_id']) || ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet)) {
                            $this->Session->setFlash(__l('Property verification fee payment has done successfully and property successfully submitted for verification.') , 'default', null, 'success');
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'index',
                                'type' => 'myproperties',
                            ));
                        }
                    }
                } else if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PagSeguro) {
                    $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                        'conditions' => array(
                            'PaymentGateway.id' => $this->request->data['Payment']['payment_type_id'],
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
                    $amount_user = $total_amount;
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
                            'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                            'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                            'encode' => 'utf-8'
                            // Especifica o encode n�o implementado

                        ) ,
                        'format' => array(
                            'item_id' => $this->Auth->user('id') ,
                            'item_descr' => __l('Property Verification Fee'),
                            'item_quant' => '1',
                            'item_valor' => $user_amount,
                            'item_frete' => '0',
                            'item_peso' => '20'
                        ) ,
                        'customer_info'
                    );
                    $transaction_data['TempPaymentLog'] = array(
                        'trans_id' => $ref,
                        'payment_type' => 'verification_fee',
                        'user_id' => $this->Auth->user('id') ,
                        // @todo "IP table logic"
                        'ip' => $this->RequestHandler->getClientIP() ,
                        'amount_needed' => $total_amount,
                        'property_id' => $this->request->data['Property']['id'],
                        'payment_gateway_id' => $this->request->data['Payment']['payment_type_id'],
                        'currency_code' => 'BRL',
                    );
                    $this->TempPaymentLog->save($transaction_data);
                    $this->set('gateway_options', $gateway_options);
                    $this->set('action', $action);
                    $this->set('amount', $total_amount);
                    $this->autoRender = false;
                    $this->layout = 'redirect_page';
                    $this->render('do_payment');
                }
            } else {
                $this->request->data = $Property;
            }
            $this->set('total_amount', $total_amount);
        } else {
            $_Data['Property']['id'] = $Property['Property']['id'];
            $_Data['Property']['is_verified'] = ConstVerification::WaitingForVerification;
            $_Data['Property']['user_id'] = $Property['Property']['user_id'];
            $_Data['Property']['name'] = $Property['Property']['title'];
            $this->Property->save($_Data);
            $this->Session->setFlash(__l('Your property has been successfully verified') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'view',
                $Property['Property']['slug'],
                'admin' => false
            ));
        }
        $user_info = $this->Property->User->find('first', array(
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
        $this->set('itemDetail', $Property);
        $this->set('user_info', $user_info);
        if (!empty($this->request->params['named']['payment_gateway_id'])) {
            $this->request->data['Payment']['payment_gateway_id'] = $this->request->params['named']['payment_gateway_id'];
        }
        $payment_options = $this->Payment->getGatewayTypes('is_enable_for_property_verified_fee');
        if (empty($this->request->data['Payment']['payment_gateway_id'])) {
            if (!empty($payment_options[ConstPaymentGateways::PayPal])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
            } elseif (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
            } elseif (!empty($payment_options[ConstPaymentGateways::PagSeguro])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
            }
        }
        $gateway_options['paymentGateways'] = $payment_options;
        $gateway_options['countries'] = $this->Property->User->UserProfile->Country->find('list', array(
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
        $Paymentprofiles = $this->Property->User->UserPaymentProfile->find('all', array(
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
                $this->request->data['Payment']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
            }
        }
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->request->data['Payment']['is_show_new_card'] = 1;
        }
        $states = $this->Property->User->UserProfile->State->find('list', array(
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
        $this->request->data['Payment']['cvv2Number'] = $this->request->data['Payment']['creditCardNumber'] = '';
    }
    public function property_pay_now($property_id = null)
    {
        $this->pageTitle = __l('Pay Now');
        $this->loadModel('Property');
        $this->loadModel('User');
        $gateway_options = array();
        if (!empty($this->request->data['Property']['id'])) {
            $property_id = $this->request->data['Property']['id'];
        }
        if (is_null($property_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $Property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
            ) ,
            'contain' => array(
                'Attachment',
                'User',
                'Country' => array(
                    'fields' => array(
                        'Country.name',
                        'Country.iso2'
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        if (empty($Property) || (!empty($Property) && $Property['Property']['user_id'] != $this->Auth->user('id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Pay Listing Fee - ') . $Property['Property']['title'];
        $total_amount = Configure::read('property.listing_fee');
        $total_amount = round($total_amount, 2);
        if (!empty($this->request->data)) {
            if (($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['Payment']['payment_profile_id']) && empty($this->request->data['Payment']['payment_profile_id']))) {
                $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
                if ($this->request->data['Payment']['is_show_new_card'] == 0) {
                    $payment_gateway_id_validate = array(
                        'payment_profile_id' => array(
                            'rule1' => array(
                                'rule' => 'notempty',
                                'message' => __l('Required')
                            )
                        )
                    );
                    $this->Payment->validate = array_merge($this->Payment->validate, $payment_gateway_id_validate);
                }
            } else if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['Payment']['payment_profile_id']))) {
                $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
            }
            $this->request->data['Payment']['payment_type_id'] = $this->request->data['Payment']['payment_gateway_id'];
            $this->Payment->set($this->request->data);
            if (!$this->Payment->validates()) {
                $this->Session->setFlash(__l('Please enter proper credit card details') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'payments',
                    'action' => 'property_pay_now',
                    $this->request->data['Property']['id'],
                    'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                ));
            }
            if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                if (!empty($this->request->data['Payment']['creditCardNumber'])) {
                    $user = $this->Property->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $this->Auth->user('id')
                        ) ,
                        'fields' => array(
                            'User.id',
                            'User.cim_profile_id'
                        )
                    ));
                    //create payment profile
                    $data = $this->request->data['Payment'];
                    $data['expirationDate'] = $this->request->data['expDateYear']['year'] . '-' . $this->request->data['expDateMonth']['month'];
                    $data['customerProfileId'] = $user['User']['cim_profile_id'];
                    $payment_profile_id = $this->Payment->_createCimPaymentProfile($data);
                    if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                        $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                        $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                        $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                        $payment['UserPaymentProfile']['is_default'] = 0;
                        $this->Property->User->UserPaymentProfile->save($payment);
                        $this->request->data['Payment']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                    } else {
                        $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'payments',
                            'action' => 'property_pay_now',
                            $this->request->data['Property']['id'],
                            'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                        ));
                    }
                }
                if (!empty($this->request->data['Payment']['payment_profile_id'])) {
                    $this->request->data['Payment']['from'] = 'listing';
                    $this->request->data['Payment']['amount'] = $total_amount;
                    $return = $this->Payment->_amountFromAuthorizeNet($this->request->data);
                    if (empty($return['error_message'])) {
                        $property = $this->Property->find('first', array(
                            'conditions' => array(
                                'Property.id' => $this->request->data['Property']['id']
                            ) ,
                            'recursive' => -1
                        ));
                        if (Configure::read('property.is_auto_approve')) {
                            $this->Session->setFlash(__l('Property listing fee payment has done and property has been listed successfully.') , 'default', null, 'success');
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'update_social_networking',
                                'property_id' => $this->request->data['Property']['id'],
                                'admin' => false
                            ));
                        } else {
                            $this->Session->setFlash(__l('Property listing fee payment has done and property will be listed after admin approve') , 'default', null, 'success');
                        }
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'view',
                            $property['Property']['slug']
                        ));
                    } else {
                        $return['error_message'].= '. ';
                        $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed') , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'payments',
                            'action' => 'property_pay_now',
                            $this->request->data['Property']['id'],
                            'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                        ));
                    }
                } else {
                    $this->Session->setFlash(__l('Your payment could not be completed') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'property_pay_now',
                        $this->request->data['Property']['id'],
                        'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                    ));
                }
            } elseif (!empty($this->request->data['Payment']['payment_type_id']) && ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet || $this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PayPal)) {
                if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet) {
                    $user = $this->Property->User->find('first', array(
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
                    if (empty($user)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if ($user['User']['available_wallet_amount'] < ($total_amount)) {
                        $this->Session->setFlash(__l('Your wallet has insufficient money') , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'payments',
                            'action' => 'property_pay_now',
                            $this->request->data['Property']['id'],
                            'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
                        ));
                    }
                }
                $data['property_id'] = $this->request->data['Property']['id'];
                $data['payment_gateway_id'] = $this->request->data['Payment']['payment_gateway_id'];
                $data['payment_type_id'] = $this->request->data['Payment']['payment_type_id'];
                $data['amount'] = $total_amount;
                $data['from'] = 'listing_fee';
                $return = $this->Payment->payProperty($data);
                if (!empty($return['error'])) {
                    $this->Session->setFlash(__l('Payment could not be completed.') , 'default', null, 'error');
                } else {
                    if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet) {
                        $property = $this->Property->find('first', array(
                            'conditions' => array(
                                'Property.id' => $this->request->data['Property']['id']
                            ) ,
                            'recursive' => -1
                        ));
                        if (Configure::read('property.is_auto_approve')) {
                            $this->Session->setFlash(__l('Property listing fee payment has done and property has been listed successfully.') , 'default', null, 'success');
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'update_social_networking',
                                'property_id' => $this->request->data['Property']['id'],
                                'admin' => false
                            ));
                        } else {
                            $this->Session->setFlash(__l('Property listing fee payment has done and property will be listed after admin approve') , 'default', null, 'success');
                        }
                        $this->redirect(array(
                            'controller' => 'properties',
                            'action' => 'view',
                            $property['Property']['slug']
                        ));
                    }
                }
            } else if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PagSeguro) {
                $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => $this->request->data['Payment']['payment_type_id'],
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
                $amount_user = $total_amount;
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
                        'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                        'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                        'encode' => 'utf-8'
                        // Especifica o encode n�o implementado

                    ) ,
                    'format' => array(
                        'item_id' => $this->Auth->user('id') ,
                        'item_descr' => __l('Property Listing Fee'),
                        'item_quant' => '1',
                        'item_valor' => $user_amount,
                        'item_frete' => '0',
                        'item_peso' => '20'
                    ) ,
                    'customer_info'
                );
                $transaction_data['TempPaymentLog'] = array(
                    'trans_id' => $ref,
                    'payment_type' => 'listing_fee',
                    'user_id' => $this->Auth->user('id') ,
                    // @todo "IP table logic"
                    'ip' => $this->RequestHandler->getClientIP() ,
                    'amount_needed' => $total_amount,
                    'property_id' => $this->request->data['Property']['id'],
                    'payment_gateway_id' => $this->request->data['Payment']['payment_type_id'],
                    'currency_code' => 'BRL',
                );
                $this->TempPaymentLog->save($transaction_data);
                //$this->Session->write('transaction_data',$transaction_data);
                $this->set('gateway_options', $gateway_options);
                $this->set('action', $action);
                $this->set('amount', $total_amount);
                $this->autoRender = false;
                $this->layout = 'redirect_page';
                $this->render('do_payment');
            }
        } else {
            $this->request->data = $Property;
        }
        $this->set('total_amount', $total_amount);
        $user_info = $this->Property->User->find('first', array(
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
        $this->set('Property', $Property);
        $this->set('user_info', $user_info);
        if (!empty($this->request->params['named']['payment_gateway_id'])) {
            $this->request->data['Payment']['payment_gateway_id'] = $this->request->params['named']['payment_gateway_id'];
        }
        $payment_options = $this->Payment->getGatewayTypes('is_enable_for_property_listing_fee');
        if (empty($this->request->data['Payment']['payment_gateway_id'])) {
            if (!empty($payment_options[ConstPaymentGateways::PayPal])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
            } elseif (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
            } elseif (!empty($payment_options[ConstPaymentGateways::PagSeguro])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
            }
        }
        $gateway_options['paymentGateways'] = $payment_options;
        $gateway_options['countries'] = $this->Property->User->UserProfile->Country->find('list', array(
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
        $Paymentprofiles = $this->Property->User->UserPaymentProfile->find('all', array(
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
                $this->request->data['Payment']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
            }
        }
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->request->data['Payment']['is_show_new_card'] = 1;
        }
        $states = $this->Property->User->UserProfile->State->find('list', array(
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
        $this->request->data['Payment']['cvv2Number'] = $this->request->data['Payment']['creditCardNumber'] = '';
    }
    public function membership_pay_now($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Membership Fee');
        $this->loadModel('User');
        $gateway_options = array();
        if (!empty($this->request->data['User']['id'])) {
            $user_id = $this->request->data['User']['id'];
        }
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		if ($this->User->isValidActivateHash($user_id, $hash)) {
        $User = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_paid' => 0,
            ) ,
            'recursive' => -1,
        ));
        if (empty($User)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Pay Membership Fee - ') . $User['User']['username'];
        $total_amount = Configure::read('user.signup_fee');
        $total_amount = round($total_amount, 2);
        if (!empty($this->request->data)) {
            if (($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['Payment']['payment_profile_id']) && empty($this->request->data['Payment']['payment_profile_id']))) {
                $this->Payment->validate = array_merge($this->Payment->validate, $this->User->validateCreditCard);
                if ($this->request->data['Payment']['is_show_new_card'] == 0) {
                    $payment_gateway_id_validate = array(
                        'payment_profile_id' => array(
                            'rule1' => array(
                                'rule' => 'notempty',
                                'message' => __l('Required')
                            )
                        ));
                        $this->Payment->validate = array_merge($this->Payment->validate, $payment_gateway_id_validate);
                    }
                } else if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['Payment']['payment_profile_id']))) {
                    $this->Payment->validate = array_merge($this->Payment->validate, $this->User->validateCreditCard);
                }
                $this->request->data['Payment']['payment_type_id'] = $this->request->data['Payment']['payment_gateway_id'];
                $this->Payment->set($this->request->data);
                if (!$this->Payment->validates()) {
                    $this->Session->setFlash(__l('Please enter proper credit card details') , 'default', null, 'error');
					$error = 1;
                }
				if (empty($error)) {
					if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
						if (!empty($this->request->data['Payment']['creditCardNumber'])) {
							$user = $this->User->find('first', array(
								'conditions' => array(
									'User.id' => $this->request->data['User']['id']
								) ,
								'fields' => array(
									'User.id',
									'User.cim_profile_id'
								)
							));
							//create payment profile
							$data = $this->request->data['Payment'];
							$data['expirationDate'] = $this->request->data['expDateYear']['year'] . '-' . $this->request->data['expDateMonth']['month'];
							$data['customerProfileId'] = $user['User']['cim_profile_id'];
							$payment_profile_id = $this->Payment->_createCimPaymentProfile($data);
							if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
								$payment['UserPaymentProfile']['user_id'] = $this->request->data['User']['id'];
								$payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
								$payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
								$payment['UserPaymentProfile']['is_default'] = 0;
								$this->User->UserPaymentProfile->save($payment);
								$this->request->data['Payment']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
							} else {
								$this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
								$this->redirect(array(
									'controller' => 'payments',
									'action' => 'membership_pay_now',
									$this->request->data['User']['id'],
									'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
								));
							}
						}
						if (!empty($this->request->data['Payment']['payment_profile_id'])) {
							$this->request->data['Payment']['from'] = 'signup';
							$this->request->data['Payment']['amount'] = $total_amount;
							$return = $this->Payment->_amountFromAuthorizeNet($this->request->data);
							if (empty($return['error_message'])) {
								$user = $this->User->find('first', array(
									'conditions' => array(
										'User.id' => $this->request->data['User']['id']
									) ,
									'recursive' => -1
								));
								if (Configure::read('user.is_admin_activate_after_register')) {
									$this->Session->setFlash(__l('You have paid membership fee successfully, will be activated once administrator approved') , 'default', null, 'success');
								} else {
									if($user['User']['is_email_confirmed'])
									{
										 $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
									}
									else
									{
										 $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s after verified your email') , Configure::read('user.using_to_login')) , 'default', null, 'success');
									}
								}
								$this->redirect(array(
									'controller' => 'users',
									'action' => 'login',
								));
							} else {
								$return['error_message'].= '. ';
								$this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed') , 'default', null, 'error');
								$this->redirect(array(
									'controller' => 'payments',
									'action' => 'membership_pay_now',
									$this->request->data['User']['id'],
									'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
								));
							}
						} else {
							$this->Session->setFlash(__l('Your payment could not be completed') , 'default', null, 'error');
							$this->redirect(array(
								'controller' => 'payments',
								'action' => 'membership_pay_now',
								$this->request->data['User']['id'],
								'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id']
							));
						}
					} elseif (!empty($this->request->data['Payment']['payment_type_id']) && ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PayPal)) {
						$data['user_id'] = $this->request->data['User']['id'];
						$data['payment_gateway_id'] = $this->request->data['Payment']['payment_gateway_id'];
						$data['payment_type_id'] = $this->request->data['Payment']['payment_type_id'];
						$data['amount'] = $total_amount;
						$data['from'] = 'signup_fee';
						$return = $this->Payment->payUser($data);
						if (!empty($return['error'])) {
							$return['error_message'].= '. ';
							$this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
						}
					} else if ($this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::PagSeguro) {
						$paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
							'conditions' => array(
								'PaymentGateway.id' => $this->request->data['Payment']['payment_type_id'],
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
						$amount_user = $total_amount;
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
								'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
								'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
								'encode' => 'utf-8'
								// Especifica o encode n�o implementado

							) ,
							'format' => array(
								'item_id' => $this->request->data['User']['id'],
								'item_descr' => __l('Signup Fee'),
								'item_quant' => '1',
								'item_valor' => $user_amount,
								'item_frete' => '0',
								'item_peso' => '20'
							) ,
							'customer_info'
						);
						$transaction_data['TempPaymentLog'] = array(
							'trans_id' => $ref,
							'payment_type' => 'signup_fee',
							'user_id' => $this->request->data['User']['id'],
							// @todo "IP table logic"
							'ip' => $this->RequestHandler->getClientIP() ,
							'amount_needed' => $total_amount,
							'user_id' => $this->request->data['User']['id'],
							'payment_gateway_id' => $this->request->data['Payment']['payment_type_id'],
							'currency_code' => 'BRL',
						);
						$this->TempPaymentLog->save($transaction_data);
						//$this->Session->write('transaction_data',$transaction_data);
						$this->set('gateway_options', $gateway_options);
						$this->set('action', $action);
						$this->set('amount', $total_amount);
						$this->autoRender = false;
						$this->layout = 'redirect_page';
						$this->render('do_payment');
					}
				}
            } else {
                $this->request->data = $User;
            }
            $this->set('total_amount', $total_amount);
            if (!empty($this->request->params['named']['payment_gateway_id'])) {
                $this->request->data['Payment']['payment_gateway_id'] = $this->request->params['named']['payment_gateway_id'];
            }
            $payment_options = $this->Payment->getGatewayTypes('is_enable_for_signup_fee');
            if (empty($this->request->data['Payment']['payment_gateway_id'])) {
                if (!empty($payment_options[ConstPaymentGateways::PayPal])) {
                    $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
                } elseif (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                    $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                } elseif (!empty($payment_options[ConstPaymentGateways::PagSeguro])) {
                    $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
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
                    'UserPaymentProfile.user_id' => $User['User']['id']
                ) ,
            ));
            foreach($Paymentprofiles as $pay_profile) {
                $gateway_options['Paymentprofiles'][$pay_profile['UserPaymentProfile']['cim_payment_profile_id']] = $pay_profile['UserPaymentProfile']['masked_cc'];
                if ($pay_profile['UserPaymentProfile']['is_default']) {
                    $this->request->data['Payment']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
                }
            }
            if (empty($gateway_options['Paymentprofiles'])) {
                $this->request->data['Payment']['is_show_new_card'] = 1;
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
            $this->set('User', $User);
            $this->set('states', $states);
            $this->set('gateway_options', $gateway_options);
            $this->request->data['Payment']['cvv2Number'] = $this->request->data['Payment']['creditCardNumber'] = '';
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function processpropertypayment($property_id, $view)
    {
        $this->Payment->processPropertyPayment($property_id, $view);
        $this->autoRender = false;
    }
    public function process_user_payment($user_id)
    {
        $this->Payment->processUserSignupPayment($user_id);
        $this->autoRender = false;
    }
    public function success_propertypayment($property_id, $view)
    {
        $this->loadModel('Property');
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
            ) ,
            'fields' => array(
                'Property.id',
                'Property.title',
                'Property.slug',
                'Property.admin_suspend',
                'Property.is_paid',
                'Property.is_verified',
            ) ,
            'recursive' => -1,
        ));
        $this->Payment->processPropertyPayment($property_id, $view);
        if ($property['Property']['admin_suspend']) {
            $this->Session->setFlash(__l('Property has been suspended, due to some bad words. Admin will unsuspend your property') , 'default', null, 'error');
            $redirect = Router::url(array(
                'controller' => 'users',
                'action' => 'dashboard',
                'admin' => false
            ) , true);
        } else {
            if ($view == 'listing_fee') {
                if (!Configure::read('property.is_auto_approve')) {
                    $this->Session->setFlash(__l('Property has been added but after admin approval it will list out in site') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('Payment has been successfully completed. Now your property has been listed.') , 'default', null, 'success');
                    $redirect = Router::url(array(
                        'action' => 'update_social_networking',
                        'property_id' => $property_id,
                        'admin' => false
                    ) , true);
                }
            } else if ($view == 'verify') {
                $this->Session->setFlash(__l('Property verification fee payment has done successfully and property successfully submitted for verification.') , 'default', null, 'success');
            }
            $redirect = Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                $property['Property']['slug'],
                'admin' => false
            ) , true);
        }
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('success_order');
        } else {
            $this->redirect($redirect);
        }
    }
    public function cancel_propertypayment($property_id)
    {
        $this->Session->setFlash(__l('Payment Failed. Please, try again') , 'default', null, 'error');
        $this->loadModel('Property');
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
            ) ,
            'fields' => array(
                'Property.id',
                'Property.title',
                'Property.slug',
            ) ,
            'recursive' => -1,
        ));
        $redirect = Router::url(array(
            'controller' => 'properties',
            'action' => 'view',
            $property['Property']['slug']
        ) , true);
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('cancel_order');
        } else {
            $this->redirect($redirect);
        }
    }
    public function success_user_payment($user_id)
    {
        $this->loadModel('User');
        $User = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $user_id,
            ) ,
            'recursive' => -1,
        ));
        $this->Payment->processUserSignupPayment($user_id);
		if (Configure::read('user.is_admin_activate_after_register')) {
			$this->Session->setFlash(__l('You have paid membership fee successfully, will be activated once administrator approved') , 'default', null, 'success');
		} else {
			if(!empty($user) && $user['User']['is_email_confirmed'])
			{
				 $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
			}
			else
			{
				 $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s after verified your email') , Configure::read('user.using_to_login')) , 'default', null, 'success');
			}
		}
        $redirect = Router::url(array(
            'controller' => 'users',
            'action' => 'login',
            'admin' => false
        ) , true);
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('success_order');
        } else {
            $this->redirect($redirect);
        }
    }
    public function cancel_user_payment($user_id)
    {
        $this->Session->setFlash(__l('Payment Failed. Please, try again') , 'default', null, 'error');
        $redirect = Router::url(array(
            'controller' => 'users',
            'action' => 'register',
        ) , true);
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('cancel_order');
        } else {
            $this->redirect($redirect);
        }
    }






    public function order($id = null, $type = 'property', $gateway = null)
    {
        $this->loadModel('Property');
        $this->loadModel('User');
        $gateway_options = array();
        //checking property booked on specic date
        if (!empty($this->request->params['named']['order_id']) && empty($this->request->params['named']['type'])) {
            $property = $this->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $id
                ) ,
                'fields' => array(
                    'Property.id',
                    'Property.additional_guest',
                    'Property.additional_guest_price',
                    'Property.user_id',
                    'Property.slug',
                    'Property.join_or_item_value',
                    'Property.fee_client',
                    'Property.fee_provider',
                ) ,
                'recursive' => -1
            ));
            $propertyUser = $this->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $this->request->params['named']['order_id']
                ) ,
                'recursive' => -1
            ));
            //already booked or not conditions
            $checkin = $propertyUser['PropertyUser']['checkin'];
            $checkout = $propertyUser['PropertyUser']['checkout'];
            $booking_conditions['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived
            );
            $booking_conditions['PropertyUser.property_id'] = $id;
            $booking_conditions['PropertyUser.checkin >='] = $checkin;
            $booking_conditions['OR']['PropertyUser.checkout <='] = $checkout;
            $booking_list = $this->Property->PropertyUser->find('list', array(
                'conditions' => $booking_conditions,
                'fields' => array(
                    'PropertyUser.id',
                    'PropertyUser.property_id'
                ) ,
                'recursive' => -1
            ));
            $custom_conditions['CustomPricePerNight.is_available'] = ConstPropertyStatus::NotAvailable;
            $custom_conditions['CustomPricePerNight.property_id'] = $id;
            $custom_conditions['CustomPricePerNight.start_date >='] = $checkin;
            $custom_conditions['OR']['CustomPricePerNight.end_date <='] = $checkout;
            $not_available_list = $this->Property->CustomPricePerNight->find('list', array(
                'conditions' => $custom_conditions,
                'fields' => array(
                    'CustomPricePerNight.id',
                    'CustomPricePerNight.property_id'
                ) ,
                'recursive' => -1
            ));
            $booking_list = array_merge($booking_list, $not_available_list);
            $booked_ids = array();
            if (count($booking_list) > 0) {
                foreach($booking_list as $booking) {
                    $booked_ids[] = $booking;
                }
            }
            //booked this property already
            /* quito limitacion para aceptar varios join el mismo dia
			 * 
			 * */
			 // Ahora tengo que evaluar si es una property dejar la limitacion
		if($property['Property']['join_or_item_value'] == 'prop'){
            if (count($booked_ids) > 0) {
                $this->Session->setFlash(__l('Property booked by some other user. Please, try for some other dates.') , 'default', null, 'error');
				if (!empty($this->request->params['named']['request_id'])) {
					$PropertiesRequest = $this->Property->PropertiesRequest->find('first', array(
                        'conditions' => array(
                            'PropertiesRequest.request_id' => $this->request->params['named']['request_id'],
							'PropertiesRequest.property_id' => $id,
                        ) ,
                        'fields' => array(
                            'PropertiesRequest.id',
                        ) ,
                        'recursive' => -1
                    ));
					if (!empty($PropertiesRequest)) {
						$this->PropertiesRequest->delete($PropertiesRequest['PropertiesRequest']['id']);
						$this->redirect(array(
							'controller' => 'requests',
							'action' => 'index',
							'type'=> 'myrequest'
						));
					}
				} else {
					$this->redirect(array(
						'controller' => 'properties',
						'action' => 'view',
						$property['Property']['slug']
					));
				}
            }
        }
	}
	 
        if (!empty($this->request->data)) {
            $id = $this->request->data['Payment']['item_id'];
            $is_error = 0;
            if (!empty($this->request->data['Payment']['normal'])) {
                unset($this->request->data['Payment']['user_paypal_connection_id']);
            }
            if (!empty($this->request->data['Payment']['contact'])) {
                if (!$this->Auth->user('id')) {
                    $property = $this->Property->find('first', array(
                        'conditions' => array(
                            'Property.id' => $this->request->data['Payment']['item_id']
                        ) ,
                        'fields' => array(
                            'Property.price_per_night',
                            'Property.slug',
                            'Property.slug',
                            'Property.id',
                            'Property.user_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $valid = $this->process_user($property);
                    if (!$valid) {
                        $is_error = 1;
                        $error_message = __l('Oops, problems in registration, please try again or later');
                    }
                    $_data['PropertyUser']['user_id'] = $this->Auth->user('id');
                }
                $_data['PropertyUser']['is_negotiation_requested'] = 1;
                $_data['PropertyUser']['id'] = $this->request->data['Payment']['order_id'];
                $this->Property->PropertyUser->save($_data, false);
                $propertyUser = $this->Property->PropertyUser->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $this->request->data['Payment']['order_id']
                    ) ,
                    'contain' => array(
                        'Property' => array(
                            'User'
                        ) ,
                    ) ,
                    'recursive' => 2
                ));

                $message_sender_user_id = $propertyUser['Property']['user_id'];
                $host_email = $propertyUser['Property']['User']['email'];
                $subject = 'Negotiation Conversation';
				$from_id = $this->request->data['PropertyUser']['from_id'];
                $message = $this->request->data['PropertyUser']['message'];
                $property_id = $propertyUser['Property']['id'];
                $order_id = $this->request->data['Payment']['order_id'];
                $message_id = $this->Property->PropertyUser->Message->sendNotifications($from_id, $subject, $message, $order_id, $is_review = 0, $property_id, ConstPropertyUserStatus::NegotiateConversation,'null', $from_id);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $content['subject'] = $subject;
                    $content['message'] = $message;
                    if (!empty($host_email)) {
                        $this->Payment->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                    }
                }
                $this->Session->setFlash(__l('Your request has been sent') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'property_users',
                    'action' => 'index',
                    'type' => 'mytours',
                    'status' => 'negotiation',
                    'view' => 'list'
                ));
            }
            if (!empty($this->request->data['Payment']['accept'])) {
                $this->request->data['PropertyUser']['is_negotiation_requested'] = 1;
                $this->request->data['PropertyUser']['id'] = $this->request->data['Payment']['order_id'];
                $this->request->data['PropertyUser']['negotiation_discount'] = $this->request->data['Payment']['negotiation_discount'];
                $this->request->data['PropertyUser']['is_negotiated'] = $this->request->data['Payment']['is_negotiated'];
                $this->Payment->set($this->request->data);
                if ($this->Payment->validates()) {
                    $this->Property->PropertyUser->save($this->request->data['PropertyUser'], false);
                    $this->Session->setFlash(__l('You successfully confirmed the Traveler request') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'property_users',
                        'action' => 'index',
                        'type' => 'myworks',
                        'status' => 'waiting_for_acceptance'
                    ));
                } else {
                    $this->Session->setFlash(__l('You request not processed successfully') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'order',
                        $id,
                        'order_id' => $this->request->data['Payment']['order_id'],
                        'type' => __l('accept') ,
                    ));
                }
            } else {
                if (!empty($this->request->data['Payment']['payment_gateway_id']) && ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['Payment']['payment_profile_id']) && empty($this->request->data['Payment']['payment_profile_id']))) {
                    $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
                    if ($this->request->data['Payment']['is_show_new_card'] == 0) {
                        $payment_gateway_id_validate = array(
                            'payment_profile_id' => array(
                                'rule1' => array(
                                    'rule' => 'notempty',
                                    'message' => __l('Required')
                                )
                            )
                        );
                        $this->Payment->validate = array_merge($this->Payment->validate, $payment_gateway_id_validate);
                    }
                } else if (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['Payment']['payment_profile_id']))) {
                    $this->Payment->validate = array_merge($this->Payment->validate, $this->Property->User->validateCreditCard);
                } else if (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                    $paymentGateway = $this->User->Transaction->PaymentGateway->find('first', array(
                        'conditions' => array(
                            'PaymentGateway.id' => $this->request->data['Payment']['payment_gateway_id'],
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
                    //amount calculation
                    $propertyUser = $this->Property->PropertyUser->find('first', array(
                        'conditions' => array(
                            'PropertyUser.property_id' => $this->request->data['Payment']['item_id'],
                            'PropertyUser.id' => $this->request->data['Payment']['order_id'],
                        ) ,
                        'recursive' => -1
                    ));
                    $amount_user = $propertyUser['PropertyUser']['price']+$propertyUser['PropertyUser']['traveler_service_amount']+$propertyUser['PropertyUser']['security_deposit'];
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
                            'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                            'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                            'encode' => 'utf-8'
                            // Especifica o encode n�o implementado

                        ) ,
                        'format' => array(
                            'item_id' => $this->Auth->user('id') ,
                            'item_descr' => __l('Property Booking'),
                            'item_quant' => '1',
                            'item_valor' => $user_amount,
                            'item_frete' => '0',
                            'item_peso' => '20'
                        ) ,
                        'customer_info'
                    );
                    $transaction_data['TempPaymentLog'] = array(
                        'trans_id' => $ref,
                        'payment_type' => 'book',
                        'user_id' => $this->Auth->user('id') ,
                        // @todo "IP table logic"
                        'ip' => $this->RequestHandler->getClientIP() ,
                        'amount_needed' => $amount_user,
                        'property_id' => $this->request->data['Payment']['item_id'],
                        'property_user_id' => $this->request->data['Payment']['order_id'],
                        'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id'],
                        'currency_code' => 'BRL',
                    );
                    $this->TempPaymentLog->save($transaction_data);
                    $this->set('gateway_options', $gateway_options);
                    $this->set('action', $action);
                    $this->set('amount', $amount_user);
                    $this->autoRender = false;
                    $this->layout = 'redirect_page';
                    $this->render('do_payment');
                }
                if (!empty($this->request->data['Payment']['payment_gateway_id'])) {
                    $this->request->data['Payment']['payment_type_id'] = $this->request->data['Payment']['payment_gateway_id'];
                }
                if (!empty($this->request->data['PropertyUser']['message'])) {
                    $this->request->data['Payment']['message'] = $this->request->data['PropertyUser']['message'];
                }
            }
            $this->Payment->set($this->request->data);
            if (!$this->Payment->validates()) {
                if (!empty($this->request->data['Payment']['contact']) || !empty($this->request->data['Payment']['accept'])) {
                    $this->Session->setFlash(__l('Please agree the terms and conditions') , 'default', null, 'error');
                } else {
                    if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $this->Session->setFlash(__l('Please agree the terms and conditions or please enter proper credit card details') , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash(__l('Please agree the terms and conditions') , 'default', null, 'error');
                    }
                }
                $this->redirect(array(
                    'controller' => 'payments',
                    'action' => 'order',
                    $id,
                    'order_id' => $this->request->data['Payment']['order_id'],
                    'payment_gateway_id' => $this->request->data['Payment']['payment_gateway_id'],
                ));
            }
            $property = $this->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $this->request->data['Payment']['item_id']
                ) ,
                'fields' => array(
                    'Property.price_per_night',
                    'Property.slug',
                    'Property.slug',
                    'Property.id',
                    'Property.user_id'
                ) ,
                'recursive' => -1
            ));
            $propertyUser = $this->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $this->request->data['Payment']['order_id']
                ) ,
                'recursive' => -1
            ));

            if (!empty($this->request->data['Payment']['message'])) {
                $message_sender_user_id = $property['Property']['user_id'];
                $subject = 'Message from traveler';
                $message = $this->request->data['Payment']['message'];
				$from_id = $this->request->data['PropertyUser']['from_id'];
                $property_id = $property['Property']['id'];
                $order_id = $this->request->data['Payment']['order_id'];
                $message_id = $this->Property->PropertyUser->Message->sendNotifications($message_sender_user_id, $subject, $message, $order_id, $is_review = 0, $property_id, ConstPropertyUserStatus::FromTravelerConversation,'',$from_id);
            }
            $service_fee = $propertyUser['PropertyUser']['traveler_service_amount'];
            $security_deposit = $propertyUser['PropertyUser']['security_deposit'];
            $this->request->data['Payment']['total_price'] = $service_fee + $propertyUser['PropertyUser']['price'] + $security_deposit;
            
            if (!empty($this->request->data['Payment']['user_paypal_connection_id'])) {
                $userPaypalConnection = $this->Property->User->UserPaypalConnection->find('first', array(
                    'conditions' => array(
                        'UserPaypalConnection.id' => $this->request->data['Payment']['user_paypal_connection_id']
                    ) ,
                    'recursive' => -1
                ));
                if (empty($userPaypalConnection)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (($userPaypalConnection['UserPaypalConnection']['amount']-$userPaypalConnection['UserPaypalConnection']['charged_amount'] < $propertyUser['PropertyUser']['price']+$service_fee+$security_deposit)) {
                    $is_error = 1;
                    $error_message = __l('Selected PayPal connection have insufficient money');
                }
            } elseif (!empty($this->request->data['Payment']['payment_type_id']) && $this->request->data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet) {
                $user = $this->Property->User->find('first', array(
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
                if (empty($user)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if ($user['User']['available_wallet_amount'] < ($propertyUser['PropertyUser']['price']+$service_fee+$security_deposit)) {
                    $is_error = 1;
                    $error_message = __l('Your wallet has insufficient money');
                }
            }
            if (!$this->Auth->user('id')) {
                $valid = $this->process_user($property);
                if (!$valid) {
                    $is_error = 1;
                    $error_message = __l('Oops, problems in registration, please try again or later');
                }
            }
            if (!empty($is_error)) {
                $this->Session->setFlash($error_message, 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'payments',
                    'action' => 'order',
                    $id,
                    'order_id' => $this->request->data['Payment']['order_id'],
                    'payment_gateway_id' => !empty($this->request->data['Payment']['payment_gateway_id']) ? $this->request->data['Payment']['payment_gateway_id'] : ''
                ));
            } else {
                if (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($this->request->data['Payment']['creditCardNumber'])) {
                        $user = $this->Property->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        //create payment profile
                        $data = $this->request->data['Payment'];
                        $data['expirationDate'] = $this->request->data['expDateYear']['year'] . '-' . $this->request->data['expDateMonth']['month'];
                        $data['customerProfileId'] = $user['User']['cim_profile_id'];
                        $payment_profile_id = $this->Payment->_createCimPaymentProfile($data);
                        if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                            $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                            $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                            $payment['UserPaymentProfile']['is_default'] = 0;
                            $this->Property->User->UserPaymentProfile->save($payment);
                            $this->request->data['Payment']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                        } else {
                            $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'payments',
                                'action' => 'order',
                                'order_id' => $this->request->data['Payment']['order_id'],
                                $this->request->data['Payment']['item_id']
                            ));
                        }
                    }
                    if (!empty($this->request->data['Payment']['payment_profile_id'])) {
                        $this->process_order($this->request->data);
                    } else {
                        $this->Session->setFlash(__l('Your payment could not be completed') , 'default', null, 'error');
                        $this->redirect(array(
                            'controller' => 'payments',
                            'action' => 'order',
                            'order_id' => $this->request->data['Payment']['order_id'],
                            $this->request->data['Payment']['item_id']
                        ));
                    }
                } else {
                    $this->process_order($this->request->data);
                }
            }
        }


        if (!empty($this->request->params['named']['is_ajax'])) {
            $this->layout = 'ajax';
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'contact') {
            $this->pageTitle = __l('Pricing Negotiation');
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'accept') {
            $this->pageTitle = __l('Booking Request Confirm');
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'cancel') {
            $this->pageTitle = __l('Booking Cancel Process');
        } else {
            $this->pageTitle = __l('Book It');
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        switch ($type) {
            case 'property':
                $itemDetail = $this->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $id
                    ) ,
                    'contain' => array(
                        'Attachment' => array(
                            'fields' => array(
                                'Attachment.id',
                                'Attachment.filename',
                                'Attachment.dir',
                                'Attachment.width',
                                'Attachment.height'
                            ) ,
                        ) ,
                        'CancellationPolicy',
                        'PropertyType',
                        'PropertyUser' => array(
                            'conditions' => array(
                                'PropertyUser.id' => !empty($this->request->params['named']['order_id']) ? $this->request->params['named']['order_id'] : $this->request->data['Payment']['order_id']
                            ) ,
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso2'
                            )
                        ) ,
                        'User'
                    ) ,
                    'recursive' => 2
                ));
				
                if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'cancel') {
					if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Canceled || $itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin) {
						throw new NotFoundException(__l('Invalid request'));
					}
					if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
	                    $refund_amount = $this->Payment->_checkCancellationPolicies($itemDetail['Property'], $itemDetail['PropertyUser'][0], $itemDetail['CancellationPolicy']);
					} else {
						$refund_amount['traveler_balance'] = $itemDetail['PropertyUser'][0]['price'];
					}
	                $this->set('refund_amount', $refund_amount);
                }
                $this->pageTitle.= ' - ' . $itemDetail['Property']['title'];
                break;
        }
        if (empty($itemDetail)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'accept') || empty($this->request->params['named']['type'])) {
            if (!empty($itemDetail) && $this->Auth->user('id') && $itemDetail['PropertyUser'][0]['user_id'] != $this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            if (!empty($itemDetail) && $this->Auth->user('id') && $itemDetail['PropertyUser'][0]['owner_user_id'] != $this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $all_userPaypalConnections = $this->Property->User->UserPaypalConnection->find('all', array(
            'conditions' => array(
                'UserPaypalConnection.is_active' => 1,
                'UserPaypalConnection.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $user_info = $this->Property->User->find('first', array(
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
                    $this->request->data['Payment']['user_paypal_connection_id'] = $userPaypalConnection['UserPaypalConnection']['id'];
                }
            }
        }
        $this->set('itemDetail', $itemDetail);
        $this->set('userPaypalConnections', $userPaypalConnections);
        $this->set('user_info', $user_info);
        $this->request->data['Payment']['type'] = $type;
        $this->request->data['Payment']['item_id'] = $id;
        if (!empty($this->request->params['named']['payment_gateway_id'])) {
            $this->request->data['Payment']['payment_gateway_id'] = $this->request->params['named']['payment_gateway_id'];
        }
        $payment_options = $this->Payment->getGatewayTypes('is_enable_for_book_a_property');
        if (empty($this->request->data['Payment']['payment_gateway_id'])) {
            if (!empty($payment_options[ConstPaymentGateways::PayPal])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PayPal;
            } elseif (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
            } elseif (!empty($payment_options[ConstPaymentGateways::PagSeguro])) {
                $this->request->data['Payment']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
            }
        }
        $gateway_options['paymentGateways'] = $payment_options;
        $gateway_options['countries'] = $this->Property->User->UserProfile->Country->find('list', array(
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
        if ($this->Auth->user('id')) {
            $Paymentprofiles = $this->Property->User->UserPaymentProfile->find('all', array(
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
                    $this->request->data['Payment']['payment_profile_id'] = $pay_profile['UserPaymentProfile']['cim_payment_profile_id'];
                }
            }
        }
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->request->data['Payment']['is_show_new_card'] = 1;
        }
        $states = $this->Property->User->UserProfile->State->find('list', array(
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
        $this->request->data['Payment']['cvv2Number'] = $this->request->data['Payment']['creditCardNumber'] = '';
    }












    //send welcome mail for new user
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
    //for new users or who have low balance amount or credit card payment or paypal auth
    public function process_user($property)
    {
        $is_purchase_with_wallet_amount = 0;
        $this->Session->write('Auth.last_bought_property_slug', $property['Property']['slug']);
        if (!empty($this->request->data)) {
            $total_property_amount = $property['Property']['price_per_night'];
            $valid_user = true;
            //already registered users
            //new users register process
            $amount_needed = $total_property_amount;
            $this->Property->User->create();
            $this->Property->User->set($this->request->data['User']);
            if ($this->Property->User->validates()) {
                $this->request->data['User']['is_active'] = 1;
                $this->request->data['User']['is_email_confirmed'] = 1;
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
                $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
                $this->request->data['User']['signup_ip'] = $this->RequestHandler->getClientIP();
                if ($this->Property->User->save($this->request->data['User'], false)) {
                    $user_id = $this->Property->User->getLastInsertId();
                    $this->Payment->_createCimProfile($user_id);
                    $this->_sendWelcomeMail($user_id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                    $this->request->data['UserProfile']['user_id'] = $user_id;
                    $this->Property->User->UserProfile->create();
                    $this->Property->User->UserProfile->save();
                    $this->Auth->login($this->request->data['User']);
                    $this->request->data['Property']['user_id'] = $user_id;
                }
            } else {
                $valid_user = false;
            }
            return $valid_user;
        }
    }
    public function process_order($data)
    {
        // @todo "Coupons"
        $this->autoRender = false;
        $this->loadModel('Property');
        if (empty($data)) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            $return = $this->Payment->processOrder($data['Payment']);
            if (empty($return['error'])) {
                if (!empty($data['Payment']['user_paypal_connection_id']) || $data['Payment']['payment_type_id'] == ConstPaymentGateways::Wallet || $data['Payment']['payment_type_id'] == ConstPaymentGateways::AuthorizeNet) {
                    $this->Payment->processOrderPayment($return['order_id']);
                    $this->redirect(array(
                        'controller' => 'pages',
                        'action' => 'view',
                        'order-purchase-completed'
                    ));
                }
            } else {
                $this->Session->setFlash($return['error_message'] . __l('. Your payment could not be completed') , 'default', null, 'error');
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'order',
                        'order_id' => $return['order_id'],
                        $this->request->data['Payment']['item_id']
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'payments',
                        'action' => 'order',
                        'order_id' => $return['order_id'],
                        $property['Property']['id']
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
        }
    }
    public function success_order($type, $order_id)
    {
        $this->pageTitle = __l('Payment Success');
        $this->Session->setFlash(__l('Your payment has been received') , 'default', null, 'success');
        switch ($type) {
            case 'property':
                $this->Payment->processOrderPayment($order_id);
                $redirect = Router::url(array(
                    'controller' => 'pages',
                    'action' => 'view',
                    'order-purchase-completed'
                ) , true);
                break;

            case 'user':
                $this->Payment->processUserPayment($order_id);
                $redirect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'add_to_wallet',
                ) , true);
                break;
        }
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
        } else {
            $this->redirect($redirect);
        }
    }
    public function cancel_order($type, $order_id)
    {
        $this->pageTitle = __l('Payment Cancel');
        $this->Session->setFlash(__l('Your payment has been canceled') , 'default', null, 'success');
        switch ($type) {
            case 'property':
                $redirect = Router::url(array(
                    'controller' => 'properties',
                    'action' => 'index',
                ) , true);
                break;

            case 'user':
                $redirect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'add_to_wallet',
                ) , true);
                break;
        }
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
        } else {
            $this->redirect($redirect);
        }
    }
    public function processpayment($type, $order_id)
    {
        $this->autoRender = false;
        switch ($type) {
            case 'property':
                $this->Payment->processOrderPayment($order_id);
                break;

            case 'user':
                $this->Payment->processUserPayment($order_id);
                break;
        }
    }
    public function connect($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = $this->Auth->user('id');
        }
        $return = $this->Payment->processPaypalConnect($user_id);
        if (!empty($return['error'])) {
            $this->Session->setFlash(__l('Gateway error:') . ' ' . $return['error_message'], 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'user_paypal_connections',
                'action' => 'index'
            ));
        }
        $this->autoRender = false;
    }
    public function success_connect($user_paypal_connection_id)
    {
        $this->pageTitle = __l('Payment Success');
        $this->_processPaypalConnection($user_paypal_connection_id);
        $this->Session->setFlash(__l('You have connected with PayPal successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'user_paypal_connections',
            'action' => 'index',
        ));
        $this->autoRender = false;
    }
    public function cancel_connect($user_paypal_connection_id)
    {
        $this->pageTitle = __l('Payment Cancel');
        $this->Session->setFlash(__l('Your connection has been canceled.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'user_paypal_connections',
            'action' => 'index',
        ));
        $this->autoRender = false;
    }
    public function _processPaypalConnection($user_paypal_connection_id)
    {
        $this->loadModel('User');
        $userPaypalConnection = $this->User->UserPaypalConnection->find('first', array(
            'conditions' => array(
                'UserPaypalConnection.id' => $user_paypal_connection_id
            ) ,
            'recursive' => -1
        ));
        if (empty($userPaypalConnection)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paypalConnection = $this->Payment->getPreapprovalDetails($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
        if (empty($paypalConnection)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($paypalConnection['approved']) && $paypalConnection['approved'] == 'true' && strtoupper($paypalConnection['status']) == 'ACTIVE') {
            $this->Payment->updateUserConnection($paypalConnection, $userPaypalConnection);
        }
    }
    public function processconnect($user_paypal_connection_id)
    {
        $this->autoRender = false;
        $this->_processPaypalConnection($user_paypal_connection_id);
    }
    public function create_paypal_account()
    {
        $this->pageTitle = __l('Create Paypal Account');
        if (!empty($this->request->data)) {
            $this->PaypalAccount->create();
            $this->request->data['PaypalAccount']['user_id'] = $this->Auth->user('id');
            $this->request->data['PaypalAccount']['currency_code'] = Configure::read('site.currency_code');
            if ($this->PaypalAccount->save($this->request->data)) {
                $paypalAccount = $this->PaypalAccount->find('first', array(
                    'conditions' => array(
                        'PaypalAccount.id = ' => $this->PaypalAccount->id
                    ) ,
                    'contain' => array(
                        'PaypalCountry' => array(
                            'fields' => array(
                                'PaypalCountry.name',
                                'PaypalCountry.code'
                            )
                        ) ,
                        'PaypalCitizenshipCountry' => array(
                            'fields' => array(
                                'PaypalCitizenshipCountry.name',
                                'PaypalCitizenshipCountry.code'
                            )
                        ) ,
                    )
                ));
                $return = $this->Payment->createPaypalAccount($paypalAccount);
                if (!empty($return['error'])) {
                    $this->PaypalAccount->delete($this->PaypalAccount->id);
                    $this->Session->setFlash($return['error_message'], 'default', null, 'error');
                } else {
                    $this->Session->setFlash(__l('PayPal Account has been added') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('PayPal Account could not be created. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data['PaypalAccount']['email'] = $this->Auth->user('email');
        }
        $this->PaypalAccount->validate;
        $this->set('referralURL', $this->Payment->getMerchantReferralURL());
        $paypalCountries = $this->PaypalAccount->PaypalCountry->find('list');
        $paypalCitizenshipCountries = $this->PaypalAccount->PaypalCitizenshipCountry->find('list');
        $this->set(compact('paypalCountries', 'paypalCitizenshipCountries'));
    }
    public function success_account()
    {
        $this->pageTitle = __l('Create Paypal Account Success');
        $this->Session->setFlash(__l('Your paypal account has been created successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'properties',
            'action' => 'index',
        ));
        $this->autoRender = false;
    }
    public function cancel_account()
    {
        $this->pageTitle = __l('Create Paypal Account Cancel');
        $this->Session->setFlash(__l('Your paypal account creation has been canceled.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'properties',
            'action' => 'index',
        ));
        $this->autoRender = false;
    }
    public function admin_send_money($id = null)
    {
        $this->loadModel('User');
        $this->pageTitle = __l('Send Money');
        if (!empty($this->request->data['User']['id'])) {
            $id = $this->request->data['User']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $id
            ) ,
            'contain' => array(
                'UserProfile'
            ) ,
            'recursive' => 2
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->User->SendMoney->set($this->request->data);
            if ($this->User->SendMoney->validates()) {
                $data['user_id'] = $this->request->data['User']['id'];
                $data['amount'] = $this->request->data['SendMoney']['amount'];
                $data['fee_payer'] = $this->request->data['SendMoney']['fee_payer'];
                $return = $this->Payment->sendMoney($data);
                if (!empty($return['error'])) {
                    $this->Session->setFlash(__l('Invalid user PayPal account.') , 'default', null, 'error');
                }
            }
        } else {
            $this->request->data = $user;
            $this->request->data['SendMoney']['fee_payer'] = 1;
        }
        $feesPayers = array(
            1 => $user['User']['username'],
            2 => __l('Site') . ' (' . Configure::read('site.name') . ')'
        );
        $this->set('paypal_balance', $this->Payment->getBalance());
        $this->set('feesPayers', $feesPayers);
        $this->set('user', $user);
    }
    public function processsendmoney($sendmoney_id)
    {
        $this->Payment->processSendMoneyPayment($sendmoney_id);
        $this->autoRender = false;
    }
    public function success_sendmoney($sendmoney_id)
    {
        $this->pageTitle = __l('Send Money Success');
        $this->Payment->processSendMoneyPayment($sendmoney_id);
        $this->Session->setFlash(__l('You have successfully sent the money to user') , 'default', null, 'success');
        $redirect = Router::url(array(
            'controller' => 'users',
            'action' => 'index',
            'admin' => true
        ) , true);
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('success_order');
        } else {
            $this->redirect($redirect);
        }
    }
    public function cancel_sendmoney($sendmoney_id)
    {
        $this->pageTitle = __l('Send Money Cancel');
        $this->Session->setFlash(__l('You have canceled the money send to user.') , 'default', null, 'success');
        $redirect = Router::url(array(
            'controller' => 'users',
            'action' => 'index',
            'admin' => true
        ) , true);
        if (Configure::read('paypal.is_embedded_payment_enabled')) {
            $this->set('redirect', $redirect);
            $this->render('cancel_order');
        } else {
            $this->redirect($redirect);
        }
    }
    public function admin_sitepaymentbalance()
    {
        $this->set('paypal_balance', $this->Payment->getBalance());
    }
}
?>