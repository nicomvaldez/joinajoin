<?php
class AmenitiesRequest extends AppModel
{
    public $name = 'AmenitiesRequest';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Amenity' => array(
            'className' => 'Amenity',
            'foreignKey' => 'amenity_id',
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
    }
}
?>