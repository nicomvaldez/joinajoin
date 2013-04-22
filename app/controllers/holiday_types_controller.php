<?php
class HolidayTypesController extends AppController
{
    public $name = 'HolidayTypes';
    public function admin_index() 
    {
        $this->pageTitle = __l('Holiday Types');
        $conditions = array();
		$this->set('active', $this->HolidayType->find('count', array(
            'conditions' => array(
                'HolidayType.is_active' => 1
            )
        )));
        $this->set('inactive', $this->HolidayType->find('count', array(
            'conditions' => array(
                'HolidayType.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['HolidayType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['HolidayType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->HolidayType->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'HolidayType.id' => 'desc'
            )
        );
        $this->set('holidayTypes', $this->paginate());
        $moreActions = $this->HolidayType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Holiday Type');
        $this->HolidayType->create();
        if (!empty($this->request->data)) {
            if ($this->HolidayType->save($this->request->data)) {
                $this->Session->setFlash(__l('Holiday Type has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Holiday Type could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Holiday Type');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->HolidayType->save($this->request->data)) {
                $this->Session->setFlash(__l('Holiday Type has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Holiday Type could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->HolidayType->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['HolidayType']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->HolidayType->delete($id)) {
            $this->Session->setFlash(__l('Holiday Type deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>