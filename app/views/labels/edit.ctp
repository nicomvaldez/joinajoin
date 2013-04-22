<?php /* SVN: $Id: $ */ ?>
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec'));?>
<div class="labels form">
<?php echo $this->Form->create('Label', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>
