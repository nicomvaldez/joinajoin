<?php
class Message extends AppModel
{
    public $name = 'Message';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $actsAs = array(
        'Aggregatable'
    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserProfile' => array(
             'className' => 'UserProfile',
            'foreignKey' => '',
            'conditions' => 'UserProfile.user_id = Message.user_id',
            'fields' => '',
            'order' => ''
        ),
        'OtherUser' => array(
            'className' => 'User',
            'foreignKey' => 'other_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'MessageContent' => array(
            'className' => 'MessageContent',
            'foreignKey' => 'message_content_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'MessageFolder' => array(
            'className' => 'MessageFolder',
            'foreignKey' => 'message_folder_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
		'Request' => array(
            'className' => 'Request',
            'foreignKey' => 'request_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'PropertyUser' => array(
            'className' => 'PropertyUser',
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
        'PropertyUserStatus' => array(
            'className' => 'PropertyUserStatus',
            'foreignKey' => 'property_user_status_id',
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
    );
    public $hasAndBelongsToMany = array(
        'Label' => array(
            'className' => 'Label',
            'joinTable' => 'labels_messages',
            'foreignKey' => 'message_id',
            'associationForeignKey' => 'label_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    public $hasMany = array(
        'PropertyUserDispute' => array(
            'className' => 'PropertyUserDispute',
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
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'message_content_id' => array(
                'numeric'
            ) ,
            'message_folder_id' => array(
                'numeric'
            ) ,
            'is_sender' => array(
                'numeric'
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
			'amount' => array(
                'rule2' => array(
                    'rule' => 'isValidDiscountAmount',
                    'message' => __l('Exceeded the allowed discount amount, give less than ').Configure::read('site.maximum_negotiation_allowed_discount').__l('%') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'message' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear flag') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }

	function isValidDiscountAmount() 
    {
        if ($this->data[$this->name]['amount']>Configure::read('site.maximum_negotiation_allowed_discount')) {
            return false;
        } else {
            return true;
        }
    }
    function myUsedSpace() 
    {
        // to retreive my used mail space
        $size = $this->find('all', array(
            'conditions' => array(
                'is_deleted' => 0,
                'OR' => array(
                    array(
                        'Message.user_id' => $_SESSION['Auth']['User']['id']
                    ) ,
                    array(
                        'Message.other_user_id' => $_SESSION['Auth']['User']['id']
                    )
                )
            ) ,
            'fields' => 'SUM(Message.size) AS size',
            'recursive' => -1,
        ));
        return $size[0][0]['size'];
    }
    function myMessagePageSize() 
    {
        // it returns the user's imbox page size or default styel decide by config
        $message_page_size = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $_SESSION['Auth']['User']['id']
            ) ,
            'fields' => array(
                'UserProfile.message_page_size'
            ) ,
            'recursive' => -1
        ));
        if (!empty($message_page_size['UserProfile']['message_page_size'])) {
            $limit = $message_page_size['UserProfile']['message_page_size'];
        } else {
            $limit = Configure::read('messages.page_size');
        }
        return $limit;
    }
    function getMessageOptionArray($folder_type) 
    {
        $options = array();
        $options['More actions'] = __l('---- More actions ----');
        $options['Mark as read'] = __l('Mark as read');
        $options['Mark as unread'] = __l('Mark as unread');
        $options['Create Label'] = __l('Create Label');
        $options['Add star'] = __l('Add star');
        $options['Remove star'] = __l('Remove star');
        if ($folder_type != 'inbox' && $folder_type != 'sent') {
            $options['Move to inbox'] = 'Move to inbox';
        }
        $labels = $this->Label->LabelsUser->find('all', array(
            'conditions' => array(
                'LabelsUser.user_id' => $_SESSION['Auth']['User']['id']
            )
        ));
        if (!empty($labels)) {
            $options['Apply label'] = __l('----Apply label----');
            foreach($labels as $label) {
				if (!empty($label['Label']['slug']) && !empty($label['Label']['name'])) {
	                $options['##apply##' . $label['Label']['slug']] = $label['Label']['name'];
				}
            }
            $options['Remove label'] = __l('----Remove label----');
            foreach($labels as $label) {
				if (!empty($label['Label']['slug']) && !empty($label['Label']['name'])) {
	                $options['##remove##' . $label['Label']['slug']] = $label['Label']['name'];
				}
            }
        }
        return $options;
    }
    function sendNotifications($to, $subject, $message, $order_id, $is_review = 0, $property_id, $property_user_status_id = null, $property_user_dispute_id = null, $from = null) 
    {
        //  to save message content
        $message_content['MessageContent']['id'] = '';
        $message_content['MessageContent']['subject'] = $subject;
        $message_content['MessageContent']['message'] = $message;
        $this->MessageContent->save($message_content);
        $message_id = $this->MessageContent->id;
        $size = strlen($subject) +strlen($message);
        if($from == null){
        	$from = ConstUserIds::Admin;//si le mando 0 o nada pone al admin, sino lo que le mando :)
        }
        $property_user_status_id = !empty($property_user_status_id) ? $property_user_status_id : '0';
        // To save in inbox //
        $is_saved = $this->saveMessage($to, $from, $message_id, ConstMessageFolder::Inbox, 0, 0, 0, $size, $property_id, $order_id, $is_review, $property_user_status_id, $property_user_dispute_id);
        // To save in sent iteams //
        $is_saved = $this->saveMessage($from, $to, $message_id, ConstMessageFolder::SentMail, 1, 1, 0, $size, $property_id, $order_id, $is_review, $property_user_status_id, $property_user_dispute_id);
        return $message_id;
    }
    function saveMessage($user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $property_id = null, $order_id = null, $is_review = 0, $property_user_status_id = 0, $property_user_dispute_id = null) 
    {
        $message['Message']['message_content_id'] = $message_id;
        $message['Message']['user_id'] = $user_id;
        $message['Message']['other_user_id'] = $other_user_id;
        $message['Message']['message_folder_id'] = $folder_id;
        $message['Message']['is_sender'] = $is_sender;
        $message['Message']['is_read'] = $is_read;
        $message['Message']['parent_message_id'] = $parent_id;
        $message['Message']['size'] = $size;
        $message['Message']['property_id'] = $property_id;
        $message['Message']['property_user_id'] = $order_id;
        $message['Message']['is_review'] = $is_review;
        $message['Message']['property_user_status_id'] = $property_user_status_id;
        if (!empty($property_user_dispute_id)) {
            $message['Message']['property_user_dispute_id'] = $property_user_dispute_id;
        }
        $this->create();
        $this->save($message);
        $id = $this->id;
        $hash = md5(Configure::read('Security.salt') . $id);
        $message['Message']['id'] = $id;
        $message['Message']['hash'] = $hash;
        $this->save($message);
        return $id;
    }
}
?>