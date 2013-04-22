<?php
class CronsController extends AppController
{
    public $name = 'Crons';
	public $components = array(
		'Cron',
    );
    public function main() 
    {
        $this->Cron->main();
        $this->Session->setFlash(__l('Property status updated successfully'), 'default', null, 'success');
        $this->redirect(Router::url(array(
            'controller' => 'pages',
            'action' => 'display',
            'tools',
            'admin' => true
        ) , true));
    }
	public function clear_permanent_cache() 
    {
		$this->autoRender = false;
		$this->Cron->clear_permanent_cache();
		if (!empty($_GET['f'])) {
			$this->Session->setFlash(__l('Permanent cache files deleted successfully'), 'default', null, 'success');
			$this->redirect(Router::url('/', true) . $_GET['f']);
		}
    }
    public function crush() 
    {
        $this->autoRender = false;
        $this->Cron->crushPng(APP . WEBROOT_DIR, 0);
        if (!empty($_GET['f'])) {
            $this->Session->setFlash(__l('PNG images crushed successfully'), 'default', null, 'success');
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }
}
?>