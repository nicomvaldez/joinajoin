<?php
class HolidayTypeRequest extends AppModel
{
    public $name = 'HolidayTypeRequest';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'HolidayType' => array(
            'className' => 'HolidayType',
            'foreignKey' => 'holiday_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Request' => array(
            'className' => 'Request',
            'foreignKey' => 'request_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'holiday_type_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'request_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
}
?>