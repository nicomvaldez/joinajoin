<?php /* SVN: $Id: $ */ ?>
<div class="collections form">
<?php echo $this->Form->create('Collection', array('class' => 'normal', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">


    <?php
		echo $this->Form->input('title', array('label' => __l('Title')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'), 'class' =>'browse-field'));

		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>

	</div>
	<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
    	</fieldset>
    <div class="submit-block clearfix">
     <?php echo $this->Form->submit(__l('Add'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
