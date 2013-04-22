<?php
class PrivaciesController extends AppController
{
    public $name = 'Privacies';
    public function admin_index() 
    {
        $this->pageTitle = __l('Privacies');
        $conditions = array();
		$this->set('active', $this->Privacy->find('count', array(
            'conditions' => array(
                'Privacy.is_active' => 1
            )
        )));
        $this->set('inactive', $this->Privacy->find('count', array(
            'conditions' => array(
                'Privacy.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Privacy.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Privacy.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->Privacy->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Privacy.id' => 'desc'
            )
        );
        $this->set('privacies', $this->paginate());
        $moreActions = $this->Privacy->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Privacy');
        $this->Privacy->create();
        if (!empty($this->request->data)) {
            if ($this->Privacy->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Privacy has been added') , $this->request->data['Privacy']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Privacy could not be added. Please, try again.') , $this->request->data['Privacy']['name']) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Privacy');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Privacy->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Privacy has been updated') , $this->request->data['Privacy']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Privacy could not be updated. Please, try again.') , $this->request->data['Privacy']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Privacy->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Privacy']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Privacy->delete($id)) {
            $this->Session->setFlash(__l('Privacy deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>