<?php /* SVN: $Id: $ */ ?>
<?php //echo "<pre>"; print_r($propertyInfo); exit; ?>
<div class="propertyFeedbacks side1 grid_18 form clearfix">

<?php echo $this->Form->create('PropertyUserFeedback', array('class' => 'normal'));?>

	<div class="massage-view-block clearfix">
	<?php
		//pr($message);
		echo $this->Form->input('property_id',array('type'=>'hidden','value' => $message['property_id']));
		echo $this->Form->input('property_user_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('traveler_user_id',array('type'=>'hidden','value' => $message['property_user_user_id']));
		echo $this->Form->input('host_user_id',array('type'=>'hidden','value' => $this->Auth->user('id')));
		echo $this->Form->input('property_order_id',array('type'=>'hidden','value' => $message['property_order_id']));
		echo $this->Form->input('property_user_id',array('type'=>'hidden','value' => $message['property_user_id']));
		echo $this->Form->input('property_order_user_email',array('type'=>'hidden','value' => $message['property_traveler_email']));
		?>
	<div class="massage-head">
	<h2 class="message-user-info">
		<?//php	echo 'Message from '.$this->Html->link($this->Html->cText($message['property_username'],false), array('controller'=> 'users', 'action' => 'view', $message['property_username']), array('title' => $this->Html->cText($message['property_username'],false),'escape' => false));?>
		<?php echo __l('Review and rate this Traveler');?>
    </h2>
	<div>
		<?php 
			$checkin_date = strtotime($propertyInfo['PropertyUser']['checkin']);
			$checkout_date = strtotime($propertyInfo['PropertyUser']['checkout']);
			$days = (($checkout_date - $checkin_date) / (60*60*24)) + 1;
		?>
		<div class="clearfix review-date-info-block grid_15">
    	   <div class="grid_2">
    	   <?php
				$current_user_details = array(
					'username' => $traveler['User']['username'],
					'user_type_id' => $traveler['User']['user_type_id'],
					'id' => $traveler['User']['id'],
					'fb_user_id' => $traveler['User']['fb_user_id']
				);
				$current_user_details['UserAvatar'] = array(
					'id' => $traveler['User']['attachment_id']
				);
				echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
			?>
    	   <?php echo $this->Html->link($this->Html->cText($traveler['User']['username'],false), array('controller' => 'users', 'action' => 'view', $traveler['User']['username']), array('escape' => false));?>
    	   </div>
    		<div class="grid_4">
        		<p ><?php echo date('D, d M Y', $checkin_date); ?></p>
        		<span><?php echo date('h:i a', $checkin_date); ?></span>
            </div>
            <span class="grid_4"><?php echo '(' . $days . ' - ' . __l('nights') . ')'; ?></span>
            <div class="grid_4">
            	<p><?php echo date('D, d M Y', $checkout_date); ?></p>
        		<span><?php echo '11:59 pm'; ?></span>
    		</div>
		</div>
	</div>
    <?php
		//$replace = array('##REVIEW##' => '', '##NEWORDER##' => '');
		//$message_content =  strtr($message['message'],$replace);
	?>
	<?php
		if (!empty($message['attachment'])) :
			?>
			<h4><?php echo count($message['attachment']).' '. __l('attachments');?></h4>
			<ul>
			<?php
			foreach($message['attachment'] as $attachment) :
		?>
			<li>
			<span class="attachement"><?php echo $attachment['filename']; ?></span>
			<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
			<span><?php echo $this->Html->link(__l('Download') , array( 'controller' => 'messages', 'action' => 'download', $message['message_hash'], $attachment['id'])); ?></span>
			</li>
		<?php
			endforeach;
		?>
		</ul>
		<?php
		endif;
		?> 		</div>
		<fieldset>
		  <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center clearfix">
	
	<div class="propertys-download-block">
        <div class="clearfix">
		<h3 class="grid_6 omega alpha"> <?php echo __l('Are you satisfied this traveler?');?></h3>
	
		<?php
			echo $this->Form->input('is_satisfied',array('label' => __l('Satisfied'),'div'=>'input radio feedback-block grid_8', 'type'=>'radio','legend'=>false,'options'=>array('1'=>__l('Yes'),'0'=>__l('No')),'class' => '' ));
		?>
        </div>
		<div class="js-negative-block <?php echo ($this->request->data['PropertyUserFeedback']['is_satisfied'] == 0) ? '' : 'hide'; ?>">
			<p class="negative-block-info"><?php echo __l('Please give your host a chance to improve his work before submitting a negative review. ').' '.$this->Html->link(__l('Contact Your Seller'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $message['property_seller_username'],'property_order_id' => $message['property_order_id'], 'review' => '1'), array('title' => __l('Contact Your Seller')));?></p>
		</div>
		<?php
			echo $this->Form->input('feedback',array('label' => __l('Review')));
		?>
	</div>
  
    </div>
	<div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid"></div>
        </div>
    </div>
	</fieldset>

		<div class="clearfix submit-block">
<?php echo $this->Form->submit(__l('Submit'));?>
</div>
</div>
<?php echo $this->Form->end();?>

</div>