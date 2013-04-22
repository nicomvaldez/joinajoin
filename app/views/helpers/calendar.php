<?php
class CalendarHelper extends Helper
{
    var $month_list = array(
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
    var $day_list = array(
        'Sun',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat'
    );
    var $helpers = array(
        'Html',
        'Form'
    );
    /**
     * Perpares a list of GET params that are tacked on to next/prev. links.
     * @retunr string - urlencoded GET params.
     */
    function getParams()
    {
        $params = array();
        foreach($this->params['url'] as $key => $val) if ($key != 'url') $params[] = urlencode($key) . '=' . urlencode($val);
        return (count($params) > 0 ? '?' . join('&', $params) : '');
    }
    /**
     * Generates a Calendar for the specified by the month and year params and populates it with the content of the data array
     *
     * @param $year string
     * @param $month string
     * @param $data array
     * @param $base_url
     * @return string - HTML code to display calendar in view
     *
     */
    function month($year = '', $month = '', $data = '', $base_url = '', $daysAvilable = '')
    {
        //to make the separation of date display with available and unavailable count
        $is_montly_available = 0;
        $days = array();
        $night_price = $data['night_price'];
        $weekly_price = $data['weekly_price'];
        $monthly_price = $data['monthly'];
        $property_id = $data['property_id'];
        unset($data['monthly']);
        unset($data['weekly_price']);
        unset($data['property_id']);
        unset($data['night_price']);
        $monthly_start_date = $year . '-' . $month . '-1';
        $month_start_date = date('Y-m-d', strtotime($monthly_start_date));
        $temmp = explode('-', $monthly_start_date);
        $month_end_date = date('Y-m-d', mktime(0, 0, 0, $temmp[1]+1, $temmp[2]-1, $temmp[0]));
        $count = count($data) -1;
		if (strtotime(date('Y-m-d')) < strtotime($month_start_date)) {
	        $monthly_color = '#98CF67';
		} else {
	        $monthly_color = '#F7F7F7';
		}
        for ($m = 0; $m < $count; $m++) {
			if (strtotime($month_start_date) > strtotime($data[$m]['start_date'])) {
				$start_date = date('M d,Y', strtotime($month_start_date));
				$data[$m]['start_date'] = $month_start_date;
			} else {
				$start_date = date('M d,Y', strtotime($data[$m]['start_date']));
			}
            $datecnt = explode('-', $data[$m]['start_date']);
			if (((int)$datecnt[1]) < $month) {
				 $start_date = date('M d,Y', mktime(0, 0, 0, $month, 1, $datecnt[0]));
				 $daycnt = 1;
			} else {
				 $daycnt = (int)$datecnt[2];
			}

            $end_date = date('M d,Y', strtotime($data[$m]['end_date']));
			 $ending_date = explode('-', $data[$m]['end_date']);
			if( ((int)$ending_date[1]) > $month  ){
				 $end_date = date('M d,Y', mktime(0, 0, 0, $month, 31, $ending_date[0]));
			}
            $strdate = strtotime($start_date);
            $enddate = strtotime($end_date);
            $numdays = intval(($enddate-$strdate) /86400) +1;
            $wk_cnt = 1;
            for ($k = 1; $k <= $numdays; $k++) {
                if (!empty($daycnt)) {
                    $wkcnt = $this->getWeekOfTheMonth($year, $month, $daycnt);
                    if (!empty($wkcnt)) {
                        $is_available = $data['week']['week' . $wkcnt]['is_available'];
                        if ((isset($data[$m]['is_custom_nights']) && ($data[$m]['is_custom_nights'] == 0)) || (isset($data[$m]['is_available']) && ($data[$m]['is_available'] == 0))) {
                            $is_available = 0;
                        }
						$is_booked = 0;
						if ((isset($data[$m]['is_custom_nights']) && ($data[$m]['is_custom_nights'] == 0))) {
							$is_booked = 1;
						}
                        $data['week']['week' . $wkcnt] = array(
                            'is_available' => $is_available,
                            'is_booked' => $is_booked,
                            'price' => $data['week']['week' . $wkcnt]['price'],
                            'start_date' => $data['week']['week' . $wkcnt]['start_date'],
                            'end_date' => $data['week']['week' . $wkcnt]['end_date'],
                        );
                    }
                    $wk_cnt++;
                }
                $temp_arr = array();
                if ($data[$m]['is_custom_nights']) {
                    if ($data[$m]['is_available']) {
	                    if ($data[$m]['pastdate'] && (date('Y-m-d', strtotime('now')) > date('Y-m-d', strtotime($month . '/' . $daycnt . '/' . $year)))) {
							$temp_arr['status'] = 'pastdate';
						} else {
	                        $temp_arr['status'] = 'available';
						}
                        $temp_arr['price'] = $data[$m]['price'];
                        $temp_arr['color'] = $data[$m]['color'];
                    } else {
                        $temp_arr['status'] = 'not-avilable';
                        $temp_arr['price'] = $data[$m]['price'];
                        $temp_arr['color'] = $data[$m]['color'];
                        $monthly_color = '#F7F7F7';
                    }
                } else {
                    $temp_arr['status'] = 'booked';
                    $temp_arr['price'] = $data[$m]['price'];
                    $temp_arr['color'] = $data[$m]['color'];
                    $monthly_color = '#FFA2B7';
                }
                if (empty($days[$daycnt])) {
                    $days[$daycnt++] = $temp_arr;
                }
            }
        }
        if (is_array($days)) {
            ksort($days);
        }
        ksort($data['week']);
        $data['days'] = $days;
        $str = '';
        $day = 1;
        $today = 0;
        $month = $this->month_list[$month-1];
        if ($year == '' || $month == '') { // just use current year & month
            $year = date('Y');
            $month = date('m');
        }
        $flag = 0;
        for ($i = 0; $i < 12; $i++) {
            //echo $month.' '.$this->month_list[$i].' '."<BR>";
            if (strtolower($month) == $this->month_list[$i]) {
                if (intval($year) != 0) {
                    $flag = 1;
                    $month_num = $i+1;
                    break;
                }
            }
        }
        $temp = array_flip($this->month_list);
        //$prev_month_mod = $temp[$prev_month] + 1;
        if ($flag == 0) {
            $year = date('Y');
            $month = date('F');
            $month_num = date('m');
        }
        $next_year = $year;
        $prev_year = $year;
        $next_month = intval($month_num) +1;
        $prev_month = intval($month_num) -1;
        if ($next_month == 13) {
            $next_month = 'january';
            $next_year = intval($year) +1;
        } else {
            $next_month = $this->month_list[$next_month-1];
        }
        if ($prev_month == 0) {
            $prev_month = 'december';
            $prev_year = intval($year) -1;
        } else {
            $prev_month = $this->month_list[$prev_month-1];
        }
        if ($year == date('Y') && strtolower($month) == strtolower(date('F'))) {
            // set the flag that shows todays date but only in the current month - not past or future...
            $today = date('j');
        }
        $calType = 'big-calendar round-5';
        $action = 'calendar';
        $days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
        $first_day_in_month = date('D', mktime(0, 0, 0, $month_num, 1, $year));
        $prev_num = $month_num-1;
        $next_num = $month_num-1;
        $str.= '<div class="hasDatepicker js-calender-permonth js-calender-form-calender" id="datepicker">';
        $str.= '<div class="' . $calType . '">';
        $str.= '<div class="calendar-month">';
        $temp = array_flip($this->month_list);
        $prev_month_mod = $temp[$prev_month]+1;
        $prev_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest',
            'month' => $prev_month_mod,
            'year' => $prev_year,
            'property_id' => $property_id,
        ) , true);
        $str.= "<span class='prev {\"url\":\"$prev_url\"} js-calender-prev ui-datepicker-prev ui-corner-all'>";
        $str.= 'Prev';
        $str.= '</span>';
        if ($monthly_color == '#98CF67') {
            $monthly_title = $this->Html->siteCurrencyFormat($monthly_price, false) . ' ' . __l('(Monthly Booking Price)');
        } elseif ($monthly_color == '#FFA2B7') {
            $monthly_title = 'Booked';
        } else {
            $monthly_title = 'Not available';
        }
        $str.= ' <div class="monthly-info" style="background:' . $monthly_color . '" title="' . $monthly_title . '"> <span class="ui-datepicker-month">' . ucfirst($month) . '</span> <span class="ui-datepicker-year ">' . $year . '</span>' . '<span class="js-monthstart-date" style="display:none;">' . $month_start_date . '</span><span class="js-monthend-date" style="display:none;">' . $month_end_date . '</span><div>';
        $next_month_mod = $temp[$next_month]+1;
        $next_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest',
            'month' => $next_month_mod,
            'year' => $next_year,
            'property_id' => $property_id,
        ) , true);
        $str.= " <span class='next {\"url\":\"$next_url\"} js-calender-next ui-datepicker-next ui-corner-all'>";
        $str.= 'Next';
        $str.= '</span></div>';
        $str.= '</div>';
        $str.= '<table>';
        $str.= '<thead>';
        $str.= '<tr>';
        //$str.= '<th colspan="2" class="calendar-head">Week</th>';
        for ($i = 0; $i < 7; $i++) {
            $str.= '<th class="calendar-head">' . substr($this->day_list[$i], 0, 2) . '</th>';
        }
        $str.= '</tr>';
        $str.= '</thead>';
        $str.= '<tbody>';
        $cnt = 0;
        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
        while ($day <= $days_in_month) {
            $is_booked = 0;
            $cnt++;
            $str.= '<tr>';
            $title = '';
            if (isset($data['week']['week' . $cnt]['is_available'])) {
                if ($data['week']['week' . $cnt]['is_available'] == 0) {
					if ($data['week']['week' . $cnt]['is_booked'] == 1) {
						$classbooked = 'booked-week';
						$metadata = ' booked {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'booked\', \'week\': \'' . $cnt . '\', \'title\': \'Booked\'}';
						$title = 'Booked';
					} else {
						$classbooked = 'notavailable-week';
						$metadata = ' pastweek {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'postweek\', \'week\': \'' . $cnt . '\', \'title\': \'Not Available\'}';
						$title = 'Not Available';
					}
                } else if ($data['week']['week' . $cnt]['is_available'] == 1) {
                    $classbooked = 'not-booked-week';
                    $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $cnt . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                    $title = $data['week']['week' . $cnt]['price'];
                    if ((!empty($data['week']['week' . $cnt]['price']))) {
                        if ($data['week']['week' . $cnt]['price'] > $weekly_price) {
                            $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $cnt . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                            $title = $data['week']['week' . $cnt]['price'];
                        } else if ($data['week']['week' . $cnt]['price'] < $weekly_price) {
                            $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $cnt . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                        }
                    }
                } else {
                    $classbooked = 'notavailable-week';
                    $metadata = ' pastweek {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'postweek\', \'week\': \'' . $cnt . '\', \'title\': \'Not Available\'}';
                    $title = 'Not Available';
                }
            }
            //$str.= '<td id="week-' . $cnt . '" class="week-' . $cnt . ' ' . $classbooked . ' js-week-booking js-month-booking ' . $metadata . '" title="' . $title . '" >W' . $cnt  . '</td>';
            //$str.= '<td class="week-list">&nbsp;</td>';
            $class_js = '';
            for ($i = 0; $i < 7; $i++) {
                $cell = '&nbsp;';
                $onClick = $class = $style = $title = $temp_flag = '';
                $is_start_date = 0;
                $is_end_date = 0;
                if ($i > 4) {
                    $class = ' class="ui-datepicker-week-end" ';
                }
                $class = $calType;

//************************************ agrego funcion de dias Not Available ***********************************//

                //debug($daysAvilable);
                //pr( Debugger::trace() );


                //separo los valores del string

                $days_availabel = explode("-", $daysAvilable['Properties_day']['days_texts']);

                $day_provider_work = true;

                if(!in_array($i, $days_availabel)){
                    $class = 'js-disable_monthly pastdate big-calendar round-5';
                    $day_provider_work = false;
                    $data['days'][$day]['status'] = 'not-avilable';
                }


//************************************************************************************************************//
                if ($day == $today) {
                    $class.= ' cal-today';
                    $temp_flag = 1;
                } else {
                    $temp_flag = 0;
                }
                if (isset($data['days'][$day])) {
                    if (is_array($data['days'][$day])) {
                        if (isset($data['days'][$day]['onClick'])) {
                            $onClick = ' onClick="' . $data['days'][$day]['onClick'] . '"';
                            $style = ' style="cursor:pointer;"';
                        }
                    } else $cell = $data['days'][$day];
                }
                if (($first_day_in_month == $this->day_list[$i] || $day > 1) && ($day <= $days_in_month)) {
                    $percen = '';
                    $color_percent = '';
                    $passDate = $day;
                    if ($day < 10) {
                        $passDate = '0' . $day;
                    }
                    $passMonth = $month_num;
                    if ($passMonth < 10) {
                        $passMonth = '0' . $passMonth;
                    }
                    if ($day == '01') {
                        $day = '1';
                    }
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
                        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
                        $title = '';
						$price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
						$class.= ' ' . $data['days'][$day]['status'];
						if ($data['days'][$day]['status'] == 'available') {
							$color_percentage = $this->convertColor($price, $night_price);
							$class.= $color_percentage . ' available';
						}
                        if ($data['days'][$day]['status'] == 'booked') {
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'booked\', \'title\': \'booked\', \'cell\': \'' . $day . '\'}';
                            $title = 'Booked';
                        } else if ($data['days'][$day]['status'] == 'available') {
                            $title = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $day . '\'} ';
                            if (empty($temp_flag)) {
                                if ((!empty($data['days'][$day]['price']))) {
									$metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $day . '\'} ';
                                }
                            }
                        } else if ($data['days'][$day]['status'] == 'not-avilable') {
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'not-avilable\', \'title\': \'Not available\', \'cell\': \'' . $day . '\'}';
                            $title = 'Not available';
                        } else {
                            $title = 'Not available';
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'pastdate\', \'title\': \'' . $title . '\', \'cell\': \'' . $day . '\'}';
                            $class.= ' js-disable_monthly pastdate';
                        }
                        $is_montly_available = 1;
                        $class_js = 'js-disable_monthly';
                    } else {
                        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
                        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
                        if ($current_date <= $calender_date) {
                            $title = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $day . '\'} ';
                            $class.= ' available';
                            if (empty($temp_flag)) {
                                if ((!empty($data['days'][$day]['price']))) {
									$metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $day . '\'} ';
                                }
                            }
                        } else {
                            $title = 'Not available';
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'pastdate\', \'title\': \'' . $title . '\', \'cell\': \'' . $day . '\'}';
                            $class.= ' js-disable_monthly pastdate';
                        }
                    }
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $price = '';
                    } else if (isset($data['days'][$day])) {
                        $price = $data['days'][$day];
                    } else {
                        $price = '';
                    }
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $is_booked = 1;
                    }
                    $str.= '<td class=" js-month-booking js-day-booking cell-' . $day . ' ' . $metadata . $class . '" id="cell-' . $day . '" title="' . $title . '">' . $day ;
                    $str.= '</td>';
                    $day++;
                } else {
                    $str.= '<td class="' . $class . '">&nbsp;</td>';
                }
            }//fin for
            if ($is_booked == 1) {
                $classbooked = 'booked-week';
            } else {
                $classbooked = 'not-booked-week';
            }
            $str.= '</tr>';
        }
        $str.= '</tbody>';
        $str.= '</table>';
        $str.= '</div>';
        $str.= '</div>';
        $str.= '</div>';
        return $str;
    }
    /**
     * Generates a Calendar for the week specified by the day, month and year params and populates it with the content of the data array
     *
     * @param $year string
     * @param $month string
     * @param $day string
     * @param $data array[day][hour]
     * @param $base_url
     * @return string - HTML code to display calendar in view
     *
     */
    function week($year = '', $month = '', $day = '', $data = '', $base_url = '', $min_hour = 8, $max_hour = 24)
    {
        $str = '';
        $today = 0;
        if ($year == '' || $month == '') { // just use current yeear & month
            $year = date('Y');
            $month = date('F');
            $day = date('d');
            $month_num = date('m');
        }
        $flag = 0;
        for ($i = 0; $i < 12; $i++) {
            if (strtolower($month) == $this->month_list[$i]) {
                if (intval($year) != 0) {
                    $flag = 1;
                    $month_num = $i+1;
                    break;
                }
            }
        }
        if ($flag == 1) {
            $days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
            if ($day <= 0 || $day > $days_in_month) $flag = 0;
        }
        if ($flag == 0) {
            $year = date('Y');
            $month = date('F');
            $month_num = date('m');
            $day = date('d');
            $days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
        }
        $next_year = $year;
        $prev_year = $year;
        $next_month = intval($month_num);
        $prev_month = intval($month_num);
        $next_week = intval($day) +7;
        $prev_week = intval($day) -7;
        if ($next_week > $days_in_month) {
            $next_week = $next_week-$days_in_month;
            $next_month++;
        }
        if ($prev_week <= 0) {
            $prev_month--;
            $prev_week = date('t', mktime(0, 0, 0, $prev_month, $year)) +$prev_week;
        }
        $next_month_num = null;
        if ($next_month == 13) {
            $next_month_num = 1;
            $next_month = 'january';
            $next_year = intval($year) +1;
        } else {
            $next_month_num = $next_month;
            $next_month = $this->month_list[$next_month-1];
        }
        $prev_month_num = null;
        if ($prev_month == 0) {
            $prev_month_num = 12;
            $prev_month = 'december';
            $prev_year = intval($year) -1;
        } else {
            $prev_month_num = $prev_month;
            $prev_month = $this->month_list[$prev_month-1];
        }
        if ($year == date('Y') && strtolower($month) == strtolower(date('F'))) {
            // set the flag that shows todays date but only in the current month - not past or future...
            $today = date('j');
        }
        //count back day until its monday
        while (date('D', mktime(0, 0, 0, $month_num, $day, $year)) != 'Mon') $day--;
        $title = '';
        if ($day+6 > $days_in_month) {
            if ($next_month == 'january') $title = ucfirst($month) . ' ' . $year . ' / ' . ucfirst($next_month) . ' ' . ($year+1);
            else $title = ucfirst($month) . '/' . ucfirst($next_month) . ' ' . $year;
        } else $title = ucfirst($month) . ' ' . $year;
        $str.= '<table class="calendar">';
        $str.= '<thead>';
        $str.= '<tr><th class="cell-prev">';
        $str.= $this->Html->link(__l('prev', true) , array(
            'controller' => 'properties',
            'action' => 'property_calendar',
            $prev_month,
            $prev_week,
            $this->getParams()
        ));
        $str.= '</th><th colspan="5">' . $title . '</th><th class="cell-next">';
        $str.= $this->Html->link(__l('next', true) , array(
            'controller' => 'properties',
            'action' => 'property_calendar',
            $next_year,
            $next_month,
            $next_week . $this->getParams()
        ));
        $str.= '</th></tr>';
        $str.= '<tr>';
        for ($i = 0; $i < 7; $i++) {
           	$offset = 0;
            if ($day+$i > $days_in_month) $offset = $days_in_month;
            else if ($day+$i < 1) $offset = -date('t', mktime(1, 1, 1, $prev_month_num, 1, $prev_year));
            $str.= '<th class="cell-header">' . $this->day_list[$i] . '<br/>' . ($day+$i-$offset) . '</th>';
        }
        $str.= '</tr>';
        $str.= '</thead>';
        $str.= '<tbody>';
        for ($hour = $min_hour; $hour < $max_hour; $hour++) {
            $str.= '<tr>';
            for ($i = 0; $i < 7; $i++) {
                $offset = 0;
                if ($day+$i > $days_in_month) $offset = $days_in_month;
                else if ($day+$i < 1) $offset = -date('t', mktime(1, 1, 1, $prev_month_num, 1, $prev_year));
                $cell = '';
                $onClick = '';
                $style = '';
                $class = '';
                if ($i > 4) {
                    $class = ' class="cell-weekend" ';
                }
                if (($day+$i) == $today && $month_num == date('m') && $year == date('Y')) {
                    $class = ' class="cell-today" ';
                }
                if (isset($data[$day+$i-$offset][$hour])) {
                    if (is_array($data[$day+$i-$offset][$hour])) {
                        if (isset($data[$day+$i-$offset][$hour]['onClick'])) {
                            $onClick = ' onClick="' . $data[$day+$i-$offset][$hour]['onClick'] . '"';
                            $style = ' style="cursor:pointer;"';
                        }
                        if (isset($data[$day+$i-$offset][$hour]['content'])) $cell = $data[$day+$i-$offset][$hour]['content'];
                        if (isset($data[$day+$i-$offset][$hour]['class'])) $class = ' class="' . $data[$day+$i-$offset][$hour]['class'] . '"';
                    } else $cell = $data[$day+$i-$offset][$hour];
                }
                $str.= '<td ' . $class . $onClick . $style . ' id="cell-' . ($day+$i-$offset) . '-' . $hour . '"><div class="week-cell-number">' . $hour . ':00' . '</div><div class="cell-data">' . $cell . '</div></td>';
            }
            $str.= '</tr>';
        }
        $str.= '</tbody>';
        $str.= '</table>';
        return $str;
    }
    function getWeekOfTheMonth($year = 2007, $month = 5, $day = 5)
    {
        return ceil(($day+date("w", mktime(0, 0, 0, $month, 1, $year))) /7);
    }
    function dateDiff($date1, $date2)
    {
        $dateDiff = $date1-$date2;
        $fullDays = floor($dateDiff/(60*60*24));
        return $fullDays;
    }
    /**
     * Generates a Calendar for the specified by the month and year params and populates it with the content of the data array
     *
     * @param $year string
     * @param $month string
     * @param $data array
     * @param $base_url
     * @return string - HTML code to display calendar in view
     *
     */
    function guest_list_month($year = '', $month = '', $data = '', $starting_date = array(), &$week_start = 1)
    {
        //to make the separation of date display with available and unavailable count
        $is_montly_available = 0;
        $days = array();
        $night_price = $data['night_price'];
        $weekly_price = $data['weekly_price'];
        $monthly_price = $data['monthly'];
        $property_id = $data['property_id'];
        unset($data['monthly']);
        unset($data['weekly_price']);
        unset($data['property_id']);
        unset($data['night_price']);
        $monthly_start_date = $year . '-' . $month . '-1';
        $month_start_date = date('Y-m-d', strtotime($monthly_start_date));
        $temmp = explode('-', $monthly_start_date);
        $month_end_date = date('Y-m-d', mktime(0, 0, 0, $temmp[1]+1, $temmp[2]-1, $temmp[0]));
        $count = count($data) -1;
        if (strtotime(date('Y-m-d')) < strtotime($month_start_date)) {
	        $monthly_color = '#98CF67';
		} else {
	        $monthly_color = '#F7F7F7';
		}
        for ($m = 0; $m < $count; $m++) {
			if (strtotime($month_start_date) > strtotime($data[$m]['start_date'])) {
				$start_date = date('M d,Y', strtotime($month_start_date));
				$data[$m]['start_date'] = $month_start_date;
			} else {
				$start_date = date('M d,Y', strtotime($data[$m]['start_date']));
			}
            $datecnt = explode('-', $data[$m]['start_date']);
			if (((int)$datecnt[1]) < $month) {
				 $start_date = date('M d,Y', mktime(0, 0, 0, $month, 1, $datecnt[0]));
				 $daycnt = 1;
			} else {
				 $daycnt = (int)$datecnt[2];
			}

            $end_date = date('M d,Y', strtotime($data[$m]['end_date']));
			 $ending_date = explode('-', $data[$m]['end_date']);
			if( ((int)$ending_date[1]) > $month  ){
				 $end_date = date('M d,Y', mktime(0, 0, 0, $month, 31, $ending_date[0]));
			}
            $strdate = strtotime($start_date);
            $enddate = strtotime($end_date);
            $numdays = intval(($enddate-$strdate) /86400) +1;
            $wk_cnt = 1;
            for ($k = 1; $k <= $numdays; $k++) {
                if (!empty($daycnt)) {
                    $wkcnt = $this->getWeekOfTheMonth($year, $month, $daycnt);
                    if (!empty($wkcnt)) {
                        $is_available = $data['week']['week' . $wkcnt]['is_available'];
                        if ((isset($data[$m]['is_custom_nights']) && ($data[$m]['is_custom_nights'] == 0)) || (isset($data[$m]['is_available']) && ($data[$m]['is_available'] == 0))) {
                            $is_available = 0;
                        }
						$is_booked = 0;
						if ((isset($data[$m]['is_custom_nights']) && ($data[$m]['is_custom_nights'] == 0))) {
							$is_booked = 1;
						}
                        $data['week']['week' . $wkcnt] = array(
                            'is_available' => $is_available,
							'is_booked' => $is_booked,
                            'price' => $data['week']['week' . $wkcnt]['price'],
                            'start_date' => $data['week']['week' . $wkcnt]['start_date'],
                            'end_date' => $data['week']['week' . $wkcnt]['end_date'],
                        );
                    }
                    $wk_cnt++;
                }
                $temp_arr = array();
                if ($data[$m]['is_custom_nights']) {
                    if ($data[$m]['is_available']) {
                        if ($data[$m]['pastdate'] && (date('Y-m-d', strtotime('now')) > date('Y-m-d', strtotime($month . '/' . $daycnt . '/' . $year)))) {
							$temp_arr['status'] = 'pastdate';
						} else {
	                        $temp_arr['status'] = 'available';
						}
                        $temp_arr['price'] = $data[$m]['price'];
                        $temp_arr['color'] = $data[$m]['color'];
                    } else {
                        $temp_arr['status'] = 'not-avilable';
                        $temp_arr['price'] = $data[$m]['price'];
                        $temp_arr['color'] = $data[$m]['color'];
                        $monthly_color = '#F7F7F7';
                    }
                } else {
                    $temp_arr['status'] = 'booked';
                    $temp_arr['price'] = $data[$m]['price'];
                    $temp_arr['color'] = $data[$m]['color'];
                    $monthly_color = '#FFA2B7';
                }
                if (empty($days[$daycnt])) {
                    $days[$daycnt++] = $temp_arr;
                }
            }
        }
        if (is_array($days)) {
            ksort($days);
        }
        ksort($data['week']);
        $data['days'] = $days;
        $str = '';
        $day = 1;
        $today = 0;
        $month = $this->month_list[$month-1];
        if ($year == '' || $month == '') { // just use current year & month
            $year = date('Y');
            $month = date('m');
        }
        $flag = 0;
        for ($i = 0; $i < 12; $i++) {
            if (strtolower($month) == $this->month_list[$i]) {
                if (intval($year) != 0) {
                    $flag = 1;
                    $month_num = $i+1;
                    break;
                }
            }
        }
        $temp = array_flip($this->month_list);
        //$prev_month_mod = $temp[$prev_month] + 1;
        if ($flag == 0) {
            $year = date('Y');
            $month = date('F');
            $month_num = date('m');
        }
        $next_year = $year;
        $prev_year = $year;
        $next_month = intval($month_num) +1;
        $prev_month = intval($month_num) -1;
        if ($next_month == 13) {
            $next_month = 'january';
            $next_year = intval($year) +1;
        } else {
            $next_month = $this->month_list[$next_month-1];
        }
        if ($prev_month == 0) {
            $prev_month = 'december';
            $prev_year = intval($year) -1;
        } else {
            $prev_month = $this->month_list[$prev_month-1];
        }
        if ($year == date('Y') && strtolower($month) == strtolower(date('F'))) {
            // set the flag that shows todays date but only in the current month - not past or future...
            $today = date('j');
        }
        $calType = 'big-calendar';
        $action = 'calendar';
        $days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
        $first_day_in_month = date('D', mktime(0, 0, 0, $month_num, 1, $year));
        $prev_num = $month_num-1;
        $next_num = $month_num-1;
        $str.= '<div class="hasDatepicker js-calender-permonth" id="datepicker">';
        $str.= '<div class="' . $calType . '">';
        $str.= '<div class="calendar-month">';
        $temp = array_flip($this->month_list);
        $prev_month_mod = $temp[$prev_month]+1;
        $prev_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest_list',
            'month' => $prev_month_mod,
            'year' => $prev_year,
            'property_id' => $property_id,
        ) , true);
        if ($monthly_color == '#98CF67') {
            $monthly_title = $this->Html->siteCurrencyFormat($monthly_price, false) . ' ' . __l('(Monthly Booking Price)');
        } elseif ($monthly_color == '#FFA2B7') {
            $monthly_title = 'Booked';
        } else {
            $monthly_title = 'Not available';
        }
        $str.= ' <div class="monthly-info" style="background:' . $monthly_color . '" title="' . $monthly_title . '"> <span class="ui-datepicker-month">' . ucfirst($month) . '</span> <span class="ui-datepicker-year ">' . $year . '</span>' . '<span class="js-monthstart-date" style="display:none;">' . $month_start_date . '</span><span class="js-monthend-date" style="display:none;">' . $month_end_date . '</span><div>';
        $next_month_mod = $temp[$next_month]+1;
        $next_url = Router::url(array(
            'controller' => 'properties',
            'action' => 'calendar',
            'guest_list',
            'month' => $next_month_mod,
            'year' => $next_year,
            'property_id' => $property_id,
        ) , true);
	      $str .= '</div>';
        $str.= '</div>';
        $str.= '<table>';
        $str.= '<thead>';
        $str.= '<tr>';
		//$str.= '<th colspan="2" class="calendar-head">Week</th>';
        for ($i = 0; $i < 7; $i++) {
            $str.= '<th class="calendar-head">' . substr($this->day_list[$i], 0, 2) . '</th>';
        }
        $str.= '</tr>';
        $str.= '</thead>';
        $str.= '<tbody>';
        $cnt = 0;
        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
        while ($day <= $days_in_month) {
            $is_booked = 0;
            $cnt++;
            $str.= '<tr>';
            $title = '';
			$current_week_no = $week_start;
			$week_start++;
            if (isset($data['week']['week' . $cnt]['is_available'])) {
                if ($data['week']['week' . $cnt]['is_available'] == 0) {
                    if ($data['week']['week' . $cnt]['is_booked'] == 1) {
						$classbooked = 'booked-week';
						$metadata = ' booked {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'booked\', \'week\': \'' . $cnt . '\', \'title\': \'Booked\'}';
						$title = 'Booked';
					} else {
						$classbooked = 'notavailable-week';
						$metadata = ' pastweek {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'postweek\', \'week\': \'' . $cnt . '\', \'title\': \'Not Available\'}';
						$title = 'Not Available';
					}
                } else if ($data['week']['week' . $cnt]['is_available'] == 1) {
                    $classbooked = 'not-booked-week';
                    $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $current_week_no . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                    $title = $data['week']['week' . $cnt]['price'];
                    if ((!empty($data['week']['week' . $cnt]['price']))) {
                        if ($data['week']['week' . $cnt]['price'] > $weekly_price) {
                            $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $current_week_no . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                            $title = $data['week']['week' . $cnt]['price'];
                        } else if ($data['week']['week' . $cnt]['price'] < $weekly_price) {
                            $metadata = ' available {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'available\', \'week\': \'' . $current_week_no . '\', \'title\': \'' . $data['week']['week' . $cnt]['price'] . '\'}';
                        }
                    }
                } else {
                    $classbooked = 'notavailable-week';
                    $metadata = ' pastweek {\'start_date\': \'' . $data['week']['week' . $cnt]['start_date'] . '\', \'end_date\': \'' . $data['week']['week' . $cnt]['end_date'] . '\', \'price\': \'' . $data['week']['week' . $cnt]['price'] . '\', \'status\': \'postweek\', \'week\': \'' . $current_week_no . '\', \'title\': \'Not Available\'}';
                    $title = 'Not Available';
                }
            }
            //$str.= '<td id="guest-week-' . $current_week_no . '" class="guest-week-' . $current_week_no . ' ' . $classbooked . ' js-guest-week-booking js-month-booking ' . $metadata . '" title="' . $title . '">W' . $cnt .  '</td>';
            $str.= '<td class="week-list">&nbsp;</td>';

            $class_js = '';

            for ($i = 0; $i < 7; $i++) {
                $cell = '&nbsp;';
                $onClick = $class = $style = $title = $temp_flag = '';
                $is_start_date = 0;
                $is_end_date = 0;
                if ($i > 4) {
                    $class = ' class="ui-datepicker-week-end" ';
                }
                $class = $calType;
                if ($day == $today) {
                    $class.= ' cal-today';
                    $temp_flag = 1;
                } else {
                    $temp_flag = 0;
                }
                if (isset($data['days'][$day])) {
                    if (is_array($data['days'][$day])) {
                        if (isset($data['days'][$day]['onClick'])) {
                            $onClick = ' onClick="' . $data['days'][$day]['onClick'] . '"';
                            $style = ' style="cursor:pointer;"';
                        }
                    } else $cell = $data['days'][$day];
                }
                if (($first_day_in_month == $this->day_list[$i] || $day > 1) && ($day <= $days_in_month)) {
                    $percen = '';
                    $color_percent = '';
                    $passDate = $day;
                    if ($day < 10) {
                        $passDate = '0' . $day;
                    }
                    $passMonth = $month_num;
                    if ($passMonth < 10) {
                        $passMonth = '0' . $passMonth;
                    }
                    if ($day == '01') {
                        $day = '1';
                    }
                    $date1 = mktime(0, 0, 0, $starting_date['month'], $starting_date['date'], $starting_date['year']); //$start_date
                    $date2 = mktime(0, 0, 0, $month_num, $day, $year);
                    $diff_date = $this->dateDiff($date2, $date1);
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
                        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
                        $title = '';
						$price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
						$class.= ' ' . $data['days'][$day]['status'];
						if ($data['days'][$day]['status'] == 'available') {
							$color_percentage = $this->convertColor($price, $night_price);
							$class.= $color_percentage . ' available';
						}
                        if ($data['days'][$day]['status'] == 'booked') {
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'booked\', \'title\': \'booked\', \'cell\': \'' . $diff_date . '\'}';
                            $title = 'Booked';
                        } else if ($data['days'][$day]['status'] == 'available') {
                            $title = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $diff_date . '\'} ';
                            if (empty($temp_flag)) {
                                if ((!empty($data['days'][$day]['price']))) {
									$metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $diff_date . '\'} ';
                                }
                            }
                        } else if ($data['days'][$day]['status'] == 'not-avilable') {
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'not-avilable\', \'title\': \'Not available\', \'cell\': \'' . $diff_date . '\'}';
                            $title = 'Not available';
                        } else {
                            $title = 'Not available';
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'pastdate\', \'title\': \'' . $title . '\', \'cell\': \'' . $diff_date . '\'}';
                            $class.= ' js-disable_monthly pastdate';
                        }
                        $is_montly_available = 1;
                        $class_js = 'js-disable_monthly';
                    } else {
                        $current_date = strtotime(date('M d,Y', mktime(0, 0, 0, date("m") , date("d") , date("Y"))));
                        $calender_date = strtotime(date('M d,Y', mktime(0, 0, 0, date($month_num) , date($day) , date($year))));
                        if ($current_date <= $calender_date) {
                            $title = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $price = (!empty($data['days'][$day]['price'])) ? $data['days'][$day]['price'] : $night_price;
                            $metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $diff_date . '\'} ';
                            $class.= ' available';
                            if (empty($temp_flag)) {
                                if ((!empty($data['days'][$day]['price']))) {
									$metadata = ' {\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'available\', \'title\': \'' . $title . '\', \'price\': \'' . $price . '\', \'cell\': \'' . $diff_date . '\'} ';
                                }
                            }
                        } else {
                            $title = 'Not available';
                            $metadata = '{\'month\': \'' . date($month_num) . '\', \'year\': \'' . date($year) . '\', \'date\': \'' . date($day) . '\', \'status\': \'pastdate\', \'title\': \'' . $title . '\', \'cell\': \'' . $diff_date . '\'}';
                            $class.= ' js-disable_monthly pastdate';
                        }
                    }
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $price = '';
                    } else if (isset($data['days'][$day])) {
                        $price = $data['days'][$day];
                    } else {
                        $price = '';
                    }
                    if (isset($data['days'][$day]) && !empty($data['days'][$day])) {
                        $is_booked = 1;
                    }
                    $str.= '<td class=" js-month-booking js-guest-day-booking guest-cell-' . $diff_date . ' ' . $metadata . $class . '" id="guest-cell-' . $diff_date . '"  title="' . $title . '">' . $day ;

                    $str.= '</td>';
                    $day++;
                } else {
                    $str.= '<td class="' . $class . '">&nbsp;</td>';
                }
            }
            if ($is_booked == 1) {
                $classbooked = 'booked-week';
            } else {
                $classbooked = 'not-booked-week';
            }
            $str.= '</tr>';
        }
        $str.= '</tbody>';
        $str.= '</table>';
        $str.= '</div>';
        $str.= '</div>';
        $str.= '</div>';
        return $str;
    }
    function convertColor($today, $night_price)
    {
		if ($today != $night_price) {
			if ($today > $night_price) {
				$return = floor(((($today - $night_price) * 100) / $night_price) / 10);
				if ($return > 10) {
					$return = 10;
				}
				return $return;
			} else {
				$return = floor(((($night_price - $today) * 100) / $night_price) / 10);
				if ($return > 10) {
					$return = 10;
				}
				return -$return;
			}
		}
        return false;
    }
}
?>