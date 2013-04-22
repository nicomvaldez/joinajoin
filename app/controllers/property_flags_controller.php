<?php
class PropertyFlagsController extends AppController
{
    public $name = 'PropertyFlags';
    public $components = array(
        'RequestHandler'
    );
    public function add($property_id = null) 
    {
        if (!Configure::read('property.is_allow_property_flag')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->PropertyFlag->create();
            if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $this->request->data['PropertyFlag']['user_id'] = $this->Auth->user('id');
            }
            $this->request->data['PropertyFlag']['property_id'] = $this->request->data['Property']['id'];
            $this->request->data['PropertyFlag']['ip_id'] = $this->PropertyFlag->toSaveIp();
            if ($this->PropertyFlag->save($this->request->data)) {
                $this->Session->setFlash(__l('Flag has been added') , 'default', null, 'success');
                $property = $this->PropertyFlag->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $this->request->data['Property']['id'],
                    ) ,
                    'fields' => array(
                        'Property.slug',
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->isAjax()) {
                    echo "redirect*" . Router::url(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                        'admin' => false
                    ) , true);
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'view',
                        $property['Property']['slug'],
                        'admin' => false
                    ));
                }
            } else {
                $this->request->data = $this->PropertyFlag->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $this->request->data['Property']['id'],
                    ) ,
                    'recursive' => 1
                ));
                $this->Session->setFlash(__l('Flag could not be added. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PropertyFlag->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $property_id,
                ) ,
                'recursive' => 1
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $propertyFlagCategories = $this->PropertyFlag->PropertyFlagCategory->find('list', array(
            'conditions' => array(
                'PropertyFlagCategory.is_active' => 1
            )
        ));
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $users = $this->PropertyFlag->User->find('list');
            $this->set(compact('users'));
        }
        $this->set(compact('propertyFlagCategories'));
    }
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['property_flag_category_id '])) {
            $propertyFlagCategory = $this->{$this->modelClass}->PropertyFlagCategory->find('first', array(
                'conditions' => array(
                    'PropertyFlagCategory.id' => $this->request->params['named']['property_flag_category_id ']
                ) ,
                'fields' => array(
                    'PropertyFlagCategory.id',
                    'PropertyFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($propertyFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['PropertyFlagCategory.id'] = $propertyFlagCategory['PropertyFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $propertyFlagCategory['PropertyFlagCategory']['name']);
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
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Property']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFlag.created) <= '] = 0;
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFlag.created) <= '] = 7;
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(PropertyFlag.created) <= '] = 30;
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['PropertyFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->data['Property']['filter_id'])) {
            if ($this->request->data['Property']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Property.property_flag_count'] != 0;
                $conditions['Property.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Property']['filter_id'];
        }
        $this->PropertyFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username'
                    )
                ) ,
                'PropertyFlagCategory' => array(
                    'fields' => array(
                        'PropertyFlagCategory.name'
                    )
                ) ,
                'Property' => array(
                    'fields' => array(
                        'Property.title',
                        'Property.slug',
                        'Property.id',
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.filename',
                            'Attachment.dir',
                            'Attachment.width',
                            'Attachment.height',
                        )
                    )
                ) ,
                'Ip',
            ) ,
            'order' => array(
                'PropertyFlag.id' => 'desc'
            )
        );
        if (isset($this->request->data['PropertyFlag']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['PropertyFlag']['q']
            ));
        }
        $this->set('propertyFlags', $this->paginate());
        $moreActions = $this->PropertyFlag->moreActions;
        $this->set(compact('moreActions'));
        $this->set('page_title', $this->pageTitle);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PropertyFlag->delete($id)) {
            $this->Session->setFlash(__l('Flag has been cleared') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>