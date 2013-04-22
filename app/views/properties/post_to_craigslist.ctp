<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-craigslist js-responses">
	<h2><?php echo __l('Post to Craigslist') . ' - ' . $this->Html->cText($property['Property']['title']);?> </h2>
	<?php echo $this->Form->create('Property', array('action' => 'post_to_craigslist', 'class' => 'normal add-property js-post-craigslist-form {"container":"js-responses"}'));?>
		<div>
			<fieldset>
				<div class="padd-bg-tl">
					<div class="padd-bg-tr">
						<div class="padd-bg-tmid"></div>
					</div>
				</div>
				<div class="padd-center">
					<?php echo $this->Form->input('title', array('label' => __l('Posting Title'))); ?>
					<?php echo $this->Form->input('craigslist_category_id', array('label' => __l('Category'), 'empty' => __l('Please Select'))); ?>
					<?php echo $this->Form->input('craigslist_market_id', array('label' => __l('Market'), 'empty' => __l('Please Select'))); ?>
					<?php echo $this->Form->input('property_id', array('type' => 'hidden')); ?>
				</div>
				<div class="padd-bg-bl">
					<div class="padd-bg-br">
						<div class="padd-bg-bmid"></div>
					</div>
				</div>
			</fieldset>
			<div class="submit-block clearfix">
				<?php echo $this->Form->submit(__l('Post to Craigslist')); ?>
			</div>
		</div>
	<?php echo $this->Form->end();?>
</div>
<div class="hide js-craigslist-form"></div>