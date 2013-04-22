<?php /* SVN: $Id: $ */ ?>
<div class="paymentGatewaySettings index">
<h2><?php echo __l('Payment Gateway Settings');?></h2>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort(__l('Payment Gateway'), 'payment_gateway_id');?></th>
        <th><?php echo $this->Paginator->sort(__l('Key'), 'key');?></th>
        <th><?php echo $this->Paginator->sort(__l('Value'), 'value');?></th>
        <th><?php echo $this->Paginator->sort(__l('Description'), 'description');?></th>
    </tr>
<?php
if (!empty($paymentGatewaySettings)):

$i = 0;
foreach ($paymentGatewaySettings as $paymentGatewaySetting):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $paymentGatewaySetting['PaymentGatewaySetting']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $paymentGatewaySetting['PaymentGatewaySetting']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></td>
		<td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGateway']['name']);?></td>
		<td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['key']);?></td>
		<td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['value']);?></td>
		<td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['description']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5" class="notice"><?php echo __l('No Payment Gateway Settings available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($paymentGatewaySettings)) {
    echo $this->element('paging_links');
}
?>
</div>
