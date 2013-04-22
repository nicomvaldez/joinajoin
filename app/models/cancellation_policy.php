<?php
class CancellationPolicy extends AppModel
{
    public $name = 'CancellationPolicy';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'cancellation_policy_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'days' => array(
				'rule2' => array(
					'rule' => array(
                        'custom',
                        '/^[0-9]*$/'
                    ) ,
					'allowEmpty' => false,
					'message' => __l('Must be a number without decimal')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'allowEmpty' => false,
					'message' => __l('Required')
				)
            ) ,
			'percentage' => array(
				'rule3' => array(
                    'rule' => array(
                        'range',
                        -1,
                        101
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be a number less than or equal to 100')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Must be a numeric')
                ) ,
				'rule1' => array(
					'rule' => 'notempty',
					'allowEmpty' => false,
					'message' => __l('Required')
				)
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
}
?>