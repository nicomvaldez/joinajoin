<?php /* SVN: $Id: $ */ ?>
<div class="jobOrderDisputes form js-responses ui-corner-right" id="dispute" >
<?php
	if(empty($is_under_dispute)){
		if(!empty($disputeTypes)){
	?>
		<?php echo $this->Form->create('PropertyUserDispute', array('class' => 'normal js-ajax-form'));?>
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				echo $this->Form->input('property_id', array('type' => 'hidden'));
				echo $this->Form->input('property_user_id', array('type' => 'hidden'));
				echo $this->Form->input('is_traveler', array('type' => 'hidden'));
				echo $this->Form->input('dispute_type_id', array('options' => $disputeTypes));
				echo $this->Form->input('reason');
			?>
        <div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Submit Dispute'));?>
		</div>
			<?php echo $this->Form->end();?>
	<?php 
	}else{?>
		<div  class="page-information clearfix">
		<h5><?php echo __l("Dispute is possible only for the following cases."); ?></h5>
			<?php
			echo '<ol class="dispute-list">';
			foreach($AlldisputeTypes as $AlldisputeType){
				echo "<li>".$AlldisputeType."</li>";
			}
			echo "</ol>";
			echo __l("Currently, Your booking hasn't met those cases.");
		?>
		</div>
	<?php
	}
}else{
?>
	<div class="page-information clearfix">
		<?php
			echo __l("Current dispute for this booking hasn't been closed yet. Only one dispute at a time for an booking is possible.");
		?>
	</div>
<?php
}
?>
</div>