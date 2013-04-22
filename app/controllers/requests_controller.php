<?php
class RequestsController extends AppController
{
    public $name = 'Requests';
    public $uses = array(
        'Request',
        'HolidayType',
        'Amenity',
        'Property',
        'SearchKeyword',
        'SearchLog',
        'RequestFavorite'
    );
	public $components = array(
		'OauthConsumer',
    );
	public $permanentCacheAction = array(
		'view' => array(
			'is_public_url' => true,
			'is_user_specific_url' => true,
			'is_view_count_update' => true
		)
	);
    public function beforeFilter() 
    {
        $this->Security->disabledFields = array(
            'City.id',
            'State.id',
            'State.name',
            'City.name',
            'Request.country_id',
            'Request.latitude',
            'Request.longitude',
            'Request.sw_latitude',
            'Request.ne_longitude',
            'Request.sw_longitude',
            'Request.ne_latitude',
            'Request.post',
            'Request.step1',
            'Request.step2',
            'Request.step3',
            'Request.step4',
        );
        parent::beforeFilter();
    }
    public function index($hash_keyword = '', $salt = '') 
    {
        $this->_redirectPOST2Named(array(
            'cityName',
            'latitude',
            'longitude',
            'sw_latitude',
            'ne_longitude',
            'sw_longitude',
            'ne_latitude',
            'checkin',
            'keyword',
            'checkout',
            'additional_guest',
            'type',
            'search',
            'is_flexible',
            'RoomType',
            'PropertyType',
            'range_from',
            'range_to',
            'Amenity',
			'HolidayType',
        ));
        $this->pageTitle = __l('Requests');
        $conditions = array();
        $search_keyword = array();
        $fields = $current_latitude = $current_longitude = '';
        $conditions['Request.is_approved'] = 1;
        $conditions['Request.is_active'] = 1;
        /// ****************************Search Related Querys **************************************///
        if ($this->RequestHandler->isAjax() && !isset($this->request->params['named']['share']) && ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'lst_my_properties') || empty($this->request->params['named']['type']))) {
            $this->set('search', 'map');
        }
        if (!empty($hash_keyword) && !empty($salt)) {
            $named_array = $this->Request->getSearchKeywords($hash_keyword, $salt);
            $search_keyword['named'] = array_merge($this->request->params['named'], $named_array);
            $this->request->params['named']['type'] = $search_keyword['named']['type'];
            $this->request->params['named']['hash'] = $hash_keyword;
            $this->request->params['named']['salt'] = $salt;
			$this->request->params['pass']['0']= $hash_keyword;
            $this->request->params['pass']['1'] = $salt;

            $is_city = false;
        } elseif (!empty($this->request->params['named']['type'])) {
            // isset of type
            
        } else {
            if (empty($this->request->params['named']['city'])) {
                $this->request->params['named']['city'] = 'all';
            }
            $query_string = '';
            if (!empty($this->request->params['named']['city'])) {
                $CityList = $this->Property->City->find('first', array(
                    'conditions' => array(
                        'City.slug' => $this->request->params['named']['city'],
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($CityList) && $this->request->params['named']['city'] != 'all') {
                    $query_string = '/city:' . $CityList['City']['name'];
                    $query_string.= '/cityname:' . $CityList['City']['name'];
                    $query_string.= '/latitude:' . $CityList['City']['latitude'];
                    $query_string.= '/longitude:' . $CityList['City']['longitude'];
                } else {
                    $query_string = '/city:';
                    $query_string.= '/cityname:';
                    $query_string.= '/latitude:';
                    $query_string.= '/longitude:';
                }
                $query_string.= '/checkin:' . date('Y-m-d');
                $query_string.= '/checkout:' . date('Y-m-d');
                $query_string.= '/additional_guest:1';
                $query_string.= '/range_from:10';
                $query_string.= '/is_flexible:1';
                $query_string.= '/type:search';
                // search log
                $searchkeyword['SearchKeyword']['keyword'] = $query_string;
                $this->SearchKeyword->save($searchkeyword, false);
                $keyword_id = $this->SearchKeyword->getLastInsertId();
                //maintain in search log
                $searchlog = array();
                $searchlog['SearchLog']['search_keyword_id'] = $keyword_id;
                $searchlog['SearchLog']['ip_id'] = $this->SearchLog->toSaveIp();
				if($this->Auth->user('id'))
				{
				$searchlog['SearchLog']['user_id'] =$this->Auth->user('id');
				}
                $this->SearchLog->save($searchlog, false);
                //salt mixing
                $salt = $keyword_id+786;
                $hash_query_string = '/' . dechex($keyword_id) . '/' . substr(dechex($salt) , 0, 2);
                $this->request->params['pass']['0']= dechex($keyword_id);
                $this->request->params['pass']['1'] = substr(dechex($salt) , 0, 2);
                if (!empty($CityList) && $this->request->params['named']['city'] != 'all') {
                    $search_keyword['named']['cityname'] = $CityList['City']['name'];
                    $search_keyword['named']['latitude'] = $CityList['City']['latitude'];
                    $search_keyword['named']['longitude'] = $CityList['City']['longitude'];
                } else {
                    $search_keyword['named']['cityname'] = '';
                    $search_keyword['named']['latitude'] = '';
                    $search_keyword['named']['longitude'] = '';
                }
                $search_keyword['named']['checkin'] = date('Y-m-d');
                $search_keyword['named']['checkout'] = date('Y-m-d');
                $search_keyword['named']['additional_guest'] = 1;
                $search_keyword['named']['range_from'] = '10';
                $search_keyword['named']['is_flexible'] = 1; // default flexible
                $search_keyword['named']['type'] = 'search';
            }
        }
        if (!empty($search_keyword['named']['type']) && $search_keyword['named']['type'] == 'search') {
            $propertytype = isset($search_keyword['named']['propertytype']) ? $search_keyword['named']['propertytype'] : '';
			$holidaytype = isset($search_keyword['named']['holidaytype']) ? $search_keyword['named']['holidaytype'] : '';
            $roomtype = isset($search_keyword['named']['roomtype']) ? $search_keyword['named']['roomtype'] : '';
            $amenity = isset($search_keyword['named']['amenity']) ? $search_keyword['named']['amenity'] : '';
            $rangefrom = isset($search_keyword['named']['range_from']) ? $search_keyword['named']['range_from'] : '10';
            $rangeto = isset($search_keyword['named']['range_to']) ? $search_keyword['named']['range_to'] : '300+';
            $current_latitude = $search_keyword['named']['latitude'];
            $current_longitude = $search_keyword['named']['longitude'];
            $checkin = $search_keyword['named']['checkin'];
            $checkout = $search_keyword['named']['checkout'];
			//checkin/checkout date valid check
			if($checkin < date('Y-m-d') || $checkout >  $checkout || $checkout < date('Y-m-d'))
			{
				  $this->Session->setFlash(__l('Checkin/checkout date is invalid') , 'default', null, 'error');
					  $this->redirect(array(
						'controller' => 'requests',
						'action' => 'index',
					));
			}
            $exact_match = array();
            $exact_match['Request.is_approved'] = 1;
            $days = (strtotime($checkout) -strtotime($checkin)) /(60*60*24);
            if ($days == 0) {
                $days = 1;
            }
            $additional_guest = isset($search_keyword['named']['additional_guest']) ? $search_keyword['named']['additional_guest'] : 1;
            $conditions['Request.price_per_night >='] = $rangefrom;
            $exact_match['Request.price_per_night >='] = $rangefrom;
            if ($rangeto != '300+') {
                $conditions['Request.price_per_night <='] = $rangeto;
                $exact_match['Request.price_per_night <='] = $rangeto;
            }
            //distance calcuation based on lat and lng
            if (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude'])) {
                $fields = "3956 * 2 * ASIN(SQRT(  POWER(SIN((Request.latitude - $current_latitude) * pi()/180 / 2), 2) + COS(Request.latitude * pi()/180) *  COS($current_latitude * pi()/180) * POWER(SIN((Request.longitude - $current_longitude) * pi()/180 / 2), 2)  )) as distance";
            }
            if (isset($search_keyword['named']['search']) && $search_keyword['named']['search'] == 'side' && !empty($search_keyword['named']['sw_longitude'])) {
                $lon1 = $search_keyword['named']['sw_longitude'];
                $lon2 = $search_keyword['named']['ne_longitude'];
                $lat1 = $search_keyword['named']['sw_latitude'];
                $lat2 = $search_keyword['named']['ne_latitude'];
                $conditions['Request.latitude BETWEEN ? AND ?'] = array(
                    $lat1,
                    $lat2
                );
                $conditions['Request.longitude BETWEEN ? AND ?'] = array(
                    $lon1,
                    $lon2
                );
            } else {
                if (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude'])) {
                    //distance based search
                    $dist = Configure::read('site.distance_limit'); // 10 kms
					$exact_dist = Configure::read('site.exact_distance_limit'); // 10 kms

                    $lon1 = $current_longitude-$dist/abs(cos(deg2rad($current_latitude)) *69);
                    $lon2 = $current_longitude+$dist/abs(cos(deg2rad($current_latitude)) *69);
                    $lat1 = $current_latitude-($dist/69);
                    $lat2 = $current_latitude+($dist/69);

					//exact match finder
					$exact_lon1 = $current_longitude-$exact_dist/abs(cos(deg2rad($current_latitude)) *69);
					$exact_lon2 = $current_longitude+$exact_dist/abs(cos(deg2rad($current_latitude)) *69);
					$exact_lat1 = $current_latitude-($exact_dist/69);
					$exact_lat2 = $current_latitude+($exact_dist/69);


                    $conditions['Request.latitude BETWEEN ? AND ?'] = array(
                        $lat1,
                        $lat2
                    );
                    $conditions['Request.longitude BETWEEN ? AND ?'] = array(
                        $lon1,
                        $lon2
                    );

                    $exact_match['Request.latitude BETWEEN ? AND ?'] = array(
                        $exact_lat1,
                        $exact_lat2
                    );
                    $exact_match['Request.longitude BETWEEN ? AND ?'] = array(
                        $exact_lon1,
                        $exact_lon2
                    );
                }
            }
            if (isset($search_keyword['named']['keyword'])) {
                $conditions['Request.title LIKE '] = '%' . $search_keyword['named']['keyword'] . '%';
            }
            if (isset($search_keyword['named']['is_flexible']) && !$search_keyword['named']['is_flexible']) {
                //Exact  Match
                $conditions['Request.checkin >='] = $checkin;
                $conditions['Request.checkout <='] = $checkout;
                $exact_match['Request.checkin >='] = $checkin;
                $exact_match['Request.checkout <='] = $checkout;
                if (!empty($additional_guest)) {
                    $conditions['Request.accommodates >='] = $additional_guest;
                    $conditions['Request.accommodates !='] = 0;
                    $exact_match['Request.accommodates >='] = $additional_guest;
                    $exact_match['Request.accommodates !='] = 0;
                }
            } else {
                $exact_match['Request.checkin >='] = $checkin;
                $exact_match['Request.checkout <='] = $checkout;
                if (!empty($additional_guest)) {
                    $exact_match['Request.accommodates >='] = $additional_guest;
                    $exact_match['Request.accommodates !='] = 0;
                }
            }
            $amenity_list = array();
			$holiday_list = array();
            if (!empty($roomtype)) {
                $this->request->data['Request']['RoomType'] = explode(',', $roomtype);
                $conditions['Request.room_type_id'] = $this->request->data['Request']['RoomType'];
            }
            if (!empty($propertytype)) {
                $this->request->data['Request']['PropertyType'] = explode(',', $propertytype);
                $conditions['Request.property_type_id'] = $this->request->data['Request']['PropertyType'];
            }
            if (!empty($amenity)) {
                $this->request->data['Request']['Amenity'] = explode(',', $amenity);
                $amenity_list = $this->Request->AmenitiesRequest->find('list', array(
                    'conditions' => array(
                        'AmenitiesRequest.amenity_id' => $this->request->data['Request']['Amenity']
                    ) ,
                    'fields' => array(
                        'AmenitiesRequest.id',
                        'AmenitiesRequest.request_id'
                    ) ,
                    'recursive' => -1
                ));
               if (count($amenity_list) > 0) {
                   $conditions['Request.id'] = $amenity_list;
                }
            }
			if (!empty($holidaytype)) {
                $this->request->data['Request']['HolidayType'] = explode(',', $holidaytype);
                $holiday_list = $this->Request->HolidayTypeRequest->find('list', array(
                    'conditions' => array(
                        'HolidayTypeRequest.holiday_type_id' => $this->request->data['Request']['HolidayType']
                    ) ,
                    'fields' => array(
                        'HolidayTypeRequest.id',
                        'HolidayTypeRequest.request_id'
                    ) ,
                    'recursive' => -1
                ));
                if (count($holiday_list) > 0) {
                   $conditions['Request.id'] = $holiday_list;
                }
            }
        }
        /// ****************************Search Related Querys **************************************///
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite') {
            if (!$this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $requestFavorites = $this->RequestFavorite->find('all', array(
                'conditions' => array(
                    'RequestFavorite.user_id =' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'RequestFavorite.request_id'
                ) ,
                'recursive' => -1,
            ));
            foreach($requestFavorites as $requestFavorite) {
                $request_id[] = $requestFavorite['RequestFavorite']['request_id'];
            }
            if (!empty($request_id)) {
                $conditions['Request.id'] = $request_id;
            } else {
                $conditions['Request.id'] = '';
            }
            $conditions['Request.user_id !='] = $this->Auth->user('id');
            $this->pageTitle = __l('Liked Requests');
            $this->set('is_favorite', 1);
            $user = $this->Property->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1,
            ));
            $this->set('user', $user);
        }
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest') {
            $this->pageTitle = __l('My Requests');
            if (!$this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
			unset($conditions['Request.is_approved']);
            $conditions['Request.user_id'] = $this->Auth->user('id');
            unset($conditions['Request.is_active']);
            $is_city = false;
            if (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'active') {
                $conditions['Request.is_active'] = 1;
                $conditions['Request.checkin >='] = date('Y-m-d');
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'inactive') {
                $conditions['Request.is_active'] = 0;
                $conditions['Request.checkin >='] = date('Y-m-d');
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'offered') {
                $conditions['Request.property_count >'] = 0;
                $conditions['Request.checkin >='] = date('Y-m-d');
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'past') {
                $conditions['Request.checkin <'] = date('Y-m-d');
            }
            //Count Querys
            $this->set('all_count', $this->Request->find('count', array(
                'conditions' => array(
                    'Request.user_id' => $this->Auth->user('id') ,
                )
            )));
            $this->set('active_count', $this->Request->find('count', array(
                'conditions' => array(
                    'Request.user_id' => $this->Auth->user('id') ,
                    'Request.checkin >=' => date('Y-m-d') ,
                    'Request.is_active' => 1
                )
            )));
            $this->set('inactive_count', $this->Request->find('count', array(
                'conditions' => array(
                    'Request.user_id' => $this->Auth->user('id') ,
                    'Request.checkin >=' => date('Y-m-d') ,
                    'Request.is_active' => 0
                )
            )));
            $this->set('offered_count', $this->Request->find('count', array(
                'conditions' => array(
                    'Request.user_id' => $this->Auth->user('id') ,
                    'Request.checkin >=' => date('Y-m-d') ,
                    'Request.property_count >' => 0
                )
            )));
            $this->set('past_count', $this->Request->find('count', array(
                'conditions' => array(
                    'Request.user_id' => $this->Auth->user('id') ,
                    'Request.checkin <' => date('Y-m-d') ,
                )
            )));
        } else {
            $conditions['Request.checkin >='] = date('Y-m-d');
        }
        if (isset($this->request->params['named']['type']) && !empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'other') {
                if (isset($this->request->params['named']['request_id']) && !empty($this->request->params['named']['request_id'])) {
                    $conditions['Request.id !='] = $this->request->params['named']['request_id'];
                }
            } elseif ($this->request->params['named']['type'] == 'myrequest') {
                $conditions['Request.user_id'] = $this->Auth->user('id');
            } elseif ($this->request->params['named']['type'] == 'related') {
                if (isset($this->request->params['named']['request_id']) && !empty($this->request->params['named']['request_id'])) {
                    $request = $this->Request->find('first', array(
                        'conditions' => array(
                            'Request.id =' => $this->request->params['named']['request_id']
                        ) ,
                        'recursive' => -1,
                    ));
                    $conditions['Request.id != '] = $request['Request']['id'];
                    $conditions['Request.property_type_id'] = $request['Request']['property_type_id'];
                    $conditions['Request.city_id'] = $request['Request']['city_id'];
                    $conditions['Request.country_id'] = $request['Request']['country_id'];
                    $conditions['Request.bed_type_id'] = $request['Request']['bed_type_id'];
                    $conditions['Request.room_type_id'] = $request['Request']['room_type_id'];
                } else {
                    $conditions['Request.property_type_id'] = 2;
                    $conditions['Request.city_id'] = $this->request->params['city_id'];
                    $conditions['Request.country_id'] = $this->request->params['country_id'];
                    $conditions['Request.bed_type_id'] = $this->request->params['bed_type_id'];
                    $conditions['Request.room_type_id'] = $this->request->params['room_type_id'];
                }
            }
        }
        if (empty($this->request->params['named']['type']) && empty($this->request->params['named']['user_id'])) {
            $conditions['Request.checkin >= '] = date('Y-m-d');
            if (!empty($this->_prefixId)) {
                if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user') {
                    $conditions['Request.city_id'] = $this->_prefixId;
                }
            }
        }
        if (isset($this->request->params['named']['user_id']) && !empty($this->request->params['named']['user_id'])) {
            $conditions['Request.user_id'] = $this->request->params['named']['user_id'];
        }
        $conditions_fav = array();
        if ($this->Auth->user()) {
            $conditions_fav['RequestFavorite.user_id'] = $this->Auth->user('id');
        }
        //should not admin suspended
        $conditions['Request.admin_suspend !='] = 1;
        $exact_match['Request.admin_suspend !='] = 1;
        $exact_match['Request.is_active'] = 1;
        $exact_ids = array();
        $exact_ids = $this->Request->find('list', array(
            'conditions' => $exact_match,
            'fields' => array(
                'Request.id',
                'Request.id'
            )
        ));
        $exact_ids = array_unique($exact_ids);
        $this->set('exact_ids', $exact_ids);
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'PropertiesRequest' => array(
                    'Property' => array(
                        'conditions' => array(
                            'Property.is_paid' => 1,
                            'Property.is_active' => 1,
                            'Property.is_approved' => 1,
                        ) ,
					'PropertiesRequest' => array(
                            'fields' => array(
                                'PropertiesRequest.order_id',
                                'PropertiesRequest.request_id',
                            )),
                        'User',
                        'Attachment',
                        'Country' => array(
                            'fields' => array(
                                'Country.id',
                                'Country.iso2',
                                'Country.name',
                            )
                        ) ,
                    ) ,
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.id',
                        'State.name',
                    )
                ) ,
                'RequestFavorite' => array(
                    'conditions' => $conditions_fav,
                    'fields' => array(
                        'RequestFavorite.id',
                        'RequestFavorite.user_id',
                        'RequestFavorite.request_id',
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.name',
                        'Country.iso2',
                    )
                ) ,
                'PropertyType' => array(
                    'fields' => array(
                        'PropertyType.id',
                        'PropertyType.name',
                    )
                ) ,
                'RoomType' => array(
                    'fields' => array(
                        'RoomType.id',
                        'RoomType.name',
                    )
                ) ,
                'BedType' => array(
                    'fields' => array(
                        'BedType.id',
                        'BedType.name',
                    )
                ) ,
                'User'
            ) ,
            'fields' => array(
                'Request.id',
                'Request.created',
                'Request.title',
                'Request.slug',
                'Request.description',
                'Request.price_per_night',
                'Request.user_id',
                'Request.city_id',
                'Request.state_id',
                'Request.checkin',
                'Request.checkout',
                'Request.country_id',
                'Request.checkin',
                'Request.checkout',
                'Request.latitude',
                'Request.longitude',
                'Request.zoom_level',
                'Request.is_active',
                'Request.property_count',
                'Request.request_flag_count',
                'Request.request_view_count',
                'Request.request_favorite_count',
                'Request.is_approved',
                'Request.is_active',
                'Request.address',
                $fields
            ) ,
            'order' => array(
                'Request.checkin' => 'ASC',
            ) ,
            'recursive' => 3,
        );
        $requests = $this->paginate();
        if (empty($this->request->params['named']['view'])) {
            $newRequests = array();
            $checkInDate = '';
            foreach($requests as $request) {
                if (empty($checkInDate) || !empty($request['Request']['checkin'])) {
                    $checkInDate = $request['Request']['checkin'];
                }
                $newRequests[$request['Request']['checkin']][] = $request;
            }
            $this->set('requests', $newRequests);
        } else {
            $this->set('requests', $requests);
        }
		$total_request_count = $this->Request->find('count', array(
            'conditions' => $conditions,
        ));
        $this->set('total_result', $total_request_count);
        $set_filter_count = $this->Request->getFilterCount($conditions);
        $this->set('search_keyword', $search_keyword);
        /// ****************************Search Related Querys **************************************///
        $roomTypes = $this->Request->RoomType->find('list', array(
            'order' => array(
                'RoomType.name' => 'asc'
            )
        ));
		$conditions['Request.room_type_id']=array_keys($roomTypes);
	   $room_types=$this->Request->find('all', array(
            'fields' => array(
				'Request.room_type_id',
                'count(Request.id) as request_count',
            ) ,
            'conditions' => $conditions,
            'group' => 'Request.room_type_id',
            'recursive' => -1
        ));

		$rom_types=array();
		foreach($room_types as $room_type)
		{
			 $rom_types[$room_type['Request']['room_type_id']]=$room_type[0]['request_count'];
		}
		foreach($roomTypes as $key => $val)
		{
			if(isset($rom_types[$key]))
			{
				$roomTypes[$key]=$val.' ('.$rom_types[$key].')';
			}
			else
			{
				$roomTypes[$key]=$val.' (0)';
			}
		}
        $propertyTypes = $this->Request->PropertyType->find('list', array(
            'order' => array(
                'PropertyType.name' => 'asc'
            )
        ));
		$conditions['Request.property_type_id']=array_keys($propertyTypes);
	   $property_types=$this->Request->find('all', array(
            'fields' => array(
				'Request.property_type_id',
                'count(Request.id) as request_count',
            ) ,
            'conditions' => $conditions,
            'group' => 'Request.property_type_id',
            'recursive' => -1
        ));
		$propertyy_types=array();
		foreach($property_types as $property_type)
		{
			 $propertyy_types[$property_type['Request']['property_type_id']]=$property_type[0]['request_count'];
		}
		foreach($propertyTypes as $key => $val)
		{
			if(isset($propertyy_types[$key]))
			{
			$propertyTypes[$key]=$val.' ('.$propertyy_types[$key].')';
			}
			else
			{
				$propertyTypes[$key]=$val.' (0)';
			}
		}
        $amenities = $this->Request->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'asc'
            )
        ));
		foreach($amenities as $amenity_id => $amenity) {
			$amenities[$amenity_id] = $amenity . ' (' . (!empty($set_filter_count['amenities_' . $amenity_id]) ? $set_filter_count['amenities_' . $amenity_id] : 0) . ')';
		}
		$holidayTypes = $this->Request->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'asc'
            )
        ));
		foreach($holidayTypes as $holiday_type_id => $holidayType) {
			$holidayTypes[$holiday_type_id] = $holidayType . ' (' . (!empty($set_filter_count['holiday_types_' . $holiday_type_id]) ? $set_filter_count['holiday_types_' . $holiday_type_id] : 0) . ')';
		}
        $range_from = array();
        $range_to = array();
        for ($i = 10; $i <= 300; $i = $i+5) {
            $range_from[$i] = $i;
            $range_to[$i] = $i;
        }
        $range_to['300+'] = '300+';
        $range_from['300+'] = '300+';
        $this->set(compact('roomTypes', 'propertyTypes', 'amenities','holidayTypes'));
        $this->set('range_from', $range_from);
        $this->set('range_to', $range_to);
        $this->set('current_latitude', $current_latitude);
        $this->set('current_longitude', $current_longitude);
        if ($this->RequestHandler->isAjax()) {
            $this->set('search', 'map');
        } else {
            $this->set('search', 'normal');
        }
        if (!isset($search_keyword['named']['range_to'])) {
            $this->request->data['Request']['range_to'] = '300+';
        } else {
            $this->request->data['Request']['range_to'] = $search_keyword['named']['range_to'];
        }
        if (isset($search_keyword['named']['range_from'])) {
            $this->request->data['Request']['range_from'] = $search_keyword['named']['range_from'];
        }
        if (!empty($search_keyword['named']['additional_guest'])) {
            $this->request->data['Request']['additional_guest'] = $search_keyword['named']['additional_guest'];
        }
        if (isset($search_keyword['named']['checkin'])) {
            $this->request->data['Request']['checkin'] = $search_keyword['named']['checkin'];
        }
        if (isset($search_keyword['named']['checkout'])) {
            $this->request->data['Request']['checkout'] = $search_keyword['named']['checkout'];
        }
        /// ****************************Search Related Querys **************************************///
		if ($this->Auth->user('id')) {
			$user = $this->Request->User->find('first', array(
				'conditions' => array(
					'User.id' => $this->Auth->user('id')
				) ,
				'recursive' => -1,
			));
			$this->set('user', $user);
		}
        if (isset($this->request->params['named']['view'])) {
            if ($this->request->params['named']['view'] == 'compact') {
                $this->autoRender = false;
                $this->render('index_compact');
            }
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest') {
            $moreActions = $this->Request->moreMyRequestsActions;
            $this->set(compact('moreActions'));
            $this->render('my_request');
        }
    }

	public function get_info($id)
	{
		 if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		 $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id = ' => $id
            ) ,
            'contain' => array(
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.name',
                        'Country.iso2',
                    )
                ) ,
            ) ,
            'fields' => array(
                'Request.id',
                'Request.created',
                'Request.title',
                'Request.slug',
                'Request.description',
                'Request.price_per_night',
                'Request.user_id',
                'Request.city_id',
                'Request.state_id',
                'Request.country_id',
                'Request.checkin',
                'Request.checkout',
                'Request.latitude',
                'Request.longitude',
                'Request.zoom_level',
                'Request.is_active',
                'Request.property_count',
                'Request.request_flag_count',
                'Request.request_view_count',
                'Request.request_favorite_count',
                'Request.is_approved',
                'Request.address',
            ) ,
            'recursive' => 2,
        ));
		$this->set('request',$request);
		$this->layout='ajax';
	}
    public function view($slug = null, $hash = null, $salt = null) 
    {
        $this->pageTitle = __l('Request');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		 $this->set('distance_view', true);
        if (!empty($hash) && !empty($salt)) {
            $salt1 = hexdec($hash) +786;
            $salt1 = substr(dechex($salt1) , 0, 2);
            if ($salt1 != $salt) {
                $this->redirect(array(
                    'controller' => 'requests',
                    'action' => 'view',
                    $slug
                ));
            }
            $named_array = $this->Request->getSearchKeywords($hash, $salt);
            $this->request->params['named'] = array_merge($this->request->params['named'], $named_array);
            $is_city = false;
            if (empty($this->request->params['named']['cityname'])) {
                $this->set('distance_view', false);
            }
        }
        $conditions_fav = array();
        if ($this->Auth->user()) {
            $conditions_fav['RequestFavorite.user_id'] = $this->Auth->user('id');
        }

        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.slug = ' => $slug
            ) ,
            'contain' => array(
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.id',
                        'State.name',
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.name',
                        'Country.iso2',
                    )
                ) ,
                'PropertyType' => array(
                    'fields' => array(
                        'PropertyType.id',
                        'PropertyType.name',
                    )
                ) ,
                'RequestFavorite' => array(
                    'conditions' => $conditions_fav,
                    'fields' => array(
                        'RequestFavorite.id',
                        'RequestFavorite.user_id',
                        'RequestFavorite.request_id',
                    )
                ) ,
                'RoomType' => array(
                    'fields' => array(
                        'RoomType.id',
                        'RoomType.name',
                    )
                ) ,
                'BedType' => array(
                    'fields' => array(
                        'BedType.id',
                        'BedType.name',
                    )
                ) ,
                'User',
                'Amenity',
				'HolidayType',
            ) ,
            'recursive' => 3,
        ));
			if (empty($request) || (empty($request['Request']['is_active']) || !empty($request['Request']['admin_suspend']) || empty($request['Request']['is_approved'])) && ($this->Auth->user('id') != $request['Request']['user_id']) && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
		
      
        $this->pageTitle.= ' - ' . $request['Request']['title'];
        $amenities_list = $this->Request->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
		$holiday_list = $this->Request->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $this->set('amenities_list', $amenities_list);
		$this->set('holiday_list', $holiday_list);


        //Log the request view
        $this->request->data['RequestView']['user_id'] = $this->Auth->user('id');
        $this->request->data['RequestView']['request_id'] = $request['Request']['id'];
        $this->request->data['RequestView']['ip_id'] = $this->Request->RequestView->toSaveIp();
        $this->Request->RequestView->create();
        $this->Request->RequestView->save($this->request->data);
        $this->set('request', $request);
    }
    public function add($hash_keyword = '', $salt = '') 
    {
        $this->pageTitle = __l('Post a request');
        if (!empty($hash_keyword) && !empty($salt)) {
            $named_array = $this->Property->getSearchKeywords($hash_keyword, $salt);
            $this->request->params['named'] = array_merge($this->request->params['named'], $named_array);
            if (empty($this->request->data['Request'])) {
                $this->request->data['Request']['address'] = $named_array['cityname'];
                $this->request->data['Request']['latitude'] = $named_array['latitude'];
                $this->request->data['Request']['longitude'] = $named_array['longitude'];
            }
			if (!empty($this->request->data['Request']['step1'])) {
				$this->request->data['Request']['checkin'] = $named_array['checkin'];
                $this->request->data['Request']['checkout'] = $named_array['checkout'];
                $this->request->data['Request']['accommodates'] = $named_array['additional_guest'];
			}
			if (!empty($named_array['sw_latitude'])) {
				$this->set('is_country_search', 1);
			}
            $this->set('hash_keyword', $hash_keyword);
            $this->set('salt', $salt);
        }
        if (!empty($this->request->data['Request']['step1'])) {
            if (!empty($this->request->data['Request']['address'])) {
                $this->set('steps', 2);
            } else {
                $this->Request->validationErrors['address'] = __l('Please select proper address');
                $this->set('steps', 1);
            }
        } else if (!empty($this->request->data['Request']['step2'])) {
            $this->Request->set($this->request->data);
            if ($this->Request->validates($this->request->data)) {
                $this->set('steps', 3);
            } else {
                $this->Session->setFlash(__l('Request could not be added. Please, try again') , 'default', null, 'error');
                $this->set('steps', 2);
            }
        } else if (!empty($this->request->data['Request']['step3'])) {
            if (empty($this->request->data['Request']['post']) && $this->Request->validates()) {
                $request_filter = 0;
                $conditions = array();
                if (!empty($this->request->data['Request']['property_type_id'])) {
                    $conditions['Property.property_type_id'] = $this->request->data['Request']['property_type_id'];
                }
               if (!empty($this->request->data['City']['name'])) {
                    $this->request->data['Request']['city_id'] = $conditions['Property.city_id'] = $this->Request->City->findOrSaveAndGetId($this->request->data['City']['name']);
                }
				if (!empty($this->request->data['State']['name'])) {
					$this->request->data['Request']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Request->State->findOrSaveAndGetId($this->request->data['State']['name']);
				}
                if (!empty($this->request->data['Request']['country_id'])) {
                    $this->request->data['Request']['country_id'] = $this->Property->Country->findCountryId($this->request->data['Request']['country_id']);
                    $conditions['Property.country_id'] = $this->request->data['Request']['country_id'];
                }
               
               if (!empty($this->request->data['Request']['bed_type_id'])) {
                    $conditions['Property.bed_type_id'] = $this->request->data['Request']['bed_type_id'];
                }
                if (!empty($this->request->data['Request']['room_type_id'])) {
                    $conditions['Property.room_type_id'] = $this->request->data['Request']['room_type_id'];
                }
                $conditions['Property.is_paid'] = 1;
                $conditions['Property.is_active'] = 1;
                $conditions['Property.is_approved'] = 1;
                $request_count = $this->Property->find('count', array(
                    'conditions' => $conditions,
                ));
                if ($request_count) {
                    $request_filter = '1';
                    $this->set('request_filters', $request_filter);
                    $this->set('steps', 4);
                } else {
                    $this->Request->create();
                    $this->request->data['Request']['is_approved'] = (Configure::read('request.is_auto_approve')) ? 1 : 0;
                    $this->request->data['Request']['user_id'] = $this->Auth->user('id');
                    $this->Request->set($this->request->data);
                    $this->Request->City->set($this->request->data);
                    $this->Request->State->set($this->request->data);
					if ($this->Request->validates() &$this->Request->City->validates() &$this->Request->State->validates()) {
						$this->Request->save($this->request->data);
						if (Configure::read('request.is_auto_approve')) {
							$this->Session->setFlash(__l('Request has been listed.') , 'default', null, 'success');
							// update into social networking site
							$this->redirect(array(
								'controller' => 'requests',
								'action' => 'update_request_in_social_networking',
								'request_id' => $this->Request->getLastInsertId(),
								'admin' => false
							));
						} else {
							$this->Session->setFlash(__l('Request has been added and it will be listed after admin approve.'), 'default', null, 'success');
							if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
								$this->redirect(array(
									'action' => 'index',
								));
							} else {
								$this->redirect(array(
									'controller' => 'requests',
									'action' => 'index',
									'type' => 'myrequest',
									'admin' => false
								));
							}
						}
					} else {
						$this->Session->setFlash(__l('Request could not be added. Please, try again.') , 'default', null, 'error');
						$this->set('steps', 3);
					}
                }
            }
        } else if (!empty($this->request->data['Request']['step4'])) {
            //state and country looking
            if (!empty($this->request->data['City']['name'])) {
                $this->request->data['Request']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Request->City->findOrSaveAndGetId($this->request->data['City']['name']);
            }
            if (!empty($this->request->data['State']['name'])) {
                $this->request->data['Request']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Request->State->findOrSaveAndGetId($this->request->data['State']['name']);
            }
			if (!empty($this->request->data['Request']['country_id'])) {
				$this->request->data['Request']['country_id'] = $this->Property->Country->findCountryId($this->request->data['Request']['country_id']);
				$conditions['Property.country_id'] = $this->request->data['Request']['country_id'];
			}
            $this->Request->create();
            $this->request->data['Request']['is_approved'] = (Configure::read('request.is_auto_approve')) ? 1 : 0;
            $this->request->data['Request']['user_id'] = $this->Auth->user('id');
            $this->Request->set($this->request->data);
            $this->Request->City->set($this->request->data);
            $this->Request->State->set($this->request->data);
			if ($this->Request->validates() &$this->Request->City->validates() &$this->Request->State->validates()) {
			$this->Request->save($this->request->data);
				if(Configure::read('request.is_auto_approve')) {
					$this->Session->setFlash(__l('Request has been listed.') , 'default', null, 'success');
					// update into social networking site
					$this->redirect(array(
						'controller' => 'requests',
						'action' => 'update_request_in_social_networking',
						'request_id' => $this->Request->getLastInsertId(),
						'admin' => false
					));
				} else {
					$this->Session->setFlash(__l('Request has been added and it will be listed after admin approve.'), 'default', null, 'success');
					if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
						$this->redirect(array(
							'action' => 'index',
						));
					} else {
						$this->redirect(array(
							'controller' => 'requests',
							'action' => 'index',
							'type' => 'myrequest',
							'admin' => false
						));
					}
				}
			} else {
				$this->Session->setFlash(__l('Request could not be added. Please, try again.') , 'default', null, 'error');
				$this->set('steps', 4);
			}
        } else if (!empty($this->request->data['Request']['back_step_1'])) {
            $this->set('steps', 1);
        } else if (!empty($this->request->data['Request']['back_step_2'])) {
            $this->set('steps', 2);
        } else if (!empty($this->request->data['Request']['back_step_3'])) {
            $this->set('steps', 3);
        } else if (!empty($this->request->data['Request']['back_step_4'])) {
            $this->set('steps', 4);
        } else {
            $this->set('steps', 1);
        }
        if (!empty($this->request->data['Request']['address'])) {
            $search_keyword['named']['latitude'] = $this->request->data['Request']['latitude'];
            $search_keyword['named']['longitude'] = $this->request->data['Request']['longitude'];
            $search_keyword['named']['address'] = $this->request->data['Request']['address'];
            $this->set('search_keyword', $search_keyword);
        }
        $preferences = array();
        $preferences['500m'] = '500m';
        $preferences['1km'] = '1km';
        $preferences['2km'] = '2km';
        $preferences['3km'] = '3km';
        $preferences['5km'] = '5km';
        $preferences['10km'] = '10km';
        $preferences['50km'] = '50km';
        $accomadation = array();
        for ($i = 1; $i <= 20; $i++) {
            $accomadation[$i] = $i;
        }
        $amenities = $this->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
        $propertyTypes = $this->Request->PropertyType->find('list', array(
            'order' => array(
                'PropertyType.name' => 'ASC'
            )
        ));
		$holidayTypes = $this->Request->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $roomTypes = $this->Request->RoomType->find('list', array(
            'order' => array(
                'RoomType.name' => 'ASC'
            )
        ));
        $bedTypes = $this->Request->BedType->find('list', array(
            'order' => array(
                'BedType.name' => 'ASC'
            )
        ));
        $morning = array();
        $noon = array();
        for ($i = 1; $i <= 12; $i++) {
            if ($i == 12) {
                $noon[] = $i . '.00 pm (noon)';
                $morning[] = $i . '.00 am (midnight)';
            } else {
                $morning[] = $i . '.00 am';
                $noon[] = $i . '.00 pm';
            }
        }
        $checkin = array_merge($morning, $noon);
        $this->set('checkin', $checkin);
        $this->set('accomadation', $accomadation);
        // $affiliates = $this->Request->Affiliate->find('list');
        $users = $this->Request->User->find('list');
        $cities = $this->Request->City->find('list');
        $states = $this->Request->State->find('list');
        $countries = $this->Request->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ),
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $this->set(compact('affiliates', 'users', 'cities', 'states', 'countries', 'preferences', 'holidayTypes', 'amenities', 'propertyTypes', 'roomTypes', 'bedTypes'));
    }
	 /*After Adding requests, it is posted in Site Facebook and Site Twitter account
    If user logged using Fb_connect or twitter account, it will be posted on their facebook and twitter account respectively
    */
    function update_request_in_social_networking($request_id=null)
    {
        if (!empty($this->params['named']['request_id'])) {
            $request_id = $this->params['named']['request_id'];
        } else {
            $uploaded_data = $this->Session->read('flashupload_data');
        }
        $request = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id = ' => $request_id,
            ) ,
            'fields' => array(
                'Request.id',
                'Request.created',
                'Request.title',
                'Request.slug',
                'Request.description',
                'Request.price_per_night',
                'Request.user_id',
                'Request.city_id',
                'Request.state_id',
                'Request.country_id',
                'Request.checkin',
                'Request.checkout',
                'Request.latitude',
                'Request.longitude',
                'Request.zoom_level',
                'Request.is_active',
                'Request.property_count',
                'Request.request_flag_count',
                'Request.request_view_count',
                'Request.request_favorite_count',
                'Request.is_approved',
                'Request.address',
				'Request.is_system_flagged',
            ) ,

            'recursive' => -1
        ));
		$user = $this->Request->User->find('first', array(
		'conditions' => array(
			'User.id' => $request['Request']['user_id']
		) ,
		'recursive' => - 1
	));
        $url = Router::url(array(
            'controller' => 'requests',
            'action' => 'view',
			'admin' => false,
            $request['Request']['slug'],
        ) , true);
        // Request willn't be posted if it is autoflagged and suspend
        if (!$request['Request']['is_system_flagged']) {
            // Post on user facebook
            if (Configure::read('social_networking.post_request_on_user_facebook')) {
                if ($user['User']['fb_user_id'] > 0) {
                    $fb_message = $user['User']['username'] . ' ' . __l('listed a new request "') . '' .$request['Request']['title']. __l('" in ') . Configure::read('site.name');
                    $getFBReturn = $this->postOnFacebook($request, $fb_message, 0);
                }
            }
            // post on user twitter
            if (Configure::read('social_networking.post_request_on_user_twitter')) {
                if (!empty($user['User']['twitter_access_token']) && !empty($user['User']['twitter_access_key'])) {
                    $message =$user['User']['username'] . ' ' . __l('listed a new request "') . '' .$request['Request']['title']. __l('" in ') . Configure::read('site.name');
					$message .=' '.$url;
                    $xml = $this->OauthConsumer->post('Twitter', $user['User']['twitter_access_token'], $user['User']['twitter_access_key'], 'https://twitter.com/statuses/update.xml', array(
                        'status' => $message
                    ));
                }
            }
            if (Configure::read('request.post_request_on_facebook')) { // post on site facebook
                $fb_message =$user['User']['username'] . ' ' . __l('listed a new request "') . '' .$request['Request']['title']. __l('" in ') . Configure::read('site.name');
                $getFBReturn = $this->postOnFacebook($request, $fb_message, 1);
            }
            if (Configure::read('request.post_request_on_twitter')) { // post on site twitter
                $message = $user['User']['username'] . ' ' . __l('listed a new request "') . '' .$request['Request']['title']. __l('" in ') . Configure::read('site.name');
				$message .=' '.$url;
                $xml = $this->OauthConsumer->post('Twitter', Configure::read('twitter.site_user_access_token') , Configure::read('twitter.site_user_access_key') , 'https://twitter.com/statuses/update.xml', array(
                    'status' => $message
                ));
            }
        }
        if (!empty($getFBReturn) && ($getFBReturn == '2')) {
            $this->Session->setFlash(__l('Request has been listed. But unable to post it on facebook.') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Request has been listed.') , 'default', null, 'success');
        }
		if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
			$this->redirect(array(
				'action' => 'index',
			));
		} else {
			$this->redirect(array(
				'controller' => 'requests',
				'action' => 'index',
				'type' => 'myrequest',
				'admin' => false
			));
		}
    }
    // Posting Request on Facebook
    function postOnFacebook($request = null, $message = null, $admin = null)
    {
        if (!empty($request)) {
            $slug = $request['Request']['slug'];
			if ($admin) {
				$facebook_dest_user_id = Configure::read('facebook.page_id'); // Site Page ID
				$facebook_dest_access_token = Configure::read('facebook.fb_access_token');
            } else {
                $facebook_dest_user_id = $this->Auth->user('fb_user_id');
                $facebook_dest_access_token = $this->Auth->user('fb_access_token');
            }
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.api_key') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            if (empty($message)) {
                $message = $request['Request']['title'];
            }
			 $image_link = Router::url(array(
                'controller' => 'requests',
                'action' => 'view',
                'admin' => false,
                $slug
            ) , true);
            try {
                $getPostCheck = $this->facebook->api('/' . $facebook_dest_user_id . '/feed', 'POST', array(
                    'access_token' => $facebook_dest_access_token,
                    'message' => $message,
                    'picture' => '',
                    'icon' => '',
                    'link' =>  $image_link,
                    'description' => $request['Request']['description']
                ));
            }
            catch(Exception $e) {
                $this->log('Post on facebook error');
                return 2;
            }
        }
    }

    public function edit($id = null) 
    {
        $this->pageTitle = __l('Edit Request');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['City']['name'])) {
                $this->request->data['Request']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Request->City->findOrSaveAndGetId($this->request->data['City']['name']);
            }
            if (!empty($this->request->data['State']['name'])) {
                $this->request->data['Request']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Request->State->findOrSaveAndGetId($this->request->data['State']['name']);
            }
            if ($this->Request->save($this->request->data)) {
                $this->Session->setFlash(__l('Request has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Request could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Request->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $preferences = array();
        $preferences['500m'] = '500m';
        $preferences['1km'] = '1km';
        $preferences['2km'] = '2km';
        $preferences['3km'] = '3km';
        $preferences['5km'] = '5km';
        $preferences['10km'] = '10km';
        $preferences['50km'] = '50km';
        $accomadation = array();
        for ($i = 1; $i <= 20; $i++) {
            $accomadation[$i] = $i;
        }

        $amenities = $this->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
        $propertyTypes = $this->Request->PropertyType->find('list', array(
            'order' => array(
                'PropertyType.name' => 'ASC'
            )
        ));
		$holidayTypes = $this->Request->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $roomTypes = $this->Request->RoomType->find('list', array(
            'order' => array(
                'RoomType.name' => 'ASC'
            )
        ));
        $bedTypes = $this->Request->BedType->find('list', array(
            'order' => array(
                'BedType.name' => 'ASC'
            )
        ));
        $morning = array();
        $noon = array();
        for ($i = 1; $i <= 12; $i++) {
            if ($i == 12) {
                $noon[] = $i . '.00 pm (noon)';
                $morning[] = $i . '.00 am (midnight)';
            } else {
                $morning[] = $i . '.00 am';
                $noon[] = $i . '.00 pm';
            }
        }
        $checkin = array_merge($morning, $noon);
        $this->set('checkin', $checkin);
        $this->set('accomadation', $accomadation);
        $users = $this->Request->User->find('list');
        $cities = $this->Request->City->find('list');
        $states = $this->Request->State->find('list');
        $countries = $this->Request->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ),
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $this->set(compact('affiliates', 'users', 'cities', 'states', 'countries', 'preferences', 'holidayTypes','currencies', 'amenities', 'propertyTypes', 'roomTypes', 'bedTypes'));
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Request->delete($id)) {
            $this->Session->setFlash(__l('Request deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
				'type' => 'myrequest'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
	public function update_view_count()
	{
		if (!empty($_POST['ids'])) {
			$ids = explode(',', $_POST['ids']);
			$requests = $this->Request->find('all', array(
				'conditions' => array(
					'Request.id' => $ids
				) ,
				'fields' => array(
					'Request.id',
					'Request.request_view_count'
				) ,
				'recursive' => -1
			));
			foreach($requests as $request) {
				$json_arr[$request['Request']['id']] = $request['Request']['request_view_count'];
			}
			$this->view = 'Json';
			$this->set('json', $json_arr);
		}
	}
    public function admin_index() 
    {
        $this->pageTitle = 'Request';
        $conditions = array();
        $this->_redirectGET2Named(array(
            'q',
            'username',
            'property_type_id'
        ));
        $this->set('active_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_active = ' => 1,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('suspended_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.admin_suspend = ' => 1,
            ) ,
            'recursive' => -1
        )));
        $this->set('user_suspended_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_active = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Request->find('count', array(
            'conditions' => array(
                'Request.is_system_flagged = ' => 1,
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('total_requests', $this->Request->find('count', array(
            'conditions' => array(
                'Request.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Request']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Request']['filter_id'])) {
            if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Approved) {
                $conditions['Request.is_approved'] = 1;
                $this->pageTitle.= __l(' - Approved ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Disapproved) {
                $conditions['Request.is_approved'] = 0;
                $this->pageTitle.= __l(' - Disapproved ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Request.is_active'] = 1;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Request.is_active'] = 0;
                $this->pageTitle.= __l(' - User suspended ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Request.admin_suspend'] = 1;
                $this->pageTitle.= __l(' - Suspended ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Request.is_system_flagged'] = 1;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Flagged ');
            } else if ($this->request->data['Request']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Request.request_flag_count !='] = 0;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Request']['filter_id'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Request.is_active'] = 1;
                $conditions['Request.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Request.is_active'] = 0;
                $this->pageTitle.= __l(' - User suspended ');
            }
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Request.created) <= '] = 0;
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Request.created) <= '] = 7;
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Request.created) <= '] = 30;
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['property_category_id'])) {
            $this->request->data['Request']['property_category_id'] = $this->request->params['named']['property_category_id'];
            $conditions['Request.property_category_id'] = $this->request->params['named']['property_category_id'];
        }
        if (isset($this->request->params['named']['property_type_id'])) {
            $this->request->data['Request']['property_type_id'] = $this->request->params['named']['property_type_id'];
            $conditions['Request.property_type_id'] = $this->request->params['named']['property_type_id'];
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
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['Request']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->pageTitle = __l('Requests');
        $this->Request->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'Request.id',
                'Request.created',
                'Request.user_id',
                'Request.title',
                'Request.checkin',
                'Request.checkout',
                'Request.slug',
                'Request.price_per_night',
                'Request.is_approved',
                'Request.property_count',
                'Request.request_view_count',
                'Request.request_flag_count',
                'Request.is_active',
                'Request.address',
                'Request.admin_suspend',
                'Request.accommodates',
                'Request.detected_suspicious_words',
                'Request.is_system_flagged',
                'Request.request_favorite_count',
                'PropertyType.name',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.is_active'
                    )
                ) ,
                'RequestFlag' => array(
                    'fields' => array(
                        'RequestFlag.id',
                        'RequestFlag.user_id',
                        'RequestFlag.request_id'
                    )
                ) ,
                'PropertyType'
            ) ,
            'order' => array(
                'Request.id' => 'desc'
            )
        );
        if (isset($this->request->data['Request']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['Request']['q']
            ));
        }
        $moreActions = $this->Request->moreActions;
        $this->set(compact('moreActions'));
        $this->set('requests', $this->paginate());
    }
    public function admin_add() 
    {
        $this->setAction('add');
    }
    public function admin_edit($id = null) 
    {
        $this->setAction('edit', $id);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Request->delete($id)) {
            $this->Session->setFlash(__l('Request deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function update() 
    {
        $this->autoRender = false;
        if (!empty($this->request->data[$this->modelClass])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $selectedIds = array();
            foreach($this->request->data[$this->modelClass] as $primary_key_id => $is_checked) {
                if ($is_checked['id']) {
                    $selectedIds[] = $primary_key_id;
                }
            }
            if ($actionid && !empty($selectedIds)) {
                if ($actionid == ConstMoreAction::Inactive) {
                    $this->{$this->modelClass}->updateAll(array(
                        $this->modelClass . '.is_active' => 0
                    ) , array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked request has been disabled') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->{$this->modelClass}->updateAll(array(
                        $this->modelClass . '.is_active' => 1
                    ) , array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked request has been enabled') , 'default', null, 'success');
                } elseif ($actionid == ConstMoreAction::Delete) {
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked request has been deleted') , 'default', null, 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
	public function sample_data()
	{
		set_time_limit(0);
		Configure::write('debug', 1);
		$dummyData = $this->Request->query('SELECT * FROM tmp_dummy_data LIMIT 0, 1');
		$title = array(
			'Need beach house near ',
			'Need rooms for rent near ',
			'Need luxury beach house near ',
			'Need house near to beach near ',
			'Need guest house near ',
			'Need luxurious place to live near ',
			'Need fully furnished house near ',
			'Need luxurious apartment near ',
		);
		$country_arr = array(43, 254, 253, 113, 14);
		$image = $country = 0;
		$escape_city = array();
		$checkin = 0;
		foreach($dummyData as $dummy) {
			if ($dummy['tmp_dummy_data']['id'] == 101 || $dummy['tmp_dummy_data']['id'] == 201 || $dummy['tmp_dummy_data']['id'] == 301 || $dummy['tmp_dummy_data']['id'] == 401) {
				$country++;
				$escape_city = array();
			}
			$tmp_country = $this->Request->query('SELECT * FROM tmp_countries WHERE id = ' . $country_arr[$country]);
			$escape_not_in_city = '';
			if (!empty($escape_city)) {
				$escape_not_in_city = ' AND id NOT IN (' . implode(',', $escape_city) . ')';
			}
			$tmp_city = $this->Request->query('SELECT * FROM tmp_cities WHERE country_id = ' . $country_arr[$country] . $escape_not_in_city . ' LIMIT 0, 1');
			$escape_city[] = $tmp_city[0]['tmp_cities']['id'];
			$tmp_state = $this->Request->query('SELECT * FROM tmp_states WHERE id = ' . $tmp_city[0]['tmp_cities']['state_id']);
			$_data['Request']['user_id'] = mt_rand(2, 10);
			$_data['Request']['property_type_id'] = mt_rand(1, 12);
			$_data['Request']['room_type_id'] = mt_rand(1, 3);
			$_data['Request']['bed_type_id'] = mt_rand(1, 5);
			$_data['Request']['city_id'] = $tmp_city[0]['tmp_cities']['id'];
			$_data['Request']['state_id'] = $tmp_city[0]['tmp_cities']['state_id'];
			$_data['Request']['country_id'] = $country_arr[$country];
			$_data['Request']['title'] = $title[mt_rand(0, 7)] . $tmp_city[0]['tmp_cities']['name'];
			$_data['Request']['description'] = str_replace('.', '', $dummy['tmp_dummy_data']['description']);
			$_data['Request']['accommodates'] = mt_rand(1, 16);
			$_data['Request']['address'] = $dummy['tmp_dummy_data']['address'] . ', ' . $tmp_city[0]['tmp_cities']['name'] . ', ' . $tmp_state[0]['tmp_states']['name'] . ', ' . $tmp_country[0]['tmp_countries']['title'];
			$_data['Request']['phone'] = $dummy['tmp_dummy_data']['phone'];
			$_data['Request']['ip_id'] = 2;
			$price_arr = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 300, 400, 500, 150, 250, 350, 450);
			$_data['Request']['price_per_night'] = $price_arr[mt_rand(0, 17)];
			$prev_checkin = $last_checkin = !empty($last_checkin) ? $last_checkin : 'now';
			if ($last_checkin == $prev_checkin) {
				if ($checkin == 3) {
					$checkin = 0;
					$_data['Request']['checkin'] = date('Y-m-d', strtotime($last_checkin . ' +' . mt_rand(2, 10) . ' days'));
					$last_checkin = $_data['Request']['checkin'];
				} else {
					$_data['Request']['checkin'] = date('Y-m-d', strtotime($last_checkin));
					$checkin++;
				}
			}
			$_data['Request']['checkout'] = date('Y-m-d', strtotime($_data['Request']['checkin'] . ' +' . mt_rand(2, 10) . ' days'));
			$_data['Request']['latitude'] = $tmp_city[0]['tmp_cities']['latitude'];
			$_data['Request']['longitude'] = $tmp_city[0]['tmp_cities']['longitude'];
			$_data['Request']['zoom_level'] = 10;
			$_data['Request']['bed_rooms'] = mt_rand(1, 20);
			$_data['Request']['beds'] = mt_rand(1, 20);
			$_data['Request']['bath_rooms'] = mt_rand(1, 20);
			$_data['Request']['is_active'] = ($dummy['tmp_dummy_data']['id']%50 == 0) ? 0 : 1;
			$_data['Request']['is_approved'] = ($dummy['tmp_dummy_data']['id']%50 == 0) ? 0 : 1;
			// amenities
			$tmp_am = $result_am = $am = array();
			for($a=1;$a<=22;$a++) {
				$tmp_am[] = $a;
			}
			$result_am = array_rand($tmp_am, 11);
			for($a=0;$a<11;$a++) {
				$am[] = $tmp_am[$result_am[$a]];
			}
			$_data['Amenity']['Amenity'] = $am;
			// holiday types
			$tmp_ht = $result_ht = $ht = array();
			for($a=1;$a<=8;$a++) {
				$tmp_ht[] = $a;
			}
			$result_ht = array_rand($tmp_ht, 4);
			for($a=0;$a<3;$a++) {
				$ht[] = $tmp_ht[$result_ht[$a]];
			}
			$_data['HolidayType']['HolidayType'] = $ht;
			$_data['Request']['id'] = '';
			$this->Request->create();
			$this->Request->save($_data);
			$_data = array();
		}
		exit;
	}
}
?>