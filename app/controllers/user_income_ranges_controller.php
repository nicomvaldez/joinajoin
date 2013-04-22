<?php
class UserIncomeRangesController extends AppController
{
    public $name = 'UserIncomeRanges';
    public function admin_index()
    {
        $this->pageTitle = __l('Income Ranges');
        $conditions = array();
		$this->set('active', $this->UserIncomeRange->find('count', array(
            'conditions' => array(
                'UserIncomeRange.is_active' => 1
            )
        )));
        $this->set('inactive', $this->UserIncomeRange->find('count', array(
            'conditions' => array(
                'UserIncomeRange.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['UserIncomeRange.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['UserIncomeRange.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->UserIncomeRange->recursive = -1;
		$this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserIncomeRange.id' => 'desc'
            )
        );
        $this->set('userIncomeRanges', $this->paginate());
		$moreActions = $this->UserIncomeRange->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Income Range');
        $this->UserIncomeRange->create();
        if (!empty($this->request->data)) {
            if ($this->UserIncomeRange->save($this->request->data)) {
                $this->Session->setFlash(__l('Income Range has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Income Range could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Income Range');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserIncomeRange->save($this->request->data)) {
                $this->Session->setFlash(__l('Income Range has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Income Range could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserIncomeRange->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserIncomeRange']['id'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserIncomeRange->delete($id)) {
            $this->Session->setFlash(__l('Income Range deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>