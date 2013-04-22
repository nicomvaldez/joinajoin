

	<div class="mail-menu">
		<ul class="admin-links">
		<!--li>
            <?php //$class = (((isset($compose)) and ($compose == 'compose')) ? 'compose-active' : 'compose-inactive'); ?>
            <?php //echo $this->Html->link(__l('Compose Message') , array('controller' => 'messages', 'action' => 'compose') , array('class' => $class)); ?>
	</li-->
<?php if ($inbox == 0): ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Inbox') , array('controller' => 'messages', 'action' => 'inbox')); ?>
			</li>
<?php else: ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'inbox')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Inbox') . ' (' . $inbox . ')', array('controller' => 'messages', 'action' => 'inbox')); ?>
			</li>
<?php endif; ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'sent')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Sent Mail') , array('controller' => 'messages', 'action' => 'sentmail')); ?>
			</li>
<?php if ($draft == 0) :  ?>
			<li class="starred <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 1) ? 'active' : 'inactive'; ?>">
				<?php echo $this->Html->link(__l('Starred') . ' (' . $stared . ')' , array('controller' => 'messages', 'action' => 'starred')); ?><em class="starred"></em>
			</li>
<?php else : ?>
			<li class="starred <?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 1) ? 'active' : 'inactive'; ?>">
				<?php echo $this->Html->link(__l('Starred') . ' (' . $stared . ')', array('controller' => 'messages', 'action' => 'starred')); ?><em class="starred"></em>
			</li>
<?php endif; ?>
			<li class="<?php echo (isset($folder_type) and $folder_type == 'all' and isset($is_starred) and $is_starred == 0) ? 'active' : 'inactive'; ?>">
				<?php echo $this->Html->link(__l('All Mail') , array('controller' => 'messages', 'action' => 'all')); ?>
			</li>
<?php if ($spam == 0) : ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'spam')) ? 'active' : 'inactive'); ?>">
				 <?php echo $this->Html->link(__l('Spam') , array('controller' => 'messages', 'action' => 'spam')); ?>
			</li>
<?php else : ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'spam')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Spam') . ' (' . $spam . ')' , array('controller' => 'messages', 'action' => 'spam')); ?>
			</li>
<?php endif; ?>
			<li class="<?php echo (((isset($folder_type)) and ($folder_type == 'trash')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Trash') , array('controller' => 'messages', 'action' => 'trash')); ?>
			</li>
			<li class=" <?php echo (((isset($settings)) and ($settings == 'settings')) ? 'active' : 'inactive'); ?>">
				<?php echo $this->Html->link(__l('Message Settings') , array('controller' => 'messages', 'action' => 'settings')); ?>
			</li>
		</ul>
	</div>
<?php
	echo $this->element('message_labels_users-lst', array('config' => 'sec', 'key' =>$this->Auth->User('username')));
?>