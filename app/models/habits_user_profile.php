<?php
class HabitsUserProfile extends AppModel
{
    public $name = 'HabitsUserProfile';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Habit' => array(
            'className' => 'Habit',
            'foreignKey' => 'habit_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_profile_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'habit_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'user_profile_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
}
?>