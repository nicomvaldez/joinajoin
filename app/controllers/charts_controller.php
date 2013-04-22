<?php
class ChartsController extends AppController
{
    public $name = 'Charts';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public function initChart()
    {
        //# last days date settings
        $days = 6;
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
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => _formatDate('Y-m-d', date('Y-m-d', $start) , true) ,
                    '#MODEL#.created <=' => _formatDate('Y-m-d', date('Y-m-d', $end) , true) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => _formatDate('Y-m-d', date('Y-m-d', $timestamp_end+24*3600) , true) ,
                '#MODEL#.created <=' => _formatDate('Y-m-d', date('Y-m-d') , true)
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y-%m')" => _formatDate('Y-m', date('Y-m-d', strtotime("-$i months")) , true)
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y-%m')" => _formatDate('Y-m', date('Y-m-d') , true)
            )
        );
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y')" => _formatDate('Y', date('Y-m-d', strtotime("-$i years")) , true)
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y')" => _formatDate('Y', date('Y-m-d') , true)
            )
        );
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
     public function admin_chart_overview()
    {
        $this->initChart();
        $this->loadModel('PropertyView');
        $this->loadModel('PropertyUser');
        $this->loadModel('Transaction');
        $this->loadModel('Property');
        $this->loadModel('UserCashWithdrawal');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $common_conditions=array();
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
            'display' => __l('Deposited') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet
            ) ,
        );
        $transaction_model_datas['Total Withdrawn Amount'] = array(
            'display' => __l('Withdrawn Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AcceptCashWithdrawRequest
            ) ,
        );
         $transaction_model_datas['Total Amount Paid to Host'] = array(
            'display' => __l('Amount Paid to Host') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'PropertyUser',
            'conditions' => array(
                'PropertyUser.is_payment_cleared' => 1
            ) ,
        );
        $transaction_model_datas['Total Pending Withdraw Request'] = array(
            'display' => __l('Pending Withdraw Request') ,
            'model' => 'UserCashWithdrawal',
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
            ) ,
        );
         $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'PropertyUser') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(PropertyUser.host_service_amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        //Toatal Bookings
         $booking_model_datas['Pipeline'] = array(
            'display' => __l('Pipeline') ,
            'model' => 'PropertyUser',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::Completed
				) ,
				'PropertyUser.is_payment_cleared' => 0,
            ),
            'fields' => array(
              'SUM(`PropertyUser`.`price` - `PropertyUser`.`host_service_amount`)'
            ) ,
        );
        $booking_model_datas['Cleared'] = array(
			'display' => __l('Cleared') ,
			'model' => 'PropertyUser',
			'conditions' => array(
				'PropertyUser.is_payment_cleared' => 1
			) ,
			'fields' => array(
				'SUM(`PropertyUser`.`traveler_service_amount` + `PropertyUser`.`host_service_amount`)'
			) ,
		);
        $booking_model_datas['Lost'] = array(
            'display' => __l('Lost') ,
            'model' => 'PropertyUser',
            'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Rejected,
					ConstPropertyUserStatus::Canceled,
					ConstPropertyUserStatus::Expired,
					ConstPropertyUserStatus::CanceledByAdmin
				)
            ),
            'fields' => array(
              'COUNT(PropertyUser.owner_user_id)'
            ) ,
        );
        $chart_booking_data = $this->_setLineData($select_var, $booking_model_datas, 'Property', $common_conditions);
        $this->set('chart_booking_data', $chart_booking_data);
        $this->set('chart_booking_data_periods', $booking_model_datas);
		//Revenue
		$revenue_model_datas['Membership Fee'] = array(
			'display' => __l('Membership Fee') ,
			'model' => 'Transaction',
			'conditions' => array(
				'Transaction.transaction_type_id' => ConstTransactionTypes::SignupFee,
			),
			'fields' => array(
				'SUM(Transaction.amount) as total_amount'
			) ,
		);
		$revenue_model_datas['Listing Fee'] = array(
			'display' => __l('Listing Fee') ,
			'model' => 'Transaction',
			'conditions' => array(
				'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyListingFee,
			),
			'fields' => array(
				'SUM(Transaction.amount) as total_amount'
			) ,
		);
		$revenue_model_datas['Verification Fee'] = array(
			'display' => __l('Verification Fee') ,
			'model' => 'Transaction',
			'conditions' => array(
				'Transaction.transaction_type_id' => ConstTransactionTypes::PropertyVerifyFee,
			) ,
			'fields' => array(
				'SUM(Transaction.amount) as total_amount'
			) ,
		);
		$revenue_model_datas['Service Fee From Traveler'] = array(
			'display' => __l('Service Fee From Traveler') ,
			'model' => 'PropertyUser',
			'conditions' => array(
				'PropertyUser.property_user_status_id' => array(
					ConstPropertyUserStatus::Confirmed,
					ConstPropertyUserStatus::Arrived,
					ConstPropertyUserStatus::WaitingforReview,
					ConstPropertyUserStatus::Completed,
					ConstPropertyUserStatus::PaymentCleared
				)
			) ,
			'fields' => array(
				'SUM(PropertyUser.traveler_service_amount) as total_amount'
			) ,
		);
		$revenue_model_datas['Site Commission from Host'] = array(
			'display' => __l('Site Commission from Host') ,
			'model' => 'Transaction',
			'conditions' => array(
				'PropertyUser.is_payment_cleared' => 1
			) ,
			'fields' => array(
				'SUM(PropertyUser.host_service_amount) as total_amount'
			) ,
		);
        $chart_revenue_data = $this->_setLineData($select_var, $revenue_model_datas, 'PropertyUser', $common_conditions);
        $this->set('chart_revenue_data', $chart_revenue_data);
        $this->set('chart_revenue_data_periods', $revenue_model_datas);
        //
        $this->_setPropertyViews($select_var);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setPropertyViews($select_var)
    {
        $this->loadModel('PropertyView');
        $common_conditions = array();
         $property_view_model_datas['Property View'] = array(
            'display' => __l('Property View') ,
            'conditions' => array() ,
        );
        $chart_property_views_data = $this->_setLineData($select_var, $property_view_model_datas, array(
            'PropertyView'
        ) , 'PropertyView', $common_conditions);
        $this->set('chart_property_views_data', $chart_property_views_data);
    }
    public function admin_chart_users()
    {
        $this->initChart();
        $this->loadModel('User');
        if (isset($this->request->params['named']['user_type_id'])) {
            $this->request->data['Chart']['user_type_id'] = $this->request->params['named']['user_type_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if(isset($this->request->data['Chart']['is_ajax_load'])){
			$this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
		}
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $user_type_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['user_type_id'] = $user_type_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
               'User.is_facebook_register' => 0,
               'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_gmail_register' => 0,
                'User.is_yahoo_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('user.is_enable_openid') || Configure::read('user.is_enable_gmail_openid') || Configure::read('user.is_enable_yahoo_openid')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_gmail_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        if (Configure::read('affiliate.is_enabled')) {
            $_periods['Affiliate'] = array(
                'display' => __l('Affiliate') ,
                'conditions' => array(
                    'User.is_affiliate_user' => 1,
                )
            );
        }
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.user_type_id' => $user_type_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.user_type_id' => $user_type_id,
                'created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        unset($model_datas['Affiliate']);
        unset($model_datas['OpenID']);
        $_pie_data = $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                    'created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
                ));
                $new_conditions['User.user_type_id'] = $user_type_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
            // demographics
            $conditions = array(
                'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
                'User.user_type_id' => $user_type_id
            );
            $this->_setDemographics($total_users, $conditions);
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_user_logins()
    {
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['user_type_id'])) {
            $this->request->data['Chart']['user_type_id'] = $this->request->params['named']['user_type_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if(isset($this->request->data['Chart']['is_ajax_load'])){
			$this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
		}
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $user_type_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['user_type_id'] = $user_type_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_gmail_register' => 0,
                'User.is_yahoo_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('user.is_enable_openid') || Configure::read('user.is_enable_gmail_openid') || Configure::read('user.is_enable_yahoo_openid')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_gmail_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.user_type_id' => $user_type_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.user_type_id' => $user_type_id,
                'UserLogin.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'UserLogin.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        unset($model_datas['OpenID']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                    'UserLogin.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
                ));
                $new_conditions['User.user_type_id'] = $user_type_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    
    public function admin_chart_requests()
    {
        $this->loadModel('Request');
        $this->initChart();
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if(isset($this->request->data['Chart']['is_ajax_load'])){
			$this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
		}
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //# requests
        $conditions = array();
        $not_conditions = array();
        $request_model_datas['Enabled'] = array(
            'display' => __l('Enabled') ,
            'conditions' => array(
                'Request.is_active' => 1
            ) ,
        );
          $request_model_datas['Disabled'] = array(
            'display' => __l('Disabled') ,
            'conditions' => array(
                'Request.is_active' => 0
            ) ,
        );
        if (!Configure::read('request.is_auto_approve')) {
             $request_model_datas['Waiting for Approval'] = array(
				'display' => __l('Waiting for Approval') ,
				'conditions' => array(
					'Request.is_approved' => 0
				) ,
			 );
        }
        $common_conditions = array();
        $chart_requests_data = $this->_setLineData($select_var, $request_model_datas, 'Request', $common_conditions);
        $this->set('chart_requests_data', $chart_requests_data);
        $this->set('chart_requests_periods', $request_model_datas);
        $this->set('selectRanges', $this->selectRanges);
    }
    public function admin_chart_properties()
    {
        $this->initChart();
        $this->loadModel('Property');
        $this->loadModel('PropertyUserStatus');
        $this->loadModel('PropertyUserDisputes');
        $this->loadModel('DisputeStatus');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if(isset($this->request->data['Chart']['is_ajax_load'])){
			$this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
		}
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //#  Properties
         $property_model_datas['Enabled'] = array(
            'display' => __l('Enabled') ,
            'conditions' => array(
                'Property.is_active' => 1,
            ) ,
        );
		$property_model_datas['Disabled'] = array(
            'display' => __l('Disabled') ,
            'conditions' => array(
                'Property.is_active' => 0,
            ) ,
        );
        if (!Configure::read('property.is_auto_approve')) {
             $property_model_datas['Waiting for Approval'] = array(
				'display' => __l('Waiting for Approval') ,
				'conditions' => array(
					'Property.is_approved' => 0
				) ,
			 );
        }
		$property_model_datas['Imported from AirBnB'] = array(
            'display' => __l('Imported from AirBnB') ,
            'conditions' => array(
                'Property.is_imported_from_airbnb' => 1,
            ) ,
        );
		if (Configure::read('property.is_property_verification_enabled')) {
			$property_model_datas['Verified'] = array(
				'display' => __l('Verified') ,
				'conditions' => array(
					'Property.is_verified' => ConstVerification::Verified,
				) ,
			);
			$property_model_datas['Waiting for Verfication'] = array(
				'display' => __l('Waiting for Verfication') ,
				'conditions' => array(
					'Property.is_verified' => ConstVerification::WaitingForVerification,
				) ,
			);
		}
         //# property bookings
        $property_users_statuses = $this->PropertyUserStatus->find('all');
        foreach($property_users_statuses as $property_user_status){
        $property_user_model_datas[$property_user_status['PropertyUserStatus']['name']] = array(
            'display' => $property_user_status['PropertyUserStatus']['name'] ,
            'conditions' => array('PropertyUser.property_user_status_id'=>$property_user_status['PropertyUserStatus']['id']),
           );
          }
        //# property user disputes
        $property_user_dispute_statuses = $this->DisputeStatus->find('all');
        foreach($property_user_dispute_statuses as $property_dispute_status){
        $property_dispute_model_datas[$property_dispute_status['DisputeStatus']['name']] = array(
            'display' => $property_dispute_status['DisputeStatus']['name'] ,
            'conditions' => array('PropertyUserDispute.dispute_status_id'=>$property_dispute_status['DisputeStatus']['id']),
           );
         }
        $common_conditions = array();
        $chart_property_dispute_data = $this->_setLineData($select_var, $property_dispute_model_datas, 'PropertyUserDispute', $common_conditions);
        $this->set('chart_property_dispute_data', $chart_property_dispute_data);
        $this->set('chart_property_dispute_periods', $property_dispute_model_datas);
        $chart_properties_data = $this->_setLineData($select_var, $property_model_datas, 'Property', $common_conditions);
        $this->set('chart_properties_data', $chart_properties_data);
        $this->set('chart_properties_periods', $property_model_datas);
        $chart_property_user_status_data = $this->_setLineData($select_var, $property_user_model_datas, 'PropertyUser', $common_conditions);
        $this->set('chart_property_user_status_data', $chart_property_user_status_data);
        $this->set('chart_property_user_status_periods', $property_user_model_datas);
        $this->set('selectRanges', $this->selectRanges);
    }
     protected function _setDemographics($total_users, $conditions = array())
    {
        $this->loadModel('User');
        $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
             //# education
            $user_educations = $this->User->UserProfile->UserEducation->find('list', array(
                'conditions' => array(
                    'UserEducation.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.user_education_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->UserRelationship->find('list', array(
                'conditions' => array(
                    'UserRelationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.user_relationship_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->UserEmployment->find('list', array(
                'conditions' => array(
                    'UserEmployment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.user_employment_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->UserIncomeRange->find('list', array(
                'conditions' => array(
                    'UserIncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
             $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.user_incomerange_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.user_incomerange_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => __l('18 - 34 Yrs') ,
                '2' => __l('35 - 44 Yrs') ,
                '3' => __l('45 - 54 Yrs') ,
                '4' => __l('55+ Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 18;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 34;
                } elseif ($age_key == 2) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 35;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 44;
                } elseif ($age_key == 3) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 45;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 54;
                } elseif ($age_key == 4) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 55;
                } elseif ($age_key == 0) {
                    $new_conditions['UserProfile.dob'] = NULL;
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }

    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array())
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
            $model = $models;
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
            }
        }
        return $_data;
    }
	public function admin_chart_stats()
	{
	}
}
