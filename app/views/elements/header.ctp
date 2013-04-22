
	<!-- Mensaje dialog -->
	<script>
	$.fx.speeds._default = 1000;
		$(function() {
			$("#what_is_join").live('click',function(){
				$("#dialog-message").dialog({
					show : "blind",
					hide : "clip",
		            modal : true,
					buttons: {
						Ok: function() {
							$( this ).dialog( "close" );
						}
					}
				});
				
			});	
		});
	</script>	
	<!-- fin dialogo -->



<div class="js-toggle-show-block header-right grid_17 grid_right clearfix <?php if (!$this->Auth->sessionValid() && $this->request->url == ''): ?>js-header hide<?php endif; ?>">
	<div class="clearfix global-block">
		<?php
           $currencies = $this->Html->getCurrencies();
           if(Configure::read('user.is_allow_user_to_switch_currency') && !empty($currencies)) :
               echo $this->Form->create('Currency', array('action' => 'change_currency', 'class' => 'normal grid_5 clearfix grid_right language-form'));
               echo $this->Form->input('currency_id', array('label'=>__l('Currency'),'class' => 'js-autosubmit', 'empty' => __l('Please Select'), 'options' => $currencies, 'value' => isset($_COOKIE['CakeCookie']['user_currency']) ?  $_COOKIE['CakeCookie']['user_currency'] : Configure::read('site.currency_id')));
               echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
               ?>
               <div class="hide">
                   <?php echo $this->Form->submit('Submit');  ?>
               </div>
               <?php
               echo $this->Form->end();
           endif;
        ?>			   
				
	    <?php
	        $languages = $this->Html->getLanguage();
	        if(Configure::read('user.is_allow_user_to_switch_language') && !empty($languages)) :
	            echo $this->Form->create('Language', array('action' => 'change_language', 'class' => 'normal grid_5 grid_right clearfix language-form'));
	            echo $this->Form->input('language_id', array('label'=>__l('Language'),'class' => 'js-autosubmit', 'empty' => __l('Please Select'), 'options' => $languages, 'value' => isset($_COOKIE['CakeCookie']['user_language']) ?  $_COOKIE['CakeCookie']['user_language'] : Configure::read('site.language')));
	            echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
	            ?>
	            <div class="hide">
	                <?php echo $this->Form->submit('Submit');  ?>
	            </div>
	            <?php
	            echo $this->Form->end();
	        endif;
		?>
		<!--	link a popular cities			
		 <ul class="js-more-cities global-links-r grid_right grid_3 clearfix">
         	<li class="down-arrow"><?php echo $this->Html->link(__l('Popular Cities'), '#', array('title' => __l('Popular Cities'), 'class' => "js-toggle-show {'container':'js-morecities1'}")); ?></li>
		 </ul>
		-->
	</div>
	

