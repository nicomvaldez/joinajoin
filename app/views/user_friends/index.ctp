<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userFriends index js-response">
<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='user'): ?>
<?php else: ?>
<h2><?php echo $this->pageTitle;?></h2>
<?php endif; ?>
<?php //echo $this->element('paging_counter');?>
<ol class="friends-list clearfix js-response" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userFriends)) {
foreach ($userFriends as $userFriend) {
?>
	<li id="friend-<?php echo $userFriend['UserFriend']['id']; ?>" class="list-row clearfix ">
<?php
		if ($type == 'received') {
?>
		<div class="friends-list-block">
			<?php
				$current_user_details = array(
					'username' => $userFriend['User']['username'],
					'user_type_id' => $userFriend['User']['user_type_id'],
					'id' => $userFriend['User']['id'],
					'fb_user_id' => $userFriend['User']['fb_user_id']
				);
				$current_user_details['UserAvatar'] = array(
					'id' => $userFriend['User']['attachment_id']
				);
				echo $this->Html->getUserAvatarLink($current_user_details, 'medium_thumb');
			?>
        	<p class="meta-row author">
		        <cite><span title="<?php echo $userFriend['User']['username'];?>"><?php echo $this->Html->link($this->Html->cText($userFriend['User']['username']), array('controller'=> 'users', 'action' => 'view', $userFriend['User']['username']), array('escape' => false));?></span></cite>
		    </p>
		</div>
<?php
		}
		else {
?>
		<div class="friends-list-block">
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
        	<p class="meta-row friends-list-author">
		        <cite><span title="<?php echo $userFriend['FriendUser']['username'];?>"><?php echo $this->Html->link($this->Html->cText($userFriend['FriendUser']['username']), array('controller'=> 'users', 'action' => 'view', $userFriend['FriendUser']['username']), array('escape' => false));?></span></cite>
		    </p>
		</div>
<?php
		}
?>
	</li>
<?php
    }
  }
else {
?>
	<li class="notice-info">
		<p class="notice">
			<?php
			if ($status == ConstUserFriendStatus::Approved) {
				echo __l('No friends available');
			}
			else if ($status == ConstUserFriendStatus::Rejected) {
				echo __l('No rejected friends available');
			}
			else if ($status == ConstUserFriendStatus::Pending) {
				echo __l('No pending friends available');
			}
			?>
		</p>
	</li>
<?php
 	}
?>
</ol>
 <div class="js-pagination">
<?php
if (!empty($userFriends)) {
if(count($userFriends)>10):
    echo $this->element('paging_links');
endif;
}
?>
</div>
</div>