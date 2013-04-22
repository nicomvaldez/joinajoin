<div>
<h2 class="login-title"><?php echo __l('Forgot your password?');?></h2>
<div class="page-information">
	<?php echo __l('Enter your Email, and we will send you instructions for resetting your password.'); ?>
</div>
<?php
	echo $this->Form->create('User', array('action' => 'forgot_password', 'class' => 'normal')); ?>
	       <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
	<?php
	echo $this->Form->input('email', array('type' => 'text'));
?>
			</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
<div class="clearfix submit-block">
<?php echo $this->Form->submit(__l('Send'));?>	
</div> 
<?php echo $this->Form->end();?>
</div>