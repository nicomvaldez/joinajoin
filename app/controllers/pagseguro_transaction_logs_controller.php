<?php
class PagseguroTransactionLogsController extends AppController
{
    var $name = 'PagseguroTransactionLogs';
    function admin_index()
    {
        $this->pageTitle = __l('Pagseguro Transaction Logs');
        $this->PagseguroTransactionLog->recursive = 0;
        $this->PagseguroTransactionLog->order = array(
                'PagseguroTransactionLog.id' => 'DESC'
            );
        $this->set('pagseguroTransactionLogs', $this->paginate());
    }
    function admin_view($id = null)
    {
        $this->pageTitle = __l('Pagseguro Transaction Log');
        if (is_null($id)) {
            $this->cakeError('error404');
        }
        $pagseguroTransactionLog = $this->PagseguroTransactionLog->find('first', array(
            'conditions' => array(
                'PagseguroTransactionLog.id = ' => $id
            ) ,
            'recursive' => 0,
        ));
        if (empty($pagseguroTransactionLog)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $pagseguroTransactionLog['PagseguroTransactionLog']['id'];
        $this->set('pagseguroTransactionLog', $pagseguroTransactionLog);
    }
  
}
?>