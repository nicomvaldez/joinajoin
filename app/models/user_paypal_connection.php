<?php
class UserPaypalConnection extends AppModel
{
    public $name = 'UserPaypalConnection';
    public $actsAs = array(
        'Aggregatable'
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
        )
    );
    public $hasMany = array(
        'PropertyUser' => array(
            'className' => 'PropertyUser',
            'foreignKey' => 'user_paypal_connection_id',
            'dependent' => true,
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
    var $aggregatingFields = array(
        'charged_amount' => array(
            'mode' => 'real',
            'key' => 'user_paypal_connection_id',
            'foreignKey' => 'user_paypal_connection_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.price)',
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id' => array(
                        0,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::Expired,
                        ConstPropertyUserStatus::CanceledByAdmin,
                    )
                )
            )
        ) ,
        'charged_count' => array(
            'mode' => 'real',
            'key' => 'user_paypal_connection_id',
            'foreignKey' => 'user_paypal_connection_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.user_paypal_connection_id)',
            'conditions' => array(
                'NOT' => array(
                    'PropertyUser.property_user_status_id' => array(
                        0,
                        ConstPropertyUserStatus::Rejected,
                        ConstPropertyUserStatus::Canceled,
                        ConstPropertyUserStatus::Expired,
                        ConstPropertyUserStatus::CanceledByAdmin,
                    )
                )
            )
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'pre_approval_key' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
    }
    // for AES_DECRYPT pre_approval_key
    function afterFind($results) 
    {
        foreach($results as $key => $val) {
            if (!empty($val['UserPaypalConnection']['pre_approval_key'])) {
                $sql = 'SELECT AES_DECRYPT("' . $results[$key]['UserPaypalConnection']['pre_approval_key'] . '","' . Configure::read('Security.salt') . '") as pre_approval_key';
                $decrypt = $this->query($sql);
                $results[$key]['UserPaypalConnection']['pre_approval_key'] = $decrypt[0][0]['pre_approval_key'];
            }
        }
        return $results;
    }
}
?>