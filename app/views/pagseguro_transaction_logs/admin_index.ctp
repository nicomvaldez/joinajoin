<?php /* SVN: $Id: $ */ ?>
<div class="pagseguroTransactionLogs index">
<h2><?php echo __l('Pagseguro Transaction Logs');?></h2>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>
       <th><?php echo $this->Paginator->sort(__l('Created'), 'created');?></th> 
        <th><?php echo $this->Paginator->sort(__l('Transaction ID'), 'transaction_id');?></th>
		<th><?php echo $this->Paginator->sort(__l('Transaction Date'), 'transaction_date');?></th>
		<th><?php echo $this->Paginator->sort(__l('Name'), 'name');?></th>
		<th><?php echo $this->Paginator->sort(__l('Email'), 'email');?></th>
		<th><?php echo $this->Paginator->sort(__l('Address'), 'address');?></th>
		<th><?php echo $this->Paginator->sort(__l('City'), 'city');?></th>
		<th><?php echo $this->Paginator->sort(__l('State'), 'state');?></th>
		<th><?php echo $this->Paginator->sort(__l('Zip'), 'zip');?></th>
		<th><?php echo $this->Paginator->sort(__l('Phone'), 'phone');?></th>
		<th><?php echo $this->Paginator->sort(__l('Payment Type'), 'payment_type');?></th>
		<th><?php echo $this->Paginator->sort(__l('Payment Status'), 'payment_status');?></th>
		<th><?php echo $this->Paginator->sort(__l('Number'), 'number');?></th>
		<th><?php echo $this->Paginator->sort(__l('Quarter'), 'quarter');?></th>
		<th><?php echo $this->Paginator->sort(__l('Amount'), 'amount');?></th>
		<th><?php echo $this->Paginator->sort(__l('Fee'), 'transaction_fee');?></th>
        <th><?php echo $this->Paginator->sort(__l('Currency'), 'currency');?></th>
        <th><?php echo $this->Paginator->sort(__l('IP'), 'ip');?></th>
    </tr>
<?php
if (!empty($pagseguroTransactionLogs)):

$i = 0;
foreach ($pagseguroTransactionLogs as $pagseguroTransactionLog):
//For display PagSeguro Payment gateway response
$pagseguro = unserialize(base64_decode($pagseguroTransactionLog['PagseguroTransactionLog']['serialized_post_array']));
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		
		
		<td>
		<div class="actions-block">
				<div class="actions round-5-left">
					<span><?php echo $this->Html->link(__l('View'), array('controller' => 'pagseguro_transaction_logs', 'action' => 'view', $pagseguroTransactionLog['PagseguroTransactionLog']['id']), array('class' => 'view', 'title' => __l('View')));?></span>
				</div>
			</div>
		<?php echo $this->Html->cDateTime($pagseguroTransactionLog['PagseguroTransactionLog']['created']);?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['transaction_id'])):
					echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['transaction_id']);
		else:
			echo $this->Html->cText($pagseguro['TransacaoID']);
		endif;
		?></td>
		<td><?php 
		if($pagseguroTransactionLog['PagseguroTransactionLog']['transaction_date'] != '0000-00-00 00:00:00'):
			echo $this->Html->cDateTime($pagseguroTransactionLog['PagseguroTransactionLog']['transaction_date']);
		else:
			echo $this->Html->cDateTime($pagseguro['created']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['name'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['name']);
		else:
			echo $this->Html->cText($pagseguro['name']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['email'])):	
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['email']);
		else:
			echo '-';
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['address'])):
		echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['address']);
		else:
		echo $this->Html->cText($pagseguro['address']);
		endif;
		?></td>
		<td><?php
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['city'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['city']);
		else:
			echo $this->Html->cText($pagseguro['city']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['state'])):
		echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['state']);
		else:
		echo $this->Html->cText($pagseguro['state']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['zip'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['zip']);
		else:
			echo $this->Html->cText($pagseguro['zip']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['phone'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['phone']);
		else:
			echo $this->Html->cText($pagseguro['CliTelefone']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['payment_type'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['payment_type']);
		else:
			echo $this->Html->cText($pagseguro['payment_type']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['payment_status'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['payment_status']);
		else:
			echo $this->Html->cText($pagseguro['payment_status']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['number'])):
			echo $this->Html->cInt($pagseguroTransactionLog['PagseguroTransactionLog']['number']);
		else:
			echo $this->Html->cInt($pagseguro['number']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['quarter'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['quarter']);
		else:
			echo $this->Html->cText($pagseguro['quarter']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['amount'])):
			echo $this->Html->cCurrency($pagseguroTransactionLog['PagseguroTransactionLog']['amount']);
		else:
			echo $this->Html->cCurrency($pagseguro['amount_needed']);
		endif;
		?></td>
		<td><?php echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['transaction_fee']);?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['currency'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['currency']);
		else:
			echo $this->Html->cText($pagseguro['currency_code']);
		endif;
		?></td>
		<td><?php 
		if(!empty($pagseguroTransactionLog['PagseguroTransactionLog']['ip'])):
			echo $this->Html->cText($pagseguroTransactionLog['PagseguroTransactionLog']['ip']);
		else:
			echo $this->Html->cText($pagseguro['ip']);
		endif;
		?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="19" class="notice"><?php echo __l('No Pagseguro Transaction Logs available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($pagseguroTransactionLogs)) {
    echo $this->element('paging_links');
}
?>
</div>