<?php
class BedTypesController extends AppController
{
    public $name = 'BedTypes';
    public function admin_index() 
    {
        $this->pageTitle = __l('Bed Types');
        $conditions = array();
		$this->set('active', $this->BedType->find('count', array(
            'conditions' => array(
                'BedType.is_active' => 1
            )
        )));
        $this->set('inactive', $this->BedType->find('count', array(
            'conditions' => array(
                'BedType.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['BedType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['BedType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->BedType->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'BedType.id' => 'desc'
            )
        );
        $this->set('bedTypes', $this->paginate());
        $moreActions = $this->BedType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Bed Type');
        $this->BedType->create();
        if (!empty($this->request->data)) {
            if ($this->BedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Bed Type has been added') , $this->request->data['BedType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Bed Type could not be added. Please, try again.') , $this->request->data['BedType']['name']) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Bed Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->BedType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Bed Type has been updated') , $this->request->data['BedType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Bed Type could not be updated. Please, try again.') , $this->request->data['BedType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->BedType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['BedType']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BedType->delete($id)) {
            $this->Session->setFlash(__l('Bed Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>