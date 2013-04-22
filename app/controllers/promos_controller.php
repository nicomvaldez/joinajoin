<?php
class PromosController extends AppController
{
    public $name = 'Promos';
     
     
    public function index() 
    {
        $this->set('title_for_layout','Welcome to Joinajoin.com');
        $this->layout = '';
    }
    
}// end class

    