<?php
class CollectionsController extends AppController
{
    public $name = 'Collections';
    
    public $helpers = array(

        'Html','Form'

    );
	
	public function home()
	{
		$this->set('titulo','Bienvenidos');
	
	}
	
	
	
	public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'Attachment',
        );
        parent::beforeFilter();
    }
	
	
	
    public function index() 
    {
    	$this->loadModel('Property');
		$this->layout = 'default_collections';
		$collections_search = $this->Property->Collection->find('all', array(
		        'conditions' => array(
                    'Collection.is_active' => 1
                )
            )
        );
        
        $active_properties = $this->Property->find('all', array(
                'conditions' => array(
                    'Property.is_approved' => 1 ,
                    'Property.is_active' => 1,
                    'Property.admin_suspend' => 0
                )
            )
        );
		
		
		//*** Modifico para las nuevas Busquedas. ****///
		$this->loadModel('Property_types');
		$this->Property_types->create();
		
		$active_types = $this->Property_types->find('all', array(
                'conditions' => array(
                    'Property_types.is_active' => 1
                )
            )
        );

		
		//***********************************************//
        
        $cities = array();
        
        foreach ($active_properties as $act_prop) {
            if ($act_prop["City"]["name"] != "" && !in_array($act_prop["City"]["name"], $cities)) {
                $cities[$act_prop["City"]["id"]] = $act_prop["City"]["name"];
            }
        }
        
        //sort($cities);

        //Post Search
      	if ($_GET["do"] && $_GET["do"] == "search") {
            $search_conditions = array(
                'Property.is_approved' => 1 ,
                'Property.is_active' => 1,
                'Property.admin_suspend' => 0
            );
            
            if (!empty($_GET["city"]) && $_GET["city"] != "all") {
                $search_conditions["Property.city_id"] = $_GET["city"]; 
            };
            
            if (!empty($_GET["property_type"]) && $_GET["property_type"] != "all") {
                $property_ids = $this->Property->CollectionsProperty->find('list', array(
                    'conditions' => array(
                            'CollectionsProperty.collection_id' => $_GET["property_type"],
                        ),
                        'fields' => array(
                            'CollectionsProperty.property_id',
                        )
                    )
                );
                
                $search_conditions["Property.id"] = $property_ids; 
            }
                    
            $search_properties = $this->Property->find('all', array(
                    'conditions' => $search_conditions
                )
            );
            
            $this->set("searched", true);
            $this->set("search_properties", $search_properties);
        }
        
        $this->set("collections_search", $collections_search);
        $this->set("cities", $cities);
		//paso los valores para el select
		$this->set('active_types',$active_types);

		
		$this->pageTitle = __l('Collections');
        $this->Collection->recursive = 0;
		$conditions=array();
		$conditions['Collection.is_active']=1;
		$conditions['Collection.property_count >']=0;
		 $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
			'contain' => array(
				'CollectionsProperty',
                'Attachment',
				'Property'=>array('Attachment'),
            ) ,
            'order' => array(
                'Collection.id' => 'desc'
            )
        );
        $this->set('collections', $this->paginate());

		
		
		
    }//end index





	public function collage() 
	{
		// @todo "Collage Script"
	}
    public function admin_index() 
    {
        $this->pageTitle = __l('Collections');
		$this->set('active', $this->Collection->find('count', array(
            'conditions' => array(
                'Collection.is_active' => 1
            )
        )));
        $this->set('inactive', $this->Collection->find('count', array(
            'conditions' => array(
                'Collection.is_active' => 0
            )
        )));
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Collection.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Collection.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
        }
        $this->Collection->recursive = -1;
		 $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'Collection.id' => 'desc'
            )
        );
        $this->set('collections', $this->paginate());
        $moreActions = $this->Collection->moreActions;
        $this->set(compact('moreActions'));
    }



    public function admin_add() 
    {
        $this->pageTitle = __l('Add Collection');
		$this->Collection->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        if (!empty($this->request->data)) {
            $this->Collection->create();
			$this->request->data['Attachment']['class']='Collection';
            $ini_upload_error = 1;
            if ($this->request->data['Attachment']['filename']['error'] == 1) {
				 $ini_upload_error = 0;
				 $this->request->data['Attachment']['class'] = 'Collection';
            }

            if ($this->Collection->save($this->request->data)) {
				 if ($ini_upload_error && !empty($this->request->data['Attachment']['filename']['name'])) {
					$this->request->data['Attachment']['foreign_id'] = $this->Collection->getLastInsertId();
                    $this->request->data['Attachment']['class'] = 'Collection';
					$this->Collection->Attachment->create();
					$this->Collection->Attachment->save($this->request->data);
                    }
                $this->Session->setFlash(__l('Collection has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l(' Collection could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $properties = $this->Collection->Property->find('list');
        $users = $this->Collection->User->find('list');
        $this->set(compact('properties', 'users'));
    }
	public function admin_add_collection() 
    {
		if(isset($this->request->data))
		{
			$property_ids=explode(',',$this->request->data['Collection']['property_list']);
			foreach($property_ids as $id)
			{
				foreach($this->request->data['Collection']['Collection'] as $collection_find)
				{
					$collection_count = $this->Collection->CollectionsProperty->find('count', array(
					'conditions' => array(
						'CollectionsProperty.property_id = ' => $id,
						'CollectionsProperty.collection_id = ' => $collection_find,
					) ,
					'recursive' =>-1,
					 ));

					if($collection_count==0)
					{
					$data=array();
					$data['CollectionsProperty']['collection_id']=$collection_find;
					$data['CollectionsProperty']['property_id']=$id;
					$this->Collection->CollectionsProperty->create();
					$this->Collection->CollectionsProperty->save($data,false);
					$this->Collection->CollectionsProperty->updateAll(array(
                       'CollectionsProperty.display_order' => $this->Collection->CollectionsProperty->getLastInsertId()
                    ) , array(
                       'CollectionsProperty.id' =>  $this->Collection->CollectionsProperty->getLastInsertId()
                    ));
					$this->Collection->updateCount($collection_find,$id);

					}

				}
			}

			//update collection count and property count
			$this->Session->setFlash(__l('Properties mapped with collections successfully') , 'default', null, 'success');
            $this->redirect(array(
				'controller'=>'properties',
                'action' => 'index'
            ));
		}
		else
		{
			 throw new NotFoundException(__l('Invalid request'));
		}
	}
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Collection');
		$this->Collection->Behaviors->attach('ImageUpload', Configure::read('image.file'));

        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
			$this->request->data['Attachment']['class']='Collection';
			 $ini_upload_error = 1;
            if ($this->request->data['Attachment']['filename']['error'] == 1) {
				 $ini_upload_error = 0;
            }

			 if(!empty($this->request->data['CollectionsProperty']))
			{
				 foreach($this->request->data['CollectionsProperty'] as $key => $val)
				{
						$this->Collection->CollectionsProperty->updateAll(array(
                       'CollectionsProperty.display_order' => $val['display_order'],
                    ) , array(
                       'CollectionsProperty.property_id' => $key,
						'CollectionsProperty.Collection_id' => $this->request->data['Collection']['id'],

                    ));

				}
				unset($this->request->data['CollectionsProperty']);
			}

			// save collections mapped proties
			//first delete all the mapped properties for this collections
			 if(!empty($this->request->data['Property']))
			{
				 foreach($this->request->data['Property'] as $key => $val)
				{
					if($val['id']==1)
					{
						$this->Collection->CollectionsProperty->deleteAll(array('CollectionsProperty.collection_id' => $this->request->data['Collection']['id'],'CollectionsProperty.property_id' => $key ));
					}
					$this->Collection->updateCount($this->request->data['Collection']['id'],$key);
					unset($this->request->data['Property']);

				}
			}
			// @todo "Collage Script"
            if ($this->Collection->save($this->request->data)) {
					if ($ini_upload_error && !empty($this->request->data['Attachment']['filename']['name'])) {
					$this->request->data['Attachment']['foreign_id'] = $this->request->data['Collection']['id'];
                    $this->request->data['Attachment']['class'] = 'Collection';
					if(empty($this->request->data['Attachment']['id']))
					{
						$this->Collection->Attachment->create();

					}
					$this->Collection->Attachment->save($this->request->data);
                    }

                $this->Session->setFlash(__l('Collection has been updated') , 'default', null, 'success');
                 $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Collection could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Collection->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Collection']['title'];
        //$properties = $this->Collection->Property->find('list');
        $users = $this->Collection->User->find('list');
		$ids = $this->Collection->CollectionsProperty->find('list',array('conditions'=>array('CollectionsProperty.collection_id'=>$this->request->data['Collection']['id']),'fields'=>array('CollectionsProperty.id','CollectionsProperty.property_id')));
		$properties=$this->Collection->Property->find('all',
			array('conditions'=>array('Property.id'=>$ids),
			'contain'=>array(
				'User',
				'Country',
				'Attachment',
			),'recursive' => 2)
			);
		$i=0;
		foreach($properties as $property)
		{
			 $collection_find = $this->Collection->CollectionsProperty->find('first', array(
            'conditions' => array(
                'CollectionsProperty.property_id = ' => $property['Property']['id'],
				'CollectionsProperty.collection_id = ' => $this->request->data['Collection']['id']
            ) ,
            'fields' => array(
                'CollectionsProperty.display_order',

            ) ,
            'recursive' => -1,
		 ));
			$properties[$i]['Property']['display_order']=$collection_find['CollectionsProperty']['display_order'];
			$i++;

		}
//Sorting code start here
// compare function
function cmpi($a, $b)
{
	 global $sort_field;
	 return strcmp($a['Property']['display_order'], $b['Property']['display_order']);
}
// do the array sorting
usort($properties, 'cmpi');
//sorting code ends here


$this->set('properties',$properties);
$moreActions = $this->Collection->moreActionsProperty;
$this->set(compact('moreActions'));
 //$properties = $this->Collection->Property->find('list');
$this->set(compact('users','moreActions'));
    }
	public function admin_delete_property($property_id = null,$id=null) 
    {
        if (is_null($id) ||  is_null($property_id) ) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ( $this->Collection->CollectionsProperty->deleteAll(array('CollectionsProperty.collection_id' => $id,'CollectionsProperty.property_id' => $property_id))) {
			$this->Collection->updateCount($id,$property_id);
            $this->Session->setFlash(__l('Collection deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'edit',
				$id
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Collection->delete($id)) {
            $this->Session->setFlash(__l('Collection deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>