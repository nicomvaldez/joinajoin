<?php
/* SVN: $Id: config.php 91 2008-07-08 13:13:19Z rajesh_04ag02 $ */
/**
 * Custom configurations
 */
if (!defined('DEBUG')) {
    define('DEBUG',0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', 'user_language');
	// salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
    // sub admin is available in site or not
    define('PERMANENT_CACHE_HAVE_SUB_ADMIN', false);
	// Enable support for HTML5 History/State API
	// By enabling this, users will not see full page load
	define('IS_ENABLE_HTML5_HISTORY_API', false);
	// Force hashbang based URL for all browsers
	// When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
$config['site']['license_key'] = '7313-5816-156-1318511505-26e359e8';
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'download',
    'v',
);
$config['image']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['property']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['property']['payment_gateway_flow_id'] = 'Buyer -> Site -> Seller';
$config['barcode']['symbology'] = 'qr';
// CDN...
$config['cdn']['images'] = null; // 'http://images.localhost/';
$config['cdn']['css'] = null; // 'http://static.localhost/';
$config['site']['google_map_key'] = 'ABQIAAAAP-YNKOKG98zieCzFPs-kExSRyAYvcj4y_SXEHA92yhs3v0HzhxSmLDrYvK9q3uvR0jkhkX3eaJGBdA';
$config['flickr']['url'] = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key';
$config['propertyfeedbacks']['max_upload_photo'] = 10;
$config['messages']['content_length'] = 50;
$config['messages']['page_size'] = 50;
$config['messages']['allowed_message_size_unit'] = 'MB';
$config['messages']['allowed_message_size'] = 5;
$config['sitemap']['models'] = array(
    'Property' => array(
		'conditions' => array(
			'Property.admin_suspend' => 0,
			'Property.is_approved' => 1,
			'Property.is_active' => 1,
			'Property.is_paid' => 1
		)
	) ,
    'Request' => array(
		'conditions' => array(
			'Request.admin_suspend' => 0,
			'Request.is_approved' => 1,
			'Request.is_active' => 1,
			'Request.checkin >=' => date('Y-m-d')
		)
	)
);
$config['property']['network_level'] = 2;
$config['site']['exception_array'] = array(
	'pages/view',
	'pages/display',
	'settings/fb_update',
	'users/register',
	'users/login',
	'users/logout',
	'users/reset',
	'users/forgot_password',
	'users/openid',
	'users/activation',
	'users/resend_activation',
	'users/view',
	'users/show_captcha',
	'users/captcha_play',
	'images/view',
	'devs/robots',
	'devs/asset_css',
	'devs/asset_js',
	'devs/sitemap',
	'requests/index',
	'requests/view',
	'contacts/add',
	'users/admin_login',
	'users/admin_logout',
	'languages/change_language',
	'contacts/show_captcha',
	'contacts/captcha_play',
	'properties/index',
	'payments/order',
	'users/oauth_callback',
	'user_comments/index',
	'user_friends/index',
	'countries/check_country',
	'properties/view',
	'properties/calendar',
	'properties/datafeed',
	'properties/map',
	'properties/cluster_data',
	'properties/get_info',
	'properties/pricefeed',
	'properties/price',
	'properties/weather',
	'properties/review_index',
	'properties/home',
	'properties/search',
	'properties/streetview',
	'properties/flickr',
	'properties/amenities_around',
	'properties/tweet_around',
	'properties/calendar_edit',
	'property_comments/index',
	'property_users/add',
	'property_feedbacks/index',
	'property_user_feedbacks/index',
	'properties/property_calendar',
	'requests/get_info',
	'cities/index',
	'crons/main',
	'properties/weather_data',
	'users/oauth_facebook',
	'users/refer',
	'users/validate_user',
	'collections/index',
	'promos/index',
	'searches/mostrar',
	'properties/update_price',
	'properties/get_turnos',
	'user_cash_withdrawals/process_masspay_ipn',
	'users/show_header',
	'properties/update_view_count',
	'currencies/change_currency',
	'payments/membership_pay_now',
	'payments/cancel_user_payment',
	'payments/success_user_payment',
);
/*
date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');
*/
/*
** to do move to settings table
*/
$config['site']['is_admin_settings_enabled'] = true;
if (!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'burrow.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('118.102.143.2', '119.82.115.146', '122.183.135.202', '122.183.136.34','122.183.136.36'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demo_mode_update_not_allowed_pages'] = array(
		'pages/admin_edit',
		'settings/admin_edit',
		'email_templates/admin_edit',
	);
	$config['site']['admin_demo_mode_not_allowed_actions'] = array(
		'admin_delete',
		'admin_update',
	);
}
?>