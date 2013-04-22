<div class="users stats">
	<div>
		<h3 class="error-log-title"><?php echo __l('Memory Status'); ?></h3>
		<dl class="list clearfix">
			<dt class="altrow"><?php echo __l('Used Cache Memory');?></dt>
				<dd class="altrow"><?php echo $tmpCacheFileSize; ?></dd>
			<dt><?php echo __l('Used Log Memory');?></dt>
				<dd><?php echo $tmpLogsFileSize; ?></dd>
		</dl>
	</div>
	<h3 class="error-log-title"><?php echo __l('Recent Errors & Logs'); ?></h3>
	<div class="clear-log clearfix">
		<div class="clearfix">
			<h4><?php echo __l('Error Log')?></h4>
			<?php echo $this->Html->link(__l('Clear Error Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'error')); ?>
		</div>
		<div><textarea rows="15" class="js-skip"><?php echo !empty($error_log) ? $error_log : '';?></textarea></div>
		<div class="clearfix">
			<h4><?php echo __l('Debug Log')?></h4>
			<?php echo $this->Html->link(__l('Clear Debug Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'debug')); ?>
		</div>
		<div><textarea rows="15" class="js-skip"><?php echo !empty($debug_log) ? $debug_log : '';?></textarea></div>
		<div class="clearfix">
			<h4><?php echo __l('Email Log')?></h4>
			<?php echo $this->Html->link(__l('Clear Email Log'), array('controller' => 'devs', 'action' => 'clear_logs', 'type' => 'email')); ?>
		</div>
		<div><textarea rows="15" class="js-skip"><?php echo !empty($email_log) ? $email_log : '';?></textarea></div>
	</div>
</div>