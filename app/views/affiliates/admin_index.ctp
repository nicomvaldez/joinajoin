<?php /* SVN: $Id: $ */ ?>
<div class="affiliates index">

		<div class="record-info clearfix record-info1 select-block">
			<?php $class = ($this->request->params['controller'] == 'affiliate_requests') ? ' class="active"' : null; ?>
				<span class="waitingforyourreview round-3" <?php echo $class;?>><?php echo $this->Html->link(__l('Affiliate  Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'),array('title' => __l('Affiliates  Requests'))); ?></span>
			<?php $class = ($this->request->params['controller'] == 'affiliate_cash_withdrawals') ? ' class="active"' : null; ?>
				<span class="waitingforyourreview round-3"<?php echo $class;?>><?php echo $this->Html->link(__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('title' => __l('Affiliate Cash Withdrawal Requests'))); ?></span>
				<span class="all round-3"><?php echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 14),array('title' => __l('Settings'))); ?></span>
                
		</div>
    

<?php echo $this->element('admin_affiliate_stat', array('config' => 'sec')); ?>
<h2><?php echo __l('Commission History');?></h2>
<div class="clearfix">
<div class="inbox-option select-block clearfix">
            <span class="select">Filter: </span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Pending) ? 'active-filter' : null; ?>
        	<span class="Travelerrejected  <?php echo $class;?> "><?php echo $this->Html->link(__l('Pending'), array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Pending), array('class' => $class, 'title' => __l('Pending')));?></span>
 			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Canceled) ? 'active-filter' : null; ?>
			<span class="cancelled <?php echo $class;?> "><?php echo $this->Html->link(__l('Canceled'), array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Canceled), array('class' => $class, 'title' => __l('Canceled')));?></span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::PipeLine) ? 'active-filter' : null; ?>
			<span class="waitingforyourreview  <?php echo $class;?> "><?php echo $this->Html->link(__l('Pipeline'), array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::PipeLine), array('class' => $class, 'title' => __l('Pipeline')));?></span>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Completed) ? 'active-filter' : null; ?>
			<span class="completed  <?php echo $class;?> "><?php echo $this->Html->link(__l('Completed'), array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Completed), array('class' => $class, 'title' => __l('Completed')));?></span>
			  
</div>
</div>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Created'), 'created');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Affiliate User'), 'AffiliateUser.username');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Type'), 'AffiliateType.name');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Status'), 'AffiliateStatus.name');?></th>
        <th class="dr"><?php echo $this->Paginator->sort(__l('Commission').' ('.Configure::read('site.currency').')', 'commission_amount');?></th>
    </tr>
<?php
if (!empty($affiliates)):

$i = 0;
foreach ($affiliates as $affiliate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <td class="dc"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($affiliate['AffiliateUser']['username']), array('controller'=> 'users', 'action'=>'view', $affiliate['AffiliateUser']['username'], 'admin' => false), array('escape' => false));?></td>
		 
        <td class="dl"> <?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?> </td>
		
		<td class="dc">
           <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
           <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
                   <?php echo '['.__l('Since').': '.$this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']). ']';?>
           <?php endif; ?>
        </td>
		<td class="dr"><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice"><?php echo __l('No commission history available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($affiliates)) {
    echo $this->element('paging_links');
}
?>
</div>