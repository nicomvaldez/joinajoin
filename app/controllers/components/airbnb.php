<?php
class AirbnbComponent extends Component
{
	var $mapping = array(
		'amenities' => array(
			'11' => '1', // Smoking Allowed
			'12' => '2', // Pets Allowed
			'1' => '3', // TV
			'2' => '4', // Cable TV
			'3' => '5', // Internet
			'4' => '6', // Wireless Internet
			'5' => '7', // Air Conditioning
			'30' => '8', // Heating
			'21' => '9', // Elevator in Building
			'6' => '10', // Handicap Accessible
			'7' => '11', // Pool
			'8' => '12', // Kitchen
			'9' => '13', // Parking Included
			'13' => '14', // Washer / Dryer
			'14' => '15', // Doorman
			'15' => '16', // Gym
			'25' => '17', // Hot Tub
			'27' => '18', // Indoor Fireplace
			'28' => '19', // Buzzer/Wireless Intercom
			'16' => '20', // Breakfast
			'31' => '21', // Family/Kid Friendly
			'32' => '22', // Suitable for Events
		) ,
		'property_types' => array(
			'1' => '1', // Apartment
			'2' => '2', // House
			'3' => '3', // Bed & Breakfast
			'4' => '4', // Cabin
			'11' => '5', // Villa
			'5' => '6', // Castle
			'9' => '7', // Dorm
			'6' => '8', // Treehouse
			'8' => '9', // Boat
			'7' => '10', // Automobile
			'12' => '11', // lgloo
			'10' => '12', // Lighthouse
		) ,
		'room_types' => array(
			'Private room' => '1', // Private room
			'Shared room' => '2', // Shared room
			'Entire home/apt' => '3', // Entire room
		) ,
		'bed_types' => array(
			'Airbed' => '1', // Airbed
			'Futon' => '2', // Futon
			'Pull-out Sofa' => '3', // Pull-out sofa
			'Couch' => '4', // Couch
			'Real Bed' => '5', // Real bed
		) ,
		'size' => array(
			'true' => '1', // Square Feet
			'false' => '2', // Square Meters
		) ,
		'cancellation_policy' => array(
			'3' => '1', // Flexible
			'4' => '2', // Moderate
			'5' => '3', // Strict
		)
	);
	public function import($data, $step, $importedProperties)
	{
		set_time_limit(0);
		App::import('Model', 'Property');
        $this->Property = new Property();
		$post_variable = 'email=' . urlencode($data['Property']['airbnb_email']) . '&password=' . $data['Property']['airbnb_password'];
		$this->_curlGetURL('http://www.airbnb.com/authenticate', $post_variable, true);
		if ($step == 1) {
			$rooms = $this->_curlGetURL('http://www.airbnb.com/rooms');
			preg_match_all('/<h3><a href="\/rooms\/(\d+)">(.*)<\/a><\/h3>/', $rooms, $matches);
			$properties = array();
			if (!empty($matches[1])) {
				$i = 0;
				foreach($matches[1] as $match) {
					$properties[$i]['Property']['id'] = $matches[1][$i];
					$properties[$i]['Property']['title'] = $matches[2][$i];
					$i++;
				}
			}
			return $properties;
		} elseif ($step == 2) {
			$return = array();
			unset($data['Property']['airbnb_email']);
			unset($data['Property']['airbnb_password']);
			unset($data['Property']['step2']);
			foreach($data['Property'] as $id => $is_checked) {
				if (!empty($is_checked['id'])) {
					if (!in_array($id, array_values($importedProperties))) {
						$_data = array();
						// @todo active, inactive
						$room_details = $this->_curlGetURL('http://www.airbnb.com/rooms/' . $id . '/edit');
						preg_match('/<label for="hosting_property_type_id">.*<\/label>.*<select.*id="hosting_property_type_id".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $room_details, $property_type);
						if (!empty($property_type[1])) {
							$_data['Property']['property_type_id'] = $this->mapping['property_types'][$property_type[1]];
						}
						preg_match('/<label for="hosting_room_type">.*<\/label>.*<select.*id="hosting_room_type".*>.*value="([a-zA-Z -]+)" selected="selected">\s*.*<\/select>/msU', $room_details, $room_type);
						if (!empty($room_type[1])) {
							$_data['Property']['room_type_id'] = $this->mapping['room_types'][$room_type[1]];
						}
						preg_match('/<input.*id="hosting_descriptions_en_name".*value="(.*)".*\/>/', $room_details, $title);
						if (!empty($title[1])) {
							$_data['Property']['title'] = $title[1];
						}
						preg_match('/<textarea.*id="hosting_descriptions_en_description".*>(.*)<\/textarea>/', $room_details, $description);
						if (!empty($description[1])) {
							$_data['Property']['description'] = $description[1];
						}
						preg_match_all('/<input value="(.*)" id="amenity_.*" name="amenities\[\]" type="checkbox" checked\/>/', $room_details, $amenities);
						if (!empty($amenities[1])) {
							$new_amenities_arr = array();
							foreach($amenities[1] as $amenity) {
								$new_amenities_arr[] = $this->mapping['amenities'][$amenity];
							}
							$_data['Amenity']['Amenity'] = $new_amenities_arr;
						}
						preg_match('/<label for="hosting_person_capacity">.*<\/label>.*<select.*id="hosting_person_capacity".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $room_details, $accommodates);
						if (!empty($accommodates[1])) {
							$_data['Property']['accommodates'] = $accommodates[1];
						}
						preg_match('/<label for="hosting_bedrooms">.*<\/label>.*<select.*id="hosting_bedrooms".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $room_details, $bed_rooms);
						if (!empty($bed_rooms[1])) {
							$_data['Property']['bed_rooms'] = $bed_rooms[1];
						}
						preg_match('/<label for="hosting_beds">.*<\/label>.*<select.*id="hosting_beds".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $room_details, $beds);
						if (!empty($beds[1])) {
							$_data['Property']['beds'] = $beds[1];
						}
						preg_match('/<label for="hosting_bed_type">.*<\/label>.*<select.*id="hosting_bed_type".*>.*value="([a-zA-Z -]+)" selected="selected">\s*.*<\/select>/msU', $room_details, $bed_type);
						if (!empty($bed_type[1])) {
							$_data['Property']['bed_type_id'] = $this->mapping['bed_types'][$bed_type[1]];
						}
						preg_match('/<label for="hosting_bathrooms">.*<\/label>.*<select.*id="hosting_bathrooms".*>.*value="([\d\.]+)" selected="selected">\s*.*<\/select>/msU', $room_details, $bath_rooms);
						if (!empty($bath_rooms[1])) {
							$_data['Property']['bath_rooms'] = round($bath_rooms[1]);
						}
						preg_match('/<input.*id="hosting_square_feet".*value="(.*)".*\/>/', $room_details, $size);
						if (!empty($size[1])) {
							$_data['Property']['size'] = $size[1];
						}
						preg_match('/<input id="hosting_square_feet".*\/>.*<select.*id="square_feet_in_feet".*>.*value="([a-zA-Z]+)" selected="selected">\s*.*<\/select>/msU', $room_details, $measurement);
						if (!empty($measurement[1])) {
							$_data['Property']['measurement'] = $this->mapping['size'][$measurement[1]];
						} elseif (!empty($size[1])) {
							// default square feet
							$_data['Property']['measurement'] = 1;
						}
						preg_match('/<textarea.*id="hosting_house_manual".*>(.*)<\/textarea>/', $room_details, $house_manual);
						if (!empty($house_manual[1])) {
							$_data['Property']['house_manual'] = $house_manual[1];
						}
						preg_match('/<input type="radio".*value="(.*)" name="pets\[\]" checked.*\/>/', $room_details, $is_pets);
						if (!empty($is_pets[1])) {
							if ($is_pets[1] == 17) {
								$_data['Property']['is_pets'] = 1;
							} else {
								$_data['Property']['is_pets'] = 0;
							}
						}
						preg_match('/<span class="address">(.*)<\/span>/', $room_details, $address);
						if (!empty($address[1])) {
							$_data['Property']['address'] = $address[1];
						}
						preg_match('/exactCoords: new google.maps.LatLng\((.*), (.*)\)/', $room_details, $latlong);
						if (!empty($latlong[1])) {
							$_data['Property']['latitude'] = $latlong[1];
							$_data['Property']['longitude'] = $latlong[2];
							App::import('Core', 'HttpSocket');
							$HttpSocket = new HttpSocket();
							$map_details = $HttpSocket->get('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $_data['Property']['latitude'] . ',' . $_data['Property']['longitude'] . '&sensor=true');
							if (!empty($map_details)) {
								$maps = json_decode($map_details);
								if ($maps->status == 'OK') {
									if (!empty($maps->results[0]->address_components)) {
										foreach($maps->results[0]->address_components as $tmp_map_arr) {
											if ($tmp_map_arr->types[0] == 'country') {
												$_data['Property']['country_id'] = $this->Property->Country->findCountryId($tmp_map_arr->short_name);
											} elseif ($tmp_map_arr->types[0] == 'administrative_area_level_1') {
												$_data['Property']['state_id'] = $this->Property->State->findOrSaveAndGetId($tmp_map_arr->long_name);
											} elseif ($tmp_map_arr->types[0] == 'administrative_area_level_2') {
												$_data['Property']['city_id'] = $this->Property->City->findOrSaveAndGetId($tmp_map_arr->long_name);
											}
										}
									}
								}
							}
						}
						$price_details = $this->_curlGetURL('http://www.airbnb.com/hosting/pricing?hosting_id=' . $id);
						preg_match('/<input.*id="hosting_price_native".*value="(.*)" \/>/', $price_details, $price_per_night);
						if (!empty($price_per_night[1])) {
							$_data['Property']['price_per_night'] = $price_per_night[1];
						}
						preg_match('/<input.*id="hosting_weekly_price_native".*value="(.*)" \/>/', $price_details, $price_per_week);
						if (!empty($price_per_week[1])) {
							$_data['Property']['price_per_week'] = $price_per_week[1];
						}
						preg_match('/<input.*id="hosting_monthly_price_native".*value="(.*)" \/>/', $price_details, $price_per_month);
						if (!empty($price_per_month[1])) {
							$_data['Property']['price_per_month'] = $price_per_month[1];
						}
						preg_match('/<input.*id="hosting_price_for_extra_person_native".*value="(.*)" \/>/', $price_details, $additional_guest_price);
						if (!empty($additional_guest_price[1])) {
							$_data['Property']['additional_guest_price'] = $additional_guest_price[1];
						}
						preg_match('/<span class="protip">.*<select.*id="hosting_guests_included".*>.*value="([\d\.]+)" selected="selected">\s*.*<\/select>/msU', $price_details, $additional_guest);
						if (!empty($additional_guest[1])) {
							$_data['Property']['additional_guest'] = $additional_guest[1];
						}
						preg_match('/<input.*id="hosting_security_deposit_native".*value="(.*)".*\/>/', $price_details, $security_deposit);
						if (!empty($security_deposit[1])) {
							$_data['Property']['security_deposit'] = $security_deposit[1];
						}
						preg_match('/<label for="hosting_cancel_policy">.*<\/label>.*<select.*id="hosting_cancel_policy".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $price_details, $cancellation_policy);
						if (!empty($cancellation_policy[1])) {
							$_data['Property']['cancellation_policy_id'] = $this->mapping['cancellation_policy'][$cancellation_policy[1]];
						}
						preg_match('/<textarea.*id="hosting_house_rules".*>(.*)<\/textarea>/', $price_details, $house_rules);
						if (!empty($house_rules[1])) {
							$_data['Property']['house_rules'] = $house_rules[1];
						}
						preg_match('/<label for="hosting_min_nights">.*<\/label>.*<select.*id="hosting_min_nights".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $price_details, $minimum_nights);
						if (!empty($minimum_nights[1])) {
							$_data['Property']['minimum_nights'] = $minimum_nights[1];
						}
						preg_match('/<label for="hosting_max_nights">.*<\/label>.*<select.*id="hosting_max_nights".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $price_details, $maximum_nights);
						if (!empty($maximum_nights[1])) {
							if ($maximum_nights[1] == 365) {
								$maximum_nights[1] = 0;
							}
							$_data['Property']['maximum_nights'] = $maximum_nights[1];
						}
						preg_match('/<label for="hosting_check_in_time">.*<\/label>.*<select.*id="hosting_check_in_time".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $price_details, $checkin);
						if (isset($checkin[1])) {
							if ($checkin[1] != '') {
								$_data['Property']['checkin'] = '0' . $checkin[1] . ':00:00';
							}
						}
						preg_match('/<label for="hosting_check_out_time">.*<\/label>.*<select.*id="hosting_check_out_time".*>.*value="(\d+)" selected="selected">\s*.*<\/select>/msU', $price_details, $checkout);
						if (isset($checkout[1])) {
							if ($checkout[1] != '') {
								$_data['Property']['checkout'] = '0' . $checkout[1] . ':00:00';
							}
						}
						$_data['Property']['is_imported_from_airbnb'] = 1;
						$_data['Property']['airbnb_property_id'] = $id;
						$_data['Property']['user_id'] = $_SESSION['Auth']['User']['id'];
						$_data['Property']['ip_id'] = $this->Property->toSaveIp();
						$_data['Property']['is_paid'] = (!Configure::read('property.listing_fee')) ? 1 : 0;
						$_data['Property']['is_approved'] = (Configure::read('property.is_auto_approve')) ? 1 : 0;
						if ($this->Property->save($_data)) {
							$calendar_details = $this->_curlGetURL('http://www.airbnb.com/calendar/single/' . $id);
							if (preg_match('/<div class="ical_link">\s+<a href="(.*)">.*<\/a>\s+<\/div>/', $calendar_details, $ical_link)) {
								if (!empty($ical_link[1])) {
									$calendar_details = $this->_curlGetURL($ical_link[1]);
									$fp = fopen(CACHE . $id . '.ics', 'x+');
									fwrite($fp, $calendar_details);
									fclose($fp);
									require(APP . 'vendors' . DS . 'iCalReader.inc.php');
									$ical = new ical(CACHE . $id . '.ics');
									$reservation_arr = $ical->get_event_array();
									foreach($reservation_arr as $reservation) {
										$_custom_data = array();
										$_custom_data['CustomPricePerNight']['property_id'] = $this->Property->getLastInsertID();
										$_custom_data['CustomPricePerNight']['start_date'] = date('Y-m-d', $ical->ical_date_to_unix_timestamp($reservation['DTSTART']));
										$_custom_data['CustomPricePerNight']['end_date'] = date('Y-m-d', $ical->ical_date_to_unix_timestamp($reservation['DTEND']));
										$_custom_data['CustomPricePerNight']['price'] = $_data['Property']['price_per_night'];
										if ($reservation['SUMMARY'] == 'Not available') {
											$_custom_data['CustomPricePerNight']['is_available'] = 0;
										} elseif (preg_match('/(\d+) [a-zA-Z ]/', $reservation['SUMMARY'], $tmp_calendar_details)) {
											$_custom_data['CustomPricePerNight']['is_available'] = 0;
										} elseif (preg_match('/(\d+)$/', $reservation['SUMMARY'], $tmp_calendar_details)) {
											$_custom_data['CustomPricePerNight']['is_available'] = 1;
											$_custom_data['CustomPricePerNight']['price'] = $tmp_calendar_details[1];
										}
										$this->Property->CustomPricePerNight->create();
										$this->Property->CustomPricePerNight->save($_custom_data);
									}
									@unlink(CACHE . $id . '.ics');
								}
							}
							$photo_details = $this->_curlGetURL('http://www.airbnb.com/rooms/' . $id . '/edit?section=photos');
							if (preg_match_all('/<img alt="Mini_square" height="40" src="(.*)" width="40" \/>/', $photo_details, $photos)) {
								if (!empty($photos[1])) {
									$i = 1;
									foreach($photos[1] as $photo) {
										$_attachment_data = array();
										$_attachment_data['Attachment']['filename']['type'] = 'image/jpeg';
										$_attachment_data['Attachment']['filename']['name'] = 'image_' . $i . '.jpg';
										$_attachment_data['Attachment']['filename']['tmp_name'] = str_replace('mini_square', 'large', $photo);
										$_attachment_data['Attachment']['filename']['size'] = 0;
										$_attachment_data['Attachment']['filename']['error'] = 0;
										$this->Property->Attachment->Behaviors->attach('ImageUpload', Configure::read('property.file'));
										$this->Property->Attachment->isCopyUpload(true);
										$this->Property->Attachment->set($_attachment_data);
										$this->Property->Attachment->create();
										$_attachment_data['Attachment']['filename'] = $_attachment_data['Attachment']['filename'];
										$_attachment_data['Attachment']['user_id'] = $_SESSION['Auth']['User']['id'];
										$_attachment_data['Attachment']['class'] = 'Property';
										$_attachment_data['Attachment']['foreign_id'] = $this->Property->getLastInsertID();
										$this->Property->Attachment->data = $_attachment_data['Attachment'];
										$this->Property->Attachment->save($_attachment_data);
										$this->Property->Attachment->Behaviors->detach('ImageUpload');
										$i++;
									}
								}
							}
							$return['success'] = 1;
						} else {
							$return['ids'][] = $id;
							$return['error'] = 1;
						}
					} else {
						$return['ids'][] = $id;
						$return['error'] = 1;
					}
				}
			}
			return $return;
		}
	}
	function _curlGetURL($url, $data_arr = '' , $is_post = false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_arr);
		}
		curl_setopt($ch, CURLOPT_COOKIEFILE, APP . 'tmp' . DS . 'curl_cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEJAR, APP . 'tmp' . DS . 'curl_cookie.txt');
		$content = curl_exec($ch);
		if (!curl_errno($ch)) {
			curl_close($ch);
		} else {
			$content = false;
		}
		return $content;
	}
}
?>