<?php if (empty($_SERVER['HTTP_X_PJAX'])) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	
	<!-- NIVO SLIDER PABLO -->
		<link rel="stylesheet" href="assets/nivo/themes/default/default.css" type="text/css" media="screen" />
	    <!-- <link rel="stylesheet" href="assets/nivo/themes/light/light.css" type="text/css" media="screen" />
	    <link rel="stylesheet" href="assets/nivo/themes/dark/dark.css" type="text/css" media="screen" />
	    <link rel="stylesheet" href="assets/nivo/themes/bar/bar.css" type="text/css" media="screen" /> -->
	    <link rel="stylesheet" href="assets/nivo/nivo-slider.css" type="text/css" media="screen" />
	    <link rel="stylesheet" href="assets/nivo/style.css" type="text/css" media="screen" />
		
		<script type="text/javascript" src="assets/nivo/scripts/jquery-1.7.1.min.js"></script> 
   		<script type="text/javascript" src="assets/nivo/jquery.nivo.slider.js"></script>
		
	    <script type="text/javascript">
		    $(window).load(function() {
		        $('#slider').nivoSlider({
		        	effect:'fade',
					slices:15,
					animSpeed:500,
					pauseTime:3000,
					directionNav:false, //Next & Prev
					directionNavHide:true, //Only show on hover
					controlNav:false //1,2,3...
		        	
		        	
		        });
		    });
		</script>
	<!-- FIN NIVO -->
	
	<!-- NEWTIKER MARQUESINA START -->

		<link rel="stylesheet" href="assets/newtiker/styles/ticker-style.css" type="text/css" media="screen" />
		<script type="text/javascript" src="assets/newtiker/includes/jquery.ticker.js"></script>


		<script type="text/javascript">
			$(function () {
			    $('#js-news').ticker({
			    	controls: false,
			    	titleText: 'INFO:',
			    	pauseOnItems: 5000			    	
			    });
			});
		</script>
	<!-- NEWTIKER END -->
	
	

		<!-- styles -->
	    <link href="/assets/css/bootstrap.css" rel="stylesheet">
	    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
	    <link href="/assets/css/docs.css" rel="stylesheet">
	    <link href="/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
	    <link rel="stylesheet" href="/assets/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
	    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	    	    <!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
	    	    <!-- fav and touch icons -->
	    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
	    <link rel="apple-touch-icon" href="/assets/ico/apple-touch-icon.png">
	    <link rel="apple-touch-icon" sizes="72x72" href="/assets/ico/apple-touch-icon-72x72.png">
	    <link rel="apple-touch-icon" sizes="114x114" href="/assets/ico/apple-touch-icon-114x114.png">
	    <!--GOOGLE FONTS-->
	    <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css' />
	    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
	    <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700,400italic,700italic|Doppio+One' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Bowlby+One+SC' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Days+One|Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Exo:800' rel='stylesheet' type='text/css'>
	    <!--/GOOGLE FONTS-->
	
	
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('default.cache', null, array('inline' => true));
        echo $this->Html->css('extras.css');
		//echo $this->Javascript->link('default.cache', true);
		if (Configure::read('paypal.is_embedded_payment_enabled') && ($this->request->params['controller'] == 'payments' || ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'add_to_wallet'))): 
	?>
		<!-- <script type="text/javascript" src="https://www.paypalobjects.com/js/external/dg.js"></script> -->
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



