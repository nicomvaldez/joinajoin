<div class="side1 grid_18">
	<?php echo $this->element('booking_guideline', array('config' => 'sec')); ?>
	<?php echo !empty($orders) ? $this->element('properties-simple-view', array('slug' => $orders['Property']['slug'], 'order_id' => $orders['PropertyUser']['id'], 'config' => 'sec')) : ''; ?>
<div class="pptview-mblock-tl">
<div class="pptview-mblock-tr">
            <div class="pptview-mblock-tt"></div>
            </div>
          </div>
		  <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">

  
	  <div class="clearfix">

		<div class="property-stats-left-block grid_4 omega alpha">
			<p class="property-stats-bar-block clearfix"><?php echo __l('Made On');?><span class="stats-val"><?php echo $this->Html->cDateTimeHighlight($orders['PropertyUser']['created']);?></span></p>
			<p><?php echo __l('Completed?');?><span class="stats-val"><?php echo (!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) ? __l('Yes'): __l('No');?></span></p>			
			<?php if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')):?>
				<p><?php echo __l('Discount'). ' ('.$orders['PropertyUser']['negotiation_discount'].'%)';?><span class="stats-val"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount']);?></span></p>
				<p><?php echo __l('Gross Amount');?><span class="stats-val"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] - $orders['PropertyUser']['host_service_amount']);?></span></p>
			<?php else: ?>
				<p><?php echo __l('Discount'). ' ('.$orders['PropertyUser']['negotiation_discount'].'%)';?><span class="stats-val"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['negotiate_amount']);?></span></p>
				<p><?php echo __l('Gross Amount');?><span class="stats-val"><?php echo $this->Html->siteCurrencyFormat($orders['PropertyUser']['price'] + $orders['PropertyUser']['traveler_service_amount']);?></span></p>
			<?php endif; ?>
		  </div>
              	<div class="property-stats-left-block grid_8 omega alpha">
        <p><?php echo __l('Current Status');?><span class="stats-val">
          
            
        	<?php if(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed):
			 echo __l('Completed');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance):
			 echo __l('Waiting for Acceptance');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed):
			 echo __l('Confirmed');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Rejected):
			 echo __l('Rejected');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Canceled):
			 echo __l('Canceled');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):
			 echo __l('Arrived');
			elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared):
			 echo __l('Payment Cleared');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Expired):
			 echo __l('Expired');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin):
			 echo __l('Canceled By Admin');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending):
			 echo __l('Payment Pending');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation):
			 echo __l('Admin Dispute Conversation');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction):
			 echo __l('Admin Dispute Action');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed):
			 echo __l('Work Reviewed');
			 elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered):
			 echo __l('Work Delivered');
			  elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosedTemp):
			 echo __l('Dispute closed temporarily');
			  elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed):
			 echo __l('Dispute Closed');
			  elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation):
			 echo __l('Distpute Conversation');
			  elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened):
			 echo __l('Dispute Opened');
			  elseif(!empty($orders['PropertyUser']['property_user_status_id']) &&  $orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::SenderNotification):
			 echo __l('Sender Notification');
			 endif;

			 if(empty($orders['PropertyUser']['message']))
			 {
				 $orders['PropertyUser']['message']=__l('n/a');
			 }
			?>
			</span></p>
			<?php if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')):?>
				<p class="property-stats-bar-block clearfix"><?php echo __l('Traveler name');?><span class="stats-val"><?php  echo $this->Html->link($orders['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['User']['username'], 'admin' => false));?> (<?php  echo $this->Html->link(__l('Contact Traveler'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['User']['username'], 'admin' => false));?>)</span></p>
			<?php elseif($orders['PropertyUser']['user_id'] == $this->Auth->user('id')):?>
				<p class="property-stats-bar-block clearfix"><?php echo __l('Host name');?><span class="stats-val"><?php  echo $this->Html->link($orders['Property']['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['Property']['User']['username'], 'admin' => false));?> (<?php  echo $this->Html->link(__l('Contact Host'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['Property']['User']['username'], 'admin' => false));?>)</span></p>
			<?php else:?>
				<p class="property-stats-bar-block clearfix"><?php echo __l('Traveler name');?><span class="stats-val"><?php  echo $this->Html->link($orders['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['User']['username'], 'admin' => false));?> (<?php  echo $this->Html->link(__l('Contact Traveler'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['User']['username'], 'admin' => false));?>)</span></p>
				<p class="property-stats-bar-block clearfix"><?php echo __l('Host name');?><span class="stats-val"><?php  echo $this->Html->link($orders['Property']['User']['username'], array('controller' => 'users', 'action' => 'view', $orders['Property']['User']['username'], 'admin' => false));?> (<?php  echo $this->Html->link(__l('Contact Host'), array('controller' => 'messages', 'action' => 'compose','type'=>'contact', 'to'=>$orders['Property']['User']['username'], 'admin' => false));?>)</span></p>
			<?php endif;?>	
			<?php if(Configure::read('property.is_enable_security_deposit')): ?>
			<p class="property-stats-bar-block clearfix"><?php echo __l('Security Deposit');?><span class="stats-val"><?php echo $this->Html->siteCurrencyFormat($orders['Property']['security_deposit']); ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></p>
			<?php endif; ?>
        </div>
	  </div>

<div class="activities-information-block">
	<h3><?php echo __l('Activities');?></h3>	
		<?php $show_checkinout = array();?>
		<?php echo $this->element('message-index-conversation', array('order_id' => $orders['PropertyUser']['id'], 'config' => 'sec')); ?>
		<h3><?php echo __l('Response and actions'); ?></h3>
		<?php if ($orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::CanceledByAdmin && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Canceled && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Rejected && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Expired): ?>
			<?php if((empty($this->request->params['named']['type']) && $orders['PropertyUserStatus']['id'] != ConstPropertyUserStatus::Completed) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed )):?>
				<a name="review_your_work"></a>
				<a name="complete_your_work"></a>
				<a name="deliver_your_work"></a>
				<div class="js-response-actions status-link ui-tabs-block clearfix">
					<?php $is_show_manage_bar = 1;?>
					<?php if (empty($orders['PropertyUser']['is_under_dispute']) || $orders['PropertyUser']['is_under_dispute']== 0): // check property order have any dispute post or not?> 
						<?php if($orders['PropertyUser']['owner_user_id'] == $this->Auth->user('id')): // Seller?>
						<?php 
							if ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance):
								echo $this->Html->link(__l('Confirm'), array('controller' => 'property_users', 'action' => 'update_order', $orders['PropertyUser']['id'], 'accept', 'admin' => false, '?r=' . $this->request->url), array('class'=>'confirm js-delete','title' => __l('Confirm')));
								echo $this->Html->link(__l('Reject'), array('controller' => 'property_users', 'action' => 'update_order', $orders['PropertyUser']['id'], 'reject', 'admin' => false, '?r=' . $this->request->url), array('class'=>'cancel js-delete','title' => __l('Reject')));
							endif;
							if (($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $orders['PropertyUser']['checkin']) && (empty($orders['PropertyUser']['is_host_checkin']))):
								if((($orders['Property']['checkin'] == '00:00:00') || ($orders['Property']['checkin'] <= date('H:i:s'))) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)):
									$show_checkinout['show'] = 1;
									$show_checkinout['value'] = __l('Check in');
									$show_checkinout['title'] = 'Checkin';
									$show_checkinout['action'] = 'check_in';
								endif;
							endif;
							if ($this->Auth->user('id') == $orders['PropertyUser']['owner_user_id'] && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed) && empty($orders['PropertyUser']['is_host_reviewed'])):
								echo $this->Html->link(__l('Review'), array('controller'=>'property_user_feedbacks','action'=>'add','property_order_id' => $orders['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review')));
							endif;
							if(empty($show_checkinout) && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $orders['PropertyUser']['checkout']) && empty($orders['PropertyUser']['is_host_checkout'])):
								if(($orders['Property']['checkout'] == '00:00:00') || ($orders['Property']['checkout'] <= date('H:s:i'))):
									$show_checkinout['show'] = 1;
									$show_checkinout['value'] = __l('Check out');
									$show_checkinout['title'] = 'Checkout';
									$show_checkinout['action'] = 'check_out';
								endif;
							endif;
						?>
					<?php else:	// Buyer ?>
						<?php
							if($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance || ($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed && $orders['PropertyUser']['checkin'] > date('Y-m-d'))):
								echo $this->Html->link(__l('Cancel'), array('controller' => 'payments', 'action' => 'order', $orders['PropertyUser']['property_id'] , 'order_id'=>$orders['PropertyUser']['id'], 'type' => __l('cancel'), 'admin' => false),array('title' => 'Cancel' ,'class' =>'delete'));
							endif;
							if($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && $orders['PropertyUser']['user_id']==$this->Auth->User('id')):
								echo $this->Html->link(__l('Book It'), array('controller' => 'payments', 'action' => 'order', $orders['Property']['id'], 'order_id:' . $orders['PropertyUser']['id'], 'admin' => false), array('class' => 'complete-booking js-delete','title' => __l('Book It')));
							endif;
							if($this->Auth->user('id')==$orders['PropertyUser']['user_id'] && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared)  &&  !empty($orders['PropertyUser']['is_traveler_checkout'])):
								echo $this->Html->link(__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $orders['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review')));
							endif;

							$is_show_manage_bar = 0;
							// seperate the blocks, to show both checkin and checkout on multiple cases //						
							if (($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $orders['PropertyUser']['checkin']) && (empty($orders['PropertyUser']['is_traveler_checkin']))):
								if ((($orders['Property']['checkin'] == '00:00:00') || ($orders['Property']['checkin'] <= date('H:i:s'))) || ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)):
									$show_checkinout['show'] = 1;
									$show_checkinout['value'] = __l('Check in');
									$show_checkinout['title'] = 'Checkin';
									$show_checkinout['action'] = 'check_in';
									?>
									<?php
								endif;
							endif;
							if(empty($show_checkinout) && ($orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $orders['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $orders['PropertyUser']['checkout']) && empty($orders['PropertyUser']['is_traveler_checkout'])):
								if(($orders['Property']['checkout'] == '00:00:00') || ($orders['Property']['checkout'] <= date('H:i:s'))):
									$show_checkinout['show'] = 1;
									$show_checkinout['value'] = __l('Check out');
									$show_checkinout['title'] = 'Checkout';
									$show_checkinout['action'] = 'check_out';
								endif;
							endif;	
						?>
					<?php endif; ?>
				<?php else:?>
					<?php 
						echo __l('Under dispute. Actions can be continued only after dispute gets closed.');
						// Dispute compose or response //
						$this->request->params['named']['type'] = !empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '';
						echo $this->element('message-dispute-response', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
						echo $this->element('property-order-dispute-resolve', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
					?>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<?php 
				if (!empty($orders['PropertyUser']['is_under_dispute'])): // check property order have any dispute post or not
					echo __l('Under dispute. Actions can be continued only after dispute gets closed.');
					// dispute compose or response 
					echo $this->element('message-dispute-response', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->request->params['named']['type'], 'config' => 'sec'));
					echo $this->element('property-order-dispute-resolve', array('order_id' => $orders['PropertyUser']['id'], 'type' => $this->params['named']['type'], 'config' => 'sec'));
				endif;
			?>
		<?php endif; ?>
	<?php endif; ?>

<div class="js-dispute-container ui-tabs-block clearfix">
<?php if(empty($this->request->params['named']['type']) ):?>
<div class="js-tabs disputes-order-block clearfix">
	<ul class="clearfix  ui-tabs-nav">
	<?php
		if ($orders['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($orders['PropertyUser']['is_negotiation_requested'])) {
	?>
			<li class="negotiation"><?php echo $this->Html->link(__l('Negotiation'), array('controller' => 'messages', 'action' => 'simple_compose', 'order_id' => $orders['PropertyUser']['id']), array('title' => __l('Negotiation')));?></li>
	<?php
		}
	?>
	<?php if(!empty($show_checkinout['show'])):?>
		<li class="check-in"><?php echo $this->Html->link($show_checkinout['value'], array('controller' => 'property_users', 'action' => 'process_checkinout', 'order_id' => $orders['PropertyUser']['id'], 'p_action' => $show_checkinout['action']), array('title' => $show_checkinout['title']));?></li>
	<?php endif;?>
	<li class=" private-note"><?php echo $this->Html->link(__l('Private Note'), array('controller' => 'messages', 'action' => 'simple_compose', 'order_id' => $orders['PropertyUser']['id'], 'conversaction_type'=> 'private'), array('title' => __l('Private Note')));?></li>
	<li class="dispute"><?php echo $this->Html->link(__l('Dispute'), array('controller' => 'property_users', 'action' => 'manage', 'property_user_id' => $orders['PropertyUser']['id']), array('title' => __l('Dispute')));?></li>
    </ul>
</div>
<?php endif;?>
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