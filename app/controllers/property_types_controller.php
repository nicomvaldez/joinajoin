<?php
class PropertyTypesController extends AppController
{
    public $name = 'PropertyTypes';
    public function admin_index() 
    {
        $this->pageTitle = __l('Property Types');
        $conditions = array();
		$this->set('active', $this->PropertyType->find('count', array(
            'conditions' => array(
                'PropertyType.is_active' => 1
            )
        )));
        $this->set('inactive', $this->PropertyType->find('count', array(
            'conditions' => array(
                'PropertyType.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['PropertyType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['PropertyType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->PropertyType->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PropertyType.id' => 'desc'
            )
        );
        $this->set('propertyTypes', $this->paginate());
        $moreActions = $this->PropertyType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Property Type');
        $this->PropertyType->create();
        if (!empty($this->request->data)) {
            if ($this->PropertyType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type has been added') , $this->request->data['PropertyType']['name']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type could not be added. Please, try again.') , $this->request->data['PropertyType']['name']) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Property Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->PropertyType->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type has been updated') , $this->request->data['PropertyType']['name']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Property Type could not be updated. Please, try again.') , $this->request->data['PropertyType']['name']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['PropertyType']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyType->delete($id)) {
            $this->Session->setFlash(__l('Property Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>