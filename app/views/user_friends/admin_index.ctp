<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userFriends index">
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($userFriends)):

$i = 0;
foreach ($userFriends as $userFriend):
	$class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
    endif;
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($userFriend['UserFriend']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($userFriend['UserFriend']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($userFriend['UserFriend']['modified']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($userFriend['User']['username']), array('controller'=> 'users', 'action' => 'view', $userFriend['User']['slug']), array('escape' => false));?></p>
		<p><?php echo $this->Html->cInt($userFriend['UserFriend']['friend_user_id']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($userFriend['FriendStatus']['name']), array('controller'=> 'friend_statuses', 'action' => 'view', $userFriend['FriendStatus']['id']), array('escape' => false));?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $userFriend['UserFriend']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $userFriend['UserFriend']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No User Friends available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($userFriends)) :
    echo $this->element('paging_links');
endif;
?>
</div>
