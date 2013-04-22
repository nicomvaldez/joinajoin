<?php /* SVN: $Id: $ */ ?>
<div class="propertyUsers index js-response">
<?php $url= array(
                'controller' => 'property_users',
                'action' => 'index',
                );?>
    <?php
		$all = '';
		foreach($propertyUserStatuses as $id => $propertyUserStatus):
        	$all += $propertyUserStatusesCount[$id];
    	endforeach;
	?>


<div class="round-5 project-chart-block clearfix">
	<ul class="project-chart clearfix">
		<li class="new-booking">
			<div class="payment-block-left">
				<div class="payment-block-right">
					<?php $url['filter_id'] = ConstPropertyUserStatus::PaymentPending;?>
					<ul>
						<li><span class="payment-pending"><?php echo $this->Html->link(sprintf("%s", __l('Payment Pending') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::PaymentPending]), $url, array('class' => 'all-property-user','title' => __l('Payment Pending')));?></span></li>
					</ul>
				</div>
			</div>
			<span class="new-booking"><span>New booking</span></span>
		</li>
		<li class="pending-approval">
			<div class="rejected-block">
				<ul>
					<?php $url['filter_id'] = ConstPropertyUserStatus::Rejected;?>
					<li><span class="rejected"><?php echo $this->Html->link(sprintf("%s", __l('Rejected') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Rejected]), $url, array('class' => 'all-property-user','title' => __l('Rejected')));?></span></li>
					<?php $url['filter_id'] = ConstPropertyUserStatus::Canceled;?>
					<li class="canceled"><span class="canceled"><?php echo $this->Html->link(sprintf("%s", __l('Canceled') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Canceled]), $url, array('class' => 'all-property-user','title' => __l('Canceled')));?></span></li>
				</ul>
			</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::WaitingforAcceptance;?>
			<span class="pending-approval"><?php echo $this->Html->link(sprintf("%s", __l('Pending Approval') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::WaitingforAcceptance]), $url, array('class' => 'all-property-user','title' => __l('Pending Approval')));?></span>
			<div class="expired-block">
				<ul>
					<?php $url['filter_id'] = ConstPropertyUserStatus::Expired;?>
					<li><span class="expired"><?php echo $this->Html->link(sprintf("%s", __l('Expired') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Expired]), $url, array('class' => 'all-property-user','title' => __l('Expired')));?></span></li>
					<?php $url['filter_id'] = ConstPropertyUserStatus::CanceledByAdmin;?>
					<li class="canceled-by-admin"><span class="canceled-by-admin"><?php echo $this->Html->link(sprintf("%s", __l('Canceled By Admin') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::CanceledByAdmin]), $url, array('class' => 'all-property-user','title' => __l('Canceled By Admin')));?></span></li>
				</ul>
			</div>
		</li>
		<li class="confirmed">
			<div class="confirmed-top-block">&nbsp;</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::Confirmed;?>
			<span class="confirmed"><?php echo $this->Html->link(sprintf("%s", __l('Confirmed') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Confirmed]), $url, array('class' => 'all-property-user','title' => __l('Confirmed')));?></span>
			<div class="confirmed-bottom-block">&nbsp;</div>
		</li>
		<?php $url['filter_id'] = ConstPropertyUserStatus::Arrived;?>
		<li class="arrived"><span class="arrived"><?php echo $this->Html->link(sprintf("%s", __l('Arrived') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Arrived]), $url, array('class' => 'all-property-user','title' => __l('Arrived')));?></span></li>
		<li class="cleared">
			<div class="traveler-review-block">
				<ul>
					<?php $url['filter_id'] = ConstPropertyUserStatus::WaitingforReview;?>
					<li><div class="traveler-arrow">&nbsp;</div><span class="traveler-review"><?php echo $this->Html->link(sprintf("%s", __l('Traveler review') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::WaitingforReview]), $url, array('class' => 'all-property-user','title' => __l('Traveler review')));?></span></li>
				</ul>
			</div>
			<?php $url['filter_id'] = ConstPropertyUserStatus::PaymentCleared;?>
			<span class="cleared"><?php echo $this->Html->link(sprintf("%s", __l('Cleared') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::PaymentCleared]), $url, array('class' => 'all-property-user','title' => __l('Cleared')));?></span>
			<div class="host-review-block">
				<ul>
					<?php $url['filter_id'] = ConstPropertyUserStatus::HostReviewed;?>
					<li><span class="host-review"><?php echo $this->Html->link(sprintf("%s", __l('Host review') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::HostReviewed]), $url, array('class' => 'all-property-user','title' => __l('Host review')));?></span></li>
				</ul>
			</div>
		</li>
		<?php $url['filter_id'] = ConstPropertyUserStatus::Completed;?>
		<li class="completed"><span class="completed"><?php echo $this->Html->link(sprintf("%s", __l('Completed') . ': ' . $propertyUserStatusesCount[ConstPropertyUserStatus::Completed]), $url, array('class' => 'all-property-user','title' => __l('Completed')));?></span></li>
	</ul>
