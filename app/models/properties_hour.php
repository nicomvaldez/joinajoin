<?php

class Properties_Hour extends AppModel {
    public $name = 'Properties_hour';
	
	var $validate = array(
        'duration' => array(
            'rule' => 'notempty',
            'allowEmpty' => false,
            'message' =>'Required'
        ),
        'hours_texts' => array(
            'rule' => 'notempty',
            'allowEmpty' => false,
            'message' =>'Required'
        )
	);
		
}


?>