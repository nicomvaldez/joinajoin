<?php /* SVN: $Id: $ */ ?>
<h2><?php echo __l("Add Amount to Wallet");?></h2>
<div class="payments order add-wallet  js-responses js-main-order-block js-submit-target-block">
	<div class="current-balance">
		<span><?php echo __l('Your current available balance:').' '. $this->Html->siteCurrencyFormat($user_info['User']['available_wallet_amount']);?></span>
	</div>
	<?php echo $this->Form->create('User', array('action' => 'add_to_wallet', 'id' => 'PaymentOrderForm', 'class' => 'js-submit-target normal')); ?>
		<div class="padd-bg-tl">
			<div class="padd-bg-tr">
				<div class="padd-bg-tmid"></div>
			</div>
		</div>
		<div class="padd-center">
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Auth->user('id')));
				if (!Configure::read('wallet.max_wallet_amount')):
					$max_amount = 'No limit';
				else:
					$max_amount = $this->Html->siteCurrencyFormat(Configure::read('wallet.max_wallet_amount'));
				endif;
				$currency_code = Configure::read('site.currency_id');
				Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
				echo $this->Form->input('amount', array('label' => __l('Amount (').configure::read('site.currency').__l(')')));
				echo $this->Form->input('type', array('type' => 'hidden'));
			?>
			<?php echo $this->Form->input('payment_gateway_id', array('legend' => false, 'type' => 'radio', 'options' => $gateway_options['paymentGateways'], 'class' => 'js-payment-type')); ?>
				<?php 	$currency_code = Configure::read('site.currency_id');?>
	<div class="page-information"><?php echo __l('This payment transacts in '). $GLOBALS['currencies'][$currency_code]['Currency']['symbol'].$GLOBALS['currencies'][$currency_code]['Currency']['code'];?></div>
			<div class="clearfix states-block payment-states-block">
				<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet])): ?>
					<div class="clearfix js-credit-payment login-left-block credit-payment-block <?php echo ((!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet)) ? '' : 'hide' ?>">
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
				<div class="js-paypal-main <?php echo (!empty($this->request->data['User']['payment_gateway_id']) && $this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::PayPal) ? "" : 'hide'?> ">
					<!-- USING CONNECT -->
					<?php if (Configure::read('property.is_paypal_connection_enabled')): ?>
						<div class="js-connected-paypal property-stats grid_left buying-bg">
							<h3><?php echo __l('Pay With Connected PayPal'); ?></h3>
							<?php if (Configure::read('property.is_paypal_connection_enabled') && !empty($userPaypalConnections)){ ?>
								<div class="option-block clearfix">
									<?php echo $this->Form->input('user_paypal_connection_id', array('type' => 'radio', 'options' =>$userPaypalConnections, 'legend' => false)); ?>
								</div>
								<div class="clearfix"><?php echo $this->Form->submit(__l('Pay with connected PayPal'), array('name' => 'data[User][adaptive_connect]','div'=>false, 'class' => 'js-update-paymentgateway-field paypal-block'));?></div>
							<?php } else { ?>
								<p class="notice">
									<?php echo __l('No PayPal Connection Available.'); ?>
									<?php echo $this->Html->link(__l('Connect Now'), array('controller' => 'user_paypal_connections', 'action' => 'index'), array('title' => __l('Connect Now'))); ?>
								</p>
								<div class="page-information clearfix">
									<?php  echo sprintf(__l('You can connect your PayPal account with %s. To connect your account, you\'ll be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again. Note: We don\'t save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.'), Configure::read('site.name')); ?>
								</div>
							<?php } ?>
						</div>
					<?php endif; ?>
					<!-- USING NORMAL -->
					<div class="js-normal-paypal user-stats grid_left pay-paypal buying-bg">
						<h3><?php echo __l('Pay With PayPal'); ?></h3>
						<div class="page-information clearfix"><?php echo __l('This will take you to the paypal.com'); ?></div>
						<div class="submit-block clearfix">
							<?php echo $this->Form->submit(__l('Pay with PayPal'), array('name' => 'data[User][adaptive_normal]','div'=>false, 'id'=>'pay_button','class' => 'paypal-block'));?>
						</div>
					</div>
				</div>
			
			</div>
		</div>
		<div class="padd-bg-bl">
			<div class="padd-bg-br">
				<div class="padd-bg-bmid"></div>
			</div>
		</div>
			<?php if (!empty($gateway_options['paymentGateways'][ConstPaymentGateways::AuthorizeNet]) || !empty($gateway_options['paymentGateways'][ConstPaymentGateways::PagSeguro])): ?>
					<div class="js-pagseguro-payment submit-block clearfix <?php if ($this->request->data['User']['payment_gateway_id'] == ConstPaymentGateways::PayPal):?> hide<?php endif;?>">
						<?php echo $this->Form->submit(__l('Add to Wallet'));?>
					</div>
				<?php endif; ?>
	<?php echo $this->Form->end();?>
</div>
<?php 
	if (Configure::read('paypal.is_embedded_payment_enabled')):
		echo $this->element('js-embedded-paypal', array('config' => 'sec'));
	endif;
?>