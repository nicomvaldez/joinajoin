<div class="project_guideline">
	<ul class="project-guideline-block">
		<li class="home"><span><?php echo __l('Add Property'); ?> </span>
			<ul>
				<?php if (Configure::read('property.listing_fee')) { 
						$fee =__l('Listing Fee ');
						$fee .=$this->Html->siteCurrencyFormat(Configure::read('property.listing_fee'),false);
				?>
			
				<li> <span><?php echo __l('Pay Through PayPal').' ('.$fee.')'; ?> </span></li>
				<?php } ?>
				<?php if (!Configure::read('property.is_auto_approve')) { ?>
				<li> <span><?php echo __l('Pending (Admin will approve your property)'); ?> </span></li>
				<?php } ?>
				<li> <span><?php echo __l('Listed'); ?></span></li>
			</ul>
		</li>
	</ul>
</div>
