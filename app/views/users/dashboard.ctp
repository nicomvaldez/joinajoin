<?php /* SVN: $Id: view.ctp 4973 2010-05-15 13:14:27Z aravindan_111act10 $ */ ?>
<div class="users view user-view-blocks">
	<div class="clearfix states-block grid_18">
		<div class="pptview-mblock-tl">
			<div class="pptview-mblock-tr">
				<div class="pptview-mblock-tt"></div>
            </div>
         </div>
          <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">

                 <div class="hosting-head user-head clearfix">
				<h2 class="grid_left">
					<?php if($this->Auth->sessionValid()):
					$balance = $this->Html->getCurrUserInfo($this->Auth->user('id'));
    				echo __l('Balance') . ' ' . $this->Html->siteCurrencyFormat($balance['User']['available_wallet_amount']);
					else:
							?>
					<?php echo __l('User Profile') ?>

					<?php endif; ?>
					   </h2>
					<?php if($this->Auth->sessionValid()): ?>
                    <p class="post-link dashbrad-amount amount-wallet grid_right"><?php echo $this->Html->link(__l('Add Amount to Wallet'), array('controller' => 'users', 'action' => 'add_to_wallet', 'admin' => false), array('title' => __l('Add Amount to Wallet ')));?> </p>
                    <?php endif; ?>
			   </div>
			   <div class="clearfix">
            	<div class="property-stats grid_left selling-bg">
            	   <div class="block2-tl">
                      <div class="block2-tr">
                        <div class="block2-tm">
                         	<h3 class="hosting"><?php echo __l('Hosting');?></h3>
                        </div>
                      </div>
                </div>
              <div class="main-side1">
               <div class="selling-block clearfix">            
			<?php if(Configure::read('property.rating_type') == 'percentage'):?>
				<dl class="ratings-feedback clearfix">
    				<dt class="rating" title = "<?php echo __l('Positive Rating'); ?>"><?php echo __l('Positive Rating:');?></dt>
    				<dd title = "<?php echo $this->Html->displayPercentageRating($user['User']['property_feedback_count'], $user['User']['positive_feedback_count']);?>" class="positive-feedback">
    					<?php echo $this->Html->displayPercentageRating($user['User']['property_feedback_count'], $user['User']['positive_feedback_count']); ?>
    				</dd>
				</dl>
				<?php else:?>
                <dl class="ratings-feedback1 clearfix">
    			   <dt  class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
    				<dd class="positive-feedback1"> <?php  echo $this->Html->cInt($user['User']['positive_feedback_count']); ?> </dd>
                </dl>
                <dl class="ratings-feedback1 clearfix">
                	<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
    				<dd class="negative-feedback1"><?php  echo $this->Html->cInt($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?></dd>
                </dl>
                <dl class="success-rate-list clearfix request-list1">
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
				<?php endif;?>
		  
	</div>
	<div class="revenue-block">
		<h4><?php echo __l('Revenue');?></h4>
    	<p class="total-earn-block"><?php echo __l('Total Earned'). ': '. $this->Html->siteCurrencyFormat($user['User']['cleared_amount']);?></p>
    	<?php
    		echo $this->element('users-hosting_panel', array('user_id' => $this->Auth->user('id'),'config' => 'sec'));
    	?>
	</div>
		<div class="select-block-info">
		<h4><?php echo __l('Reservation');?></h4>
					<div class="inbox-option dashboard-info">
						<?php
							$host_links[] =  "<p class='key-info-block clearfix'> <span class='all'>".$this->Html->link(__l('All') . ': ' . (!empty($host_all_count) ? $this->Html->cInt($host_all_count) : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All')))."</span></p>";
							foreach($host_moreActions as $host_key => $host_value):
								$host_class_name = "";
								list($host_slug, $host_cnt,$host_class_name) = $host_value;
								$host_count_list[] = $this->Html->cInt($host_cnt, false);
								$host_name_list[] = $host_key;
								$host_links[] = "<p class='key-info-block clearfix'> <span class='".$host_class_name."'>".$this->Html->link($host_key . ': ' . $this->Html->cInt($host_cnt), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks','status' => $host_slug,'admin' => false), array( 'title' => $host_key, 'escape' => false))."</span></p>";
							endforeach;
							echo implode('', $host_links);
						?>
					</div>
			<div class="chart-info-block">
					<?php
						$host_count_display = implode(',', $host_count_list);
						$host_name_display = implode('|', $host_name_list);
						$host_color_list = '4CB153|4E8975|EDA710|8B65D6|49A7FF|FD66B5|DF5958|A5A5A5|B371AF|828214';
						echo $this->Html->image('https://chart.googleapis.com/chart?cht=p&chs=110x110&chd=t:'.$host_count_display.'&chco=' . $host_color_list  . '&chf=bg,s,FFFFFF00', array('title' => 'Reservation chart'));
					?>
					</div>
				</div>
      </div>
 
	</div>

	
	<div class="user-stats grid_left buying-bg">
		   <div class="block2-tl">
               <div class="block2-tr">
                   <div class="block2-tm">
                     	<h3 class="traveling"><?php echo __l('Traveling');?></h3>
                     </div>
                  </div>
                </div>
            <div class="main-side1">
				<div><div class="selling-block clearfix">
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
		<dl class="clearfix request-list1 success-rate-list">
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
</dd>
</dl>
		   <?php endif; ?>
				</div>
				<span class="info side-info1"><?php echo __l('Rated by host');?></span>
				</div>
				<div class="revenue-block">
            	<h4><?php echo __l('Booked Trips');?></h4>
            	<div class="select-block-info">
					<div class="inbox-option dashboard-info">
						<?php
							$links[] =  "<p class='key-info-block clearfix'> <span class='all'>".$this->Html->link(__l('All') . ': ' . (!empty($all_count) ? $this->Html->cInt($all_count) : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'status' => 'all', 'admin' => false), array('escape' => false,  'title' => __l('All')))."</span></p>";
							foreach($moreActions as $key => $value):
								$class_name = "";
								list($slug, $cnt,$class_name) = $value;
								$count_list[] = $this->Html->cInt($cnt, false);
								$name_list[] = $key;
								$links[] = "<p class='key-info-block clearfix'> <span class='".$class_name."'>".$this->Html->link($key . ': ' . $this->Html->cInt($cnt), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours','status' => $slug, 'view' => 'list','admin' => false), array( 'title' => $key, 'escape' => false))."</span></p>";
							endforeach;
							echo implode('',$links);
						?>
					</div>
			<div class="chart-info-block">
					<?php
						$count_display = implode(',', $count_list);
						$name_display = implode('|', $name_list);
						$color_list = '4CB153|6DC699|49A7FF|EDA710|8B65D6|FD66B5|DF5958|A5A5A5|B371AF|ED6E38';
						echo $this->Html->image('https://chart.googleapis.com/chart?cht=p&chs=110x110&chd=t:'.$count_display.'&chco=' . $color_list . '&chf=bg,s,FFFFFF00', array('title' => 'Trips chart' ));
					?>
					</div>
				</div>

			
            </div>
   	        </div>
   	        </div>
        </div>
   		</div>
			</div>
			</div>
			<div class="pptview-mblock-bl">
			<div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
            </div>
          </div>
</div>
<div class="grid_6 omega">
<?php
		echo $this->element('sidebar', array('config' => 'sec'));
	?>
</div>
</div>
