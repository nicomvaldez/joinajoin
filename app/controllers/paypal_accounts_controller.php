<?php
class PaypalAccountsController extends AppController
{
    public $name = 'PaypalAccounts';
    public function admin_index() 
    {
        $this->pageTitle = __l('Paypal Accounts');
        $this->PaypalAccount->recursive = 0;
        $this->PaypalAccount->order = array(
            'PaypalAccount.id' => 'DESC'
        );
        $this->set('paypalAccounts', $this->paginate());
    }
}
?>