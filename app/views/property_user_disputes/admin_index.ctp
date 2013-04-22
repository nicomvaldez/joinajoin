<?php /* SVN: $Id: $ */ ?>
<div class="propertyUserDisputes index">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php echo $this->Form->create('PropertyUserDispute', array('type' => 'get', 'class' => 'normal search-form clearfix', 'action'=>'index')); ?>
		<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		<?php echo $this->Form->submit(__l('Search'));?>
<?php echo $this->Form->end(); ?>
</div>
</div>

	<div class="record-info clearfix select-block inbox-option">
	    <?php foreach($status_count as $status):?>
		<div>
		<?php 
			$class = ((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == $status['id']) || (empty($status['id']) && empty($this->request->params['named']['filter_id']))) ? 'active-filter' : null;
			$class_name = str_replace(' ', '', str_replace(' ', '', strtolower(trim($status['dispaly']))));
		?>
			<span class="arrivedconfirmed <?php echo $class .' '.$class_name ; ?>"><?php echo $this->Html->link($status['dispaly'] . ':' , array('controller'=>'property_user_disputes','action'=>'index','filter_id' => $status['id']), array('class' => $class, 'title' => $status['dispaly']));?>
			<?php echo $this->Html->cInt($status['count']); ?></span>
		</div>
		<?php endforeach; ?>
   </div>

<div class="overflow-block">
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Created'), 'created');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('User'), 'user_id');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Property'), 'property_id');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Booking #'), 'property_order_id');?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Booking Status'), 'property_user_status_id');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Property User Type'), 'is_traveler');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Dispute Type'), 'dispute_type_id');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Reason'), 'reason');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Dispute Status'), 'dispute_status_id');?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Resolved'), 'resolved_date');?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Favor user type'), 'is_favor_traveler');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Last Replied Date'), 'last_replied_date');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Dispute Conversation Count'), 'dispute_converstation_count');?></th>
    </tr>
<?php
if (!empty($propertyUserDisputes)):

$i = 0;
foreach ($propertyUserDisputes as $propertyUser):
	$class = null;
	if(in_array($propertyUser['PropertyUser']['property_user_status_id'], array(ConstPropertyUserStatus::Canceled, ConstPropertyUserStatus::Rejected, ConstPropertyUserStatus::Expired, ConstPropertyUserStatus::CanceledByAdmin))){
		$class = ' class="errorrow"';
	}elseif ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions dl" >
			<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        Action                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
									<li><?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'admin_order_view', 'order_id' => $propertyUser['PropertyUser']['id']), array('class' => 'view js-edit', 'title' => __l('View activities')));?></li>
            </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
        </td>
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyUser['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyUser['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title']), array('controller'=> 'properties', 'action'=>'view', $propertyUser['Property']['slug'], 'admin' => false), array('escape' => false));?></td>
		<td class="dc"><?php echo $this->Html->cInt($propertyUser['PropertyUser']['id']);?></td>
		<td class="dl"><?php echo !empty($propertyUser['PropertyUser']['PropertyUserStatus']['name']) ? $this->Html->cText($propertyUser['PropertyUser']['PropertyUserStatus']['name']) : '';?></td>
		<td class="dl"><?php echo !empty($propertyUser['PropertyUserDispute']['is_traveler']) ? __l('Traveler') : __l('Host');?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['DisputeType']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['PropertyUserDispute']['reason']);?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['DisputeStatus']['name']);?></td>
		<td class="dc"><?php echo !empty($propertyUser['PropertyUserDispute']['resolved_date']) ? $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['resolved_date']) : __l('Not yet');?></td>
		<td class="dl"><?php echo !empty($propertyUser['PropertyUserDispute']['is_favor_traveler']) ? __l('Traveler') : __l('Host');?></td>
		<td class="dc"><?php echo !empty($propertyUser['PropertyUserDispute']['last_replied_date']) ? $this->Html->cDateTimeHighlight($propertyUser['PropertyUserDispute']['last_replied_date']) : '-';?></td>
		<td class="dc"><?php echo $this->Html->cInt($propertyUser['PropertyUserDispute']['dispute_converstation_count']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17" class="notice"><?php echo __l('No bookings available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($propertyUserDisputes)) {
    echo $this->element('paging_links');
}
?>
</div>