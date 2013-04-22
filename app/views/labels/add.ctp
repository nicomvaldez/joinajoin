<?php /* SVN: $Id: $ */ ?>
<div class="mail-right-block grid_6">
<div class="l-curve-top">							
								<div class="top-bg"></div>
							<div class="r-curve-top"></div>
						</div>
						<div class="shad-bg-lft">
							<div class="shad-bg-rgt">
								<div class="shad-bg">
								<div class="main-section">
	<h3><?php echo __l('Mail');?> </h3>

    <?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
</div>
	</div>
							</div>
						</div>
						<div class="l-curve-bot">							
							<div class="bot-bg"></div>
							<div class="r-curve-bot"></div>
						</div>
</div>
<div class="message-side2 grid_18">
<div class="l-curve-top">							
								<div class="top-bg"></div>
							<div class="r-curve-top"></div>
						</div>
						<div class="shad-bg-lft">
							<div class="shad-bg-rgt">
								<div class="shad-bg">
								<div class="main-section">
<div class="labels form">
    <h2  class="title"><?php echo __l('Create Label'); ?></h2>
    <div class="form-blocks js-corner round-5">
        <?php
            echo $this->Form->create('Label', array('class' => 'normal js-form'));
            echo $this->Form->input('name');
            echo $this->Form->end(__l('Add'));
        ?>
    </div>
	</div>
	</div>
	</div>
							</div>
						</div>
						<div class="l-curve-bot">							
							<div class="bot-bg"></div>
							<div class="r-curve-bot"></div>
						</div>
</div>
