<div class="messages index message-compose-block js-responses">
<?php
if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message', array('config' => 'sec'));
endif;
?>
<?php //echo '<pre>'; print_r($this->request->data); exit;?>
<?php echo $this->Form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'simple_compose', 'admin' => false), 'class' => 'compose normal js-ajax-form', 'enctype' => 'multipart/form-data')); ?>
<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>

	<div class="compose-box padd-center" id="js-amount-negotiate-block">
		<?php
			echo $this->Form->input('property_user_dispute_id', array('type' => 'hidden'));
			echo $this->Form->input('to_user_id', array('type' => 'hidden'));
			echo $this->Form->input('to_username', array('type' => 'hidden'));
			echo $this->Form->input('type', array('type' => 'hidden'));
			if(!empty($this->request->data['Message']['property_id'])):
				echo $this->Form->input('property_id', array('type' => 'hidden'));
			endif;
			if(!empty($this->request->data['Message']['property_user_id'])):
				echo $this->Form->input('property_user_id', array('type' => 'hidden'));
			endif;
			if(isset($this->request->data['Message']['conversaction_type']) && !empty($this->request->data['Message']['conversaction_type'])):
				echo $this->Form->input('conversaction_type', array('type' => 'hidden'));
			endif;
		?>
		<?php if(isset($this->request->data['Message']['conversaction_type']) && $this->request->data['Message']['conversaction_type'] == 'private'): ?>
		<div class="page-information clearfix">
			<?php echo __l('Your private note for your own reference.'); ?>
		</div>
		<?php endif; ?>
		<?php
        if ($propertyOreder['Property']['user_id'] == $this->Auth->user('id') && $propertyOreder['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($propertyOreder['PropertyUser']['is_negotiation_requested']) && (empty($this->request->data['Message']['conversaction_type']) || !empty($this->request->data['Message']['conversaction_type']) && $this->request->data['Message']['conversaction_type'] != 'private')): ?>
		<div class="page-information clearfix">
			<?php echo __l('Host commission will be calculated from original price; not from negotiated price.'); ?>
		</div>
		<?php endif; ?>
		<div class="input required message-lable-info">
			<label>	
			<?php
			$msg_label = __l('Message');
			if(isset($this->request->data['Message']['conversaction_type']) && $this->request->data['Message']['conversaction_type'] == 'private'){
					$msg_label = __l('Note');
				}
			
				echo $msg_label;
			?>
			</label>
			<?php echo $this->Form->input('message', array('type' => 'textarea', 'label' => false)); ?>
		</div>
		<?php
        if ($propertyOreder['Property']['user_id'] == $this->Auth->user('id') && $propertyOreder['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending && !empty($propertyOreder['PropertyUser']['is_negotiation_requested']) && (empty($this->request->data['Message']['conversaction_type']) || !empty($this->request->data['Message']['conversaction_type']) && $this->request->data['Message']['conversaction_type'] != 'private')): ?>
  		<div class="input">
			<label>
			<?php
				echo __l('Discount (in percentage)');
			?>
			</label>
			<?php echo $this->Form->input('amount', array('type' => 'text', 'label' => false, 'class' => 'js-negotiate-discount','info'=>__l('Maximum allowed discount is ').configure::read('site.maximum_negotiation_allowed_discount').__l('%'))); ?>
 	</div>
		<div class="input clearfix">
		   <span class="grid_5 omega message-title  alpha">
			<?php
				echo __l('Your Gross Amount');
			?>
		</span>
			<div class="grid_10 omega alpha">
		      <?php echo Configure::read('site.currency'); ?>
			<span class="js-gross-host-amount message-title {price:'<?php echo ($this->Html->siteWithCurrencyFormat($propertyOreder['PropertyUser']['price']+$propertyOreder['PropertyUser']['negotiate_amount'],false)); ?>', gross:'<?php echo $this->Html->siteWithCurrencyFormat($propertyOreder['PropertyUser']['price'],false); ?>', service_amount:'<?php echo $this->Html->siteWithCurrencyFormat($propertyOreder['PropertyUser']['host_service_amount'],false); ?>'}">
			<?php echo $this->Html->siteWithCurrencyFormat($propertyOreder['PropertyUser']['price']-$propertyOreder['PropertyUser']['host_service_amount'],false); ?></span>
        </div>
		</div>
		<?php
	    endif;
		?>
		</div>
		<div class="padd-bg-bl">
			<div class="padd-bg-br">
				<div class="padd-bg-bmid"></div>
			</div>
		</div>
		<div class="compose-block clearfix">
			<div class="submit-block clearfix" >
				<?php 
				$btn = __l('Send');
				if(isset($this->request->data['Message']['conversaction_type']) && $this->request->data['Message']['conversaction_type'] == 'private'){
					$btn = __l('Update');
				}
				echo $this->Form->submit($btn); ?>
			</div>
		</div>
	
<?php echo $this->Form->end(); ?>
</div>