<?php /* SVN: $Id: add.ctp 619 2009-07-14 13:25:33Z boopathi_23ag08 $ */ ?>
<div class="propertyFlags form js-responses">
<h2><?php echo __l('Flag This Property');?></h2>
<?php echo $this->Form->create('PropertyFlag', array('class' => 'normal js-ajax-form'));?>
	<?php
		if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
           echo $this->Form->input('user_id', array('empty' => __l('Select')));
        endif;
			 echo $this->Form->input('Property.id',array('type'=>'hidden'));
		echo $this->Form->input('property_flag_category_id', array('label' => __l('Category')));
		echo $this->Form->input('message', array('label' => __l('Message')));
    ?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Submit'));?>
	</div>
    <?php echo $this->Form->end();?>
</div>