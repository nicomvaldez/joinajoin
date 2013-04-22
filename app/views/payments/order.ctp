<?php /* SVN: $Id: $ */ ?>
<?php
if(!empty($this->request->params['isAjax'])):
	echo $this->element('flash_message', array('config' => 'sec'));
endif;
//debug($user_info['User']['id']);
?>

<div class="side1 grid_18">
	<div class="clearfix gigs-view-info-blocks">
	<?php  if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
		<h2><?php echo __l('Pricing Negotiation');?></h2>
	<?php  elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
		<h2><?php echo __l('Booking Request Confirm');?></h2>
	<?php  elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'):?>
		<h2><?php echo __l('Booking Cancel Process');?></h2>
	<?php elseif(!empty($this->request->params['named']['order_id'])):?>
		<h2><?php echo __l('Book It');?></h2>
	<?php endif;?>
	<div class="clearfix">
		<div class="grid_4 view-thumb-block omega alpha">
			<div class="thumb">
				<span>
					<?php
						echo $this->Html->link($this->Html->showImage('Property', $itemDetail['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemDetail['Property']['title'], false)), 'title' => $this->Html->cText($itemDetail['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($itemDetail['Property']['title'],false),'escape' => false));
					?>
				</span>
			</div>
		</div>
		<div class="grid_10 alpha omega">
			<div class="clearfix">
				<div class="grid_1 user-avatar alpha omega">
					<?php
						$current_user_details = array(
							'username' => $itemDetail['User']['username'],
							'user_type_id' => $itemDetail['User']['user_type_id'],
							'id' => $itemDetail['User']['id'],
							'fb_user_id' => $itemDetail['User']['fb_user_id']
						);
						$current_user_details['UserAvatar'] = array(
							'id' => $itemDetail['User']['attachment_id']
						);
						echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
					?>
				</div>
				<div class="grid_9 user-avatar ">
					<div class="clearfix">
						<h3 class="properties-title">
							<?php
								$lat = $itemDetail['Property']['latitude'];
								$lng = $itemDetail['Property']['longitude'];
								$id = $itemDetail['Property']['id'];
								echo $this->Html->link($this->Html->cText($itemDetail['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $itemDetail['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($itemDetail['Property']['title'], false),'escape' => false));
								$flexible_class = '';
								if (!empty($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] == 1) {
									if(!in_array($itemDetail['Property']['id'], $booked_property_ids) && in_array($itemDetail['Property']['id'], $exact_ids)) {
							?>
							<span class="exact round-3"> <?php echo __l('exact'); ?></span>
							<?php
									}
								}
								if(Configure::read('property.is_property_verification_enabled') && $itemDetail['Property']['is_verified']):
							?>
								<span class="isverified"> <?php echo __l('verified'); ?></span>
							<?php
								endif;
							?>
							<?php if($itemDetail['Property']['is_featured']): ?>
								<span class="featured round-3 isfeatured"> <?php echo __l('featured'); ?></span>
							<?php endif; ?>
						</h3>
					</div>
					<p class="address-info">
						<?php if(!empty($itemDetail['Country']['iso2'])): ?>
							<span class="flags flag-<?php echo strtolower($itemDetail['Country']['iso2']); ?>" title ="<?php echo $itemDetail['Country']['name']; ?>"><?php echo $itemDetail['Country']['name']; ?></span>
						<?php endif; ?>
						<?php echo $this->Html->cText($itemDetail['Property']['address']);?>
					</p>
				</div>
			</div>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
			<div class="clearfix js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
				<?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($itemDetail[0]['distance'])): ?>
					<dl class="clearfix guest request-list1">
						<dt><?php echo __l('Distance');?><span class="km"> <?php echo __l('(km)');?></span></dt>
						<dd><?php echo $this->Html->cInt($itemDetail[0]['distance']*1.60934 ,false); ?></dd>
					</dl>
				<?php endif; ?>
				<dl class="request-list1 view-list1 guest clearfix">
					<dt class="positive-feedback1" title ="<?php echo __l('View');?>"><?php echo __l('Views');?></dt>
					<dd class="positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $itemDetail['Property']['id']; ?> {'id':'<?php echo $itemDetail['Property']['id']; ?>'}"><?php  echo $this->Html->cInt($itemDetail['Property']['property_view_count']); ?></dd>
				</dl>
				<dl class="ratings-feedback1 clearfix">
					<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
					<dd class="positive-feedback1"><?php  echo $this->Html->cInt($itemDetail['Property']['positive_feedback_count']); ?></dd>
				</dl>
				<dl class="ratings-feedback1 clearfix">
					<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
					<dd  class="negative-feedback1"><?php  echo $this->Html->cInt($itemDetail['Property']['property_feedback_count'] - $itemDetail['Property']['positive_feedback_count']); ?></dd>
				</dl>
				<dl class="clearfix  request-list1 request-index-list success-rate-list">
					<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
					<?php if(empty($itemDetail['Property']['property_feedback_count'])): ?>
						<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php else:?>
						<dd class="success-rate">
						<?php
										if(!empty($itemDetail['Property']['positive_feedback_count'])):
										$positive = floor(($itemDetail['Property']['positive_feedback_count']/$itemDetail['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?>
							
						</dd>
					<?php endif; ?>
				</dl>
			</div>
		</div>
		<div class="city-price grid_right grid_4 omega alpha">
			<div class="clearfix edit-info-block">
				<?php if ($itemDetail['Property']['user_id'] == $this->Auth->user('id')) : ?>
					<div class="actions clearfix"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $itemDetail['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $itemDetail['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
				<?php endif; ?>
			</div>
			<div class="city-price grid_right grid_4 omega alpha">
				<div class="clearfix city-price1">
					<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
						<sub> <?php echo Configure::read('site.currency').' '?></sub>
					<?php endif; ?>
					<?php echo $this->Html->cCurrency($itemDetail['Property']['price_per_night']);?>
					<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
						<sub> <?php echo ' '.Configure::read('site.currency'); ?></sub>
					<?php endif; ?>
					<p><?php echo (empty($itemDetail['Property']['price_per_week']))? __l('Per night'):__l('Per Join');?></p>
				</div>
			</div>
			<div class="clearfix price-info-right">
				<!--<dl class="clearfix request-list grid_2 omega alpha">
					<dt><?php echo __l('Per Week');?></dt>
					<dd>
						<?php
							if($itemDetail['Property']['price_per_week']!=0):
								echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_week']);
							else:
								echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*7);
							endif;
						?>
					</dd>
				</dl>
				<dl class="clearfix request-list grid_2 omega alpha">
					<dt><?php echo __l('Per Month');?></dt>
					<dd>
						<?php
							if($itemDetail['Property']['price_per_month']!=0):
								echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_month']);
							else:
								echo $this->Html->siteCurrencyFormat($itemDetail['Property']['price_per_night']*30);
							endif;
						?>
					</dd>
				</dl>
			-->	
			</div>
			<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='related' ): ?>
				<?php if($this->Auth->user('id')!=$itemDetail['Property']['user_id']): ?>
					<div class="clearfix">
						<div class="cancel-block"><?php echo $this->Html->link(__l('Book it!'), array('controller' => 'properties', 'action' => 'view',$itemDetail['Property']['slug'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false)); ?></div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="pptview-mblock-tl">
	<div class="pptview-mblock-tr">
		<div class="pptview-mblock-tt"></div>
	</div>
</div>
<?php
						$additional_guest = (!empty($itemDetail['PropertyUser'][0]['guests']) && ($itemDetail['PropertyUser'][0]['guests'] - $itemDetail['Property']['additional_guest']) > 0) ? ($itemDetail['PropertyUser'][0]['guests'] - $itemDetail['Property']['additional_guest']) : 0;
						$additional_guest_price = 0;
						if($additional_guest > 0) {
							$additional_guest_price = $additional_guest * $itemDetail['Property']['additional_guest_price'];
						}
						$security_deposit=$itemDetail['PropertyUser'][0]['security_deposit'];
						$days = (!empty($itemDetail['PropertyUser'][0]['checkout']) && !empty($itemDetail['PropertyUser'][0]['checkin'])) ? (((strtotime($itemDetail['PropertyUser'][0]['checkout']) -strtotime($itemDetail['PropertyUser'][0]['checkin'])) / (60*60*24)) + 1) : 1;
						$price = $itemDetail['PropertyUser'][0]['price'];
						$service_fee = $itemDetail['PropertyUser'][0]['traveler_service_amount'];
						$total = $service_fee + $price;
						if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])):
							$price = !empty($itemDetail['PropertyUser'][0]['original_price']) ? $itemDetail['PropertyUser'][0]['original_price'] : 0;
							$total = $service_fee + $price;
							$discount= !empty($itemDetail['PropertyUser'][0]['negotiate_amount']) ? $itemDetail['PropertyUser'][0]['negotiate_amount'] : 0;
							$total = $total - $discount;
							$price = $price - $discount;
						endif;
					  if(Configure::read('property.is_enable_security_deposit')):
					  $total = $total + $security_deposit;
					  endif;
					?>
<div class="pptview-mblock-ll">
	<div class="pptview-mblock-rr">
		<div class="pptview-mblock-mm clearfix user-order-block">
			<div class="main-center-block">
                <?php if(Configure::read('user.signup_fee')==0 || $this->Auth->sessionValid() || (!$this->Auth->sessionValid() && Configure::read('user.signup_fee')==0) ): ?>
            				<div class="payments payments-order order js-responses js-main-order-block js-submit-target-block">
					<?php  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
						<div class="page-information"><?php echo sprintf(__l('Host may confirm booking with other guests while you %s negotiate. So, make your negotiation short and genuine to avoid disappointments.'), '<em>still</em>'); ?></div>
					<?php endif; ?>
					<?php  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
						<div class="page-information"><?php echo __l('You can give whatever discount, but admin commission will be calculated on your property cost!'); ?></div>
					<?php endif; ?>
					<?php echo $this->Form->create('Payment', array('controller' => 'payment', 'action' => 'order', 'id' => 'PaymentOrderForm', 'class' => 'js-submit-target normal')); ?>
                    <?php if(!$this->Auth->sessionValid() && Configure::read('user.is_enable_normal_registration')): ?>
<!--                    	
                    	<fieldset>
							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center user-padd-center">
						<?php
						/*
							echo $this->Form->input('User.username',array('label' => __l('Username'),'info' => __l('Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed')));
							echo $this->Form->input('User.email',array('label' => __l('Email')));
							echo $this->Form->input('User.passwd', array('label' => __l('Password')));
						
						 * 
						 */?>
							</div>
							<div class="padd-bg-bl">
									<div class="padd-bg-br">
										<div class="padd-bg-bmid"></div>
									</div>
							</div>
						</fieldset>
-->
						
					<?php elseif(!empty($user['User']['fb_user_id']) && empty($user['User']['email'])): ?>
							<?php echo $this->Form->input('User.email',array('label' => __l('Email'))); ?>
					<?php endif; ?>
					
					<?php if(isset($this->request->params['named']['type'])) : ?>
						<fieldset>

							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center">
								<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']!='cancel'):?>
									<?php echo $this->Form->input('PropertyUser.message',array('label' => __l('Message to Host'),'div' =>'input textarea host-textarea')); ?>
									<?php echo $this->Form->input('PropertyUser.from_id',array('type'=>'hidden', 'value'=>$user_info['User']['id'])); ?>
								<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'): ?>
									<dl class="cancel-list list clearfix">
											<?php if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Confirmed): ?>
											<?php
												if ($itemDetail['CancellationPolicy']['percentage'] == '0.00') {
													$percentage = 'No';
												} elseif ($itemDetail['CancellationPolicy']['percentage'] == '100.00') {
													$percentage = 'Full';
												} else {
													$percentage = $this->Html->cFloat($itemDetail['CancellationPolicy']['percentage'], false) . '%';
												}
											?>
											<dt><?php echo __l('Cancellation'); ?></dt>
											<dd><?php echo $this->Html->cText($itemDetail['CancellationPolicy']['name']) . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($itemDetail['CancellationPolicy']['days'], false)); ?></dd>
										<?php endif; ?>
										<dt><?php echo __l('Amount Paid'); ?></dt>
										<?php
											if(Configure::read('property.is_enable_security_deposit')):
												$security_deposit_label = ' ' . __l('+ Security Deposit');
											endif;
										?>
										<dd><?php echo $this->Html->siteCurrencyFormat($total);?><?php echo ' ' . sprintf(__l('(Price + Service Fee %s)'), $security_deposit_label); ?></dd>
										<dt><?php echo __l('Service Fee'); ?></dt>
										<dd><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['traveler_service_amount']);?></dd>
										<?php if ($itemDetail['PropertyUser'][0]['property_user_status_id'] == ConstPropertyUserStatus::Confirmed): ?>
											<dt><?php echo __l('Cancellation Fee'); ?></dt>
											<dd><?php echo $this->Html->siteCurrencyFormat($price-$refund_amount['traveler_balance']);?></dd>
										<?php endif; ?>
										<?php if(Configure::read('property.is_enable_security_deposit')): ?>
										<dt><?php echo __l('Security Deposit'); ?></dt>
											<dd><?php echo $this->Html->siteCurrencyFormat($security_deposit);?></dd>
										<?php endif; ?>
									</dl>
									<div class="trip-condition-block trip-condition-block-total">
										<dl class=" condition-list clearfix">
											<dt class="total"><?php echo __l('Refundable Amount'); ?></dt>
											<dd><?php echo $this->Html->siteCurrencyFormat($refund_amount['traveler_balance'] + $security_deposit);?></dd>
										</dl>
									</div>
								<?php endif; ?>
							</div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</fieldset>
					<?php else: ?>
						<fieldset class="message-field">
						<div class="page-information"><?php echo __l('Your order confirmation request will be expired automatically in ').(Configure::read('property.auto_expire')*24).__l(' hrs when host not yet respond.'); ?></div>

							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center">
								<?php echo $this->Form->input('PropertyUser.message',array('label' => __l('Message to Host'),'div' =>'input textarea host-textarea')); ?>		
								<?php echo $this->Form->input('PropertyUser.from_id',array('type'=>'hidden', 'value'=>$user_info['User']['id'])); ?>		
							</div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</fieldset>
					<?php endif; ?>
					<!-- @todo "Coupons" -->
					<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='cancel'):?>
                        <div class="clearfix">
                             <div class="cancel-block"><?php 	echo $this->Html->link(__l('Submit'), array('controller' => 'property_users', 'action' => 'update_order', $itemDetail['PropertyUser'][0]['id'], __l('cancel'), 'admin' => false), array('title' => __l('Cancel'),'class' => 'js-cancel cancel'));   ?></div>
                        </div>
                	<?php endif; ?>
					<?php if((isset($this->request->params['named']['type']) && $this->request->params['named']['type']!='cancel' ) || !isset($this->request->params['named']['type'])):?>
						
						
						<fieldset>
							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center">
								<dl class="list clearfix">
									<?php
										if ($itemDetail['CancellationPolicy']['percentage'] == '0.00') {
											$percentage = 'No';
										} elseif ($itemDetail['CancellationPolicy']['percentage'] == '100.00') {
											$percentage = 'Full';
										} else {
											$percentage = $this->Html->cFloat($itemDetail['CancellationPolicy']['percentage'], false) . '%';
										}
									?>
									<!-- <dt><?php echo __l('Cancellation'); ?></dt>
									<dd><?php echo $this->Html->cText($itemDetail['CancellationPolicy']['name']) . ': ' . sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($itemDetail['CancellationPolicy']['days'], false)); ?></dd>
									--> <dt><?php echo __l('House Rules'); ?></dt>
									<dd><?php echo !empty($itemDetail['Property']['house_rules']) ? $this->Html->cText($itemDetail['Property']['house_rules']) : 'n/a' ; ?></dd>
								</dl>
								<?php
									//echo $this->Form->input('is_agree_terms_conditions', array('type'=>'checkbox','label' => __l('I agree to the cancellation policy and house rules'), 'checked')); 
									echo $this->Form->input('is_agree_terms_conditions', array('type'=>'hidden', 'value'=>1));
									echo $this->Form->input('item_id', array('type' => 'hidden'));
									if(!empty($this->request->params['named']['order_id'])):
										echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
									endif;
								?>
							</div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</fieldset>
						
						
					<?php endif; ?>
					<?php 	$currency_code = Configure::read('site.currency_id');?>
					<div class="page-information"><?php echo __l('This payment transacts in '). $GLOBALS['currencies'][$currency_code]['Currency']['symbol'].$GLOBALS['currencies'][$currency_code]['Currency']['code'].__l('. Your total charge is ').$this->Html->siteDefaultCurrencyFormat($total);?></div>
					<?php  if(!isset($this->request->params['named']['type'])):?>
					
