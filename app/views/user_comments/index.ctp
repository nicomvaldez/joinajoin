<?php /* SVN: $Id: index.ctp 15559 2010-07-26 05:23:23Z sakthivel_135at10 $ */ ?>
<div class="userComments user-comment-block index js-response">
<h2>
<?php
if (empty($username)):
	echo __l('Recommendations');
endif;
?>
</h2>
<?php echo $this->element('paging_counter'); ?>
<ol class="commment-list list property-list clearfix js-comment-responses" start="<?php echo $this->Paginator->counter(array('format' => '%start%')); ?>">
<?php
if (!empty($userComments)):
    foreach($userComments as $userComment):
?>
    <li class="list-row clearfix" id="comment-<?php echo $userComment['UserComment']['id']; ?>" >
	    <div class="grid_1 alpha">
			<?php 
				$current_user_details = array(
					'username' => $userComment['PostedUser']['username'],
					'user_type_id' => $userComment['PostedUser']['user_type_id'],
					'id' => $userComment['PostedUser']['id'],
					'fb_user_id' => $userComment['PostedUser']['fb_user_id']
				);
				$current_user_details['UserAvatar'] = array(
					'id' => $userComment['PostedUser']['attachment_id']
				);
				echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
			?>
	        </div>
		<div class="grid_14 omega">
            <h3>
			<?php echo $this->Html->link($userComment['UserProfile']['first_name'].' '. $userComment['UserProfile']['last_name'], array('controller' => 'users', 'action' => 'view', $userComment['PostedUser']['username']), array('escape' => false));?>
            </h3>
              <p class="address-info">
	       	  <?php echo __l('Recommended'); ?> <?php echo $this->Time->timeAgoInWords($userComment['UserComment']['created']) ;?>
		  </p>
		  <?php echo $this->Html->cText(nl2br($userComment['UserComment']['comment']));?>
		
		  <?php if ($user['User']['id'] == $this->Auth->user('id') or $userComment['PostedUser']['id'] == $this->Auth->user('id')) { ?>
          <div class="edit-info-block">
            <div class="actions">
            	<?php echo $this->Html->link(__l('Delete'), array('controller' => 'user_comments', 'action' => 'delete', $userComment['UserComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
    		</div>
		</div>
		<?php } ?>
		</div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p  class="notice"><?php echo __l('No recommendations available'); ?></p>
	</li>
<?php
endif;
?>
</ol>
<div class="js-pagination">
<?php
if (!empty($userComments)) {
    echo $this->element('paging_links');
}
?>
</div>

<?php if($this->Auth->user('id') and $this->Auth->user('id') != $user['User']['id']): ?>

		<?php echo $this->element('../user_comments/add', array('config' => 'sec'));?>

<?php endif; ?>
</div>