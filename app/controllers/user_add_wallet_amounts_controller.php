<?php
class UserAddWalletAmountsController extends AppController
{
    public $name = 'UserAddWalletAmounts';
    public function admin_index() 
    {
        $this->pageTitle = __l('User Add Wallet Amounts');
        $this->UserAddWalletAmount->recursive = 0;
        $this->set('userAddWalletAmounts', $this->paginate());
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserAddWalletAmount->delete($id)) {
            $this->Session->setFlash(__l('User Add Wallet Amount deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>