<?php
class User extends AppModel
{
    public $name = 'User';
    public $displayField = 'username';
    public $belongsTo = array(
        'UserType' => array(
            'className' => 'UserType',
            'foreignKey' => 'user_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ReferredByUser' => array(
            'className' => 'User',
            'foreignKey' => 'referred_by_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    var $aggregatingFields = array(
        'property_pending_approval_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'Property',
            'function' => 'COUNT(Property.user_id)',
            'conditions' => array(
                'Property.is_approved' => 0
            )
        ) ,
        'property_inactive_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'Property',
            'function' => 'COUNT(Property.user_id)',
            'conditions' => array(
                'Property.is_active' => 0
            )
        ) ,
        'host_expired_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Expired,
            )
        ) ,
        'host_canceled_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::CanceledByAdmin,
				)
            )
        ) ,
        'host_rejected_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Rejected,
            )
        ) ,
        'host_completed_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Completed,
            )
        ) ,
        'host_review_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::PaymentCleared,
					ConstPropertyUserStatus::Completed,
				) ,
                'PropertyUser.is_host_reviewed' => 0,
            )
        ) ,
        'host_arrived_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Arrived,
            )
        ) ,
        'host_confirmed_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Confirmed,
            )
        ) ,
        'host_waiting_for_acceptance_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance,
            )
        ) ,
        'host_payment_cleared_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1,
            )
        ) ,
        'host_negotiation_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
                'PropertyUser.is_negotiation_requested' => 1,
                'PropertyUser.user_id >' => 0,
				'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
            )
        ) ,
		'host_total_booked_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::WaitingforAcceptance,
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::PaymentCleared,
					ConstPropertyUserStatus::Completed,
				)
            )
        ) ,
		'host_total_pipeline_amount' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(`PropertyUser`.`price` - `PropertyUser`.`host_service_amount`)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::Completed
				) ,
				'PropertyUser.is_payment_cleared' => 0,
            )
        ) ,
		'host_total_lost_booked_count' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.owner_user_id)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Rejected,
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::Expired,
					ConstPropertyUserStatus::CanceledByAdmin
				)
            )
        ) ,
		'host_total_lost_amount' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(`PropertyUser`.`price` - `PropertyUser`.`host_service_amount`)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Rejected,
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::Expired,
					ConstPropertyUserStatus::CanceledByAdmin
				)
            )
        ) ,
		'host_total_earned_amount' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(`PropertyUser`.`price` - `PropertyUser`.`host_service_amount`)',
            'conditions' => array(
				'PropertyUser.is_payment_cleared' => 1
            )
        ) ,
		'host_total_site_revenue' => array(
            'mode' => 'real',
            'key' => 'owner_user_id',
            'foreignKey' => 'owner_user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.host_service_amount)',
            'conditions' => array(
				'PropertyUser.is_payment_cleared' => 1
            )
        ) ,
        'travel_negotiation_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.is_negotiation_requested' => 1,
                'PropertyUser.user_id >' => 0,
				'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,

            )
        ) ,
        'travel_expired_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Expired,
            )
        ) ,
        'travel_canceled_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::CanceledByAdmin,
				)
            )
        ) ,
        'travel_rejected_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Rejected,
            )
        ) ,
        'travel_payment_pending_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentPending,
            )
        ) ,
        'travel_payment_cleared_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::PaymentCleared,
            )
        ) ,
        'travel_completed_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Completed,
				// @todo "Auto review" add condition CompletedAndClosedByAdmin
            )
        ) ,
        'travel_review_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforReview,
            )
        ) ,
        'travel_arrived_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Arrived,
            )
        ) ,
        'travel_confirmed_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::Confirmed,
            )
        ) ,
        'traveler_positive_feedback_count' => array(
            'mode' => 'real',
            'key' => 'traveler_user_id',
            'foreignKey' => 'traveler_user_id',
            'model' => 'PropertyUserFeedback',
            'function' => 'COUNT(PropertyUserFeedback.traveler_user_id)',
            'conditions' => array(
                'PropertyUserFeedback.is_satisfied' => 1,
            )
        ) ,
        'traveler_property_user_count' => array(
            'mode' => 'real',
            'key' => 'traveler_user_id',
            'foreignKey' => 'traveler_user_id',
            'model' => 'PropertyUserFeedback',
            'function' => 'COUNT(PropertyUserFeedback.traveler_user_id)',
        ) ,
        'travel_waiting_for_acceptance_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => ConstPropertyUserStatus::WaitingforAcceptance,
            )
        ) ,
		'travel_total_booked_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::WaitingforAcceptance,
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::PaymentCleared,
					ConstPropertyUserStatus::Completed,
				)
            )
        ) ,
		'travel_total_booked_amount' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.price)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::WaitingforAcceptance,
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::PaymentCleared,
					ConstPropertyUserStatus::Completed,
				)
            )
        ) ,
		'travel_total_lost_booked_count' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_id)',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Rejected,
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::Expired,
					ConstPropertyUserStatus::CanceledByAdmin
				)
            )
        ) ,
		'travel_total_site_revenue' => array(
            'mode' => 'real',
            'key' => 'user_id',
            'foreignKey' => 'user_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.traveler_service_amount)',
            'conditions' => array(
				'PropertyUser.is_payment_cleared' => 1
            )
        ) ,
    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
		'SendMoney' => array(
            'className' => 'SendMoney',
            'foreignKey' => 'user_id',
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
        'UserFacebookFriend' => array(
            'className' => 'UserFacebookFriend',
            'foreignKey' => 'user_id',
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
        'UserComment' => array(
            'className' => 'UserComment',
            'foreignKey' => 'user_id',
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
        'CkSession' => array(
            'className' => 'CkSession',
            'foreignKey' => 'user_id',
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
	  'PaypalAccount' => array(
		'className' => 'PaypalAccount',
		'foreignKey' => 'user_id',
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
        'UserOpenid' => array(
            'className' => 'UserOpenid',
            'foreignKey' => 'user_id',
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
        'PropertyUser' => array(
            'className' => 'PropertyUser',
            'foreignKey' => 'user_id',
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
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'user_id',
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
        'UserLogin' => array(
            'className' => 'UserLogin',
            'foreignKey' => 'user_id',
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
        'MessageFilter' => array(
            'className' => 'MessageFilter',
            'foreignKey' => 'user_id',
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
        'UserCashWithdrawal' => array(
            'className' => 'UserCashWithdrawal',
            'foreignKey' => 'user_id',
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
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'user_id',
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
        'UserView' => array(
            'className' => 'UserView',
            'foreignKey' => 'user_id',
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
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'user_id',
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
        'Affiliate' => array(
            'className' => 'Affiliate',
            'foreignKey' => 'affliate_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
        'AffiliateCashWithdrawal' => array(
            'className' => 'AffiliateCashWithdrawal',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
        'AffiliateRequest' => array(
            'className' => 'AffiliateRequest',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ) ,
        'UserPaypalConnection' => array(
            'className' => 'UserPaypalConnection',
            'foreignKey' => 'user_id',
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
        'UserFriend' => array(
            'className' => 'UserFriend',
            'foreignKey' => 'user_id',
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
        'UserPaymentProfile' => array(
            'className' => 'UserPaymentProfile',
            'foreignKey' => 'user_id',
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
            'foreignKey' => 'user_id',
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
		'MoneyTransferAccount' => array(
            'className' => 'MoneyTransferAccount',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        )
    );
    public $hasOne = array(
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserAvatar' => array(
            'className' => 'UserAvatar',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'UserAvatar.class' => 'UserAvatar',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CkSession' => array(
            'className' => 'CkSession',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
            'username' => array(
                'rule5' => array(
                    'rule' => array(
                        'between',
                        3,
                        20
                    ) ,
                    'message' => __l('Must be between of 3 to 20 characters')
                ) ,
                'rule4' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __l('Only use letters and numbers.')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Username is already exist')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[a-zA-Z]/'
                    ) ,
                    'message' => __l('Must be start with an alphabets')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'email' => array(
                'rule4' => array(
                    'rule' => 'isUnique',
                    'on' => 'create',
                    'message' => __l('Email address is already exist')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'on' => 'update',
                    'message' => __l('Email address is already exist')
                ) ,
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'passwd' => array(
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'old_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkOldPassword',
                        'old_password'
                    ) ,
                    'message' => __l('Your old password is incorrect, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_isPasswordSame',
                        'passwd',
                        'confirm_password'
                    ) ,
                    'message' => __l('New and confirm password field must match, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => array(
                        '_isValidCaptcha',
                        'register',
                        'captcha'
                    ) ,
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'ajax_captcha' => array(
                'rule2' => array(
                    'rule' => array(
                        '_isValidCaptcha',
                        'ajax_register',
                        'ajax_captcha'
                    ) ,
                    'message' => __l('Please enter valid captcha')
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
            'message' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'amount' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'send_to' => array(
                'rule1' => array(
                    'rule' => 'checkMultipleEmail',
                    'message' => __l('Must be a valid email') ,
                    'allowEmpty' => true
                )
            ) ,
            'amount' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            )
        );
        $this->validateCreditCard = array(
            'firstName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'lastName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'creditCardNumber' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'expiration_month' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'expiration_year' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'cvv2Number' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
        // filter options in admin index
        $this->isFilterOptions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::OpenID => __l('OpenID') ,
            ConstMoreAction::Facebook => __l('Facebook') ,
            ConstMoreAction::Twitter => __l('Twitter')
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::Export => __l('Export')
        );
        $this->bulkMailOptions = array(
            1 => __l('All Users') ,
            2 => __l('Inactive Users') ,
            3 => __l('Active Users')
        );
    }
    // check the new and confirm password
    function _isPasswordSame($field1 = array() , $field2 = null, $field3 = null) 
    {
        if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
            return true;
        }
        return false;
    }
    // check the old password field with database
    function _checkOldPassword($field1 = array() , $field2 = null) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ) ,
            'recursive' => -1
        ));
        if (AuthComponent::password($this->data[$this->name][$field2]) == $user['User']['password']) {
            return true;
        }
        return false;
    }
    // hash for forgot password mail
    function getResetPasswordHash($user_id = null) 
    {
        return md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt'));
    }
    // check the forgot password hash
    function isValidResetPasswordHash($user_id = null, $hash = null) 
    {
        return (md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt')) == $hash);
    }
    // hash for activate mail
    function getActivateHash($user_id = null) 
    {
        return md5($user_id . '-' . Configure::read('Security.salt'));
    }
    // check the activate mail
    function isValidActivateHash($user_id = null, $hash = null) 
    {
        return (md5($user_id . '-' . Configure::read('Security.salt')) == $hash);
    }
    // hash for resend activate mail
    function getResendActivateHash($user_id = null) 
    {
        return md5(Configure::read('Security.salt') . '-' . $user_id);
    }
    // check the resend activate hash
    function isValidResendActivateHash($user_id = null, $hash = null) 
    {
        return (md5(Configure::read('Security.salt') . '-' . $user_id) == $hash);
    }
    function checkMultipleEmail() 
    {
        $multipleEmails = explode(',', $this->data['User']['send_to']);
        foreach($multipleEmails as $key => $singleEmail) {
            if (!Validation::email(trim($singleEmail))) {
                return false;
            }
        }
        return true;
    }
    function getUserIdHash($user_ids = null) 
    {
        return md5($user_ids . Configure::read('Security.salt'));
    }
    function isValidUserIdHash($user_ids = null, $hash = null) 
    {
        return (md5($user_ids . Configure::read('Security.salt')) == $hash);
    }
    function checkUserBalance($user_id = null) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.available_wallet_amount',
                'User.blocked_amount',
                'User.cleared_amount',
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount']) {
            return $user['User']['available_wallet_amount'];
        }
        return false;
    }
    function checkUsernameAvailable($username) 
    {
        $user = $this->find('count', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'recursive' => -1
        ));
        if (!empty($user)) {
            return false;
        }
        return $username;
    }
    function afterSave() 
    {
        if (!empty($this->data['User']['referred_by_user_id'])) { // Updating referred user count
            $user_refer_count = $this->find('count', array(
                'conditions' => array(
                    'User.referred_by_user_id' => $this->data['User']['referred_by_user_id']
                ) ,
                'recursive' => -1
            ));
            $this->updateAll(array(
                'User.user_referred_count' => $user_refer_count,
            ) , array(
                'User.id' => $this->data['User']['referred_by_user_id']
            ));
        }
        // Saving notifications during registerations
        $notify = array();
        App::import('Model', 'UserNotification');
        $this->UserNotification = new UserNotification();
        $check_user_notification_exist = $this->UserNotification->find('first', array(
            'conditions' => array(
                'UserNotification.user_id' => $this->id
            ) ,
            'recursive' => -1
        ));
        if (empty($check_user_notification_exist) && !empty($this->id)) {
            $notify['UserNotification']['user_id'] = $this->id;
            $this->UserNotification->save($notify['UserNotification']);
        }
    }
    function _checkMinimumAmount() 
    {
        $amount = $this->data['User']['amount'];
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            return false;
        }
        return true;
    }
    function _checkamount($amount) 
    {
        if (!empty($amount) && !is_numeric($amount)) {
            $this->validationErrors['amount'] = __l('Amount should be Numeric');
        }
        if (empty($amount)) {
            $this->validationErrors['amount'] = __l('Required');
        }
        if (!empty($amount) && $amount < Configure::read('wallet.min_wallet_amount')) {
            $this->validationErrors['amount'] = __l('Amount should be greater than minimum amount');
        }
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
			$currency_code = Configure::read('site.currency_id');
			Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
            $this->validationErrors['amount'] = sprintf(__l('Given amount should lies from  %s%s to %s%s') , Configure::read('site.currency') , Configure::read('wallet.min_wallet_amount') , Configure::read('site.currency') , Configure::read('wallet.max_wallet_amount'));
        }
        return false;
    }
    function _checkMAximumAmount() 
    {
        $amount = $this->data['User']['amount'];
        if (Configure::read('wallet.max_wallet_amount') && !empty($amount) && $amount > Configure::read('wallet.max_wallet_amount')) {
            return false;
        }
        return true;
    }
}
?>