</div>
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
	<?php echo $this->Form->create('PropertyUser', array('class' => 'normal search-form clearfix', 'action' => 'index')); ?>
		<?php echo $this->Form->input('filter_id', array('empty' => __l('Please Select'))); ?>
		<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		<?php echo $this->Form->submit(__l('Search'));?>
	<?php echo $this->Form->end(); ?>
<?php endif; ?>
</div>
</div>
<?php   
	echo $this->Form->create('PropertyUser' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<div class="overflow-block">
<table class="list">
    <tr>
	<?php if(empty($this->request->params['named']['simple_view'])) : ?>
        <th class="actions"><?php echo __l('Actions');?></th>
		<?php endif; ?>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Trip Id #'), 'id');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Property'), 'Property.title');?></div></th>
        <th class="dr"><div class="js-pagination"><?php echo __l('Amount') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="dr"><div class="js-pagination"><?php echo __l('Site Commission Amount') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="dr"><div class="js-pagination"><?php echo __l('Paid Amount to host') . ' (' . Configure::read('site.currency') . ')';?></div></th>
        <th class="dr"><div class="js-pagination"><?php echo __l('Traveler Service Fee') . ' (' . Configure::read('site.currency') . ')';?></div></th>
		<th class="dl"><div class="js-pagination"><?php echo __l('Original Search Address');?></div></th>

    </tr>
<?php
if (!empty($propertyUsers)):

$i = 0;
foreach ($propertyUsers as $propertyUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
		<td class="actions">
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
			<?php if($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance || $propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed || $propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived):?>
				<li><?php echo $this->Html->link(__l('Cancel and refund'), array('action' => 'delete', $propertyUser['PropertyUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Cancel and refund')));?></li>
			<?php endif;?>
			<?php if ($propertyUser['PropertyUser']['payment_gateway_id'] == ConstPaymentGateways::PayPal && $propertyUser['PropertyUser']['property_user_status_id'] != ConstPropertyUserStatus::PaymentPending): ?>
			<li><?php echo $this->Html->link(__l('View Transactions'), array('controller' => 'adaptive_transaction_logs', 'action' => 'index', 'property_users', $propertyUser['PropertyUser']['id']), array('class' => 'view', 'title' => __l('View Transactions')));?></li>
			<?php endif; ?>
			<li>
			<?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities', 'type' => 'admin_order_view', 'order_id' => $propertyUser['PropertyUser']['id']), array('class' => 'view', 'title' => __l('View activities')));?>
			</li>
			 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
		</td>
		<?php endif; ?>
		<td class="dc"><?php echo $this->Html->cDateTime($propertyUser['PropertyUser']['created']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($propertyUser['PropertyUser']['id']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyUser['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyUser['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dl propertys-title-info">
			<?php
				$class = '';
				if ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
					$class = 'waitingforacceptance';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Confirmed) {
					$class = 'confirmed';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Rejected) {
					$class = 'rejected';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Canceled) {
					$class = 'cancelled';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::CanceledByAdmin) {
					$class = 'cancelled';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Arrived) {
					$class = 'arrived';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::WaitingforReview) {
					$class = 'waitingforyourreview';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Completed) {
					$class = 'completed';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::Expired) {
					$class = 'expired';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentPending) {
					$class = 'paymentpending';
				} elseif ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared) {
					$class = 'confirmed';
				}
			?>
			<span class="grid_left property-status-info <?php echo $class; ?>" title="<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'], false);?>"></span>
			<?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title']), array('controller'=> 'properties', 'action'=>'view', $propertyUser['Property']['slug'], 'admin' => false), array('escape' => false));?>
		</td>
		<td class="dr"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['price']);?></td>
		<td class="dr"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['host_service_amount']);?></td>
		<td class="dr"><?php echo ($propertyUser['PropertyUser']['property_user_status_id'] == ConstPropertyUserStatus::PaymentCleared)?$this->Html->cCurrency($propertyUser['PropertyUser']['price'] - $propertyUser['PropertyUser']['host_service_amount']):'-';?></td>
		<td class="dr"><?php echo $this->Html->cCurrency($propertyUser['PropertyUser']['traveler_service_amount']);?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyUser['PropertyUser']['original_search_address']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="13" class="notice"><?php echo __l('No Property Users available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($propertyUsers)):
?>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>