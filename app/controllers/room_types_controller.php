<?php
class RoomTypesController extends AppController
{
    public $name = 'RoomTypes';
    public function admin_index() 
    {
        $this->pageTitle = __l('Room Types');
        $conditions = array();
		$this->set('active', $this->RoomType->find('count', array(
            'conditions' => array(
                'RoomType.is_active' => 1
            )
        )));
        $this->set('inactive', $this->RoomType->find('count', array(
            'conditions' => array(
                'RoomType.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['RoomType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['RoomType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->RoomType->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'RoomType.id' => 'desc'
            )
        );
        $this->set('roomTypes', $this->paginate());
        $moreActions = $this->RoomType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Room Type');
        if (!empty($this->request->data)) {
            $this->RoomType->create();
            if ($this->RoomType->save($this->request->data)) {
                $this->Session->setFlash(__l('Room Type has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Room Type could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Room Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->RoomType->save($this->request->data)) {
                $this->Session->setFlash(__l('Room Type has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Room Type could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->RoomType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['RoomType']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RoomType->delete($id)) {
            $this->Session->setFlash(__l('Room Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>