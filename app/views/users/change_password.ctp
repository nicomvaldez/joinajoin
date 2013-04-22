<?php if (empty($this->request->params['prefix'])): ?>
	<h2 class="change-pass"><?php echo __l('Change Password'); ?></h2>
	<div class="side1 grid_18">
<?php endif; ?>
<div class="community-block clearfix">
	<div class="store-left">
		<div class="store-right">
			<div class="store-center coupon-center">
				<?php
					echo $this->Form->create('User', array('action' => 'change_password' ,'class' => 'normal')); ?>
								<div class="padd-bg-tl">
					<div class="padd-bg-tr">
					<div class="padd-bg-tmid"></div>
					</div>
				</div>
				<div class="padd-center">
					<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin) :
						echo $this->Form->input('user_id', array('empty' => 'Select'));
					endif;
					if($this->Auth->user('user_type_id') != ConstUserTypes::Admin) :
						echo $this->Form->input('user_id', array('type' => 'hidden'));
						echo $this->Form->input('old_password', array('type' => 'password','label' => __l('Old password') ,'id' => 'old-password'));
					endif;
					echo $this->Form->input('passwd', array('type' => 'password','label' => __l('Enter a new password') , 'id' => 'new-password'));
					echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password'))); ?>
					</div>
					<div class="padd-bg-bl">
						<div class="padd-bg-br">
						<div class="padd-bg-bmid"></div>
						</div>
						</div>
					<div class="submit-block clearfix">
						<?php echo $this->Form->submit(__l('Submit'));?>
					</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<div class="coupon-bottom"></div>
</div>
<?php if (empty($this->request->params['prefix'])): ?>
	</div>
	<div class="side2">
		<?php echo $this->element('sidebar', array('config' => 'sec')); ?>
	</div>
<?php endif; ?>