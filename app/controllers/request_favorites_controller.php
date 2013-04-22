<?php
class RequestFavoritesController extends AppController
{
    public $name = 'RequestFavorites';
    public function add($slug = null) 
    {
        $this->pageTitle = __l('Add Request Favorite');
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['RequestFavorite']['request_id'] = $request['Request']['id'];
            $this->request->data['RequestFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['RequestFavorite']['ip_id'] = $this->RequestFavorite->toSaveIp();
            if (!empty($this->request->data)) {
                $this->request->data['RequestFavorite']['ip_id'] = $this->RequestFavorite->toSaveIp();
                $this->RequestFavorite->create();
                if ($this->RequestFavorite->save($this->request->data)) {
                    if ($this->RequestHandler->isAjax()) {
                        echo "added|" . Router::url(array(
                            'controller' => 'request_favorites',
                            'action' => 'delete',
                            $request['Request']['slug']
                        ) , true);
                        exit;
                    }
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('"%s" Request Favorite could not be added. Please, try again.') , $this->request->data['RequestFavorite']['id']) , 'default', null, 'error');
                }
            }
        } else {
            $this->Session->setFlash(__l(' Request already added has Favorite') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'view',
                $slug
            ));
        }
        $users = $this->RequestFavorite->User->find('list');
        $requests = $this->RequestFavorite->Request->find('list');
        $this->set(compact('users', 'requests'));
    }
    public function delete($slug = null) 
    {
        $request = $this->RequestFavorite->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->RequestFavorite->find('first', array(
            'conditions' => array(
                'RequestFavorite.user_id' => $this->Auth->user('id') ,
                'RequestFavorite.request_id' => $request['Request']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['RequestFavorite']['id'])) {
            $id = $chkFavorites['RequestFavorite']['id'];
            if ($this->RequestFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
                    echo "removed|" . Router::url(array(
                        'controller' => 'request_favorites',
                        'action' => 'add',
                        $request['Request']['slug']
                    ) , true);
                    exit;
                }
                $this->Session->setFlash(__l('Request Favorite deleted') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('Request Favorites');
		$conditions=array();
		if(!empty($this->request->params['named']['request_id']))
		{
			$conditions['RequestFavorite.request_id']=$this->request->params['named']['request_id'];
		}
        $this->paginate = array(
			'conditions'=>$conditions,
            'contain' => array(
                'User',
                'Request',
                'Ip',
            ) ,
            'order' => array(
                'RequestFavorite.id' => 'DESC'
            )
        );
        $this->set('requestFavorites', $this->paginate());
        $moreActions = $this->RequestFavorite->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->RequestFavorite->delete($id)) {
            $this->Session->setFlash(__l('Request Favorite deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>