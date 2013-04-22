<?php
class UserViewsController extends AppController
{
    public $name = 'UserViews';
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $this->pageTitle = __l('User Views');
        $conditions = array();
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['UserView']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'UserView.id',
                'UserView.created',
                'UserView.ip_id',
                'User.username',
                'ViewingUser.username',
                'Ip.ip',
                'Ip.host',
            ) ,
            'order' => array(
                'UserView.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['UserView']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['UserView']['q']
            ));
        }
        $this->set('userViews', $this->paginate());
        $users = $this->UserView->User->find('list');
        $moreActions = $this->UserView->moreActions;
        $this->set(compact('moreActions', 'users'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserView->delete($id)) {
            $this->Session->setFlash(__l('User View deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>