<?php /* SVN: $Id: $ */ ?>
<div class="propertyTypes form">
<?php echo $this->Form->create('PropertyType', array('class' => 'normal'));?>
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
