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
<div class="messages index message-compose-block message-side2">
<div class="block2-tl">
			<div class="block2-tr">
							<div class="block2-tm">
                            <h2 class="title"><?php echo __l('Compose');?>
</h2>
</div>
							</div>
						</div>
	<div class="block2-cl">
							<div class="block2-cr">
								<div class="block2-cm">
								<div class="main-section">
<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose normal', 'enctype' => 'multipart/form-data')); ?>
<?php
if((!empty($this->request->params['named']['type']) == 'contact') || (!empty($this->request->data['Message']['type']) && (($this->request->data['Message']['type']  == 'contact') || ($this->request->data['Message']['type']  == 'user')))){
?>
<div class="mail-content-curve-middle">
<div class="send-iteam-block">
<div class="add-block">
<?php
	echo $this->Html->link(__l('Inbox') , array('controller' => 'messages','action' => 'inbox')); ?>
	<?php
	echo $this->Html->link(__l('Sent items') , array('controller' => 'messages','action' => 'sentmail'));
    ?>
</div>
</div>
    <div class="clearfix input">
 
    <span class="grid_5 omega message-title  alpha">
        <?php 	echo __l('From'); ?>
    </span>
    <span class="grid_10  omega alpha"> 
             <?php echo $this->Html->link($this->Html->cText($from_user['UserProfile']['first_name'].' '.$from_user['UserProfile']['last_name']), array('controller'=> 'users', 'action' => 'view', $this->Auth->user('username')), array('title' => $this->Html->cText($this->Auth->user('username'),false),'escape' => false));
             ?>
     </span>
    </div>
      <div class="clearfix input">
     <span class="grid_5 message-title omega alpha">
       <?php 	echo __l('To'); ?>
    </span>
	  <span class="grid_10 omega alpha">
	       	<?php echo !empty($this->request->data['Message']['to_username']) ? $this->Html->link($this->Html->cText($this->request->data['Message']['name']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to_username']), array('title' => $this->Html->cText($this->request->data['Message']['to_username'],false),'escape' => false)) : ''; ?>
        </span>
   </div>
    <?php if (!empty($this->request->data['Message']['property_name']) || !empty($this->request->data['Message']['request_name'])): ?>
    <div class="clearfix input">
		<span class="grid_5 message-title omega alpha">
			<?php echo 'Join';//$this->request->data['Message']['from'];  ?>
		</span>
		<span class="grid_10 omega alpha">
		<?php if($this->request->data['Message']['from']=='Property'): ?>
		<?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['property_name']), array('controller' => 'properties', 'action' => 'view',  $this->request->data['Message']['property_slug']), array('title' => $this->Html->cText($this->request->data['Message']['property_name'],false),'escape' => false));?>
		<?php elseif($this->request->data['Message']['from']=='Request'): ?>
		<?php echo $this->Html->link($this->Html->cText($this->request->data['Message']['request_name']), array('controller' => 'requests', 'action' => 'view',  $this->request->data['Message']['request_slug']), array('title' => $this->Html->cText($this->request->data['Message']['request_name'],false),'escape' => false));?>
		<?php endif; ?>
		</span>
    </div>
 <?php	endif;  ?>
 <?php if(!empty($this->request->params['named']['property_user_id']) || !empty($this->request->data['Message']['property_user_id'])):?>
	<p class="clearfix">
		<span class="message-title"><?php 	echo __l('Booking#'); ?></span>
		 <?php	if(!empty($this->request->params['named']['property_user_id'])){
				echo $this->request->params['named']['property_user_id'];
			}elseif(!empty($this->request->data['Message']['property_user_id'])){
				echo $this->request->data['Message']['property_user_id'];	
			}
		 ?>
	</p>
	<?php endif;?>
	</div>
<?php }?>
<div class="compose-box">
			<?php
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
					if(!empty($this->request->data['Message']['to_username'])):
						echo $this->Form->input('to_username', array('type' => 'hidden', 'id' => 'message-to'));
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to-name', 'value' => $this->request->data['Message']['to_username']));
					else:
						echo $this->Form->input('to', array('type' => 'hidden', 'id' => 'message-to'));
					endif;
					if (!empty($this->request->data['Message']['property_slug'])):
						echo $this->Form->input('purpose', array('class'=>'js-contact-purpose {"negotiable":"'.$this->request->data['Message']['negotiable'].'"}','type' => 'select','options'=>$contact_purposes,'default'=>4));
					endif;?>
					<div class="js-response"></div>
					<div class="js-contactus-container">
				<?php 
					
					if (!empty($this->request->data['Message']['contact_type']) && ($this->request->data['Message']['contact_type'] == 'deliver')):
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'type' => 'hidden', 'label' => __l('Subject')));
						else:
							echo $this->Form->input('subject', array('id' => 'MessSubject', 'label' => __l('Subject')));
					endif;
					if (!empty($this->request->data['Message']['property_id'])):
						echo $this->Form->input('property_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_slug'])):
						echo $this->Form->input('property_slug', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_name'])):
						echo $this->Form->input('property_name', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['property_user_id'])):
						echo $this->Form->input('property_user_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_id'])):
						echo $this->Form->input('request_id', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_slug'])):
						echo $this->Form->input('request_slug', array('type' => 'hidden'));
					endif;
					if (!empty($this->request->data['Message']['request_name'])):
						echo $this->Form->input('request_name', array('type' => 'hidden'));
					endif;
					echo $this->Form->input('ordered_date', array('type' => 'hidden'));
					echo $this->Form->input('property_amount', array('type' => 'hidden'));
					echo $this->Form->input('contact_type', array('type' => 'hidden'));
            ?>
			<div class="input required message-lable-info">
				<label>	
				<?php
					if(!empty($this->request->params['named']['order']) == 'deliver'):
						echo __l('Message to buyer');
					else:
						echo __l('Message');
					endif;
				?>
				</label>
			</div>
			<?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => false)); ?>
			<span class="message-lable-info">
			<?php
				echo __l('Attachment');
			?>
			</span>
            <div class="atachment">
				<?php echo $this->Form->input('Attachment.filename. ', array('type' => 'file', 'label' => '','size' => '33', 'class' => 'multi file attachment browse-field')); ?>
			</div>

<div class="compose-block clearfix">
<div class="submit-block clearfix" >
	<?php echo $this->Form->submit(__l('Send')); ?>
	<div class="cancel-block">
		<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
    </div>
</div>
</div>
</div>
</div>
<?php echo $this->Form->end(); ?>
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