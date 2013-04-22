<?php /* SVN: $Id: $ */ ?>
<?php 
	$user_avatar_grid = 'grid_10';
	$user_avatar_inner_left_grid = 'grid_1';
	$user_avatar_inner_right_grid = 'grid_9';
	$city_list_grid = 'grid_4';
	$price_info_right_grid = 'grid_2';
	if (preg_match('/admin\/messages/s', $_SERVER['REDIRECT_URL'])) {
		$user_avatar_grid = 'grid_16';
		$user_avatar_inner_left_grid = 'grid_2';
		$user_avatar_inner_right_grid = 'grid_10';
		$city_list_grid = 'grid_24';
		$price_info_right_grid = 'grid_12';
	}
?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="jobs view">
<div class="gigs-view-info-blocks">
<div class="clearfix gigs-view-info-block-inner">
<div class="pptview-mblock-tl">
<div class="pptview-mblock-tr">
            <div class="pptview-mblock-tt">
            </div>
          </div>
          <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">





	<div class="grid_4 view-thumb-block omega alpha">
		<div class="thumb">
	    <span>
		<?php echo $this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'],false)));?>
        </span>
        </div>
        
    </div>
  
		<div class="<?php echo $user_avatar_grid; ?> omega alpha">
		<div class="clearfix">
			<div class="<?php echo $user_avatar_inner_left_grid; ?> user-avatar alpha">
        		<?php 
					$current_user_details = array(
						'username' => $property['User']['username'],
						'user_type_id' => $property['User']['user_type_id'],
						'id' => $property['User']['id'],
						'fb_user_id' => $property['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $property['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
				?>
            </div>
            	<div class="<?php echo $user_avatar_inner_right_grid; ?> user-avatar alpha">
         <div class="clearfix"> <h3 class="properties-title"><?php echo __l('Activities') . ' - ' . $this->Html->link($this->Html->cText($property['Property']['title']), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('target' => '_blank', 'title' => $this->Html->cText($property['Property']['title'], false),'escape' => false));?> </h3></div>
       
        <address class="address-info sfont dl clearfix">
        <span>
			<?php if(!empty($property['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
			<?php echo $this->Html->cText($property['Property']['address']); ?>
		</span>
    </address>
        <dl class="posted-list clearfix">
        		 <dt title="<?php echo __l('Posted on'); ?>"><?php echo __l('Posted on'); ?>
        		 <dd class="tb" title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($property['Property']['created'])); ?>"><?php echo  $this->Time->timeAgoInWords($property['Property']['created']);?></dd>

        </dl>
		<div class="progress-tl">
							<div class="progress-tr">
								<div class="progress-tm"> </div>
							</div>
                        </div>
						<div class="progress-inner clearfix">
							<?php
								$total_days = getCheckinCheckoutDiff($propertyUser['PropertyUser']['checkin'],getCheckoutDate($propertyUser['PropertyUser']['checkout']));
								$completed_days = (strtotime(date('Y-m-d')) - strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24);
								if($completed_days == 0) {
									$completed_days = 1;
								} elseif($completed_days < 0) {
									$completed_days = 0;
								} elseif($completed_days > $total_days) {
									$completed_days = $total_days;	
								}
                                $pixels = round(($completed_days/$total_days) * 100);
                            ?>
                            <p class="progress-bar round-5 pr">
								<span class="progress-status pa round-5" style="width:<?php echo $pixels; ?>%" title="<?php echo $pixels; ?>%">&nbsp;</span>
							</p>
                            <p class="progress-value clearfix">
								<span class="progress-from tb">
                                             <?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?>
                                </span>
								<span class="progress-to tb">
                                    <?php echo $this->Html->cDate(getCheckoutDate($propertyUser['PropertyUser']['checkout']));?>
                                 </span>
							</p>
							<p class="progress-value clearfix">
							
						          	<span class="checkin grid_left dc tb"> <?php echo __l('Check in');?> </span>
                                
							
                                        <span class="checkout grid_right dc tb"> <?php echo __l('Check out');?> </span>
                                
							</p>
                         </div>
                        <div class="progress-bl">
							<div class="progress-br">
								<div class="progress-bm"> </div>
							</div>
                        </div>
    </div>
    </div>
    
	    <div class="user-info-block-right1 no-bimg clearfix ">
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
	        <div class="gigs-block clearfix js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
			<dl class="request-list1 view-list1 guest clearfix">
                      <dt title ="<?php echo __l('View');?>">
                      <?php echo __l('Views');?></dt>
                      <dd class="dc js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo numbers_to_higher($property['Property']['property_view_count']); ?></dd>
                  </dl>
             <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
						<?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?>					  
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
							<?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>					  
                      </dd>
                    </dl>

         <dl class="clearfix request-list1 request-index-list success-rate-list">
    				        <dt  title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
                          <?php if(empty($property['Property']['property_feedback_count'])): ?>
		<dd class="not-available dc" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
								 <dd class="success-rate dc">
										<?php if(!empty($property['Property']['positive_feedback_count'])):
										$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));  ?>
								</dd>
							<?php endif; ?>
    		   </dl>
   </div>
	</div>
    </div>
		  <div class="city-price grid_right grid_4 omega alpha">
		   <div class="city-price omega alpha">
		   <div class="clearfix city-price1">
				<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
                 <sub class="tb"> <?php echo Configure::read('site.currency').' '?></sub>
				 <?php endif; ?>
                  <?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
				<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
                 <sub class="tb"> <?php echo ' '.Configure::read('site.currency');?></sub>
				 <?php endif; ?>
                  <p class="">
                  <?php echo __l('Per night');?>
                  </p>
            </div>
            </div>
            <div class="clearfix price-info-right">
                 <dl class="<?php echo $price_info_right_grid ?> clearfix request-list dc omega alpha">
    				<dt><?php echo __l('Per Week');?></dt>
                      <dd>
					    <?php
					  if($property['Property']['price_per_week']!=0):
					  echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);
					  else:
						echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7);
					endif;
					  ?></dd>
				  </dl>
 				   <dl class="<?php echo $price_info_right_grid ?> clearfix request-list dc omega alpha">
    				 <dt><?php echo __l('Per Month');?></dt>
                      <dd>
					   <?php
					  if($property['Property']['price_per_month']!=0):
					  echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);
					  else:
						echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30);
					endif;
					  ?></dd>
				  </dl>
				  </div>
         </div>
</div>
</div>
</div>
<div class="pptview-mblock-bl">
<div class="pptview-mblock-br">
            <div class="pptview-mblock-bb">
            </div>
          </div>





         

    
      </div>
	</div>
</div>
