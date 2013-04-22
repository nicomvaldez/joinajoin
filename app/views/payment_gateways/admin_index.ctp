<?php /* SVN: $Id: $ */ ?>
<div class="home-page-block">
<div><?php echo $this->element('paging_counter');?></div>
<div class="overflow-block">
<table class="list">
    <tr>
		<th><?php echo __l('Action');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Name'), 'name');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Description'), 'description');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Test Mode'), 'is_test_mode'); ?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Active'), 'is_active');?></th>
		<th class="dc"><?php echo $this->Paginator->sort(__l('Mass Pay Enabled'), 'is_mass_pay_enabled');?></th>
    </tr>
<?php
if (!empty($paymentGateways)):

$i = 0;
foreach ($paymentGateways as $paymentGateway):
	$class = null;
	$status_class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
	endif;
?>
	<tr<?php echo $class;?>>
		<td class="actions">
				<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                      <?php echo __l('Actions'); ?>                                   </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
								<li>
			<span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
			</li></ul>
		</div>
		<div class="action-bottom-block"></div>
		</div></div>
    	</td>
		<td class="dl"><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['display_name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($paymentGateway['PaymentGateway']['description']);?></td>
		<td class="dc"><?php if($paymentGateway['PaymentGateway']['id'] == 2){ echo '-';}else{
                     echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_test_mode']); }?></td>
		<td class="dc"><?php echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_active']);?></td>
		<td class="dc">
			<?php 
				if($paymentGateway['PaymentGateway']['id'] != ConstPaymentGateways::Wallet):
					echo $this->Html->cBool($paymentGateway['PaymentGateway']['is_mass_pay_enabled']);
				else:
					echo '-';
				endif;
			?>
		</td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="9" class="notice"><?php echo __l('No Payment Gateways available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php if (!empty($paymentGateways)): ?>
	<div><?php echo $this->element('paging_links'); ?></div>
<?php endif; ?>
</div>