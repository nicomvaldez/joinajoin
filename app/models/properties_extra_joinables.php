<?php

class Properties_extra_joinables extends AppModel {
        public $name = 'Properties_extra_joinables';

		var $validate = array(
            'item_price_hour' => array(
                'rule' => 'numeric',
                'message' =>'Only Numbers'
            ), 
            'item_price_day' => array(
                'rule' => 'numeric',
                'message' =>'Only Numbers'
            ),
            'item_price_week' => array(
                'rule' => 'numeric',
                'message' =>'Only Numbers'
            )
		);
		
}

?>