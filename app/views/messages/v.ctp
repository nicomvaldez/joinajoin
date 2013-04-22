<?php /* SVN: $Id: $ */ ?>
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
<div class="messages message-side2">
<div class="l-curve-top">							
								<div class="top-bg"></div>
							<div class="r-curve-top"></div>
						</div>
						<div class="shad-bg-lft">
							<div class="shad-bg-rgt">
								<div class="shad-bg">
<div class="main-section js-corner round-5">
<div class="mail-side-two">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal'));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden('label_slug', array('value' => $label_slug,'name' => 'data[Message][label_slug]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
    <div class="mail-main-curve">
			<div>
			<?php
                if (!empty($label_slug) && $label_slug != 'null') :
                    echo $this->Html->link(__l('Back to Label') , array('controller' => 'messages','action' => 'label',$label_slug));
                elseif (!empty($is_starred)) :
                    echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'));
                else :
                    echo $this->Html->link(__l('Back to') . ' ' . $back_link_msg, array('controller' => 'messages','action' => $folder_type));
                endif;
            ?>
			</div>
			<div class="message-block clearfix js-message-action-block">
				<div class="message-block-left submit-block grid_7"  >
			<?php echo $this->Form->input('more_action_1', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action'));?>
			</div>
			<div class="message-block-right grid_10 submit-block">
    			<?php
                    echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
                    echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
                    echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
                ?>
			</div>
        </div>
              <div class="mail-body js-corner round-5">
                <div class="mail-content-curve-middle">
			   <div class="js-show-mail-detail-div show-mail">
				<?php
				//debug($message);
                    if ($message['Message']['is_sender'] == 0) : ?>
                    	<p class="clearfix"><span class="show-details-left"><?php echo __l('From').': ';  ?></span> <?php echo $message['OtherUser']['UserProfile']['first_name'].' '.$message['OtherUser']['UserProfile']['last_name']; ?></p>
                    <?php
                    else : ?>
                    	<p  class="clearfix"><span class="show-details-left"><?php echo __l('From').': ';  ?></span> <?php echo $message['User']['UserProfile']['first_name'].' '.$message['User']['UserProfile']['last_name'] ; ?> < <?php echo $message['User']['email']; ?> ></p>
        			<?php
                    endif; ?>
    				<p  class="clearfix"><span class="show-details-left"><?php echo __l('To').': ';  ?></span><?php echo $show_detail_to; ?></p>
					<p  class="clearfix"><span class="show-details-left"><?php echo __l('Date').': ';  ?></span><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $this->Time->timeAgoInWords($message['Message']['created']); ?>)</p>
					<?php if (!empty($message['Message']['property_id'])) :?>
						<p class="celarfix"><span class="show-details-left"><?php echo __l('Property').':'.' '; ?></span><?php echo $this->Html->link($message['Property']['title'], array('controller' => 'properties', 'action' => 'view', $message['Property']['slug']), array('title' => $message['Property']['title']));?></p>
					<?php endif;?>
					<?php if (!empty($message['Message']['request_id'])) :?>
						<p class="celarfix"><span class="show-details-left"><?php echo __l('Request').':'.' '; ?></span><?php echo $this->Html->link($message['Request']['title'], array('controller' => 'requests', 'action' => 'view', $message['Request']['slug']), array('title' => $message['Request']['title']));?></p>
					<?php endif;?>
					<?php if (!empty($message['Message']['property_user_id'])) :?>
						<p class="celarfix"><span class="show-details-left"><?php echo __l('Activity').':'.' '; ?></span><?php echo $this->Html->link($message['Message']['property_user_id'], array('controller' => 'messages', 'action' => 'activities', 'order_id' => $message['Message']['property_user_id']), array('title' => $message['Message']['property_user_id']));?></p>
					<?php endif; ?>
					<p  class="clearfix"><span class="show-details-left"><?php echo __l('Subject').': ';  ?></span><?php echo $this->Html->cText($message['MessageContent']['subject']); ?> </p>
				</div>
                <div class="message-inner-content">
					<?php
						if (!empty($message['Message']['property_user_status_id']) && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::FromTravelerConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::PrivateConversation && $message['Message']['property_user_status_id'] != ConstPropertyUserStatus::NegotiateConversation):
							echo $message['MessageContent']['message'];
						else:
							echo nl2br($this->Html->cHtml($message['MessageContent']['message']));
						endif;
					?>
                </div>
				<?php if(ConstUserTypes::Admin != $message['OtherUser']['user_type_id'] && empty($message['Message']['is_sender'])): ?>
					<ul class="replay-forward-links  clearfix">
						<li><?php echo $this->Html->link(__l('Reply') , array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'reply'), array('class'=>'btn btn-success btn-large','escape' => false)); ?></li>
					</ul>
				<?php endif;?>
                <div class="download-block">
                <?php
                if (!empty($message['MessageContent']['Attachment'])) :
					?>
					<h4><?php echo count($message['MessageContent']['Attachment']).' '. __l('attachments');?></h4>
					<ul>
					<?php
                    foreach($message['MessageContent']['Attachment'] as $attachment) :
                ?>
					<li>
                	<span class="attachement"><?php echo $attachment['filename']; ?></span>
                	<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['id'], $attachment['id'])); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>
            </div>
       </div>
        <div class="message-block clearfix">
        <div class="message-block-left submit-block grid_7" >
			<?php
            echo $this->Form->input('more_action_2', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action2' ));
            ?>
			</div>

        <div class="message-block-right grid_10 submit-block">
        <?php
            echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
            echo $this->Form->submit(__l('Spam'), array( 'name' => 'data[Message][ReportSpam]'));
            echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
        ?>
        </div>
        </div>
<p class="back-to-inbox">
    <?php
    if (!empty($label_slug) && $label_slug != 'null') :
        echo $this->Html->link('Back to Label', array( 'controller' => 'messages','action' => 'label', $label_slug), array('class' => 'btn btn-success btn-large'));
    elseif (!empty($is_starred)) :
        echo $this->Html->link('Back to Starred', array('controller' => 'messages','action' => 'starred'), array('class' => 'btn btn-success btn-large'));
    else :
        echo $this->Html->link(__l('Back to') . ' ' . $back_link_msg, array(
            'controller' => 'messages',
            'action' => $folder_type
        ), array('class' => 'btn btn-success btn-large'));
    endif;
    ?>
</p>
     </div>
	<?php echo $this->Form->end();
?>
</div>
</div>
	</div>
							</div>
						</div>
						<div class="l-curve-bot">							
							<div class="bot-bg"></div>
							<div class="r-curve-bot"></div>
						</div>
</div>