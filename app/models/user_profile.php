<?php
class UserProfile extends AppModel
{
    public $name = 'UserProfile';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Gender' => array(
            'className' => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
		'UserEducation' => array(
            'className' => 'UserEducation',
            'foreignKey' => 'user_education_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserEmployment' => array(
            'className' => 'UserEmployment',
            'foreignKey' => 'user_employment_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserIncomeRange' => array(
            'className' => 'UserIncomeRange',
            'foreignKey' => 'user_incomerange_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserRelationship' => array(
            'className' => 'UserRelationship',
            'foreignKey' => 'user_relationship_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasAndBelongsToMany = array(
        'Habit' => array(
            'className' => 'Habit',
            'joinTable' => 'habits_user_profiles',
            'foreignKey' => 'user_profile_id',
            'associationForeignKey' => 'habit_id',
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
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'dob' => array(
                'rule3' => array(
                    'rule' => '_isValidDob',
                    'message' => __l('Must be a valid date')
                ) ,
                'rule2' => array(
                    'rule' => 'date',
                    'message' => __l('Must be a valid date')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
			 
			'first_name' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => __l('Required')
			),
			'last_name' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => __l('Required')
            )
			 
			  
			 /*
            'gender_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'address' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'paypal_account' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'paypal_first_name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'paypal_last_name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            )*/
        );
    }
    function _isValidDob() 
    {
        return Date('Y') . '-' . Date('m') . '-' . Date('d') >= $this->data[$this->name]['dob'];
    }
}
?>