<div id="sub-header" class="clearfix" style="width: 890px; margin-left: -220px">
		<ul class="header-menu clearfix grid_right">
			<!-- <li class="hosting grid_left"> -->
            	
        	  	<li class="menu-link grid_left">
	                <div class="hi">
	                	<nav id="main-nav">
	    					<ul id="menu">
	                    		<a title="Discover something new to do" href="#" id="what_is_join"><?php echo __l('What is a Join') ;?></a>
	                    	</ul>
	                    </nav>		
	                </div>
                </li>
                
				<!-- div dialog jquery -->                
				<div id="dialog-message" title="What is a Join?" style="display: none;">
					<p>
						<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
						 Any experience, adventure or fun rental item.
					</p>
				</div>
				<!-- fin div dialog -->

            	<li class="menu-link grid_left">
		            <div class="hi">
		          		<nav id="main-nav">
        					<ul id="menu">
		              			<a title="Share your world" href="http://joinajoin.com/properties/add"><?php echo  __l('Provide a Join');?></a>
							</ul>
						</nav>	            
 		            </div>

                                                    
                    <!-- <span><span class="menu-arrow"><?php echo  __l('Hosting');?></span></span>
                    <div class="sub-menu-block grid_10">
              			  <div class="hosting-head">
            					<h2><span><?php echo __l('Hosting') ?></span></h2>
            			   </div>
                   
                       <div class="hosting-details-info">
                        <div class="clearfix">
                            <div class="request-left-block grid_5">
                                <?php if($this->Auth->sessionValid()) { ?>
    								<h4 class="request-title"><?php echo __l('My Hosting'); ?></h4>
    								<p class="page-information page-information1"><?php echo __l('Manage your hosting'); ?></p>
    							<?php } ?>
                        </div>
                    	<div class="space-block request-right-block grid_4 grid_right clearfix">
						<div class="clearfix">
							<a class="list-space grid_left" title="<?php echo __l('List your property'); ?>" href="<?php echo Router::url(array('controller' => 'properties', 'action' => 'add'),true); ?>"><span><span class="list-property"><?php echo __l('List your property'); ?></span></span></a></div>
							
						</div>
						</div>
                      
						<?php if($this->Auth->sessionValid()):?>
						  <ul class="clearfix list-menu">
								<li class="properties"><?php echo $this->Html->link(__l('My Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'myproperties','admin' => false), array('title' => __l('My Properties')));?></li>
                                     <li class="bookmarked-request"><?php echo $this->Html->link(__l('Liked Requests'), array('controller' => 'requests', 'action' => 'index', 'type'=>'favorite','admin' => false), array('title' => __l('Liked Requests')));?></li>
                        		<li class="calender"><?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'status' => 'waiting_for_acceptance','admin' => false), array('title' => __l('Calendar')));?>
                                    <span class="info"><?php echo __l('Manage reservations & pricing');?></span>
                                </li>
							 </ul>
    						<?php endif; ?>
                       

                    </div>
                 <div class="clearfix request-block-info">
                    <div class="request-left-block grid_5">
						<h4 class="request-title"><?php echo __l('Requests'); ?></h4>
						<p><?php echo __l('Find others\' requests'); ?></p>
						</div>
						  <div class="request-right-block grid_4 grid_right request-right-block1">
						  <ul class="request-right">
						  <li>
					           	<?php echo $this->Html->link(__l('Requests'), array('controller' => 'requests', 'action' => 'index','admin' => false), array('title' => __l('Requests')));?>
                        </li>
                        </ul>
                        </div>
                    </div>
                   
                    </div> -->
                </li>
				<!-- <li class="traveling hosting grid_left"> -->

                
                                    <!-- <span><span class="menu-arrow"><?php echo __l('Traveling') ;?></span></span>
                	<div class="sub-menu-block sub-menu-block1 grid_10">
    	   			  <div class="hosting-head travel-head">
        					<h2><span><?php echo __l('Traveling') ?></span></h2>
        			   </div>
        			     <div class="hosting-details-info">
                            <div class="clearfix">
                                <div class="request-left-block grid_5">
                                   <?php if($this->Auth->sessionValid()) { ?>
    								<h4 class="request-title"><?php echo __l('My Traveling'); ?></h4>
        								<p class="page-information page-information1"><?php echo __l('Your travel details'); ?></p>
        							<?php } ?>
                                </div>
                            	<div class="space-block request-right-block grid_4 grid_right clearfix">
        						    <a class="list-space grid_left" title="Post a request" href="<?php echo Router::url(array('controller' => 'requests', 'action' => 'add'),true); ?>"><span><span class="post-request"><?php echo __l('Post a request'); ?></span></span></a>
        						</div>
    						</div>
                            
    							<?php if($this->Auth->sessionValid()):?>
    							<ul class="clearfix list-menu travel-arrow">
    									<li class="trips"><?php echo $this->Html->link(__l('Trips'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'mytours', 'view' => 'list','status' => 'in_progress', 'admin' => false), array('title' => __l('Trips')));?></li>

    									<li class="bookmarked-request"><?php echo $this->Html->link(__l('Liked Properties'), array('controller' => 'properties', 'action' => 'index', 'type'=>'favorite','admin' => false), array('title' => __l('Liked Properties')));?></li>
                                            	<li class="request"><?php echo $this->Html->link(__l('My Requests'), array('controller' => 'requests', 'action' => 'index', 'type'=>'myrequest','admin' => false), array('title' => __l('My Requests')));?></li>
                                  </ul>
                            	<?php endif; ?>
                          
                        </div>
                       <div class="clearfix request-block-info">
                            <div class="request-left-block grid_5">
        						<h4 class="request-title"><?php echo __l('Properties') ?></h4>
        						<p><?php echo __l('Find others\' properties'); ?></p>
                            </div>
                            <div class="request-right-block grid_4 grid_right request-right-block1">
                                <ul class="request-right">
                                    <li>
                                        <?php echo $this->Html->link(__l('Properties'), array('controller' => 'properties', 'action' => 'index','admin' => false), array('title' => __l('Properties')));?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                    </li> -->
					<?php if($this->Auth->sessionValid()) { ?>
					<?php
						$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'));
						$message_count = !empty($message_count) ? ' ('.$message_count.')' : '';
					?>
					 <li class="menu-link grid_left">
                       <div class="hi">
                        <nav id="main-nav">
                            <ul id="menu">
                                <?php echo $this->Html->link(__l('How it works'), array('controller' => 'page', 'action' => 'how-it-works'));?>
                            </ul>
                        </nav>  
                       
                       </div>
                    </li>
                    
                    <li class="menu-link grid_left">
                       <div class="hi">
                        <nav id="main-nav">
                            <ul id="menu">
                                <?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'map'), array('title' => __l('Map of joins')));?>
                            </ul>
                        </nav>  
                       
                       </div>
                    </li>
					
					
						<li class="menu-link grid_left">
							<div class="hi">
				          		<nav id="main-nav">
    		    					<ul id="menu">
										<li><?php echo $this->Html->link(__l('Inbox').$message_count, array('controller' => 'messages', 'action' => 'index'), array('title' => __l('Your personal messages'))); ?></li>
									</ul>
								</nav>					
							</div>
						</li>
						
						                                                
						<li class="menu-link grid_left centrar_menu">
							<div class="hi">
				          		<nav id="main-nav">
    		    					<ul id="menu">
										<li><?php echo $this->Html->link(__l('My account'), array('controller' => 'joiner_dashboard'), array('title' => __l('My account'))); ?></li>
									</ul>
								</nav>					
							</div>
						</li>
						
						<li class="menu-link grid_left centrar_menu">
							<div class="hi">
				          		<nav id="main-nav">
    		    					<ul id="menu">
										<li> 
											<?php echo $this->Html->image("logout_img_16.png", array('class'=>'logout_img',"alt" => "Logout", 'url' => array('controller' => 'users', 'action' => 'logout'))); 
											echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');?>
										</li>
									</ul>
								</nav>					
							</div>
						</li>
						
					<?php } ?>
					<?php if($this->Auth->sessionValid()) { ?>
						
	                    	<li class="menu-link grid_left">
		                    	<div class="hi">
		                        	<nav id="main-nav">
	        						<ul id="menu">
	    	                        	<span>
											<?php if (!$this->Auth->sessionValid()):
												echo __l('Hi '); 
												echo __l('Guest');
											else:
											?>
											<span class="menu-arrow">
												<?php
												if($this->Auth->user('user_type_id') == ConstUserTypes::User):
												$current_user_details = array(
													'username' => $this->Auth->user('username'),
													'user_type_id' =>  $this->Auth->user('user_type_id'),
													'id' =>  $this->Auth->user('id'),
													'fb_user_id' =>  $this->Auth->user('fb_user_id')
												);
													$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($this->Auth->user('id'));
													echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
													//echo $this->Html->getUserLink($current_user_details);
	                                                //echo '<a title="My Account" href="/user/' . $this->Auth->user('username') . '">My Account</a>';
	                                                                                                    
													if($this->Auth->user('is_openid_register')):
														?>
														<span class ="openid-icon" title = "Registered through OpenID"><?php echo __l("Registered through OpenID"); ?> </span>
														<?php
													endif;
												else:
													echo $this->Html->link($this->Auth->user('username'), array('controller' => 'users', 'action' => 'stats', 'admin' => true),array('title' => $this->Auth->user('username')));
												endif;
												?>
											</span>
										<?php
										endif;
										?>
									</span>
	                         		</ul>
	                         	</nav>
	                      	</div>
						</li>                     
<!--                         
         <div class="sub-menu-block sub-menu-block3 grid_11">
           	<div class="hosting-head user-head clearfix">
					<h2 class="grid_left">
					<?php if($this->Auth->sessionValid()):
					$balance = $this->Html->getCurrUserInfo($this->Auth->user('id'));
    				echo $this->Html->siteCurrencyFormat($balance['User']['available_wallet_amount']);
					else:
							?>
					<?php echo __l('User Profile') ?>
                 
					<?php endif; ?>
					   </h2>
					<?php if($this->Auth->sessionValid()): ?>
                    <p class="post-link amount-wallet grid_right"><?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'users', 'action' => 'add_to_wallet', 'admin' => false), array('title' => __l('Add Amount to Wallet ')));?> </p>
                    <?php endif; ?>
			   </div>
        	<?php if(!$this->Auth->sessionValid()){ 
					$load_class ="user-profile-info1";
			  } else { 
            $load_class ="";
            } ?>
			 <div class="user-profile-info <?php echo $load_class; ?> clearfix">
                <div class="user-profile-info-left grid_5 alpha omega">
                  <h4>
					 <?php if($this->Auth->sessionValid()) { echo __l('Settings'); } ?>
				  </h4>
                    <?php if($this->Auth->sessionValid()): ?> <p class="change-profile"><?php echo __l('Change your profile settings'); ?></p><?php endif; ?>
                    <ul class="clearfix profile-list">
                    <?php //echo $this->Html->get_links('header'); ?>
					<?php
						if($this->Auth->sessionValid()):
					?>
							<li><?php echo $this->Html->link(__l('Edit Profile'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('My Account')));?></li>
							<li><?php echo $this->Html->link(__l('Social Networks'), array('controller' => 'users', 'action' => 'social'), array('title' => __l('Social Networks')));?></li>
							<li><?php echo $this->Html->link(__l('Email Settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email Settings')));?></li>
							<?php if (!$this->Auth->user('is_openid_register') && !$this->Auth->user('fb_user_id') && !$this->Auth->user('twitter_user_id') && !$this->Auth->user('is_gmail_register') && !$this->Auth->user('is_yahoo_register')): ?>
								<li><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change Password')));?></li>
							<?php endif; ?>
						   <li><?php echo $this->Html->link(__l('PayPal Connections'), array('controller' => 'user_paypal_connections', 'action' => 'index'), array('title' => __l('PayPal Connections')));?></li>
						   <li><?php echo $this->Html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index'), array('title' => __l('Credit Cards')));?></li>
							<li><?php echo $this->Html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request')));?></li>
							<li><?php echo $this->Html->link(__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('title' => __l('Money Transfer Accounts')));?></li>
							<?php
						endif;
					?>
			
				  </ul>
             </div>

	                    
                <?php if($this->Auth->sessionValid()){ ?>
                     <div class="user-profile-info-right grid_5 alpha omega">
                         <div class="selling-right-info">
                        	<h4><?php echo __l('Affiliates') ?></h4>
						    <p class="request-info"><?php echo __l('Get referral commission') ?></p>
							<ul class="clearfix profile-list">
                            	<li><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'), array('title' => __l('Affiliates')));?></li>
									<?php if($this->Auth->user('is_affiliate_user')):?>
        								<li><?php echo $this->Html->link(__l('Affiliate Cash Withdrawals'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('title' => __l('Affiliate Cash Withdrawals')));?></li>
									<?php endif;?>
							</ul>
				   </div>
				  <?php if($this->Auth->sessionValid()): ?>
				<div class="">
                    <h4><?php echo __l('My Account'); ?></h4>
                        <p class="request-info"><?php echo __l('Your account details'); ?></p>
					<ul class="clearfix profile-list">
						<li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard')));?></li>
						<li><?php echo $this->Html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('My Transactions')));?></li>
						<li><?php echo $this->Html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst'), array('title' => __l('My Friends')));?></li>
                        <li><?php echo $this->Html->link(__l('Your public profile'), array('controller' => 'users', 'action' => 'view',$this->Auth->user('username')), array('title' => __l('Your public profile')));?></li>
                        	<?php if($this->Auth->sessionValid()){ ?>
						<li>
                        	<?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout')));?>
                        </li>
	                        <?php } ?>
					</ul>
				</div>
				
		
				<div class="">
                    <h4><?php echo __l('Dashboard'); ?></h4>
                        <p class="request-info"><?php echo __l('Texto que falta :)'); ?></p>
					<ul class="clearfix profile-list">
						<li><?php echo $this->Html->link(__l('My Joins'), array('controller' => 'myproperties', 'action' => 'index'), array('title' => __l('My Joins')));?></li>
						<li><?php echo $this->Html->link(__l('My Calendar'), array('controller' => 'calendar', 'action' => 'index'),array('title' => __l('My Calendar'))); ?></li>
                        <li><?php echo $this->Html->link(__l('My Requests'), array('controller' => 'myrequests', 'action' => 'index'),array('title' => __l('My Requests'))); ?></li>
                        <li><?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'requests', 'action' => 'favorites'),array('title' => __l('Request Favorites'))); ?></li>
                        <li><?php echo $this->Html->link(__l('Join Favorites'), array('controller' => 'properties', 'action' => 'favorites'),array('title' => __l('Join Favorites'))); ?></li>
                        <li><?php echo $this->Html->link(__l('Request a Join'), array('controller' => 'requests', 'action' => 'add'),array('title' => __l('Request a Join'))); ?></li>

					</ul>
				</div>
		
		
				  <?php endif; ?>
				  </div>
				  <?php } ?>
                 
				  </div>
				</div>
				 </li>