<?php if($this->Auth->sessionValid()): ?>	
						<fieldset>
							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center">
								<p class="round-5"><?php echo __l('Select Payment Type');?></p>
								<?php
									if (!$this->Auth->sessionValid()):
										unset($gateway_options['paymentGateways'][ConstPaymentGateways::Wallet]);
									endif;
								?>
								<?php echo $this->Form->input('payment_gateway_id', array('legend' => false, 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type')); ?>
								<div class="clearfix">
									<?php echo $this->Form->input('type', array('type' => 'hidden')); ?>
									<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::PayPal])): ?>
										<div class="js-paypal-main <?php echo (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::PayPal) ? "" : 'hide'?> ">
											<?php if ($this->Auth->sessionValid() && Configure::read('property.is_paypal_connection_enabled')): ?>
												<div class="js-connected-paypal  buying-bg">
													<div class="pay-paypa-side1 main-side1">
														<h3><?php echo __l('Pay With Connected PayPal'); ?></h3>
														<?php if (Configure::read('property.is_paypal_connection_enabled') && !empty($userPaypalConnections)){ ?>
															<div class="option-block clearfix">
																<?php echo $this->Form->input('user_paypal_connection_id', array('type' => 'radio', 'options' =>$userPaypalConnections, 'legend' => false)); ?>
															</div>
															<div class="clearfix connected-paypal-block">
																<?php echo $this->Form->submit(__l('Pay with connected PayPal'), array('name' => 'data[Payment][connect]','div'=>false, 'class' => 'js-update-order-field paypal-block'));?>
															</div>
														<?php } else { ?>
															<p class="notice"><?php echo __l('No PayPal Connection Available.'); ?><?php echo $this->Html->link(__l('Connect Now'), array('controller' => 'user_paypal_connections', 'action' => 'index'), array('title' => __l('Connect Now'),'target' =>'_blank')); ?></p>
															<div class="page-information clearfix">
																<?php  echo sprintf(__l('You can connect your PayPal account with %s. To connect your account, you\'ll be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again. Note: We don\'t save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.'), Configure::read('site.name')); ?>
															</div>
														<?php } ?>
													</div>
												</div>
											<?php endif; ?>	
											<div class="js-normal-paypal pay-paypal buying-bg">
												<div class="pay-paypa-side1 main-side1">
													<h3><?php echo __l('Pay With PayPal'); ?></h3>
													<p class="order-paypal-info"><?php echo __l('This will take you to the paypal.com'); ?></p>
													<div class="submit-block clearfix">
														<?php echo $this->Form->submit(__l('Pay with PayPal'), array('name' => 'data[Payment][normal]', 'id'=>'pay_button','class' => 'paypal-block js-update-order-field' ,'div' => false));?>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::Wallet])): ?>
										<div class="js-wallet-connection pay-paypa-side1 wallet-side1 <?php echo (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet) ? "" : 'hide'?>">
											<?php if(!empty($user_info['User']['available_wallet_amount'])):?>
												<p class="available-balance js-user-available-balance {'balance':'<?php echo $user_info['User']['available_wallet_amount']; ?>'}"><?php echo __l('Your available balance:').' '. $this->Html->siteCurrencyFormat($user_info['User']['available_wallet_amount']);?></p>
											<?php endif;?>
											<h3><?php echo __l('Pay by Wallet'); ?></h3>
											<div class="clearfix connected-paypal-block">
												<?php echo $this->Form->submit(__l('Pay by Wallet'), array('name' => 'data[Payment][wallet]', 'class' => 'wallet-block js-update-order-field'));?>
											</div>
										</div>
									<?php endif; ?>

									<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
										<div class="clearfix js-credit-payment login-left-block credit-payment-block <?php echo ((!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet)) ? '' : 'hide' ?>">
											<div class="user-payment-profile js-show-payment-profile <?php echo (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])) ? '' : 'hide'; ?>">
												<?php 
													if (!empty($gateway_options['Paymentprofiles'])):
														echo $this->Form->input('payment_profile_id', array('legend' => __l('Pay with this card(s)'), 'type' => 'radio', 'options' => $gateway_options['Paymentprofiles'], 'class' => 'js-payment-profile'));
														echo $this->Html->link(__l('Add new card'), '#', array('class' => 'js-add-new-card add add-new-card'));
												?>
												<div class="js-new-credit-card hide">
												<?php
														echo $this->Html->link(__l('Hide'), '#', array('class' => 'js-hide-new-card hide-home-page'));
												?>
												</div>
												<?php
													endif;
												?>
											</div>
											
											<div class="js-new-credit-card <?php if (!empty($gateway_options['Paymentprofiles'])): ?>hide<?php endif; ?>">
												<div class="billing-left required">
													<h3><?php echo __l('Billing Information'); ?></h3>
													<?php
														echo $this->Form->input('firstName', array('label' => __l('First Name')));
														echo $this->Form->input('lastName', array('label' => __l('Last Name')));
														echo $this->Form->input('creditCardType', array('label' => __l('Card Type'), 'type' => 'select', 'options' => $gateway_options['creditCardTypes']));
														echo $this->Form->input('creditCardNumber', array('AUTOCOMPLETE' => 'OFF', 'label' => __l('Card Number'))); 
													?>
													<div class="input date">
														<label><?php echo __l('Expiration Date'); ?> </label>
														<?php 
															echo $this->Form->month('expDateMonth', array('value' => date('m')));
															echo $this->Form->year('expDateYear', date('Y'), date('Y')+25, array('value' => date('Y')+2, 'orderYear' => 'asc'));
														?>
													</div>
													<?php echo $this->Form->input('cvv2Number', array('AUTOCOMPLETE' => 'OFF', 'maxlength' =>'4', 'label' => __l('Card Verification Number:'))); ?>
												</div>
												<div class="billing-right required">
													<h3><?php echo __l('Billing Address'); ?></h3>
													<?php
														echo $this->Form->input('address', array('label' => __l('Address')));
														echo $this->Form->input('city', array('label' => __l('City')));
														echo $this->Form->input('state', array('label' => __l('State')));
														echo $this->Form->input('zip', array('label' => __l('Zip code')));
														echo $this->Form->input('country', array('label' => __l('Country'), 'type' => 'select', 'options' => $gateway_options['countries'], 'empty' => __l('Please Select')));
														echo $this->Form->input('is_show_new_card', array('type' => 'hidden'));
													?>   
												</div>
											</div>
										</div>
									<?php endif; ?>

									<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::PagSeguro])): ?>
										<div class="js-pagseguro-payment submit-block clearfix <?php if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::PayPal || $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet):?> hide<?php endif;?>">
											<?php echo $this->Form->submit(__l('Submit'));?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</fieldset>
						
