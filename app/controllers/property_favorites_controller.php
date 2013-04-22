<?php
class PropertyFavoritesController extends AppController
{
    public $name = 'PropertyFavorites';
    public $components = array(
        'OauthConsumer'
    );
    // Add Favourites and update in facebook and twitter if user is logged in using FB Connect or Twitter Connect //
    public function add($slug = null) 
    {
        $property = $this->PropertyFavorite->Property->find('first', array(
            'conditions' => array(
                'Property.slug' => $slug,
                'Property.user_id != ' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->PropertyFavorite->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id') ,
                'property_id' => $property['Property']['id']
            ) ,
            'recursive' => -1
        ));
        if (empty($chkFavorites)) {
            $this->request->data['PropertyFavorite']['property_id'] = $property['Property']['id'];
            $this->request->data['PropertyFavorite']['user_id'] = $this->Auth->user('id');
            $this->request->data['PropertyFavorite']['ip_id'] = $this->PropertyFavorite->toSaveIp();
            if (!empty($this->request->data)) {
                $this->PropertyFavorite->create();
                if ($this->PropertyFavorite->save($this->request->data, false)) {
                    // Update Social Networking//
                    $property = $this->PropertyFavorite->Property->find('first', array(
                        'conditions' => array(
                            'Property.id = ' => $this->request->data['PropertyFavorite']['property_id'],
                        ) ,
                        'fields' => array(
                            'Property.id',
                            'Property.title',
                            'Property.slug',
                            'Property.user_id',
                            'Property.description',
                            'Property.property_view_count',
                            'Property.property_feedback_count',
                            'Property.property_favorite_count',
                            'Property.is_active',
                        ) ,
                        'contain' => array(
                            'Attachment' => array(
                                'fields' => array(
                                    'Attachment.id',
                                    'Attachment.filename',
                                    'Attachment.dir',
                                    'Attachment.width',
                                    'Attachment.height'
                                )
                            ) ,
                        ) ,
                        'recursive' => 2,
                    ));
                    $url = Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                    ) , true);
                    if ($this->RequestHandler->isAjax()) {
                        echo "added|" . Router::url(array(
                            'controller' => 'property_favorites',
                            'action' => 'delete',
                            $property['Property']['slug']
                        ) , true);
                        exit;
                    }
                    $this->Session->setFlash(__l(' Property has been added to your Favorites') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug']
                    ));
                } else {
                    $this->Session->setFlash(__l(' Property Favorite could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->Session->setFlash(__l(' Property already added has Favorite') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'view',
                $slug
            ));
        }
    }
    public function delete($slug = null) 
    {
        $property = $this->PropertyFavorite->Property->find('first', array(
            'conditions' => array(
                'Property.slug = ' => $slug
            ) ,
            'recursive' => -1
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->PropertyFavorite->find('first', array(
            'conditions' => array(
                'PropertyFavorite.user_id' => $this->Auth->user('id') ,
                'PropertyFavorite.property_id' => $property['Property']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['PropertyFavorite']['id'])) {
            $id = $chkFavorites['PropertyFavorite']['id'];
            if ($this->PropertyFavorite->delete($id)) {
                if ($this->RequestHandler->isAjax()) {
                    echo "removed|" . Router::url(array(
                        'controller' => 'property_favorites',
                        'action' => 'add',
                        $property['Property']['slug']
                    ) , true);
                    exit;
                }
                $this->Session->setFlash(__l(' Property removed from favorites') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $property['Property']['slug']
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
        $this->pageTitle = __l('Property Favorites');
        $this->_redirectGET2Named(array(
            'q',
            'username',
        ));
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
        if (!empty($this->request->params['named']['property']) || !empty($this->request->params['named']['property_id'])) {
            $propertyConditions = !empty($this->request->params['named']['property']) ? array(
                'Property.slug' => $this->request->params['named']['property']
            ) : array(
                'Property.id' => $this->request->params['named']['property_id']
            );
            $property = $this->{$this->modelClass}->Property->find('first', array(
                'conditions' => $propertyConditions,
                'fields' => array(
                    'Property.id',
                    'Property.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($property)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Property.id'] = $this->request->data[$this->modelClass]['property_id'] = $property['Property']['id'];
            $this->pageTitle.= ' - ' . $property['Property']['title'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFavorite.created) <= '] = 0;
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFavorite.created) <= '] = 7;
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFavorite.created) <= '] = 30;
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['property'])) {
            $conditions['Property.slug'] = $this->request->params['named']['property'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyFavorite']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->PropertyFavorite->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PropertyFavorite.id' => 'desc'
            )
        );
        if (isset($this->request->data['PropertyFavorite']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['PropertyFavorite']['q']
            ));
        }
        $moreActions = $this->PropertyFavorite->moreActions;
        $this->set(compact('moreActions'));
        $this->set('propertyFavorites', $this->paginate());
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyFavorite->delete($id)) {
            $this->Session->setFlash(__l('Property favorite deleted successfully') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>