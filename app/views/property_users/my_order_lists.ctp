<div class="propertyUsers index side1 grid_18 js-request-responses js-responses js-response">
	<div class="clearfix">
    	<div class="jobs-inbox-option show-block grid_left clearfix">
    		<h5 class="show grid_left"><?php echo __l('Show').':'; ?></h5>
    		<ul class="filter-list grid_left">
    			<li class="list">
    				<?php echo $this->Html->link(__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list status_selected','escape' => false));?>
    			</li>
    			<li class="grid">
    				<?php echo $this->Html->link(__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid','escape' => false));?>
    			</li>
    	   </ul>
    	</div>
	</div>

		<div class="inbox-option select-block clearfix">
			<span class="select"><?php echo __l('Filter: '); ?></span>
			<?php 
				$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
				$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
				$links[] ='<span class="all '.$active_filter.'">' . $this->Html->link(__l('All') . ': ' . (!empty($all_count) ? $all_count : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'status' => 'all', 'view' => 'list', 'admin' => false), array('class' => $stat_class, 'title' => __l('All').': '.(!empty($all_count) ? $all_count : '0'))).'</span>';
				foreach($moreActions as $key => $value):
					$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
					$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active-filter' : null;
					$links[] = '<span class="'. $class_name.' ' . $stat_class .'">' . $this->Html->link($key, array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'view' => 'list','status' => $value,'admin' => false), array('title' => $key)) . '</span>';
				endforeach;
				echo implode(' ',$links);
			?>
			
		</div>
	
	<div class="">
  <div class="block1-tl">
              <div class="block1-tr">
                  <div class="block1-tm"> 
				  <h2><?php echo __l('Trips');?></h2>
                  </div>

              </div>
            </div>

         <div class="block1-cl">
              <div class="block1-cr">
                <div class="block1-cm clearfix">
	
	<ol class="js-response-actions list property-list" start="<?php echo $this->Paginator->counter(array('format' => '%start%'));?>">
	<?php
		if (!empty($propertyUsers)) {
			$i = 0;
			$num = 1;
			foreach ($propertyUsers as $propertyUser) {
				
				$class = null;
				if ($i++ % 2 == 0) {
					$class = 'altrow';
				}
	?>
				<li class=" <?php echo $class;?> js-map-num<?php echo $num; ?> clearfix">
                  
    					<div class="my-order-left grid_3 omega alpha">
                        <div class=" thumb">
    						<?php
								$propertyUser['Property']['Attachment'][0] = !empty($propertyUser['Property']['Attachment'][0]) ? $propertyUser['Property']['Attachment'][0] : array();
    							echo $this->Html->link($this->Html->showImage('Property', $propertyUser['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyUser['Property']['title'], false)), 'title' => $this->Html->cText($propertyUser['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $propertyUser['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['title'], false), 'escape' => false));
    						?>
                            </div>
						<div class="property-user-status select-block">
								<?php
									if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all'):
										$class = '';
										if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
											$class = 'waitingforacceptance';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
											$class = 'confirmed';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Rejected) {
											$class = 'rejected';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Canceled) {
											$class = 'cancelled';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin) {
											$class = 'cancelled';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
											$class = 'arrived';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview) {
											$class = 'waitingforyourreview';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) {
											$class = 'completed';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Expired) {
											$class = 'expired';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
											$class = 'paymentpending';
										} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
											$class = 'confirmed';
										}
								?>
										<span class="round-3 <?php echo $class; ?>">
										<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'],false); ?>
										</span>
								<?php
									endif;
								?>
								<?php
									$negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];
									$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];
									if($propertyUser['PropertyUser']['is_negotiation_requested'] == 1) {
								?>
										<span class="round-3 negotiationrequested "><?php echo __l('Negotiation'); ?></span>
										<span class="round-3 negotiate-amount">
											<?php																				
												$traveler_gross = $traveler_gross;	
												echo '(-'.$this->Html->siteCurrencyFormat($negotiate_discount).')';
											?>
										</span>
								<?php
									}
								?>
    						</div>
    						</div>
				
					<div class="grid_10 alpha omega">
						<div class="clearfix">
							<h2>
								<?php
									$lat = $propertyUser['Property']['latitude'];
									$lng = $propertyUser['Property']['longitude'];
									$id = $propertyUser['Property']['id'];
									echo $this->Html->link($this->Html->cText($propertyUser['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $propertyUser['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($propertyUser['Property']['title'], false),'escape' => false));
								?>
							</h2>
						</div>
						<p class="address-info">
							<?php if(!empty($propertyUser['Property']['Country']['iso2'])): ?>
									<span class="flags flag-<?php echo strtolower($propertyUser['Property']['Country']['iso2']); ?>" title ="<?php echo $propertyUser['Property']['Country']['name']; ?>"><?php echo $propertyUser['Property']['Country']['name']; ?></span>
							<?php endif; ?>
							
							<?php echo $this->Html->cText($propertyUser['Property']['address']);?>
						</p>
						<p class="trip-info">
						<?php echo __l('Trip Id# '); ?>
						<span class="trip-id">
						<?php echo$this->Html->cInt($propertyUser['PropertyUser']['id']);?>
                        </span>
                        <?php echo __l('Host: '); ?>
                        <span class="trip-id">
						<?php echo !empty($propertyUser['Property']['User']['username']) ? $this->Html->link($this->Html->cText($propertyUser['Property']['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['Property']['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['User']['username'],false),'escape' => false)) : ''; ?>
                        </span>
                    	</p>
						<div class="progress-tl">
							<div class="progress-tr">
								<div class="progress-tm"> </div>
							</div>
                        </div>
						<div class="progress-inner clearfix">
							<?php
								$total_days = ((strtotime($propertyUser['PropertyUser']['checkout']) - strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24)) + 1;
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
                            <p class="progress-bar round-5">
								<span class="progress-status round-5" style="width:<?php echo $pixels; ?>%" title="<?php echo $pixels; ?>%">&nbsp;</span>
							</p>
                            <p class="progress-value clearfix">
								<span class="progress-from">
                                             <?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?>
                                </span>
								<span class="progress-to">
                                    <?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkout']);?>
                                 </span>
							</p>
							<p class="progress-value clearfix">
							
						          	<span class="checkin"> <?php echo __l('Check in');?> </span>
                                
							
                                        <span class="checkout"> <?php echo __l('Check out');?> </span>
                                
							</p>
							<?php if(!empty($propertyUser['PropertyUser']['traveler_private_note'])): ?>
							<p class="privacy"><span class="note"><?php echo __l('Private note: '); ?></span><?php echo $this->Html->cText($propertyUser['PropertyUser']['traveler_private_note']);?></p>
							<?php endif; ?>
                         </div>
                        <div class="progress-bl">
							<div class="progress-br">
								<div class="progress-bm"> </div>
							</div>
                        </div>
					</div>
					<div class="city-price grid_4 grid_right omega alpha">
						<div class="clearfix edit-info-block">
						<div class="actions clearfix">
							<?php 

								if (empty($propertyUser['PropertyUser']['is_under_dispute'])) {
									if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived) {
										echo $this->Html->link(__l('Print Ticket'), array('controller' => 'property_user', 'action' => 'view', $propertyUser['PropertyUser']['id'], 'type'=>'print', 'admin' => false), array('class' => 'print-ticket', 'target' => '_blank', 'title'=>__l('Print Ticket'), false, 'escape' => false));  
									}
									if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed  && $propertyUser['PropertyUser']['checkin'] > date('Y-m-d') || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
										echo $this->Html->link(__l('Cancel'), array('controller' => 'payments', 'action' => 'order', $propertyUser['PropertyUser']['property_id'] , 'order_id'=>$propertyUser['PropertyUser']['id'], 'type' => __l('cancel'), 'admin' => false),array('title' => 'Cancel' ,'class' =>'js-delete delete'));
									}

									if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_traveler_checkin']))) {
										if ((($propertyUser['Property']['checkin'] == '00:00:00') || ($propertyUser['Property']['checkin'] <= date('H:i:s'))) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)) {
											echo $this->Html->link(__l('Check in'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkin'), array('class' => 'checkin', 'id'=>'Checkin','title' => __l('Check in')));
										}
									}
									if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_traveler_checkout'])) {
										if (($propertyUser['Property']['checkout'] == '00:00:00') || ($propertyUser['Property']['checkout'] <= date('H:i:s'))) {
											echo $this->Html->link(__l('Check out'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id'=>'Checkout','title' => __l('Check out')));
										}
									}
									if ($this->Auth->user('id') == $propertyUser['PropertyUser']['user_id'] && $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview &&  !empty($propertyUser['PropertyUser']['is_traveler_checkout'])) {
										echo $this->Html->link(__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review js-delete', 'title' => __l('Review')));
									}
								} else {
									echo '<span class="dispute-open">' . __l('Under dispute. Continued only after dispute gets closed.') . '</span>';
								}
							?>
							<?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'view-activities','title'=>__l('View activities')));?>
						<?php	$note_url = Router::url(array(
				'controller' => 'messages',
				'action' => 'activities',
				'order_id' => $propertyUser['PropertyUser']['id'],
			) , true);
			echo $this->Html->link(__l('Private note'), $note_url.'#Private_Note', array('class' => 'add-note', 'title' => __l('Private note'))); 
			if(($this->request->params['named']['status'] == 'negotiation' && !empty($propertyUser['PropertyUser']['is_negotiation_requested']))|| $this->request->params['named']['status'] == 'payment_pending' || ($this->request->params['named']['status'] == 'all' && $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentPending)){		
					echo $this->Html->link(__l('Book it'), array('controller' => 'payments', 'action' => 'order', $propertyUser['PropertyUser']['property_id'], 'order_id:' . $propertyUser['PropertyUser']['id'], 'admin' => false), array('class' => 'book-it', 'title' => __l('Book it')));
			}
			?>
			            
						</div>
						</div>
						<div class="clearfix city-price1">
                      	<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
                         <sub> <?php echo Configure::read('site.currency').' '?></sub>
        				 <?php endif; ?>
                          <?php						
						 echo $this->Html->cCurrency($traveler_gross);?>
        				<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
                         <sub> <?php echo ' '.Configure::read('site.currency');?></sub>
        				 <?php endif; ?>
						</div>
						<?php if(Configure::read('property.is_enable_security_deposit')): ?> 
						<div class="secuirty-deposit">
						+<span class="deposite-info"><?php echo __l('Security Deposit') . ': '; ?></span><span><?php echo $this->Html->siteCurrencyFormat($propertyUser['Property']['security_deposit']); ?></span>
						</div>
						<?php endif; ?>
						<div class="clearfix my-order-request">
							<dl class="request-list1 view-list1 guest clearfix">
								<dt class="positive-feedback1" title ="<?php echo __l('Guests');?>">
									<?php echo __l('Guests');?>
								</dt>
								<dd class="positive-feedback1">
									<?php  echo $this->Html->cInt($propertyUser['PropertyUser']['guests']); ?>
								</dd>
							</dl>
							<!-- @todo "Guest details" -->
							<dl class="request-list1 view-list1 guest clearfix">
								<dt class="positive-feedback1" title ="<?php echo __l('Days');?>">
									<?php echo __l('Days');?>
								</dt>
								<dd class="positive-feedback1">
									<?php
										$days = ((strtotime($propertyUser['PropertyUser']['checkout']) -strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24)) + 1;
										echo $this->Html->cInt($days); 
									?>
								</dd>
							</dl>
						</div>

					</div>
				</li>
	<?php 
				$num++;
			} 
		} else {
	?>
			<li><p class="notice"><?php echo __l('No trips available');?></p></li>
	<?php 
		}
	?>
	</ol>
    <?php
    	if (!empty($propertyUsers)) {
    		if(count($propertyUsers)>0) {
    ?>
    		<div class="js-pagination">
    <?php
    			echo $this->element('paging_links'); ?>
    		</div>
    <?php
    		}
    	}
    ?>
	</div>
	</div>
	</div>
	 <div class="block2-bl">
				  <div class="block2-br">
					<div class="block2-bm"> </div>
				  </div>
				</div>
		</div>
</div>
<div class="side2 grid_6">
	<?php echo $this->element('user-stats'); ?>
</div>