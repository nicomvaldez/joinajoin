<?php /* SVN: $Id: $ */ ?>
<?php //echo "<pre>"; debug($propertyInfo); exit; ?>
<div class="propertyFeedbacks side1 grid_18 form clearfix">
<div class="gigs-view-info-blocks">
<div class="clearfix">
	<div class="grid_4 view-thumb-block omega alpha">
		<div class="thumb">
	    <span>
		<?php echo $this->Html->showImage('Property', $propertyInfo['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyInfo['Property']['title'], false)), 'title' => $propertyInfo['Property']['title']));?>
        </span>
        </div>

    </div>

		<div class="grid_10 omega alpha">
		<div class="clearfix">
			<div class="grid_1 user-avatar alpha">
        		<?php 
					$current_user_details = array(
						'username' => $propertyInfo['User']['username'],
						'user_type_id' => $propertyInfo['User']['user_type_id'],
						'id' => $propertyInfo['User']['id'],
						'fb_user_id' => $propertyInfo['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $propertyInfo['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
				$attachment = array('id'=>$propertyInfo['Property']['User']['attachment_id']);
			?>
            </div>
            	<div class="grid_9 user-avatar alpha">
          <h3 class="properties-title"><?php echo __l('Activities') . ' - ' . $this->Html->link($this->Html->cText($propertyInfo['Property']['title']), array('controller' => 'properties', 'action' => 'view', $propertyInfo['Property']['slug']), array('target' => '_blank', 'title' => $this->Html->cText($propertyInfo['Property']['title'], false),'escape' => false));?> </h3>

        <address class="address-info">
        <span>
			<?php if(!empty($propertyInfo['Property']['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($propertyInfo['Property']['Country']['iso2']); ?>" title ="<?php echo $propertyInfo['Property']['Country']['name']; ?>"><?php echo $propertyInfo['Property']['Country']['name']; ?></span>
				<?php endif; ?>
			<?php echo $this->Html->cText($propertyInfo['Property']['address']); ?>
		</span>
    </address>
        <dl class="posted-list clearfix">
        		 <dt title="<?php echo __l('Posted on'); ?>"><?php echo __l('Posted on'); ?>
        		 <dd title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($propertyInfo['Property']['created'])); ?>"><?php echo  $this->Time->timeAgoInWords($propertyInfo['Property']['created']);?></dd>

        </dl>
    </div>
    </div>

	    <div class="user-info-block-right1 clearfix ">
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
                      <dd class="js-view-count-property-id js-view-count-property-id-<?php echo $propertyInfo['Property']['id']; ?> {'id':'<?php echo $propertyInfo['Property']['id']; ?>'}"><?php echo $this->Html->cInt($propertyInfo['Property']['property_view_count']); ?></dd>
                  </dl>
             <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
                        <?php  echo $this->Html->cInt($propertyInfo['Property']['positive_feedback_count']); ?>
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
                            <?php  echo $this->Html->cInt($propertyInfo['Property']['property_feedback_count'] - $propertyInfo['Property']['positive_feedback_count']); ?>
                      </dd>
                    </dl>

          <?php
		  if($propertyInfo['Property']['property_user_count']!=0 && $propertyInfo['Property']['property_user_failure_count']!=0){
						$total_completed  = $propertyInfo['Property']['property_user_success_count']+$propertyInfo['Property']['property_user_failure_count'];
						$success_rate = ($total_completed/$propertyInfo['Property']['property_user_count'])*100 ;
						$on_time_rate = ($propertyInfo['Property']['property_user_success_count']/$total_completed)*100 ;
						$success_rate  = ($success_rate > 100)? 100 : $success_rate;
						$on_time_rate  = ($on_time_rate > 100)? 100 : $on_time_rate;
					?>
             <p class="property-stats-bar-block clearfix"> <span>
                 <?php if(($propertyInfo['Property']['property_user_count']) == 0): ?>
  			        <?php echo sprintf(__l('Success Rate: ').'<span class="stats-val">%s</span>', __l(' Success Rate')); ?>
                  <?php else: ?>
                      <?php echo sprintf(__l('Success Rate: ').'<span class="stats-val">%s/%s</span>', $this->Html->cInt($total_completed),$this->Html->cInt($propertyInfo['Property']['property_user_count'])); ?> <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.round($success_rate).','.(100 - round($success_rate)).'&chs=45x45&chco=00FF00|FF0000', array('title' => round($success_rate).'%')); ?>
                          <?php if($total_completed == 0): ?>
                                  <span class="ontime-info"> (<?php echo sprintf(__l('On Time: ').'<span class="stats-val">%s</span>', __l('Still no booking'));  ?> )  </span>
                            <?php else: ?>
                                   <span class="ontime-info"> (<?php echo sprintf(__l('On Time: ').'<span class="stats-val">%s/%s</span>', $this->Html->cInt($propertyInfo['Property']['property_user_success_count']),$this->Html->cInt($total_completed)); ?> <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.round($on_time_rate).','.(100 - round($on_time_rate)).'&chs=45x45&chco=00FF00|FF0000', array('title' => round($on_time_rate).'%')); ?> )   </span>
                           <?php endif; ?>
                   <?php endif; ?>
              </span> </p>
<?php
		  }else{
?>
		  <dl class="clearfix guest request-list1">
    				    <dt  title ="<?php echo __l('Still no booking');?>"><?php echo __l('Success Rate');?></dt>
                          <dd class="not-available" title="<?php  echo __l('No bookings available'); ?>">
                        <?php  echo __l('n/a'); ?>
                      </dd>
    		   </dl>
   <?php } ?>
   </div>
	</div>
    </div>
		  <div class="city-price grid_4 grid_right omega alpha">
		  		   <div class="city-price grid_4 omega alpha">
		   <div class="clearfix city-price1">
                 <sub> <?php echo Configure::read('site.currency').' '?></sub>
                  <?php echo $this->Html->cCurrency($propertyInfo['Property']['price_per_night']);?>
                  <p class="">
                  <?php echo __l('Per night');?>
                  </p>
            </div>
            </div>
            <div class="clearfix price-info-right">
                 <dl class="clearfix request-list grid_2 omega alpha">
    				<dt><?php echo __l('Per Week');?></dt>
                      <dd>
    				  <?php echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_week']);?></dd>
				  </dl>
 				   <dl class="clearfix request-list grid_2 omega alpha">
    				 <dt><?php echo __l('Per Month');?></dt>
                      <dd>
    				  <?php echo $this->Html->siteCurrencyFormat($propertyInfo['Property']['price_per_month']);?></dd>
				  </dl>
				  </div>
         </div>
      </div>
	</div>
<?php echo $this->Form->create('PropertyFeedback', array('class' => 'normal'));?>

	<div class="massage-view-block clearfix">
	<?php
		//pr($message);
		echo $this->Form->input('property_id',array('type'=>'hidden','value' => $message['property_id']));
		echo $this->Form->input('property_user_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('property_order_id',array('type'=>'hidden','value' => $message['property_order_id']));
		echo $this->Form->input('property_user_id',array('type'=>'hidden','value' => $message['property_user_id']));
		echo $this->Form->input('property_order_user_email',array('type'=>'hidden','value' => $message['property_seller_email']));
		?>
	<div class="massage-head">
	<h2 class="message-user-info">
		<?php echo __l('Review this property and host');?>
    </h2>
	<div>
		<?php 
			$checkin_date = strtotime($propertyInfo['PropertyUser']['checkin']);
			$checkout_date = strtotime($propertyInfo['PropertyUser']['checkout']);
			$days = (($checkout_date - $checkin_date) /(60*60*24)) + 1;
		?>
		<div class="clearfix review-date-info-block grid_15">
		<div class="grid_4">
    		<p ><?php echo date('D, d M Y', $checkin_date); ?></p>
    		<span><?php echo date('h:i a', $checkin_date); ?></span>
        </div>
            <span class="grid_4"><?php echo '(' . $days . ' - ' . __l('nights') . ')'; ?></span>
        <div class="grid_4">
        	<p><?php echo date('D, d M Y', $checkout_date); ?></p>
    		<span><?php echo '11:59 pm'; ?></span>
		</div>
		</div>
	</div>
	<?php
		if (!empty($message['attachment'])) :
			?>
			<h4><?php echo count($message['attachment']).' '. __l('attachments');?></h4>
			<ul>
			<?php
			foreach($message['attachment'] as $attachment) :
		?>
			<li>
			<span class="attachement"><?php echo $attachment['filename']; ?></span>
			<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
			<span><?php echo $this->Html->link(__l('Download') , array( 'controller' => 'messages', 'action' => 'download', $message['message_hash'], $attachment['id'])); ?></span>
			</li>
		<?php
			endforeach;
		?>
		</ul>
		<?php
		endif;
		?> 		</div>
		<fieldset>
		  <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center clearfix">
	
	<div class="propertys-download-block">
        <div class="clearfix">
		<h3 class="grid_6 omega alpha"> <?php echo __l('Are you satisfied in the trips?');?></h3>
	
		<?php
			echo $this->Form->input('is_satisfied',array('label' => __l('Satisfied'),'div'=>'input radio feedback-block grid_8', 'type'=>'radio','legend'=>false,'options'=>array('1'=>__l('Yes'),'0'=>__l('No')),'class' => '' ));
		?>
        </div>
		<div class="js-negative-block <?php echo ($this->request->data['PropertyFeedback']['is_satisfied'] == 0) ? '' : 'hide'; ?>">
			<p class="negative-block-info"><?php echo __l('Please give your host a chance to improve his work before submitting a negative review. ').' '.$this->Html->link(__l('Contact Your Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $message['property_seller_username'],'property_order_id' => $message['property_order_id'], 'review' => '1'), array('title' => __l('Contact Your Seller')));?></p>
		</div>
		<?php
			echo $this->Form->input('feedback',array('label' => __l('Review')));
		?>
	</div>
  
    </div>
	<div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid"></div>
        </div>
    </div>
	</fieldset>
	<div class="page-information"><?php echo __l('Optional: Upload the photos and videos you have taken in/about this property. This will help other future guests.'); ?></div>
<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Photos');?></p>        				
							<div class="picture">
								<ol class=" upload-list clearfix">
									<?php	for($i = 0; $i<Configure::read('propertyfeedbacks.max_upload_photo'); $i++):  ?>
										<li>
											<div class="property-img"> <?php echo $this->Form->uploader('Attachment.'.$i.'.filename', array('id' =>'Attachment.'.$i.'.filename', 'type'=>'file', 'uPreview' => '1', 'uFilecount'=>1, 'uController'=> 'properties', 'uId' => 'PropertyImage'.$i.'',  'uFiletype' => Configure::read('photo.file.allowedExt'))); ?> 
												<span class="property-image-preview" id="preview_image<?php echo $i?>">
													<?php if(!empty($this->request->data['Attachment']) && !empty($this->request->data['Attachment'][$i]['filename'])) :?>
														<?php
															$thumb_url = Router::url(array(
															'controller' => 'joinproperties',
															'action' => 'thumbnail',
															session_id(),
															$this->request->data['Attachment'][$i]['filename'],
															'admin' => false
															) , true);
														?>
														<img src="<?php echo $thumb_url; ?>" /><input type="hidden" name="data[Attachment][<?php echo $i; ?>][filename]" value="<?php echo $this->request->data['Attachment'][$i]['filename']; ?>" /><a href="#" class="js-preview-close {id:<?php echo $i ?>}">&nbsp;</a>
													<?php endif; ?>
												</span>
											</div>
											<div class="js-overlabel">
												<?php  echo $this->Form->input('Attachment.'.$i.'.description', array('type' => 'text', 'label' => __l('Caption'))); ?>
											</div>
										</li>
									<?php
									endfor;
									?>
								</ol>
									
							</div>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>
			</fieldset>
			<fieldset>
	<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Videos');?></p>        				
								<?php echo $this->Form->input('video_url', array('label' => __l('Video URL'))); ?>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>
					</fieldset>
		<div class="clearfix submit-block">
<?php echo $this->Form->submit(__l('Submit'));?>
</div>
</div>
<?php echo $this->Form->end();?>

</div>