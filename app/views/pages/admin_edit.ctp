<?php /* SVN: $Id: admin_edit.ctp 56835 2011-06-14 13:42:32Z arovindhan_144at11 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting');?>
<?php
    if(!empty($page)):
        ?>
        <div class="js-tabs">
        <ul>
            <li><span><?php echo $this->Html->link(__l('Preview'), '#preview'); ?></span></li>
            <li><span><?php echo $this->Html->link(__l('Change'), '#add'); ?></span></li>
        </ul>
        <div id="preview">
            <div class="page">
                    <div class="entry">
                   <?php echo $page['Page']['content']; ?>
                </div>
            </div>
        </div>
        <?php
    endif;
?>
<div id="add">
  <div class="pages form">
		<?php echo $this->Form->create('Page', array('class' => 'normal', 'enctype' => 'multipart/form-data')); ?>
		<fieldset>
			<?php
                echo $this->Form->input('id');
                echo $this->Form->input('title', array('between' => '', 'label' => __l('Page title')));
                echo $this->Form->input('content', array('type' => 'textarea', 'class' => 'js-editor', 'label' =>__l('Body'), 'info' => __l('Available Variables: ##SITE_NAME##, ##SITE_URL##, ##ABOUT_US_URL##, ##CONTACT_US_URL##, ##FAQ_URL##, ##SITE_CONTACT_PHONE##, ##SITE_CONTACT_EMAIL##')));                
			?>
		</fieldset>
		<fieldset>
			<?php
				echo $this->Form->input('meta_keywords', array('label' =>__l('Meta Keywords')));
				echo $this->Form->input('meta_description', array('type' => 'textarea', 'label' =>__l('Meta Description')));
			?>
        </fieldset>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Update'), array('name' => 'data[Page][Update]')); ?>
			<div class="cancel-block">
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'pages', 'action' => 'index'), array('title' => 'Cancel'));?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php if(!empty($page)): ?>
	</div>
<?php endif; ?>