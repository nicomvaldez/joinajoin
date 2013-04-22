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
<?php if (empty($_SERVER['HTTP_X_PJAX'])) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

    <!--  	<link href="/assets/css/bootstrap_whitout_conflict.css" rel="stylesheet"> 
	    <link href="/assets/css/bootstrap.css" rel="stylesheet"> -->
		<link href="/assets/css/footer.css" rel="stylesheet">



    
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('default.cache', null, array('inline' => true));
       // echo $this->Html->css('custom-theme/jquery-ui-1.8.24.custom.css');
		echo $this->Html->css('redmond/jquery-ui-1.10.2.custom.min.css');
        echo $this->Html->css('extras.css');
        echo $this->Html->css('listas.css');
        echo $this->Html->css('all.css');
		echo $this->Html->css('jquery.ptTimeSelect.css');
		echo $this->Javascript->link('default.cache', true);
        echo $this->Javascript->link('common', true);   
		echo $this->Javascript->link('libs/guest-calendar', true); 
		echo $this->Javascript->link('jquery.ptTimeSelect', true);
		echo $this->Javascript->link('listas', true); 
		//echo $this->Javascript->link('libs/jquery-migrate-1.1.1', true); 
 
		
		
		    
        
		if (Configure::read('paypal.is_embedded_payment_enabled') && ($this->request->params['controller'] == 'payments' || ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'add_to_wallet'))): 
	?>
			<script type="text/javascript" src="https://www.paypalobjects.com/js/external/dg.js"></script>
	<?php
		endif;
		// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
			echo '<!--', "\n";
		endif;
	?>
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="og:app_id" />
	<meta content="<?php echo Configure::read('facebook.app_id');?>" property="fb:app_id" />
	<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
	<?php if(!empty($meta_for_layout['view_image'])) { ?>
		<meta property="og:image" content="<?php echo $meta_for_layout['view_image'];?>"/>
		<meta property="og:title" content="<?php echo $meta_for_layout['property_name'];?>"/>
	<?php } else { ?>
		<meta property="og:image" content="<?php echo Router::url(array(
				'controller' => 'img',
				'action' => 'logo.png',
				'admin' => false
			) , true);?>"/>
	<?php } ?>
	<?php
		if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
			echo '-->', "\n";
		endif;
	?>
<?php echo $this->element('site_tracker', array('cache' => 30, 'plugin' => 'site_tracker')); ?>



</head>
<?php if(($this->request->params['controller'] == 'properties') && ($this->request->params['action'] == 'index')) { ?>
<body class="properties-index">
<?php } else { ?>
<body<?php if (Configure::read('paypal.is_embedded_payment_enabled') && $this->request->params['controller'] == 'payments' && ($this->request->params['action'] == 'success_order' || $this->request->params['action'] == 'cancel_order' || $this->request->params['action'] == 'success_propertypayment' || $this->request->params['action'] == 'cancel_propertypayment' || $this->request->params['action'] == 'success_sendmoney' || $this->request->params['action'] == 'cancel_sendmoney')): ?> onload="setTimeout(handleEmbeddedFlow, 0);"<?php endif; ?>>
<?php } ?>
<?php } ?>
<?php
	$meta = '';
	if (!empty($_SERVER['HTTP_X_PJAX'])) {
		$meta_arr = array(
			'title' => Configure::read('site.name') . ' | ' . $this->Html->cText($title_for_layout, false),
			'keywords' => $meta_for_layout['keywords'],
			'description' => $meta_for_layout['description'],
		);
		$meta = ' js-meta ' . str_replace('"', '\'', json_encode($meta_arr));
	}
