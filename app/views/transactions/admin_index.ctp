<?php /* SVN: $Id: admin_index.ctp 2077 2010-04-20 10:42:36Z josephine_065at09 $ */ ?>
<?php $credit = 1;
$debit = 1;
$debit_total_amt = $credit_total_amt = $gateway_total_fee = 0;
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes :: AddedToWallet) && !empty($this->request->params['named']['stat'])) {
    $debit = 0;
}
if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == ConstTransactionTypes::ReferralAmountPaid || $this->request->params['named']['type'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $this->request->params['named']['type'] == ConstTransactionTypes::PaidDealAmountToCompany) && !empty($this->request->params['named']['stat'])) {
    $credit = 0;
	
}?>

<?php if(empty($this->request->params['isAjax'])): ?>
 	<div class="clearfix">
		<?php echo $this->element('payment-site_payment_balance', array('config' => 'sec'));?>
	</div>
	<?php echo $this->Form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix')); ?>
	 <?php
		echo $this->Form->autocomplete('User.username', array('label' => __l('User'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
		echo $this->Form->input('PropertyUser.Id', array('label' => __l('Booking#'),'info' => __l('Booking has high priority than')));
		echo $this->Form->autocomplete('Property.title', array('label' => __l('Property'), 'acFieldKey' => 'Property.id', 'acFields' => array('Property.title'), 'acSearchFieldNames' => array('Property.title'), 'maxlength' => '255'));
	 ?>
	 <div class="clearfix date-time-block">
		<div class="input date-time">
			<div class="js-datetime">
				<?php echo $this->Form->input('from_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
			</div>
		</div>
		<div class="input date-time today-date-block">
			<div class="js-datetime">
				<?php echo $this->Form->input('to_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'))); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->submit(__l('Filter')); ?>
   
    <?php echo $this->Form->end(); ?>
<?php endif;?>
<div class="transactions index js-response js-responses">
	<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>
	<div class="add-block grid_right">
	<?php if(!empty($transactions)) {?>
	<?php echo $this->Html->link(__l('CSV'), array('controller' => 'transactions', 'action' => 'export_filtered', 'csv:all', 'ext' => 'csv',$export_hash), array('title' => __l('Export This Report In CSV'), 'class' => 'export', 'escape' => false));
	?>
	<?php } ?>
	</div>
	</div>
	
	<div class="overflow-block">
    <table class="list">
        <tr>
            <th class="dc"><?php echo $this->Paginator->sort(__l('Date'), 'Transaction.created');?></th>
            <th class="dl"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></th>
            <th class="dl"><?php echo $this->Paginator->sort(__l('Description'),'TransactionType.name');?></th>
            <?php if(!empty($credit)){ ?>
                <th class="dr"><?php echo $this->Paginator->sort(__l('Credit'), 'Transaction.amount') . ' (' . Configure::read('site.currency') . ')';?></th>
            <?php } ?>
            <?php if(!empty($debit)){?>
                <th class="dr"><?php echo $this->Paginator->sort(__l('Debit'), 'Transaction.amount') . ' (' . Configure::read('site.currency') . ')';?></th>
            <?php } ?>
        </tr>
    <?php
    if (!empty($transactions)):
    
    $i = 0;
    foreach ($transactions as $transaction):
        $class = null;
        if ($i++ % 2 == 0) {
            $class = ' class="altrow"';
        }
    ?>
        <tr<?php echo $class;?>>
                <td class="dc"><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
                <td class="dl">
                <?php 
					$current_user_details = array(
						'username' => $transaction['User']['username'],
						'user_type_id' => $transaction['User']['user_type_id'],
						'id' => $transaction['User']['id'],
						'fb_user_id' => $transaction['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $transaction['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'micro_thumb');
					echo $this->Html->getUserLink($current_user_details);
				?>
				</td>
                <td class="dl">
                    <?php
                        $class = $transaction['Transaction']['class'];
               			echo $this->Html->transactionDescription($transaction);
                    ?>
                </td>
                <?php if(!empty($credit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
								$credit_total_amt = $credit_total_amt + $transaction['Transaction']['amount']; 
                            else:
                                echo '--';
                            endif;
                         ?>
                    </td>
                <?php } ?>
                <?php if(!empty($debit)) {?>
                    <td class="dr">
                        <?php
                            if($transaction['TransactionType']['is_credit']):
                                echo '--';
                            else:
							    $debit_total_amt = $debit_total_amt + $transaction['Transaction']['amount'];
                                echo $this->Html->cCurrency($transaction['Transaction']['amount']);
                            endif;
                         ?>
                    </td>
                <?php } ?>
            </tr>
    <?php
        endforeach;
	?>
	<tr class="total-block">
		<td colspan="3" class="dr"><?php echo __l('Total');?></td>
		 <?php if(!empty($credit)) {?>
		<td class="dr"><?php echo $this->Html->siteCurrencyFormat($credit_total_amt);?></td>
		 <?php } if(!empty($debit)) {?>
		<td class="dr"><?php echo $this->Html->siteCurrencyFormat($debit_total_amt);?></td>
		<?php } ?>
	</tr>
	<?php
    else:
    ?>
        <tr>
            <td colspan="11" class="notice"><?php echo __l('No Transactions available');?></td>
        </tr>
    <?php
    endif;
    ?>
    </table>
    </div>
    <?php
    if (!empty($transactions)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
</div>