<?php
class PaymentGatewaysController extends AppController
{
    public $name = 'PaymentGateways';
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'PaymentGateway.makeActive',
            'PaymentGateway.makeInactive',
            'PaymentGateway.makeTest',
            'PaymentGateway.makeLive',
            'PaymentGateway.makeDelete',
        );
        parent::beforeFilter();
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('Payment Gateways');
        $this->_redirectGET2Named(array(
            'filter',
            'keywords'
        ));
        $conditions = array();
        if (!empty($this->request->params['named'])) {
            $this->request->data['PaymentGateway'] = array(
                'filter' => (isset($this->request->params['named']['filter'])) ? $this->request->params['named']['filter'] : '',
                'keywords' => (isset($this->request->params['named']['keywords'])) ? $this->request->params['named']['keywords'] : ''
            );
        }
        if (!empty($this->request->data['PaymentGateway']['filter'])) {
            if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Active) {
                $conditions['PaymentGateway.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Inactive) {
                $conditions['PaymentGateway.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::TestMode) {
                $conditions['PaymentGateway.is_test_mode'] = 1;
                $this->pageTitle.= __l(' - Test Mode ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::LiveMode) {
                $conditions['PaymentGateway.is_test_mode'] = 0;
                $this->pageTitle.= __l(' - Live Mode ');
            }
        }
        if (!empty($this->request->data['PaymentGateway']['keywords'])) {
            $conditions = array(
                'OR' => array(
                    'PaymentGateway.name LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                    'PaymentGateway.description LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                )
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PaymentGateway.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('paymentGateways', $this->paginate());
        $isFilterOptions = $this->PaymentGateway->isFilterOptions;
        $this->set(compact('isFilterOptions'));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Payment Gateway');
        if (!empty($this->request->data)) {
            $this->PaymentGateway->create();
            if ($this->PaymentGateway->save($this->request->data)) {
                $this->Session->setFlash(__l('Payment Gateway has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Payment Gateway could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Payment Gateway');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->PaymentGateway->save($this->request->data)) {
                if (!empty($this->request->data['PaymentGatewaySetting'])) {
                    foreach($this->request->data['PaymentGatewaySetting'] as $key => $value) {
						$value['live_mode_value'] = !empty($value['live_mode_value']) ? $value['live_mode_value'] : '';
                        $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                            'PaymentGatewaySetting.test_mode_value' => '\'' . trim($value['test_mode_value']) . '\'',
                            'PaymentGatewaySetting.live_mode_value' => '\'' . trim($value['live_mode_value']) . '\''
                        ) , array(
                            'PaymentGatewaySetting.id' => $key
                        ));
                    }
                }
                $this->Session->setFlash(__l('Payment Gateway has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Payment Gateway could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PaymentGateway->read(null, $id);
            unset($this->request->data['PaymentGatewaySetting']);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $paymentGatewaySettings = $this->PaymentGateway->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => $id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'asc'
            )
        ));
        if (!empty($this->request->data['PaymentGatewaySetting']) && !empty($paymentGatewaySettings)) {
            foreach($paymentGatewaySettings as $key => $paymentGatewaySetting) {
                $paymentGatewaySettings[$key]['PaymentGatewaySetting']['value'] = $this->request->data['PaymentGatewaySetting'][$paymentGatewaySetting['PaymentGatewaySetting']['id']]['value'];
            }
        }
        $this->set(compact('paymentGatewaySettings'));
        $this->pageTitle.= ' - ' . $this->request->data['PaymentGateway']['name'];
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PaymentGateway->delete($id)) {
            $this->Session->setFlash(__l('Payment Gateway deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>