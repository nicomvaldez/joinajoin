<?php
class SpamFilter extends AppModel
{
    public $name = 'SpamFilter';
    public $displayField = '';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
    }
}
?>