<?php
class CurrencyConversionHistory extends AppModel
{
    public $name = 'CurrencyConversionHistory';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'CurrencyConversion' => array(
            'className' => 'CurrencyConversion',
            'foreignKey' => 'currency_conversion_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        ) ,       
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }	
}
