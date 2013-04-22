<?php /* SVN: $Id: index.ctp 714 2009-07-20 17:13:32Z boopathi_026ac09 $ */ ?>
<div id="temp-contacts-<?php echo $member; ?>">
	<div class="tempContacts index">
        <div class="info-msg"><h2><?php
            if($member == 1) {
            	echo __l('Contacts found in your friends list');
            } else if($member == 2) {
                echo __l('Contacts found in'); ?> <?php echo Configure::read('site.name');
            } else if($member == 3) {
                echo __l('Invite your contacts to'); ?> <?php echo Configure::read('site.name');
            } ?>
    	</h2></div>
		<?php
        	echo $this->Form->create('UserFriend', array('id' => 'UserFriend'.$member, 'action' => 'importfriends', 'class' => 'normal js-ajax-form'));
        	echo $this->Form->input('contacts_source', array('type' => 'hidden', 'value' => $contacts_source));
			echo $this->Form->input('member', array('type' => 'hidden', 'value' => $member));
		?>
		<table class="list">
			<?php
				if (!empty($tempContacts)):
					$i = 0;
			?>
			<tr>
				<th><?php echo __l('Contact Name') ;?></th>
				<th><?php echo __l('Contact E-mail') ;?></th>
                <th><?php
                    if($member == 1) {
                        echo $this->Form->input('all', array('type' => 'select', 'class' => 'js-exist-all', 'label' => '', 'options' => $exist_friend_options));
                    } elseif($member == 2) {
                        echo $this->Form->input('all', array('type' => 'select', 'class' => 'js-add-all', 'label' => '', 'options' => $add_friend_options));
                    } elseif($member == 3) {
                        echo $this->Form->input('all', array('type' => 'select', 'class' => 'js-invite-all', 'label' => '', 'options' => $invite_friend_options));
                    } ?>
                </th>
			</tr>
			<?php
				foreach ($tempContacts as $tempContact):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
			?>
			<tr<?php echo $class;?>>
				<td><?php echo $this->Html->truncate($tempContact['TempContact']['contact_name'], 12); ?></td>
				<td><?php echo $this->Html->truncate($tempContact['TempContact']['contact_email'], 30); ?></td>
                <td><?php
                    if($tempContact['TempContact']['is_member'] == 1) {
                        echo $this->Form->input($tempContact['TempContact']['id'], array('type' => 'select', 'class' => 'exist-select', 'label' => '', 'options' => $exist_friend_options));
    	            } elseif($tempContact['TempContact']['is_member'] == 2) {
    	                echo $this->Form->input($tempContact['TempContact']['id'], array('type' => 'select', 'class' => 'add-select', 'label' => '', 'options' => $add_friend_options));
                    } elseif($tempContact['TempContact']['is_member'] == 3) {
                        echo $this->Form->input($tempContact['TempContact']['id'], array('type' => 'select', 'class' => 'invite-select', 'label' => '', 'options' => $invite_friend_options));
    		        } ?>
                </td>
			</tr>
			<?php
				endforeach;
				else:
			?>
			<tr>
				<?php if($member == 1) { ?>
					<td colspan="8" class="notice"><?php echo __l('No'); ?> <?php echo Configure::read('site.name');?> <?php echo __l('friends available in your mail'); ?></td>
				<?php } else if($member == 2) { ?>
					<td colspan="8" class="notice"><?php echo __l('No');?> <?php echo Configure::read('site.name'); ?> <?php echo __l('contacts available in your mail');?></td>
				<?php } else if($member == 3) { ?>
					<td colspan="8" class="notice"><?php echo __l('No contacts available in your mail');?></td>
				<?php } ?>
			</tr>
			<?php
				endif;
			?>
		</table>
		<?php 
			if (!empty($tempContacts)):
				echo $this->Form->submit(__l('Submit'));
		?>
			<div class="cancel-block">
		<?php
				echo $this->Html->link(__l('Cancel'), array('controller' => 'user_friends', 'action' => 'import'), array('class' => 'cancel-button'));
		?>
			</div>
		<?php
			endif;
		?>
		<?php echo $this->Form->end(); ?>
		<div class="clearfix">
		<?php
			if (!empty($tempContacts)) {
				echo $this->element('paging_links');
			}
		?>
		</div>
	</div>
</div>