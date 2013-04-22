<?php
class UserEmploymentsController extends AppController
{
    public $name = 'UserEmployments';
    public function admin_index()
    {
        $this->pageTitle = __l('Employments');
        $conditions = array();
		$this->set('active', $this->UserEmployment->find('count', array(
            'conditions' => array(
                'UserEmployment.is_active' => 1
            )
        )));
        $this->set('inactive', $this->UserEmployment->find('count', array(
            'conditions' => array(
                'UserEmployment.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['UserEmployment.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['UserEmployment.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->UserEmployment->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserEmployment.id' => 'desc'
            )
        );
        $this->set('userEmployments', $this->paginate());
		$moreActions = $this->UserEmployment->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Employment');
        $this->UserEmployment->create();
        if (!empty($this->request->data)) {
            if ($this->UserEmployment->save($this->request->data)) {
                $this->Session->setFlash(__l('Employment has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Employment could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Employment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserEmployment->save($this->request->data)) {
                $this->Session->setFlash(__l('Employment has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Employment could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserEmployment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserEmployment->delete($id)) {
            $this->Session->setFlash(__l('Employment deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>