<?php
class UserPaypalConnectionsController extends AppController
{
    public $name = 'UserPaypalConnections';
    public function index() 
    {
        $this->pageTitle = __l('PayPal Connections');
        $this->UserPaypalConnection->recursive = -1;
        $this->paginate = array(
            'conditions' => array(
                'UserPaypalConnection.user_id' => $this->Auth->user('id') ,
                'UserPaypalConnection.is_active' => 1
            ) ,
            'order' => array(
                'UserPaypalConnection.id' => 'DESC'
            )
        );
        $this->set('userPaypalConnections', $this->paginate());
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userPaypalConnection = $this->UserPaypalConnection->find('first', array(
            'conditions' => array(
                'UserPaypalConnection.id' => $id
            ) ,
            'recursive' => -1
        ));
        $this->loadModel('Payment');
        $rsArray = $this->Payment->cancelPreapproval($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);
        $ack = strtoupper($rsArray["responseEnvelope.ack"]);
        if ($ack == "SUCCESS") {
            $_data['UserPaypalConnection']['is_active'] = 0;
            $_data['UserPaypalConnection']['is_default'] = 0;
            $_data['UserPaypalConnection']['id'] = $id;
            if ($this->UserPaypalConnection->save($_data)) {
                $this->Session->setFlash(__l('PayPal Connection deleted') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            $ErrorMsg = urldecode($rsArray["error(0).message"]);
            $this->Session->setFlash($ErrorMsg . __l('. PayPal Connection could not be deleted') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function update($id) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserPaypalConnection->updateAll(array(
            'UserPaypalConnection.is_default' => 0
        ) , array(
            'UserPaypalConnection.user_id' => $this->Auth->user('id')
        ));
        $this->UserPaypalConnection->updateAll(array(
            'UserPaypalConnection.is_default' => 1
        ) , array(
            'UserPaypalConnection.id' => $id
        ));
        $this->Session->setFlash(__l('PayPal connection set as default successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'user_paypal_connections',
            'action' => 'index'
        ));
    }
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('PayPal Connections');
        $conditions = array();
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['UserPaypalConnection']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (isset($this->request->params['named']['is_active'])) {
            $conditions['UserPaypalConnection.is_active'] = $this->request->params['named']['is_active'];
            $this->pageTitle.= ($this->request->params['named']['is_active'] == 0) ? __l(' - Inactive') : (($this->request->params['named']['is_active'] == 1) ? __l(' - Active') : '');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserPaypalConnection.created) <= '] = 0;
            $this->pageTitle.= __l(' - Requested today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserPaypalConnection.created) <= '] = 7;
            $this->pageTitle.= __l(' - Requested in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserPaypalConnection.created) <= '] = 30;
            $this->pageTitle.= __l(' - Requested in this month');
        }
        $conditions['UserPaypalConnection.sender_email !='] = '';
         $this->UserPaypalConnection->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'UserPaypalConnection.id' => 'desc'
            )
        );
        if (isset($this->request->data['UserPaypalConnection']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['UserPaypalConnection']['q']
            ));
        }
        $this->set('userPaypalConnections', $this->paginate());
        $this->set('active_count', $this->UserPaypalConnection->find('count', array(
            'conditions' => array(
                'UserPaypalConnection.is_active' => 1,
                'UserPaypalConnection.sender_email !=' => '',
            )
        )));
        $this->set('inactive_count', $this->UserPaypalConnection->find('count', array(
            'conditions' => array(
                'UserPaypalConnection.is_active' => 0,
                'UserPaypalConnection.sender_email !=' => '',
            )
        )));
        
    }
    public function admin_delete($id = null) 
    {
        $this->setAction('delete', $id);
    }
}
?>