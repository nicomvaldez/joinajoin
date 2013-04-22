<?php /* SVN: $Id: $ */ ?>
<div class="paypalAccounts form">
<?php echo $this->Form->create('Payment', array('action' => 'create_paypal_account', 'class' => 'normal'));?>
	<fieldset>
 		<h2 class="paypal-heading clearfix"><span class="grid_left"><?php echo __l('Create'); ?></span><span class="paypal-icon grid_left">PayPal</span><span class="grid_left"><?php echo __l('Account');?></span></h2>
		<div class="page-information clearfix">
		<p><?php echo __l('Here you can create PayPal account quickly (through PayPal API).');?></p>
		<p><?php echo __l('You may also create a PayPal account from ').$this->Html->link(__l('PayPal'), $referralURL, array('target' => '_blank')).__l(' site.'); ?></p>
		</div>
	<?php		
		echo $this->Form->input('PaypalAccount.first_name', array('label' => __l('First Name')));
		echo $this->Form->input('PaypalAccount.last_name', array('label' => __l('Last Name')));
		echo $this->Form->input('PaypalAccount.email', array('label' => __l('Email')));
		echo $this->Form->input('PaypalAccount.dob', array('label' => __l('DOB'), 'empty' => __l('Please Select'), 'maxYear' => date('Y'), 'minYear' => date('Y') - 100));     
		echo $this->Form->input('PaypalAccount.address1', array('label' => __l('Address1')));
		echo $this->Form->input('PaypalAccount.address2', array('label' => __l('Address2')));
		echo $this->Form->input('PaypalAccount.city', array('label' => __l('City')));
		echo $this->Form->input('PaypalAccount.state', array('label' => __l('State')));
		echo $this->Form->input('PaypalAccount.paypal_country_id', array('empty' => __l('Please Select'), 'label' =>__l('Country')));
		echo $this->Form->input('PaypalAccount.paypal_citizenship_country_id', array('empty' => __l('Please Select'), 'label' =>__l('Citizenship Country')));
		echo $this->Form->input('PaypalAccount.zip', array('label' => __l('Zip')));
		echo $this->Form->input('PaypalAccount.phone', array('label' => __l('Phone')));
		
	?>
	</fieldset>
	<div class="submit-block clearfix">
<?php echo $this->Form->end(__l('Create PayPal Account'));?>
</div>
</div>