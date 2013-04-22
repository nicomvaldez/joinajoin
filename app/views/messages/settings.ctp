<?php /* SVN: $Id: settings.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<div class="mail-right-block grid_5">
    <div class="block2-tl">
    	<div class="block2-tr">
    		<div class="block2-tm">
                    <h4><?php echo __l('Mail');?></h4>
            </div>
            </div>
    	</div>
		<div class="block1-cl">
		<div class="block1-cr">
			<div class="block1-cm">
			<div class="main-section main-message-block">
        <?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
        	</div>
	</div>
							</div>
						</div>
						<div class="block2-bl">
							<div class="block2-br">
							<div class="block2-bm"></div>
							</div>
						</div>
</div>
<div class="messages-settings message-side2">
<div class="block2-tl">
			<div class="block2-tr">
							<div class="block2-tm">
                            <h2 class="title"><?php echo __l('General Settings');?>
</h2>
</div>
							</div>
						</div>
	<div class="block2-cl">
							<div class="block2-cr">
								<div class="block2-cm">
								<div class="main-section">
    <?php
            echo $this->Form->create('Message', array('action' => 'settings', 'class' => 'normal  js-form-settings')); ?>
	 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
  
    <div id="message-settings">
      <?php
            echo $this->Form->input('UserProfile.message_page_size', array('label' => __l('Message Page Size')));
            echo $this->Form->input('UserProfile.message_signature', array('label' => __l('Message Signature'), 'type' => 'textarea'));
          ?>
	</div>
	</div>
	<div class="padd-bg-bl">
        <div class="padd-bg-br">
            <div class="padd-bg-bmid"></div>
        </div>
    </div>
    <div class="submit-block clearfix">
    <?php
      echo $this->Form->submit(__l('Update')); ?>
      </div>
      <?php
            echo $this->Form->end();
        ?>
        </div>
	</div>
							</div>
						</div>
						<div class="block2-bl">
							<div class="block2-br">
							<div class="block2-bm"></div>
							</div>
						</div>
</div>
