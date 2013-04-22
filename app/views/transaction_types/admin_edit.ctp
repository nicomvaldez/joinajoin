<?php /* SVN: $Id: $ */ ?>
<div class="transactionTypes form">
<h2><?php echo __l('Edit Transaction Type');?></h2>
<?php echo $this->Form->create('TransactionType', array('class' => 'normal'));?>
<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
<div class="padd-center clearfix">
	<fieldset>
	<?php
		echo $this->Form->input('id');?>
		<h3><?php echo $this->request->data['TransactionType']['name'];?></h3>
	<?php
		echo $this->Form->input('message',array('label'=>__l('Message'),'info' => $this->Html->cText($this->request->data['TransactionType']['transaction_variables'])));
	?>
	</fieldset>
	</div>
	<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Update'));?>
		<div class="cancel-block">
			<?php echo $this->Html->link(__l('Cancel') , array('action' => 'index'));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>

