<div class="messages index js-response js-responses">
<?php //echo $this->element('mail-search', array('config' => 'sec'));?>

	<div class="record-info inbox-option select-block js-pagination clearfix">
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Suspend) ? ' active-filter' : null; ?>
		<div><span class="filter-suspended <?php echo $class; ?>"><?php echo $this->Html->link(__l('Suspended messages:'), array('controller'=>'messages','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('class' => $class, 'title' => __l('Suspended messages')));?>
		  <?php echo $this->Html->cInt($suspended); ?></span>
          </div>

		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) ? ' active-filter' : null; ?>
		<div><span class="filter-flag <?php echo $class; ?>"><?php echo $this->Html->link(__l('System flagged  messages:'), array('controller'=>'messages','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('class' => $class, 'title' => __l('System flagged  messages')));?>
		 	<?php echo $this->Html->cInt($system_flagged); ?></span>
        </div>
		<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'active-filter' : null; ?>
		<div><span class="total-user <?php echo $class; ?> "><?php echo $this->Html->link(__l('Total messages:'), array('controller'=>'messages','action'=>'index'), array('class' => $class, 'title' => __l('Total messages')));?>
		  <?php echo $this->Html->cInt($all); ?></span>
        </div>
	</div>
	<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php

	echo $this->Form->create('Message' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix ')); //js-ajax-form
?>

<?php
	echo $this->Form->input('filter_id', array('type' =>'hidden')); 
	echo $this->Form->autocomplete('Message.username', array('label' => __l('From'), 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
	echo $this->Form->autocomplete('Message.other_username', array('label' => __l('To'), 'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
	echo $this->Form->autocomplete('Property.title', array('label' => __l('Property'), 'acFieldKey' => 'Property.id', 'acFields' => array('Property.title'), 'acSearchFieldNames' => array('Property.title'), 'maxlength' => '255'));

?>

<?php echo $this->Form->submit(__l('Filter'));?>

	<?php echo $this->Form->end();?>
	</div>
	</div>
<?php echo $this->Form->create('Message' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<table class="list">
<tr>
	<th></th>
	<th class="actions"><?php echo __l('Action');?></th>
	<th class="dl"><?php echo __l('Subject'); ?></th>
	<th class="dl"><?php echo __l('Property'); ?></th>
	<th class="dl"><?php echo __l('From'); ?></th>
	<th class="dl"><?php echo __l('To'); ?></th>
	<th class="dc"><?php echo __l('Date'); ?></th>
</tr>
<?php
if (!empty($messages)) :
$i = 0;
foreach($messages as $message):
   // if empty subject, showing with (no suject) as subject as like in gmail
    if (!$message['MessageContent']['subject']) :
		$message['MessageContent']['subject'] = '(no subject)';
    endif;
	if ($i++ % 2 == 0) :
		$row_class = 'row';
	else :
		$row_class = 'altrow';
    endif;
	
	$message_class = "checkbox-message ";
	
	$is_read_class = "";
	
    if ($message['Message']['is_read']) :
        $message_class .= "js-checkbox-active";
    else :
        $message_class .= "js-checkbox-inactive";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row';
    endif;
	$row_class='class="'.$row_class.'"';

	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
	
	if($message['MessageContent']['admin_suspend']):
		$message_class.= ' js-checkbox-suspended';
	else:
		$message_class.= ' js-checkbox-unsuspended';
	endif;
	if(isset($message['MessageContent']['is_system_flagged'])&& $message['MessageContent']['is_system_flagged'] ):
		$message_class.= ' js-checkbox-flagged';
	else:
		$message_class.= ' js-checkbox-unflagged';
	endif;
	
		$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
?>
    <tr <?php echo $row_class;?>>

		<td class="w-one">
				<?php echo $this->Form->input('Message.'.$message['Message']['id'], array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => false, 'class' => $message_class.' js-checkbox-list'));?>
		</td>
		
		<td class="actions">
		<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        Action                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                  
			 <?php if($message['MessageContent']['admin_suspend']):?>
				<li><?php echo $this->Html->link(__l('Unsuspend Message'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'unsuspend'), array('class' => 'unsuspend js-delete', 'title' => __l('Unsuspend Message')));?>
				</li>
			<?php else:?>
					<li><?php echo $this->Html->link(__l('Suspend Message'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'suspend'), array('class' => 'suspend js-delete', 'title' => __l('Suspend Message')));?>
					</li>
			<?php endif;?>
			<?php 
				if(isset($message['MessageContent']['is_system_flagged']) && $message['MessageContent']['is_system_flagged']):
					echo '<li>'.$this->Html->link(__l('Clear flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'deactivate'), array('class' => 'clear-flag js-delete', 'title' => __l('Clear flag'))).'</li>';
				else:
					echo '<li>'.$this->Html->link(__l('Flag'), array('action' => 'admin_update_status', $message['MessageContent']['id'], 'flag' => 'active'), array('class' => ' flag js-delete', 'title' => __l('Flag'))).'</li>';
				endif;
			?>
			 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
		</td>
		
        <td  class="dl <?php echo $row_three_class;?>">
             <?php
               if (!empty($message['Label'])):
					?>
					<ul class="message-label-list">
						<?php foreach($message['Label'] as $label): ?>
							<li>
								<?php echo $this->Html->cText($this->Html->truncate($label['name']), false);?>
							</li>
						<?php
						endforeach;
					?>					
					</ul>
					<?php
                endif;
			?>
			<?php 
				echo $this->Html->link($this->Html->truncate($message['MessageContent']['subject'] . ' - ' . substr(strip_tags($message['MessageContent']['message']), 0, Configure::read('messages.content_length'))) ,$view_url);?>
			<?php
				if($message['MessageContent']['admin_suspend']):
					echo '<span class="suspended round-5">'.__l('Admin Suspended').'</span>';
				endif;
				if(isset($message['MessageContent']['is_system_flagged']) && $message['MessageContent']['is_system_flagged']):
					echo '<span class="system-flagged round-5">'.__l('System Flagged').'</span>';
				endif;
				
			?>
        </td>
		
		<td class="dl">
			<?php
				if(!empty($message['Property']['title'])):
					echo $this->Html->link($message['Property']['title'], array('controller' => 'properties', 'action' => 'view', $message['Property']['slug'], 'admin' => false), array('title' => $this->Html->cText($message['Property']['title'], false), 'escape' => false));
				else:
					echo '-';
				endif;
			?>
		</td>	
		

            <td class="w-two dl <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller' => 'users', 'action' => 'view', $message['User']['username'], 'admin' => false), array('title' => $message['User']['username'], 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>
			<td class="w-two dl <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller' => 'users', 'action' => 'view', $message['OtherUser']['username'], 'admin' => false), array('title' => $message['OtherUser']['username'], 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>

        <td class="w-four dc<?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="8" class="notice"><?php echo __l('No messages available') ?></td>
</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($messages)):
        ?>
        <div class="clearfix">
       <div class="admin-select-block clearfix grid_left">
        <div>
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-admin-select-flagged', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-admin-select-unflagged', 'title' => __l('Unflagged'))); ?>
			<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'js-admin-select-suspended', 'title' => __l('Suspended'))); ?>
        </div>
        
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
        <div class="js-pagination grid_right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
 echo $this->Form->end();
    ?>

</div>