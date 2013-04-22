<ol class="activities-list index">
	<?php
    if (!empty($messages)):
        foreach($messages as $message):
			// quick fix for host review message
			if (!empty($message['Message']['property_user_status_id']) && $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::HostReviewed):
				continue;
			endif;
	?>
		<?php if(!empty($message['Message']['property_user_status_id'])):?>
		
			<!-- DISPUTE -->
			<?php if(!empty($message['Message']['property_user_dispute_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
			<?php
				$avatar_positioning_class = "avatar_middle_container";
				$user_type_container_class = "activities_system_container";
			?>
			<li class="activities-dispute_status clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeOpened):?>
						<?php echo __l('Dispute - Opened');?>
					<?php elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeClosed):?>
						<?php echo __l('Dispute - Closed');?>					
					<?php else:?>
						<?php echo __l('Dispute');?>					
					<?php endif;?>
				</div>
				<div class="grid_9 omega alpha">
					<blockquote>
						<?php echo $this->Html->cText($message['MessageContent']['subject']);?>
					</blockquote>
				</div>
			</li>
			<?php endif;?>
			
			<!-- DISPUTE CONVERSATION -->
			<?php if(!empty($message['Message']['property_user_dispute_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
			<?php
				if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeConversation):
					$status_message = __l('Dispute - Under Discussion');
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];
					endif;
				elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::DisputeAdminAction):
					$avatar_positioning_class = "avatar_middle_container";
					$user_type_container_class = "activities_system_container";
					$status_message = __l('Dispute - Waiting for Administrator Decision');
				elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::AdminDisputeConversation):
					$avatar_positioning_class = "avatar_right_container";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['OtherUser'];
				endif;
			?>
			<li class="activities-dispute_converstation clearfix <?php echo $user_type_container_class;?>">
				<div class="activity-status activities-dispute_converstation">
					<div class="grid_4 omega alpha">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</div>
					<div class="activities-status">
						<?php echo $status_message;?>
					</div>
					<div class="grid_9 omega alpha">
						<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::DisputeAdminAction):?>
							<div class="<?php echo $avatar_positioning_class;?>">	
								<?php if(!empty($avatar['User']['attachment_id'])):?>
								<cite>
									<?php
										$current_user_details = array(
											'username' => $avatar['User']['username'],
											'user_type_id' => $avatar['User']['user_type_id'],
											'id' => $avatar['User']['id'],
											'fb_user_id' => $avatar['User']['fb_user_id']
										);
										$current_user_details['UserAvatar'] = array(
											'id' => $avatar['User']['attachment_id']
										);
										echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
									?>
								</cite>
								<?php endif;?>
								<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
							</div>
						<?php endif;?>
						<div <?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::DisputeAdminAction):?> class="avatar-info-block" <?php endif;?>>
							<?php echo $this->Html->cText($message['MessageContent']['message']);?>
						</div>
					</div>
				</div>
			</li>
			<?php endif;?>
			
			<!-- WORK DELIVERED/REVIEWED -->
			<?php if(!empty($message['Message']['property_user_status_id']) && ($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered || $message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>
				<?php
					if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkDelivered):
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];
					elseif($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed):
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
					endif;
				?>
				<li class="activities-normal_converstation clearfix <?php echo $user_type_container_class;?>">				
					<div class="grid_4 omega alpha">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</div>
					<div class="activities-status">
						<?php echo __l('Conversation');?>
					</div>
					<div class="grid_9 omega alpha">
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite>
								<?php
									$current_user_details = array(
										'username' => $avatar['User']['username'],
										'user_type_id' => $avatar['User']['user_type_id'],
										'id' => $avatar['User']['id'],
										'fb_user_id' => $avatar['User']['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['User']['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
		
							<div class="avatar-info-block">
								<blockquote>
								   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
								</blockquote>
								<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WorkReviewed && !empty($message['PropertyUser']['PropertyFeedback'])):?>
									<?php $rating_class = ($message['PropertyUser']['PropertyFeedback']['is_satisfied']) ? 'positive-feedback' : 'negative-feedback';?>
									(<span class="feedback-list <?php echo $rating_class;?>"><?php echo ($message['PropertyUser']['PropertyFeedback']['is_satisfied']) ? __l('Rated Positive') : __l('Rated Negative');?></span>)
								<?php endif;?>	
								<ul class="attachement-list">
								<?php
									$attachment = !empty($message['MessageContent']['Attachment']['0']) ? $message['MessageContent']['Attachment']['0'] : '';
									if (!empty($message['MessageContent']['Attachment']['0'])) :
										echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
									endif;
								?>
								</ul>
							</div>
					
				</div>
				</li>
			<?php endif;?>
			
			<!-- ORDER STATUS CHANGED -->
			<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SenderNotification && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WorkDelivered  && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WorkReviewed && empty($message['Message']['property_user_dispute_id']) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::RequestNegotiation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::SecurityDepositRefund):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					// Avatar positioning //
						$avatar_positioning_class = "avatar_middle_container";
						$user_type_container_class = "activities_system_container";
						if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin):
							$user_type_container_class = "activities_administrator_container";
							$avatar_positioning_class = "avatar_admin_container";
						endif;
					// Eop //
				
				?>
				<?php if($message['Message']['property_user_status_id'] != ConstPropertyUserStatus::Arrived && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::WaitingforReview):?>
				<li class="activities-status_<?php echo $message['PropertyUserStatus']['slug'];?> activity-status clearfix <?php echo $user_type_container_class;?>">
					<div class="grid_4 omega alpha">
						<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
					</div>
					<div class="activities-status">
						<?php echo $message['PropertyUserStatus']['name'];?>
					</div>
					<div class="grid_9 omega alpha">
						<blockquote>
							<?php echo $this->Html->conversationDescription($message);?>
						</blockquote>
					</div>
				
				</li>
				<?php endif;?>
				<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):?>
					<?php 
						$checked_ins = array('is_auto_checkin' => 'auto_checkin_date', 'is_host_checkin' => 'host_checkin_date', 'is_traveler_checkin' => 'traveler_checkin_date');
						foreach($checked_ins as $key => $value):
							if(!empty($message['PropertyUser'][$key])):?>
								<li class="activities-status_<?php echo $message['PropertyUserStatus']['slug'];?> activity-status clearfix <?php echo $user_type_container_class;?>">
									<div class="grid_4 omega alpha">
										<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
									</div>
									<div class="activities-status">
										<?php
											if($key == 'is_auto_checkin'):
												echo __l('Arrived - Auto');
											elseif($key == 'is_host_checkin'):
												echo __l('Arrived - Host');
											elseif($key == 'is_traveler_checkin'):
												echo __l('Arrived - Traveler');
											endif;
										?>
									</div>
									<div class="grid_9 omega alpha">
										<blockquote>
											<?php
												if($key == 'is_auto_checkin'):
													echo __l('Status changed automatically to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_host_checkin'):
													echo __l('Host changed the status to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_traveler_checkin'):
													echo __l('Traveler changed the status to "Arrived". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												endif;
											?>
										</blockquote>
									</div>
								
								</li>
							<?php endif;						
						endforeach;					
					?>					
				<?php endif;?>
				<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview):?>
					<?php 
						$checked_outs = array('is_auto_checkout' => 'auto_checkout_date', 'is_host_checkout' => 'host_checkout_date', 'is_traveler_checkout' => 'traveler_checkout_date');
						foreach($checked_outs as $key => $value):
							if(!empty($message['PropertyUser'][$key])):?>
								<li class="activities-status_<?php echo $message['PropertyUserStatus']['slug'];?> activity-status clearfix <?php echo $user_type_container_class;?>">
									<div class="grid_4 omega alpha">
										<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
									</div>
									<div class="activities-status">
										<?php
											if($key == 'is_auto_checkout'):
												echo __l('Checked Out - Auto');
											elseif($key == 'is_host_checkout'):
												echo __l('Checked Out - Host');
											elseif($key == 'is_traveler_checkout'):
												echo __l('Checked Out - Traveler');
											endif;
										?>
									</div>
									<div class="grid_9 omega alpha">
										<blockquote>
											<?php
												if($key == 'is_auto_checkout'):
													echo __l('Status changed automatically to "Checked Out". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_host_checkout'):
													echo __l('Host changed the status to "Checked Out". Changed at') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												elseif($key == 'is_traveler_checkout'):
													echo __l('Traveler changed the status to "Checked Out"') . ' ' . $this->Html->cDateTimeHighlight($message['PropertyUser'][$value]);
												endif;
											?>
										</blockquote>
									</div>
								
								</li>
							<?php endif;						
						endforeach;					
					?>					
				<?php endif;?>
			<?php endif;?>
			<!-- NEGOTIATE -->
			<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::NegotiateConversation):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];						
					endif;
				
				?>
				
				<li class="activities-negotiate_msg clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php echo __l('Negotiation Conversation')?>
				</div>
				<div class="grid_9 omega alpha">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite>
								<?php
									$current_user_details = array(
										'username' => $avatar['User']['username'],
										'user_type_id' => $avatar['User']['user_type_id'],
										'id' => $avatar['User']['id'],
										'fb_user_id' => $avatar['User']['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['User']['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					<blockquote>
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</blockquote>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
						}
					?>
					</ul>
					</div>
				</div>
		</li>
		<?php endif;?>
		<!-- PRIVATE NOTE -->
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::PrivateConversation && $message['Message']['user_id'] == $this->Auth->user('id')):?>				
				<?php
					$avatar_positioning_class = "avatar_right_container";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['User'];					
				?>
				
				<li class="activities-private_note clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php echo __l('Private Note'); ?>
				</div>
				<div class="grid_9 omega alpha">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<?php if(!empty($avatar['UserAvatar']['id'])):?>
							<cite>
								<?php
									$current_user_details = array(
										'username' => $avatar['User']['username'],
										'user_type_id' => $avatar['User']['user_type_id'],
										'id' => $avatar['User']['id'],
										'fb_user_id' => $avatar['User']['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['User']['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<?php endif;?>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					<blockquote>
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</blockquote>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
						}
					?>
					</ul>
					</div>
				</div>
		</li>
		<?php endif;?>
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::RequestNegotiation):?>				
				<?php
					$avatar_positioning_class = "avatar_right_container";
					$user_type_container_class = "activities_buyer_container";
					$avatar = $message['User'];					
				?>
				
				<li class="activities-private_note clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php echo __l('Private Note'); ?>
				</div>
				<div class="grid_9 omega alpha">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<?php if(!empty($avatar['UserAvatar']['id'])):?>
							<cite>
								<?php
									$current_user_details = array(
										'username' => $avatar['username'],
										'user_type_id' => $avatar['user_type_id'],
										'id' => $avatar['id'],
										'fb_user_id' => $avatar['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<?php endif;?>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					<blockquote>
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</blockquote>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
						}
					?>
					</ul>
					</div>
				</div>
		</li>
		<?php endif;?>
		<!-- MESSAGE FROM TRAVELER -->
		<?php if($message['Message']['property_user_status_id'] == ConstPropertyUserStatus::FromTravelerConversation):?>				
				<?php
					$avatar_positioning_class = '';
					$avatar = array();
					if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
						$avatar_positioning_class = "avatar_right_container";
						$user_type_container_class = "activities_buyer_container";
						$avatar = $message['PropertyUser']['User'];
						
					elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
						$avatar_positioning_class = "avatar_left_container";
						$user_type_container_class = "activities_seller_container";
						$avatar = $message['Property']['User'];						
					endif;			
				?>
				
				<li class="activities-from_traveler clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php echo __l('From Traveler'); ?>
				</div>
				<div class="grid_9 omega alpha">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite>
								<?php
									$current_user_details = array(
										'username' => $avatar['User']['username'],
										'user_type_id' => $avatar['User']['user_type_id'],
										'id' => $avatar['User']['id'],
										'fb_user_id' => $avatar['User']['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['User']['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					<blockquote>
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</blockquote>
					<ul class="attachement-list">
					<?php
						if(isset($message['MessageContent']['Attachment']['0'])){
						$attachment = $message['MessageContent']['Attachment']['0'];
							if (!empty($message['MessageContent']['Attachment']['0'])) :
								echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
							endif;
						}
					?>
					</ul>
					</div>
				</div>
		</li>
		<?php endif;?>
		<?php else:?>
		
		<!-- NORMAL CONVERSATION -->
		<?php
			$avatar_positioning_class = '';
			$avatar = array();
			if($message['Message']['user_id'] == $message['PropertyUser']['owner_user_id']): // if message is to seller, then, requester is buyer //
				$avatar_positioning_class = "avatar_right_container";
				$user_type_container_class = "activities_buyer_container";
				$avatar = $message['PropertyUser']['User'];
				$status_name = __l('Mutual cancel request');
			elseif($message['Message']['user_id'] == $message['PropertyUser']['user_id']): // if message is to buyer, then, requester is seller //
				$avatar_positioning_class = "avatar_left_container";
				$user_type_container_class = "activities_seller_container";
				$avatar = $message['Property']['User'];
				$status_name = __l('Mutual cancel request');
			endif;
		?>
		<li class="activities-normal_converstation clearfix <?php echo $user_type_container_class;?>">
				<div class="grid_4 omega alpha">
					<?php echo $this->Time->timeAgoInWords($message['Message']['created']);?>
				</div>
				<div class="activities-status">
					<?php echo __l('Conversation'); ?>
				</div>
				<div class="grid_9 omega alpha">
					<?php if($avatar_positioning_class == "avatar_left_container" || $avatar_positioning_class == "avatar_right_container"):?>
						<div class="<?php echo $avatar_positioning_class;?>">	
							<cite>
								<?php 
									$current_user_details = array(
										'username' => $avatar['User']['username'],
										'user_type_id' => $avatar['User']['user_type_id'],
										'id' => $avatar['User']['id'],
										'fb_user_id' => $avatar['User']['fb_user_id']
									);
									$current_user_details['UserAvatar'] = array(
										'id' => $avatar['User']['attachment_id']
									);
									echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
								?>
							</cite>
							<span><?php echo $this->Html->cText($avatar['username'], false);?></span>
						</div>
					<?php endif;?>
					<div class="">
					<blockquote>
					   <?php echo $this->Html->cText($message['MessageContent']['message']);?>
					</blockquote>
					<ul class="attachement-list">
					<?php
						$attachment = $message['MessageContent']['Attachment']['0'];
						if (!empty($message['MessageContent']['Attachment']['0'])) :
							echo "<li>".__l('Attached').': '.$this->Html->link($attachment['filename'] , array( 'controller' => 'messages', 'action' => 'download', $message['Message']['hash'], $attachment['id']))."</li>";
						endif;
					?>
					</ul>
					</div>
				</div>
		</li>
		<?php endif;?>
        <?php
        endforeach;
    endif;
    ?>
</ol>