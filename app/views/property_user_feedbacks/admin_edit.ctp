<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks form">
	<h2><?php echo __l('Edit Feedback');?></h2>
	<?php echo $this->Form->create('PropertyUserFeedback', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('feedback', array('label' => __l('Feedback')));
		echo $this->Form->input('is_satisfied', array('label' => __l('Satisfied')));
	?>
	</fieldset>
	<div class="submit-block clearfix">
      	<?php echo $this->Form->submit(__l('Update')); ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>