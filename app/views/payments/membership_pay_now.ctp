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
	 <h2><?php echo __l('Pay Membership Fee');?></h2>


<div class="donations  user-profile-form round-5 pledge-form donations-block clearfix js-submit-target-block">
 <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'membership_pay_now', $User['User']['id'],$this->request->params['pass'][1]), 'class' => 'js-submit-target normal clearfix'));
     echo $this->Form->input('User.id',array('type'=>'hidden'));
 ?>
    <dl class="list payment-list round-5 clearfix"><?php $i = 0; $class = ' class="altrow"';?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Membership Fee');?></dt>
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
									<?php echo $this->Form->submit(__l('Pay with PayPal'), array('name' => 'data[Payment][normal]', 'id'=>'pay_button','div'=>false ,'class' => 'paypal-block'));?>
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