<div class="messages contacts">
<div class="main-content-block js-corner round-5">
<h2><?php echo __l('Contacts'); ?></h2>
<div class="form-blocks js-corner round-5">
<?php echo $this->Form->create('UserFriend', array('controller' => 'user_friends' , 'action' => 'contacts' , 'class' => 'normal'));?>
	 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
        <?php echo $this->Form->input('search', array('label' => __l('Search'))); ?>
	</div>
	<div class="padd-bg-bl">
        <div class="padd-bg-br">
            <div class="padd-bg-bmid"></div>
        </div>
    </div>
    <div class="submit-block clearfix">
     <?php echo $this->Form->submit(__l('Search'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
<div class=" message-list">
<ol class="friends-list">
<?php if (!empty($contacts)) { ?>
<?php
$i = 0;
$class = null;
if ($i++ % 2 == 0) {
	$class = ' class="altrow"';
}
foreach($contacts as $contact) { ?>
<li class="list-row clearfix">
	<div class="avatar">
		<?php
			$current_user_details = array(
				'username' => $contact['FriendUser']['username'],
				'user_type_id' => $contact['FriendUser']['user_type_id'],
				'id' => $contact['FriendUser']['id'],
				'fb_user_id' => $contact['FriendUser']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $contact['FriendUser']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'medium_thumb');
		?>
	</div>
	<h4><?php echo $this->Html->link($this->Html->cText($contact['FriendUser']['username'], false), array('controller' => 'users', 'action' => 'view', $contact['FriendUser']['username'])); ?></h4>
</li>
<?php }
} else { ?>
    <li class="notice-info"><p class="notice"><?php echo __l('No user contacts available.');?></p></li>
<?php } ?>
</ol>
</div>
</div>
</div>

