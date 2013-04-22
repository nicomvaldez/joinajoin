<p  class="paypal-amount grid_right">
<span><?php echo __l('Your');?></span>
<span class="paypal"><?php echo __l('PayPal');?></span>
<span><?php echo __l('balance is:').' ';?></span>
<?php echo $this->Html->siteCurrencyFormat($paypal_balance); ?>
</p>