<?php
class Property extends AppModel
{
    public $name = 'Property';
    public $displayField = 'title';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'title'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'title',
                'description',
                'tag',
                'address',
                'mobile',
                'house_rules',
                'house_manual'
            )
        ) ,
        'FindInSet' => array(
            'setField' => array(
                'Amenity',
                'HolidayType'
            )
        )
    );
    var $aggregatingFields = array(
        'sales_cleared_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            )
        ) ,
        'sales_pending_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::WaitingforAcceptance
                )
            )
        ) ,
        'sales_pipeline_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                ) ,
				'PropertyUser.is_payment_cleared' => 0
            )
        ) ,
        'negotiation_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.is_negotiation_requested' => 1,
                'PropertyUser.user_id >' => 0,
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::PaymentPending
                )
            )
        ) ,
        'sales_completed_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Completed,
					// @todo "Auto review" add condition CompletedAndClosedByAdmin
                )
            )
        ) ,
        'sales_rejected_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Rejected
                )
            )
        ) ,
        'sales_canceled_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Canceled,
                    ConstPropertyUserStatus::CanceledByAdmin,
                )
            )
        ) ,
        'sales_lost_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Rejected,
                    ConstPropertyUserStatus::Canceled,
                    ConstPropertyUserStatus::Expired,
                    ConstPropertyUserStatus::CanceledByAdmin,
                )
            )
        ) ,
        'sales_expired_count' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'COUNT(PropertyUser.property_id)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Expired
                )
            )
        ) ,
        'sales_cleared_amount' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.price)',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            )
        ) ,
        'sales_pipeline_amount' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.price)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Confirmed,
                    ConstPropertyUserStatus::Arrived,
                    ConstPropertyUserStatus::WaitingforReview,
                ) ,
				'PropertyUser.is_payment_cleared' => 0
            )
        ) ,
        'sales_lost_amount' => array(
            'mode' => 'real',
            'key' => 'property_id',
            'foreignKey' => 'property_id',
            'model' => 'PropertyUser',
            'function' => 'SUM(PropertyUser.price)',
            'conditions' => array(
                'PropertyUser.property_user_status_id' => array(
                    ConstPropertyUserStatus::Rejected,
                    ConstPropertyUserStatus::Canceled,
                    ConstPropertyUserStatus::Expired,
                    ConstPropertyUserStatus::CanceledByAdmin,
                )
            )
        ) ,
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Property.is_paid' => 1,
                'Property.is_active' => 1,
                'Property.is_approved' => 1
            )
        ) ,
        'CancellationPolicy' => array(
            'className' => 'CancellationPolicy',
            'foreignKey' => 'cancellation_policy_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
			'counterCache' => true,
        ) ,
        'PropertyType' => array(
            'className' => 'PropertyType',
            'foreignKey' => 'property_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'RoomType' => array(
            'className' => 'RoomType',
            'foreignKey' => 'room_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'BedType' => array(
            'className' => 'BedType',
            'foreignKey' => 'bed_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Privacy' => array(
            'className' => 'Privacy',
            'foreignKey' => 'privacy_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'Property'
            ) ,
            'dependent' => true
        ) ,
        'CustomPricePerNight' => array(
            'className' => 'CustomPricePerNight',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'property_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CustomPricePerMonth' => array(
            'className' => 'CustomPricePerMonth',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CustomPricePerWeek' => array(
            'className' => 'CustomPricePerWeek',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertyFeedback' => array(
            'className' => 'PropertyFeedback',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertyUserFeedback' => array(
            'className' => 'PropertyUserFeedback',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertyFavorite' => array(
            'className' => 'PropertyFavorite',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertyUser' => array(
            'className' => 'PropertyUser',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertyView' => array(
            'className' => 'PropertyView',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'HolidayTypeProperty' => array(
            'className' => 'HolidayTypeProperty',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'AmenitiesProperty' => array(
            'className' => 'AmenitiesProperty',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'PropertiesRequest' => array(
            'className' => 'PropertiesRequest',
            'foreignKey' => 'property_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    public $hasAndBelongsToMany = array(
        'Amenity' => array(
            'className' => 'Amenity',
            'joinTable' => 'amenities_properties',
            'foreignKey' => 'property_id',
            'associationForeignKey' => 'amenity_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'HolidayType' => array(
            'className' => 'HolidayType',
            'joinTable' => 'holiday_type_properties',
            'foreignKey' => 'property_id',
            'associationForeignKey' => 'holiday_type_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'Collection' => array(
            'className' => 'Collection',
            'joinTable' => 'collections_properties',
            'foreignKey' => 'property_id',
            'counterCache' => true,
            'associationForeignKey' => 'collection_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'title' => array(
                'rule2' => array(
                    'rule' => array(
                        '_validateTitle',
                        'title'
                    ) ,
                    'message' => sprintf(__l('Must be between of %s to %s'), Configure::read('property.minimum_title_length'), Configure::read('property.maximum_title_length'))
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'description' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'cancellation_policy_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'property_type_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'room_type_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'bed_type_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'privacy_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'slug' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Please select proper address')
            ) ,
            'street_view' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'accommodates' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'bed_rooms' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'beds' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'price_per_night' => array(
                'rule3' => array(
                    'rule' => array(
                        '_validatePrice',
                        'price_per_night'
                    ) ,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Enter valid format')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'price_per_week' => array(
                'rule2' => array(
                    'rule' => array(
                        '_validatePrice',
                        'price_per_week'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid format')
                ) ,
            ) ,
            'price_per_month' => array(
                'rule2' => array(
                    'rule' => array(
                        '_validatePrice',
                        'price_per_month'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid format')
                ) ,
            ) ,
			'security_deposit' => array(
                'rule2' => array(
                    'rule' => array(
                        '_validatePrice',
                        'security_deposit'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid format')
                ) ,
            ) ,
			'additional_guest' => array(
				'rule1' => array(
                    'rule' => array(
						'_validateGuestCount',
					) ,
                    'allowEmpty' => true,
                    'message' => __l('Must be less than maximum number of guests')
                )
			) ,
            'additional_guest_price' => array(
                'rule2' => array(
                    'rule' => array(
                        '_validatePrice',
                        'additional_guest_price'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Must be greater than zero')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Enter valid format')
                ) ,
            ) ,
			'maximum_nights' => array(
                'rule1' => array(
                    'rule' => '_validateNights',
                    'allowEmpty' => true,
                    'message' => __l('Must be greater than minimum nights')
                ) ,
			) ,
            'phone' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'video_url' => array(
                'rule' => '_validateVideoUrl',
                'message' => __l('Must be a valid video URL') ,
                'allowEmpty' => true,
            ) ,
            'airbnb_email' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'airbnb_password' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'craigslist_category_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'craigslist_market_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
        );
        $this->moreStreetActions = array(
            ConstStreetAction::Hidestreetview => __l('Hide street view') ,
            ConstStreetAction::Closesttoaddress => __l('Closest to my address') ,
            ConstStreetAction::Nearby => __l('Nearby (within 2 blocks)') ,
        );
        $this->moreMeasureActions = array(
            ConstMeasureAction::Squarefeet => __l('Square Feet') ,
            ConstMeasureAction::Squaremeasures => __l('Square Meters')
        );
        $this->moreMyPropertiesActions = array(
            ConstMoreAction::Inactive => __l('Disable') ,
            ConstMoreAction::Active => __l('Enable') ,
        );
        $this->moreActionpropertys = array(
            ConstMoreAction::Collection => __l('Add in collection') ,
            ConstMoreAction::Suspend => __l('Suspend') ,
            ConstMoreAction::Unsuspend => __l('Unsuspend') ,
            ConstMoreAction::Flagged => __l('Flag') ,
            ConstMoreAction::Unflagged => __l('Clear flag') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _validateTitle($field1 = array() , $field2 = null)
    {
        if (strlen($this->data[$this->name][$field2]) <= Configure::read('property.maximum_title_length') && strlen($this->data[$this->name][$field2]) >= Configure::read('property.minimum_title_length')) {
            return true;
        } else {
            return false;
        }
    }
    function _validateVideoUrl()
    {
        App::import('Helper', 'Embed');
        $this->Embed = new EmbedHelper();
        if (!(!empty($this->data['Property']['video_url']) && $this->Embed->parseUrl($this->data['Property']['video_url']))) {
            return false;
        }
        return true;
    }
	function _validateGuestCount($field1 = array())
    {
        if (!empty($this->data[$this->name]['additional_guest']) && !empty($this->data[$this->name]['accommodates']) && !empty($this->data[$this->name]['additional_guest_price']) && $this->data[$this->name]['additional_guest'] >= $this->data[$this->name]['accommodates']) {
            return false;
        }
        return true;
    }
	function _validateNights($field1 = array())
    {
        if (!empty($this->data[$this->name]['minimum_nights']) && !empty($this->data[$this->name]['maximum_nights']) && $this->data[$this->name]['minimum_nights'] > $this->data[$this->name]['maximum_nights']) {
            return false;
        }
        return true;
    }
    function _validatePrice($field1 = array() , $field2 = null)
    {
        if (isset($this->data[$this->name][$field2]) && $this->data[$this->name][$field2] < 0) {
            return false;
        }
        return true;
    }
    function checkCustomWeekPrice($checkin, $checkout, $property_id, $additional_guest,$convert=false)
    {
		if ($checkin > $checkout || $checkin < date('Y-m-d')) {
			return 0;
		}
        App::import('Model', 'CustomPricePerWeek');
        $this->CustomPricePerWeek = new CustomPricePerWeek();
        $days = ((strtotime($checkout) -strtotime($checkin)) /(60*60*24)) + 1;
        $no_weeks = round($days/7);
        $cutom_week_prices = $this->CustomPricePerWeek->find('all', array(
            'conditions' => array(
                'CustomPricePerWeek.start_date >=' => $checkin,
                'CustomPricePerWeek.end_date <=' => $checkout,
                'CustomPricePerWeek.property_id' => $property_id,
            ) ,
            'fields' => array(
                'count(CustomPricePerWeek.price) as records',
                'sum(CustomPricePerWeek.price) as total_price',
            ) ,
            'group' => array(
                'CustomPricePerWeek.property_id',
            ) ,
            'recursive' => -1,
        ));
        $property = $this->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id,
            ) ,
            'recursive' => -1,
        ));
        $records = 0;
        $cstom_week_price = 0;
        if (!empty($cutom_week_prices)) {
            $records = $cutom_week_prices[0][0]['records'];
            $cstom_week_price = $cutom_week_prices[0][0]['total_price'];
        }
        //additional guest price calculations
        $additional_guest = (($additional_guest-$property['Property']['additional_guest']) > 0) ? ($additional_guest-$property['Property']['additional_guest']) : 0;
        $additional_guest_price = 0;
        if ($additional_guest > 0) {
            $additional_guest_price = ($additional_guest*$property['Property']['additional_guest_price']) * $days;
        }
        $remaining_weeks = $no_weeks-$records;
        $price = 0;
        if ($remaining_weeks > 0) {
            $item_price = !empty($property['Property']['price_per_week']) ? $property['Property']['price_per_week'] : $property['Property']['price_per_night'];
            if (!empty($property['Property']['price_per_week'])) {
                $price = $item_price*($remaining_weeks);
            } else {
                $price = $item_price*(7*$remaining_weeks);
            }
        }
        //appening custom price
        $price = $price+$cstom_week_price;
        //appending the addition guest price
        $price = $price+$additional_guest_price;
       if($convert)
		{
         return $this->siteWithCurrencyFormat($price,false);
		}
		else
		{
			return $price;
		}
    }
    function checkCustomMonthPrice($checkin, $checkout, $property_id, $additional_guest,$convert=false)
    {
		if ($checkin > $checkout || $checkin < date('Y-m-d')) {
			return 0;
		}
        App::import('Model', 'CustomPricePerMonth');
        $this->CustomPricePerMonth = new CustomPricePerMonth();
        $days = ((strtotime($checkout) -strtotime($checkin)) /(60*60*24)) + 1;
        $no_months = round($days/30);
        $cutom_month_prices = $this->CustomPricePerMonth->find('all', array(
            'conditions' => array(
                'CustomPricePerMonth.start_date >=' => $checkin,
                'CustomPricePerMonth.end_date <=' => $checkout,
                'CustomPricePerMonth.property_id' => $property_id,
            ) ,
            'fields' => array(
                'count(CustomPricePerMonth.price) as records',
                'sum(CustomPricePerMonth.price) as total_price',
            ) ,
            'group' => array(
                'CustomPricePerMonth.property_id',
            ) ,
            'recursive' => -1,
        ));
        $property = $this->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id,
            ) ,
            'recursive' => -1,
        ));
        $records = 0;
        $cstom_month_price = 0;
        if (!empty($cutom_month_prices)) {
            $records = $cutom_month_prices[0][0]['records'];
            $cstom_month_price = $cutom_month_prices[0][0]['total_price'];
        }
        //additional guest price calculations
        $additional_guest = (($additional_guest-$property['Property']['additional_guest']) > 0) ? ($additional_guest-$property['Property']['additional_guest']) : 0;
        $additional_guest_price = 0;
        if ($additional_guest > 0) {
            $additional_guest_price = ($additional_guest*$property['Property']['additional_guest_price']) * $days;
        }
        $remaining_months = $no_months-$records;
        $price = 0;
        if ($remaining_months > 0) {
            $item_price = !empty($property['Property']['price_per_month']) ? $property['Property']['price_per_month'] : $property['Property']['price_per_night'];
            if (!empty($property['Property']['price_per_month'])) {
                $price = $item_price*($remaining_months);
            } else {
                $price = $item_price*(30*$remaining_months);
            }
        }
        //appening custom price
        $price = $price+$cstom_month_price;
        //appending the addition guest price
        $price = $price+$additional_guest_price;
		if($convert)
		{
         return $this->siteWithCurrencyFormat($price,false);
		}
		else
		{
			return $price;
		}
    }
    function checkCustomPrice($checkin, $checkout, $property_id, $additional_guest,$convert=false)
    {
		if ($checkin > $checkout || $checkin < date('Y-m-d')) {
			return 0;
		}
        App::import('Model', 'CustomPricePerNight');
        $this->CustomPricePerNight = new CustomPricePerNight();
        $days = ((strtotime($checkout) - strtotime($checkin)) /(60*60*24)) + 1;
        $no_days = $days;
        $customPricePerNights = $this->CustomPricePerNight->find('all', array(
            'conditions' => array(
                'CustomPricePerNight.property_id' => $property_id,
            ) ,
            'recursive' => -1,
        ));
		$property = $this->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id,
            ) ,
            'recursive' => -1,
        ));
		$checkin_checkout_date_diff = (strtotime($checkout) - strtotime($checkin)) / (60*60*24);
		$found = $custom_daily_price = $additional_guest_price = 0;
		for ($i=0; $i<=$checkin_checkout_date_diff; $i++) {
			if ($i == 0) {
				$tmp_checkin = $checkin;
			} else {
				$tmp_checkin = date('Y-m-d', strtotime($tmp_checkin . ' +1 day'));
			}
			foreach($customPricePerNights as $customPricePerNight) {
				if ((strtotime($tmp_checkin) >= strtotime($customPricePerNight['CustomPricePerNight']['start_date'])) && (strtotime($tmp_checkin) <= strtotime($customPricePerNight['CustomPricePerNight']['end_date']))) {
					$custom_daily_price += $customPricePerNight['CustomPricePerNight']['price'];
					$found++;
					break;
				}
			}
		}
        //additional guest price calculations
        $additional_guest = (($additional_guest-$property['Property']['additional_guest']) > 0) ? ($additional_guest-$property['Property']['additional_guest']) : 0;
        if ($additional_guest > 0) {
            $additional_guest_price = ($additional_guest*$property['Property']['additional_guest_price']) * $no_days;
        }
		$remaining_days = $no_days - $found;
		$price = ($remaining_days * $property['Property']['price_per_night']) + $custom_daily_price + $additional_guest_price;
        if ($convert) {
			return $this->siteWithCurrencyFormat($price,false);
		} else {
			return $price;
		}
    }
    function getSearchKeywords($hash_keyword = '', $salt = '')
    {
        App::import('Model', 'SearchKeyword');
        $this->SearchKeyword = new SearchKeyword();
        if (!empty($hash_keyword) && !empty($salt)) {
            //decoding
            $keyword_id = hexdec($hash_keyword);
            //checking valid one using encoding format
            $check_hash = dechex($keyword_id);
            $salty = $keyword_id+786;
            $check_salt = substr(dechex($salty) , 0, 2);
            if ($check_hash == $hash_keyword && $check_salt == $salt) {
                $searchKeyword = $this->SearchKeyword->find('first', array(
                    'conditions' => array(
                        'SearchKeyword.id =' => $keyword_id
                    ) ,
                    'fields' => array(
                        'SearchKeyword.id',
                        'SearchKeyword.keyword',
                    ) ,
                    'recursive' => -1,
                ));
                $querystring = $searchKeyword['SearchKeyword']['keyword'];
                $query_string_array = explode('/', $querystring);
                $query_string_array = array_filter($query_string_array);
                $named_array = array();
                foreach($query_string_array as $key => $val) {
                    $split_array = explode(':', $val);
                    $named_array[$split_array[0]] = $split_array[1];
                    unset($split_array);
                }
                return $named_array;
            } else {
                $this->redirect(array(
                    'controller' => 'properties',
                    'action' => 'index',
                    'admin' => false
                ));
            }
        }
    }
    function getCalendarData($year, $month, $conditions)
    {
        $sites = $this->find('all', array(
            'conditions' => array(
                'Property.is_active != ' => 1
            ) ,
            'fields' => array(
                'Property.id'
            ) ,
            'recursive' => 0
        ));
        if (!empty($sites)) {
            foreach($sites as $site) {
                $unverified[] = $site['Property']['id'];
            }
            $conditions['NOT']['Property.id'] = $unverified;
        }
        for ($i = 1, $j = 1; $i <= 31; $i++, $j++) {
            if ($i < 10) {
                $i = '0' . $i;
            }
            if ($month < 10) {
                $month = '0' . $month;
            }
            $day[$year][$j] = $this->find('count', array(
                'conditions' => array(
                    $conditions,
                    'and' => array(
                        'Property.checkin >= ' => $year . '-' . $month . '-' . $i . ' 00:00:00',
                        'Property.checkout <= ' => $year . '-' . $month . '-' . $i . ' 23:59:59',
                        'Property.is_active' => 1
                    )
                ) ,
            ));
        }
        return $day;
    }
    function _updateCityPropertyCount()
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cityProperties = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1,
            ) ,
            'contain' => array(
                'Property' => array(
                    'conditions' => array(
                        'Property.is_active' => 1,
                        'Property.is_approved' => 1,
                    ) ,
                    'fields' => array(
                        'Property.id',
                    ) ,
                ) ,
            ) ,
            'recursive' => 2
        ));
        $this->City->updateAll(array(
            'City.property_count' => 0,
        ));
        foreach($cityProperties as $cityProperty) {
            if (!empty($cityProperty['Property'])) {
                $this->City->updateAll(array(
                    'City.property_count' => count($cityProperty['Property']) ,
                ) , array(
                    'City.id' => $cityProperty['City']['id']
                ));
            }
        }
    }
    function __updatePropertyRequest($request_id, $property_id)
    {
        App::import('Model', 'PropertiesRequest');
        $this->PropertiesRequest = new PropertiesRequest();
        App::import('Model', 'Request');
        $this->Request = new Request();
        $property_request = $this->PropertiesRequest->find('count', array(
            'conditions' => array(
                'PropertiesRequest.property_id' => $property_id,
                'PropertiesRequest.request_id' => $request_id,
            ) ,
        ));
        if (!$property_request) {
            $this->data['PropertiesRequest']['request_id'] = $request_id;
            $this->data['PropertiesRequest']['property_id'] = $property_id;
            $this->PropertiesRequest->save($this->data['PropertiesRequest']);
            $request_count = $this->PropertiesRequest->find('count', array(
                'conditions' => array(
                    'PropertiesRequest.property_id' => $property_id,
                ) ,
            ));
            $property_count = $this->PropertiesRequest->find('count', array(
                'conditions' => array(
                    'PropertiesRequest.request_id' => $request_id,
                ) ,
            ));
            $this->Request->updateAll(array(
                'Request.property_count' => $property_count,
            ) , array(
                'Request.id' => $request_id
            ));
            $this->updateAll(array(
                'Property.request_count' => $request_count,
            ) , array(
                'Property.id' => $property_id
            ));
	        $this->_requestPropertyNotificationMail($request_id, $property_id);
			return $this->PropertiesRequest->getLastInsertId();
        }
		return false;
    }
    // <-- For iPhone App code
    function saveiPhoneAppThumb($attachments)
    {
        $options[] = array(
            'dimension' => 'iphone_big_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
            'full_url' => true
        );
        $options[] = array(
            'dimension' => 'iphone_small_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg',
            'full_url' => true
        );
        $model = 'Property';
        $attachment = $attachments[0];
        foreach($options as $option) {
            $destination = APP . 'webroot' . DS . 'img' . DS . $option['dimension'] . DS . $model . DS . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $option['type'] . $option['dimension'] . Configure::read('site.name')) . '.' . $option['type'];
            if (!file_exists($destination)) {
                $url = getImageUrl($model, $attachment, $option);
                getimagesize($url);
            }
        }
    }
    // For iPhone App code -->
    function _requestPropertyNotificationMail($request_id, $property_id)
    {
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $request_property = $this->find('first', array(
            'conditions' => array(
                'Property.id' => $property_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.cleared_amount',
                    )
                )
            ) ,
            'recursive' => 0
        ));
        $request_user = $this->Request->find('first', array(
            'conditions' => array(
                'Request.id' => $request_id
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
            ) ,
            'recursive' => 0
        ));
		// @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
	 $email = $this->EmailTemplate->selectTemplate('Requested Property Notification');
        $emailFindReplace = array(
            '##USERNAME##' => $request_user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                $request_property['Property']['slug'],
            ) , true) ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##REQUEST_URL##' => Router::url(array(
                'controller' => 'requests',
                'action' => 'view',
                $request_user['Request']['slug']
            ) , true) ,
            '##PROPERTY_URL##' => Router::url(array(
                'controller' => 'properties',
                'action' => 'view',
                $request_property['Property']['slug']
            ) , true),
            '##FROM_EMAIL##' =>($email['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $email['from'],
            '##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add'
			), true),
			'##SITE_LOGO##' => Router::url(array(
            'controller' => 'img',
            'action' => 'logo.png',
            'admin' => false
            ) , true) ,

        );
        $sender_email = $request_property['User']['email'];
        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'];
        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $email['reply_to'];
        $this->Email->to = $request_user['User']['email'];
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $to = $request_user['User']['id'];
        $subject = strtr($email['subject'], $emailFindReplace);
        $message = strtr($email['email_content'], $emailFindReplace);
        if (Configure::read('messages.is_send_internal_message')) {
            $message_id = $this->Message->sendNotifications($to, $subject, $message, 0, 0, $property_id);
            if (Configure::read('messages.is_send_email_on_new_message')) {
                $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                $this->Email->send(strtr($message, $emailFindReplace));
            }
        }
    }
    function _getCalendarBookingDates($property_id, $month, $year)
    {
        $booked = array();
        $available_week = array();
        // Find propery_user and custom_nights monthly booking //
        $property_user_monthly_bookings = $this->PropertyUser->_getCalendarMontlyBooking($property_id, $month, $year);
        $custom_night_monthly_bookings = $this->CustomPricePerNight->_getCalendarMontlyBooking($property_id, $month, $year);
        $custom_week_monthly_bookings = $this->CustomPricePerWeek->_getCalendarMontlyBooking($property_id, $month, $year);
        foreach($property_user_monthly_bookings as $property_user_monthly_booking) {
            $booked[] = array(
                'start_date' => $property_user_monthly_booking['PropertyUser']['checkin'],
                'end_date' => $property_user_monthly_booking['PropertyUser']['checkout'],
                'price' => $property_user_monthly_booking['PropertyUser']['price'],
                'is_custom_nights' => 0,
                'color' => '#FFA2B7'
            );
        }
        foreach($custom_night_monthly_bookings as $custom_night_monthly_booking) {
            $booked[] = array(
                'start_date' => $custom_night_monthly_booking['CustomPricePerNight']['start_date'],
                'end_date' => $custom_night_monthly_booking['CustomPricePerNight']['end_date'],
                'price' => $custom_night_monthly_booking['CustomPricePerNight']['price'],
                'is_custom_nights' => 1,
                'is_available' => $custom_night_monthly_booking['CustomPricePerNight']['is_available'],
                'color' => ($custom_night_monthly_booking['CustomPricePerNight']['is_available']) ? '#98CF67' : '#FFE3F2',
				'pastdate' => (strtotime('now') > strtotime($custom_night_monthly_booking['CustomPricePerNight']['start_date'])) ? 1 : 0
            );
        }
        foreach($custom_week_monthly_bookings as $key => $custom_week_monthly_booking) {
            $available_week[$key] = array(
                'start_date' => $custom_week_monthly_booking['CustomPricePerWeek']['start_date'],
                'end_date' => $custom_week_monthly_booking['CustomPricePerWeek']['end_date'],
                'price' => $custom_week_monthly_booking['CustomPricePerWeek']['price'],
            );
        }
        $conditions = array();
        $conditions['Property.id'] = $property_id;
        $property = $this->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Property.id',
                'Property.title',
                'Property.slug',
                'Property.price_per_night',
                'Property.price_per_week',
                'Property.price_per_month',
                'Property.checkin',
                'Property.checkout',
            ) ,
            'recursive' => -1
        ));
        $ts = strtotime(date("Y-m-d", mktime(0, 0, 0, $month, 1, $year)));
        for ($i = 0; $i < 6; $i++) {
            $weekcnt = $i+1;
            $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
            $start_date = date('Y-m-d', $start);
            $end_date = date('Y-m-d', strtotime('next saturday', $start));
            $temp = explode('-', $end_date);
            $ts = strtotime(date("Y-m-d", mktime(0, 0, 0, $month, $temp[2]+1, $year)));
            if (strtotime(date('Y-m-d')) >= strtotime(date("Y-m-d", $start))) {
                $booked['week'][$weekcnt]['is_available'] = 2;
            } else {
                $booked_status = $this->PropertyUser->_getCalendarWeekBooking($property_id, $start_date, $end_date);
                if ($booked_status) {
                    $booked['week'][$weekcnt]['is_available'] = 0;
                } else {
                    $booked['week'][$weekcnt]['is_available'] = 1;
                }
            }
            $booked['week'][$weekcnt]['start_date'] = $start_date;
            $booked['week'][$weekcnt]['end_date'] = $end_date;
            $booked['week'][$weekcnt]['price'] = $property['Property']['price_per_week'];
        }
        foreach($booked['week'] as $key => $week) {
            if (empty($available_week[$key])) {
                $available_week['week' . $key] = $week;
            } else {
                $available_week['week' . $key] = $available_week[$key];
                $available_week['week' . $key]['is_available'] = $week['is_available'];
                unset($available_week[$key]);
            }
        }
        $booked['week'] = $available_week;
        $booked['property_id'] = $property['Property']['id'];
        $booked['weekly_price'] = !empty($property['Property']['price_per_week']) ? $property['Property']['price_per_week'] : ($property['Property']['price_per_night'] * 7);
        $booked['night_price'] = $property['Property']['price_per_night'];
        $booked['monthly'] = !empty($property['Property']['price_per_month']) ? $property['Property']['price_per_month'] : ($property['Property']['price_per_night'] * 30);
        return $booked;
    }
	public function getFacebookFriendLevel($user_ids)
	{
		$userFacebookFriends = $this->_getUserFacebookFriendsList($_SESSION['Auth']['User']['id']);
		$network_level = array();
		if (!empty($userFacebookFriends)) {
			$travelerFacebookFriends = $travelerFirstFacebookFriends = array_keys($userFacebookFriends[$_SESSION['Auth']['User']['id']]);
			if (!empty($travelerFirstFacebookFriends)) {
				foreach($user_ids as $user_id => $fb_user_id) {
					if (in_array($fb_user_id, $travelerFirstFacebookFriends)) {
						$network_level[$user_id] = 1;
						continue;
					} else {
						for($i = 2; $i <= Configure::read('property.network_level'); $i++) {
							$userIds = $this->_getUserIds($travelerFacebookFriends);
							$travelerFacebookFriends = array();
							if (!empty($userIds)) {
								$tmpUserFacebookFriends = $this->_getUserFacebookFriendsList(array_keys($userIds));
								if (!empty($tmpUserFacebookFriends)) {
									foreach($tmpUserFacebookFriends as $tmpUserFacebookFriend) {
										$travelerFacebookFriends = array_keys($tmpUserFacebookFriend);
									}
									if (!empty($travelerFacebookFriends)) {
										if (in_array($fb_user_id, $travelerFacebookFriends)) {
											$network_level[$user_id] = $i;
											break;
										}
									} else {
										break;
									}
								} else {
									break;
								}
							} else {
								break;
							}
						}
					}
				}
			}
		}
		return $network_level;
	}
	function getMutualFriends($traveler_user_id, $host_user_id)
	{
		return $this->_getUserFacebookFriendsList(array($traveler_user_id, $host_user_id));
	}
	function _getUserFacebookFriendsList($user_ids)
	{
		$userFacebookFriends = $this->User->UserFacebookFriend->find('list', array(
			'conditions' => array(
				'UserFacebookFriend.user_id' => $user_ids
			) ,
			'fields' => array(
				'UserFacebookFriend.facebook_friend_id',
				'UserFacebookFriend.facebook_friend_name',
				'UserFacebookFriend.user_id',
			) ,
			'recursive' => -1
		));
		return $userFacebookFriends;
	}
	function _getUserIds($facebook_user_ids)
	{
		$userIds = $this->User->find('list', array(
			'conditions' => array(
				'User.network_fb_user_id' => $facebook_user_ids
			) ,
			'fields' => array(
				'User.id',
				'User.username',
			) ,
			'recursive' => -1
		));
		return $userIds;
	}
}
?>