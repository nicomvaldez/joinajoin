<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userFriends index">
<ol class="friends clearfix " start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userFriends)) {
foreach ($userFriends as $userFriend) {
?>
	<li id="friend-<?php echo $userFriend['UserFriend']['id']; ?>" class="friend">
		<?php
			$current_user_details = array(
				'username' => $userFriend['FriendUser']['username'],
				'user_type_id' => $userFriend['FriendUser']['user_type_id'],
				'id' => $userFriend['FriendUser']['id'],
				'fb_user_id' => $userFriend['FriendUser']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $userFriend['FriendUser']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'medium_thumb');
		?>
	</li>
<?php
    } ?>
</ol>
 <?php  }

else {
?>
<div>
		<p class="notice"><?php echo __l('No friends available'); ?></p>
</div>

<?php
 	}
?>

<?php
if (!empty($userFriends) and $total_friends > 12) {
    echo $this->element('paging_links');
}
?>
</div>