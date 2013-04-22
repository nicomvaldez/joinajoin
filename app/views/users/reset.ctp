<h2><?php echo __l('Reset your password'); ?></h2>
<?php
	echo $this->Form->create('User', array('action' => 'reset' ,'class' => 'normal')); ?>
		<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
	<?php
	echo $this->Form->input('user_id', array('type' => 'hidden'));
	echo $this->Form->input('hash', array('type' => 'hidden'));
	echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') ,'id' => 'password'));
	echo $this->Form->input('confirm_password', array('type' => 'password','label' => __l('Confirm Password')));
    ?>
    </div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
    <div class="submit-block clearfix">
<?php

	echo $this->Form->submit(__l('Change password'));
?>
</div>
<?php echo $this->Form->end(); ?>