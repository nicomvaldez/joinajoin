<div class="js-tabs">	
<?php
	if (!empty($emailTemplates)):
?>
	<ul>
<?php
		foreach ($emailTemplates as $emailTemplate):
?>		
			<li><?php echo $this->Html->link($this->Html->cText($emailTemplate['EmailTemplate']['name'], false), array('controller' => 'email_templates', 'action' => 'edit', $emailTemplate['EmailTemplate']['id']), array('escape' => false,'title' => $this->Html->cText($emailTemplate['EmailTemplate']['name'],false)));?></li>
<?php
		endforeach;
?>
	</ul>
<?php
	else:
?>
	<ul>
		<li><?php echo __l('No e-mail templates added yet.'); ?></li>
	</ul>
<?php
	endif;
?>	
</div>