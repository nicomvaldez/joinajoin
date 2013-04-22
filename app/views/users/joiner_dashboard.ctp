    <?php 
    	echo $this->Javascript->link('ui.selectmenu.js', true);
    	echo $this->Html->css('ui.selectmenu.css');
    	
    	echo $this->Html->css('joiner_dashboard.css'); 
    	echo $this->Javascript->link('joiner_dashboard.js', true);
    ?>	
	
	<link rel="stylesheet" href="css/960/reset.css" />
	<link rel="stylesheet" href="css/960/text.css" />
	<link rel="stylesheet" href="css/960/960.css" />	

	<div id="container_top" class="container_16">
	   <div class=" grid_16" style="float:right; text-align: right; padding-right: 5px;">
            <p><?php echo __l('Welcome '); echo '<b>'. $user['UserProfile']['first_name'].' '.$user['UserProfile']['last_name'] . '</b>';  ?></p>
        </div>  
		
		<div class="info_tabs grid_16 ">
			<h4 class="grid_4" style="float:left; padding-left:12px; margin:0px !important;">
			<?php
				$balance = $this->Html->getCurrUserInfo($this->Auth->user('id'));
    			echo __l('Wallet Balance') . ' ' . $this->Html->siteCurrencyFormat($balance['User']['available_wallet_amount']);
			?>
			</h4>
					
		</div>  
		<div class="clear"></div>
		
			<div id="foto_area" class="grid_4">
				<?php 
					$current_user_details = array(
						'username' => $this->Auth->user('username'),
						'user_type_id' =>  $this->Auth->user('user_type_id'),
						'id' =>  $this->Auth->user('id'),
						'fb_user_id' =>  $this->Auth->user('fb_user_id')
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $user['User']['attachment_id']
					);

					//echo $this->Html->getUserAvatar($this->Auth->user('id')); 
					echo $this->Html->getUserAvatarLinkClase($current_user_details, 'big_thumb', true,'foto_joiner');
				?>
				<?php echo $this->Html->link(__l('Edit Profile'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('My Account'), 'class'=>'edit_profile_button', 'id'=>'edit_profile_button'));?>
				<!-- <form id="searchform" method="get" action="/user_profiles/edit">
					<input class="boton_edicion" type="submit" value="Edit profile"/>
				</form> -->
				
			</div>
			<div id="tab_top_area" class="grid_12">
						<!-- Tabs -->
				<div id="top_tabs">
						<ul>
							<li><a href="#tab-search">Fast Search</a></li>
							<li><a href="#tab-settings">Settings</a></li>
							<li><a href="#tab-usermenu">User Menu</a></li>
						</ul>
						<!-- tabs contenido -->
					<div id="tab-search"><!-- tab Search -->
						<div class="info_tabs grid_11">Select a criteria for search.</div>
						<div class="clear"></div>
						<div id="select_container">
							<form id="searchform" method="get" action="/searches/mostrar">
                    			<input type="hidden" name="do" value="search">
							       <div class="grid_4">
								        <select name="city" class="jq_select">
								            <option select value="all">All Locations</option>
							            	<option value="196">Puerto Rico</option>
							            	<option value="253">United States</option>
							            	<option value="224">Spain</option>
								        </select>
							        </div>  
							        <div class="grid_4">
								        <select name="property_type" class="jq_select">
								            <option select value="all">All Categories</option>
								            <option value="17">Adventure</option>
							            	<option value="20">Fooding</option>
							            	<option value="18">Extreme Sports</option>
							            	<option value="24">Arts + Culture</option>
							            	<option value="19">Nightlife</option>						            
								        </select>
							        </div> 
						        <input type="submit" value="Search" id="search_button"/>
					    	</form>
					    </div>	
					</div><!-- tab search-->
					<div class="clear"></div>				

					<div id="tab-settings"><!-- tab Settings -->
						<div id="settings_container" class="">
							<div class="grid_4 links alpha omega">
								<?php echo $this->Html->link(__l('Social Networks'), array('controller' => 'users', 'action' => 'social'), array('title' => __l('Social Networks'), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Email Settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email Settings'), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change Password'), 'class'=>'button medium blue'));?>
							</div>
							<div class=" alpha grid_4 links omega">
								<?php echo $this->Html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index'), array('title' => __l('Credit Cards'), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request'), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('title' => __l('Money Transfer Accounts'), 'class'=>'button medium blue'));?>
							</div>
							<div class=" alpha grid_3 links omega">
								<?php echo $this->Html->link(__l('Edit Profile'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('My Account'), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'users', 'action' => 'add_to_wallet', 'admin' => false), array('title' => __l('Add Amount to Wallet '), 'class'=>'button medium blue'));?>
								<?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'), array('title' => __l('Affiliates'), 'class'=>'button medium blue'));?>
							</div>
						</div>
					</div><!-- tab settings -->
					<div class="clear"></div>

					<div id="tab-usermenu">
						<div id="settings_container" class="">
							<div class="grid_4 links alpha omega">
								<?php echo $this->Html->link(__l('My Joins'), array('controller' => 'myproperties', 'action' => 'index'), array('title' => __l('My Joins'), 'class'=>'button medium yellow'));?>
								<?php echo $this->Html->link(__l('My Calendar'), array('controller' => 'calendar', 'action' => 'index'),array('title' => __l('My Calendar'), 'class'=>'button medium yellow')); ?>
								<?php echo $this->Html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('My Transactions'), 'class'=>'button medium yellow'));?>
							</div>
							<div class=" alpha grid_4 links omega">
								<?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard'), 'class'=>'button medium yellow'));?>
								<?php echo $this->Html->link(__l('Your public profile'), array('controller' => 'users', 'action' => 'view',$this->Auth->user('username')), array('title' => __l('Your public profile'), 'class'=>'button medium green'));?>
								<?php echo $this->Html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst'), array('title' => __l('My Friends'), 'class'=>'button medium green'));?>
							</div>
							<div class=" alpha grid_3 links omega">
								<?php echo $this->Html->link(__l('Join Favorites'), array('controller' => 'properties', 'action' => 'favorites'),array('title' => __l('Join Favorites'), 'class'=>'button medium blue')); ?>
								<?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'requests', 'action' => 'favorites'),array('title' => __l('Request Favorites'), 'class'=>'button medium blue')); ?>
								<?php echo $this->Html->link(__l('Request a Join'), array('controller' => 'requests', 'action' => 'add'),array('title' => __l('Request a Join'), 'class'=>'button medium blue')); ?>
							</div>
						</div>						
					</div>
					<div class="clear"></div>
				</div><!-- Fin Top Tabs -->
			</div>	
	</div><!-- container 12-->				
	<div class="clear"></div>		


