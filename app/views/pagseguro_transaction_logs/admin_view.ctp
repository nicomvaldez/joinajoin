<?php /* SVN: $Id: $ */ ?>
<div class="pagseguroTransactionLogs view">
<h2><?php echo __l('Pagseguro Transaction Log');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($pagseguroTransactionLog['PagseguroTransactionLog']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Amount');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cCurrency($pagseguroTransactionLog['PagseguroTransactionLog']['amount']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Currency');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cCurrency($pagseguroTransactionLog['PagseguroTransactionLog']['currency']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Remark');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['remark']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Quantity');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($pagseguroTransactionLog['PagseguroTransactionLog']['quantity']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Ip');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['ip']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Serialized Post Array');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>> <?php $data= unserialize(base64_decode($pagseguroTransactionLog['PagseguroTransactionLog']['serialized_post_array']));?>
			<dl>
					<?php foreach($data as $key => $value){ ?>
					<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo $key ?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>> <?php  echo $this->Html->cText($value);?></dd>
					<?php  } ?>
			</dl>
		</dd>
	</dl>
</div>