?>
	<?php if ($this->request->params['action'] != 'success_order' && $this->request->params['action'] != 'cancel_order' && $this->request->params['action'] != 'success_propertypayment' && $this->request->params['action'] != 'cancel_propertypayment' && $this->request->params['action'] != 'success_sendmoney' && $this->request->params['action'] != 'cancel_sendmoney'): ?>
		<?php if ($this->Session->check('Message.error') || $this->Session->check('Message.success') || $this->Session->check('Message.flash')): ?>
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
		<?php endif; ?>
	<?php endif; ?>
	<div class="js-morecities1 top-slider1  hide">
		<div class="cities-index-block">
			<?php
				$city = '';
				if ($this->request->url == 'properties' || $this->request->url == 'requests'):
					$city = 'all';
				endif;
				if ($this->request->params['controller'] == 'requests'):
					$is_request = 1;
				else:
					$is_request = 0;
				endif;
				echo $this->element('cities-index', array('is_request' => $is_request, 'city' => !empty($this->request->params['named']['city']) ? $this->request->params['named']['city'] : $city, 'config' => 'sec'));
			?>
		</div>
    </div>
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content clearfix">
	<?php
              	 if($this->Auth->sessionValid() && $this->Auth->user('user_type_id') == ConstUserTypes::Admin):
                    ?>
	<div class="clearfix admin-wrapper">
    			<h5 class="admin-site-logo grid_left">
					<?php echo $this->Html->link((Configure::read('site.name').' '.'<span>Admin</span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'title' => (Configure::read('site.name').' '.'Admin')));?>
    			</h5>
                <p class="logged-info grid_left"><?php echo __l('You are logged in as Admin'); ?></p>
    			<ul class="admin-menu grid_right clearfix">
    			 		<li class="logout"><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users' , 'action' => 'logout', 'admin' => true), array('title' => __l('Logout'))); ?></li>
				</ul>
	</div>
    <?php endif; ?>

<?php if($this->request->params['action']!='calendar_edit' ): ?>
		<div id="header" class="clearfix<?php echo $meta; ?>">
		<div class="header-content container_24  clearfix">
    
        	<h1 class="grid_6"><?php echo $this->Html->link(Configure::read('site.name'), Router::url('/collections', true));?></h1>
       
        <?php echo $this->element('header', array('config' => 'sec')); ?>

</div>
		</div>
	<?php endif; ?>

<?php
//lazy loading image
$lazy_allowed=true;
//Lazy load image not allowed cases
if($this->request->params['controller'].'/'.$this->request->params['action'] =='properties/view' || $this->request->params['controller'].'/'.$this->request->params['action'] =='properties/search' || $this->request->params['controller'].'/'.$this->request->params['action'] =='transactions/index' || (isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection')):
$lazy_allowed=false;
endif;



?>

		<div id="main" class="clearfix <?php if($lazy_allowed): ?>js-lazyload<?php endif; ?>">			
		<div class="main-content container_24 clearfix">
		<?php if( ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/search') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/index') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/view') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='users/dashboard')&& ($this->request->params['controller'].'/'.$this->request->params['action'] !='requests/view') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='requests/index') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='messages/activities') &&
        ($this->request->params['controller'].'/'.$this->request->params['action'] !='payments/order')  && ($this->request->params['controller'].'/'.$this->request->params['action'] !='property_feedbacks/add')&& ($this->request->params['controller'].'/'.$this->request->params['action'] !='property_users/index') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='collections/index') ): ?>

    	<div class="pptview-mblock-tl">
    	<div class="pptview-mblock-tr">
            <div class="pptview-mblock-tt"></div>
            </div>
          </div>
          <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
              <div class="main-center-block">
			  <?php endif; ?>
			<?php echo $content_for_layout;?>
	  	<?php if( ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/search') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/index') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='properties/view') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='users/dashboard')&& ($this->request->params['controller'].'/'.$this->request->params['action'] !='requests/view')&& ($this->request->params['controller'].'/'.$this->request->params['action'] !='messages/activities')&& ($this->request->params['controller'].'/'.$this->request->params['action'] !='payments/order') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='property_feedbacks/add') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='property_users/index') && ($this->request->params['controller'].'/'.$this->request->params['action'] !='collections/index')): ?>
            </div>
            </div>
			</div>
			</div>
			<div class="pptview-mblock-bl">
			<div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
            </div>
          </div>

  <?php endif; ?>

			</div>
			
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
<!-- FOOTER --> 	
<?php if($this->request->params['action']!='calendar_edit' ): ?>
    <footer style="padding-top: 15px; padding-bottom: 10px;">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="logoFooter"></div>
                    <!-- <img src="../img/logo.png" alt="logo" style="margin-bottom:7px; margin-top:7px;height: 100px;" /> -->
                	<!-- <hr class="visible-phone"> -->
                </div>
               <!-- <div class="footer_center_space"></div> -->
                <div class="span3" style="padding-top: 15px;">
                    <h5><span class="colored">///</span> Joinajoin Company.</h5>
                    <p>JoinaJoin is the fun providing marketplace where you can list, find & book any experience.</p>
                     <!-- <hr class="visible-phone"> -->
                </div>
                <div class="span3 flickr" style="padding-top: 15px;">
                    <h5><span class="colored">///</span> Contact info</h5>
                    <span><strong class="colored"> Address:</strong> San Francisco, USA</span>
                     <!-- <hr class=" hidden-phone"><br class="visible-phone"> -->
                    <br>
                    <span><strong class="colored">Phone:</strong>(415) 742 8501</span>
                     <!-- <hr class="visible-phone">  -->	
                </div> 
                <div class="span3 soc_icons">
                    <h5><span class="colored">///</span> Stay in touch</h5>
                    <span>Find out what's happening:</span>
                    <hr style="max-width: 70%;">
					<a href="http://www.facebook.com/joinajoin"><div class="icon_facebook"></div></a>
                    <a href="https://twitter.com/#!/joinajoin"><div class="icon_t"></div></a>
                </div>
            </div>
        </div>
    </footer>
    <div class="bottom-block">
        <div class="container">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="span6">
                            <span>Copyright 2012 Joinajoin - Company. <span class="undercolored"><a href="#"></a></span></span>
                        </div>
                        <div class="span6">
                            <span class="pull-right visible-desktop"><span class="undercolored"><a href="http://www.joinajoin.com">Home</a></span> / <span class="undercolored"><a href="http://www.joinajoin.com/page/faq">How this Works</a></span> / <span class="undercolored"><a href="http://www.joinajoin.com/page/faq">F.A.Q.</a></span> / <span class="undercolored"><a href="#">Blog</a></span> / <span class="undercolored"><a href="http://www.joinajoin.com/page/faq">Privacy Policy</a></span> / <span class="undercolored"><a href="http://www.joinajoin.com/page/faq">Terms of Service</a></span> / <span class="undercolored"><a href="http://www.joinajoin.com/contacts/add">Contact</a></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


      <!--div id="footer" class="clearfix">
        <div class="footer-content container_24 clearfix">
          <ul class="share-link clearfix">
            <li class="gris_5 twitter alpha"> <a href="<?php echo Configure::read('twitter.site_twitter_url'); ?>" title="Follow me on twitter">Follow me on twitter</a> </li>
            <li class="gris_5 facebook"> <a href="<?php echo Configure::read('facebook.site_facebook_url'); ?>" title="Follow me on facebook">Follow me on facebook</a> </li>
          </ul>
          <div class="foot-link-block clearfix">
            
            <ul class="foot-link clearfix">
              <li><?php echo $this->Html->link(__l('About'), array('controller' => 'pages', 'action' => 'view', 'about', 'admin' => false), array('title' => __l('About')));?> </li>
				<li><?php echo $this->Html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact Us')));?></li>
				<li><?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions', 'admin' => false), array('title' => __l('Terms & Conditions')));?></li>
				<li><?php echo $this->Html->link(__l('Privacy & Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy', 'admin' => false), array('title' => __l('Privacy & Polic')));?></li>
				<li><?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'map', 'admin' => false), array('title' => __l('Map')));?></li>
				<li><?php echo $this->Html->link(__l('Collections'), array('controller' => 'collections', 'action' => 'index', 'admin' => false), array('title' => __l('Collections')));?></li>
				 <li><?php echo $this->Html->link(__l('FAQ'), array('controller' => 'pages', 'action' => 'view', 'faq', 'admin' => false), array('title' => __l('faq')));?></li>           
                </li>
            </ul>
          </div>
      	<div id="agriya" class="clearfix copywrite-info">
		 <div class="footer-block clearfix">
			<p>&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
		</div>
		</div>
    </div>
  </div>
