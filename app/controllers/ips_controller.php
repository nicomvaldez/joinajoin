<?php
class IpsController extends AppController
{
    public $name = 'Ips';
    public function admin_index() 
    {
        $this->pageTitle = __l('IPs');
        $this->Ip->recursive = 0;
        $this->set('ips', $this->paginate());
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Ip->delete($id)) {
            $this->Session->setFlash(__l('Ip deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>