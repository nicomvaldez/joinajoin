<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges form">
<?php echo $this->Form->create('UserIncomeRange', array('class' => 'normal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('income', array('label' => __l('Income')));
		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	</fieldset>
  <div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Update'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
