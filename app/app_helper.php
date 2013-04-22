<?php
/* SVN FILE: $Id: app_helper.php 195 2009-03-18 06:30:14Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7904 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2008-12-05 22:19:43 +0530 (Fri, 05 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'Helper');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper
{
    function getUserAvatar($user_id)
    {
        App::import('Model', 'User');
        $modelObj = new User();
        $user = $modelObj->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'fields' => array(
                'UserAvatar.id',
                'UserAvatar.dir',
                'UserAvatar.filename'
            ) ,
            'recursive' => 0
        ));
        return $user['UserAvatar'];
    }
    function getCurrUserInfo($id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function getUserLink($user_details)
    {
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
            return $this->link($this->cText($user_details['username'], false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
    }
    function CheckReview($host_id, $traveler_id, $property_user_id)
    {
        App::import('Model', 'PropertyUserFeedback');
        $this->PropertyUserFeedback = new PropertyUserFeedback();
        $count = $this->PropertyUserFeedback->find('count', array(
            'conditions' => array(
                'PropertyUserFeedback.host_user_id' => $host_id,
                'PropertyUserFeedback.traveler_user_id' => $traveler_id,
                'PropertyUserFeedback.property_user_id' => $property_user_id,
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
    function getUserAvatarLink($user_details, $dimension = 'medium_thumb', $is_link = true)
    {
        App::import('Model', 'Setting');
        $this->Setting = new Setting();
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
            $user_image = '';
            if (isset($user_details['fb_user_id']) && !empty($user_details['fb_user_id']) && empty($user_details['UserAvatar']['id'])) {
                $width = $this->Setting->find('first', array(
                    'conditions' => array(
                        'Setting.name' => 'thumb_size.' . $dimension . '.width'
                    ) ,
                    'recursive' => -1
                ));
                $height = $this->Setting->find('first', array(
                    'conditions' => array(
                        'Setting.name' => 'thumb_size.' . $dimension . '.height'
                    ) ,
                    'recursive' => -1
                ));
                $user_image = $this->getFacebookAvatar($user_details['fb_user_id'], $height['Setting']['value'], $width['Setting']['value']);
            } else {
                  //get user image
                     $user_image = $this->showImage('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username']
                ));
            }
            //return image to user
            return (!$is_link) ? $user_image : $this->link($user_image, array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
    }

    function getUserAvatarLinkClase($user_details, $dimension = 'medium_thumb', $is_link = true, $clase='')
    {
        App::import('Model', 'Setting');
        $this->Setting = new Setting();
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
            $user_image = '';
            if (isset($user_details['fb_user_id']) && !empty($user_details['fb_user_id']) && empty($user_details['UserAvatar']['id'])) {
                $width = $this->Setting->find('first', array(
                    'conditions' => array(
                        'Setting.name' => 'thumb_size.' . $dimension . '.width'
                    ) ,
                    'recursive' => -1
                ));
                $height = $this->Setting->find('first', array(
                    'conditions' => array(
                        'Setting.name' => 'thumb_size.' . $dimension . '.height'
                    ) ,
                    'recursive' => -1
                ));
                $user_image = $this->getFacebookAvatar($user_details['fb_user_id'], $height['Setting']['value'], $width['Setting']['value']);
            } else {
                  //get user image
                     $user_image = $this->showImage('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
                    'class'=>$clase,
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username']                    
                ));
            }
            //return image to user
            return (!$is_link) ? $user_image : $this->link($user_image, array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
    }



    function getFacebookAvatar($fbuser_id, $height = 35, $width = 35)
    {
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture", array(
            'height' => $height,
            'width' => $width
        ));
    }
    function transactionDescription($transaction)
    { 
        $transaction['PropertyUser']['traveler_service_amount'] = !empty($transaction['PropertyUser']['traveler_service_amount']) ? $transaction['PropertyUser']['traveler_service_amount'] : 0;
        $transaction['PropertyUser']['host_service_amount'] = !empty($transaction['PropertyUser']['host_service_amount']) ? $transaction['PropertyUser']['host_service_amount'] : 0;
        $transaction['PropertyUser']['price'] = !empty($transaction['PropertyUser']['price']) ? $transaction['PropertyUser']['price'] : 0;
        $transactionReplace = array(
            '##TRAVELER##' => !empty($transaction['PropertyUser']) ? $this->link($transaction['UserProfile']['first_name'] . ' ' . $transaction['UserProfile']['last_name'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) : '',
            '##HOSTER##' => $this->link($transaction['UserProfile']['first_name'] . ' ' . $transaction['UserProfile']['last_name'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) ,
            '##AFFILIATE_USER##' => $this->link($transaction['UserProfile']['first_name'] . ' ' . $transaction['UserProfile']['last_name'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) ,
            '##PROPERTY##' => !empty($transaction['Property']) ? $this->link($transaction['Property']['title'], array(
                'controller' => 'properties',
                'action' => 'view',
                $transaction['Property']['slug'],
                'admin' => false
            )) : (!empty($transaction['PropertyUser']['Property']) ? $this->link($transaction['PropertyUser']['Property']['title'], array(
                'controller' => 'properties',
                'action' => 'view',
                $transaction['PropertyUser']['Property']['slug'],
                'admin' => false
            )) : '') ,
             '##ORDER_NO##' => !empty($transaction['PropertyUser']['id']) ? $this->link($transaction['PropertyUser']['id'], array(
				'controller' => 'messages',
				'action' => 'activities',
				'order_id'=>$transaction['PropertyUser']['id'],
				'admin' => false
			)) : '',
            '##SECURITY_DEPOSIT##' => (!empty($transaction['PropertyUser']['security_deposit']) && Configure::read('property.is_enable_security_deposit')) ? __l('with security deposit amount') . ' ' . $this->siteCurrencyFormat($transaction['PropertyUser']['security_deposit']) : '',
            '##PROPERTY_LISTING_FEE##' => Configure::read('property.listing_fee') ,
            '##PROPERTY_AMOUNT##' => (in_array($transaction['TransactionType']['id'], array(
                ConstTransactionTypes::RefundForCanceledProperty,
                ConstTransactionTypes::CanceledByAdminRefundToTraveler,
                ConstTransactionTypes::RefundForExpiredProperty
            ))) ? (!empty($transaction['PropertyUser']) ? $this->siteCurrencyFormat($transaction['PropertyUser']['price']) : '') : (!empty($transaction['PropertyUser']) ? $this->siteCurrencyFormat($transaction['PropertyUser']['price']+$transaction['PropertyUser']['traveler_service_amount']) : ''),
			'##PROPERTY_RECEIVED_AMOUNT##' => !empty($transaction['PropertyUser']) ? $this->siteCurrencyFormat(($transaction['PropertyUser']['price']-$transaction['PropertyUser']['host_service_amount'])) : '',
			'##USER##' => !empty($transaction['SecondUser']['username']) ? $this->link($transaction['SecondUser']['username'], array(
				'controller' => 'users',
				'action' => 'view',
				$transaction['SecondUser']['username'],
				'admin' => false
			)) : '',
		);
		if ((!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && !empty($transaction['TransactionType']['message_for_admin'])) {
			return strtr($transaction['TransactionType']['message_for_admin'], $transactionReplace);
		} else {
			return strtr($transaction['TransactionType']['message'], $transactionReplace);
		}
	}
	function conversationDescription($conversation)
	{
		$conversationReplace = array(
			'##TRAVELER##' => !empty($conversation['PropertyUser']) ? $this->link($conversation['PropertyUser']['User']['username'], array(
				'controller' => 'users',
				'action' => 'view',
				$conversation['PropertyUser']['User']['username'],
				'admin' => false
			)) : '',
			'##HOSTER##' => !empty($conversation['Property']['User']['username']) ? $this->link($conversation['Property']['User']['username'], array(
				'controller' => 'users',
				'action' => 'view',
				$conversation['Property']['User']['username'],
				'admin' => false
			)) : '',
			'##SITE_NAME##' => Configure::read('site.name') ,
			'##CREATED_DATE##' => $this->cDateTime($conversation['PropertyUser']['created']) ,
			'##ACCEPTED_DATE##' => $this->cDateTime($conversation['PropertyUser']['created']) ,
			'##CLEARED_DATE##' => $this->cDateTime(date('Y-m-d H:i:s', strtotime('+' . Configure::read('property.days_after_amount_withdraw') . ' days', strtotime($conversation['PropertyUser']['checkin'])))) ,
			'##CHECKIN_DATE##' => $this->cDateTime($conversation['PropertyUser']['checkin']) ,
			'##CLEARED_DAYS##' => Configure::read('property.days_after_amount_withdraw')
		);
		return strtr($conversation['PropertyUserStatus']['description'], $conversationReplace);
	}
	public function formGooglemap($properydetails = array() , $size = '320x320')
	{
		if ((!(is_array($properydetails))) || empty($properydetails)) {
			return false;
		}
		$mapurl = 'http://maps.google.com/maps/api/staticmap?center=';
		$mapcenter[] = str_replace(' ', '+', $properydetails['latitude']) . ',' . $properydetails['longitude'];
		$mapcenter[] = 'zoom=' . (!empty($properydetails['zoom_level']) ? $properydetails['zoom_level'] : 8);
		$mapcenter[] = 'size=' . $size;
		$mapcenter[] = 'markers=color:pink|label:M|' . $properydetails['latitude'] . ',' . $properydetails['longitude'];
		$mapcenter[] = 'sensor=false';
		return $mapurl . implode('&amp;', $mapcenter);
	}
	function distance($lat1, $lon1, $lat2, $lon2, $unit)
	{
		$theta = $lon1-$lon2;
		$dist = sin(deg2rad($lat1)) *sin(deg2rad($lat2)) +cos(deg2rad($lat1)) *cos(deg2rad($lat2)) *cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist*60*1.1515;
		$unit = strtoupper($unit);
		if ($unit == "K") {
			return ($miles*1.609344);
		} else if ($unit == "N") {
			return ($miles*0.8684);
		} else {
			return $miles;
		}
	}
	function getLanguage()
	{
		App::import('Model', 'Translation');
		$modelObj = new Translation();
		$languages = $modelObj->find('all', array(
			'fields' => array(
				'DISTINCT(Translation.language_id)',
				'Language.name',
				'Language.iso2'
			)
		));
		$languageList = array();
		if (!empty($languages)) {
			foreach($languages as $language) {
				if (!empty($language['Language']['name'])) {
					$languageList[$language['Language']['iso2']] = $language['Language']['name'];
				}
			}
		}
		return $languageList;
	}
	function displayPercentageRating($total_rating, $possitive_rating)
	{
		if (!$total_rating) {
			return __l('Not Rated Yet');
		} else {
			if ($possitive_rating) {
				return floor(($possitive_rating/$total_rating) *100) . '% ' . __l('Positive');
			} else {
				return '100% ' . __l('Negative');
			}
		}
	}
	function siteCurrencyFormat($amount, $wrap = 'span')
	{
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
			$currency_code = $_COOKIE['CakeCookie']['user_currency'];
		}
		if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
			return $_currencies[$currency_code]['Currency']['prefix'] . $this->cCurrency($amount, $wrap);
		} else {
			return $this->cCurrency($amount, $wrap) . $_currencies[$currency_code]['Currency']['prefix'];
		}
	}
	function siteWithCurrencyFormat($amount, $wrap = 'span')
	{
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
			$currency_code = $_COOKIE['CakeCookie']['user_currency'];
		}
		if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
			return $this->cCurrency($amount, $wrap);
		} else {
			return $this->cCurrency($amount, $wrap);
		}
	}
	function siteDefaultCurrencyFormat($amount, $wrap = 'span')
	{
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
			return $_currencies[$currency_code]['Currency']['prefix'] . $this->cDefaultCurrency($amount, $wrap);
		} else {
			return $this->cCurrency($amount, $wrap) . $_currencies[$currency_code]['Currency']['prefix'];
		}
	}
	function cCurrency($str, $wrap = 'span', $title = false)
	{
		$_precision = 2;
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
			$currency_code = $_COOKIE['CakeCookie']['user_currency'];
			$str = round($str*$_currencies[Configure::read('site.currency_id') ]['CurrencyConversion'][$currency_code], 2);
		}
		$changed = (($r = floatval($str)) != $str);
		$rounded = (($rt = round($r, $_precision)) != $r);
		$r = $rt;
		if ($wrap) {
			if (!$title) {
				$title = ucwords(Numbers_Words::toCurrency($r, 'en_US', $_currencies[$currency_code]['Currency']['code']));
			}
			$r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$currency_code]['Currency']['dec_point'], $_currencies[$currency_code]['Currency']['thousands_sep']) . '</' . $wrap . '>';
		}
		return $r;
	}
	function cDefaultCurrency($str, $wrap = 'span', $title = false)
	{
		$_precision = 2;
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		$changed = (($r = floatval($str)) != $str);
		$rounded = (($rt = round($r, $_precision)) != $r);
		$r = $rt;
		if ($wrap) {
			if (!$title) {
				$title = ucwords(Numbers_Words::toCurrency($r, 'en_US', $_currencies[$currency_code]['Currency']['code']));
			}
			$r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$currency_code]['Currency']['dec_point'], $_currencies[$currency_code]['Currency']['thousands_sep']) . '</' . $wrap . '>';
		}
		return $r;
	}
	function getCurrencies()
	{
		$currencies = $GLOBALS['currencies'];
		$currencyList = array();
		if (!empty($currencies)) {
			foreach($currencies as $currency) {
				$currencyList[$currency['Currency']['id']] = $currency['Currency']['code'];
			}
		}
		return $currencyList;
	}
	function getUserUnReadMessages($user_id = null)
	{
		App::import('Model', 'Message');
		$this->Message = new Message();
		$unread_count = $this->Message->find('count', array(
			'conditions' => array(
				'Message.is_read' => '0',
				'Message.user_id' => $user_id,
				'Message.is_sender' => '0',
				'Message.message_folder_id' => ConstMessageFolder::Inbox,
				'MessageContent.is_system_flagged' => 0
			) ,
			'recursive' => 1
		));
		return $unread_count;
	}
	
}