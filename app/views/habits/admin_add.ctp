<?php /* SVN: $Id: $ */ ?>
<div class="habits form">
<?php echo $this->Form->create('Habit', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
