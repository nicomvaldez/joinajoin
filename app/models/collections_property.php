<?php
class CollectionsProperty extends AppModel
{
    public $name = 'CollectionsProperty';
	public $actsAs = array(
			'List' 
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Collection' => array(
            'className' => 'Collection',
            'foreignKey' => 'collection_id',
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
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'property_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
}
?>