<?php endif;?>
<!-- /FOOTER -->	
		
		
		
		
		

		
		
		
		
	<!--	
		<?php if($this->request->params['action']!='calendar_edit' ): ?>
      <div id="footer" class="clearfix">
        <div class="footer-content container_24 clearfix">
          <ul class="share-link clearfix">
            <li class="gris_5 twitter alpha"> <a href="<?php echo Configure::read('twitter.site_twitter_url'); ?>" title="Follow me on twitter">Follow me on twitter</a> </li>
            <li class="gris_5 facebook"> <a href="<?php echo Configure::read('facebook.site_facebook_url'); ?>" title="Follow me on facebook">Follow me on facebook</a> </li>
          </ul>
          <div class="foot-link-block clearfix">
            
            <ul class="foot-link clearfix">
              <li><?php echo $this->Html->link(__l('About'), array('controller' => 'pages', 'action' => 'view', 'about', 'admin' => false), array('title' => __l('About')));?> </li>
				<li><?php echo $this->Html->link(__l('Contact Us'), array('controller' => 'contacts', 'action' => 'add', 'admin' => false), array('title' => __l('Contact Us')));?></li>
				<li><?php echo $this->Html->link(__l('Terms & Conditions'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions', 'admin' => false), array('title' => __l('Terms & Conditions')));?></li>
				<li><?php echo $this->Html->link(__l('Privacy & Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy', 'admin' => false), array('title' => __l('Privacy & Polic')));?></li>
				<li><?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'map', 'admin' => false), array('title' => __l('Map')));?></li>
				<li><?php echo $this->Html->link(__l('Collections'), array('controller' => 'collections', 'action' => 'index', 'admin' => false), array('title' => __l('Collections')));?></li>
				 <li><?php echo $this->Html->link(__l('FAQ'), array('controller' => 'pages', 'action' => 'view', 'faq', 'admin' => false), array('title' => __l('faq')));?></li>           
                </li>
            </ul>
          </div>
      	<div id="agriya" class="clearfix copywrite-info">
		 <div class="footer-block clearfix">
			<p>&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::Url('/',true), array('title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
		</div>
		</div>
    </div>
  </div>

<?php endif;
?>
	</div>
	

    <script type="text/javascript">
		if (runFancy) {
			jQuery.noConflict()(function($){
			$(".view").preloader();
			$(".flexslider").preloader();
			});
		}
    </script>	
    -->	
<?php // echo $cakeDebug?>
<?php if (empty($_SERVER['HTTP_X_PJAX'])) { ?>
</body>
</html>
<?php } ?>