<!-- BODY -->
	<?php if(($this->request->params['controller'] == 'properties') && ($this->request->params['action'] == 'index')) { ?>
<body class="properties-index">
	<?php } else { ?>
<body style="min-width: 1220px !important;" <?php if (Configure::read('paypal.is_embedded_payment_enabled') && $this->request->params['controller'] == 'payments' && ($this->request->params['action'] == 'success_order' || $this->request->params['action'] == 'cancel_order' || $this->request->params['action'] == 'success_propertypayment' || $this->request->params['action'] == 'cancel_propertypayment' || $this->request->params['action'] == 'success_sendmoney' || $this->request->params['action'] == 'cancel_sendmoney')): ?> onload="setTimeout(handleEmbeddedFlow, 0);"<?php endif; ?>>
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
    <!-- SOCIAL LINKS -->
        <div class="container_24">
            <div class="row hidden-phone">
               <!-- <img class="flip" src="/assets/img/panel.jpg" style="float: right;"/><span class="header_social">Follow us on <span class="badge"><a href="https://twitter.com/#!/joinajoin">Twitter</a></span> and <span class="badge"><a href="http://www.facebook.com/joinajoin">Facebook</a></span></span>-->
            </div>
    	</div>
    <!-- /SOCIAL LINKS -->
    
    <!-- LOGO Y CURRENCY-->
	<?php if($this->request->params['action']!='calendar_edit' ): ?>
		<div id="header" class="clearfix<?php echo $meta; ?>">
			<div class="header-content container_24  clearfix">
	        	<h1 class="grid_6"><?php echo $this->Html->link(Configure::read('site.name'), Router::url('/', true));?></h1>
	        	<?php echo $this->element('header', array('config' => 'sec')); ?>
			</div>
		</div>
	<?php endif; ?>
	
	
	<!--TOP
    <div class="top_line"></div>
    <div class="panel hidden-phone">
        <div id="map">
        </div>
    </div>
    <!--/TOP-->

	
	
	<?php
		//lazy loading image
		$lazy_allowed=true;
		//Lazy load image not allowed cases
		if($this->request->params['controller'].'/'.$this->request->params['action'] == 'properties/view' || $this->request->params['controller'].'/'.$this->request->params['action'] =='properties/search' || $this->request->params['controller'].'/'.$this->request->params['action'] =='transactions/index' || (isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection')):
		$lazy_allowed=false;
		endif;
	?>


		<div id="main" class="clearfix <?php if($lazy_allowed): ?>js-lazyload<?php endif; ?>">			
		<div class="main-content clearfix">
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
                <div class="span3">
                    <h5><span class="colored">///</span> Joinajoin Company.</h5>
                    <p>JoinaJoin is the fun providing marketplace where you can list, find & book any experience.</p>
                     <hr class="visible-phone">
                </div>
                <div class="span3 flickr">
                    <h5><span class="colored">///</span> Contact info</h5>
                    <span><strong class="colored"> Address:</strong> San Francisco, USA</span>
                    <hr class=" hidden-phone"><br class="visible-phone">
                    <br>
                    <span><strong class="colored">Phone:</strong>(415) 742 8501</span>
                    <hr class="visible-phone">
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


</div>
<?php  //echo $cakeDebug?>
<?php if (empty($_SERVER['HTTP_X_PJAX'])) { ?>
</body>
</html>
<?php } ?>
























    <!--FEATURES AREA
    <div class="gray_bg">
        <div class="container">
            <div class="row m25">
                <div class="span4 clearfix">
                        <img src="/assets/img/html5.png" class="pull-left" />
                        <h3>HTML 5 <span class="colored">&amp;</span> CSS 3</h3>
                        <p><em>Built to support new HTML5 elements and syntax. Progressively enhanced components for ultimate style. Yes, Valera is awesome!</em></p>
                </div>
                <div class="span4 clearfix">
                        <img src="/assets/img/resp.png" class="pull-left" />
                        <h3>Responsive Design</h3>
                        <p><em> Our components are scaled according to a range of resolutions and devices to provide a consistent experience, no matter what.</em></p>
                </div>
                <div class="span4 clearfix">
                        <img src="/assets/img/doc.png" class="pull-left" />
                        <h3>Well Documented</h3>
                        <p><em>Valera was designed first and foremost as a styleguide to document not only our features, but best practices and living.</em></p>
                </div>
            </div>
        </div>
    </div>
    <!--FEATURES AREA-->
    <!--MAIN CONTENT AREA
    <div class="container portfolio">
        <div style="margin-top:65px;">
            <div class="row">
                <div class="span4">
                    <div class="modal hade fade" id="myModal">
                        <div class="modal-header">
                        <a class="close" data-dismiss="modal">x</a>
                        <h3>Modal header</h3>
                        </div>
                        <div class="modal-body">
                        <p>One fine body...</p>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                    <div>
                        <h2><span class="colored"><strong>///</strong></span> From <span class="undercolored"><a href="#">Portfolio</a></span></h2>
                        <hr class="dash">
                        <div>
                            <p><em>The fluid grid system uses percents for column widths instead of fixed pixels. It has the responsive variations, ensuring proper proportions for key screen resolutions and devices.</em></p>
                        </div>
                        <hr class="dash">
                        <div class="well visible-desktop center">
                            <a class="btn btn-success btn-small" style="margin-right:10%" href="#"><i class="icon-picture icon-white"></i> View Portfolio</a> <a class="btn btn-success btn-small" data-toggle="modal" href="#myModal" ><i class="icon-download icon-white"></i> Download PDF</a>
                        </div>
                    </div>
                </div>
                <div class="span4 block">
                    <div class="view view-first">
                        <a href="/assets/img/gal/2.jpg" rel="prettyPhoto"><img src="/assets/img/gal/2.jpg" alt="" /></a>
                        <div class="mask">
                            <a href="/assets/img/gal/2.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                            <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                        </div>
                    </div>
                    <h5><i class="icon-picture"></i> <a href="#">Psd Retro Badges Vintage</a></h5>
                    <div class="description">
                        <p class="clo">A set of 6 original vintage and retro badges.</p>
                    </div>
                </div>
                <div class="span4 block">
                    <div class="view view-first">
                        <a href="/assets/img/gal/1.jpg" rel="prettyPhoto"><img src="/assets/img/gal/1.jpg" alt="" /></a>
                        <div class="mask">
                            <a href="/assets/img/gal/1.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                            <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                        </div>
                    </div>
                    <h5><i class="icon-picture"></i> <a href="#">Hanging Note Sign Psd</a></h5>
                    <div class="description">
                        <p class="clo">Our note is a great way to showcase an offer.</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" style="margin-top:45px; margin-bottom:45px;">
                <div class="span6">
                    <div class="row">
                    <div class="span6">
                        <h2><span class="colored"><strong>///</strong></span> About <span class="undercolored"><a href="#">valera</a></span></h2>
                        <hr class="dash">
                        <div class="intro">
                            <p style="margin-bottom:10px;"><em>Powerful WordPress theme very flexible, easy for customizing and well documented, approaches for.</em></p>
                        </div>
                        <hr class="dash intro">
                    </div>
                    <div class="span3">
                        <div class="about_icons pull-left">
                            <img src="/assets/img/frame.png" />
                        </div>
                        <div>
                            <h5>12-column grid</h5>
                            <p>Grid systems aren't everything, but having a durable and flexible one at the core of your work can make development much simpler.</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="about_icons pull-left">
                            <img src="/assets/img/skills.png" />
                        </div>
                        <div>
                            <h5>All skill levels</h5>
                            <p>Bootstrap is designed to help people of all skill levels designer or developer, huge nerd or early beginner.</p>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="well">
                            <h6>Web design</h6>
                            <div class="progress progress-success progress-striped active" style="margin-bottom: 9px;">
                                <div class="bar" style="width: 90%"></div>
                            </div>
                            <h6>Programming</h6>
                            <div class="progress progress-success progress-striped active" style="margin-bottom: 9px;">
                                <div class="bar" style="width: 70%"></div>
                            </div>
                            <h6>Social marketing</h6>
                            <div class="progress progress-success progress-striped active" style="margin-bottom: 9px;">
                                <div class="bar" style="width: 80%"></div>
                            </div>
                            <h6>SEO</h6>
                            <div class="progress progress-success progress-striped active" style="margin-bottom: 9px;">
                                <div class="bar" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row visible-desktop">
                        <div class="span6 ">
                            <hr class="dash">
                            <h3><span class="colored"><strong>///</strong></span> Clients Testimonials</h3>
                                <div class="row">
                                <div class="span6">
                                    <div class="well" style="margin-top:10px;">
                                        <div class="testimonialslider">
                                            <ul class="slides">
                                                <li>
                                                    <blockquote>
                                                        <p>Built to support new HTML5 elements and syntax.</p>
                                                        <small>HTML5</small>
                                                    </blockquote>
                                                </li>
                                                <li>
                                                    <blockquote>
                                                        <p>Progressively enhanced components for ultimate style.</p>
                                                        <small>CSS3</small>
                                                    </blockquote>
                                                </li>
                                                <li>
                                                    <blockquote>
                                                        <p>Built for and maintained by the community via GitHub.</p>
                                                        <small>Open-source</cite></small>
                                                    </blockquote>
                                                </li>
                                                <li>
                                                    <blockquote>
                                                        <p>Brought to you by an experienced engineer and designer.</p>
                                                        <small>Made at Twitter</small>
                                                    </blockquote>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <h2><span class="colored"><strong>///</strong></span> From our <span class="undercolored"><a href="#">blog</a></span></h2>
                    <hr class="dash">
                </div>
                <div class="span6">
                    <div class="row">
                        <div class="blogslider span6 clearfix">
                            <ul class="slides">
                                <li>
                                    <div class="blog_item">
                                        <div class="blog_head">
                                            <h4>Anoter blog post</h4>
                                            <span><i class="icon-calendar icon-white"></i> Fantasy by Lewis Carroll on Aug 24, 2011</span>
                                        </div>
                                        <div class="view view-first">
                                            <a href="/assets/img/gal/6.jpg" rel="prettyPhoto"><img src="/assets/img/gal/6.jpg" alt="" /></a>
                                            <div class="mask">
                                                <a href="/assets/img/gal/6.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                                                <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                                            </div>
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'.<br><br><a class="btn btn-small" href="#">Read More</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="blog_item">
                                        <div class="blog_head">
                                            <h4>Anoter blog post</h4>
                                            <span><i class="icon-calendar icon-white"></i> Fantasy by Lewis Carroll on Aug 24, 2011</span>
                                        </div>
                                        <div class="view view-first">
                                            <a href="/assets/img/gal/3.jpg" rel="prettyPhoto"><img src="/assets/img/gal/3.jpg" alt="" /></a>
                                            <div class="mask">
                                                <a href="/assets/img/gal/3.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                                                <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                                            </div>
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'.<br><br><a class="btn btn-small" href="#">Read More</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="blog_item">
                                        <div class="blog_head">
                                            <h4>Anoter blog post</h4>
                                            <span><i class="icon-calendar icon-white"></i> Fantasy by Lewis Carroll on Aug 24, 2011</span>
                                        </div>
                                        <div class="view view-first">
                                            <a href="/assets/img/gal/4.jpg" rel="prettyPhoto"><img src="/assets/img/gal/4.jpg" alt="" /></a>
                                            <div class="mask">
                                                <a href="/assets/img/gal/4.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                                                <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                                            </div>
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'.<br><br><a class="btn btn-small" href="#">Read More</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="blog_item">
                                        <div class="blog_head">
                                            <h4>Anoter blog post</h4>
                                            <span><i class="icon-calendar icon-white"></i> Fantasy by Lewis Carroll on Aug 24, 2011</span>
                                        </div>
                                        <div class="view view-first">
                                            <a href="/assets/img/gal/5.jpg" rel="prettyPhoto"><img src="/assets/img/gal/5.jpg" alt="" /></a>
                                            <div class="mask">
                                                <a href="/assets/img/gal/5.jpg" rel="prettyPhoto" class="info"><img src="/assets/img/plus.png" alt="Hanging Note Sign Psd" /></a>
                                                <a href="#" class="link"><img src="/assets/img/link.png" alt="Visit link" /></a>
                                            </div>
                                        </div>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'.<br><br><a class="btn btn-small" href="#">Read More</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/MAIN CONTENT AREA-->
    <!--TWITTER AREA-
    <div class="twitter-block">
        <div class="container">
            <div class="row">
                <div class="span3 header">
                    <h5><span class="colored">///</span> Our Twitter Feed</h5>
                    <p>Find out what's happening, right now, with the people and organizations you care about.</p>
                </div>
                <div class="span9">
                    <div class="well">
                        <img class="twit_img" src="/assets/img/twitter.png" alt="Visit link" />
                        <div id="jstwitter" class="clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/TWITTER AREA-->
    <!--FOOTER-->

    <!--/FOOTER-->
    <!--BOTTOM LINE-->

    <!--/BOTTOM LINE-->
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> -->	
    <!-- <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> -->
   <!-- <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/google-code-prettify/prettify.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
    <script src="/assets/js/jquery.easing.1.3.js"></script>
    <script src="/assets/js/jquery.slabtext.min.js"></script>
    <!-- <script src="/assets/js/jquery.flexslider-min.js"></script> -->
    <!-- <script src="/assets/js/superfish-menu/superfish.js"></script> -->
    <!--<script src="/assets/js/plugin.js"></script>-->
    <!-- <script src="/assets/js/jquery.prettyPhoto.js"></script> -->
    <!-- <script src="/assets/js/twitter.js"></script> -->
    <!-- <script src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
    <!-- <script src="/assets/js/jquery.gmap.min.js"></script> -->
    <!-- <script src="/assets/js/jquery.preloader.js"></script> -->
    <!-- <script src="/assets/js/custom.js"></script> -->
	<!-- <script type="text/javascript">var runFancy = true;</script> -->
    <!--[if IE]>
    <script type="text/javascript">
        runFancy = false;
    </script>
    <![endif]-->
    <!--
    <script type="text/javascript">
		if (runFancy) {
			jQuery.noConflict()(function($){
			$(".view").preloader();
			$(".flexslider").preloader();
			});
		}
    </script>
	-->
	
	</body>
</html>