<?php
class MessageFolder extends AppModel
{
    public $name = 'MessageFolder';
    public $displayField = 'name';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_folder_id',
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
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
}
?>