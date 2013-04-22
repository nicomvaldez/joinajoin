<?php
/* SVN FILE: $Id: default.ctp 7805 2008-10-30 17:30:26Z AD7six $ */
/**
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
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<?php if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'hashbang')) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo sprintf(__l('Admin - %s'), $this->Html->cText($title_for_layout, false)); ?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('admin.cache', null, array('inline' => true));
		echo $this->Javascript->link('default.cache', true);
		echo $this->Javascript->link('common', true);   
		echo $this->Javascript->link('libs/guest-calendar', true); 
		echo $this->element('site_tracker');
	?>
</head>
<body class="admin">
	<div class="js-flash-message flash-message-block">
    	<?php
    	if ($this->Session->check('Message.error')):
    			echo $this->Session->flash('error');
    	endif;
    	if ($this->Session->check('Message.success')):
    			echo $this->Session->flash('success');
    	endif;
    	if ($this->Session->check('Message.flash')):
    			echo $this->Session->flash();
    	endif;
    	?>
    </div>
    <div class="admin-content-block">
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content admin-content admin-container-24 ">
		<div id="header" class="clearfix">
		    <div id="header-content">
			<div class="header-top-content">
			<div class="clearfix">
    			<h1 class="grid_5 mega alpha">
					<?php echo $this->Html->link((Configure::read('site.name').' '.'<span>Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'title' => (Configure::read('site.name').' '.'Admin')));?>
    			</h1>
    			<ul class="admin-menu clearfix grid_right">
				    <li class="view-site"><?php echo $this->Html->link(__l('View Site'), array('controller' => 'properties', 'action' => 'search', 'admin' => false), array('escape' => false, 'title' => __l('View Site')));?></li>
                    <li><?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true),array('title' => __l('Diagnostics'))); ?></li>
					<li><?php echo $this->Html->link(__l('Tools'), array('controller' => 'pages', 'action' => 'display', 'tools', 'admin' => true), array('escape' => false, 'title' => __l('View Site')));?></li>
					<?php $class = (($this->request->params['controller'] == 'user_profiles') && ($this->request->params['action'] == 'edit')) ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('title' => __l('My Account')));?></li>
                    <?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'admin_change_password')) ? ' class="active"' : null; ?>
                    <li <?php echo $class;?>><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'admin_change_password'), array('title' => __l('Change Password')));?></li>
    			    <li class="logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?></li>
                  	</ul>
				    </div>
    		   <?php
                    echo $this->element('admin-sidebar');
                ?>
				</div>
				<div class="header-bottom-content clearfix">
            	<!--<p class="admin-welcome-info grid_10 omega alpha"><?php echo __l('Welcome, ').$this->Html->link($this->Auth->user('username'), array('controller' => 'users', 'action' => 'stats', 'admin' => true),array('title' => $this->Auth->user('username'))); ?></p> -->
    			 <div class="grid_11 grid_right omega alpha admin-language-block">
      				<?php echo $this->element('lanaguge-change-block', array('cache' => array('config' => 'site_element_cache', 'key' => $this->request->params['controller'].'_'.$this->request->params['action'])));?>
    				<?php echo $this->element('admin-cities-filter', array('cache' => array('config' => '2sec', 'key' => $this->request->params['controller'].'_'.$this->request->params['action'])));?>
				</div>
				</div>
    		

            
		</div>
		</div>
		<div id="main" class="clearfix">
			<?php
				$user_menu = array('users','user_views', 'user_profiles',  'user_logins', 'messages', 'user_comments','user_paypal_connections','paypal_accounts');
				$properties_menu=array('properties', 'property_views', 'property_favorites','property_flags','collections','property_users','property_feedbacks','property_user_feedbacks','property_user_disputes');
				$requests_menu = array('requests', 'request_views','request_favorites','request_flags');
				$payment_menu = array('payment_gateways', 'transactions', 'user_cash_withdrawals','affiliate_cash_withdrawals');
				$partners_menu = array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_types', 'affiliate_widget_sizes');
				$master_menu = array('currencies', 'email_templates','pages', 'transaction_types', 'translations', 'languages',  'banned_ips', 'cities', 'privacies', 'states', 'countries',  'user_educations', 'genders', 'user_employments', 'property_flag_categories', 'affiliate_widget_sizes', 'ips','cancellation_policies','request_flag_categories','room_types','property_types','holiday_types','bed_types','amenities','user_relationships','user_income_ranges','habits');
				$diagnostics_menu = array('paypal_transaction_logs', 'paypal_docapture_logs', 'authorizenet_docapture_logs');
                $currency_conversion_menu = array('currency_conversion_histories');
                $search_log_menu = array('search_logs');
                $adaptive_transaction_log_menu = array('adaptive_transaction_logs');
                $devs_menu = array('devs');
                if(in_array($this->request->params['controller'], $user_menu) && $this->request->params['action'] != 'admin_diagnostics') {
					$class = "users-title";
				}elseif(in_array($this->request->params['controller'], $properties_menu)) {
					$class = "properties-title";
				}elseif(in_array($this->request->params['controller'], $requests_menu)) {
					$class = "requests-title";
				}elseif(in_array($this->request->params['controller'], $payment_menu)) {
					$class = "payment-title";
				}  elseif(in_array($this->request->params['controller'], $partners_menu)) {
					$class = "partners-title";
				} elseif(in_array($this->request->params['controller'], $master_menu)) {
					$class = "master-title";
				} elseif(in_array($this->request->params['controller'], $diagnostics_menu)) {
					$class = "diagnostics-title";
				}elseif(in_array($this->request->params['controller'], $currency_conversion_menu)) {
					$class = "currency_conversion-title";
				}elseif(in_array($this->request->params['controller'], $search_log_menu)) {
					$class = "search-log-title";
				}elseif(in_array($this->request->params['controller'], $adaptive_transaction_log_menu)) {
					$class = "adaptive-transaction-log-title";
				}elseif(in_array($this->request->params['controller'], $devs_menu)) {
    				$class = "dev-title";
				}elseif($this->request->params['controller'] == 'settings') {
					$class = "settings-title";				
				} elseif($this->request->params['controller'] == 'subscriptions' && $this->request->params['action'] == 'admin_subscription_customise') {
					$class = "customize-subscriptions-title";
				} elseif($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
					$class = "diagnostics-title";
				}
		  if(($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'admin_stats' || $this->request->params['action'] == 'admin_demographic_stats'))){
                echo $content_for_layout;
             } else { ?> 	
						<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix page-title-info">
					         <h2 class="<?php echo $class; ?>">
							<?php if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index') { ?>
								<?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> 				
							<?php }elseif($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit' ) { ?>
								<?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));?> &raquo; <?php echo $setting_categories['SettingCategory']['name']; ?>					
							<?php } elseif(in_array( $this->request->params['controller'], $diagnostics_menu) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') { ?>
							<?php echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics')));?> &raquo; <?php echo $this->pageTitle;?>
							<?php }  else { ?>
								<?php echo $this->pageTitle;?>
							<?php } ?>
						</h2>
					</div></div></div>
					               	<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm clearfix">
                	<?php if(!Configure::read('affiliate.is_enabled') && in_array( $this->request->params['controller'], array('affiliates', 'affiliate_requests',  'affiliate_cash_withdrawals', 'affiliate_widget_sizes'))) { ?>
                         <div class="page-info"><?php echo __l('Affiliate module is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } elseif(!Configure::read('site.is_currency_conversion_history_updation') && in_array( $this->request->params['controller'], array('currency_conversion_histories'))) { ?>
                         <div class="page-info"><?php echo __l('Currency Conversion History Updation is currently disabled. You can enable it from '); 
                          echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 4),array('title' => __l('Settings'))). __l(' page'); ?>
                          </div>
					 <?php } else {
					 		echo $content_for_layout;
					 }?>
                      </div>
                      </div>
               	</div>
					<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
        <?php } ?>
           
		</div>
	    <div id="agriya" class="clearfix">

            <div class="footer-block clearfix">
          	<p>&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
            </div>
        </div>
	</div>
    </div>
	<?php echo $this->element('site_tracker');?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
<?php } ?>
