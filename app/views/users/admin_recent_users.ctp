   <div class="clearfix admin-center-block">
	<div class="block2-tl">
			<div class="block2-tr">
				<div class="block2-tm">
        <h3><?php echo __l('Recently Registered Users'); ?></h3>
		</div></div></div>
		<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm">
		<div class="stats-section">
<?php
	if (!empty($recentUsers)):
		$users = '';
		foreach ($recentUsers as $user):
			$users .= sprintf('%s, ',$this->Html->link($this->Html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false)));
		endforeach;
		echo substr($users, 0, -2);
	else:
?>
	<p class="notice"><?php echo __l('Recently no users registered');?></p>
<?php
	endif;
?>
</div>
		</div>
		</div>
		</div>
		<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
	</div>