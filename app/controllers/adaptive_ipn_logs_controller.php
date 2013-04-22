<?php
class AdaptiveIpnLogsController extends AppController
{
    public $name = 'AdaptiveIpnLogs';
    public function admin_index() 
    {
        $this->pageTitle = __l('Adaptive Ipn Logs');
        $conditions = array();
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'AdaptiveIpnLog.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $this->set('adaptiveIpnLogs', $this->paginate());
    }
}
?>