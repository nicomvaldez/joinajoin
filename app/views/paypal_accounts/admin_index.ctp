<?php /* SVN: $Id: $ */ ?>
<div class="paypalAccounts index">
<div class="page-information clearfix">
<?php echo __l('Note: These accounts are created from ').$this->Html->link(__l('this page'), array('controller' => 'payments', 'action' => 'create_paypal_account', 'admin' => false), array('target' => '_blank')); ?>
</div>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>        
        <th><?php echo $this->Paginator->sort(__l('Created On'),'created');?></th>        
        <th><?php echo $this->Paginator->sort(__l('User'),'User.username');?></th>
        <th><?php echo $this->Paginator->sort(__l('Payment Types'), 'payment_types');?></th>
        <th><?php echo $this->Paginator->sort(__l('First Name'), 'first_name');?></th>
        <th><?php echo $this->Paginator->sort(__l('Last Name'), 'last_name');?></th>
		<th><?php echo $this->Paginator->sort(__l('Email'), 'email');?></th>
        <th><?php echo $this->Paginator->sort(__l('DOB'), 'dob');?></th>
        <th><?php echo $this->Paginator->sort(__l('Address1'), 'address1');?></th>
        <th><?php echo $this->Paginator->sort(__l('Address2'), 'address2');?></th>
        <th><?php echo $this->Paginator->sort(__l('City'), 'city');?></th>
        <th><?php echo $this->Paginator->sort(__l('State'), 'state');?></th>
        <th><?php echo $this->Paginator->sort(__l('Country'), 'PaypalCountry.name');?></th>
        <th><?php echo $this->Paginator->sort(__l('Zip'), 'zip');?></th>
        <th><?php echo $this->Paginator->sort(__l('Citizenship Country'),'PaypalCitizenshipCountry.name');?></th>
        <th><?php echo $this->Paginator->sort(__l('Phone'), 'phone');?></th>
		<th><?php echo $this->Paginator->sort(__l('Create Account Key'), 'create_account_key');?></th>
    </tr>
<?php
if (!empty($paypalAccounts)):

$i = 0;
foreach ($paypalAccounts as $paypalAccount):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>			
		<td><?php echo $this->Html->cDateTimeHighlight($paypalAccount['PaypalAccount']['created']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($paypalAccount['User']['username']), array('controller'=> 'users', 'action'=>'view', $paypalAccount['User']['username'] , 'admin' => false), array('escape' => false));?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['payment_types']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['first_name']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['last_name']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['email']);?></td>
		<td><?php echo $this->Html->cDate($paypalAccount['PaypalAccount']['dob']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['address1']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['address2']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['city']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['state']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalCountry']['name']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['zip']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalCitizenshipCountry']['name']);?></td>
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['phone']);?></td>		
		<td><?php echo $this->Html->cText($paypalAccount['PaypalAccount']['create_account_key']);?></td>	
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="25" class="notice"><?php echo __l('No Paypal Accounts available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($paypalAccounts)) {
    echo $this->element('paging_links');
}
?>
</div>
