<div class="user_friends import">
<div class="main-content-block js-corner round-5">
<h2><?php echo __l('Friends Import'); ?></h2>
<div class="form-blocks js-corner round-5">
<?php
	if(isset($exist_friend_arr) or isset($add_friend_arr) or isset($invite_friend_arr)) {
?>
<div id="friends-add-import-div">
	<div class="exist-friend js-responses">
		<?php echo $this->requestAction('temp_contacts/index/1/'.$contacts_source, array('return')); ?>
	</div>
	<div class="add-friend js-responses">
		<?php echo $this->requestAction('temp_contacts/index/2/'.$contacts_source, array('return')); ?>
	</div>
	<div class="invite-friend js-responses">
		<?php echo $this->requestAction('temp_contacts/index/3/'.$contacts_source, array('return')); ?>
	</div>
</div>
<?php
	}
	else {
?>
<div>
	<div class="js-tabs">
	<div class="pptab-menu-left">
					<div class="pptab-menu-right">
            <div class="pptab-menu-center">
    	<ul class="clearfix">
    		<li class="yahoo"><?php echo $this->Html->link(__l('YAHOO!'), '#yahoo-import'); ?></li>
    		<li class="gmail"><?php echo $this->Html->link(__l('Gmail'), '#gmail-import'); ?></li>
    		<li class="msn"><?php echo $this->Html->link(__l('MSN'), '#msn-import'); ?></li>
    		<li class="msn"><?php echo $this->Html->link(__l('CSV Import'), '#csv-import'); ?></li>
    	</ul>
    	</div></div></div>
    	<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix import-block">
	<div id="yahoo-import" class="friends-request">
		<div class="display-information">
			<p class="friends-info"><?php echo sprintf(__l('You need to give %s permission to access your Yahoo! Mail address book.'), Configure::read('site.name'));?></p>
			<p><?php echo sprintf(__l('We\'ll take you to Yahoo! where you\'ll be asked to let %s take a peek at your address book. Once you get there, click "Grant access" and you\'ll be returned here to find your friends.'), Configure::read('site.name'));?></p>
		</div>
		<div>
		<div class="import-note" class="friends-request">
        	<h4><?php echo __l('Your privacy is our top concern');?></h4>
            <p class="page-information">
                <?php echo sprintf(__l('Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %'), Configure::read('site.name'), Configure::read('site.name'));?>
                <span><?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy'), array('class'=>'js-contact-thickbox'));?></span>
            </p>
		</div>
			<?php
			echo $this->Form->create('UserFriend', array('action' => 'import', 'class' => 'normal','id'=>'yahoo-form'));
			echo $this->Form->hidden('domain', array('value' => 'yahoo','id'=>'yahoodomain')); ?>
            <div class="clearfix">
            <?php
			echo $this->Form->submit(__l('Go')); ?>
            </div>
           <?php echo $this->Form->end(); ?>
		</div>
	</div>
	<div id="gmail-import" class="friends-request">
		<div class="display-information">
            <p class="friends-info"><?php echo sprintf(__l('You need to give %s permission to access your Gmail address book.'), Configure::read('site.name'));?></p>
			<p><?php echo sprintf(__l('We\'ll take you to Google where you\'ll be asked to let %s take a peek at your address book. Once you get there, click "Grant access" and you\'ll be returned here to find your friends.'), Configure::read('site.name'));?></p>
		</div>
	
		<div class="import-note">
        	<h4><?php echo __l('Your privacy is our top concern');?></h4>
            <p class="page-information">
                <?php echo sprintf(__l('Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %'), Configure::read('site.name'), Configure::read('site.name'));?>
                <span><?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy'), array('class'=>'js-contact-thickbox'));?></span>
            </p>
		</div>
			<div>
			<?php
				echo $this->Form->create('UserFriend', array('action' => 'import', 'class' => 'normal','id'=>'gmail-form'));
				echo $this->Form->hidden('domain', array('value' => 'gmail','id'=>'gmaildomain')); ?>
				<div class="clearfix">
            <?php
			echo $this->Form->submit('Go'); ?>
            </div>
           <?php echo $this->Form->end(); ?>
		</div>
	</div>
	<div id="msn-import" class="friends-request">
		<div class="display-information">
            <p class="friends-info"><?php echo sprintf(__l('You need to give %s permission to access your Windows Live Hotmail address book.'), Configure::read('site.name'));?></p>
			<p><?php echo sprintf(__l('We\'ll take you to Windows Live where you\'ll be asked to let %s take a peek at your address book. Once you get there, click "Grant access" and you\'ll be returned here to find your friends.'), Configure::read('site.name'));?></p>
		</div>
	
		<div class="import-note">
        	<h4><?php echo __l('Your privacy is our top concern');?></h4>
            <p class="page-information">
                <?php echo sprintf(__l('Your contacts are your private information. Only you have access to your contacts, and %s will not send them any email. For more information please see the %'), Configure::read('site.name'), Configure::read('site.name'));?>
                <span><?php echo $this->Html->link(__l('Privacy Policy'), array('controller' => 'pages', 'action' => 'view', 'privacy_policy'), array('class'=>'js-contact-thickbox'));?></span>
            </p>
		</div>
			<div>
			<?php
				echo $this->Form->create('UserFriend', array('action' => 'import', 'class' => 'normal','id'=>'msn-form'));
				echo $this->Form->hidden('domain', array('value' => 'msn','id'=>'msndomain')); ?>
				<div class="clearfix">
            <?php
			echo $this->Form->submit('Go'); ?>
            </div>
           <?php echo $this->Form->end(); ?>
		</div>
	</div>
	<div id="csv-import">
		<div class="display-information">
            <?php echo __l('You can export contacts to a file (csv - comma separated values) from any address book software and upload that file.'); ?>
			<a href="<?php echo Router::url('/').'files/sample.csv'	?>"  target = '_blank' title ="<?php echo __l("View Sample CSV File");?> "><?php echo __l("View Sample CSV File");?></a>
		</div>

		<div class="import-note">
		</div>
				<div>
			<?php
				echo $this->Form->create('UserFriend', array('action' => 'import', 'class' => 'normal', 'id'=>'csv-form', 'enctype' => 'multipart/form-data'));
                echo $this->Form->input('Attachment.filename', array('type' => 'file', 'label' => __l('Upload Friends'), 'class' =>'browse-field'));
				echo $this->Form->end('Go');
			?>
		</div>
	</div>
	</div></div></div>
	<div class="pptview-mblock-bl">
						 <div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
           </div>
          </div>
  </div>
</div>
<?php
	}
?>
</div>
</div>
</div>