<!-- Segunda etapa -->	
	<div id="container_middle" class="container_16">
		<div id="hot_links" class="grid_4">
			<h4 class="prefix_1">Hot Links</h4>
			<hr>	
			<?php if($this->Auth->sessionValid()) {
				$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'));
				$message_count = !empty($message_count) ? ' ('.$message_count.')' : '';
			}
			?>
			<?php echo $this->Html->link(__l('- Inbox ').$message_count, array('controller' => 'messages', 'action' => 'index'), array('title' => __l('Your personal messages'), 'class'=>'button medium blue')); ?>
			<?php echo $this->Html->link(__l('- Incoming Bookings ') . ' ( ' . (!empty($host_all_count) ? $this->Html->cInt($host_all_count).' )' : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All'), 'class'=>'button medium blue')); ?>
			<?php echo $this->Html->link(__l('- Your Bookings ') . '( ' . (!empty($all_count) ? $this->Html->cInt($all_count).' )' : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All'), 'class'=>'button medium blue')); ?>
			<?php //echo $this->Html->link(__l('- Request a Join'), array('controller' => 'requests', 'action' => 'add'),array('title' => __l('Request a Join'), 'class'=>'button medium blue')); ?>
			<?php echo $this->Html->link(__l('- Logout'), array('controller' => 'users', 'action' => 'logout'), array('title' => __l('Logout'), 'class'=>'button medium red'));?>
			
		</div>
		
		<div id="content_center" class="grid_12">
		
		
		
			<?php echo $this->Html->image('logo_gris.png'); ?>
		
		
		
		</div>
	</div><!-- fin contenedor middle-->
			
			
