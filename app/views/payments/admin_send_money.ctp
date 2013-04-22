<?php /* SVN: $Id: admin_add.ctp 6515 2010-06-02 10:45:44Z sreedevi_140ac10 $ */ ?>
<div class="users form">
	<h3> <?php echo sprintf(__l('Send money to').' %s', $user['User']['username']); ?></h3>
<?php echo $this->Form->create('Payment', array('action' => 'send_money', 'class' => 'normal'));
	echo $this->Form->input('User.id');
?>
<div class="clearfix">
		<?php echo $this->element('payment-site_payment_balance', array('config' => 'sec'));?>
	</div>
<div class="clearfix user-view-block send-money-view-block">
	<div class="view-img-left-block grid_2">
		<?php
			$current_user_details = array(
				'username' => $user['User']['username'],
				'user_type_id' => $user['User']['user_type_id'],
				'id' => $user['User']['id'],
				'fb_user_id' => $user['User']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $user['User']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb');
		?>
	</div>
	<div class="view-info-right-block grid_8">
     <h3 class="view-title"><?php echo ucfirst($this->Html->cText($user['User']['username'], false)); ?></h3>
	 <div class="clearfix">
        <?php if(Configure::read('property.rating_type') == 'percentage'):?>
    			<dl class="ratings-feedback1 clearfix">
                <dt class="positive-feedback1" title = "<?php echo __l('Positive Rating'); ?>"><?php echo __l('Positive Rating:');?></dt>
    				<dd class="positive-feedback1" title = "<?php echo $this->Html->displayPercentageRating($property['Property']['property_feedback_count'], $property['Property']['positive_feedback_count']);?>" class="positive-feedback">
    					<?php echo $this->Html->displayPercentageRating($user['User']['property_feedback_count'], $user['User']['positive_feedback_count']); ?>
    				</dd>
    			</dl>
    	<?php else:?>
    			<dl class="ratings-feedback1 clearfix clearfix">
    				<dt  class="positive-feedback1" title ="<?php echo __l('Positive Rating');?>"><?php echo __l('Positive');?></dt>
                    <dd class="positive-feedback1"> <?php  echo $this->Html->cInt($user['User']['positive_feedback_count']); ?> </dd></dl>
					<dl class="ratings-feedback1 clearfix clearfix">
					<dt class="negative-feedback1" title ="<?php echo __l('Negative Rating');?>"><?php echo __l('Negative');?></dt>
					<dd class="negative-feedback1"><?php  echo $this->Html->cInt($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?></dd>
                </dl>
    	<?php endif;?>
		</div>
			<dl class="list clearfix">
				<dt><?php echo !empty($user['UserProfile']['full_name']) ? $this->Html->cText($user['UserProfile']['full_name']) : $user['User']['username'];?></dt>
				<dd><?php echo __l('joined').' '. Configure::read('site.name').' '. __l('on').' '.$this->Html->cDateTimeHighlight($user['User']['created']);?></dd>
			</dl>
			<p class="paypal-user">				
				<?php echo __l('Users PayPal account:').' '.$this->Html->cText($user['UserProfile']['paypal_account']);?>
			</p>
	</div>
</div>
	<fieldset> 	
	<?php        
		echo $this->Form->input('SendMoney.amount', array('after' => Configure::read('site.currency'))); ?>
	<div class="send-money-paypal"> 
	<?php echo $this->Form->input('SendMoney.fee_payer', array('type' =>'radio', 'options' => $feesPayers, 'legend' => __l('Who will pay the fee?'))); ?>
		<?php echo $this->Html->image('paypal.gif', array('title' => __l('PayPal'), 'alt' => __l('PayPal')));?></div>
	</fieldset>
	<div class="submit-block clearfix">
	<?php echo $this->Form->end(__l('Send Money'));?>
	</div>
</div>
<?php echo $this->element('js-embedded-paypal', array('config' => 'sec')); ?>