<?php /* SVN: $Id: $ */ ?>
<div class="cancellationPolicies form">
	<?php echo $this->Form->create('CancellationPolicy', array('class' => 'normal'));?>
		<fieldset>
			<?php
				echo $this->Form->input('name', array('label' => __l('Name')));
				echo $this->Form->input('days', array('label' => __l('Prior Days'), 'info' => __l('Traveler can get percentage of refund, if he canceled before the given no. of days before check-in date.')));
				echo $this->Form->input('percentage', array('label' => __l('Percentage'), 'info' => __l('Percentage of amount will be refund to traveler')));
				echo $this->Form->input('is_active', array('type' => 'checkbox', 'label' => __l('Active')));
			?>
		</fieldset>
	<?php echo $this->Form->end(__l('Add'));?>
</div>