-->					 
				 <?php } ?>
			 
                 <?php if(!$this->Auth->sessionValid()){ ?>
                 	
                 	<li class="menu-link grid_left">
                       <div class="hi">
						<nav id="main-nav">
        					<ul id="menu">
                       			<?php echo $this->Html->link(__l('How it works'), array('controller' => 'page', 'action' => 'how-it-works'));?>
                       		</ul>
                       	</nav>	
                       
                       </div>
                    </li>
                    
                    <li class="menu-link grid_left">
                       <div class="hi">
                        <nav id="main-nav">
                            <ul id="menu">
                                <?php echo $this->Html->link(__l('Map'), array('controller' => 'properties', 'action' => 'map'), array('title' => __l('Map of joins')));?>
                            </ul>
                        </nav>  
                       
                       </div>
                    </li>
                 	
                   	<li class="menu-link grid_left">
                       <div class="hi">
							<nav id="main-nav">
	        					<ul id="menu">
	                       			<?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));?>
	                       		</ul>
	                       	</nav>	
                       </div>
                    </li>
              
                <?php } ?>
	         	<?php if(!$this->Auth->sessionValid()){ ?>
                	<li class="menu-link grid_left">
	                    <div class="hi">
	                    	<nav id="main-nav">
	        					<ul id="menu">
	                    			<?php echo $this->Html->link(__l('Register'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Register')));?>
	                    		</ul>
	                    	</nav>
	                    </div>
                    </li>
                    
                	<li class="menu-link grid_left">
	                    <div class="hi">
	                    	<nav id="main-nav">
	        					<ul id="menu">                    
								    <div class="face_login_header">
										<a href="http://www.joinajoin.com/users/facebook/login"><?php echo $this->Html->image('face_connect_buton_small.png'); ?></a>
									</div>  
	                    		</ul>
	                    	</nav>
	                    </div>
                    </li>									                       
                    
               <?php } ?>
			</ul>
		</div>
  	</div>