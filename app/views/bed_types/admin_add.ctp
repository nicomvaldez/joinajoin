<?php /* SVN: $Id: $ */ ?>
<div class="bedTypes form">
<?php echo $this->Form->create('BedType', array('class' => 'normal'));?>
	<fieldset>
<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
<div class="padd-center clearfix">
	<?php
		echo $this->Form->input('BedType.name', array('label' => __l('Name')));
		echo $this->Form->input('BedType.is_active', array('label' => __l('Active'),'type'=>'checkbox'));
	?>
	</div>
		<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
