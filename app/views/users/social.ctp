<div class="users form clearfix">
    <h2><?php echo __l('Social Networks'); ?></h2>
	<div class="form">
    <div class="grid_17 side1">
	<div class="users-social-networks round-3">
		<?php if (!empty($this->request->data['User']['is_facebook_friends_fetched'])): ?>
			<?php echo $this->Form->create('User', array('action' => 'social', 'class' => 'normal clearfix')); ?>
				<div class="padd-bg-tl">
					<div class="padd-bg-tr">
						<div class="padd-bg-tmid"></div>
					</div>
				</div>
				<div class="padd-center">
					<?php echo $this->Form->input('User.is_show_facebook_friends', array('type' => 'checkbox', 'label' => __l('Show Facebook friends level in properties list page.'))); ?>
				</div>
				<div class="padd-bg-bl">
					<div class="padd-bg-br">
						<div class="padd-bg-bmid"></div>
					</div>
				</div>
				<div class="clearfix submit-block">
					<?php echo $this->Form->submit(__l('Update')); ?>
				</div>
			<?php echo $this->Form->end();?>
		<?php else: ?>
			<?php echo $this->Html->link(__l('Connect with Facebook'), $fb_login_url, array('class' => 'facebook-connect-link', 'title' => __l('Connect with Facebook'))) . ' ' . __l('to filter by Social Network level'); ?>
		<?php endif; ?>
	</div>
	</div>
	    <div class="grid_6 omega side2 user-sidebar">
        <?php
    		echo $this->element('sidebar', array('config' => 'sec'));
    	?>
    </div>
	</div>
</div>