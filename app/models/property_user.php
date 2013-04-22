<?php
class PropertyUser extends AppModel
{
    public $name = 'PropertyUser';
    public $actsAs = array(
        'Aggregatable',
        'Versionable' => array(
            'modified',
            'property_user_status_id',
            'price',
            'host_service_amount',
        )
    );
    var $aggregatingFields = array(
        'message_count' => array(
            'mode' => 'real',
            'key' => 'property_user_id',
            'foreignKey' => 'property_user_id',
            'model' => 'Message',
            'function' => 'COUNT(Message.property_user_id)',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,                'UserProfile' => array(            'className' => 'UserProfile',            'foreignKey' => '',            'conditions' => array('UserProfile.user_id = User.id'),            'fields' => '',            'order' => ''        ),        
        'OwnerUser' => array(
            'className' => 'User',
            'foreignKey' => 'owner_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PropertyUserStatus' => array(
            'className' => 'PropertyUserStatus',
            'foreignKey' => 'property_user_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'PropertyFeedback' => array(
            'className' => 'PropertyFeedback',
            'foreignKey' => 'property_user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_content_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'AuthorizenetDocaptureLog' => array(
            'className' => 'AuthorizenetDocaptureLog',
            'foreignKey' => 'property_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    public $hasOne = array(
        'PropertyFeedback' => array(
            'className' => 'PropertyFeedback',
            'foreignKey' => 'property_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'property_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'checkin' => array(
                /*'rule3' => array(
                    'rule' => '_isValidCheckinDate',
                    'message' => __l('Oops, seems you given wrong date or greater than checkout date, please check it!') ,
                    'allowEmpty' => false
                ) ,
                /*'rule2' => array(
                    'rule' => '_isCheckinDateAvailable',
                    'message' => __l('Selected date not available, Please select some other date or check calendar!') ,
                    'allowEmpty' => false
                ) ,*/
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'checkout' => array(
               /* 'rule3' => array(
                    'rule' => '_isValidCheckoutDate',
                    'message' => __l('Oops, seems you given wrong date or less than checkin date, please check it!') ,
                    'allowEmpty' => false
                ) ,
               /* 'rule2' => array(
                    'rule' => '_isCheckoutDateAvailable',
                    'message' => __l('Selected date not available, Please select some other date or check calendar!') ,
                    'allowEmpty' => false
                ) ,*/
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
           /* 'checkinout' => array(
                'rule1' => array(
                    'rule' => '_isCheckInOutValid',
                    'message' => __l('Invalid Selection') ,
                    'allowEmpty' => false
                ) ,
            ) ,*/
            /*
            'guests' => array(
                'rule1' => array(
                    'rule' => '_isCheckGuest',
                    'message' => __l('Your selection is exceeded the allowed guest limit') ,
                    'allowEmpty' => false
                ) ,
            )*/
        );
        $conditions = array();
        $conditions['Message.is_sender'] = 0;
        $conditions['NOT']['Message.property_user_status_id'] = array(
            ConstPropertyUserStatus::SenderNotification,
            ConstPropertyUserStatus::WorkDelivered,
            ConstPropertyUserStatus::WorkReviewed,
            ConstPropertyUserStatus::RequestNegotiation,
            ConstPropertyUserStatus::SecurityDepositRefund
        );
        $this->aggregatingFields['message_count']['conditions'] = $conditions;
        $this->isFilterOptions = array(
            ConstPropertyUserStatus::PaymentPending => __l('Payment Pending') ,
            ConstPropertyUserStatus::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstPropertyUserStatus::Confirmed => __l('Confirmed') ,
            ConstPropertyUserStatus::Arrived => __l('Arrived') ,
            ConstPropertyUserStatus::WaitingforReview => __l('Waiting for traveler review') ,
            ConstPropertyUserStatus::Completed => __l('Completed') ,
            ConstPropertyUserStatus::Canceled => __l('Canceled by traveler') ,
            ConstPropertyUserStatus::Rejected => __l('Rejected') ,
            ConstPropertyUserStatus::Expired => __l('Expired') ,
            ConstPropertyUserStatus::CanceledByAdmin => __l('Canceled by admin') ,
        );
        $this->moreActions = array(
            ConstMoreAction::WaitingforAcceptance => __l('Waiting for acceptance') ,
            ConstMoreAction::InProgress => __l('In progress') ,
            ConstMoreAction::Completed => __l('Completed') ,
            ConstMoreAction::Canceled => __l('Canceled') ,
            ConstMoreAction::Rejected => __l('Rejected') ,
            ConstMoreAction::PaymentCleared => __l('Payment Cleared') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _isCheckInOutValid()
    {
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyuser = $this->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $this->data[$this->name]['order_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyuser)) {
            $checkinout = $this->data[$this->name]['checkinout']['year'] . '-' . $this->data[$this->name]['checkinout']['month'] . '-' . $this->data[$this->name]['checkinout']['day'];
            if ($propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
                if ($checkinout >= $propertyuser['PropertyUser']['checkin']) {
                    return true;
                }
            }
            if ($propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview || $propertyuser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
                if ($checkinout >= $propertyuser['PropertyUser']['checkout']) {
                    return true;
                }
            }
        }
        return false;
    }
    function _isCheckGuest(){
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $property = $this->PropertyUser->Property->find('first', array(
            'conditions' => array(
                'Property.id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($property)) {
            if ($property['Property']['accommodates'] == 0) {
                return true;
            } else if ($this->data[$this->name]['guests'] > $property['Property']['maximum_nights']) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
    function _isCheckinDateAvailable(){
        $return = true;
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyusers = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id ' => array(
                        ConstPropertyUserStatus::WaitingforAcceptance,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::CanceledByAdmin,
                        ConstPropertyUserStatus::PaymentPending,
                        ConstPropertyUserStatus::Expired,
                        0,
                    ) ,
                ) ,
                'PropertyUser.property_id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyusers)) {
            foreach($propertyusers as $propertyuser) {
                if (strtotime($this->data[$this->name]['checkin']) >= strtotime($propertyuser['PropertyUser']['checkin']) && strtotime($this->data[$this->name]['checkin']) <= strtotime($propertyuser['PropertyUser']['checkout'])) {
                    $return = false;
                }
            }
        }
        return $return;
    }
    function _isCheckoutDateAvailable()
    {
        $return = true;
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        $propertyusers = $this->PropertyUser->find('all', array(
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id ' => array(
                        ConstPropertyUserStatus::WaitingforAcceptance,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::CanceledByAdmin,
                        ConstPropertyUserStatus::PaymentPending,
                        ConstPropertyUserStatus::Expired,
                        0,
                    ) ,
                ) ,
                'PropertyUser.property_id' => $this->data[$this->name]['property_id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($propertyusers)) {
            foreach($propertyusers as $propertyuser) {
                if (strtotime($this->data[$this->name]['checkout']) >= strtotime($propertyuser['PropertyUser']['checkin']) && strtotime($this->data[$this->name]['checkout']) <= strtotime($propertyuser['PropertyUser']['checkout'])) {
                    $return = false;
                }
            }
        }
        return $return;
    }
    function _isValidCheckinDate()
    {
        if (strtotime($this->data[$this->name]['checkin']) >= strtotime(date('Y-m-d')) && strtotime($this->data[$this->name]['checkin']) <= strtotime($this->data[$this->name]['checkout'])) {
            return true;
        } else {
            return false;
        }
    }
    function _isValidCheckoutDate()
    {
        if (strtotime($this->data[$this->name]['checkout']) >= strtotime($this->data[$this->name]['checkin'])) {
            return true;
        } else {
            return false;
        }
    }
    function processOrder($order_id, $order_status, $message = null, $data = null)
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
        $propertyInfo = $this->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $order_id,
            ) ,
            'contain' => array(
                'Property' => array(
                    'fields' => array(
                        'Property.id',
                        'Property.title',
                        'Property.user_id',
                        'Property.slug',
                        'Property.address',
                        'Property.phone',
                        'Property.house_manual',
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
                    ) ,
					'CancellationPolicy'
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
        $success = 0;
        $is_review = 0;
        $ajax_repsonse = 'failed';
        $guest_user_id = $propertyInfo['PropertyUser']['user_id'];
        $guest_username = $propertyInfo['User']['username'];
        $guest_email = $propertyInfo['User']['email'];
        $host_user_id = $propertyInfo['Property']['user_id'];
        $host_username = $propertyInfo['Property']['User']['username'];
        $host_email = $propertyInfo['Property']['User']['email'];
        $property_id = $propertyInfo['Property']['id'];
        $verification_code = $host_contact = $guest_contact = $print_link = $success_message = $status = '';
        $host_contact = __l('Address:') . "\n";
        $host_contact.= !empty($propertyInfo['Property']['address']) ? $propertyInfo['Property']['address'] : ' - ' . "\n";
        $host_contact.= __l('Phone:') . "\n";
        $host_contact.= !empty($propertyInfo['Property']['phone']) ? ' - '.$propertyInfo['Property']['phone'] : ' - ' . "\n";
		$private_details = __l('Private Details:') . "\n";
		$private_details .= !empty($propertyInfo['Property']['house_manual']) ? $propertyInfo['Property']['house_manual'] : '-' . "\n";

		$join_id = !empty($propertyInfo['Property']['id']) ? $propertyInfo['Property']['id'] : '-' . "\n";
        switch ($order_status) {
            case 'accept':
                if ($host_user_id != $_SESSION['Auth']['User']['id']) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                if (!empty($propertyInfo['PropertyUser']) && ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance)) {
                    if (!empty($propertyUser['PropertyUser']['payment_gateway_id']) && $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $return = $this->Payment->_captureProcessOrder($propertyUser['PropertyUser']['id']);
                    }
                    if (empty($return['error'])) {
                        // Generating verification code for offline propertys //
                        $PropertyUser['PropertyUser']['id'] = $order_id;
                        $PropertyUser['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Confirmed;
                        $PropertyUser['PropertyUser']['accepted_date'] = date('Y-m-d H:i:s');
                        $print_link = "";
                        $this->PropertyUser->save($PropertyUser, false);
                        $success = 1;
                        $mail_template = 'Accepted booking notification';
                        $mail_template_for_sender = 'Accept booking host notification';
                        $to = $guest_user_id;
                        $message_sender_user_id = $host_user_id;
                        $to_user = $guest_username;
                        $sender_email = $guest_email;
                        $message_sender_name = $host_username;
                        $message_sender_email = $host_email;
                        $ajax_repsonse = 'accepted';
                        $email_message = __l('Your booking has been accepted');
                        $email_message_for_sender = __l('You have accepted your booking');
                        $success_message = __l('You have successfully accepted the booking request');
                        $redirect = 'myworks';
                        $status = 'confirmed';
                    } else {
                        $redirect = 'myworks';
                    }
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'cancel':
                if (!empty($propertyInfo['PropertyUser']) && ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance)) {
                    // @todo "What goodies I want (Host)"
                    if ($guest_user_id != $_SESSION['Auth']['User']['id']) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    $security_deposit = 0;
                    if (Configure::read('property.is_enable_security_deposit')) {
                        $security_deposit = $propertyInfo['PropertyUser']['security_deposit'];
                    }
                    if ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
                        $return_amount = $this->Property->_checkCancellationPolicies($propertyInfo['Property'], $propertyInfo['PropertyUser'], $propertyInfo['Property']['CancellationPolicy']);
                        if (!empty($return_amount['traveler_balance']) && !empty($return_amount['host_balance'])) {
							$return_amount['traveler_balance'] = $return_amount['traveler_balance'] + $security_deposit;
                            $update_seller_balance = $propertyInfo['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
                            $update_seller_wallet_balance = $propertyInfo['Property']['User']['available_wallet_amount'] + $return_amount['host_balance'];
                            $update_seller_cleared_amount = $propertyInfo['Property']['User']['cleared_amount'] + $return_amount['host_balance'];
                            $update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
                        } elseif (!empty($return_amount['no_refund'])) {
                            $this->_noRefund($propertyInfo, ConstPropertyUserStatus::Canceled);
                        }
                    } else {
                        if ($propertyInfo['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                            $return = $this->Payment->_captureProcessOrder($propertyInfo['PropertyUser']['id']);
                        }
                        $return_amount['traveler_balance'] = $propertyInfo['PropertyUser']['price'] + $security_deposit;
                        $return_amount['host_balance'] = $propertyInfo['PropertyUser']['price'] - $propertyInfo['PropertyUser']['host_service_amount'];
                        $update_seller_balance = $propertyInfo['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
                        $update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
                    }
                    if (empty($return['error_message'])) {
                        if (empty($return_amount['no_refund'])) {
                            if (isset($update_seller_balance) && isset($update_buyer_balance)) {
                                $order_status = ConstPropertyUserStatus::Canceled;
                                $transaction_status = ConstTransactionTypes::RefundForCanceledProperty;
                                $success_message = __l('You have successfully canceled your booked property.');
                                $stat_mess = 'canceled';
                                $ajax_repsonse = 'canceled';
                                $redirect = 'mytours';
                                $to = $host_user_id;
                                $success = 1;
                                $message_sender_user_id = $guest_user_id;
                                $to_user = $host_username;
                                $message_sender_name = $guest_username;
                                $message_sender_email = $guest_email;
                                $transaction_user_id = $_SESSION['Auth']['User']['id'];
                                $sender_email = $host_email;
                                $email_message = __l('Your booking has been canceled');
                                $email_message_for_sender = __l('You have canceled your booking');
                                $mail_template = 'Canceled booking notification';
                                $mail_template_for_sender = 'Canceled booking Traveler notification';
                                $seller_transaction_status = ConstTransactionTypes::SellerDeductedForCanceledProperty;
                                $success = 1;
                                // Change order status
                                $PropertyUser['PropertyUser']['id'] = $order_id;
                                $PropertyUser['PropertyUser']['property_user_status_id'] = $order_status;
                                $this->PropertyUser->save($PropertyUser);
                                // Update amount to seller ->  reduce 5$ from seller //
								if (empty($return_amount['partially_refund'])) {
									$this->PropertyUser->User->updateAll(array(
										'User.blocked_amount' => "'" . $update_seller_balance . "'"
									) , array(
										'User.id' => $host_user_id
									));
								}
                                // Update amount to Buyer -> add 5$ to buyer balance//
                                $this->PropertyUser->User->updateAll(array(
                                    'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                                ) , array(
                                    'User.id' => $guest_user_id
                                ));
                                // Update Transactions //
                                $transaction['Transaction']['user_id'] = $transaction_user_id;
                                $transaction['Transaction']['foreign_id'] = $order_id;
                                $transaction['Transaction']['class'] = 'PropertyUser';
                                $transaction['Transaction']['amount'] = $return_amount['traveler_balance'];
                                $transaction['Transaction']['description'] = "Property $stat_mess - Amount Refunded";
                                $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                                $this->PropertyUser->User->Transaction->log($transaction);
                                // Updating transaction again for seller //
                                $transaction['Transaction']['id'] = '';
                                $transaction['Transaction']['user_id'] = $propertyInfo['Property']['user_id'];
                                $transaction['Transaction']['foreign_id'] = $order_id;
                                $transaction['Transaction']['class'] = 'PropertyUser';
                                $transaction['Transaction']['amount'] = $return_amount['host_balance'];
                                $transaction['Transaction']['description'] = 'Updating payment status for Traveler';
                                $transaction['Transaction']['transaction_type_id'] = $seller_transaction_status;
                                $this->PropertyUser->User->Transaction->save($transaction);
                                if (!empty($return_amount['partially_refund'])) {
                                    // Clear Amount For Seller, since the order has been canceled with no refund to buyer... seller amount will be stll in blocked status... clearing that amount //
                                    $this->User->updateAll(array(
                                        'User.blocked_amount' => "'" . $update_seller_balance . "'",
                                        'User.cleared_amount' => "'" . $update_seller_cleared_amount . "'",
                                        'User.available_wallet_amount' => "'" . $update_seller_wallet_balance . "'",
                                    ) , array(
                                        'User.id' => $host_user_id
                                    ));
                                    // Updating transaction again for seller //
                                    $transaction['Transaction']['id'] = '';
                                    $transaction['Transaction']['user_id'] = $propertyInfo['Property']['User']['id'];
                                    $transaction['Transaction']['foreign_id'] = $propertyInfo['PropertyUser']['id'];
                                    $transaction['Transaction']['class'] = 'PropertyUser';
                                    $transaction['Transaction']['amount'] = $return_amount['host_balance'];
                                    $transaction['Transaction']['description'] = 'Amount cleared';
                                    $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostAmountCleared;
                                    $this->Transaction->save($transaction);
                                    $message_for_reciever = __l('According to our Cancellation Policies, partially amount has been refunded to your account.');
                                    $message = __l('According to our Cancellation Policies, partially amount has been cleared for your withdrawal. Remaining has been refunded to traveler.');
                                }
                            } else {
                                $redirect = 'mytours';
                            }
                        } else {
                            $update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $security_deposit;
                            $order_status = ConstPropertyUserStatus::Canceled;
                            $transaction_status = ConstTransactionTypes::RefundedToTraveler;
                            $transaction_user_id = $_SESSION['Auth']['User']['id'];
                            $stat_mess = 'canceled';
                            $success = 1;
                            $this->PropertyUser->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $guest_user_id
                            ));
                            // Update Transactions //
                            $transaction['Transaction']['user_id'] = $transaction_user_id;
                            $transaction['Transaction']['foreign_id'] = $order_id;
                            $transaction['Transaction']['class'] = 'PropertyUser';
                            $transaction['Transaction']['amount'] = $security_deposit;
                            $transaction['Transaction']['description'] = "Property $stat_mess - Amount Refunded";
                            $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                            $this->PropertyUser->User->Transaction->log($transaction);
                            $flash_message = __l('You have successfully canceled your booking.');
                            $stat_mess = 'canceled';
                            $ajax_repsonse = 'canceled';
                            $redirect = 'mytours';
                        }
                    } else {
                        $flash_message = __l('You cancellation process was failed');
                        $redirect = 'mytours';
                    }
                } else {
                    $flash_message = __l('You cannot cancel this booking');
                    $redirect = 'mytours';
                }
                break;

            case 'arrived':
                if (!empty($propertyInfo['PropertyUser']) && (($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) || ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived))) {
                    if ($guest_user_id != $_SESSION['Auth']['User']['id'] && $host_user_id != $_SESSION['Auth']['User']['id']) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (empty($refund['error'])) {
                        $order_status = ConstPropertyUserStatus::Arrived;
                        $success_message = __l('You have successfully entered your arrived status');
                        $stat_mess = 'arrived';
                        $ajax_repsonse = 'arrived';
                        $redirect = 'mytours';
                        $success = 1;
                        $to = $host_user_id;
                        $message_sender_user_id = $guest_user_id;
                        $to_user = $host_username;
                        $message_sender_name = $guest_username;
                        $message_sender_email = $guest_email;
                        $sender_email = $host_email;
                        $email_message = __l('Checkin date has arrived.');
                        $email_message_for_sender = __l('Checkin date has arrived.');
                        // Arrived mail will be sent only for the first time /
                        if ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
                            $mail_template = 'Checkin host notification mail';
                        }
                        $mail_template_for_sender = 'Checkin welcome mail';
                        // Change order status
                        $PropertyUser['PropertyUser']['id'] = $order_id;
                        $PropertyUser['PropertyUser']['property_user_status_id'] = $order_status;
                        $PropertyUser['PropertyUser']['actual_checkin_date'] = date('Y-m-d h:i:s');
                        if ($propertyInfo['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                            $PropertyUser['PropertyUser']['is_traveler_checkin'] = 1;
                            $PropertyUser['PropertyUser']['traveler_checkin_date'] = $data['checkinout'];
                        } else if ($propertyInfo['PropertyUser']['owner_user_id'] == $_SESSION['Auth']['User']['id']) {
                            $PropertyUser['PropertyUser']['is_host_checkin'] = 1;
                            $PropertyUser['PropertyUser']['host_checkin_date'] = $data['checkinout'];
                        }
                        if (isset($data['via']) && $data['via'] == 'ticket') {
                            $PropertyUser['PropertyUser']['checkin_via_ticket'] = 1;
                        }
                        $this->PropertyUser->save($PropertyUser);
                    } else {
                        $redirect = 'myworks';
                    }
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'reject':
                if (!empty($propertyInfo['PropertyUser']) && ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance)) {
                    if ($host_user_id != $_SESSION['Auth']['User']['id']) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if ($propertyInfo['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && !empty($propertyInfo['PropertyUser']['is_delayed_chained_payment'])) {
                        $refund = $this->Payment->_refundProcessOrder($propertyInfo['PropertyUser']['id']);
                    }
                    if ($propertyInfo['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $refund = $this->Payment->_voidProcessOrder($propertyInfo['PropertyUser']['id']);
                    }
                    if (empty($refund['error'])) {
                        $return_amount['traveler_balance'] = $propertyInfo['PropertyUser']['price'] + $propertyInfo['PropertyUser']['traveler_service_amount'] + $propertyInfo['PropertyUser']['security_deposit'];
                        $return_amount['host_balance'] = $propertyInfo['PropertyUser']['price'] - $propertyInfo['PropertyUser']['host_service_amount'];
                        $update_seller_balance = $propertyInfo['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
                        $update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
                        $order_status = ConstPropertyUserStatus::Rejected;
                        $transaction_status = ConstTransactionTypes::RefundForRejectedProperty;
                        $success_message = __l('You have rejected successfully');
                        $stat_mess = 'rejected';
                        $status = 'rejected';
                        $ajax_repsonse = 'rejected';
                        $redirect = 'myworks';
                        $to = $guest_user_id;
                        $message_sender_user_id = $host_user_id;
                        $to_user = $guest_username;
                        $sender_email = $guest_email;
                        $message_sender_name = $host_username;
                        $message_sender_email = $host_email;
                        $transaction_user_id = $guest_user_id;
                        $email_message = __l('Your booking has been rejected');
                        $email_message_for_sender = __l('You have rejected your booking');
                        $mail_template = 'Rejected booking notification';
                        $mail_template_for_sender = 'Rejected booking host notification';
                        $seller_transaction_status = ConstTransactionTypes::SellerDeductedForRejectedProperty;
                        $success = 1;
                        // Change order status
                        $PropertyUser['PropertyUser']['id'] = $order_id;
                        $PropertyUser['PropertyUser']['property_user_status_id'] = $order_status;
                        $this->PropertyUser->save($PropertyUser);
                        // Update amount to seller ->  reduce 5$ from seller //
                        $this->PropertyUser->User->updateAll(array(
                            'User.blocked_amount' => "'" . $update_seller_balance . "'"
                        ) , array(
                            'User.id' => $host_user_id
                        ));
                        // Paypal adaptive reverse process shouldn't reduce from wallet
                        if (($propertyInfo['PropertyUser']['payment_gateway_id'] != ConstPaymentGateways::PayPal && $propertyInfo['PropertyUser']['payment_gateway_id'] != ConstPaymentGateways::AuthorizeNet) || ($propertyInfo['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && empty($propertyInfo['PropertyUser']['is_delayed_chained_payment']))) {
                            // Update amount to Buyer -> add 5$ to buyer balance//
                            $this->PropertyUser->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $guest_user_id
                            ));
                        }
                        // Update Transactions //
                        $transaction['Transaction']['user_id'] = $transaction_user_id;
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'PropertyUser';
                        $transaction['Transaction']['amount'] = $return_amount['traveler_balance'];
                        $transaction['Transaction']['description'] = "Property $stat_mess - Amount Refunded";
                        $transaction['Transaction']['transaction_type_id'] = $transaction_status;
                        $this->PropertyUser->User->Transaction->log($transaction);
                        // Updating transaction again for seller //
                        $transaction['Transaction']['id'] = '';
                        $transaction['Transaction']['user_id'] = $propertyInfo['Property']['user_id'];
                        $transaction['Transaction']['foreign_id'] = $order_id;
                        $transaction['Transaction']['class'] = 'PropertyUser';
                        $transaction['Transaction']['amount'] = $return_amount['host_balance'];
                        $transaction['Transaction']['description'] = 'Updating payment status for host';
                        $transaction['Transaction']['transaction_type_id'] = $seller_transaction_status;
                        $this->PropertyUser->User->Transaction->save($transaction);
                    } else {
                        $redirect = 'myworks';
                    }
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'admin_cancel':
				$security_deposit = 0;
				if (Configure::read('property.is_enable_security_deposit')) {
					$security_deposit = $propertyInfo['PropertyUser']['security_deposit'];
				}
				if ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
					$return_amount = $this->Property->_checkCancellationPolicies($propertyInfo['Property'], $propertyInfo['PropertyUser'], $propertyInfo['Property']['CancellationPolicy']);
					if (!empty($return_amount['traveler_balance']) && !empty($return_amount['host_balance'])) {
						$return_amount['traveler_balance'] = $return_amount['traveler_balance'] + $security_deposit;
						$update_seller_balance = $propertyInfo['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
						$update_seller_wallet_balance = $propertyInfo['Property']['User']['available_wallet_amount'] + $return_amount['host_balance'];
						$update_seller_cleared_amount = $propertyInfo['Property']['User']['cleared_amount'] + $return_amount['host_balance'];
						$update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
					} elseif (!empty($return_amount['no_refund'])) {
						$this->_noRefund($propertyInfo, ConstPropertyUserStatus::CanceledByAdmin);
					}
				} else {
					if ($propertyInfo['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
						$return = $this->Payment->_captureProcessOrder($propertyInfo['PropertyUser']['id']);
					}
					$return_amount['traveler_balance'] = $propertyInfo['PropertyUser']['price'] + $security_deposit;
					$return_amount['host_balance'] = $propertyInfo['PropertyUser']['price'] - $propertyInfo['PropertyUser']['host_service_amount'];
					$update_seller_balance = $propertyInfo['Property']['User']['blocked_amount'] - $return_amount['host_balance'];
					$update_buyer_balance = $propertyInfo['User']['available_wallet_amount'] + $return_amount['traveler_balance'];
				}
                if (empty($return['error_message'])) {
                    if (empty($return_amount['no_refund'])) {
                        if (isset($update_seller_balance) && isset($update_buyer_balance)) {
                            $order_status = ConstPropertyUserStatus::CanceledByAdmin;
                            $transaction_status = ConstTransactionTypes::RefundForCanceledProperty;
                            $success_message = __l('Your booking has been canceled by admin');
                            $stat_mess = 'rejected';
                            $ajax_repsonse = 'rejected';
                            $redirect = 'myworks';
                            $to = $host_user_id;
                            $message_sender_user_id = $guest_user_id;
                            $to_user = $guest_username;
                            $sender_email = $host_email;
                            $message_sender_name = $host_username;
                            $message_sender_email = $guest_email;
                            $transaction_user_id = $guest_user_id;
                            $email_message = __l('Your booking has been canceled by admin');
                            $email_message_for_sender = __l('Your booking has been canceled by admin');
                            $mail_template = 'Admin rejected booking notification';
                            $mail_template_for_sender = 'Admin rejected booking host notification';
                            $seller_transaction_status = ConstTransactionTypes::SellerDeductedForCanceledProperty;
                            $success = 1;
                            // Change order status
                            $PropertyUser['PropertyUser']['id'] = $order_id;
                            $PropertyUser['PropertyUser']['property_user_status_id'] = $order_status;
                            $this->PropertyUser->save($PropertyUser);
                            // Update amount to seller ->  reduce 5$ from seller //
							if (empty($return_amount['partially_refund'])) {
								$this->PropertyUser->User->updateAll(array(
									'User.blocked_amount' => "'" . $update_seller_balance . "'"
								) , array(
									'User.id' => $host_user_id
								));
							}
                            // Update amount to Buyer -> add 5$ to buyer balance//
                            $this->PropertyUser->User->updateAll(array(
                                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
                            ) , array(
                                'User.id' => $guest_user_id
                            ));
                            // Update Transactions //
                            $transaction['Transaction']['user_id'] = $transaction_user_id;
                            $transaction['Transaction']['foreign_id'] = $order_id;
                            $transaction['Transaction']['class'] = 'PropertyUser';
                            $transaction['Transaction']['amount'] = $return_amount['traveler_balance'];
                            $transaction['Transaction']['description'] = "Property $stat_mess - Amount Refunded";
                            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CanceledByAdminRefundToTraveler;
                            $this->PropertyUser->User->Transaction->log($transaction);
                            // Updating transaction again for seller //
                            $transaction['Transaction']['id'] = '';
                            $transaction['Transaction']['user_id'] = $propertyInfo['Property']['user_id'];
                            $transaction['Transaction']['foreign_id'] = $order_id;
                            $transaction['Transaction']['class'] = 'PropertyUser';
                            $transaction['Transaction']['amount'] = $return_amount['host_balance'];
                            $transaction['Transaction']['description'] = 'Updating payment status for seller';
                            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::CanceledByAdminRefundFromHost;
                            $this->PropertyUser->User->Transaction->save($transaction);
                            if (!empty($return_amount['partially_refund'])) {
                                // Clear Amount For Seller, since the order has been canceled with no refund to buyer... seller amount will be stll in blocked status... clearing that amount //
                                $this->User->updateAll(array(
									'User.blocked_amount' => "'" . $update_seller_balance . "'",
									'User.cleared_amount' => "'" . $update_seller_cleared_amount . "'",
									'User.available_wallet_amount' => "'" . $update_seller_wallet_balance . "'",
								) , array(
									'User.id' => $host_user_id
								));
                                // Updating transaction again for seller //
                                $transaction['Transaction']['id'] = '';
                                $transaction['Transaction']['user_id'] = $propertyInfo['Property']['User']['id'];
                                $transaction['Transaction']['foreign_id'] = $propertyInfo['PropertyUser']['id'];
                                $transaction['Transaction']['class'] = 'PropertyUser';
                                $transaction['Transaction']['amount'] = $return_amount['host_balance'];
                                $transaction['Transaction']['description'] = 'Amount cleared';
                                $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostAmountCleared;
                                $this->Transaction->save($transaction);
                                $message = __l('According to our Cancellation Policies, partially amount has been refunded to your account.');
                                $message_for_reciever = __l('According to our Cancellation Policies, partially amount has been cleared for your withdrawal. Remaining has been refunded to traveler.');
                            }
                        }
                    }
                }
                break;

            case 'review':
                if (!empty($propertyInfo['PropertyUser']) && ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview)) {
                    $PropertyUser['PropertyUser']['id'] = $order_id;
                    $PropertyUser['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::Completed;
                    $this->PropertyUser->save($PropertyUser);
                    $success = 1;
                    $is_review = 1;
                    $to = $guest_user_id;
                    $message_sender_user_id = $host_user_id;
                    $to_user = $guest_username;
                    $sender_email = $guest_email;
                    $message_sender_name = $host_username;
                    $message_sender_email = $host_email;
                    $email_message = __l('Your booking has been canceled');
                    $email_message_for_sender = __l('You have canceled your booking');
                    $mail_template = 'Canceled booking notification';
                    $mail_template_for_sender = 'Canceled booking traveler notification';
                    $redirect = 'myworks';
                    $success_message = __l('Your work has been delivered successfully!');
                    $status = 'waiting_for_Review';
                } else {
                    $redirect = 'myworks';
                }
                break;

            case 'completed':
                if (!empty($propertyInfo['PropertyUser']) && ($propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived || $propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared || $propertyInfo['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview)) {
                    $PropertyUser['PropertyUser']['id'] = $order_id;
                    $PropertyUser['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
                    $PropertyUser['PropertyUser']['actual_checkout_date'] = date('Y-m-d h:i:s');
                    if ($propertyInfo['PropertyUser']['user_id'] == $_SESSION['Auth']['User']['id']) {
                        $PropertyUser['PropertyUser']['is_traveler_checkout'] = 1;
                        $PropertyUser['PropertyUser']['traveler_checkout_date'] = $data['checkinout'];
                    } else if ($propertyInfo['PropertyUser']['owner_user_id'] == $_SESSION['Auth']['User']['id']) {
                        $PropertyUser['PropertyUser']['is_host_checkout'] = 1;
                        $PropertyUser['PropertyUser']['host_checkout_date'] = $data['checkinout'];
                    }
                    if (isset($data['via']) && $data['via'] == 'ticket') {
                        $PropertyUser['PropertyUser']['checkout_via_ticket'] = 1;
                    }
                    $this->PropertyUser->save($PropertyUser);
                    $success = 1;
                    $is_review = 1;
                    $to = $guest_user_id;
                    $message_sender_user_id = $host_user_id;
                    $to_user = $guest_username;
                    $sender_email = $guest_email;
                    $message_sender_name = $host_username;
                    $message_sender_email = $host_email;
                    $email_message = __l('Your booking has been completed');
                    $email_message_for_sender = __l('Your booking has been completed');
                    // Arrived mail will be sent only for the first time /
                    if ($propertyInfo['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::WaitingforReview) {
                        $mail_template = 'Traveler review notification';
                    }
                    //$mail_template_for_sender = 'Canceled order buyer notification';
                    $success_message = __l('You completed the booking, please give review and ratet the property!');
                    $status = 'completed';
                    $redirect = 'mytours';
                } else {
                    $redirect = 'myorders';
                }
                break;
            }
            if ($success) {
                if (!empty($mail_template)) {
                    $template = $this->EmailTemplate->selectTemplate($mail_template);
                    $emailFindReplace = array(
                        '##USERNAME##' => $to_user,
                        '##PROPERTY_NAME##' => $propertyInfo['Property']['title'],
                        '##PROPERTY##' => $propertyInfo['Property']['title'],
                        '##PROPERTY_ID##' => $join_id,
                        '##TRAVELER##' => $guest_username,
                        '##guest_username##' => $guest_username,
                        '##ORDERNO##' => $order_id,
                        '##REVIEW_URL##' => "<a href=" . Router::url(array(
                            'controller' => 'property_feedbacks',
                            'action' => 'add',
                            'property_order_id' => $propertyInfo['PropertyUser']['id'],
                            'admin' => false
                        ) , true) . ">" . __l('review link') . "</a>",
                        '##VERIFICATION_CODE##' => $verification_code,
                        '##HOST_CONTACT##' => $host_contact,
                        '##JOIN_PRIVATE_DETAILS##' => $private_details,
                        '##GUEST_CONTACT##' => $guest_contact,
                        '##PRINT##' => $print_link,
                        '##MESSAGE##' => $message,
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
                    $get_order_status = $this->PropertyUser->find('first', array(
                        'conditions' => array(
                            'PropertyUser.id' => $order_id
                        ) ,
                        'recursive' => -1
                    ));
                    $message = strtr($template['email_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $property_id, $get_order_status['PropertyUser']['property_user_status_id']);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $email_message;
                            $content['message'] = $email_message;
                            if (!empty($sender_email)) {
                                if ($this->_checkUserNotifications($to, $get_order_status['PropertyUser']['property_user_status_id'], 0)) {
                                    $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Booking Alert Mail');
                                }
                            }
                        }
                        $emailFindReplace['##USERNAME##'] = $message_sender_name;
                        if (!empty($message_for_reciever)) {
                            $emailFindReplace['##MESSAGE##'] = $message_for_reciever;
                        }
                        if (!empty($mail_template_for_sender)) {
                            $template = $this->EmailTemplate->selectTemplate($mail_template_for_sender);
                            $message_for_buyer = strtr($template['email_content'], $emailFindReplace);
                            $subject_for_buyer = strtr($template['subject'], $emailFindReplace);
                            if (Configure::read('messages.send_notification_mail_for_sender')) {
                                $message_id_buyer = $this->Message->sendNotifications($message_sender_user_id, $subject_for_buyer, $message_for_buyer, $order_id, $is_review = 0, $property_id, ConstPropertyUserStatus::SenderNotification);
                                if (Configure::read('messages.is_send_email_on_new_message')) {
                                    $content['subject'] = $email_message_for_sender;
                                    $content['message'] = $email_message_for_sender;
                                    if (!empty($message_sender_email)) {
                                        if ($this->_checkUserNotifications($message_sender_user_id, $get_order_status['PropertyUser']['property_user_status_id'], 1)) {
                                            $this->_sendAlertOnNewMessage($message_sender_email, $content, $message_id_buyer, 'Booking Alert Mail');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $flash_message = $success_message;
            } else {
                $error = 1;
                if (empty($flash_message)) {
                    $flash_message = __l("Booking couldn't be processed at the moment. Try again");
                }
            }
            $status = !empty($status) ? $status : 'all';
            $return['order_id'] = $order_id;
            $return['status'] = $status;
            $return['redirect'] = $redirect;
            $return['flash_message'] = $flash_message;
            $return['ajax_repsonse'] = $ajax_repsonse;
            $return['error'] = (!empty($error) ? $error : '0');
            return $return; //$_SESSION['Auth']['User']['id']

        }
        // After save to update sales and purchase related information after every status gets saved.
        function afterSave()
        {
            /* Quick Fix */
            if (!empty($this->data['PropertyUser']['id'])) {
                $proprtyUser = $this->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $this->data['PropertyUser']['id'],
                    ) ,
                    'fields' => array(
                        'PropertyUser.user_id',
                    ) ,
                    'recursive' => -1,
                ));
                $payment_pending_count = $this->find('count', array(
                    'conditions' => array(
                        'PropertyUser.user_id' => $proprtyUser['PropertyUser']['user_id'],
                        'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
                    ) ,
                    'recursive' => -1,
                ));
                $this->User->updateAll(array(
                    'User.travel_payment_pending_count' => $payment_pending_count
                ) , array(
                    'User.id' => $proprtyUser['PropertyUser']['user_id']
                ));
            }
        }
        // common function to get property details //
        function get_property($property_user_id)
        {
            $property = $this->find('first', array(
                'conditions' => array(
                    'PropertyUser.id' => $property_user_id
                ) ,
                'contain' => array(
                    'Property' => array(
                        'fields' => array(
                            'Property.id',
                            'Property.user_id',
                        ) ,
                    )
                ) ,
                'recursive' => 1
            ));
            return $property;
        }
        // common function to get property counts for various conditions passed //
        function property_count($conditions)
        {
            $property_user_count = $this->find('count', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            return $property_user_count;
        }
        // Used from Cron and Completed, Cleared Stages //
        function _clearAmount($propertyUser)
        {
            App::import('Model', 'Transaction');
            $this->Transaction = new Transaction();
            App::import('Model', 'EmailTemplate');
            $this->EmailTemplate = new EmailTemplate();
            App::import('Model', 'Payment');
            $this->Payment = new Payment();
            $cache_site_name = Cache::read('site_url_for_shell', 'long'); // For link generation during Cron run
            if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && !empty($propertyUser['PropertyUser']['is_delayed_chained_payment'])) {
                $refund = $this->Payment->_executeProcessOrder($propertyUser['PropertyUser']['id']);
            }
            if (empty($refund['error'])) {
                $property_user['PropertyUser']['id'] = $propertyUser['PropertyUser']['id'];
                if ($propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::Completed) {
                    $property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentCleared;
                }
                if (empty($propertyUser['PropertyFeedback']) && !empty($property_user['PropertyUser']['is_auto_checkout'])) {
                    $property_user['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::WaitingforReview;
                }
                $property_user['PropertyUser']['is_payment_cleared'] = 1;
                $this->save($property_user);
                $this->User->updateAll(array(
                    'User.blocked_amount' => 'User.blocked_amount - ' . ($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']) ,
                    'User.cleared_amount' => 'User.cleared_amount + ' . ($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']) ,
                ) , array(
                    'User.id' => $propertyUser['Property']['User']['id']
                ));
                if (($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::Wallet || $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet || $propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) || ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && empty($propertyUser['PropertyUser']['is_delayed_chained_payment']))) {
                    $this->User->updateAll(array(
                        'User.available_wallet_amount' => 'User.available_wallet_amount + ' . ($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount'])
                    ) , array(
                        'User.id' => $propertyUser['Property']['User']['id']
                    ));
                }
                // Updating Revenue in property table
                $getPropertyTotalRevenueAmount = $this->find('first', array(
                    'conditions' => array(
                        'PropertyUser.property_id' => $propertyUser['Property']['id'],
                        'PropertyUser.property_user_status_id' => array(
                            ConstPropertyUserStatus::PaymentCleared
                        ) ,
                    ) ,
                    'fields' => array(
                        'SUM(PropertyUser.price - PropertyUser.host_service_amount) as revenue'
                    ) ,
                    'recursive' => 1
                ));
                if (!empty($getPropertyTotalRevenueAmount['0'])) {
                    $this->Property->UpdateAll(array(
                        'Property.revenue' => $getPropertyTotalRevenueAmount['0']['revenue']
                    ) , array(
                        'Property.id' => $propertyUser['Property']['id']
                    ));
                }
                // Updating transaction again for Host //
                $transaction['Transaction']['id'] = '';
                $transaction['Transaction']['user_id'] = $propertyUser['Property']['User']['id'];
                $transaction['Transaction']['foreign_id'] = $propertyUser['PropertyUser']['id'];
                $transaction['Transaction']['class'] = 'PropertyUser';
                $transaction['Transaction']['amount'] = ($propertyUser['PropertyUser']['price']-$propertyUser['PropertyUser']['host_service_amount']);
                $transaction['Transaction']['description'] = 'Amount cleared';
                $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostAmountCleared;
                $this->Transaction->save($transaction);
                // Send Notification Message //
                $user = $propertyUser['Property']['User']['id'];
                $username = $propertyUser['Property']['User']['username'];
                $template = $this->EmailTemplate->selectTemplate('Cleared amount notification');
                $emailFindReplace = array(
                    '##USERNAME##' => $username,
                    '##PROPERTY_NAME##' => $propertyUser['Property']['title'],
                    '##PROPERTY_ID##' => $join_id,
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
					'##SITE_LINK##' => Router::url('/', true) ,
                );
                $message = strtr($template['email_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $message_id = $this->User->Message->sendNotifications($user, $subject, $message, $propertyUser['PropertyUser']['id'], $is_review = 0, $propertyUser['Property']['id'], ConstPropertyUserStatus::PaymentCleared);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $sender_email = $propertyUser['Property']['User']['email'];
                    $content['subject'] = 'Your amount has been cleared for withdrawal';
                    $content['message'] = 'Your amount has been cleared for withdrawal';
                    $content['cache_site_name'] = $cache_site_name;
                    if (!empty($sender_email)) {
                        if ($this->_checkUserNotifications($user, ConstPropertyUserStatus::PaymentCleared, 0)) {
                            $this->_sendAlertOnNewMessage($sender_email, $content, $message_id, 'Booking Alert Mail');
                        }
                    }
                }
            }
            return true;
        }
        function _noRefund($propertyInfo, $update_status)
        {
            App::import('Model', 'Transaction');
            $this->Transaction = new Transaction();
            // Update Status //
            $PropertyUser['PropertyUser']['id'] = $propertyInfo['PropertyUser']['id'];
            $PropertyUser['PropertyUser']['property_user_status_id'] = $update_status;
            $this->PropertyUser->save($PropertyUser);
            // Setting var for further process //
            $traveler_id = $propertyInfo['PropertyUser']['user_id'];
            $host_id = $propertyInfo['Property']['user_id'];
            $traveler_email = $propertyInfo['User']['email'];
            $host_email = $propertyInfo['Property']['User']['email'];
            $traveler_username = $propertyInfo['User']['username'];
            $host_username = $propertyInfo['Property']['User']['username'];
            // Clear Amount For Host, since the order has been canceled with no refund to buyer... seller amount will be stll in blocked status... clearing that amount //
            $this->User->updateAll(array(
                'User.blocked_amount' => 'User.blocked_amount - ' . ($propertyInfo['PropertyUser']['price']-$propertyInfo['PropertyUser']['host_service_amount']) ,
                'User.cleared_amount' => 'User.cleared_amount + ' . ($propertyInfo['PropertyUser']['price']-$propertyInfo['PropertyUser']['host_service_amount']) ,
            ) , array(
                'User.id' => $host_id
            ));
            // Updating transaction again for Host//
            $transaction['Transaction']['id'] = '';
            $transaction['Transaction']['user_id'] = $propertyInfo['Property']['User']['id'];
            $transaction['Transaction']['foreign_id'] = $propertyInfo['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = ($propertyInfo['PropertyUser']['price']-$propertyInfo['PropertyUser']['host_service_amount']);
            $transaction['Transaction']['description'] = 'Amount cleared';
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostAmountCleared;
            $this->Transaction->save($transaction);
            switch ($update_status) {
                case ConstPropertyUserStatus::Canceled:
                    $mail_template_for_sender = 'Canceled booking notification';
                    $mail_template = 'Canceled booking Traveler notification';
                    $message_for_Traveler = __l('According to our "Cancellation policy", you wont be refund.');
                    $message_for_host = __l('According to our "Cancellation policy", buyer wont be refund and your amount will be cleared for withdrawal.');
                    $email_message = __l('Your booking has been canceled');
                    $email_message_for_sender = __l('You have canceled your booking');
            }
            if (!empty($mail_template)) {
                $template = $this->EmailTemplate->selectTemplate($mail_template);
                $emailFindReplace = array(
                    '##USERNAME##' => $traveler_username,
                    '##PROPERTY_NAME##' => $propertyInfo['Property']['title'],
                    '##PROPERTY_ID##' => $join_id,
                    '##ORDERNO##' => $propertyInfo['PropertyUser']['id'],
                    '##REVIEW_URL##' => "<a href=" . Router::url(array(
                        'controller' => 'property_feedbacks',
                        'action' => 'add',
                        'property_order_id' => $propertyInfo['PropertyUser']['id'],
                        'admin' => false
                    ) , true) . ">" . __l('review link') . "</a>",
                    '##HOST_CONTACT##' => '',
                    '##JOIN_PRIVATE_DETAILS##' => $private_details,//$propertyInfo['Property']['house_manual'],
                    '##GUEST_CONTACT##' => '',
                    '##PRINT##' => '',
                    '##MESSAGE##' => $message_for_Traveler,
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
                $get_order_status = $this->PropertyUser->find('first', array(
                    'conditions' => array(
                        'PropertyUser.id' => $propertyInfo['PropertyUser']['id']
                    ) ,
                    'recursive' => -1
                ));
                $message = strtr($template['email_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                if (Configure::read('messages.is_send_internal_message')) {
                    $message_id = $this->Message->sendNotifications($traveler_id, $subject, $message, $propertyInfo['PropertyUser']['id'], $is_review = 0, $propertyInfo['Property']['id'], $get_order_status['PropertyUser']['property_user_status_id']);
                    if (Configure::read('messages.is_send_email_on_new_message')) {
                        $content['subject'] = $email_message;
                        $content['message'] = $email_message;
                        if (!empty($traveler_email)) {
                            if ($this->_checkUserNotifications($traveler_id, $get_order_status['PropertyUser']['property_user_status_id'], 0)) {
                                $this->_sendAlertOnNewMessage($traveler_email, $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                    $emailFindReplace['##USERNAME##'] = $host_username;
                    $emailFindReplace['##MESSAGE##'] = $message_for_host;
                    if (!empty($mail_template_for_sender)) {
                        $template = $this->EmailTemplate->selectTemplate($mail_template_for_sender);
                        $message_for_buyer = strtr($template['email_content'], $emailFindReplace);
                        if (Configure::read('messages.send_notification_mail_for_sender')) {
                            $message_id_buyer = $this->Message->sendNotifications($host_id, $subject, $message_for_buyer, $propertyInfo['PropertyUser']['id'], $is_review = 0, $propertyInfo['Property']['id'], ConstPropertyUserStatus::SenderNotification);
                            if (Configure::read('messages.is_send_email_on_new_message')) {
                                $content['subject'] = $email_message_for_sender;
                                $content['message'] = $email_message_for_sender;
                                if (!empty($host_email)) {
                                    if ($this->_checkUserNotifications($host_id, $get_order_status['PropertyUser']['property_user_status_id'], 1)) {
                                        $this->_sendAlertOnNewMessage($host_email, $content, $message_id_buyer, 'Booking Alert Mail');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        function _getCalendarMontlyBooking($property_id, $month, $year)
        {
            $conditions = array();
            $conditions['PropertyUser.property_id'] = $property_id;
            // checkin must be within the given month n year //
            $conditions['PropertyUser.checkin >= '] = $year . '-' . $month . '-' . '01' . ' 00:00:00';
            $conditions['PropertyUser.checkin <= '] = $year . '-' . $month . '-' . '31' . ' 00:00:00';
            // must be active status //
            $conditions['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived,
                ConstPropertyUserStatus::WaitingforReview,
                ConstPropertyUserStatus::PaymentCleared,
            );
            $property_users = $this->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'PropertyUser.id',
                    'PropertyUser.checkin',
                    'PropertyUser.checkout',
                    'PropertyUser.price',
                ) ,
                'order' => array(
                    'PropertyUser.checkin' => 'ASC'
                ) ,
                'recursive' => -1
            ));
            return $property_users;
        }
        function _getCalendarWeekBooking($property_id, $checkin, $checkout)
        {
            $conditions = array();
            $conditions['PropertyUser.property_id'] = $property_id;
            // checkin must be within the given month n year //
            $conditions['PropertyUser.checkin >= '] = $checkin;
            $conditions['PropertyUser.checkin <= '] = $checkout;
            // must be active status //
            $conditions['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived,
                ConstPropertyUserStatus::WaitingforReview,
                ConstPropertyUserStatus::PaymentCleared,
            );
            $property_users = $this->find('count', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            return $property_users;
        }
    }
?>