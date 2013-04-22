<?php
class JoinpropertiesController extends AppController
{
    public $name = 'Joinproperties';
    public $lastDays;
    public $uses = array(
        'Property',
        'Request',
        'SearchKeyword',
        'SearchLog',
        'EmailTemplate',
    );
    public $helpers = array(
        'Text'
    );
    public $permanentCacheAction = array(
		'user' => array(
			'calendar_edit',
			'calendar',
			'datafeed',
			'property_calendar',
			'manage_property',
			'my_properties',
			'import',
			'post_to_craigslist',
		) ,
		'public' => array(
			'index',
			'search',
			'map',
			'home',
		) ,
		'admin' => array(
			'add',
			'edit',
			'admin_add',
			'admin_edit',
		) ,
        'is_view_count_update' => true
    );

    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Property.address',
            'Attachment',
            'Attachment.file',
            'Property.latitude',
            'Property.longitude',
            'Property.ne_latitude',
            'Property.ne_longitude',
            'Property.sw_latitude',
            'Property.sw_longitude',
            'Property.zoom_level',
            'Property.country_id',
            'Property.step1',
            'Property.step2',
            'Property.step3',
            'Property.step4',
            'Property.step5',
            'Amenity.Amenity',
            'Joinproperty',
            'HolidayType.HolidayType',
            'PropertyUser.property_id',
            'PropertyUser.property_slug',
            'Property.jscity',
            'PropertyUser.type',
            'City.id',
            'State.id',
            'State.name',
            'City.name',
        );
        parent::beforeFilter();
    }

    public function search()
    {
        $this->pageTitle = __l('Home');
        $this->request->data['Property']['checkout'] = getCheckoutDate(date('Y-m-d'));
    }
    public function index($hash_keyword = '', $salt = '')
    {
       $this->_redirectPOST2Named(array(
            'cityName',
            'city',
            'latitude',
            'longitude',
            'sw_latitude',
            'ne_longitude',
            'sw_longitude',
            'ne_latitude',
            'slug',
            'checkin',
            'keyword',
            'checkout',
            'additional_guest',
            'type',
            'language',
            'network_level',
            'is_flexible',
            'RoomType',
            'HolidayType',
            'PropertyType',
            'min_bedrooms',
            'min_bathrooms',
            'min_beds',
            'range_from',
            'range_to',
            'deposit_from',
            'deposit_to',
            'Amenity'
        ));
        $this->pageTitle = __l('Properties');
        $search_keyword = array();
        if ($this->RequestHandler->isAjax() && !isset($this->request->params['named']['share']) && ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'lst_my_properties') || empty($this->request->params['named']['type']))) {
            $this->set('search', 'map');
        }
        $is_city = true;
        $current_latitude = '';
        $current_longitude = '';
        $amenity_conditions = array();
        $query_string = '';
        $is_searching = true;
        if (!empty($hash_keyword) && !empty($salt)) {
            $salt1 = hexdec($hash_keyword) +786;
            $salt1 = substr(dechex($salt1) , 0, 2);
            if ($salt1 != $salt) {
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'search',
                ));
            }
            $named_array = $this->Property->getSearchKeywords($hash_keyword, $salt);
            $search_keyword['named'] = array_merge($this->request->params['named'], $named_array);
            $this->request->params['named']['type'] = !empty($search_keyword['named']['type']) ? $search_keyword['named']['type'] : 'search';
            $is_city = false;
        } else {
            $CityList = array();
            if (!empty($this->request->params['named']['city'])) {
                $CityList = $this->Property->City->find('first', array(
                    'conditions' => array(
                        'City.slug' => $this->request->params['named']['city'],
                    ) ,
                    'recursive' => -1
                ));
            }
            //direct url access without hash ans salt, so we are forming querystring and stroed in search for as normal process
            if (!empty($CityList) && $this->request->params['named']['city'] != 'all') {
                $query_string = '/city:' . $CityList['City']['name'];
                $query_string.= '/cityname:' . $CityList['City']['name'];
                $query_string.= '/latitude:' . $CityList['City']['latitude'];
                $query_string.= '/longitude:' . $CityList['City']['longitude'];
            } else {
                $is_searching = false;
                $query_string = '/city:';
                $query_string.= '/cityname:';
                $query_string.= '/latitude:';
                $query_string.= '/longitude:';
            }
           // $query_string.= '/checkin:' . date('Y-m-d');
           // $query_string.= '/checkout:' . getCheckoutDate(date('Y-m-d'));
            $query_string.= '/additional_guest:1';
            $query_string.= '/range_from:1';
            $query_string.= '/deposit_from:0';
            $query_string.= '/is_flexible:1';
            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection') {
                $query_string.= '/type:collection';
                if (!empty($this->request->params['named']['slug'])) {
                    $query_string.= '/slug:' . $this->request->params['named']['slug'];
                }
            } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user') {
                $query_string.= '/type:user';
                if (!empty($this->request->params['named']['slug'])) {
                    $query_string.= '/slug:' . $this->request->params['named']['slug'];
                }
            } else {
                $query_string.= '/type:search';
                $this->request->params['named']['type'] = !empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : 'search';
            }
            $searchkeyword['SearchKeyword']['keyword'] = $query_string;
            $this->SearchKeyword->save($searchkeyword, false);
            $keyword_id = $this->SearchKeyword->getLastInsertId();
            //maintain in search log
            $searchlog = array();
            $searchlog['SearchLog']['search_keyword_id'] = $keyword_id;
            $searchlog['SearchLog']['ip_id'] = $this->SearchLog->toSaveIp();
            if ($this->Auth->user('id')) {
                $searchlog['SearchLog']['user_id'] = $this->Auth->user('id');
            }
            $this->SearchLog->save($searchlog, false);
            $salt = $keyword_id+786;
            $hash_query_string = '/' . dechex($keyword_id) . '/' . substr(dechex($salt) , 0, 2);
            $this->request->params['pass']['0'] = dechex($keyword_id);
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
           // $search_keyword['named']['checkout'] = getCheckoutDate(date('Y-m-d'));
            $search_keyword['named']['is_flexible'] = 1; // default flexible

        }
        $conditions = array();
        $conditions['Property.admin_suspend'] = 0;
        $conditions['Property.is_approved'] = 1;
        $conditions['Property.is_active'] = 1;
        $conditions['Property.is_paid'] = 1;
        $exact_match = array();
        $limit = !empty($this->request->params['named']['limit']) ? $this->request->params['named']['limit'] : '20';
        if (!empty($this->request->params['named']['user']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user') {
            $is_searching = true;
            $conditions['Property.user_id'] = $this->request->params['named']['user'];
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection') {
            $slug = !empty($this->request->params['named']['slug']) ? $this->request->params['named']['slug'] : (!empty($search_keyword['named']['slug']) ? $search_keyword['named']['slug'] : '');
            if (!empty($slug)) {
                $is_searching = true;
                $collection = $this->Property->Collection->find('first', array(
                    'conditions' => array(
                        'Collection.slug' => $slug
                    ) ,
                    'fields' => array(
                        'Collection.id',
                    ) ,
                    'recursive' => -1
                ));
                if (empty($collection)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                $property_ids = $this->Property->CollectionsProperty->find('list', array(
                    'conditions' => array(
                        'CollectionsProperty.collection_id' => $collection['Collection']['id'],
                    ) ,
                    'fields' => array(
                        'CollectionsProperty.id',
                        'CollectionsProperty.property_id',
                    ) ,
                    'recursive' => -1
                ));
                $collections = $this->Property->Collection->find('first', array(
                    'conditions' => array(
                        'Collection.id' => $collection['Collection']['id'],
                    ) ,
                    'fields' => array(
                        'Collection.title',
                        'Collection.slug',
                        'Collection.description',
                        'Collection.property_count',
                        'Collection.country_count',
                        'Collection.city_count',
                    ) ,
                    'recursive' => -1
                ));
                $this->set('collections', $collections);
                $this->set('collection_description', $collections['Collection']['description']);
                $this->set('property_count', $collections['Collection']['property_count']);
                $this->set('country_count', $collections['Collection']['country_count']);
                $this->set('city_count', $collections['Collection']['city_count']);
                $this->pageTitle = 'Collection - ' . $collections['Collection']['title'];
                if (count($property_ids) > 0) {
                    $conditions['Property.id'] = $property_ids;
                }
                // filter search for collection
                $holidaytype = isset($search_keyword['named']['holidaytype']) ? $search_keyword['named']['holidaytype'] : '';
                $propertytype = isset($search_keyword['named']['propertytype']) ? $search_keyword['named']['propertytype'] : '';
                $roomtype = isset($search_keyword['named']['roomtype']) ? $search_keyword['named']['roomtype'] : '';
                $language = isset($search_keyword['named']['language']) ? $search_keyword['named']['language'] : '';
                $network_level = isset($search_keyword['named']['network_level']) ? $search_keyword['named']['network_level'] : '';
                $min_beds = isset($search_keyword['named']['min_beds']) ? $search_keyword['named']['min_beds'] : '';
                $min_bedrooms = isset($search_keyword['named']['min_bedrooms']) ? $search_keyword['named']['min_bedrooms'] : '';
                $min_bathrooms = isset($search_keyword['named']['min_bathrooms']) ? $search_keyword['named']['min_bathrooms'] : '';
                $amenity = isset($search_keyword['named']['amenity']) ? $search_keyword['named']['amenity'] : '';
                $rangefrom = isset($search_keyword['named']['range_from']) ? $search_keyword['named']['range_from'] : '1';
                $rangeto = isset($search_keyword['named']['range_to']) ? $search_keyword['named']['range_to'] : '300+';
                $depositfrom = isset($search_keyword['named']['deposit_from']) ? $search_keyword['named']['deposit_from'] : '0';
                $depositto = isset($search_keyword['named']['deposit_to']) ? $search_keyword['named']['deposit_to'] : '300+';
                $amenity_list = array();
                $holiday_list = array();
                $property_list = array();
                if (!empty($roomtype)) {
                    $this->request->data['Property']['RoomType'] = explode(',', $roomtype);
                    if (count($this->request->data['Property']['RoomType']) > 0) {
                        $conditions['Property.room_type_id'] = $this->request->data['Property']['RoomType'];
                    }
                }
                if (!empty($min_beds)) {
                    $this->request->data['Property']['min_beds'] = $min_beds;
                    $conditions['Property.beds >='] = $this->request->data['Property']['min_beds'];
                }
                if (!empty($min_bedrooms)) {
                    $this->request->data['Property']['min_bedrooms'] = $min_bedrooms;
                    $conditions['Property.bed_rooms >='] = $this->request->data['Property']['min_bedrooms'];
                }
                if (!empty($min_bathrooms)) {
                    $this->request->data['Property']['min_bathrooms'] = $min_bathrooms;
                    $conditions['Property.bath_rooms >='] = $this->request->data['Property']['min_bathrooms'];
                }
                if (!empty($language)) {
                    $this->request->data['Property']['language'] = explode(',', $language);
                    $host_languages = $this->Property->User->UserProfile->find('list', array(
                        'conditions' => array(
                            'UserProfile.language_id' => $this->request->data['Property']['language']
                        ) ,
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.user_id'
                        )
                    ));
                    $conditions['Property.user_id'] = $host_languages;
                }
                if (!empty($network_level)) {
                    $this->request->data['Property']['network_level'] = explode(',', $network_level);
                    $tmp_user_ids = array();
                    foreach($this->request->data['Property']['network_level'] as $tmp_network_level) {
                        if (!empty($_SESSION['network_level'][$tmp_network_level])) {
                            foreach($_SESSION['network_level'][$tmp_network_level] as $session_network_level) {
                                $tmp_user_ids[] = $session_network_level;
                            }
                        }
                    }
                    if (!empty($tmp_user_ids)) {
                        $conditions['Property.user_id'] = $tmp_user_ids;
                    } else {
                        $conditions['Property.user_id ='] = '';
                    }
                }
                if (!empty($holidaytype)) {
                    $this->request->data['Property']['HolidayType'] = explode(',', $holidaytype);
                    $holidayTypes = $this->Property->HolidayTypeProperty->find('all', array(
                        'conditions' => array(
                            'HolidayTypeProperty.holiday_type_id' => $this->request->data['Property']['HolidayType']
                        ) ,
                        'fields' => array(
                            'HolidayTypeProperty.holiday_type_id',
                            'HolidayTypeProperty.property_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $total_holiday_type_list = array();
                    foreach($holidayTypes as $holidayType) {
                        $total_holiday_type_list[$holidayType['HolidayTypeProperty']['holiday_type_id']][] = $holidayType['HolidayTypeProperty']['property_id'];
                    }
                    if (!empty($total_holiday_type_list)) {
                        $holiday_list = $total_holiday_type_list[current($this->request->data['Property']['HolidayType']) ];
                        next($this->request->data['Property']['HolidayType']);
                        foreach($this->request->data['Property']['HolidayType'] as $holiday_type) {
                            $holiday_list = array_intersect($holiday_list, $total_holiday_type_list[$holiday_type]);
                        }
                    }
                }
                if (!empty($propertytype)) {
                    $this->request->data['Property']['PropertyType'] = explode(',', $propertytype);
                    if (count($this->request->data['Property']['PropertyType']) > 0) {
                        $conditions['Property.property_type_id'] = $this->request->data['Property']['PropertyType'];
                    }
                }
                if (!empty($amenity)) {
                    $this->request->data['Property']['Amenity'] = explode(',', $amenity);
                    $amenitiesProperties = $this->Property->AmenitiesProperty->find('all', array(
                        'conditions' => array(
                            'AmenitiesProperty.amenity_id' => $this->request->data['Property']['Amenity']
                        ) ,
                        'fields' => array(
                            'AmenitiesProperty.amenity_id',
                            'AmenitiesProperty.property_id'
                        ) ,
                        'recursive' => -1
                    ));
                    foreach($amenitiesProperties as $amenitiesProperty) {
                        $total_amenity_list[$amenitiesProperty['AmenitiesProperty']['amenity_id']][] = $amenitiesProperty['AmenitiesProperty']['property_id'];
                    }
                    $amenity_list = $total_amenity_list[current($this->request->data['Property']['Amenity']) ];
                    next($this->request->data['Property']['Amenity']);
                    foreach($this->request->data['Property']['Amenity'] as $amenity) {
                        $amenity_list = array_intersect($amenity_list, $total_amenity_list[$amenity]);
                    }
                }
                if (!empty($holiday_list) && !empty($amenity_list)) {
                    $property_list = array_intersect($holiday_list, $amenity_list);
                } elseif (!empty($holiday_list)) {
                    $property_list = $holiday_list;
                } elseif (!empty($amenity_list)) {
                    $property_list = $amenity_list;
                }
                if (!empty($property_list) && count($property_list) > 0) {
                    $conditions['Property.id'] = array_intersect($property_ids, $property_list);
                }
                if (!empty($rangefrom)) {
                    $conditions['Property.price_per_night >='] = $rangefrom;
                    $exact_match['Property.price_per_night >='] = $rangefrom;
                }
                if (!empty($rangeto) && $rangeto != '300+') {
                    $conditions['Property.price_per_night <='] = $rangeto;
                }
                if (!empty($depositfrom)) {
                    $conditions['Property.security_deposit >='] = $depositfrom;
                    $exact_match['Property.security_deposit >='] = $depositfrom;
                }
                if (!empty($depositeto) && $depositto != '300+') {
                    $conditions['Property.security_deposit <='] = $depositto;
                }
                if (!empty($search_keyword['named']['keyword'])) {
                    $conditions['Property.title LIKE '] = '%' . $search_keyword['named']['keyword'] . '%';
                }
                if (!empty($search_keyword['named']['sw_latitude'])) {
                    $lon1 = round($search_keyword['named']['sw_longitude'], 6);
                    $lon2 = round($search_keyword['named']['ne_longitude'], 6);
                    $lat1 = round($search_keyword['named']['sw_latitude'], 6);
                    $lat2 = round($search_keyword['named']['ne_latitude'], 6);
                    $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                        $lat1,
                        $lat2
                    );
                    $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                        $lon1,
                        $lon2
                    );
                }
            }
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite') {
            if (!$this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $is_searching = true;
            $propertyFavorites = $this->Property->PropertyFavorite->find('list', array(
                'conditions' => array(
                    'PropertyFavorite.user_id =' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'PropertyFavorite.property_id'
                ) ,
                'recursive' => -1,
            ));
            //if (!empty($propertyFavorites)) {
            $conditions['Property.id'] = $propertyFavorites;
            //}
            $user = $this->Property->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1,
            ));
            $this->set('user', $user);
        }
        if (!empty($this->request->params['named']['user_id']) && !empty($this->request->params['named']['property_id'])) {
            $conditions['Property.user_id'] = $this->request->params['named']['user_id'];
            $conditions['Property.id !='] = $this->request->params['named']['property_id'];
        }
        if (!empty($this->request->params['named']['property']) && $this->request->params['named']['property'] == 'my_properties') {
            $requests = $this->Property->PropertiesRequest->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->params['named']['request_id'],
                ) ,
                'recursive' => -1
            ));
            $this->set('request_name', $requests['Request']['title']);
            $conditions['Property.user_id'] = $this->Auth->user('id');
            //distance based search
            $dist = Configure::read('site.exact_distance_limit') /1.60934; // 2 kms
            $this->request->params['named']['request_latitude'] = round($this->request->params['named']['request_latitude'], 6);
            $this->request->params['named']['request_longitude'] = round($this->request->params['named']['request_longitude'], 6);
            $lon1 = $this->request->params['named']['request_longitude']-$dist/abs(cos(deg2rad($this->request->params['named']['request_latitude'])) *69);
            $lon2 = $this->request->params['named']['request_longitude']+$dist/abs(cos(deg2rad($this->request->params['named']['request_latitude'])) *69);
            $lat1 = $this->request->params['named']['request_latitude']-($dist/69);
            $lat2 = $this->request->params['named']['request_latitude']+($dist/69);
            $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                $lat1,
                $lat2
            );
            $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                $lon1,
                $lon2
            );
            //exact match properties finder
            $match_conditions = array();
            $match_conditions['Property.user_id'] = $this->Auth->user('id');
            $match_conditions['Property.is_active'] = 1;
            $match_conditions['Property.latitude BETWEEN ? AND ?'] = array(
                $lat1,
                $lat2
            );
            $match_conditions['Property.longitude BETWEEN ? AND ?'] = array(
                $lon1,
                $lon2
            );
            $match_conditions['Property.price_per_night <='] = $requests['Request']['price_per_night'];
            $days = getCheckinCheckoutDiff($requests['Request']['checkin'], getCheckoutDate($requests['Request']['checkout']));
            $match_conditions['Property.minimum_nights <='] = $days;
            $match_conditions['AND'][]['OR'] = array(
                'Property.maximum_nights <=' => $days,
                'Property.maximum_nights =' => 0
            );
            $match_conditions['Property.accommodates >='] = $requests['Request']['accommodates'];
            $match_conditions['Property.accommodates !='] = 0;
            // check checkin date booked or not for this request
            $booking_conditions = array();
            $booking_conditions['PropertyUser.property_user_status_id'] = array(
                ConstPropertyUserStatus::Confirmed,
                ConstPropertyUserStatus::Arrived
            );
            $booking_conditions['PropertyUser.checkin <='] = getCheckoutDate($requests['Request']['checkout']);
            $booking_conditions['PropertyUser.checkout >='] = $requests['Request']['checkin'];
            $booking_list = $this->Property->PropertyUser->find('list', array(
                'conditions' => $booking_conditions,
                'fields' => array(
                    'PropertyUser.id',
                    'PropertyUser.property_id'
                ) ,
                'recursive' => -1
            ));
            $custom_conditions['CustomPricePerNight.is_available'] = ConstPropertyStatus::Available;
            $custom_conditions['CustomPricePerNight.start_date <='] = getCheckoutDate($requests['Request']['checkout']);
            $custom_conditions['CustomPricePerNight.end_date >='] = $requests['Request']['checkin'];
            $not_available_list = $this->Property->CustomPricePerNight->find('list', array(
                'conditions' => $custom_conditions,
                'fields' => array(
                    'CustomPricePerNight.id',
                    'CustomPricePerNight.property_id'
                ) ,
                'recursive' => -1
            ));
            $booking_list = array_merge($booking_list, $not_available_list);
            if (!empty($booking_list)) {
                $match_conditions['NOT']['Property.id'] = $booking_list;
            }
            $available_list = $this->Property->find('list', array(
                'conditions' => $match_conditions,
                'fields' => array(
                    'Property.id'
                ) ,
                'recursive' => -1
            ));
            $this->set('available_list', $available_list);
            $limit = 9;
        }
        $fields = '';
        //Nearby properties
        if (!empty($this->request->params['named']['city_id']) && !empty($this->request->params['named']['property_id'])) {
            $conditions['Property.id !='] = $this->request->params['named']['property_id'];
            $nearby_property = $this->Property->find('first', array(
                'conditions' => array(
                    'Property.id' => $this->request->params['named']['property_id']
                ) ,
                'recursive' => -1,
            ));
            //distance based search
            $nearby_dist = Configure::read('site.distance_limit') /1.60934; // 10 kms
            $nearby_property['Property']['latitude'] = round($nearby_property['Property']['latitude'], 6);
            $nearby_property['Property']['longitude'] = round($nearby_property['Property']['longitude'], 6);
            $nearby_lon1 = $nearby_property['Property']['longitude']-$nearby_dist/abs(cos(deg2rad($nearby_property['Property']['latitude'])) *69);
            $nearby_lon2 = $nearby_property['Property']['longitude']+$nearby_dist/abs(cos(deg2rad($nearby_property['Property']['latitude'])) *69);
            $nearby_lat1 = $nearby_property['Property']['latitude']-($nearby_dist/69);
            $nearby_lat2 = $nearby_property['Property']['latitude']+($nearby_dist/69);
            $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                $nearby_lat1,
                $nearby_lat2
            );
            $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                $nearby_lon1,
                $nearby_lon2
            );
            $fields = "3956 * 2 * ASIN(SQRT(  POWER(SIN((Property.latitude - " . $nearby_property['Property']['latitude'] . ") * pi()/180 / 2), 2) + COS(Property.latitude * pi()/180) *  COS(" . $nearby_property['Property']['latitude'] . " * pi()/180) * POWER(SIN((Property.longitude - " . $nearby_property['Property']['longitude'] . ") * pi()/180 / 2), 2)  )) as distance";
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties') {
            $this->request->params['pass'] = array();
            $this->pageTitle = __l('My Properties');
            if (!$this->Auth->user('id')) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Property.user_id'] = $this->Auth->user('id');
            $is_city = false;
            //unset default conditions
            unset($conditions['Property.admin_suspend']);
            unset($conditions['Property.is_approved']);
            unset($conditions['Property.is_active']);
            unset($conditions['Property.is_paid']);
            if (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'pending') {
                $conditions['Property.is_paid'] = 0;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'active') {
                $conditions['Property.is_active'] = 1;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'inactive') {
                $conditions['Property.is_active'] = 0;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'verified') {
                $conditions['Property.is_verified'] = ConstVerification::Verified;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'notverified') {
                $conditions['Property.is_verified'] = NULL;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'waiting_for_verification') {
                $conditions['Property.is_verified'] = ConstVerification::WaitingForVerification;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'waiting_for_approval') {
                $conditions['Property.is_approved'] = 0;
            } elseif (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'imported') {
                $conditions['Property.is_imported_from_airbnb'] = 1;
            }
            //Count Querys
            $this->set('all_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            )));
            $this->set('active_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_active' => 1
                ) ,
                'recursive' => -1
            )));
            $this->set('inactive_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_active' => 0
                ) ,
                'recursive' => -1
            )));
            $this->set('verified_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_verified' => ConstVerification::Verified
                ) ,
                'recursive' => -1
            )));
            $this->set('notverified_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_verified' => NULL
                ) ,
                'recursive' => -1
            )));
            $this->set('waiting_for_verification_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_verified' => ConstVerification::WaitingForVerification
                ) ,
                'recursive' => -1
            )));
            $this->set('waiting_for_approval_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_approved' => 0
                ) ,
                'recursive' => -1
            )));
            $this->set('imported_from_airbnb_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_imported_from_airbnb' => 1
                ) ,
                'recursive' => -1
            )));
            $this->set('pending_count', $this->Property->find('count', array(
                'conditions' => array(
                    'Property.user_id' => $this->Auth->user('id') ,
                    'Property.is_paid' => 0
                ) ,
                'recursive' => -1
            )));
        } else {
            $exact_match = $conditions;
        }
        if (!empty($this->_prefixId) && $is_city) {
            if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user') {
                $conditions['Property.city_id'] = $this->_prefixId;
            }
        }
        $this->Property->recursive = 2;
        $order = array();
        $this->set('search', 'normal');
        $conditions_fav = array();
        if ($this->Auth->user()) {
            $conditions_fav['PropertyFavorite.user_id'] = $this->Auth->user('id');
        }
        // its called from property_users index
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'lst_my_properties') {
            $conditions['Property.user_id'] = $this->Auth->user('id');;
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'related') {
            $is_searching = true;
            // @todo "What goodies I can provide (guest)"
            if (!empty($this->request->params['named']['request_latitude']) && !empty($this->request->params['named']['request_longitude'])) {
                //distance based search
                $dist = 10; // 10 kms
                $this->request->params['named']['request_longitude'] = round($this->request->params['named']['request_longitude'], 6);
                $this->request->params['named']['request_latitude'] = round($this->request->params['named']['request_latitude'], 6);
                $lon1 = $this->request->params['named']['request_longitude']-$dist/abs(cos(deg2rad($this->request->params['named']['request_latitude'])) *69);
                $lon2 = $this->request->params['named']['request_longitude']+$dist/abs(cos(deg2rad($this->request->params['named']['request_latitude'])) *69);
                $lat1 = $this->request->params['named']['request_latitude']-($dist/69);
                $lat2 = $this->request->params['named']['request_latitude']+($dist/69);
                $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                    $lat1,
                    $lat2
                );
                $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                    $lon1,
                    $lon2
                );
            }
            $limit = 5;
            $conditions['Property.user_id !='] = $this->Auth->user('id');
            $this->set('search', 'map');
        }
        if (!empty($this->request->params['named']['sortby'])) {
                if ($this->request->params['named']['sortby'] == 'distance') {
                $order = array(
                    'distance'
                );
            } elseif ($this->request->params['named']['sortby'] == 'favorites') {
                $order = array(
                    'Property.property_favorite_count'  => 'DESC'
                );
            } elseif ($this->request->params['named']['sortby'] == 'high') {
                $order = array(
                    'Property.price_per_night'
                );
            } elseif ($this->request->params['named']['sortby'] == 'low') {
                $order = array(
                    'Property.price_per_night' => 'DESC'
                );
            } elseif ($this->request->params['named']['sortby'] == 'recent') {
                $order = array(
                    'Property.id' => 'DESC'
                );
            } elseif ($this->request->params['named']['sortby'] == 'featured') {
                $order = array(
                    'Property.is_featured' => 'DESC'
                );
            } elseif ($this->request->params['named']['sortby'] == 'reviews') {
                $order = array(
                    'Property.positive_feedback_count' => 'desc'
                );
            }
        } else {
            if (!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) {
                $order = array(
                    'distance' => 'asc'
                );
            }
        }
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'search') {
            $booking_conditions = array();
            $current_latitude = !empty($search_keyword['named']['latitude']) ? round($search_keyword['named']['latitude'], 6) : '';
            $current_longitude = !empty($search_keyword['named']['longitude']) ? round($search_keyword['named']['longitude'], 6) : '';
            $checkin = !empty($search_keyword['named']['checkin'])?$search_keyword['named']['checkin']:'';
            $checkout = !empty($search_keyword['named']['checkout'])?$search_keyword['named']['checkout']:'';
            $checkout_cdn = $checkout;
            if (Configure::read('property.days_calculation_mode') == 'Night') {
                $checkout_cdn = date('Y-m-d', strtotime('-1 day', strtotime($checkout)));
                if (strtotime($checkout) <= strtotime($checkin)) {
                    $this->Session->setFlash(__l('Check out date should be greater than the checkin date') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'search'
                    ));
                }
            }
            $days = dateDiff($checkin, $checkout);
            if (!empty($search_keyword['named']['latitude'])) {
                $this->pageTitle.= ' - Search - ' . $search_keyword['named']['cityname'];
            }
            $additional_guest = isset($search_keyword['named']['additional_guest']) ? $search_keyword['named']['additional_guest'] : 1;
            $holidaytype = isset($search_keyword['named']['holidaytype']) ? $search_keyword['named']['holidaytype'] : '';
            $propertytype = isset($search_keyword['named']['propertytype']) ? $search_keyword['named']['propertytype'] : '';
            $roomtype = isset($search_keyword['named']['roomtype']) ? $search_keyword['named']['roomtype'] : '';
            $language = isset($search_keyword['named']['language']) ? $search_keyword['named']['language'] : '';
            $network_level = isset($search_keyword['named']['network_level']) ? $search_keyword['named']['network_level'] : '';
            $min_beds = isset($search_keyword['named']['min_beds']) ? $search_keyword['named']['min_beds'] : '';
            $min_bedrooms = isset($search_keyword['named']['min_bedrooms']) ? $search_keyword['named']['min_bedrooms'] : '';
            $min_bathrooms = isset($search_keyword['named']['min_bathrooms']) ? $search_keyword['named']['min_bathrooms'] : '';
            $amenity = isset($search_keyword['named']['amenity']) ? $search_keyword['named']['amenity'] : '';
            $rangefrom = isset($search_keyword['named']['range_from']) ? $search_keyword['named']['range_from'] : '1';
            $rangeto = isset($search_keyword['named']['range_to']) ? $search_keyword['named']['range_to'] : '300+';
            $depositfrom = isset($search_keyword['named']['deposit_from']) ? $search_keyword['named']['deposit_from'] : '0';
            $depositto = isset($search_keyword['named']['deposit_to']) ? $search_keyword['named']['deposit_to'] : '300+';
            $amenity_list = array();
            $holiday_list = array();
            $property_list = array();
            if (!empty($roomtype)) {
                $this->request->data['Property']['RoomType'] = explode(',', $roomtype);
                if (count($this->request->data['Property']['RoomType']) > 0) {
                    $conditions['Property.room_type_id'] = $this->request->data['Property']['RoomType'];
                }
            }
            if (!empty($min_beds)) {
                $this->request->data['Property']['min_beds'] = $min_beds;
                $conditions['Property.beds >='] = $this->request->data['Property']['min_beds'];
            }
            if (!empty($min_bedrooms)) {
                $this->request->data['Property']['min_bedrooms'] = $min_bedrooms;
                $conditions['Property.bed_rooms >='] = $this->request->data['Property']['min_bedrooms'];
            }
            if (!empty($min_bathrooms)) {
                $this->request->data['Property']['min_bathrooms'] = $min_bathrooms;
                $conditions['Property.bath_rooms >='] = $this->request->data['Property']['min_bathrooms'];
            }
            if (!empty($language)) {
                $this->request->data['Property']['language'] = explode(',', $language);
                $host_languages = $this->Property->User->UserProfile->find('list', array(
                    'conditions' => array(
                        'UserProfile.language_id' => $this->request->data['Property']['language']
                    ) ,
                    'fields' => array(
                        'UserProfile.id',
                        'UserProfile.user_id'
                    )
                ));
                $conditions['Property.user_id'] = $host_languages;
            }
            if (!empty($network_level)) {
                $this->request->data['Property']['network_level'] = explode(',', $network_level);
                $tmp_user_ids = array();
                foreach($this->request->data['Property']['network_level'] as $tmp_network_level) {
                    if (!empty($_SESSION['network_level'][$tmp_network_level])) {
                        foreach($_SESSION['network_level'][$tmp_network_level] as $session_network_level) {
                            $tmp_user_ids[] = $session_network_level;
                        }
                    }
                }
                if (!empty($tmp_user_ids)) {
                    $conditions['Property.user_id'] = $tmp_user_ids;
                } else {
                    $conditions['Property.user_id ='] = '';
                }
            }
            if (!empty($holidaytype)) {
                $this->request->data['Property']['HolidayType'] = explode(',', $holidaytype);
                $holidayTypes = $this->Property->HolidayTypeProperty->find('all', array(
                    'conditions' => array(
                        'HolidayTypeProperty.holiday_type_id' => $this->request->data['Property']['HolidayType']
                    ) ,
                    'fields' => array(
                        'HolidayTypeProperty.holiday_type_id',
                        'HolidayTypeProperty.property_id'
                    ) ,
                    'recursive' => -1
                ));
                $total_holiday_type_list = array();
                foreach($holidayTypes as $holidayType) {
                    $total_holiday_type_list[$holidayType['HolidayTypeProperty']['holiday_type_id']][] = $holidayType['HolidayTypeProperty']['property_id'];
                }
                if (!empty($total_holiday_type_list)) {
                    $holiday_list = $total_holiday_type_list[current($this->request->data['Property']['HolidayType']) ];
                    next($this->request->data['Property']['HolidayType']);
                    foreach($this->request->data['Property']['HolidayType'] as $holiday_type) {
                        $holiday_list = array_intersect($holiday_list, $total_holiday_type_list[$holiday_type]);
                    }
                }
            }
            if (!empty($propertytype)) {
                $this->request->data['Property']['PropertyType'] = explode(',', $propertytype);
                if (count($this->request->data['Property']['PropertyType']) > 0) {
                    $conditions['Property.property_type_id'] = $this->request->data['Property']['PropertyType'];
                }
            }
            if (!empty($amenity)) {
                $this->request->data['Property']['Amenity'] = explode(',', $amenity);
                $amenitiesProperties = $this->Property->AmenitiesProperty->find('all', array(
                    'conditions' => array(
                        'AmenitiesProperty.amenity_id' => $this->request->data['Property']['Amenity']
                    ) ,
                    'fields' => array(
                        'AmenitiesProperty.amenity_id',
                        'AmenitiesProperty.property_id'
                    ) ,
                    'recursive' => -1
                ));
                foreach($amenitiesProperties as $amenitiesProperty) {
                    $total_amenity_list[$amenitiesProperty['AmenitiesProperty']['amenity_id']][] = $amenitiesProperty['AmenitiesProperty']['property_id'];
                }
                $amenity_list = $total_amenity_list[current($this->request->data['Property']['Amenity']) ];
                next($this->request->data['Property']['Amenity']);
                foreach($this->request->data['Property']['Amenity'] as $amenity) {
                    $amenity_list = array_intersect($amenity_list, $total_amenity_list[$amenity]);
                }
            }
            if (!empty($holiday_list) && !empty($amenity_list)) {
                $property_list = array_intersect($holiday_list, $amenity_list);
            } elseif (!empty($holiday_list)) {
                $property_list = $holiday_list;
            } elseif (!empty($amenity_list)) {
                $property_list = $amenity_list;
            }
            if (!empty($property_list) && count($property_list) > 0) {
                $conditions['Property.id'] = $property_list;
            }
            if (!empty($rangefrom)) {
                $conditions['Property.price_per_night >='] = $rangefrom;
                $exact_match['Property.price_per_night >='] = $rangefrom;
            }
            if (!empty($rangeto) && $rangeto != '300+') {
                $conditions['Property.price_per_night <='] = $rangeto;
            }
            if (!empty($depositfrom)) {
                $conditions['Property.security_deposit >='] = $depositfrom;
                $exact_match['Property.security_deposit >='] = $depositfrom;
            }
            if (!empty($depositeto) && $depositto != '300+') {
                $conditions['Property.security_deposit <='] = $depositto;
            }
            if (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude'])) {
                //distance calcuation based on lat and lng
                $fields = "3956 * 2 * ASIN(SQRT(  POWER(SIN((Property.latitude - $current_latitude) * pi()/180 / 2), 2) + COS(Property.latitude * pi()/180) *  COS($current_latitude * pi()/180) * POWER(SIN((Property.longitude - $current_longitude) * pi()/180 / 2), 2)  )) as distance";
            }
            if (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude']) && empty($search_keyword['named']['sw_latitude'])) {
                //distance based search
                if (isset($search_keyword['named']['is_flexible']) && !$search_keyword['named']['is_flexible']) {
                    $dist = Configure::read('site.exact_distance_limit') /1.60934;
                } else {
                    $dist = Configure::read('site.distance_limit') /1.60934; // 10 kms

                }
                $exact_dist = Configure::read('site.exact_distance_limit') /1.60934; // 10 kms
                $lon1 = $current_longitude-$dist/abs(cos(deg2rad($current_latitude)) *69);
                $lon2 = $current_longitude+$dist/abs(cos(deg2rad($current_latitude)) *69);
                $lat1 = $current_latitude-($dist/69);
                $lat2 = $current_latitude+($dist/69);
                //exact match finder
                $exact_lon1 = $current_longitude-$exact_dist/abs(cos(deg2rad($current_latitude)) *69);
                $exact_lon2 = $current_longitude+$exact_dist/abs(cos(deg2rad($current_latitude)) *69);
                $exact_lat1 = $current_latitude-($exact_dist/69);
                $exact_lat2 = $current_latitude+($exact_dist/69);
                if (!isset($conditions['Property.city_id'])) {
                    $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                        $lat1,
                        $lat2
                    );
                    $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                        $lon1,
                        $lon2
                    );
                    //exact match
                    $exact_match['Property.latitude BETWEEN ? AND ?'] = array(
                        $exact_lat1,
                        $exact_lat2
                    );
                    $exact_match['Property.longitude BETWEEN ? AND ?'] = array(
                        $exact_lon1,
                        $exact_lon2
                    );
                }
            } else {
                if (!empty($search_keyword['named']['sw_latitude'])) {
                    $lon1 = round($search_keyword['named']['sw_longitude'], 6);
                    $lon2 = round($search_keyword['named']['ne_longitude'], 6);
                    $lat1 = round($search_keyword['named']['sw_latitude'], 6);
                    $lat2 = round($search_keyword['named']['ne_latitude'], 6);
                    $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                        $lat1,
                        $lat2
                    );
                    $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                        $lon1,
                        $lon2
                    );
                }
            }
            if (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude']) && empty($search_keyword['named']['sw_latitude'])) {
                array_push($order, array(
                    'distance' => 'asc',
                    'is_featured' => 'desc'
                ));
            }
            if (!empty($this->request->params['named']['search'])) {
                $lon1 = round($this->request->params['named']['sw_longitude'], 6);
                $lon2 = round($this->request->params['named']['ne_longitude'], 6);
                $lat1 = round($this->request->params['named']['sw_latitude'], 6);
                $lat2 = round($this->request->params['named']['ne_latitude'], 6);
                $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                    $lat1,
                    $lat2
                );
                $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                    $lon1,
                    $lon2
                );
                $this->set('search', 'map');
            } else {
                if (!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) {
                    //distance based search
                    $dist = Configure::read('site.distance_limit') /1.60934; // 10 kms
                    $lon1 = $current_longitude-$dist/abs(cos(deg2rad($current_latitude)) *69);
                    $lon2 = $current_longitude+$dist/abs(cos(deg2rad($current_latitude)) *69);
                    $lat1 = $current_latitude-($dist/69);
                    $lat2 = $current_latitude+($dist/69);
                    $conditions['Property.latitude BETWEEN ? AND ?'] = array(
                        $lat1,
                        $lat2
                    );
                    $conditions['Property.longitude BETWEEN ? AND ?'] = array(
                        $lon1,
                        $lon2
                    );
                }
            }
            if (!empty($search_keyword['named']['keyword'])) {
                $conditions['Property.title LIKE '] = '%' . $search_keyword['named']['keyword'] . '%';
            }
            //if dates are not flexible then strictly search given creteria
            $custom_conditions = array();
            if ((isset($this->request->params['named']['is_flexible']) && !$this->request->params['named']['is_flexible']) || (isset($search_keyword['named']['is_flexible']) && !$search_keyword['named']['is_flexible'])) {
                //minimum and maximum nights calculation
                if ((!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) || (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude']))) {
                    $conditions['Property.minimum_nights <='] = $days;
                    $conditions['AND'][]['OR'] = array(
                        'Property.maximum_nights <=' => $days,
                        'Property.maximum_nights =' => 0
                    );
                }
                if (!empty($additional_guest)) {
                    $conditions['AND'][]['OR'] = array(
                        'Property.accommodates >=' => $additional_guest,
                        'Property.accommodates !=' => 0
                    );
                }
                $booking_conditions['PropertyUser.property_user_status_id'] = array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived
                );
                $booking_conditions['PropertyUser.checkin <='] = $checkout_cdn;
                $booking_conditions['PropertyUser.checkout >='] = $checkin;
                $booking_list = $this->Property->PropertyUser->find('list', array(
                    'conditions' => $booking_conditions,
                    'fields' => array(
                        'PropertyUser.id',
                        'PropertyUser.property_id'
                    ) ,
                    'recursive' => -1
                ));
                $custom_conditions['CustomPricePerNight.is_available'] = ConstPropertyStatus::Available;
                $custom_conditions['CustomPricePerNight.start_date <='] = $checkout_cdn;
                $custom_conditions['CustomPricePerNight.end_date >='] = $checkin;
                $not_available_list = $this->Property->CustomPricePerNight->find('list', array(
                    'conditions' => $custom_conditions,
                    'fields' => array(
                        'CustomPricePerNight.id',
                        'CustomPricePerNight.property_id'
                    ) ,
                    'recursive' => -1
                ));
                $booking_list = array_merge($booking_list, $not_available_list);
                $booked_ids = array();
                if (count($booking_list) > 0) {
                    foreach($booking_list as $booking) {
                        $booked_ids[] = $booking;
                    }
                }
                if (count($booked_ids) > 0) {
                    $conditions['NOT']['Property.id'] = $booked_ids;
                }
            }
            //exact match set
            $exact_match['Property.minimum_nights <='] = $days;
            $exact_match['AND'][]['OR'] = array(
                'Property.maximum_nights <=' => $days,
                'Property.maximum_nights =' => 0
            );
            $exact_match['AND'][]['OR'] = array(
                'Property.accommodates >=' => $additional_guest,
                'Property.accommodates =' => 0
            );
            /*Exact match calculation creteria */
            // ----------------Start --------------
            $custom_conditions['CustomPricePerNight.is_available'] = ConstPropertyStatus::Available;
            $custom_conditions['CustomPricePerNight.start_date <='] = $checkout_cdn;
            $custom_conditions['CustomPricePerNight.end_date >='] = $checkin;
            $not_available_list = $this->Property->CustomPricePerNight->find('list', array(
                'conditions' => $custom_conditions,
                'fields' => array(
                    'CustomPricePerNight.id',
                    'CustomPricePerNight.property_id'
                ) ,
                'recursive' => -1
            ));
            $booking_list = $not_available_list;
            $booked_ids = array();
            if (count($booking_list) > 0) {
                foreach($booking_list as $booking) {
                    $booked_ids[] = $booking;
                }
            }
            $booked_ids = array_unique($booked_ids);
            $this->set('booked_property_ids', $booked_ids);
            $exact_ids = $this->Property->find('list', array(
                'conditions' => $exact_match,
                'fields' => array(
                    'Property.id',
                    'Property.id'
                )
            ));
            $exact_ids = array_unique($exact_ids);
            $this->set('exact_ids', $exact_ids);
            // --------------- ENd ------------------------
            $this->paginate = array(
                'conditions' => array(
                    $conditions
                ) ,
                'contain' => array(
                    'User',
                    'PropertyFavorite' => array(
                        'conditions' => $conditions_fav,
                        'fields' => array(
                            'PropertyFavorite.id',
                            'PropertyFavorite.user_id',
                            'PropertyFavorite.property_id',
                        )
                    ) ,
                    'Attachment',
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso2'
                        )
                    ) ,
                ) ,
                'fields' => array(
                    'Property.id',
                    'Property.created',
                    'Property.modified',
                    'Property.user_id',
                    'Property.cancellation_policy_id',
                    'Property.property_type_id',
                    'Property.room_type_id',
                    'Property.bed_type_id',
                    'Property.city_id',
                    'Property.state_id',
                    'Property.title',
                    'Property.slug',
                    'Property.description',
                    'Property.street_view',
                    'Property.accommodates',
                    'Property.address',
                    'Property.unit',
                    'Property.phone',
                    'Property.price_per_night',
                    'Property.price_per_week',
                    'Property.price_per_month',
                    'Property.minimum_nights',
                    'Property.maximum_nights',
                    'Property.additional_guest',
                    'Property.checkin',
                    'Property.checkout',
                    'Property.latitude',
                    'Property.longitude',
                    'Property.zoom_level',
                    'Property.rate',
                    'Property.bed_rooms',
                    'Property.beds',
                    'Property.property_view_count',
                    'Property.property_favorite_count',
                    'Property.property_feedback_count',
                    'Property.positive_feedback_count',
                    'Property.property_view_count',
                    'Property.is_pets',
                    'Property.is_negotiable',
                    'Property.is_system_flagged',
                    'Property.is_active',
                    'Property.is_paid',
                    'Property.is_featured',
                    'Property.is_verified',
                    '((Property.positive_feedback_count/Property.property_feedback_count)*100) as reviews',
                    $fields,
                ) ,
                'order' => $order,
                'limit' => $limit,
                'recursive' => 3,
            );
        } else {
            if (empty($order)) {
                $order = array(
                    'Property.id' => 'DESC'
                );
            }
            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'collection') {
                $conditions['Property.beds >='] = 1;
                $conditions['Property.bed_rooms >='] = 1;
                $conditions['Property.bath_rooms >='] = 1;
            }
            $this->paginate = array(
                'conditions' => array(
                    $conditions
                ) ,
                'contain' => array(
                    'User',
                    'Amenity' => array(
                        'conditions' => $amenity_conditions,
                    ) ,
                    'PropertyFavorite' => array(
                        'conditions' => $conditions_fav,
                        'fields' => array(
                            'PropertyFavorite.id',
                            'PropertyFavorite.user_id',
                            'PropertyFavorite.property_id',
                        )
                    ) ,
                    'Attachment',
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso2'
                        )
                    ) ,
                ) ,
                'order' => $order,
                'limit' => $limit,
                'recursive' => 3,
            );
            $booked_ids = array();
            $exact_ids = array();
            $this->set('booked_property_ids', $booked_ids);
            $this->set('exact_ids', $exact_ids);
            $this->request->data['Property']['is_flexible'] = 1;
        }
        $total_property_count = $this->Property->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        $this->set('total_result', $total_property_count);
        $set_filter_count = $this->Property->getFilterCount($conditions);
        $this->set('search_keyword', $search_keyword);
        $roomTypes = $this->Property->RoomType->find('list', array(
            'order' => array(
                'RoomType.name' => 'asc'
            )
        ));
        $conditions['Property.room_type_id'] = array_keys($roomTypes);
        $room_types = $this->Property->find('all', array(
            'fields' => array(
                'Property.room_type_id',
                'count(Property.id) as property_count',
            ) ,
            'conditions' => $conditions,
            'group' => 'Property.room_type_id',
            'recursive' => -1
        ));
        $rom_types = array();
        foreach($room_types as $room_type) {
            $rom_types[$room_type['Property']['room_type_id']] = $room_type[0]['property_count'];
        }
        foreach($roomTypes as $key => $val) {
            if (isset($rom_types[$key])) {
                $roomTypes[$key] = $val . ' (' . $rom_types[$key] . ')';
            } else {
                $roomTypes[$key] = $val . ' (0)';
            }
        }
        $holidayTypes = $this->Property->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'asc'
            )
        ));
        foreach($holidayTypes as $holiday_type_id => $holidayType) {
            $holidayTypes[$holiday_type_id] = $holidayType . ' (' . (!empty($set_filter_count['holiday_types_' . $holiday_type_id]) ? $set_filter_count['holiday_types_' . $holiday_type_id] : 0) . ')';
        }
        $language_lists = $this->Property->find('list', array(
            'conditions' => array(
                'Property.language_id !=' => 0
            ) ,
            'fields' => array(
                'Property.language_id'
            )
        ));
        $languages = $this->Property->User->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.id' => $language_lists
            ) ,
            'order' => array(
                'Language.name' => 'asc'
            )
        ));
        $amenities = $this->Property->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'asc'
            )
        ));
        foreach($amenities as $amenity_id => $amenity) {
            $amenities[$amenity_id] = $amenity . ' (' . (!empty($set_filter_count['amenities_' . $amenity_id]) ? $set_filter_count['amenities_' . $amenity_id] : 0) . ')';
        }
        $propertyTypes = $this->Property->PropertyType->find('list', array(
            'order' => array(
                'PropertyType.name' => 'asc'
            )
        ));
        $conditions['Property.property_type_id'] = array_keys($propertyTypes);
        $property_types = $this->Property->find('all', array(
            'fields' => array(
                'Property.property_type_id',
                'count(Property.id) as property_count',
            ) ,
            'conditions' => $conditions,
            'group' => 'Property.property_type_id',
            'recursive' => -1
        ));
        $propertyy_types = array();
        foreach($property_types as $property_type) {
            $propertyy_types[$property_type['Property']['property_type_id']] = $property_type[0]['property_count'];
        }
        foreach($propertyTypes as $key => $val) {
            if (isset($propertyy_types[$key])) {
                $propertyTypes[$key] = $val . ' (' . $propertyy_types[$key] . ')';
            } else {
                $propertyTypes[$key] = $val . ' (0)';
            }
        }
        $range_from = array();
        $range_to = array();
        $deposit_from = array();
        $deposit_to = array();
        $minimum = array();
        $minimumBeds = array();
        for ($j = 1; $j <= 10; $j = $j+1) {
            $minimum[$j] = $j;
        }
        for ($j = 1; $j <= 15; $j = $j+1) {
            $minimumBeds[$j] = $j;
        }
        $minimumBeds[16] = '16+';
        $deposit_from[0] = 0;
        $deposit_to[0] = 0;
        for ($i = 1; $i <= 300; $i = $i+5) {
            $range_from[$i] = $i;
            $deposit_from[$i] = $i;
            $range_to[$i] = $i;
            $deposit_to[$i] = $i;
        }
        $range_to['300+'] = '300+';
        $range_from['300+'] = '300+';
        $deposit_to['300+'] = '300+';
        $deposit_from['300+'] = '300+';
        $this->set(compact('roomTypes', 'holidayTypes', 'amenities', 'languages', 'propertyTypes'));
        $this->set('range_from', $range_from);
        $this->set('range_to', $range_to);
        $this->set('deposit_from', $deposit_from);
        $this->set('deposit_to', $deposit_to);
        $this->set('minimum', $minimum);
        $this->set('minimumBeds', $minimumBeds);
        $this->set('current_latitude', $current_latitude);
        $this->set('current_longitude', $current_longitude);
        if (!Configure::read('property.is_enable_property_count')) {
            $is_searching = true;
        }
        $this->set('is_searching', $is_searching);
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json') && $is_searching === true) {
            $this->view = 'Json';
            $properties = $this->paginate();
            $total_properties = count($properties);
            for ($i = 0; $i < $total_properties; $i++) {
				$properties[$i]['TmpUser'] = $properties[$i]['User'];
				unset($properties[$i]['User']);
				$properties[$i]['User'] = array(
					'id' => $properties[$i]['TmpUser']['id'],
					'username' => $properties[$i]['TmpUser']['username']
				);
				unset($properties[$i]['TmpUser']);
                //views
                $properties[$i]['Property']['views'] = $properties[$i]['Property']['property_view_count'];
                $this->Property->saveiPhoneAppThumb($properties[$i]['Attachment']);
                $image_options = array(
                    'dimension' => 'iphone_big_thumb',
                    'class' => '',
                    'alt' => $properties[$i]['Property']['title'],
                    'title' => $properties[$i]['Property']['title'],
                    'type' => 'jpg',
                    'full_url' => true
                );
                $iphone_big_thumb = getImageUrl('Property', $properties[$i]['Attachment'][0], $image_options);
                $properties[$i]['Property']['iphone_big_thumb'] = $iphone_big_thumb;
                $image_options = array(
                    'dimension' => 'iphone_small_thumb',
                    'class' => '',
                    'alt' => $properties[$i]['Property']['title'],
                    'title' => $properties[$i]['Property']['title'],
                    'type' => 'jpg',
                    'full_url' => true
                );
                $iphone_small_thumb = getImageUrl('Property', $properties[$i]['Attachment'][0], $image_options);
                $properties[$i]['Property']['iphone_small_thumb'] = $iphone_small_thumb;
                $properties[$i]['Property']['total_page'] = ceil($total_property_count/20);
                $properties[$i]['Property']['current_page'] = !empty($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            }
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $properties : $this->viewVars['iphone_response']);
        }
        // For iPhone App code -->
        if ($this->RequestHandler->isAjax()) {
            $this->set('search', 'map');
        }
        if (!isset($search_keyword['named']['range_to'])) {
            $this->request->data['Property']['range_to'] = '301';
        } else {
            $this->request->data['Property']['range_to'] = $search_keyword['named']['range_to'];
        }
        if (isset($search_keyword['named']['range_from'])) {
            $this->request->data['Property']['range_from'] = $search_keyword['named']['range_from'];
        }
        if (!empty($search_keyword['named']['is_flexible'])) {
            $this->request->data['Property']['is_flexible'] = $search_keyword['named']['is_flexible'];
        }
        if (!isset($search_keyword['named']['deposit_to'])) {
            $this->request->data['Property']['deposit_to'] = '301';
        } else {
            $this->request->data['Property']['deposit_to'] = $search_keyword['named']['deposit_to'];
        }
        if (isset($search_keyword['named']['deposit_from'])) {
            $this->request->data['Property']['deposit_from'] = $search_keyword['named']['deposit_from'];
        }
        if (!empty($search_keyword['named']['is_flexible'])) {
            $this->request->data['Property']['is_flexible'] = $search_keyword['named']['is_flexible'];
        }
        if (!empty($search_keyword['named']['additional_guest'])) {
            $this->request->data['Property']['additional_guest'] = $search_keyword['named']['additional_guest'];
        }
        if (isset($search_keyword['named']['checkin'])) {
            $this->request->data['Property']['checkin'] = $search_keyword['named']['checkin'];
        }
        if (isset($search_keyword['named']['checkout'])) {
            $this->request->data['Property']['checkout'] = $search_keyword['named']['checkout'];
        }
        if (!empty($this->request->params['named']['request_id'])) {
            $this->request->data['Property']['request_id'] = $this->request->params['named']['request_id'];
        }
        //checkin/checkout date valid check
        if ($this->request->data['Property']['checkin'] < date('Y-m-d') || $this->request->data['Property']['checkin'] > $this->request->data['Property']['checkout'] || $this->request->data['Property']['checkout'] < date('Y-m-d')) {
			if ($this->RequestHandler->prefers('json')) {
				$response = array(
					'status' => 1,
					'message' => __l('Checkin/checkout date is invalid')
				);
				$this->view = 'Json';
				$this->set('json', $response);
			} else {
				$this->Session->setFlash(__l('Checkin/checkout date is invalid') , 'default', null, 'error');
				$this->redirect(array(
					'controller' => 'properties',
					'action' => 'index',
				));
			}
        }
        $properties = $this->paginate();
        // social connections list
        if ($this->Auth->user('id') && $this->Auth->user('is_show_facebook_friends') && $this->Auth->user('is_facebook_friends_fetched')) {
            $social_conditions['Property.user_id != '] = $this->Auth->user('id');
            $social_conditions = array_merge($conditions, $social_conditions);
            $tmpProperties = $this->Property->find('list', array(
                'conditions' => $social_conditions,
                'fields' => array(
                    'Property.id',
                    'Property.user_id',
                ) ,
                'recursive' => -1
            ));
            $tmpUserPropertyCount = array_count_values($tmpProperties);
            if (!empty($tmpProperties)) {
                $user_ids = $this->Property->User->find('list', array(
                    'conditions' => array(
                        'User.id' => array_keys($tmpUserPropertyCount) ,
                        'User.is_facebook_friends_fetched' => 1
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.network_fb_user_id',
                    )
                ));
                if (!empty($user_ids)) {
                    $network_level = $this->Property->getFacebookFriendLevel($user_ids);
                    $this->set('network_level', $network_level);
                    $network_property_count = array();
                    $network_level_session = array();
                    foreach($network_level as $tmp_user_id => $level) {
                        if (isset($network_property_count[$level])) {
                            $network_property_count[$level]+= $tmpUserPropertyCount[$tmp_user_id];
                        } else {
                            $network_level_session[$level][] = $tmp_user_id;
                            $network_property_count[$level] = $tmpUserPropertyCount[$tmp_user_id];
                        }
                    }
                    if (empty($_SESSION['network_level'])) {
                        $_SESSION['network_level'] = $network_level_session;
                    }
                    $this->set('network_property_count', $network_property_count);
                }
            }
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection') {
            $slug = !empty($this->request->params['named']['slug']) ? $this->request->params['named']['slug'] : (!empty($search_keyword['named']['slug']) ? $search_keyword['named']['slug'] : '');
            $collection = $this->Property->Collection->find('first', array(
                'conditions' => array(
                    'Collection.slug' => $slug
                ) ,
                'fields' => array(
                    'Collection.id',
                ) ,
                'recursive' => -1
            ));
            $i = 0;
            if (!empty($properties)) {
                foreach($properties as $property) {
                    $collections = $this->Property->CollectionsProperty->find('first', array(
                        'conditions' => array(
                            'CollectionsProperty.property_id = ' => $property['Property']['id'],
                            'CollectionsProperty.collection_id = ' => $collection['Collection']['id']
                        ) ,
                        'fields' => array(
                            'CollectionsProperty.display_order',
                        ) ,
                        'recursive' => -1,
                    ));
                    $properties[$i]['Property']['display_order'] = $collections['CollectionsProperty']['display_order'];
                    $i++;
                }
            }
            //Sorting code start here
            // compare function
            function cmpi($a, $b)
            {
                global $sort_field;
                return strcmp($a['Property']['display_order'], $b['Property']['display_order']);
            }
            // do the array sorting
            if (!isset($this->request->params['named']['sortby']) && !empty($properties)) {
                usort($properties, 'cmpi');
            }
            //sorting code ends here

        }
        $this->set('properties', $properties);
        if ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched')) {
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.app_id') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            $fb_return_url = Router::url(array(
                'controller' => 'users',
                'action' => 'fb_update',
                'admin' => false
            ) , true);
            $this->Session->write('fb_return_url', $fb_return_url);
            $fb_login_url = $this->facebook->getLoginUrl(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'scope' => 'email,offline_access,publish_stream'
            ));
            $this->set('fb_login_url', $fb_login_url);
        }
        if (!empty($this->request->params['named']['user']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user') {
            $this->render('index');
        }
        if ((!empty($this->request->params['named']['user_id']) && !empty($this->request->params['named']['property_id'])) || (!empty($this->request->params['named']['city_id']) && !empty($this->request->params['named']['property_id']))) {
            $this->set('near_by', 1);
            $this->render('index');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite') {
            $this->pageTitle = __l('Liked Properties');
            $this->render('index');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties') {
            $chart_data = $this->Property->getBookingChart($this->Auth->user('id') , null);
            $moreActions = $this->Property->moreMyPropertiesActions;
            $this->set(compact('moreActions', 'chart_data'));
            $this->render('my_properties');
        }
        if (!empty($this->request->params['named']['property']) && $this->request->params['named']['property'] == 'my_properties') {
            $this->pageTitle = __l('Make an offer');
            $this->render('my-properties-compact');
        }
        // its called from property_users index
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'lst_my_properties') {
            $this->render('lst_my_properties');
        }
    }
    function streetview($lat, $lng)
    {
        $this->set('lat', $lat);
        $this->set('lng', $lng);
    }
    function review_index()
    {
        $this->set('property_id', $this->request->params['named']['property_id']);
    }
    function flickr($lat = null, $lng = null)
    {
        $this->set('lat', $lat);
        $this->set('lng', $lng);
    }
    function weather_data($cityname = null)
    {
        $this->set('cityname', $cityname);
    }
    function amenities_around($lat = null, $lng = null)
    {
        $this->set('lat', $lat);
        $this->set('lng', $lng);
    }
    function tweet_around($lat = null, $lng = null)
    {
        $this->set('lat', $lat);
        $this->set('lng', $lng);
    }
    public function calendar_edit()
    {
        $id = $this->request->query['id'];
        $start = $this->request->query['start'];
        $end = $this->request->query['end'];
        $title = $this->request->query['title'];
        $description = isset($this->request->query['description']) ? $this->request->query['description'] : '';
        $model = isset($this->request->query['model']) ? $this->request->query['model'] : '';
        $property_id = isset($this->request->query['property_id']) ? $this->request->query['property_id'] : '';
        $current_status = isset($this->request->query['current_status']) ? $this->request->query['current_status'] : '';
        $price = isset($this->request->query['price']) ? $this->request->query['price'] : '';
        if (!empty($current_status)) {
            $this->request->data['status'] = $current_status;
        }
        $property_status_list = $this->Property->PropertyUser->PropertyUserStatus->find('list', array(
            'conditions' => array(
                'PropertyUserStatus.id' => array(
                    16,
                    17,
                    18,
                    6
                ) ,
            ) ,
            'fields' => array(
                'PropertyUserStatus.id',
                'PropertyUserStatus.name'
            ) ,
            'recursive' => -1
        ));
        $this->set('id', $id);
        $this->set('property_start', $start);
        $this->set('property_end', $end);
        $this->set('property_title', $title);
        $this->set('property_id', $property_id);
        $this->set('property_description', $description);
        $this->set('property_model', $model);
        $this->set('price', $price);
        $this->set('current_status', $current_status);
        $this->set('property_status_list', $property_status_list);
    }
    public function calendar($type)
    {
        if (is_null($type)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['property_id'])) {
            $id = $this->request->params['named']['property_id'];
        } else if (!empty($this->request->params['named']['ids'])) {
            $id = $this->request->params['named']['ids'];
        } else {
            $id = '';
        }
        $conditions = array();
        if (!empty($id)) {
            $conditions['Property.id'] = explode(',', $id);
        } else {
            if (!$this->Auth->user()) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (!empty($type) && $type == 'guest') {
            if (!empty($this->request->params['named']['month'])) {
                $month = $this->request->params['named']['month'];
            } else {
                $month = date('m');
            }
            if (!empty($this->request->params['named']['year'])) {
                $year = $this->request->params['named']['year'];
            } else {
                $year = date('Y');
            }
            $data = $this->Property->_getCalendarBookingDates($id, $month, $year);
            $this->set('month', $month);
            $this->set('year', $year);
            $this->set('data', $data);
        } else if (!empty($type) && $type == 'guest_list') {
            if (!empty($this->request->params['named']['month'])) {
                $month = $this->request->params['named']['month'];
            } else {
                $month = date('m');
            }
            if (!empty($this->request->params['named']['year'])) {
                $year = $this->request->params['named']['year'];
            } else {
                $year = date('Y');
            }
            for ($i = 0; $i < 12; $i++) {
                $guest_lists[$i]['month'] = $month;
                $guest_lists[$i]['year'] = $year;
                $guest_lists[$i]['id'] = $id;
                $guest_lists[$i]['data'] = $this->Property->_getCalendarBookingDates($id, $month, $year);
                if ($month == 12) {
                    $month = 1;
                    $year = $year+1;
                } else {
                    $month++;
                }
            }
            $this->set('guest_lists', $guest_lists);
            $this->render('guest_list_calendar');
        }
        $this->set('id', $id);
        $this->set('type', $type);
    }
    public function datafeed()
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Wdcalendar');
        $this->Wdcalendar = new WdcalendarComponent($collection);
        if ((isset($this->request->params['named']['method'])) && $this->request->params['named']['method'] == 'guest') {
            $method = 'guest';
            $id = $this->request->params['named']['property_id'];
        } else {
            $method = $this->request->query['method'];
            $id = $this->request->params['named']['property_id'];
        }
        switch ($method) {
            case 'add':
                $ret = $this->Wdcalendar->addCalendar($_POST['CalendarStartTime'], $_POST['CalendarEndTime'], $_POST['CalendarTitle'], $_POST['IsAllDayEvent'], $_POST['property_id'], $_POST['is_available'], $_POST['fromdt'], $_POST['todt']);
                break;

            case 'list':
                $view = $_POST['viewtype'];
                $return = $this->Wdcalendar->getDateIntervals($_POST['showdate'], $_POST['viewtype']);
                if (!empty($id)) {
                    $ret = $this->Wdcalendar->listCalendar($return['start_date'], $return['end_date'], 'host', $view, $id);
                } else {
                    $ret = $this->Wdcalendar->listCalendar($return['start_date'], $return['end_date'], 'host', $view);
                }
                break;

            case 'remove':
                $ret = $this->Wdcalendar->removeCalendar($_POST['calendarId']);
                break;

            case 'update':
                if (!empty($_POST)) {
                    $property_id = $_POST['property_id'];
                    $id = $_POST['id'];
                    $st = $_POST['stpartdate'];
                    $et = $_POST['etpartdate'];
					$fromdt = $_POST['stpartdate'];
					$todt = $_POST['etpartdate'];
					if(!empty($_POST['fromdt'])) {
						$fromdt = $_POST['fromdt'];
					}
					if(!empty($_POST['todt'])) {
						$todt = $_POST['todt'];
					}
                    $ret = $this->Wdcalendar->updateDetailedCalendar($id, $property_id, $st, $et, $_POST['price'], $_POST['status'], $_POST['Description'], $_POST['model'], $_POST['colorvalue'], $_POST['timezone'], $fromdt, $todt);
                }
                break;
        }
        if ((isset($this->request->params['named']['method'])) && $this->request->params['named']['method'] == 'guest') {
            $this->set('data', $data);
            $this->set('year', $year);
            $this->set('month', $month);
            $this->render('guest');
        }
        $this->view = 'Json';
        $this->set('json', $ret);
    }
    public function weather()
    {
        $city = $this->request->params['named']['city'];
        $request_url = 'http://www.google.com/ig/api?weather=' . $city . '';
        $results = array();
        $xml = simplexml_load_file($request_url) or die("Google Weather feed not loading");
        if (!isset($xml->weather->problem_cause)) {
            //Parse current conditions XML
            $results['current']['condition'] = (array)$xml->weather->current_conditions->condition['data'];
            $results['current']['temp'] = (array)$xml->weather->current_conditions->temp_f['data'];
            $results['current']['humidity'] = (array)$xml->weather->current_conditions->humidity['data'];
            $results['current']['wind'] = (array)$xml->weather->current_conditions->wind_condition['data'];
            $results['current']['icon'] = (array)$xml->weather->current_conditions->icon['data'];
            $results['current']['city'] = (array)$xml->weather->forecast_information->city['data'];
            //Parse four day outlook XML
            for ($i = 0; $i <= 3; $i++) {
                $results[$i]['day'] = (array)$xml->weather->forecast_conditions->$i->day_of_week['data'];
                $results[$i]['condition'] = (array)$xml->weather->forecast_conditions->$i->condition['data'];
                $results[$i]['low'] = (array)$xml->weather->forecast_conditions->$i->low['data'];
                $results[$i]['high'] = (array)$xml->weather->forecast_conditions->$i->high['data'];
                $results[$i]['icon'] = (array)$xml->weather->forecast_conditions->$i->icon['data'];
            }
        }
        $this->view = 'Json';
        $this->set('json', $results);
    }
    public function get_info($id)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id =' => $id
            ) ,
            'contain' => array(
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height',
                        'Attachment.description'
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.name',
                        'Country.iso2'
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        $this->set('property', $property);
        $this->layout = 'ajax';
    }
    public function view($slug = null, $hash = null, $salt = null)
    {
        $this->pageTitle = __l('Property');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->request->data['PropertyUser']['checkout'] = date('Y-m-d');
        $this->set('distance_view', true);
        if (!empty($hash) && !empty($salt)) {
            $salt1 = hexdec($hash) +786;
            $salt1 = substr(dechex($salt1) , 0, 2);
            if ($salt1 != $salt) {
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'view',
                    $slug
                ));
            }
            $named_array = $this->Property->getSearchKeywords($hash, $salt);
            $this->request->params['named'] = array_merge($this->request->params['named'], $named_array);
            $is_city = false;
            if (empty($this->request->params['named']['cityname'])) {
                $this->set('distance_view', false);
            }
        }
        $conditions_fav = array();
        if ($this->Auth->user()) {
            $conditions_fav['PropertyFavorite.user_id'] = $this->Auth->user('id');
        }
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.slug =' => $slug
            ) ,
            'contain' => array(
                'Amenity',
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height',
                        'Attachment.description'
                    )
                ) ,
                'CancellationPolicy',
                'User',
                'HolidayType' => array(
                    'fields' => array(
                        'HolidayType.name',
                        'HolidayType.id',
                    )
                ) ,
                'PropertyType' => array(
                    'fields' => array(
                        'PropertyType.name'
                    )
                ) ,
                'RoomType' => array(
                    'fields' => array(
                        'RoomType.name'
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.name',
                        'Country.iso2'
                    )
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.name'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.name',
                        'City.id',
                    )
                ),
                'PropertyFavorite' => array(
                    'conditions' => $conditions_fav,
                    'fields' => array(
                        'PropertyFavorite.id',
                        'PropertyFavorite.user_id',
                        'PropertyFavorite.property_id',
                    )
                ) ,
                'BedType' => array(
                    'fields' => array(
                        'BedType.name'
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        if (empty($property) || (empty($property['Property']['is_active']) || !empty($property['Property']['admin_suspend']) || empty($property['Property']['is_approved'])) && ($this->Auth->user('id') != $property['Property']['user_id']) && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (empty($hash) && empty($salt)) {
            //generating keyword id
            $query_string = '/city:';
            $query_string.= '/cityname:';
            $query_string.= '/latitude:' . $property['Property']['latitude'];
            $query_string.= '/longitude:' . $property['Property']['longitude'];
            $query_string.= '/checkin:' . date('Y-m-d');
            $query_string.= '/checkout:' . date('Y-m-d');
            $query_string.= '/additional_guest:1';
            $query_string.= '/range_from:10';
            $query_string.= '/range_from:0';
            $query_string.= '/is_flexible:1';
            $query_string.= '/type:search';
            $query_string.= '/type:search';
            $searchkeyword['SearchKeyword']['keyword'] = $query_string;
            $this->SearchKeyword->save($searchkeyword, false);
            $keyword_id = $this->SearchKeyword->getLastInsertId();
            //maintain in search log
            $searchlog = array();
            $searchlog['SearchLog']['search_keyword_id'] = $keyword_id;
            $searchlog['SearchLog']['ip_id'] = $this->SearchLog->toSaveIp();
            if ($this->Auth->user('id')) {
                $searchlog['SearchLog']['user_id'] = $this->Auth->user('id');
            }
            $this->SearchLog->save($searchlog, false);
            $salt = $keyword_id+786;
            $hash_query_string = '/' . dechex($keyword_id) . '/' . substr(dechex($salt) , 0, 2);
            $this->request->params['pass']['1'] = dechex($keyword_id);
            $this->request->params['pass']['2'] = substr(dechex($salt) , 0, 2);
            $this->set('distance_view', false);
        }
        $amenities = $this->Property->Amenity->find('list');
        $holidayTypes = $this->Property->HolidayType->find('list');
        $this->set(compact('amenities', 'holidayTypes'));
        if (isset($this->request->params['named']['checkin']) && isset($this->request->params['named']['checkout'])) {
            $this->request->data['PropertyUser']['checkin'] = $this->request->params['named']['checkin'];
            $this->request->data['PropertyUser']['checkout'] = getCheckoutDate($this->request->params['named']['checkout']);
        }
        // Set the meta value for View Property
        $meta_keyword = '';
        if (isset($property['PropertyType']['name']) && !empty($property['PropertyType']['name'])) {
            if (empty($meta_keyword)) {
                $meta_keyword.= $property['PropertyType']['name'];
            } else {
                $meta_keyword.= ', ' . $property['PropertyType']['name'];
            }
        }
        if (isset($property['RoomType']['name']) && !empty($property['RoomType']['name'])) {
            if (empty($meta_keyword)) {
                $meta_keyword.= $property['RoomType']['name'];
            } else {
                $meta_keyword.= ', ' . $property['RoomType']['name'];
            }
        }
        if (isset($property['BedType']['name']) && !empty($property['BedType']['name'])) {
            if (empty($meta_keyword)) {
                $meta_keyword.= $property['BedType']['name'];
            } else {
                $meta_keyword.= ' & ' . $property['BedType']['name'];
            }
        }
        // Metas Settings
        if (!empty($property['Attachment'][0])) {
            $image_options = array(
                'dimension' => 'medium_thumb',
                'class' => '',
                'alt' => $property['Property']['title'],
                'title' => $property['Property']['title'],
                'type' => 'png'
            );
            $property_image = Router::url('/', true) . getImageUrl('Property', $property['Attachment'][0], $image_options, true);
            Configure::write('meta.view_image', $property_image);
        }
        $meta_description = 'Book ' . $meta_keyword . ' property at ' . $property['Property']['price_per_night'] . ' in ' . (!empty($property['City']['name']) ? $property['City']['name'] : '') . ', ' . $property['Property']['title'];
        Configure::write('meta.description', $meta_description);
        Configure::write('meta.keywords', $meta_keyword);
        Configure::write('meta.property_name', $property['Property']['title']);
        if (isset($this->request->params['named']['order_id'])) {
            $propertyUser = $this->Property->PropertyUser->find('first', array(
                'conditions' => array(
                    'PropertyUser.id = ' => $this->request->params['named']['order_id'],
                ) ,
                'recursive' => -1,
            ));
            $this->set('propertyUser', $propertyUser);
        }
        //Log the property view
        $this->request->data['PropertyUser']['property_id'] = $property['Property']['id'];
        $this->request->data['PropertyUser']['price'] = $property['Property']['price_per_night'];
        $this->request->data['PropertyUser']['property_slug'] = $property['Property']['slug'];
        $this->request->data['PropertyUser']['property_name'] = $property['Property']['title'];
        $this->request->data['PropertyView']['user_id'] = $this->Auth->user('id');
        $this->request->data['PropertyView']['property_id'] = $property['Property']['id'];
        $this->request->data['PropertyUser']['booking_option'] = 'price_per_night';
        $this->request->data['PropertyView']['ip_id'] = $this->Property->PropertyView->toSaveIp();
        $this->Property->PropertyView->create();
        $this->Property->PropertyView->save($this->request->data);
        $this->pageTitle.= ' - ' . $property['Property']['title'];
        $amenities_list = $this->Property->Amenity->find('list', array(
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
        $holiday_list = $this->Property->HolidayType->find('list', array(
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $this->set('amenities_list', $amenities_list);
        $this->set('holiday_list', $holiday_list);
        $this->set('property', $property);
        // social connections list
        if ($this->Auth->user('id') && $this->Auth->user('is_show_facebook_friends') && $this->Auth->user('is_facebook_friends_fetched')) {
            $social_conditions['Property.user_id != '] = $this->Auth->user('id');
            $host_user_id = $this->Property->User->find('list', array(
                'conditions' => array(
                    'User.id' => $property['Property']['user_id'],
                    'User.is_facebook_friends_fetched' => 1
                ) ,
                'fields' => array(
                    'User.id',
                    'User.network_fb_user_id',
                )
            ));
            if (!empty($host_user_id)) {
                $network_level = $this->Property->getFacebookFriendLevel($host_user_id);
                $this->set('network_level', $network_level);
                $userFacebookFriends = $this->Property->getMutualFriends($this->Auth->user('id') , $property['Property']['user_id']);
                if (!empty($userFacebookFriends[$property['Property']['user_id']]) && !empty($userFacebookFriends[$this->Auth->user('id') ])) {
                    $this->set('common_friends', array_intersect($userFacebookFriends[$this->Auth->user('id') ], $userFacebookFriends[$property['Property']['user_id']]));
                }
            }
        }
        if ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched')) {
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.app_id') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            $fb_return_url = Router::url(array(
                'controller' => 'users',
                'action' => 'fb_update',
                'admin' => false
            ) , true);
            $this->Session->write('fb_return_url', $fb_return_url);
            $fb_login_url = $this->facebook->getLoginUrl(array(
                'redirect_uri' => Router::url(array(
                    'controller' => 'users',
                    'action' => 'oauth_facebook',
                    'admin' => false
                ) , true) ,
                'scope' => 'email,offline_access,publish_stream'
            ));
            $this->set('fb_login_url', $fb_login_url);
        }
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->Property->saveiPhoneAppThumb($property['Attachment']);
            $image_options = array(
                'dimension' => 'iphone_big_thumb',
                'class' => '',
                'alt' => $property['Property']['title'],
                'title' => $property['Property']['title'],
                'type' => 'jpg',
                'full_url' => true
            );
            $iphone_big_thumb = getImageUrl('Property', $property['Attachment'][0], $image_options);
            $property['Property']['iphone_big_thumb'] = $iphone_big_thumb;
            $image_options = array(
                'dimension' => 'iphone_small_thumb',
                'class' => '',
                'alt' => $property['Property']['title'],
                'title' => $property['Property']['title'],
                'type' => 'jpg',
                'full_url' => true
            );
            $iphone_small_thumb = getImageUrl('Property', $property['Attachment'][0], $image_options);
            $property['Property']['iphone_small_thumb'] = $iphone_small_thumb;
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $property : $this->viewVars['iphone_response']);
        }
        $chart_data = null;//$this->Property->getBookingChart(null, $property['Property']['id']);
        $this->set('chart_data', $chart_data);
        // For iPhone App code -->
                $this -> render('view2');
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'simple-view') {
            $this->render('simple-view');
        }
    }



    public function add($request = null, $request_id = null)
    {
        //debug($this->request->data);
        $this->layout = 'defaultbnb';
        $this->pageTitle = __l('List your property');
        $this->Property->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        $this->set('is_paypal_enabled', $this->Property->isPaymentGatewayEnabled(ConstPaymentGateways::PayPal));
        if ((!empty($this->request->data['Property']['step1'])) || (!empty($this->request->data['Property']['step2']))) {
           // $this->Property->set($this->request->data);
           // if ($this->Property->validates($this->request->data)) {
              //  $this->set('steps', 3);
       /*     } else {
                $this->set('steps', 2);
            }*/

            $paypal_account = 1;
            if (!empty($this->request->data['UserProfile']['paypal_account'])) {
                $this->loadModel('Payment');
                $rsPayStatus = $this->Payment->getVerifiedStatus($this->request->data['UserProfile']);
                if (strtoupper($rsPayStatus['responseEnvelope.ack']) != 'SUCCESS' || strtoupper($rsPayStatus['accountStatus']) != 'VERIFIED') {
                    $paypal_account = 0;
                    $this->Property->User->UserProfile->validationErrors['paypal_account'] = __l('Enter PayPal verification email and name associated with your PayPal');
                }
            }
            $this->Property->set($this->request->data);
            if ($paypal_account&$this->Property->validates($this->request->data)) {
                $this->request->data['Property']['checkin'] = array(
                    'hour' => '6',
                    'minute' => '00',
                    'meridien' => 'am'
                );
                $this->request->data['Property']['checkout'] = array(
                    'hour' => '9',
                    'minute' => '00',
                    'meridien' => 'am'
                );
                $this->set('steps', 3);
            } else {
                $this->Session->setFlash(__l('Property could not be added. Please, try again') , 'default', null, 'error');
                $this->set('steps', 2);
            }
        } else if (!empty($this->request->data['Property']['step3'])) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $user_profile = $this->Property->User->UserProfile->find('first', array(
                    'conditions' => array(
                        'UserProfile.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'UserProfile.phone',
                        'UserProfile.backup_phone'
                    )
                ));
                $this->request->data['Property']['phone'] = $user_profile['UserProfile']['phone'];
                $this->request->data['Property']['backup_phone'] = $user_profile['UserProfile']['backup_phone'];
                $this->set('steps', 4);
            } else {
                $this->Session->setFlash(__l('Property could not be added. Please, try again') , 'default', null, 'error');
                $this->set('steps', 3);
            }
        } else if (!empty($this->request->data['Property']['step4'])) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $this->set('steps', 5);
            } else {
                $this->Session->setFlash(__l('Property could not be added. Please, try again') , 'default', null, 'error');
                $this->set('steps', 4);
            }
        } else if (!empty($this->request->data['Property']['step5'])) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $this->request->data['Property']['user_id'] = !empty($this->request->data['Property']['user_id']) ? $this->request->data['Property']['user_id'] : $this->Auth->user('id');
                $this->request->data['Property']['is_active'] = 0;
                $this->request->data['Property']['ip_id'] = $this->Property->toSaveIp();
                if (empty($this->request->data['Property']['maximum_nights'])) {
                    $this->request->data['Property']['maximum_nights'] = 0;
                }
                //state and country looking
                if (!empty($this->request->data['City']['name'])) {
                    $this->request->data['Property']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Property->City->findOrSaveAndGetId($this->request->data['City']['name']);
                }
                if (!empty($this->request->data['Property']['country_id'])) {
                    $this->request->data['Property']['country_id'] = $this->Property->Country->findCountryId($this->request->data['Property']['country_id']);
                }
                if (!empty($this->request->data['State']['name'])) {
                    $this->request->data['Property']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Property->State->findOrSaveAndGetId($this->request->data['State']['name']);
                }
                $this->Property->create();
                $this->Property->set($this->request->data);
                $uploaded_photo_count = 0;
                for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                    if (!empty($this->request->data['Attachment'][$i]['filename'])) {
                        $uploaded_photo_count = 1;
                        break;
                    }
                }
                if ($uploaded_photo_count&$this->Property->validates($this->request->data)) {
                    if (!Configure::read('property.listing_fee')) {
                        $this->request->data['Property']['is_paid'] = 1;
                        $this->request->data['Property']['is_active'] = 1;
                        $this->request->data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
                    }
                    // @todo "Language Filter"
                    $user_id = !empty($this->request->data['Property']['user_id']) ? $this->request->data['Property']['user_id'] : $this->Auth->user('id');
                    $userProfile = $this->Property->User->UserProfile->find('first', array(
                        'fields' => array(
                            'UserProfile.language_id'
                        ) ,
                        'conditions' => array(
                            'UserProfile.user_id' => $user_id
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($userProfile['UserProfile']['language_id'])) {
                        $this->request->data['Property']['language_id'] = $userProfile['UserProfile']['language_id'];
                    }
                    $this->Property->save($this->request->data);
                    $property_id = $this->Property->getLastInsertId();
//debug($this->request->data);



//amenities save hard
                    $this->loadModel('AmenitiesProperty');
                    $datos = array();
                        if (!empty($this->request->data['Property']['Amenity'])) {
                            for ($i = 0; $i < count($this->request->data['Property']['Amenity']); $i++) {
                                $datos[$i]['amenity_id'] = $this->request->data['Property']['Amenity'][$i];
                                $datos[$i]['property_id'] = $property_id;
                            }
                                $this->AmenitiesProperty->saveAll($datos);
                        }

//Holidays type save hard
                    $this->loadModel('HolidayTypeProperty');
                    $datosH = array();
                        if (!empty($this->request->data['Property']['HolidayType'])) {
                            for ($i = 0; $i < count($this->request->data['Property']['HolidayType']); $i++) {
                                $datosH[$i]['holiday_type_id'] = $this->request->data['Property']['HolidayType'][$i];
                                $datosH[$i]['property_id'] = $property_id;
                            }
                                $this->HolidayTypeProperty->saveAll($datosH);
                        }



                    if (!empty($this->request->data['UserProfile']['paypal_account'])) {
                        if (empty($this->request->data['UserProfile']['id'])) {
                            $userProfile = $this->Property->User->UserProfile->find('first', array(
                                'conditions' => array(
                                    'UserProfile.user_id' => $this->request->data['Property']['user_id']
                                ) ,
                                'recursive' => -1
                            ));

							if(!empty($userProfile)){
								$this->request->data['UserProfile']['id'] = $userProfile['UserProfile']['id'];
								$_data = $this->request->data['UserProfile'];
							}
							else {
								$this->Property->User->UserProfile->create();
								$_data['paypal_account'] = $this->request->data['UserProfile']['paypal_account'];
								$_data['paypal_first_name'] = $this->request->data['UserProfile']['paypal_first_name'];
								$_data['paypal_last_name'] = $this->request->data['UserProfile']['paypal_last_name'];
								$_data['user_id'] = $this->request->data['Property']['user_id'];
							}
                        }
						$this->Property->User->UserProfile->set($_data);
                        $this->Property->User->UserProfile->save($_data);
                    }
                    // saving in to request property
                    if (!empty($this->request->data['Property']['request_id'])) {
                        $this->Property->PropertiesRequest->create();
                        $request = array();
                        $request['PropertiesRequest']['request_id'] = $this->request->data['Property']['request_id'];
                        $request['PropertiesRequest']['property_id'] = $property_id;
                        $request['PropertiesRequest']['is_active'] = 1;
                        $this->Property->PropertiesRequest->set($request);
                        $this->Property->PropertiesRequest->save($request);
                        $this->Property->__updatePropertyRequest($this->request->data['Property']['request_id'], $property_id);
                    }

                    $this->Property->Attachment->create();
                    // save attachment
                    $attachment['Attachment']['foreign_id'] = $property_id;
                    $attachment['Attachment']['class'] = 'Property';
                    if (empty($_FILES)) { // Flash Upload
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            if (!empty($this->request->data['Attachment'][$i]['filename'])) {
                                $file_id = $this->request->data['Attachment'][$i]['filename'];
                                $this->Property->Attachment->create();
                                $attachment['Attachment']['description'] = $this->request->data['Attachment'][$i]['description'];
                                $this->Property->Attachment->Behaviors->attach('ImageUpload');
                                $this->Property->Attachment->enableUpload(false); //don't trigger upload behavior on save
                                $attachment['Attachment']['mimetype'] = $_SESSION["property_file_info"][$file_id]['type'];
                                $attachment['Attachment']['dir'] = 'Property/' . $property_id;
                                $upload_path = APP . DS . 'media' . DS . 'Property' . DS . $property_id;
                                new Folder($upload_path, true);
                                $file_name = $_SESSION["property_file_info"][$file_id]['filename'];
                                $attachment['Attachment']['filename'] = $file_name;
                                $fp = fopen($upload_path . DS . $file_name, 'w');
                                fwrite($fp, base64_decode($_SESSION["property_file_info"][$file_id]['original']));
                                fclose($fp);
                                //debug($attachment);
                                $this->Property->Attachment->create();
                                $this->Property->Attachment->save($attachment);
                                $this->Property->Attachment->Behaviors->detach('ImageUpload');
                                unset($_SESSION["property_file_info"][$file_id]);
                            }
                        }
                        if (Configure::read('property.listing_fee') && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                            $this->Session->setFlash(__l('Property has been added successfully and it will be list out after paying the listing fee') , 'default', null, 'success');
                            $this->redirect(array(
                                'controller' => 'payments',
                                'action' => 'property_pay_now',
                                $this->Property->id
                            ));
                        } else {
                            $property = $this->Property->find('first', array(
                                'conditions' => array(
                                    'Property.id = ' => $this->Property->id,
                                ) ,
                                'fields' => array(
                                    'Property.id',
                                    'Property.title',
                                    'Property.slug',
                                    'Property.admin_suspend',
                                ) ,
                                'recursive' => -1,
                            ));
                            $mail_template = 'New Property Activated';
                            if (!empty($mail_template)) {
                                $template = $this->EmailTemplate->selectTemplate($mail_template);
                                $emailFindReplace = array(
                                    '##USERNAME##' => $this->Auth->user('username') ,
                                    '##PROPERTY_NAME##' => $property['Property']['title'],
                                    '##PROPERTY_URL##' => Router::url(array(
                                        'controller' => 'joinproperties',
                                        'action' => 'view',
                                        $property['Property']['slug'],
                                        'admin' => false,
                                    ) , true) ,
                                    '##SITE_NAME##' => Configure::read('site.name') ,
                                    '##SITE_LINK##' => Router::url('/', true) ,
                                    '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
                                    '##CONTACT_URL##' => Router::url(array(
                                        'controller' => 'contacts',
                                        'action' => 'add'
                                    ) , true) ,
                                    '##SITE_LOGO##' => Router::url(array(
                                        'controller' => 'img',
                                        'action' => 'logo.png',
                                        'admin' => false
                                    ) , true) ,
                                );
                                $email_message = __l('Your property has been activated');
                                $message = strtr($template['email_content'], $emailFindReplace);
                                $subject = strtr($template['subject'], $emailFindReplace);
                                if (Configure::read('messages.is_send_internal_message')) {
                                    $message_id = $this->Property->Message->sendNotifications($this->Auth->user('id') , $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                                    if (Configure::read('messages.is_send_email_on_new_message')) {
                                        $content['subject'] = $email_message;
                                        $content['message'] = $email_message;
                                        if (!empty($host_email)) {
                                            $this->_sendAlertOnNewMessage($host_email, $content, $message_id, 'New Property Activated');
                                        }
                                    }
                                }
                            }
                            if ($property['Property']['admin_suspend']) {
                                $this->Session->setFlash(__l('Property has been suspended, due to some bad words. Admin will unsuspend your property') , 'default', null, 'error');
                                $this->redirect(array(
                                    'controller' => 'users',
                                    'action' => 'dashboard',
                                    'admin' => false
                                ));
                            } else {
                                if (Configure::read('property.is_auto_approve')) {
                                    $this->Session->setFlash(__l('Property has been listed.') , 'default', null, 'success');
                                    $this->redirect(array(
                                        'controller' => 'joinproperties',
                                        'action' => 'update_social_networking',
                                        'property_id' => $property['Property']['id'],
                                        'admin' => false
                                    ));
                                } else {
                                       if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                                        $this->Session->setFlash(__l('Property has been added but after admin approval it will list out in site') , 'default', null, 'success');
                                        $this->redirect(array(
                                            'controller' => 'properties',
                                            'action' => 'index',
                                            'admin' => true
                                            ));
                                        }
                                   $this->Session->setFlash(__l('Property has been added but after admin approval it will list out in site') , 'default', null, 'success');
                                }
                            }
                        }
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                $upload_photo_count++;
                                $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                $this->request->data['Attachment'][$i]['description'] = $this->request->data['Attachment'][$i]['description'];
                                $this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
                                $this->Property->Attachment->set($this->request->data);
                                if (!$this->Property->validates() |!$this->Property->Attachment->validates()) {
                                    $attachmentValidationError[$i] = $this->Property->Attachment->validationErrors;
                                    $is_form_valid = false;
                                    $this->Session->setFlash(__l('could not be added. Please, try again.') , 'default', null, 'error');
                                }
                            }
                        }
                        if (!$upload_photo_count) {
                            $this->Property->validates();
                            $this->Property->Attachment->validationErrors[0]['filename'] = __l('Required');
                            $is_form_valid = false;
                        }
                        if (!empty($attachmentValidationError)) {
                            foreach($attachmentValidationError as $key => $error) {
                                $this->Property->Attachment->validationErrors[$key]['filename'] = $error;
                            }
                        }
                        if ($is_form_valid) {
                            $this->request->data['foreign_id'] = $property_id;
                            $this->request->data['Attachment']['description'] = 'Property';
                            $this->XAjax->normalupload($this->request->data, false);
                            if (Configure::read('property.is_auto_approve')) {
                                $this->Session->setFlash(__l('Property has been listed.') , 'default', null, 'success');
                                $this->redirect(array(
                                    'controller' => 'joinproperties',
                                    'action' => 'update_social_networking',
                                    'property_id' => $property['Property']['id'],
                                    'admin' => false
                                ));
                            } else {
                                $this->Session->setFlash(__l('Property has been added but after admin approval it will list out in site') , 'default', null, 'success');
                            }
                            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                                $this->redirect(array(
                                    'controller' => 'joinproperties',
                                    'action' => 'index',
                                    'admin' => true
                                ));
                            } else {
                                $this->redirect(array(
                                    'action' => 'index',
                                    'admin' => false
                                ));
                            }
                        }
                    }
                } else {
                    if (empty($uploaded_photo_count)) {
                        $this->Session->setFlash(__l('Property could not be added. Please, upload at least one property image.') , 'default', null, 'error');
                        $this->set('steps', 5);
                    } else {
                        $this->Session->setFlash(__l('Property could not be added. Please, try again.') , 'default', null, 'error');
                        $this->set('steps', 5);
                    }
                }
            } else {
                $this->Session->setFlash(__l('Property could not be added. Please, try again.') , 'default', null, 'error');
                $this->set('steps', 5);
            }
        } else if (!empty($this->request->data['Property']['back_step_1'])) {
            $this->set('steps', 1);
        } else if (!empty($this->request->data['Property']['back_step_2'])) {
            $this->set('steps', 2);
        } else if (!empty($this->request->data['Property']['back_step_3'])) {
            $this->set('steps', 3);
        } else if (!empty($this->request->data['Property']['back_step_4'])) {
            $this->set('steps', 4);
        } else {
            $this->set('steps', 1);
			    $user_id = !empty($this->request->data['Property']['user_id']) ? $this->request->data['Property']['user_id'] : $this->Auth->user('id');
                $userProfile = $this->Property->User->UserProfile->find('first', array(
                    'conditions' => array(
                        'UserProfile.user_id' => $user_id
                    ) ,
                    'recursive' => -1
                ));
                $this->set('userProfile', $userProfile);
        }
        $currency_code = Configure::read('site.currency_code');
        $collections = $this->Property->Collection->find('list', array(
            'order' => array(
                'Collection.title' => 'ASC'
            )
        ));
        $users = $this->Property->User->find('list');
        $tmpCancellationPolicies = $this->Property->CancellationPolicy->find('all', array(
            'conditions' => array(
                'CancellationPolicy.is_active' => 1
            ) ,
            'order' => array(
                'CancellationPolicy.name' => 'ASC'
            ) ,
            'recursive' => -1
        ));
        foreach($tmpCancellationPolicies as $cancellationPolicy) {
            if ($cancellationPolicy['CancellationPolicy']['percentage'] == '0.00') {
                $percentage = 'No';
            } elseif ($cancellationPolicy['CancellationPolicy']['percentage'] == '100.00') {
                $percentage = 'Full';
            } else {
                $percentage = $cancellationPolicy['CancellationPolicy']['percentage'] . '%';
            }
            $cancellationPolicies[$cancellationPolicy['CancellationPolicy']['id']] = $cancellationPolicy['CancellationPolicy']['name'] . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees') , $percentage, $cancellationPolicy['CancellationPolicy']['days']);
        }
        $amenities = $this->Property->Amenity->find('list', array(
			'conditions' => array(
                'Amenity.is_active' => 1
            ) ,
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
        $propertyTypes = $this->Property->PropertyType->find('list', array(
          'conditions' => array(
                'PropertyType.is_active' => 1,
                'PropertyType.is_property' => 1
            ) ,
            'order' => array(
                'PropertyType.name' => 'ASC'
            )
        ));
        $roomTypes = $this->Property->RoomType->find('list', array(
          'conditions' => array(
                'RoomType.is_active' => 1
            ) ,
            'order' => array(
                'RoomType.name' => 'ASC'
            )
        ));
        $bedTypes = $this->Property->BedType->find('list', array(
            'conditions' => array(
                'BedType.is_active' => 1
            ) ,
            'order' => array(
                'BedType.name' => 'ASC'
            )
        ));
        $holidayTypes = $this->Property->HolidayType->find('list', array(
           'conditions' => array(
                'HolidayType.is_active' => 1
            ) ,
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $cities = $this->Property->City->find('list', array(
			'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'order' => array(
                'City.name' => 'ASC'
            )
        ));
        $states = $this->Property->State->find('list', array(
			'conditions' => array(
                'State.is_approved' => 1
            ) ,
            'order' => array(
                'State.name' => 'ASC'
            )
        ));
        $countries = $this->Property->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $accomadation = array();
        $bathrroom = array();
        $minNights = array();
        $maxNights = array();
        for ($i = 1; $i <= 20; $i++) {
            $bathrroom[$i] = $i;
        }
        for ($i = 1; $i <= Configure::read('property.minimum_nights'); $i++) {
            $minNights[$i] = $i;
        }
        for ($i = 1; $i <= Configure::read('property.maximum_nights'); $i++) {
            $maxNights[$i] = $i;
        }
        $moreStreetActions = $this->Property->moreStreetActions;
        $moreMeasureActions = $this->Property->moreMeasureActions;
        $this->set(compact('moreStreetActions', 'moreMeasureActions'));
        $room_keys = array_keys($roomTypes);
        $bed_keys = array_keys($bedTypes);
        $this->set('room_default', $room_keys[0]);
        $this->set('bed_default', $bed_keys[0]);
        $this->set('accomadation', $bathrroom);
        $this->set('minNights', $minNights);
        $this->set('maxNights', $maxNights);
        $this->set('bathrroom', $bathrroom);
        $this->set(compact('collections', 'users', 'cancellationPolicies', 'currencies', 'amenities', 'propertyTypes', 'roomTypes', 'bedTypes', 'holidayTypes', 'cities', 'states', 'countries'));
        if (!empty($request) && !empty($request_id)) {
            $this->request->data['Property']['request_id'] = $request_id;
            $request = $this->Property->PropertiesRequest->Request->find('first', array(
                'conditions' => array(
                    'Request.id' => $this->request->data['Property']['request_id'],
                    'Request.user_id !=' => $this->Auth->user('id') ,
                    'Request.checkin >= ' => date('Y-m-d')
                ) ,
                'fields' => array(
                    'Request.latitude',
                    'Request.longitude',
                    'Request.title'
                ) ,
                'recursive' => -1
            ));
            if (empty($request)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->request->data['Property']['request_latitude'] = $request['Request']['latitude'];
            $this->request->data['Property']['request_longitude'] = $request['Request']['longitude'];
            $this->set('request_name', $request['Request']['title']);
        }
    }





    public function flashupload()
    {
        $this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
        $this->XAjax->previewImage();
    }
	
    public function thumbnail()
    {
        $file_id = $this->request->params['pass'][1]; // show preview uploaded product image, session unique id
        $this->XAjax->thumbnail($file_id);
    }
    /*
    After Adding properties, it is posted in Site Facebook and Site Twitter account
    If user logged using Fb_connect or twitter account, it will be posted on their facebook and twitter account respectively
    */
    function update_social_networking($property_id = null)
    {
        if (!empty($this->params['named']['property_id'])) {
            $property_id = $this->params['named']['property_id'];
        } else {
            $uploaded_data = $this->Session->read('flashupload_data');
            //$property_id = $uploaded_data['Properties']['Attachment']['foreign_id'];

        }
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id = ' => $property_id,
            ) ,
            'fields' => array(
                'Property.id',
                'Property.created',
                'Property.modified',
                'Property.user_id',
                'Property.cancellation_policy_id',
                'Property.property_type_id',
                'Property.room_type_id',
                'Property.bed_type_id',
                'Property.privacy_id',
                'Property.city_id',
                'Property.state_id',
                'Property.title',
                'Property.slug',
                'Property.description',
                'Property.street_view',
                'Property.accommodates',
                'Property.address',
                'Property.unit',
                'Property.phone',
                'Property.price_per_night',
                'Property.price_per_week',
                'Property.price_per_month',
                'Property.additional_guest',
                'Property.additional_guest_price',
                'Property.backup_phone',
                'Property.house_rules',
                'Property.house_manual',
                'Property.size',
                'Property.measurement',
                'Property.minimum_nights',
                'Property.maximum_nights',
                'Property.checkin',
                'Property.checkout',
                'Property.zoom_level',
                'Property.latitude',
                'Property.longitude',
                'Property.rate',
                'Property.bed_rooms',
                'Property.beds',
                'Property.bath_rooms',
                'Property.detected_suspicious_words',
                'Property.is_pets',
                'Property.is_negotiable',
                'Property.is_approved',
                'Property.is_featured',
                'Property.sales_pending_count',
                'Property.sales_pipeline_count',
                'Property.is_verified',
                'Property.property_user_count',
                'Property.positive_feedback_count',
                'Property.property_feedback_count',
                'Property.property_user_success_count',
                'Property.property_user_failure_count',
                'Property.property_view_count',
                'Property.is_active',
                'Property.video_url',
                'Property.admin_suspend',
                'Property.is_system_flagged',
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
            'recursive' => 2
        ));

        $user = $this->Property->User->find('first', array(
            'conditions' => array(
                'User.id' => $property['Property']['user_id']
            ) ,
            'recursive' => -1
        ));
        $url = Router::url(array(
            'controller' => 'properties',
            'action' => 'view',
            'admin' => false,
            $property['Property']['slug'],
        ) , true);
        // Property willn't be posted if it is autoflagged and suspend
        if (!$property['Property']['is_system_flagged']) {
            // Post on user facebook
            if (Configure::read('social_networking.post_property_on_user_facebook')) {
                if ($user['User']['fb_user_id'] > 0) {
                    $fb_message = $user['User']['username'] . ' ' . __l('listed a new property "') . '' . $property['Property']['title'] . __l('" in ') . Configure::read('site.name');
                    $getFBReturn = $this->postOnFacebook($property, $fb_message, 0);
                }
            }
// post on user twitter
            if (Configure::read('social_networking.post_property_on_user_twitter')) {
                if (!empty($user['User']['twitter_access_token']) && !empty($user['User']['twitter_access_key'])) {
                    $message = $user['User']['username'] . ' ' . __l('listed a new property "') . '' . $property['Property']['title'] . __l('" in ') . Configure::read('site.name');
                    $message .=' '.$url;
                    $xml = $this->OauthConsumer->post('Twitter', $user['User']['twitter_access_token'], $user['User']['twitter_access_key'], 'https://twitter.com/statuses/update.xml', array(
                        'status' => $message
                    ));
                }
            }
            if (Configure::read('property.post_property_on_facebook')) { // post on site facebook
                $fb_message = $user['User']['username'] . ' ' . __l('listed a new property "') . '' . $property['Property']['title'] . __l('" in ') . Configure::read('site.name');
                $getFBReturn = $this->postOnFacebook($property, $fb_message, 1);
            }
            /*
            if (Configure::read('property.post_property_on_twitter')) { // post on site twitter
                $message = $user['User']['username'] . ' ' . __l('listed a new property "') . '' . $property['Property']['title'] . __l('" in ') . Configure::read('site.name');
                $message .=' '.$url;
                $xml = $this->OauthConsumer->post('Twitter', Configure::read('twitter.site_user_access_token') , Configure::read('twitter.site_user_access_key') , 'https://twitter.com/statuses/update.xml', array(
                    'status' => $message
                ));
            }
            */
        }
        if (!empty($getFBReturn) && ($getFBReturn == '2')) {
            $this->Session->setFlash($property['Property']['title'] . ' ' . __l('has been listed. But unable to post it on facebook.') , 'default', null, 'success');
        } else {
            $this->Session->setFlash($property['Property']['title'] . ' ' . __l('has been listed.') , 'default', null, 'success');
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'properties',
                'action' => 'index',
                'admin' => 'true',
            ));
        }
        $this->redirect(array(
            'controller' => 'properties',
            'action' => 'view',
            $property['Property']['slug'],
            'admin' => false
        ));
    }








    // Posting Property on Facebook
    function postOnFacebook($property = null, $message = null, $admin = null)
    {
        if (!empty($property)) {
            $slug = $property['Property']['slug'];
            $image_options = array(
                'dimension' => 'small_big_thumb',
                'class' => '',
                'alt' => $property['Property']['title'],
                'title' => $property['Property']['title'],
                'type' => 'jpg'
            );
            if ($admin) {
                //$facebook_dest_user_id = Configure::read('facebook.fb_user_id');	// Site USER ID
                $facebook_dest_user_id = Configure::read('facebook.page_id'); // Site Page ID
                $facebook_dest_access_token = Configure::read('facebook.fb_access_token');
            } else {
                $facebook_dest_user_id = $property['Property']['fb_user_id'];
                $facebook_dest_access_token = $property['Property']['fb_access_token'];
            }
            App::import('Vendor', 'facebook/facebook');
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.api_key') ,
                'secret' => Configure::read('facebook.secrect_key') ,
                'cookie' => true
            ));
            if (empty($message)) {
                $message = $property['Property']['title'];
            }
            $image_url = Router::url('/', true) . getImageUrl('Property', $property['Attachment']['0'], $image_options);
            $image_link = Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                'admin' => false,
                $slug
            ) , true);
            try {
                $getPostCheck = $this->facebook->api('/' . $facebook_dest_user_id . '/feed', 'POST', array(
                    'access_token' => $facebook_dest_access_token,
                    'message' => $message,
                    'picture' => $image_url,
                    'icon' => $image_url,
                    'link' => $image_link,
                    'description' => $property['Property']['description']
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
        $this->pageTitle = __l('Edit Property');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            //state and country looking
            if (!empty($this->request->data['City']['name'])) {
                $this->request->data['Property']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Property->City->findOrSaveAndGetId($this->request->data['City']['name']);
            }
            if (!empty($this->request->data['Property']['country_id'])) {
                $this->request->data['Property']['country_id'] = $this->Property->Country->findCountryId($this->request->data['Property']['country_id']);
            }
            if (!empty($this->request->data['State']['name'])) {
                $this->request->data['Property']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Property->State->findOrSaveAndGetId($this->request->data['State']['name']);
            }
            $uploaded_photo_count = 0;
            for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                if ((!empty($this->request->data['Attachment'][$i]['id']) && empty($this->request->data['Attachment'][$i]['checked_id'])) || (!empty($this->request->data['Attachment'][$i]['filename']))) {
                    $uploaded_photo_count = 1;
                    break;
                }
            }
            if ($uploaded_photo_count&$this->Property->validates($this->request->data)) {
                if ($this->Property->save($this->request->data)) {
                    $property_id = $this->request->data['Property']['id'];
                    $this->Property->Attachment->create();
                    // save attachment
                    $attachment['Attachment']['foreign_id'] = $property_id;
                    $attachment['Attachment']['class'] = 'Property';
                    if (empty($_FILES)) { // Flash Upload
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            $upload_photo = 0;
                            if (!empty($this->request->data['Attachment'][$i]['checked_id']) && !empty($this->request->data['Attachment'][$i]['id'])) {
                                $this->Property->Attachment->delete($this->request->data['Attachment'][$i]['id']);
                                $upload_photo = 1;
                            }
                            if (!empty($this->request->data['Attachment'][$i]['filename'])) {
                                $file_id = $this->request->data['Attachment'][$i]['filename'];
                                $this->Property->Attachment->create();
                                $attachment['Attachment']['description'] = $this->request->data['Attachment'][$i]['description'];
                                $this->Property->Attachment->Behaviors->attach('ImageUpload');
                                $this->Property->Attachment->enableUpload(false); //don't trigger upload behavior on save
                                $attachment['Attachment']['mimetype'] = $_SESSION["property_file_info"][$file_id]['type'];
                                $attachment['Attachment']['dir'] = 'Property/' . $property_id;
                                $upload_path = APP . DS . 'media' . DS . 'Property' . DS . $property_id;
                                new Folder($upload_path, true);
                                $file_name = $_SESSION["property_file_info"][$file_id]['filename'];
                                $attachment['Attachment']['filename'] = $file_name;
                                $fp = fopen($upload_path . DS . $file_name, 'w');
                                fwrite($fp, base64_decode($_SESSION["property_file_info"][$file_id]['original']));
                                fclose($fp);
                                $this->Property->Attachment->create();
                                $this->Property->Attachment->save($attachment);
                                $this->Property->Attachment->Behaviors->detach('ImageUpload');
                                unset($_SESSION["property_file_info"][$file_id]);
                            } elseif (empty($this->request->data['Attachment'][$i]['checked_id']) && !empty($this->request->data['Attachment'][$i]['id'])) {
                                $_attachment['Attachment']['foreign_id'] = $property_id;
                                $_attachment['Attachment']['id'] = $this->request->data['Attachment'][$i]['id'];
                                $_attachment['Attachment']['id'] = $this->request->data['Attachment'][$i]['id'];
                                $_attachment['Attachment']['description'] = $this->request->data['Attachment'][$i]['description'];
                                $_attachment['Attachment']['class'] = 'Property';
                                $this->Property->Attachment->save($_attachment);
                            }
                        }
                        $this->Session->setFlash(__l('Property has been updated') , 'default', null, 'success');
                        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                            $this->redirect(array(
                                'action' => 'index',
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'properties',
                                'action' => 'index',
                                'type' => 'myproperties'
                            ));
                        }
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        if (!empty($this->request->data['Attachment'])) {
                            for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                                if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                    $upload_photo_count++;
                                    $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                    $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                    $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                    $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                    $this->request->data['Attachment'][$i]['description'] = $this->request->data['Attachment'][$i]['description'];
                                    $this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
                                    $this->Property->Attachment->set($this->request->data);
                                    if (!$this->Property->validates() |!$this->Property->Attachment->validates()) {
                                        $attachmentValidationError[$i] = $this->Property->Attachment->validationErrors;
                                        $is_form_valid = false;
                                        $this->Session->setFlash(__l('Property could not be added. Please, try again.') , 'default', null, 'error');
                                    }
                                }
                            }
                        }
                        if (!empty($attachmentValidationError)) {
                            foreach($attachmentValidationError as $key => $error) {
                                $this->Property->Attachment->validationErrors[$key]['filename'] = $error;
                            }
                        }
                        if ($is_form_valid) {
                            $this->request->data['foreign_id'] = $property_id;
                            $this->request->data['Attachment']['description'] = 'Property';
                            $this->XAjax->normalupload($this->request->data, false);
                            $this->Session->setFlash(__l('Property has been updated') , 'default', null, 'success');
                            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                                $this->redirect(array(
                                    'action' => 'index',
                                ));
                            } else {
                                $this->redirect(array(
                                    'controller' => 'properties',
                                    'action' => 'index',
                                    'type' => 'myproperties'
                                ));
                            }
                        }
                    }
                } else {
                    $this->Session->setFlash(__l('Property could not be updated. Please, try again.') , 'default', null, 'error');
                }
            } else {
                if (empty($uploaded_photo_count)) {
                    $this->Session->setFlash(__l('Property could not be updated. Please, upload at least one property image.') , 'default', null, 'error');
                } else {
                    $this->Session->setFlash(__l('Property could not be updated. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->request->data = $this->Property->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Property']['title'];
        $collections = $this->Property->Collection->find('list', array(
            'order' => array(
                'Collection.title' => 'ASC'
            )
        ));
        $users = $this->Property->User->find('list');
        $tmpCancellationPolicies = $this->Property->CancellationPolicy->find('all', array(
            'conditions' => array(
                'CancellationPolicy.is_active' => 1
            ) ,
            'order' => array(
                'CancellationPolicy.name' => 'ASC'
            ) ,
            'recursive' => -1
        ));
        foreach($tmpCancellationPolicies as $cancellationPolicy) {
            if ($cancellationPolicy['CancellationPolicy']['percentage'] == '0.00') {
                $percentage = 'No';
            } elseif ($cancellationPolicy['CancellationPolicy']['percentage'] == '100.00') {
                $percentage = 'Full';
            } else {
                $percentage = $cancellationPolicy['CancellationPolicy']['percentage'] . '%';
            }
            $cancellationPolicies[$cancellationPolicy['CancellationPolicy']['id']] = $cancellationPolicy['CancellationPolicy']['name'] . ':' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees') , $percentage, $cancellationPolicy['CancellationPolicy']['days']);
        }
        $amenities = $this->Property->Amenity->find('list', array(
			'conditions' => array(
                'Amenity.is_active' => 1
            ) ,
            'order' => array(
                'Amenity.name' => 'ASC'
            )
        ));
        $propertyTypes = $this->Property->PropertyType->find('list', array(
          'conditions' => array(
                'PropertyType.is_active' => 1
            ) ,
            'order' => array(
                'PropertyType.name' => 'ASC'
            )
        ));
        $roomTypes = $this->Property->RoomType->find('list', array(
          'conditions' => array(
                'RoomType.is_active' => 1
            ) ,
            'order' => array(
                'RoomType.name' => 'ASC'
            )
        ));
        $bedTypes = $this->Property->BedType->find('list', array(
            'conditions' => array(
                'BedType.is_active' => 1
            ) ,
            'order' => array(
                'BedType.name' => 'ASC'
            )
        ));
        $holidayTypes = $this->Property->HolidayType->find('list', array(
           'conditions' => array(
                'HolidayType.is_active' => 1
            ) ,
            'order' => array(
                'HolidayType.name' => 'ASC'
            )
        ));
        $cities = $this->Property->City->find('list', array(
			'conditions' => array(
                'City.is_approved' => 1
            ) ,
            'order' => array(
                'City.name' => 'ASC'
            )
        ));
        $states = $this->Property->State->find('list', array(
			'conditions' => array(
                'State.is_approved' => 1
            ) ,
            'order' => array(
                'State.name' => 'ASC'
            )
        ));
        $countries = $this->Property->Country->find('list', array(
            'fields' => array(
                'Country.iso2',
                'Country.name'
            ) ,
            'order' => array(
                'Country.name' => 'ASC'
            )
        ));
        $accomadation = array();
        $bathrroom = array();
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
        for ($i = 1; $i <= 20; $i++) {
            $accomadation[$i] = $i;
        }
        for ($i = 1; $i <= 20; $i++) {
            $bathrroom[$i] = $i;
        }
        $minNights = array();
        $maxNights = array();
        for ($i = 1; $i <= Configure::read('property.minimum_nights'); $i++) {
            $minNights[$i] = $i;
        }
        for ($i = 1; $i <= Configure::read('property.maximum_nights'); $i++) {
            $maxNights[$i] = $i;
        }
        $this->set('minNights', $minNights);
        $this->set('maxNights', $maxNights);
        $moreStreetActions = $this->Property->moreStreetActions;
        $moreMeasureActions = $this->Property->moreMeasureActions;
        $this->set(compact('moreStreetActions', 'moreMeasureActions'));
        $this->set('accomadation', $accomadation);
        $this->set('bathrroom', $bathrroom);
        $this->set('checkin', $checkin);
        $this->set(compact('collections', 'users', 'cancellationPolicies', 'currencies', 'amenities', 'propertyTypes', 'roomTypes', 'bedTypes', 'holidayTypes', 'cities', 'states', 'countries'));
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Property->delete($id)) {
            $this->Session->setFlash(__l('Property deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function update_view_count()
    {
        if (!empty($_POST['ids'])) {
            $ids = explode(',', $_POST['ids']);
            $properties = $this->Property->find('all', array(
                'conditions' => array(
                    'Property.id' => $ids
                ) ,
                'fields' => array(
                    'Property.id',
                    'Property.property_view_count'
                ) ,
                'recursive' => -1
            ));
            foreach($properties as $property) {
                $json_arr[$property['Property']['id']] = $property['Property']['property_view_count'];
            }
            $this->view = 'Json';
            $this->set('json', $json_arr);
        }
    }
    function admin_manage_collections()
    {
        $this->pageTitle = __l('Manage Collections');
        if (isset($this->request->data)) {
            $properties_data = $this->request->data;
            unset($properties_data['Property']['r']);
            unset($properties_data['Property']['more_action_id']);
            $property_list = array();
            foreach($properties_data['Property'] as $key => $property) {
                if ($property['id'] == 1) {
                    $property_list[] = $key;
                }
            }
            $properties = $this->Property->find('all', array(
                'conditions' => array(
                    'Property.id' => $property_list,
                ) ,
                'order' => array(
                    'Property.id' => 'desc'
                ) ,
                'recursive' => -1
            ));
            $this->set('properties', $properties);
            $this->set('property_list', implode(',', $property_list));
            $collections = $this->Property->Collection->find('list', array(
				'conditions' => array(
					'Collection.is_active' => 1
				) ,
				'recursive' => -1
			));
            $this->set(compact('collections'));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $conditions = array();
        $this->_redirectPOST2Named(array(
            'q',
            'username',
            'property_type_id'
        ));
        $this->pageTitle = __l('Properties');
        $this->set('active_properties', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_active = ' => 1,
                'Property.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('inactive_properties', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_active' => 0
            ) ,
            'recursive' => -1
        )));
        $this->set('suspended_properties', $this->Property->find('count', array(
            'conditions' => array(
                'Property.admin_suspend = ' => 1,
            ) ,
            'recursive' => -1
        )));
        $this->set('system_flagged', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_system_flagged = ' => 1,
                'Property.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('user_flagged', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_user_flagged = ' => 1,
                'Property.admin_suspend = ' => 0,
            ) ,
            'recursive' => -1
        )));
        $this->set('featured', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_featured = ' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('home', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_show_in_home_page = ' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('verified', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_verified' => ConstVerification::Verified
            ) ,
            'recursive' => -1
        )));
        $this->set('waiting_for_verification', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_verified' => ConstVerification::WaitingForVerification
            ) ,
            'recursive' => -1
        )));
        $this->set('waiting_for_approval', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_approved' => 0
            ) ,
            'recursive' => -1
        )));
        $this->set('imported_from_airbnb_count', $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_imported_from_airbnb' => 1
            ) ,
            'recursive' => -1
        )));
        $this->set('total_properties', $this->Property->find('count', array(
            'recursive' => -1
        )));
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') {
            $conditions['Property.is_user_flagged'] = 1;
			$conditions['Property.admin_suspend'] = 0;
            $this->pageTitle.= __l(' - User Flagged');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Property.created) <= '] = 0;
            $this->pageTitle.= __l(' - today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Property.created) <= '] = 7;
            $this->pageTitle.= __l(' - in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Property.created) <= '] = 30;
            $this->pageTitle.= __l(' - in this month');
        }
        if (isset($this->request->params['named']['property_type_id'])) {
            $this->request->data['Property']['property_type_id'] = $this->request->params['named']['property_type_id'];
            $conditions['Property.property_type_id'] = $this->request->params['named']['property_type_id'];
            // Get the Property Category name
            $category_name = $this->Property->PropertyType->find('first', array(
                'conditions' => array(
                    'PropertyType.id' => $this->request->params['named']['property_type_id']
                ) ,
                'fields' => array(
                    'PropertyType.name',
                ) ,
                'recursive' => -1
            ));
            $this->pageTitle.= __l(' - PropertyType - ') . $category_name['PropertyType']['name'];
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
            $conditions[] = array(
                'OR' => array(
                    array(
                        'Property.title LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'User.username LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Property.description LIKE ' => '%' . $this->request->params['named']['q'] . '%'
                    )
                )
            );
            $this->request->data['Property']['q'] = $this->request->params['named']['q'];
        }
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Property']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Property']['filter_id'])) {
            if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Approved) {
                $conditions['Property.is_approved'] = 1;
                $this->pageTitle.= __l(' - Approved ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Disapproved) {
                $conditions['Property.is_approved'] = 0;
                $this->pageTitle.= __l(' - Waiting for Approval ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Active) {
                $conditions['Property.is_active'] = 1;
                $conditions['Property.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Enabled ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['Property.is_active'] = 0;
                $this->pageTitle.= __l(' - Disabled ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['Property.admin_suspend'] = 1;
                $this->pageTitle.= __l(' - Suspended ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['Property.is_system_flagged'] = 1;
                $conditions['Property.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - Flagged ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::UserFlagged) {
                $conditions['Property.property_flag_count !='] = 0;
                $conditions['Property.admin_suspend'] = 0;
                $this->pageTitle.= __l(' - User Flagged ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Featured) {
                $conditions['Property.is_featured'] = 1;
                $this->pageTitle.= __l(' - Featured ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::HomePage) {
                $conditions['Property.is_show_in_home_page'] = 1;
                $this->pageTitle.= __l(' - HomePage ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Verified) {
                $conditions['Property.is_verified'] = ConstVerification::Verified;
                $this->pageTitle.= __l(' - Verified ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::WaitingForVerification) {
                $conditions['Property.is_verified'] = ConstVerification::WaitingForVerification;
                $this->pageTitle.= __l(' - Waiting for Verification ');
            } else if ($this->request->data['Property']['filter_id'] == ConstMoreAction::Imported) {
                $conditions['Property.is_imported_from_airbnb'] = 1;
                $this->pageTitle.= __l(' - Imported from AirBnB ');
            }
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'listing_fee') {
            $conditions['Property.is_active'] = 1;
            $this->pageTitle.= __l(' - Listing fee ');
        } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'verify_fee') {
            $conditions['Property.is_verified'] = 1;
            $this->pageTitle.= __l(' - Verified ');
        }
        $this->Property->recursive = 1;
        $this->paginate = array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'User',
				'PropertyFlag',
                'Attachment',
                    'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host',
                        )
                    ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'Country' => array(
                    'fields' => array(
                        'Country.name',
                        'Country.iso2'
                    )
                ) ,
            ) ,
            'order' => array(
                'Property.id' => 'desc'
            )
        );
        $property_types = $this->Property->PropertyType->find('list', array(
            'conditions' => array(
                'PropertyType.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        $this->set('properties', $this->paginate());
        $moreActions = $this->Property->moreActionpropertys;
        $users = $this->Property->User->find('list');
        $this->set(compact('moreActions', 'property_types', 'users'));
    }
    public function cluster_data()
    {
        $conditions = array();
        $conditions['Property.is_paid'] = 1;
        $conditions['Property.is_active'] = 1;
        $conditions['Property.is_approved'] = 1;
        $conditions['Property.admin_suspend'] = 0;
        $property_count = $this->Property->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1,
        ));
        $results['Properties'] = $this->Property->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'Property.id',
                'Property.latitude',
                'Property.longitude',
            ) ,
            'recursive' => -1,
        ));
        $results['Properties']['Count'] = $property_count;
        $conditions1['Request.is_active'] = 1;
        $conditions1['Request.is_approved'] = 1;
        $conditions1['Request.admin_suspend'] = 0;
        $conditions1['Request.checkin >='] = date('Y-m-d');
        $request_count = $this->Request->find('count', array(
            'conditions' => $conditions1,
            'recursive' => -1,
        ));
        $results['Requests'] = $this->Request->find('all', array(
            'conditions' => $conditions1,
            'fields' => array(
                'Request.id',
                'Request.latitude',
                'Request.longitude',
            ) ,
            'recursive' => -1,
        ));
        $results['Requests']['Count'] = $request_count;
        $this->view = 'Json';
        $this->set('json', $results);
    }
    public function map()
    {
        $this->pageTitle = __l('Map');
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
        if ($this->Property->delete($id)) {
            $this->Session->setFlash(__l('Property deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function property_calendar($year = null, $month = null, $property_id)
    {
        $data = array();
        if ($year == '' || $month == '') { // just use current yeear & month
            $year = date('Y');
            $monthInNumber = $month = date('m');
        }
        $flag = 0;
        $month_list = array(
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july',
            'august',
            'september',
            'october',
            'november',
            'december'
        );
        for ($i = 0; $i < 12; $i++) {
            if (strtolower($month) == $month_list[$i]) {
                if (intval($year) != 0) {
                    $flag = 1;
                    $monthInNumber = $i+1;
                    break;
                }
            }
        }
        if ($flag == 0) {
            $year = date('Y');
            $month = date('F');
            $monthInNumber = date('m');
        }
        $this->set('year', $year);
        $this->set('month', $month);
        $conditions = array();
        $conditions['Property.id'] = $property_id;
        $data = $this->Property->getCalendarData($year, $monthInNumber, $property_id);
        $this->set('data', $data);
    }
    public function manage_property()
    {
        $r = $this->request->data['Property']['r'];
        if (!empty($this->request->data['Property']['request_id']) && !empty($this->request->data['Property']['property'])) {
            if ($request_property_id = $this->Property->__updatePropertyRequest($this->request->data['Property']['request_id'], $this->request->data['Property']['property'])) {
                $this->Session->setFlash(__l('Property mapped with request.') , 'default', null, 'success');
                $request = $this->Property->PropertiesRequest->Request->find('first', array(
                    'conditions' => array(
                        'Request.id' => $this->request->data['Property']['request_id'],
                    ) ,
                    'recursive' => -1
                ));
                $property = $this->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $this->request->data['Property']['property'],
                    ) ,
                    'recursive' => -1
                ));
				$_data = array();
				$_data['PropertyUser']['user_id'] = $request['Request']['user_id'];
				$_data['PropertyUser']['checkin'] = $request['Request']['checkin'];
				$_data['PropertyUser']['checkout'] = $request['Request']['checkout'];
				$_data['PropertyUser']['property_id'] = $this->request->data['Property']['property'];
				$_data['PropertyUser']['property_user_status_id'] = ConstPropertyUserStatus::PaymentPending;
				$_data['PropertyUser']['owner_user_id'] = $this->Auth->user('id');
				$days = getCheckinCheckoutDiff($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']));
				$_data['PropertyUser']['price'] = $property['Property']['price_per_night']*$days;
				$_data['PropertyUser']['top_code'] = $this->_uuid();
				$_data['PropertyUser']['bottum_code'] = $this->_unum();
				$_data['PropertyUser']['security_deposit'] = $property['Property']['security_deposit'];
				$_data['PropertyUser']['price'] = $this->Property->checkCustomPrice($request['Request']['checkin'], getCheckoutDate($request['Request']['checkout']) , $this->request->data['Property']['property'], $request['Request']['accommodates']);
				$_data['PropertyUser']['guests'] = $request['Request']['accommodates'];
				$_data['PropertyUser']['original_price'] = $_data['PropertyUser']['price'];
				$_data['PropertyUser']['traveler_service_amount'] = ($_data['PropertyUser']['price']) *(Configure::read('property.booking_service_fee') /100);
				$hosting_fee = ($_data['PropertyUser']['price']) *(Configure::read('property.host_commission_amount') /100);
				$_data['PropertyUser']['host_service_amount'] = $hosting_fee;
				$_data['PropertyUser']['is_negotiation_requested'] = ConstNegotiationStatus::NegotiationRequested;
				$this->Property->PropertyUser->save($_data, false);
				$order_id = $this->Property->PropertyUser->getLastInsertId();
				$this->Property->PropertiesRequest->updateAll(array(
					'PropertiesRequest.order_id' => $order_id
				) , array(
					'PropertiesRequest.id' => $request_property_id
				));
				$subject = __l('Negotiation for request - ') . $request['Request']['title'];
				$message = $this->Auth->user('username') . __l(' is giving negotiation for this request -  ') . $request['Request']['title'];
				$message_id = $this->Property->PropertyUser->Message->sendNotifications($this->Auth->user('id') , $subject, $message, $order_id, $is_review = 0, $this->request->data['Property']['property'], ConstPropertyUserStatus::RequestNegotiation);
				$this->redirect(array(
					'controller' => 'messages',
					'action' => 'activities',
					'order_id' => $order_id,
				));
            }
            $this->Session->setFlash(__l('Selected property already mapped with this request.') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash(__l('Couldn\'t map to request') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'requests',
                'action' => 'index'
            ));
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
                    $this->Session->setFlash(__l('Checked records has been disabled') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    $this->{$this->modelClass}->updateAll(array(
                        $this->modelClass . '.is_active' => 1
                    ) , array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked records has been enabled') , 'default', null, 'success');
                } elseif ($actionid == ConstMoreAction::Delete) {
                    $this->{$this->modelClass}->deleteAll(array(
                        $this->modelClass . '.id' => $selectedIds
                    ));
                    $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    public function home()
    {
        $limit = Configure::read('properties.max_limit_to_home_slider');
        $order = 'rand()';
        $properties = $this->Property->find('all', array(
            'conditions' => array(
                'Property.is_active' => 1,
                'Property.is_show_in_home_page' => 1,
                'Property.is_paid' => 1,
                'Property.is_approved' => 1,
				'Property.admin_suspend' => 0,
            ) ,
            'contain' => array(
                'User',
                'Attachment',
                'Country' => array(
                    'fields' => array(
                        'Country.id',
                        'Country.iso2',
                        'Country.name',
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
            ) ,
            'limit' => $limit,
            'order' => $order,
            'recursive' => 2
        ));
        $this->set('properties', $properties);
    }
    public function my_properties()
    {
        $this->pageTitle = __l('Properties');
        $conditions = array();
        if (!empty($this->_prefixId) && $is_city) {
            if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user') {
                $conditions['Property.city_id'] = $this->_prefixId;
            }
        }
        $order = array(
            'Property.id' => 'desc'
        );
        // its called from property_users index
        $conditions['Property.user_id'] = $this->Auth->user('id');
        $properties = $this->Property->find('all', array(
            'conditions' => array(
                $conditions
            ) ,
            'contain' => array(
                'Attachment',
            ) ,
            'fields' => array(
                'Property.id',
                'Property.created',
                'Property.modified',
                'Property.user_id',
                'Property.title',
                'Property.slug',
                'Property.description',
                'Property.unit',
                'Property.price_per_night',
                'Property.price_per_week',
                'Property.price_per_month',
                'Property.is_active',
                'Property.is_paid',
                'Property.is_verified',
            ) ,
            'order' => $order,
            'recursive' => 0
        ));
        $this->set('properties', $properties);
        $this->render('lst_my_properties');
    }
    public function update_price()
    {
        $price = 0;
        switch ($_POST['type']) {
            case 'night':
                $price = $this->Property->checkCustomPrice($_POST['checkin'], $_POST['checkout'], $_POST['property_id'], $_POST['guest'], true);
                break;

            case 'week':
                $price = $this->Property->checkCustomWeekPrice($_POST['checkin'], $_POST['checkout'], $_POST['property_id'], $_POST['guest'], true);
                break;

            case 'month':
                $price = $this->Property->checkCustomMonthPrice($_POST['checkin'], $_POST['checkout'], $_POST['property_id'], $_POST['guest'], true);
                break;
        }
        echo $price;
        exit;
    }
    public function import()
    {
        $this->pageTitle = __l('Import Properties');
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Airbnb');
        $this->Airbnb = new AirbnbComponent($collection);
        $importedProperties = $this->Property->find('list', array(
            'conditions' => array(
                'Property.is_imported_from_airbnb' => 1,
                'Property.user_id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'Property.id',
                'Property.airbnb_property_id',
            )
        ));
        $this->set('importedProperties', $importedProperties);
        if (!empty($this->request->data['Property']['step2'])) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $return = $this->Airbnb->import($this->request->data, 2, $importedProperties);
                if (!empty($return['error']) || !empty($return['success'])) {
                    if (!empty($return['error'])) {
                        foreach($return['ids'] as $id) {
                            $title[] = '"' . $this->request->data['Property'][$id]['title'] . '"';
                        }
                        $title = implode(', ', $title);
                        if (!empty($return['success'])) {
                            $this->Session->setFlash(sprintf(__l('%s property not imported from AirBnB and other checked properties are imported successfully.') , $title) , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(sprintf(__l('%s property not imported from AirBnB.') , $title) , 'default', null, 'error');
                        }
                    } elseif (!empty($return['success'])) {
                        $this->Session->setFlash(__l('Checked property imported from AirBnB successfully.') , 'default', null, 'success');
                    }
                    $this->redirect(array(
                        'controller' => 'properties',
                        'action' => 'index',
                        'type' => 'myproperties',
                        'status' => 'imported'
                    ));
                } else {
                    $this->Session->setFlash(__l('Please select any one property to import.') , 'default', null, 'error');
                    $this->set('properties', $this->Airbnb->import($this->request->data, 1, $importedProperties));
                    $this->set('steps', 2);
                }
            } else {
                $this->Session->setFlash(__l('Property could not be imported. Please, try again') , 'default', null, 'error');
                $this->set('properties', $this->Airbnb->import($this->request->data, 1, $importedProperties));
                $this->set('steps', 2);
            }
        } elseif (!empty($this->request->data['Property']['step1'])) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $this->set('properties', $this->Airbnb->import($this->request->data, 1, $importedProperties));
                $this->set('steps', 2);
            } else {
                $this->Session->setFlash(__l('Property could not be imported. Please, try again') , 'default', null, 'error');
                $this->set('steps', 1);
            }
        } else {
            $this->set('steps', 1);
        }
    }
    public function post_to_craigslist()
    {
        $this->pageTitle = __l('Post on Craigslist');
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Craigslist');
        $this->Craigslist = new CraigslistComponent($collection);
        if (!empty($this->request->params['named']['property_id'])) {
            $property_id = $this->request->params['named']['property_id'];
        } else {
            $property_id = $this->request->data['Property']['property_id'];
        }
        if (empty($property_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $property = $this->Property->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id,
                'Property.user_id'=>$this->Auth->user('id'),
				'Property.is_active' =>1,
				'Property.is_paid' =>1,
                  ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.email'
                    )
                ) ,
                'State' => array(
                    'fields' => array(
                        'State.id',
                        'State.name'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name'
                    )
                ) ,
                'Attachment',
                'Amenity',
                'PropertyFeedback' => array(
                    'PropertyUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username'
                            )
                        ) ,
                    ) ,
                    'order' => array(
                        'PropertyFeedback.id' => 'desc'
                    ) ,
                    'limit' => 1
                )
            ) ,
            'recursive' => 2
        ));
        if (empty($property)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $property['Property']['title'];
        $this->set('property', $property);
        $currency_code = Configure::read('site.currency_id');
        $default_currency = $GLOBALS['currencies'][$currency_code]['Currency']['symbol'];
        $property_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'view',
            $property['Property']['slug']
        ) , true);
        $amenities = '';
        $img_bullet_url = Router::url(array(
            'controller' => 'img',
            'action' => 'bullet.png'
        ) , true);
        foreach($property['Amenity'] as $amenity) {
            $amenities.= '<div><img src="' . $img_bullet_url . '" alt="[Image: bullet]">' . $amenity['name'] . '</div>';
        }
        $review = '';
        if (!empty($property['Property']['property_feedback_count'])) {
            $review.= '<br><div><b><font size="5">' . __l('Recent review') . ' (' . $property['Property']['property_feedback_count'] . ' ' . __l('total') . ')</font></b></div><div><font size="2">' . $property['PropertyFeedback']['PropertyUser']['User']['username'] . ' ' . __l('said') . '"<i>' . $property['PropertyFeedback']['feedback'] . '</i>"</font></div>';
        }
        $images = '';
        $property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
        $image_options = array(
            'dimension' => 'medium_big_thumb',
            'class' => '',
            'alt' => $property['Property']['title'],
            'title' => $property['Property']['title'],
            'type' => 'jpg',
            'full_url' => true
        );
        $medium_big_thumb = getImageUrl('Property', $property['Attachment'][0], $image_options);
        $images.= '<div><a rel="nofollow" href="' . $property_url . '"><img src="' . $medium_big_thumb . '" title="' . $property['Property']['title'] . '" alt="[Image: ' . $property['Property']['title'] . ']" /></a></div>';
        if (count($property['Attachment']) >= 2) {
            $image_options = array(
                'dimension' => 'small_big_thumb',
                'class' => '',
                'alt' => $property['Property']['title'],
                'title' => $property['Property']['title'],
                'type' => 'jpg',
                'full_url' => true
            );
            $images.= '<br><table><tbody><tr>';
            unset($property['Attachment'][0]);
            $i = 1;
            foreach($property['Attachment'] as $attachment) {
                $small_big_thumb = getImageUrl('Property', $attachment, $image_options);
                $images.= '<td width="108"><a rel="nofollow" href="' . $property_url . '"><img src="' . $small_big_thumb . '" title="' . $property['Property']['title'] . '" alt="[Image: ' . $property['Property']['title'] . ']" /></a></td>';
                if ($i == 2) {
                    $i = 0;
                    $images.= '</tr><tr>';
                }
                $i++;
            }
            $images.= '</tr></tbody></table>';
        }
        $description = '<div><b><font size="4">' . __l('Interested? Got a question?') . ' <a rel="nofollow" href="' . $property_url . '">' . __l('Contact me here') . '</a></font></b></div><table width="100%"><tbody><tr><td align="left"><div><table><tbody><tr><td width="475" valign="top">' . $images . '</td><td valign="top"><div><b><font size="6">' . $property['Property']['title'] . '</font></b></div><br><table><tbody><tr><td width="135" valign="top"><div><b><font size="6">' . $default_currency . $property['Property']['price_per_night'] . '</font></b></div><div>' . __l('per night') . ' </div></td><td width="200" valign="top"><font size="2"><div>' . __l('Includes') . ':</div>' . $amenities . '</div></font></td><td width="125" valign="top"></td><td width="115" valign="top"></td></tr></tbody></table><div><b><font size="5">' . __l('Description') . '</font></b></div><div><font size="2">' . $property['Property']['description'] . '<a rel="nofollow" href="' . $property_url . '">' . __l('Read full description') . '</a>.</font></div>' . $review . '<br><div><b><font size="5">' . __l('Location') . '</font></b></div><div><font size="2">' . $property['City']['name'] . '.</font></div></td></tr></tbody></table></div></td></tr></tbody></table>';
        if (!empty($this->request->data)) {
            $this->Property->set($this->request->data);
            if ($this->Property->validates($this->request->data)) {
                $this->request->data['Property']['price_per_night'] = $property['Property']['price_per_night'];
                $this->request->data['Property']['email'] = $property['User']['email'];
                $this->request->data['Property']['city'] = $property['City']['name'];
                $this->request->data['Property']['state'] = $property['State']['name'];
                $this->request->data['Property']['description'] = $description;
                echo $this->Craigslist->post($this->request->data);
                exit;
            } else {
                $this->Session->setFlash(__l('Property could not be posted. Please, try again') , 'default', null, 'error');
            }
        }
        $this->request->data['Property']['property_id'] = $property_id;
        if (!isset($this->request->data['Property']['title'])) {
            $this->request->data['Property']['title'] = $property['Property']['title'];
        }
        $this->loadModel('CraigslistMarket');
        $this->loadModel('CraigslistCategory');
        $craigslistMarkets = $this->CraigslistMarket->find('list', array(
            'fields' => array(
                'CraigslistMarket.code',
                'CraigslistMarket.name',
            )
        ));
        $craigslistCategories = $this->CraigslistCategory->find('list', array(
            'fields' => array(
                'CraigslistCategory.code',
                'CraigslistCategory.name',
            )
        ));
        $this->set(compact('craigslistMarkets', 'craigslistCategories'));
    }
    public function sample_data()
    {
        set_time_limit(0);
        Configure::write('debug', 1);
        $dummyData = $this->Property->query('SELECT * FROM tmp_dummy_data');
        $title = array(
            'Beach house in ',
            'Rooms for rent in ',
            'Luxury beach house in ',
            'House near to beach in ',
            'Guest house in ',
            'Luxurious place to live in ',
            'Fully furnished house in ',
            'Luxurious apartment in ',
        );
        $video_url = array(
            'http://www.youtube.com/watch?v=EByBssKshGo',
            'http://www.youtube.com/watch?v=U00bgAkmwYM',
            'http://www.youtube.com/watch?v=90A67SIcNVw',
            'http://www.youtube.com/watch?v=xHFVCjK6aIw',
            'http://www.youtube.com/watch?v=EPuqIKYy7DI',
        );
        $img_dir = APP . 'media' . DS . 'images';
        $handle = opendir($img_dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..' && $readdir != 'Thumbs.db') {
                $image_path_arr[] = $readdir;
            }
        }
        $country_arr = array(
            43,
            254,
            253,
            113,
            14
        );
        $image = $country = 0;
        $escape_city = array();
        foreach($dummyData as $dummy) {
            if ($dummy['tmp_dummy_data']['id'] == 251 || $dummy['tmp_dummy_data']['id'] == 501 || $dummy['tmp_dummy_data']['id'] == 751 || $dummy['tmp_dummy_data']['id'] == 851) {
                $country++;
                $escape_city = array();
            }
            $tmp_country = $this->Property->query('SELECT * FROM tmp_countries WHERE id = ' . $country_arr[$country]);
            $escape_not_in_city = '';
            if (!empty($escape_city)) {
                $escape_not_in_city = ' AND id NOT IN (' . implode(',', $escape_city) . ')';
            }
            $tmp_city = $this->Property->query('SELECT * FROM tmp_cities WHERE country_id = ' . $country_arr[$country] . $escape_not_in_city . ' LIMIT 0, 1');
            $escape_city[] = $tmp_city[0]['tmp_cities']['id'];
            $tmp_state = $this->Property->query('SELECT * FROM tmp_states WHERE id = ' . $tmp_city[0]['tmp_cities']['state_id']);
            $_data['Property']['user_id'] = mt_rand(2, 10);
            $_data['Property']['cancellation_policy_id'] = mt_rand(1, 3);
            $_data['Property']['property_type_id'] = mt_rand(1, 12);
            $_data['Property']['room_type_id'] = mt_rand(1, 3);
            $_data['Property']['bed_type_id'] = mt_rand(1, 5);
            $_data['Property']['city_id'] = $tmp_city[0]['tmp_cities']['id'];
            $_data['Property']['state_id'] = $tmp_city[0]['tmp_cities']['state_id'];
            $_data['Property']['country_id'] = $country_arr[$country];
            $_data['Property']['title'] = $title[mt_rand(0, 7) ] . $tmp_city[0]['tmp_cities']['name'];
            $_data['Property']['description'] = str_replace('.', '', $dummy['tmp_dummy_data']['description']);
            $_data['Property']['accommodates'] = mt_rand(1, 16);
            $_data['Property']['address'] = $dummy['tmp_dummy_data']['address'] . ', ' . $tmp_city[0]['tmp_cities']['name'] . ', ' . $tmp_state[0]['tmp_states']['name'] . ', ' . $tmp_country[0]['tmp_countries']['title'];
            $_data['Property']['phone'] = $dummy['tmp_dummy_data']['phone'];
            $_data['Property']['ip_id'] = 2;
            $price_arr = array(
                10,
                20,
                30,
                40,
                50,
                60,
                70,
                80,
                90,
                100,
                200,
                300,
                400,
                500,
                150,
                250,
                350,
                450
            );
            $_data['Property']['price_per_night'] = $price_arr[mt_rand(0, 17) ];
            $_data['Property']['price_per_week'] = ($_data['Property']['price_per_night']*7) -10;
            $_data['Property']['price_per_month'] = ($_data['Property']['price_per_night']*30) -10;
            if ($_data['Property']['accommodates'] > 3) {
                $_data['Property']['additional_guest'] = $_data['Property']['accommodates']-1;
                $guest_price_arr = array(
                    1,
                    2,
                    3,
                    4,
                    5,
                    6,
                    7,
                    8,
                    9,
                    10
                );
                $_data['Property']['additional_guest_price'] = $guest_price_arr[mt_rand(0, 9) ];
            }
            $_data['Property']['backup_phone'] = $dummy['tmp_dummy_data']['backup_phone'];
            $_data['Property']['house_rules'] = str_replace('.', '', $dummy['tmp_dummy_data']['house_rules']);
            $_data['Property']['house_manual'] = str_replace('.', '', $dummy['tmp_dummy_data']['house_manual']);
            $size_arr = array(
                10,
                20,
                30,
                40,
                50,
                60,
                70,
                80,
                90,
                100,
                200,
                300,
                400,
                500,
                150,
                250,
                350,
                450
            );
            $_data['Property']['property_size'] = $size_arr[mt_rand(0, 17) ];
            $_data['Property']['measurement'] = mt_rand(1, 2);
            $_data['Property']['minimum_nights'] = 1;
            $checkin_arr = array(
                '06:00:00',
                '06:15:00',
                '06:30:00',
                '06:45:00',
                '07:00:00',
                '07:15:00',
                '07:30:00',
                '07:45:00',
                '08:00:00',
                '08:15:00',
                '08:30:00',
                '08:45:00',
                '09:00:00'
            );
            $_data['Property']['checkin'] = $checkin_arr[mt_rand(0, 12) ];
            $checkout_arr = array(
                '18:00:00',
                '18:15:00',
                '18:30:00',
                '18:45:00',
                '19:00:00',
                '19:15:00',
                '19:30:00',
                '19:45:00',
                '20:00:00',
                '20:15:00',
                '20:30:00',
                '20:45:00',
                '21:00:00'
            );
            $_data['Property']['checkout'] = $checkout_arr[mt_rand(0, 12) ];
            $_data['Property']['latitude'] = $tmp_city[0]['tmp_cities']['latitude'];
            $_data['Property']['longitude'] = $tmp_city[0]['tmp_cities']['longitude'];
            $_data['Property']['zoom_level'] = 10;
            $_data['Property']['bed_rooms'] = mt_rand(1, 20);
            $_data['Property']['beds'] = mt_rand(1, 20);
            $_data['Property']['bath_rooms'] = mt_rand(1, 20);
            $_data['Property']['is_active'] = ($dummy['tmp_dummy_data']['id']%50 == 0) ? 0 : 1;
            $_data['Property']['is_approved'] = ($dummy['tmp_dummy_data']['id']%50 == 0) ? 0 : 1;
            $_data['Property']['is_featured'] = ($dummy['tmp_dummy_data']['id']%30 == 0) ? 1 : 0;
            $_data['Property']['is_verified'] = ($dummy['tmp_dummy_data']['id']%30 == 0) ? 1 : 0;
            $_data['Property']['is_show_in_homepage'] = ($dummy['tmp_dummy_data']['id']%220 == 0) ? 1 : 0;
            $_data['Property']['is_paid'] = ($dummy['tmp_dummy_data']['id']%30 == 0) ? 0 : 1;
            $_data['Property']['video_url'] = $video_url[mt_rand(0, 4) ];
            $_data['Property']['location_manual'] = str_replace('.', '', $dummy['tmp_dummy_data']['location_manual']);
            // amenities
            $tmp_am = $result_am = $am = array();
            for ($a = 1; $a <= 22; $a++) {
                $tmp_am[] = $a;
            }
            $result_am = array_rand($tmp_am, 11);
            for ($a = 0; $a < 11; $a++) {
                $am[] = $tmp_am[$result_am[$a]];
            }
            $_data['Amenity']['Amenity'] = $am;
            // holiday types
            $tmp_ht = $result_ht = $ht = array();
            for ($a = 1; $a <= 8; $a++) {
                $tmp_ht[] = $a;
            }
            $result_ht = array_rand($tmp_ht, 4);
            for ($a = 0; $a < 3; $a++) {
                $ht[] = $tmp_ht[$result_ht[$a]];
            }
            $_data['HolidayType']['HolidayType'] = $ht;
            $_data['Property']['id'] = '';
            $this->Property->create();
            if ($this->Property->save($_data)) {
                $property_id = $this->Property->getLastInsertId();
                for ($i = 0; $i < 3; $i++) {
                    $img_url = $img_dir . DS . $image_path_arr[$image];
                    $image_size = getimagesize($img_url);
                    $filename = basename($image_path_arr[$image]);
                    $_attachment_data['Attachment']['filename']['type'] = $image_size['mime'];
                    $_attachment_data['Attachment']['filename']['name'] = $filename;
                    $_attachment_data['Attachment']['filename']['tmp_name'] = $img_url;
                    $_attachment_data['Attachment']['filename']['size'] = filesize($img_url);
                    $_attachment_data['Attachment']['filename']['error'] = 0;
                    $this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
                    $this->Property->Attachment->isCopyUpload(true);
                    $this->Property->Attachment->set($_attachment_data);
                    $this->Property->Attachment->create();
                    $_attachment_data['Attachment']['filename'] = $_attachment_data['Attachment']['filename'];
                    $_attachment_data['Attachment']['class'] = 'Property';
                    $_attachment_data['Attachment']['description'] = str_replace('.jpeg', '', str_replace('.jpg', '', $filename));
                    $_attachment_data['Attachment']['width'] = $image_size[0];
                    $_attachment_data['Attachment']['height'] = $image_size[1];
                    $_attachment_data['Attachment']['foreign_id'] = $property_id;
                    $this->Property->Attachment->data = $_attachment_data['Attachment'];
                    $this->Property->Attachment->save($_attachment_data);
                    $this->Property->Attachment->Behaviors->detach('ImageUpload');
                    if ($image == 114) {
                        $image = 0;
                    } else {
                        $image++;
                    }
                    $_attachment_data = array();
                }
            }
            $_data = array();
        }
        exit;
    }
    public function initChart()
    {
        //# last days date settings
        $days = 3;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y-%m-%d')" => _formatDate('Y-m-d', date('Y-m-d', strtotime("-$i days")) , true) ,
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y-%m-%d')" => _formatDate('Y-m-d', date('Y-m-d') , true)
            )
        );
    }
    public function admin_action_taken()
    {
			$this->loadModel('UserCashWithdrawal');
            $pending_withdraw_count = $this->UserCashWithdrawal->find('count', array(
                'conditions' => array(
                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
                ) ,
                'recursive' => -1
            ));
            $this->set('pending_withdraw_count', $pending_withdraw_count);
			$this->loadModel('AffiliateCashWithdrawal');
            $afffiliate_pending_withdraw_count = $this->AffiliateCashWithdrawal->find('count', array(
                'conditions' => array(
                    'AffiliateCashWithdrawal.affiliate_cash_withdrawal_status_id' => ConstAffiliateCashWithdrawalStatus::Pending
                ) ,
                'recursive' => -1
            ));
            $this->set('afffiliate_pending_withdraw_count', $afffiliate_pending_withdraw_count);
            $property_system_flagged_count = $this->Property->find('count', array(
                'conditions' => array(
                    'Property.is_system_flagged' => 1,
					'Property.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            $property_user_flagged_count = $this->Property->find('count', array(
                'conditions' => array(
                    'Property.is_user_flagged' => 1,
					'Property.admin_suspend' => 0,
                ) ,
                'recursive' => -1
            ));
            $this->set('property_system_flagged_count', $property_system_flagged_count);
            $this->set('property_user_flagged_count', $property_user_flagged_count);
            $request_system_flagged_count = $this->Property->PropertiesRequest->Request->find('count', array(
                'conditions' => array(
                    'Request.is_system_flagged' => 1,
					'Request.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            $request_user_flagged_count = $this->Property->PropertiesRequest->Request->find('count', array(
                'conditions' => array(
                    'Request.is_user_flagged' => 1,
					'Request.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            $this->set('request_system_flagged_count', $request_system_flagged_count);
            $this->set('request_user_flagged_count', $request_user_flagged_count);
        $pending_for_verification_count = $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_verified' => ConstVerification::WaitingForVerification
            ) ,
            'recursive' => -1
        ));
		$this->set('pending_for_verification_count', $pending_for_verification_count);
		$pending_for_approval_count = $this->Property->find('count', array(
            'conditions' => array(
                'Property.is_approved' => 0
            ) ,
            'recursive' => -1
        ));
        $this->set('pending_for_approval_count', $pending_for_approval_count);
		$request_pending_for_approval_count = $this->Property->PropertiesRequest->Request->find('count', array(
            'conditions' => array(
                'Request.is_active' => 0
            ) ,
            'recursive' => -1
        ));
        $this->set('request_pending_for_approval_count', $request_pending_for_approval_count);
		$this->loadModel('PropertyUserDispute');
		$propery_displute_count = $this->PropertyUserDispute->find('count', array(
            'conditions' => array(
                'PropertyUserDispute.dispute_status_id' => ConstDisputeStatus::Open
            ) ,
            'recursive' => -1
        ));
        $this->set('propery_displute_count', $propery_displute_count);
    }
}
?>