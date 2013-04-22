<?php
/* SVN FILE: $Id: app_model.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7847 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-08 08:24:07 +0530 (Sat, 08 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model
{
    public $actsAs = array(
        'Containable',
        'Affiliate'
    );
    function beforeSave() 
    {
        $this->useDbConfig = 'master';
        return true;
    }
    function afterSave() 
    {
        $this->useDbConfig = 'default';
        return true;
    }
    function beforeDelete() 
    {
        $this->useDbConfig = 'master';
        return true;
    }
    function afterDelete() 
    {
        $this->useDbConfig = 'default';
        return true;
    }
    function getIdHash($ids = null) 
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    function isValidIdHash($ids = null, $hash = null) 
    {
        return (md5($ids . Configure::read('Security.salt')) == $hash);
    }
    function findOrSaveAndGetId($data) 
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $this->data[$this->name]['name'] = $data;
            $this->save($this->data[$this->name]);
            return $this->id;
        }
    }
    function findCountryId($data) 
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'Country.iso2' => $data
            ) ,
            'fields' => array(
                'Country.id'
            ) ,
            'recursive' => -1
        ));
        return $findExist[$this->name]['id'];
    }
	function siteWithCurrencyFormat($amount, $wrap = 'span')
	{
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
			$currency_code = $_COOKIE['CakeCookie']['user_currency'];
		}
		if ($_currencies[$currency_code]['Currency']['is_prefix_display_on_left']) {
			return  $this->cCurrency($amount, $wrap);
		} else {
			return $this->cCurrency($amount, $wrap);
		}
	}
	function cCurrency($str, $wrap = 'span', $title = false)
	{
		$_precision = 2;
		$_currencies = $GLOBALS['currencies'];
		$currency_code = Configure::read('site.currency_id');
		if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
			$currency_code = $_COOKIE['CakeCookie']['user_currency'];
			$str = round($str * $_currencies[Configure::read('site.currency_id')]['CurrencyConversion'][$currency_code], 2);
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
    function _isValidCaptcha() 
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        return $img->check($this->data[$this->name]['captcha']);
    }
    function _sendAlertOnNewMessage($email, $message, $message_id, $template) 
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Model', 'Message');
        $this->Message = new Message();
        App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'MessageContent');
        $this->MessageContent = new MessageContent();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $template = $this->EmailTemplate->selectTemplate($template);
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.hash',
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.message',
                        'MessageContent.is_system_flagged',
                        'MessageContent.detected_suspicious_words',
                    ) ,
                )
            ) ,
            'recursive' => 2
        ));
		// @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        if (!empty($get_message_hash) && empty($get_message_hash['MessageContent']['is_system_flagged'])) {
            $get_user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $get_message_hash['Message']['user_id']
                ) ,
                'recursive' => -1
            ));
            $emailFindReplace = array(
                '##MESSAGE##' => $message['message'],
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##SITE_LINK##' => Router::url('/', true) ,
                '##REPLY_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'compose',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                    'reply'
                ) , true) ,
                '##VIEW_LINK##' => Router::url(array(
                    'controller' => 'messages',
                    'action' => 'v',
                    'admin' => false,
                    $get_message_hash['Message']['id'],
                ) , true) ,
                '##TO_USER##' => $get_user['User']['username'],
                '##FROM_USER##' => (($template == 'Booking Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##FROM_USER##' => (($template == 'Booking Alert Mail') ? 'Administrator' : $_SESSION['Auth']['User']['username']) ,
                '##SUBJECT##' => $message['subject'],
                '##FROM_EMAIL##' =>($template['from'] == '##FROM_EMAIL##')?Configure::read('site.from_email') : $template['from'],
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
            $subject = strtr($template['subject'], $emailFindReplace);
            $content = strtr($template['email_content'], $emailFindReplace);
            // Send e-mail to users
            $this->Email->from = (!empty($template['from']) && ($template['from'] == '##FROM_EMAIL##')) ? Configure::read('site.from_email') : $template['from'];
            $this->Email->replyTo = (!empty($template['from']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('site.reply_to_email') : $template['reply_to'];
            $this->Email->to = $email;
            $this->Email->subject = $subject;
			$this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
            $this->Email->send($content);
        }
    }
    function _checkUserNotifications($to_user_id, $order_status_id, $is_sender, $is_contact = null) 
    {
        App::import('Model', 'UserNotification');
        $this->UserNotification = new UserNotification();
        $conditions = array();
        $notification_check_array = array(
            '1' => 'is_new_property_order_host_notification',
            '2' => 'is_accept_property_order_traveler_notification',
            '3' => 'is_reject_property_order_traveler_notification',
            '4' => 'is_cancel_property_order_host_notification',
            '5' => 'is_arrival_host_notification',
            '6' => 'is_review_property_order_traveler_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_complete_property_order_host_notification',
            '9' => 'is_expire_property_order_host_notification',
            '10' => 'is_cancel_property_order_host_notification',
            '11' => 'is_admin_cancel_property_order_host_notification',
            '12' => 'is_complete_later_property_order_host_notification',
            '46' => 'is_recieve_dispute_notification',
        );
        $notification_check_sender_array = array(
            '1' => 'is_new_property_order_traveler_notification',
            '2' => 'is_accept_property_order_host_notification',
            '3' => 'is_reject_property_order_host_notification',
            '4' => 'is_cancel_property_order_traveler_notification',
            '5' => 'is_arrival_traveler_notification',
            '6' => 'is_review_property_order_host_notification',
            '7' => 'is_cleared_notification',
            '8' => 'is_complete_property_order_traveler_notification',
            '9' => 'is_expire_property_order_traveler_notification',
            '10' => 'is_cancel_property_order_traveler_notification',
            '11' => 'is_admin_cancel_traveler_notification',
            '12' => 'is_complete_later_property_order_traveler_notification',
            '15' => 'is_recieve_mutual_cancel_notification',
            '46' => 'is_recieve_dispute_notification',
        );
        if (!empty($is_contact)) {
            $conditions['UserNotification.is_contact_notification'] = 1;
        }
        if (!empty($to_user_id)) {
            $check_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $to_user_id
                ) ,
                'recursive' => -1
            ));
            if (!empty($check_notifications)) {
                $conditions['UserNotification.user_id'] = $to_user_id;
                if (empty($is_contact)) {
                    if (empty($is_sender)) {
                        if (isset($notification_check_array[$order_status_id])) {
                            $conditions["UserNotification.$notification_check_array[$order_status_id]"] = '1';
                        }
                    } else {
                        $conditions["UserNotification.$notification_check_sender_array[$order_status_id]"] = '1';
                    }
                }
                $check_send_mail = $this->UserNotification->find('first', array(
                    'conditions' => $conditions,
                    'recursive' => -1
                ));
                if (!empty($check_send_mail)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }
    function getRatingCount($user_id) 
    {
        App::import('Model', 'Property');
        $this->Property = new Property();
        $total_property_feedback_count = '';
        $total_property_positive_feedback_count = '';
        $get_user_total_ratings = $this->Property->find('all', array(
            'conditions' => array(
                'Property.user_id' => $user_id
            ) ,
            'recursive' => -1
        ));
        foreach($get_user_total_ratings as $get_user_total_rating) {
            if (!empty($get_user_total_rating['Property']['property_feedback_count'])) {
                $total_property_feedback_count+= $get_user_total_rating['Property']['property_feedback_count'];
                $total_property_positive_feedback_count+= $get_user_total_rating['Property']['positive_feedback_count'];
            }
        }
        $getrating = $this->getPropertyRating($total_property_feedback_count, $total_property_positive_feedback_count);
        return $getrating;
    }
    function getPropertyRating($total_rating, $possitive_rating) 
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
    function siteCurrencyFormat($amount) 
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    function toSaveIp() 
    {
        App::import('Model', 'Ip');
        $this->Ip = new Ip();
        $this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($ip)) {
            $this->data['Ip']['host'] = gethostbyaddr($this->data['Ip']['ip']);
            if (!empty($_COOKIE['_geo'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $country = $this->Ip->Country->find('first', array(
                    'conditions' => array(
                        'Country.iso2' => $_geo[0]
                    ) ,
                    'fields' => array(
                        'Country.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($country)) {
                    $this->data['Ip']['country_id'] = 0;
                } else {
                    $this->data['Ip']['country_id'] = $country['Country']['id'];
                }
                $state = $this->Ip->State->find('first', array(
                    'conditions' => array(
                        'State.Name' => $_geo[1]
                    ) ,
                    'fields' => array(
                        'State.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($state)) {
                    $this->data['State']['name'] = $_geo[1];
                    $this->Ip->State->create();
                    $this->Ip->State->save($this->data['State']);
                    $this->data['Ip']['state_id'] = $this->Ip->State->getLastInsertId();
                } else {
                    $this->data['Ip']['state_id'] = $state['State']['id'];
                }
                $city = $this->Ip->City->find('first', array(
                    'conditions' => array(
                        'City.Name' => $_geo[2]
                    ) ,
                    'fields' => array(
                        'City.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($city)) {
                    $this->data['City']['name'] = $_geo[2];
                    $this->Ip->City->create();
                    $this->Ip->City->save($this->data['City']);
                    $this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
                } else {
                    $this->data['Ip']['city_id'] = $city['City']['id'];
                }
                $this->data['Ip']['latitude'] = $_geo[3];
                $this->data['Ip']['longitude'] = $_geo[4];
            }
            $this->Ip->create();
            $this->Ip->save($this->data['Ip']);
            return $this->Ip->getLastInsertId();
        } else {
            return $ip['Ip']['id'];
        }
    }
    function _checkCancellationPolicies($property_arr, $property_user_arr, $cancellation_policy_arr) 
    {
        App::import('Model', 'PropertyUser');
        $this->PropertyUser = new PropertyUser();
        // CHECK ACTIVE ??? //
        $check_in_diff_date = $this->PropertyUser->find('first', array(
            'conditions' => array(
                'PropertyUser.id' => $property_user_arr['id'],
            ) ,
            'fields' => array(
                'DATEDIFF(PropertyUser.checkin, CURDATE()) as date_diff'
            ) ,
            'recursive' => -1
        ));
        $return_amount = array();
        $check_in_diff_date = $check_in_diff_date['0']['date_diff'];
        if (!empty($property_arr['cancellation_policy_id']) && !empty($property_user_arr['price'])) {
			if ($check_in_diff_date >= $cancellation_policy_arr['days']) {
				$percentage = 1;
				if (!empty($cancellation_policy_arr['percentage']) && $cancellation_policy_arr['percentage'] > 0) {
					$percentage = $cancellation_policy_arr['percentage'] / 100;
					$return_amount['traveler_balance'] = $property_user_arr['price'] * $percentage;
					$return_amount['host_balance'] = $property_user_arr['price'] - $property_user_arr['host_service_amount'] - $return_amount['traveler_balance'];
					if ($cancellation_policy_arr['percentage'] > 0 && $cancellation_policy_arr['percentage'] < 100) {
						$return_amount['partially_refund'] = 1;
					}
				} else {
					$return_amount['no_refund'] = 1;
				}
			} else {
				$return_amount['no_refund'] = 1;
			}
            return $return_amount;
        }
    }
    function getGatewayTypes($field = null) 
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => array(
                        'PaymentGatewaySetting.key' => $field,
                        'PaymentGatewaySetting.test_mode_value' => 1
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
		$payment_gateway_types = array();
		foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
				$payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
            }
        }
        return $payment_gateway_types;
    }
	function isPaymentGatewayEnabled($payment_gateway_id = null)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id,
                'PaymentGateway.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        if (!empty($paymentGateway)) {
            return true;
        }
        return false;
    }
    function formatToAddress($user = null)
    {
        if (!empty($user['UserProfile']['first_name'])) {
			$name = $user['UserProfile']['first_name'];
			if (!empty($user['UserProfile']['last_name'])) {
				$name .= ' ' . $user['UserProfile']['last_name'];
			}
            return $name . ' <' . $user['User']['email'] . '>';
        } else {
            return $user['User']['email'];
        }
    }
}
?>