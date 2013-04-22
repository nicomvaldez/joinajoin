<?php
/* SVN FILE: $Id: routes.php 173 2009-01-31 12:51:40Z rajesh_04ag02 $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7820 $
 * @modifiedby    $LastChangedBy: renan.saddam $
 * @lastmodified  $Date: 2008-11-03 23:57:56 +0530 (Mon, 03 Nov 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'xml');
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
$controllers = Cache::read('controllers_list', 'default');
if ($controllers === false) {
    $controllers = App::objects('controller');
    foreach($controllers as &$value) {
        $value = Inflector::underscore($value);
    }
    foreach($controllers as $value) {
        $controllers[] = Inflector::singularize($value);
    }
    array_push($controllers, 'admin');
    $controllers = implode('|', $controllers);
    Cache::write('controllers_list', $controllers);
}
$prefix_parameter_key = Configure::read('site.prefix_parameter_key');
//	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
//  pages/install as home page...
Router::connect('/', array( 
    'controller' => 'promos',
    'action' => 'index'
));
Router::connect('/pages/*', array(
	'controller' => 'pages',
	'action' => 'display'
));
Router::connect('/admin/pages/tools', array(
	'controller' => 'pages',
	'action' => 'display',
	'tools',
	'prefix' => 'admin',
	'admin' => true
));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/admin', array(
    'controller' => 'users',
    'action' => 'stats',
    'prefix' => 'admin',
    'admin' => 1
));
//Code to show the images uploaded by upload behaviour
Router::connect('/img/:size/*', array(
    'controller' => 'images',
    'action' => 'view'
) , array(
    'size' => '(?:[a-zA-Z_]*)*'
));
Router::connect('/files/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
Router::connect('/img/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
Router::connect('/cron/:action/*', array(
    'controller' => 'crons',
));
Router::connect('/users/twitter/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'twitter'
));
Router::connect('/users/facebook/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'facebook'
));
Router::connect('/users/yahoo/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'yahoo'
));
Router::connect('/users/gmail/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'gmail'
));
Router::connect('/users/openid/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'openid'
));

Router::connect('/properties/guest', array(
    'controller' => 'properties',
    'action' => 'datafeed'
) , array(
    'method' => 'guest',
    'startdate' => '[0-9\-]+',
    'enddate' => '[0-9\-]+',
    'property_id' => '[0-9\-]+',
    'year' => '[0-9\-]+',
    'month' => 'a-zA-Z]+',
));
Router::connect('/robots', array(
    'controller' => 'devs',
    'action' => 'robots'
));
Router::connect('/css/*', array(
	'controller' => 'devs',
	'action' => 'asset_css'
));
Router::connect('/js/*', array(
	'controller' => 'devs',
	'action' => 'asset_js'
));
Router::connect('/contactus', array(
    'controller' => 'contacts',
    'action' => 'add'
));
Router::connect('/myproperties', array(
    'controller' => 'properties',
    'action' => 'index',
    'type' => 'myproperties'
));
Router::connect('/map', array(
    'controller' => 'properties',
    'action' => 'map',
));
Router::connect('/calendar', array(
    'controller' => 'property_users',
    'action' => 'index',
    'type' => 'myworks',
    'status' => 'waiting_for_acceptance'
));
Router::connect('/trips', array(
    'controller' => 'property_users',
    'action' => 'index',
    'type' => 'mytours',
    'view' => 'list',
    'status' => 'in_progress'
));
Router::connect('/requests/favorites', array(
    'controller' => 'requests',
    'action' => 'index',
    'type' => 'favorite'
));
Router::connect('/properties/favorites', array(
    'controller' => 'properties',
    'action' => 'index',
    'type' => 'favorite'
));
Router::connect('/myrequests', array(
    'controller' => 'requests',
    'action' => 'index',
    'type' => 'myrequest',
	'status' => 'active'
));
Router::connect('/dashboard', array(
    'controller' => 'users',
    'action' => 'dashboard',
));
Router::connect('/joiner_dashboard', array(
    'controller' => 'users',
    'action' => 'joiner_dashboard',
));
Router::connect('/:city/properties', array(
    'controller' => 'properties',
    'action' => 'index'
) , array(
    'city' => '(?!' . $controllers . ')[^\/]*'
));
Router::connect('/activity/:order_id', array(
    'controller' => 'messages',
    'action' => 'activities'
) , array(
    'order_id' => '[0-9]+'
));
Router::connect('/collection/:slug', array(
    'controller' => 'properties',
    'action' => 'index',
	'type' => 'collection'
) , array(
    'slug' => '[^\/]*'
));

Router::connect('/sitemap', array(
    'controller' => 'devs',
    'action' => 'sitemap'
));
Router::connect('/:city/requests', array(
    'controller' => 'requests',
    'action' => 'index'
) , array(
    'city' => '(?!' . $controllers . ')[^\/]*'
));
?>