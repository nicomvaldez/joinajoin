<?php
class RequestViewsController extends AppController
{
    public $name = 'RequestViews';
    public function admin_index() 
    {
        $this->pageTitle = __l('Request Views');
        $conditions = array();
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(RequestView.created) <= '] = 0;
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(RequestView.created) <= '] = 7;
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(RequestView.created) <= '] = 30;
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['request'])) {
            $request = $this->RequestView->Request->find('first', array(
                'conditions' => array(
                    'Request.slug' => $this->request->params['named']['request']
                ) ,
                'fields' => array(
                    'Request.id',
                    'Request.title'
                ) ,
                'recursive' => -1
            ));
            $conditions['RequestView.request_id'] = $request['Request']['id'];
            $this->pageTitle.= ' - ' . $request['Request']['title'];
        }
        if (!empty($this->request->params['named']['request_id'])) {
            $conditions['RequestView.request_id'] = $this->request->params['named']['request_id'];
            $project_name = $this->RequestView->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->params['named']['request_id'],
                ) ,
                'fields' => array(
                    'Request.title',
                ) ,
                'recursive' => -1,
            ));
            $this->pageTitle.= sprintf(__l(' - %s') , $project_name['Request']['title']);
        }
        $this->RequestView->recursive = 0;
        $this->RequestView->order = array(
            'RequestView.id' => 'desc'
        );
        $this->paginate = array(
            'conditions' => $conditions,
        );
        $this->set('requestViews', $this->paginate());
        $moreActions = $this->RequestView->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestView->delete($id)) {
            $this->Session->setFlash(__l('Request View deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>