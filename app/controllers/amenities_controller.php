<?php
class AmenitiesController extends AppController
{
    public $name = 'Amenities';
    public function admin_index() 
    {
        $this->pageTitle = __l('Amenities');
        $conditions = array();
		$this->set('active', $this->Amenity->find('count', array(
            'conditions' => array(
                'Amenity.is_active' => 1
            )
        )));
        $this->set('inactive', $this->Amenity->find('count', array(
            'conditions' => array(
                'Amenity.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Amenity.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Amenity.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->Amenity->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Amenity.id' => 'desc'
            )
        );
        $this->set('amenities', $this->paginate());
        $moreActions = $this->Amenity->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Amenity');
        $this->Amenity->create();
        if (!empty($this->request->data)) {
            if ($this->Amenity->save($this->request->data)) {
                $this->Session->setFlash(__l('Amenity has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Amenity could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Amenity');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Amenity->save($this->request->data)) {
                $this->Session->setFlash(__l('Amenity has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Amenity could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Amenity->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Amenity']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Amenity->delete($id)) {
            $this->Session->setFlash(__l('Amenity deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>