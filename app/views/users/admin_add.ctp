<?php /* SVN: $Id: admin_add.ctp 4507 2010-05-03 13:34:54Z josephine_065at09 $ */ ?>
<div class="users form">
<?php echo $this->Form->create('User', array('class' => 'normal'));?>
<h2><?php echo __l('Add User');?></h2>
<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
	
	<?php
        echo $this->Form->input('user_type_id', array('label' => __l('User Type')));
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('passwd', array('label' => __l('Password')));
	?>
	
</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
    <div class="clearfix submit-block">
			<?php echo $this->Form->submit(__l('Add'));?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>