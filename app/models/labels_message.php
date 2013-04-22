<?php
class LabelsMessage extends AppModel
{
    public $name = 'LabelsMessage';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Label' => array(
            'className' => 'Label',
            'foreignKey' => 'label_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
}
?>