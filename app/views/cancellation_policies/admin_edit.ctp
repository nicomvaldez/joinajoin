<?php /* SVN: $Id: $ */ ?>
<div class="cancelationPolicies form">
	<?php echo $this->Form->create('CancellationPolicy', array('class' => 'normal'));?>
		<fieldset>
			<div class="padd-bg-tl">
				<div class="padd-bg-tr">
					<div class="padd-bg-tmid"></div>
				</div>
			</div>
			<div class="padd-center clearfix">
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name', array('label' => __l('Name')));
					echo $this->Form->input('days', array('label' => __l('Prior Days'), 'info' => __l('Traveler can get percentage of refund, if he canceled before the given no. of days before check-in date.')));
					echo $this->Form->input('percentage', array('label' => __l('Percentage'), 'info' => __l('Percentage of amount will be refund to traveler')));
					echo $this->Form->input('is_active', array('label' => __l('Active')));
				?>
			</div>
			<div class="padd-bg-bl">
				<div class="padd-bg-br">
					<div class="padd-bg-bmid"></div>
				</div>
			</div>
		</fieldset>
	<?php echo $this->Form->end(__l('Update'));?>
</div>