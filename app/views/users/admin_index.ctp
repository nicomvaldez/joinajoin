<?php /* SVN: $Id: admin_index.ctp 4852 2010-05-12 12:58:27Z aravindan_111act10 $ */ ?>
<div class="users index js-response js-responses">

	<div class="clearfix">
	<div class="select-block inbox-option">
	
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
			<span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(__l('Active Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => $class, 'title' => __l('Active users')));?>
			 <?php echo $this->Html->cInt($approved ,false); ?>
			 </span>

			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
			<span class="notverified <?php echo $class; ?>"><?php echo $this->Html->link(__l('Inactive Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => $class, 'title' => __l('Inactive users')));?>
			  <?php echo $this->Html->cInt($pending  ,false); ?>
              </span>
	
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::OpenID) ? 'active-filter' : null; ?>
 			<span class="openid-user <?php echo $class; ?>"><?php echo $this->Html->link(__l('OpenID Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::OpenID), array('class' => $class, 'title' => __l('OpenID users')));?>
			  <?php echo $this->Html->cInt($openid ,false); ?>
                </span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Gmail) ? 'active-filter' : null; ?>
 			<span class="gmail-user <?php echo $class; ?>"><?php echo $this->Html->link(__l('Gmail Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Gmail), array('class' => $class, 'title' => __l('Gmail users')));?>
			  <?php echo $this->Html->cInt($gmail ,false); ?>
	        </span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Yahoo) ? 'active-filter' : null; ?>
 			<span class="yahoo-user <?php echo $class; ?>"><?php echo $this->Html->link(__l('Yahoo Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Yahoo), array('class' => $class, 'title' => __l('Yahoo users')));?>
			  <?php echo $this->Html->cInt($yahoo ,false); ?>
	        </span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Facebook) ? 'active-filter' : null; ?>
			<span class="facebook-user <?php echo $class; ?>"><?php echo $this->Html->link(__l('Facebook Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Facebook), array('class' => $class, 'title' => __l('Facebook users')));?>
			  <?php echo $this->Html->cInt($facebook ,false); ?>
	        </span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Twitter) ? 'active-filter' : null; ?>
			<span class="twitter-user <?php echo $class; ?>"><?php echo $this->Html->link(__l('Twitter Users: '), array('controller'=>'users','action'=>'index','filter_id' => ConstMoreAction::Twitter), array('class' => $class, 'title' => __l('Twitter users')));?>
			  <?php echo $this->Html->cInt($twitter ,false); ?>
	         </span>
			<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'active-filter' : null; ?>
			<span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('Total Users:'), array('controller'=>'users','action'=>'index'), array('class' => $class, 'title' => __l('Total Users')));?>
			 <?php echo $this->Html->cInt($pending + $approved ,false); ?>
			</span>
	
	</div>
    </div>
	<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php echo $this->Form->create('User', array('type' => 'get', 'class' => 'normal search-form', 'action'=>'index')); ?>

			<?php echo $this->Form->input('user_type_id',array('label' => __l('User Type'), 'empty' => __l('Please Select'))); ?>
            <?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>

			<?php echo $this->Form->submit(__l('Search'));?>
	<?php echo $this->Form->end(); ?>
</div>
<div class="add-block clearfix grid_right">
	<?php echo $this->Html->link(__l('Add'), array('controller' => 'users', 'action' => 'add'), array('class' => 'add','title'=>__l('Add'))); ?> 
</div>
</div>
  <?php   echo $this->Form->create('User' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>


<div class="overflow-block">
 <table class="list" id="js-expand-table">
	<tr class="js-even">
		<th class="select"  rowspan="2"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="dl"><?php echo $this->Paginator->sort(__l('User'), 'username'); ?></th>
        <th colspan="2"><?php echo __l('As Traveler');?></th>
        <th colspan="2"><?php echo __l('As Host');?></th>
        <th rowspan="2" class="dr"><?php echo $this->Paginator->sort(__l('Available Balance'),'User.available_wallet_amount').' ('.Configure::read('site.currency').')'; ?></th>
        <th colspan="3"><?php echo __l('Logins');?></th>
        
 	</tr>
 	<tr class="js-even">
        <th><?php echo __l('Bookings');?></th>
        <th class="dr"><?php echo __l('Site Revenue').' ('.Configure::read('site.currency').')';?></th>
        <th><?php echo __l('Properties');?></th>
        <th class="dr"><?php echo __l('Site Revenue').' ('.Configure::read('site.currency').')';?></th>
        <th><?php echo __l('Count'); ?></th>
        <th><?php echo __l('Time'); ?></th>
        <th><?php echo __l('IP'); ?></th>
      </tr>
<?php
if (!empty($users)):
$i = 0;
foreach ($users as $user):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		$class = 'altrow';
	endif;
	$email_active_class = ' email-not-comfirmed';
	if($user['User']['is_email_confirmed']):
	$email_active_class = ' email-comfirmed';
	endif;
	if($user['User']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$active_class = ' inactive-record';
		$status_class = 'js-checkbox-inactive';
	endif;
		$email_active_class = ' email-not-comfirmed';
		if($user['User']['is_email_confirmed']):
		$email_active_class = ' email-comfirmed';
		endif;
?>
     <tr class="<?php echo $class.$active_class;?> expand-row js-odd">
     		<td class="<?php echo $class;?> select"><div class="arrow"></div><?php echo $this->Form->input('User.'.$user['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$user['User']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dl">
            <div class="clearfix user-info-block">
                <p class="user-img-left grid_left">
                        <?php
                       	$chnage_user_info = $user['User'];
                       	$user['User']['full_name'] = (!empty($user['UserProfile']['first_name']) || !empty($user['UserProfile']['last_name'])) ? $user['UserProfile']['first_name'] . ' ' . $user['UserProfile']['last_name'] :  $user['User']['username'];
						$current_user_details = array(
						'username' => $chnage_user_info['username'],
						'user_type_id' =>  $chnage_user_info['user_type_id'],
						'id' =>  $chnage_user_info['id'],
						'fb_user_id' => $chnage_user_info['fb_user_id']
							);
						$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($chnage_user_info['id']);
      						echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
						    echo $this->Html->getUserLink($current_user_details);
                            ?>
                            </p>
                              <p class="user-img-right grid_right clearfix">

                        <?php if($user['User']['is_affiliate_user']):?>
								<span class="grid_right affiliate"> <?php echo __l('Affiliate'); ?> </span>
						<?php endif; ?>
						  <?php if($user['User']['user_type_id'] == ConstUserTypes::Admin):?>
								<span class="grid_right admin"> <?php echo __l('Admin'); ?> </span>
						<?php endif; ?>
						</p>
                        </div>
                        <div class="clearfix user-status-block user-info-block">
                        <?php
							if(!empty($user['UserProfile']['Country'])):
								?>
                                <span class="grid_left flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso2']); ?>" title ="<?php echo $user['UserProfile']['Country']['name']; ?>">
									<?php echo $user['UserProfile']['Country']['name']; ?>
								</span>
                                <?php
	                        endif;
						?>
                        <?php if($user['User']['is_openid_register']):?>
								<span class="open_id" title="OpenID"> <?php echo __l('OpenID'); ?> </span>
						<?php endif; ?>
                        <?php if($user['User']['is_gmail_register']):?>
								<span class="gmail" title="Gmail"> <?php echo __l('Gmail'); ?> </span>
						<?php endif; ?>
                        <?php if($user['User']['is_yahoo_register']):?>
								<span class="yahoo" title="Yahoo"> <?php echo __l('Yahoo'); ?> </span>
						<?php endif; ?>
                        <?php if($user['User']['fb_user_id']):?>
								<span class="facebook" title="Facebook"> <?php echo __l('Facebook'); ?> </span>
						<?php endif; ?>
                        <?php if($user['User']['twitter_user_id']):?>
								<span class="twitter" title="Twitter"> <?php echo __l('Twitter'); ?> </span>
						<?php endif;?>
                                  <?php if(!empty($user['User']['email'])):?>
								<span class="email <?php echo $email_active_class; ?>" title="<?php echo $user['User']['email']; ?>">
								<?php
								if(strlen($user['User']['email'])>20) :
									echo '..' . substr($user['User']['email'], strlen($user['User']['email'])-15, strlen($user['User']['email']));
								else:
									echo $user['User']['email'];
								endif;
								?>
                                </span>
						<?php endif; ?>
			 </div>
        </td>
       <td><?php echo $this->Html->cInt($user['User']['travel_total_booked_count']); ?></td>
       <td class="dr"><?php echo $this->Html->cCurrency($user['User']['travel_total_site_revenue']); ?></td>
       <td><?php echo $this->Html->cInt($user['User']['property_count']); ?></td>
       <td class="dr"><?php echo $this->Html->cCurrency($user['User']['host_total_site_revenue']);?></td>
       <td class="dr"><?php echo $this->Html->cCurrency($user['User']['available_wallet_amount']);?></td>
       <td><?php echo $this->Html->cInt($user['User']['user_login_count']); ?></td>
       <td><?php echo ($user['User']['last_logged_in_time']=='0000-00-00 00:00:00')? '-': $this->Html->cDateTimeHighlight($user['User']['last_logged_in_time']);?></td>
       <td><?php echo !empty($user['User']['last_login_ip'])?$this->Html->cText($user['User']['last_login_ip']):'-'; ?></td>
       
        </tr>
    <tr class="hide">
        <td colspan="11" class="action-block">
           <div class="action-info-block clearfix">
               <div class="action-left-block">
               	<h3> <?php echo __l('Action'); ?> </h3>
                       <ul class="action-link clearfix">
    			           <li><?php if(Configure::read('user.is_email_verification_for_register') and ($user['User']['is_email_confirmed'] == 0)):
    					     	echo $this->Html->link(__l('Resend Activation'), array('controller' => 'users', 'action' => 'resend_activation', $user['User']['id'], 'admin' => false),array('title' => __l('Resend Activation'),'class' =>'activate-user'));
    				            endif;?>
    			            </li>
    			            <li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                               <?php if($user['User']['user_type_id'] != ConstUserTypes::Admin){ ?>
                            <li><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $user['User']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                                    <?php } ?>
    		                  	<?php if(!empty($user['User']['fb_user_id']) || !empty($user['User']['twitter_user_id']) || !empty($user['User']['is_openid_register'])):?>
    			                <?php else:?>
                             <li>
                                   <?php if(!($user['User']['is_openid_register']) && !($user['User']['is_yahoo_register']) && !($user['User']['is_gmail_register'])&& !($user['User']['fb_user_id'])&& !($user['User']['twitter_user_id']) ):?>
                            				<?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('class' => 'password', 'title' => __l('Change password')));?>
                            			<?php endif ?> </li>
    			                 <?php endif?>
    			                 <?php if(!empty($user['UserProfile']['paypal_account']) && ($user['User']['user_type_id'] != ConstUserTypes::Admin)): ?>
    			             <li>
    			                 <?php echo $this->Html->link(__l('Send Money'), array('controller' => 'payments', 'action'=>'send_money', $user['User']['id']), array('class' => 'send-money', 'title' => __l('Send Money')));?>
    		                </li>
    			             <?php endif; ?>
    			     </ul>
                 </div>
                 <div class="action-right-block deal-action-right-block clearfix">
                    <div class="clearfix">
                            <div class="action-right action-right1 users-action">
                                       <h3><?php echo __l('As Host'); ?></h3>
									    <h4><?php echo __l('Amount'); ?></h4>
                                       <dl class="clearfix">
        								   <dt><?php echo __l('Earned'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_earned_amount']); ?></dd>
        								   <dt><?php echo __l('Lost'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_lost_amount']); ?></dd>
        								   <dt><?php echo __l('Pipeline'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_pipeline_amount']); ?></dd>
        								   <dt><?php echo __l('Site Revenue'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['host_total_site_revenue']); ?></dd>
                                       </dl>
									   <h4><?php echo __l('Properties'); ?></h4>
                                        <dl class="clearfix">
        								   <dt><?php echo __l('Pending Approval:'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['property_pending_approval_count']); ?></dd>
        								   <dt><?php echo __l('Enabled:'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['property_count']); ?></dd>
        								   <dt><?php echo __l('Disabled:'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['property_inactive_count']); ?></dd>
                                        </dl>
										  <h4><?php echo __l('Bookings'); ?></h4>
                                        <dl class="clearfix">
        								   <dt><?php echo __l('Successful'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['host_total_booked_count']); ?></dd>
        								   <dt><?php echo __l('Unsuccessful'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['host_total_lost_booked_count']); ?></dd>
        								</dl>
        								<div class="city-action users-city-action">
        								   <h4><?php echo __l('Reviews:'); ?></h4>
                                            <dl class="ratings-feedback1 clearfix">
                                    			<dt  class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
                                    			<dd class="positive-feedback1"> <?php  echo $this->Html->cInt($user['User']['positive_feedback_count']); ?> </dd>
                                            </dl>
                                             <dl class="ratings-feedback1 clearfix">
                                                	<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                                    				<dd class="negative-feedback1"><?php  echo $this->Html->cInt($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?></dd>
                                             </dl>
                                             <dl class="clearfix request-list1 success-rate-list">
                                				<?php
                                			  $success_rate = $user['User']['property_feedback_count'] - $user['User']['positive_feedback_count'];
                                				 ?>
                                			<dt  title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
                                				<?php if(empty($user['User']['property_feedback_count'])): ?>
                                    	         <dd class="not-available" ><?php echo __l('n/a'); ?></dd>
                                				<?php else: ?>
                                			 <dd class="success-rate">
                                						<?php if(!empty($user['User']['positive_feedback_count'])):
                        										$positive = floor(($user['User']['positive_feedback_count']/$user['User']['property_feedback_count']) *100);
                        										$negative = 100 - $positive;
                        										else:
                        										$positive = 0;
                        										$negative = 100;
                        										endif;

                        										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));  ?>
                                                  </dd>
                                                				<?php endif; ?>
                                               </dl>
                                        </div>
                            </div>
                            <div class="action-right users-action">
                                       <h3><?php echo __l('As Traveler'); ?></h3>
                                       <h4><?php echo __l('Amount:'); ?></h4>
									   <dl class="clearfix">
        								   <dt><?php echo __l('Paid'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_booked_amount']); ?></dd>
        								   <dt><?php echo __l('Site Revenue'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_site_revenue']); ?></dd>
        							  </dl>
                                             <h4><?php echo __l('Bookings:'); ?></h4>                                    
										<dl class="clearfix">
        								   <dt><?php echo __l('Successful:'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['travel_total_booked_count']); ?></dd>
        								   <dt><?php echo __l('Unsuccessful:'); ?></dt><dd><?php echo $this->Html->cInt($user['User']['travel_total_lost_booked_count']); ?></dd>
        								</dl> 
        								<div class="selling-block clearfix city-action users-city-action">
        								<h4><?php echo __l('Reviews:'); ?></h4>
				                         <dl class="ratings-feedback1 clearfix">
                                            <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                                            <?php echo __l('Positive');?></dt>
                                            <dd class="positive-feedback1">
                                            <?php  echo $this->Html->cInt($user['User']['traveler_positive_feedback_count']); ?>
                                            </dd>
                                            </dl>
                                            <dl class="ratings-feedback1 clearfix">
                                            <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                                            <dd  class="negative-feedback1">
                                              <?php  echo $this->Html->cInt($user['User']['traveler_property_user_count'] - $user['User']['traveler_positive_feedback_count']); ?>
                                            </dd>
                                            </dl>
                                            <?php if(($user['User']['traveler_property_user_count']) == 0): ?>
                                            		<dl class="clearfix request-list1">
                                            					<dt><?php echo __l('Success Rate'); ?></dt>
                                            					<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php echo __l('n/a'); ?></dd>
                                            			</dl>
                                            		  <?php else: ?>
                                            <dl class="ratings-feedback1 no-booking clearfix success-rate-list">
                                               <dt class="no-booking"><?php echo __l('Success Rate'); ?></dt>
                                            	<dd class="success-rate"><span class="stats-val">
                                            <?php if(!empty($user['User']['traveler_positive_feedback_count'])):
                                            		$positive = floor(($user['User']['traveler_positive_feedback_count']/$user['User']['traveler_property_user_count']) *100);
                                            		$negative = 100 - $positive;
                                            		else:
                                            		$positive = 0;
                                            		$negative = 100;
                                            		endif;

                                            		echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?>
                                            </span></dd>
                                        </dl>
                                		   <?php endif; ?>
                                	</div>

                            </div>
                            <div class="action-right action-right3">
                                    <h3><?php echo __l('As User'); ?></h3>
                                       <dl class="clearfix">
                                           <dt><?php echo __l('Deposited'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['total_amount_deposited']); ?></dd>
                                           <dt><?php echo __l('Wallet'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['available_wallet_amount']); ?></dd>
                                           <dt><?php echo __l('Withdrawn'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['total_amount_withdrawn']); ?></dd>
                                           <dt><?php echo __l('Total Site Revenue'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($user['User']['travel_total_site_revenue'] + $user['User']['host_total_site_revenue']); ?></dd>
                                       </dl>
                            </div>
                           
                    </div>
                 </div>
                 <div class="action-right action-right-block action-right4">
                     <div class="deal-img-block">
                     <?php echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb',false);?>
                     </div>
                     <dl class="clearfix">
                     <dt> <?php echo __l('Registered 0n'); ?></dt><dd><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></dd>
                     <?php if(!empty($user['User']['fb_user_id'])):?>
                     <dt> <?php echo __l('Facebook User ID'); ?></dt><dd><?php echo $this->Html->cText($user['User']['fb_user_id']); ?></dd>
                     <?php endif;?>
                     <?php if(!empty($user['User']['twitter_user_id'])):?>
                     <dt><?php echo __l('Twitter User ID'); ?></dt><dd><?php echo $this->Html->cText($user['User']['twitter_user_id']); ?></dd>
                     <?php endif;?>
					 <?php if(Configure::read('user.signup_fee')):?>
                     <dt><?php echo __l('Membership Paid'); ?></dt><dd><?php echo $this->Html->cBool($user['User']['is_paid']);?></dd>
                     <?php endif;?>
					 <dt><?php echo __l('Email Activated'); ?></dt><dd><?php echo $this->Html->cBool($user['User']['is_email_confirmed']);?></dd>
                     </dl>
                     
                 </div>
                </div>
        </td>
    </tr>
<?php
    endforeach;
else:
?>
	 <tr class="js-odd">
		<td colspan="14" class="notice"><?php echo __l('No users available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($users)):
?>	<div class="clearfix">
       <div class="admin-select-block clearfix grid_left">
            <div>
				<?php echo __l('Select:'); ?>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Inactive'))); ?>
				<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
            </div>
           <div class="admin-checkbox-button">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
         </div>
          <div class="js-pagination grid_right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>