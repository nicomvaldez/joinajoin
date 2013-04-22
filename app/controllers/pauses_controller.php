<?php
class PausesController extends AppController
{
    public $name = 'Pauses';
	
	public function mant() 
    {
        $this->layout = 'maintenance';	
        //$this->set('msj','Mantenimiento');
    }
}
?>