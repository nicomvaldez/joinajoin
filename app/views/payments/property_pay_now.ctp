<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="payments order user-profile-form payment-block js-responses js-main-order-block">
<div class="l-curve-top">							
								<div class="top-bg"></div>
							<div class="r-curve-top"></div>
						</div>
						<div class="shad-bg-lft">
							<div class="shad-bg-rgt">
								<div class="shad-bg">
	<div class="main-section">
	 <h2><?php echo $this->Html->link($Property['Property']['title'],array('controller'=>'properties','action'=>'view',$Property['Property']['slug'])) ?> &raquo; <?php echo __l('Pay Listing Fee');?></h2>

  <div class="clearfix">
      <div class="grid_4 view-thumb-block omega alpha">
          <div class="thumb">
              <span>
            	  <?php 
                          echo $this->Html->link($this->Html->showImage('Property', $Property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($Property['Property']['title'], false)), 'title' => $this->Html->cText($Property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $Property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($Property['Property']['title'],false),'escape' => false));
            	 ?>
        	 </span>
    	 </div>
	 </div>
	<div class="grid_10 alpha omega">
	<div class="clearfix">
	<div class="grid_1 user-avatar alpha omega">
		<?php
			$current_user_details = array(
				'username' => $Property['User']['username'],
				'user_type_id' => $Property['User']['user_type_id'],
				'id' => $Property['User']['id'],
				'fb_user_id' => $Property['User']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $Property['User']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
		?>
    </div>
	<div class="grid_9 user-avatar ">
	<div class="clearfix">
		<h3 class="properties-title payment-properties-title">
		<?php

		$lat = $Property['Property']['latitude'];
		$lng = $Property['Property']['longitude'];
		$id = $Property['Property']['id'];

		echo $this->Html->link($this->Html->cText($Property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $Property['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($Property['Property']['title'], false),'escape' => false));
		?>

		<?php
			$flexible_class = '';
			 if(isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] ==1)
			 {
				if(!in_array($Property['Property']['id'], $booked_property_ids) && in_array($Property['Property']['id'], $exact_ids)) { ?>
					<span class="exact round-3"> <?php echo __l('exact'); ?></span>
		<?php		} }
			if(Configure::read('property.is_property_verification_enabled') && $Property['Property']['is_verified']):?>
			<span class="isverified"> <?php echo __l('verified'); ?></span>
		<?php
			endif;
		?>

		<?php
			if($Property['Property']['is_featured']):?>
			<span class="featured round-3 isfeatured"> <?php echo __l('featured'); ?></span>
		<?php
			endif;
		?>
			</h3>
		</div>
        <p class="address-info">
			<?php if(!empty($Property['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($Property['Country']['iso2']); ?>" title ="<?php echo $Property['Country']['name']; ?>"><?php echo $Property['Country']['name']; ?></span>
				<?php endif; ?>
			<?php echo $this->Html->cText($Property['Property']['address']);?>
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
    <?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($Property[0]['distance'])): ?>

        <dl class="clearfix guest request-list1">
			<dt><?php echo __l('Distance');?><span class="km"> <?php echo __l('(km)');?></span></dt>
			<dd><?php echo $this->Html->cInt($Property[0]['distance']*1.60934 ,false); ?></dd>
		</dl>

			<?php endif; ?>
					<dl class="request-list1 view-list1 guest clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('View');?>">
                      <?php echo __l('Views');?></dt>
                      <dd class="positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $Property['Property']['id']; ?> {'id':'<?php echo $Property['Property']['id']; ?>'}">
                        <?php  echo $this->Html->cInt($Property['Property']['property_view_count']); ?>
                      </dd>
                  </dl>
		           <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
                        <?php  echo $this->Html->cInt($Property['Property']['positive_feedback_count']); ?>
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
                            <?php  echo $this->Html->cInt($Property['Property']['property_feedback_count'] - $Property['Property']['positive_feedback_count']); ?>
                      </dd>
                    </dl>
				  <dl class="clearfix  request-list1 request-index-list success-rate-list">
    				        <dt  title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
                          <?php if(empty($Property['Property']['positive_feedback_count'])): ?>
                          	<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
								 <dd class="success-rate">
										<?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.round($this->Html->cInt($Property['Property']['positive_feedback_count'])).','.(100 - round($this->Html->cInt($Property['Property']['positive_feedback_count']))).'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => round($this->Html->cInt($Property['Property']['positive_feedback_count'])).'%')); ?>
								</dd>
							<?php endif; ?>
    		   </dl>
		</div>
		 </div>
		  <div class="city-price grid_4 grid_right omega alpha">
		  <div class="clearfix edit-info-block">
		  	<div class="rating-block grid_left">
              <div class="rating clearfix">
                <ul class="star-rating">				
                    </ul>
                  </div>
                </div>            
		   </div>
		   <div class="city-price grid_right grid_4 omega alpha">
		   <div class="clearfix city-price1">
				<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
                 <sub> <?php echo Configure::read('site.currency').' '?></sub>
				 <?php endif; ?>
                  <?php echo $this->Html->cCurrency($Property['Property']['price_per_night']);?>
				<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
                 <sub> <?php echo ' '.Configure::read('site.currency'); ?></sub>
				 <?php endif; ?>
                  <p class="">
                  <?php echo __l('Per night');?>
                  </p>
            </div>
            </div>
            <div class="clearfix price-info-right">
                 <dl class="clearfix request-list grid_2 omega alpha">
    				<dt><?php echo __l('Per Week');?></dt>
                      <dd><?php
					  if($Property['Property']['price_per_week']!=0):
					  echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_week']);
					  else:
						echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_night']*7);
					endif;
					  ?></dd>
				  </dl>
 				   <dl class="clearfix request-list grid_2 omega alpha">
    				 <dt><?php echo __l('Per Month');?></dt>
                      <dd><?php
					  if($Property['Property']['price_per_month']!=0):
					  echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_month']);
					  else:
						echo $this->Html->siteCurrencyFormat($Property['Property']['price_per_night']*30);
					endif;
					  ?></dd>
				  </dl>
				  </div>
				  <?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='related' ): ?>
					  <?php if($this->Auth->user('id')!=$Property['Property']['user_id']): ?>
						  <div class="clearfix">
						 <div class="cancel-block"><?php echo $this->Html->link(__l('Book it!'), array('controller' => 'properties', 'action' => 'view',$Property['Property']['slug'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false)); ?></div></div>
					 <?php endif; ?>
				 <?php endif; ?>
         </div>
         </div>
<div class="donations  user-profile-form round-5 pledge-form donations-block clearfix js-submit-target-block">
 <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'property_pay_now', $Property['Property']['id']), 'class' => 'js-submit-target normal clearfix'));
     echo $this->Form->input('Property.id',array('type'=>'hidden'));
 ?>
    <dl class="list payment-list round-5 clearfix"><?php $i = 0; $class = ' class="altrow"';?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Listing Fee');?></dt>
    		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->siteCurrencyFormat($total_amount);?></dd>
    </dl>
	<?php 	$currency_code = Configure::read('site.currency_id');?>
	<div class="page-information"><?php echo __l('This payment transacts in '). $GLOBALS['currencies'][$currency_code]['Currency']['symbol'].$GLOBALS['currencies'][$currency_code]['Currency']['code'].__l('. Your total charge is ').$this->Html->siteDefaultCurrencyFormat($total_amount);?></div>
	<fieldset>
		<div class="padd-bg-tl">
			<div class="padd-bg-tr">
				<div class="padd-bg-tmid"></div>
			</div>
		</div>
		<div class="padd-center">
			<p class="round-5"><?php echo __l('Select Payment Type');?></p>
			<?php echo $this->Form->input('payment_gateway_id', array('legend' => false, 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type')); ?>
			<div class="clearfix">
				<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::PayPal])): ?>
					<div class="js-paypal-main <?php echo (!empty($this->request->data['Payment']['payment_gateway_id']) && $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::PayPal) ? "" : 'hide'?> ">
						<div class="js-normal-paypal pay-paypal buying-bg">
							<div class="pay-paypa-side1 main-side1">
								<h3><?php echo __l('Pay With PayPal'); ?></h3>
								<p class="order-paypal-info"><?php echo __l('This will take you to the paypal.com'); ?></p>
								<div class="submit-block clearfix">
									<?php echo $this->Form->submit(__l('Pay with PayPal'), array('name' => 'data[Payment][normal]', 'id'=>'pay_button','div'=>false ,'class' => 'paypal-block js-update-order-field'));?>
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
		
			</div>
		</div>
		<div class="padd-bg-bl">
			<div class="padd-bg-br">
				<div class="padd-bg-bmid"></div>
			</div>
		</div>
				<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::PagSeguro])): ?>
					<div class="js-pagseguro-payment submit-block clearfix <?php if ($this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::PayPal || $this->request->data['Payment']['payment_gateway_id'] == ConstPaymentGateways::Wallet):?> hide<?php endif;?>">
						<?php echo $this->Form->submit(__l('Submit'));?>
					</div>
				<?php endif; ?>
	</fieldset>
	<?php echo $this->Form->end();?>
</div>
</div>
	</div>
							</div>
						</div>
						<div class="l-curve-bot">							
							<div class="bot-bg"></div>
							<div class="r-curve-bot"></div>
						</div>
</div>
<?php 
	if (Configure::read('paypal.is_embedded_payment_enabled')):
		echo $this->element('js-embedded-paypal', array('config' => 'sec'));
	endif;
?>