<?php endif; ?>						
						
					<?php else: ?>
								<?php  if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?>
									<div class="clearfix connected-paypal-block"><?php echo $this->Form->submit(__l('Contact'), array('name' => 'data[Payment][contact]'));?></div>
								<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='accept'):?>
									<div class="clearfix connected-paypal-block"><?php echo $this->Form->submit(__l('Confirm'), array('name' => 'data[Payment][accept]'));?></div>
								<?php endif; ?>
							<?php endif; ?>
						<?php echo $this->Form->end();?>
					</div>
					<?php else: 
						//storing the order id in session
						$_SESSION['order_id']=$this->request->params['named']['order_id'];

					  ?>
					<div class="page-information"><?php echo __l('Membership fee needs to pay for registration. Please click the link for  ').$this->Html->link(__l('register'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('register'))).__l(' , your order will be placed automatically and you can continue the booking from trips manager after login.'); ?></div>
						<?php endif; ?>
				</div>
			
			
			
			
				<?php if(!$this->Auth->sessionValid() && Configure::read('user.is_enable_normal_registration') && Configure::read('user.signup_fee')==0): ?>
					
					<div id="fondoNegro" class="fondoNegro"></div>
					
					<div class="clearfix login-right-block <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='contact'):?> login-right-contact-block<?php endif; ?>">
						<p class="js-login-form login-account"><?php echo __l('Already Have An Account?'); ?></p>
						<div class="js-login-form-container ">
							<h3><?php echo __l('Already Have An Account?');?></h3>
							<div>
								<p class="login-info-block"><?php echo sprintf(__l('If you have created account in %s before, you can sign in using your %s.'), Configure::read('site.name'),Configure::read('user.using_to_login')); ?></p>
								<?php
									unset($this->validationErrors['User']['username']);
									unset($this->validationErrors['User']['passwd']);
									echo $this->element('users-login', array('payment_id' => $this->request->params['pass'][0], 'order_id' => $this->request->params['named']['order_id'], 'type' => !empty($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '', 'config' => 'sec'));
								?>
							</div>
						</div>
					</div>	

				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="pptview-mblock-bl">
		<div class="pptview-mblock-br">
			<div class="pptview-mblock-bb"></div>
		</div>
	</div>
</div>
<div class="side2 payment-side2">
	<div class="rightbox" style="margin-top: 162px;">
		<div class="block2-tl">
			<div class="block2-tr">
				<div class="block2-tm">
					<h4><?php echo __l('Trip Details');?></h4>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-ll">
			<div class="pptview-mblock-rr">
				<div class="pptview-mblock-mm ">
					<div class="trip-condition-block">
						<dl class=" condition-list clearfix">
							<dt><?php echo __l('Check in'); ?></dt>
							<dd><?php echo !empty($itemDetail['PropertyUser'][0]['checkin']) ? $this->Html->cDate($itemDetail['PropertyUser'][0]['checkin']) : ''; ?></dd>
							<?php if($itemDetail['Property']['join_or_item_value'] == 'prop'){ ?>
							<dt><?php echo __l('Check out'); ?></dt>
							<dd><?php echo !empty($itemDetail['PropertyUser'][0]['checkout']) ? $this->Html->cDate($itemDetail['PropertyUser'][0]['checkout']) : ''; ?></dd>
							<dt><?php echo __l('Nights'); ?></dt>
							<dd><?php echo round($days); ?></dd>
							<?php } ?>


							<dt><?php echo (empty($itemDetail['Property']['price_per_week']))?(($itemDetail['Property']['join_or_item_value']=='prop')? __l('Quantity') : __l('Nights')):__l('Join'); ?></dt>
							<dd><?php echo !empty($itemDetail['PropertyUser'][0]['guests']) ? $this->Html->cInt($itemDetail['PropertyUser'][0]['guests']) : 1; ?></dd>
							
							<?php if ($additional_guest > 0) { ?>
								<dt><?php echo __l('Additional Guests'); ?></dt>
								<dd><?php echo $additional_guest;?></dd>
							<?php } ?>
							
							<?php 
							$default_currency_id = Configure::read('site.currency_id');
							if (!empty($_COOKIE['CakeCookie']['user_currency'])) {
							$currency_id = $_COOKIE['CakeCookie']['user_currency'];
							}
							$display_default_currency=false;
							if (!empty($_COOKIE['CakeCookie']['user_currency']) && $default_currency_id!=$currency_id)
							{
								$display_default_currency=true;
							}

							?>
							</dl>
							<dl class=" condition-list condition-list1 clearfix">
							<dt><?php echo __l('Price'); ?></dt>
							
							<?php $precio = ($itemDetail['Property']['join_or_item_value'] == 'item')? $itemDetail['PropertyUser'][0]['price'] : $itemDetail['Property']['price_per_night']; ?>
							
							<dd><?php echo $this->Html->siteCurrencyFormat($precio);?> <span class="trips-price"> <?php if($display_default_currency): ?> / 
							<?php echo $this->Html->siteDefaultCurrencyFormat($precio);?><?php endif; ?></span></dd>
							</dl>
							<dl class=" condition-list condition-list1 clearfix">
							<!--
							<dt><?php echo __l('Sub Total'); ?></dt>
							<?php if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])): ?>
							<dd><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['original_price']);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($itemDetail['PropertyUser'][0]['original_price']);?><?php endif; ?></span></dd>
							<?php else: ?>
							<dd><?php echo $this->Html->siteCurrencyFormat($itemDetail['PropertyUser'][0]['price']);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($itemDetail['PropertyUser'][0]['price']);?><?php endif; ?></span></dd>
							<?php endif; ?>
							-->
							<?php if($additional_guest > 0) { ?>
								<dt><?php echo 'Additional Guests Price (per night)'; ?></dt>
								<dd><?php echo  $this->Html->siteCurrencyFormat($additional_guest_price);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo  $this->Html->siteDefaultCurrencyFormat($additional_guest_price);?><?php endif; ?></span></dd>
							<?php } ?>
							
							<?php if(!empty($itemDetail['PropertyUser'][0]['negotiation_discount'])): ?>
								<dt><?php echo __l('Discount') . ' (' . $itemDetail['PropertyUser'][0]['negotiation_discount'] . '%)'; ?></dt>
								<dd class="highlight-cleared"><?php echo $this->Html->siteCurrencyFormat($discount);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($discount);?><?php endif; ?></span></dd>
							<?php endif; ?>
							</dl>
							<dl class=" condition-list condition-list1 clearfix">
							<dt><?php echo __l('Subtotal'); ?></dt>
							<dd><?php echo $this->Html->siteCurrencyFormat($price);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($price);?><?php endif; ?></span></dd>
							</dl>
							<dl class=" condition-list condition-list1 clearfix">
							<dt><?php echo __l('Service Fee') . ' ' . '('. Configure::read('property.booking_service_fee') .'%)'; ?></dt>
							<dd><?php echo $this->Html->siteCurrencyFormat($service_fee);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($service_fee);?><?php endif; ?></span></dd>
						</dl>
						<dl class=" condition-list condition-list1 clearfix">
						<?php if (Configure::read('property.is_enable_security_deposit')): ?>
							<dt><?php echo __l('Security Deposit'); ?><span class="refundable round-3"><?php echo __l('Refundable'); ?></span></dt>
							<dd><?php echo $this->Html->siteCurrencyFormat($security_deposit);?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($security_deposit);?><?php endif; ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></dd>
							<?php endif; ?>

						</dl>
					</div>
					<div class="trip-condition-block trip-condition-block-total">
						<dl class=" condition-list clearfix">
							<dt class="total"><?php echo __l('Total'); ?></dt>
							<dd><?php echo $this->Html->siteCurrencyFormat($total);?> <?php if($display_default_currency): ?> <span class="trips-price"><?php if($display_default_currency): ?>/ <?php echo $this->Html->siteDefaultCurrencyFormat($total);?><?php endif; ?><?php endif; ?></span></dd>
						</dl>
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
</div>
<?php 
	if (Configure::read('paypal.is_embedded_payment_enabled')):
		echo $this->element('js-embedded-paypal', array('config' => 'sec'));
	endif;
?>