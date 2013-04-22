<?php
class PropertyUserDispute extends AppModel
{
    public $name = 'PropertyUserDispute';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'PropertyUser' => array(
            'className' => 'PropertyUser',
            'foreignKey' => 'property_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeType' => array(
            'className' => 'DisputeType',
            'foreignKey' => 'dispute_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeStatus' => array(
            'className' => 'DisputeStatus',
            'foreignKey' => 'dispute_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'DisputeClosedType' => array(
            'className' => 'DisputeClosedType',
            'foreignKey' => 'dispute_closed_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'property_user_dispute_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->isFilterOptions = array(
            ConstDisputeStatus::Open => __l('Open') ,
            ConstDisputeStatus::UnderDiscussion => __l('UnderDiscussion') ,
            ConstDisputeStatus::WaitingForAdministratorDecision => __l('WaitingForAdministratorDecision') ,
            ConstDisputeStatus::Closed => __l('Closed') ,
        );
        $this->validate = array(
            'dispute_type_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'reason' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
    function _resolveByRefund($dispute) 
    {
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        if (empty($refund['error'])) {
            $refund_percentage = Configure::read('dispute.refund_amount_during_dispute_cancellation');
            $refund_percentage = ($refund_percentage/100);
            $update_seller_balance = $dispute['Property']['User']['blocked_amount']-(($dispute['PropertyUser']['price']-$dispute['PropertyUser']['host_service_amount']) *$refund_percentage); // seller blocked amount - actual job amount
            $update_buyer_balance = $dispute['PropertyUser']['User']['available_wallet_amount']+($dispute['PropertyUser']['price']*$refund_percentage); // Buyer blocked amount + actual job amount
            // Change order status //
            if ($dispute['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
                $PropertyUser['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
                $PropertyUser['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentCleared;
                $this->PropertyUser->save($PropertyUser);
            }
            // Update amount to Host ->  reduce 5$ from seller //
            $this->PropertyUser->User->updateAll(array(
                'User.blocked_amount' => "'" . $update_seller_balance . "'"
            ) , array(
                'User.id' => $dispute['Property']['user_id']
            ));
            // Update amount to Buyer -> add 5$ to buyer balance//
            $this->PropertyUser->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_buyer_balance . "'"
            ) , array(
                'User.id' => $dispute['PropertyUser']['user_id']
            ));
            // Update Transactions //
            $transaction['Transaction']['user_id'] = $dispute['PropertyUser']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = ($dispute['PropertyUser']['price']*$refund_percentage);
            $transaction['Transaction']['description'] = "Property - Amount Refunded";
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::RefundedToTravelerWithDipsuteCancellation;
            $this->PropertyUser->User->Transaction->log($transaction);
            // Updating transaction again for Host //
            $transaction['Transaction']['id'] = '';
            $transaction['Transaction']['user_id'] = $dispute['Property']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = (($dispute['PropertyUser']['price']-$dispute['PropertyUser']['host_service_amount']) *$refund_percentage);
            $transaction['Transaction']['description'] = 'Updating payment status for host';
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::HostAmountCleared;
            $this->PropertyUser->User->Transaction->save($transaction);
        }
    }
	
	function _resolveByDeposit($dispute) 
    {
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        if (empty($refund['error'])) {
            $update_seller_balance =$dispute['Property']['User']['available_wallet_amount']+$dispute['PropertyUser']['security_deposit']; // host security deposit amount
            // Change order status //
            if ($dispute['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
                $PropertyUser['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
                $PropertyUser['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::SentToHost;
                $this->PropertyUser->save($PropertyUser);
            }
            // Update amount to Host ->  reduce 5$ from seller //
            $this->PropertyUser->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_seller_balance . "'"
            ) , array(
                'User.id' => $dispute['Property']['user_id']
            ));
            // Update Transactions //
            $transaction['Transaction']['user_id'] = $dispute['Property']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = $dispute['PropertyUser']['security_deposit'];
            $transaction['Transaction']['description'] = "Security Deposit - Amount Credited";
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::SentToHost;
            $this->PropertyUser->User->Transaction->log($transaction);
        }
    }
	function _resolveByDepositRefund($dispute) 
    {
        App::import('Model', 'Payment');
        $this->Payment = new Payment();
        if (empty($refund['error'])) {

            $update_traveler_balance =$dispute['PropertyUser']['User']['available_wallet_amount']+$dispute['PropertyUser']['security_deposit']; // host security deposit amount
            // Change order status //
            if ($dispute['PropertyUser']['security_deposit_status'] == ConstSecurityDepositStatus::Blocked) {
                $PropertyUser['PropertyUser']['id'] = $dispute['PropertyUser']['id'];
                $PropertyUser['PropertyUser']['security_deposit_status'] = ConstSecurityDepositStatus::RefundedToTraveler;
                $this->PropertyUser->save($PropertyUser);
            }
            // Update amount to Host ->  reduce 5$ from seller //
            $this->PropertyUser->User->updateAll(array(
                'User.available_wallet_amount' => "'" . $update_traveler_balance . "'"
            ) , array(
                'User.id' => $dispute['PropertyUser']['user_id']
            ));
            // Update Transactions //
            $transaction['Transaction']['user_id'] = $dispute['PropertyUser']['user_id'];
            $transaction['Transaction']['foreign_id'] = $dispute['PropertyUser']['id'];
            $transaction['Transaction']['class'] = 'PropertyUser';
            $transaction['Transaction']['amount'] = $dispute['PropertyUser']['security_deposit'];
            $transaction['Transaction']['description'] = "Security Deposit - Amount Refunded";
            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::RefundedToTraveler;
            $this->PropertyUser->User->Transaction->log($transaction);
        }
    }
    function _resolveByReview($dispute) 
    {
        $feedback = $this->Property->PropertyFeedback->_getFeedback($dispute['PropertyUser']['id']);
        $update_feedback_message = __l("Based on Dispute ID#") . $dispute['PropertyUserDispute']['id'] . ' ' . __l("Feedback has been changed by site administrator") . '. ';
        $update_feedback_message.= "<p>" . __l("Original Feedback:") . ' ' . $feedback['PropertyFeedback']['feedback'] . "</p>";
        $propertyFeedback['PropertyFeedback']['id'] = $feedback['PropertyFeedback']['id'];
        $propertyFeedback['PropertyFeedback']['feedback'] = $update_feedback_message;
        $propertyFeedback['PropertyFeedback']['is_satisfied'] = 1;
        $this->Property->PropertyFeedback->save($propertyFeedback, false);
    }
	// @todo "Auto review" _resolveByTravlerReview function
    function _closeDispute($close_type, $dispute) 
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        // SENDING CLOSE DISPUTE MAIL //
        $template = $this->EmailTemplate->selectTemplate("Dispute Resolved Notification");
        $emailFindReplace = array(
            '##ORDER_ID##' => $dispute['PropertyUserDispute']['property_user_id'],
            '##DISPUTE_ID##' => $dispute['PropertyUserDispute']['id'],
            '##DISPUTER##' => $dispute['User']['username'],
            '##DISPUTER_USER_TYPE##' => (!empty($dispute['PropertyUserDispute']['is_traveler']) ? $dispute['User']['username'] : $dispute['Property']['User']['username']) ,
            '##REASON##' => $dispute['PropertyUserDispute']['reason'],
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
        if (!empty($close_type['close_type_8'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('8');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 0;
        } elseif (!empty($close_type['close_type_4'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('4');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 0;
        } elseif (!empty($close_type['close_type_1'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('1');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        } elseif (!empty($close_type['close_type_7'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('7');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        } elseif (!empty($close_type['close_type_6'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('6');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 0;
        }elseif (!empty($close_type['close_type_10'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('10');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        }elseif (!empty($close_type['close_type_11']) || !empty($close_type['close_type_12'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('11');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        } elseif (!empty($close_type['close_type_9'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('9');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 0;
        } elseif (!empty($close_type['close_type_2'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Host") . ' (' . $dispute['Property']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('2');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 0;
        } elseif (!empty($close_type['close_type_3'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('3');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        } elseif (!empty($close_type['close_type_5'])) {
            $emailFindReplace['##FAVOUR_USER##'] = __l("Traveler") . ' (' . $dispute['PropertyUser']['User']['username'] . ')';
            $reason_for_closing = $this->DisputeClosedType->getDisputeClosedType('5');
            $emailFindReplace['##REASON_FOR_CLOSING##'] = $reason_for_closing['DisputeClosedType']['reason'];
            $emailFindReplace['##RESOLVED_BY##'] = $reason_for_closing['DisputeClosedType']['resolve_type'];
            $favour_user_type_id = 1;
        }
        if (Configure::read('messages.is_send_internal_message')) {
            $users = array(
                $dispute['Property']['User']['id'] => $dispute['Property']['User']['username'],
                $dispute['PropertyUser']['User']['id'] => $dispute['PropertyUser']['User']['username']
            );
            $k = 0;
            foreach($users as $key => $value) {
                $username = $value;
                $user = $key;
                $emailFindReplace['##USERNAME##'] = $username;
                $message = strtr($template['email_content'], $emailFindReplace);
                $subject = strtr($template['subject'], $emailFindReplace);
                $disp_stat = ($k == 0) ? ConstPropertyUserStatus::DisputeClosed : ConstPropertyUserStatus::DisputeClosedTemp;
                $message_id = $this->Message->sendNotifications($user, $subject, $message, $dispute['PropertyUserDispute']['property_user_id'], '0', $dispute['PropertyUserDispute']['property_id'], $disp_stat, $dispute['PropertyUserDispute']['id']);
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $sender_emails = array(
                        $dispute['Property']['User']['email'],
                        $dispute['User']['email']
                    );
                    $content['subject'] = $subject;
                    $content['message'] = $subject;
                    if ($this->_checkUserNotifications($sender_emails[$k], ConstPropertyUserStatus::DisputeOpened, 0)) {
                        $this->_sendAlertOnNewMessage($sender_emails[$k], $content, $message_id, 'Booking Alert Mail');
                    }
                    $k++;
                }
            }
        }
        // END OF SENDING MAIL //
        // UN-HOLDING ORDER PROCESS //
        $this->PropertyUser->updateAll(array(
            'PropertyUser.is_under_dispute' => 0
        ) , array(
            'PropertyUser.id' => $dispute['PropertyUserDispute']['property_user_id']
        ));
        // END OF HOLD //
        // UPDATING DISPUTE STATUS ORDER PROCESS //
        $this->updateAll(array(
            'PropertyUserDispute.dispute_status_id' => ConstDisputeStatus::Closed,
            'PropertyUserDispute.resolved_date' => "'" . date('Y-m-d H:i:s') . "'",
            'PropertyUserDispute.is_favor_traveler' => $favour_user_type_id,
            'PropertyUserDispute.dispute_closed_type_id' => $reason_for_closing['DisputeClosedType']['id'],
        ) , array(
            'PropertyUserDispute.id' => $dispute['PropertyUserDispute']['id']
        ));
        // END OF STATUS UPDATE //
        
    }
}
?>