<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyOrders index js-response  js-responses">

<h2><?php echo __l('Calendar');?></h2>
	<div class="inbox-option select-block clearfix">
		<span class="select"><?php echo __l('Select:'); ?></span>
		<?php
			$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
			$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
		?>
		<span class="round-5 all <?php echo $active_filter; ?>">
		<?php
			echo  $this->Html->link(__l('All') . ': ' . (!empty($all_count) ? $all_count : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'myworks', 'status' => 'all', 'admin' => false), array('class' => $stat_class, 'title' => __l('All') . ': ' . (!empty($all_count) ? $all_count : '0')));
		?>
		</span>
		<?php
			if (!empty($moreActions)):
				foreach($moreActions as $key => $value):
					$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
					$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active-filter' : null;
			?>
    <span class="round-5 <?php echo $class_name .' '. $stat_class;?>">
			<?php
				echo $this->Html->link($key, array('controller' => 'property_users', 'action' => 'index','type'=>'myworks','status' => $value,'admin' => false), array( 'title' => $key));
			?>
				</span>
			<?php
				endforeach;
			endif;
		?>

	</div>
<?php  if(isset($this->request->params['named']['status']) && $this->request->params['named']['status']=='negotiation_requested'):?>
<div class="page-information"><?php echo __l('You can give whatever discount, but admin commission will be calculated on your property cost!'); ?></div>
<?php endif; ?>
<div><?php echo $this->element('paging_counter');?></div>
<div class="page-information"><?php echo __l('Order confirmation request will be expired automatically in ').(Configure::read('property.auto_expire')*24).__l(' hrs, please hurry to confirm.'); ?></div>
<table class="revenues-list list">
	<tr>
		<th rowspan="2"><?php echo __l('Action'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Check in Date'),'checkin'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Check out Date'),'checkout'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Property'),'Property.title'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Traveler'),'User.username'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Trip Id'),'id'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Guests'),'guests'); ?></th>
		<!-- @todo "Guest details" -->
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Gross') . ' ('. Configure::read('site.currency') . ')', 'price'); ?></th>
		<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
			<th colspan="2"><?php echo $this->Paginator->sort(__l('Booking code')); ?></th>
		<?php endif; ?>
		<?php if(empty($this->request->params['named']['status'])): ?>
			<th rowspan="2"><?php echo $this->Paginator->sort(__l('Current Status'),'PropertyUserStatus.name'); ?></th>
		<?php endif; ?>	
		<th rowspan="2"><?php echo __l('No of Days');?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Booked Date'),'created');?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Private Note'),'host_private_note'); ?></th>
	</tr>
	<tr>		
	<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
		<th><?php echo $this->Paginator->sort(__l('Top Code'),'top_code'); ?></th>
		<th><?php echo $this->Paginator->sort(__l('Bottom Code'),'bottum_code'); ?></th>
	<?php endif; ?>
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
		<td class="action-block">
			<?php
				if(empty($propertyUser['PropertyUser']['is_under_dispute'])){
					if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance) {
						echo $this->Html->link(__l('Confirm'), array('controller' => 'property_users', 'action' => 'update_order', $propertyUser['PropertyUser']['id'],  'accept', 'admin' => false, '?r=' . $this->request->url), array('class' => 'confirm js-delete', 'title' => __l('Confirm')));
						echo $this->Html->link(__l('Reject'), array('controller' => 'property_users', 'action' => 'update_order', $propertyUser['PropertyUser']['id'],  'reject', 'admin' => false, '?r=' . $this->request->url), array('class' => 'cancel js-delete', 'title' => __l('Reject')));
					}
					if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_host_checkin']))) {
						if ((($propertyUser['Property']['checkin'] == '00:00:00') || ($propertyUser['Property']['checkin'] <= date('H:i:s'))) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)) {
							echo $this->Html->link(__l('Check in'), array('controller' => 'messages', 'action' => 'activities','order_id' => $propertyUser['PropertyUser']['id'].'#Checkin'), array('class' => 'checkin', 'id' => 'Checkin', 'title' => __l('Check in')));
						}
					} 
					if(($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_host_checkout'])){
						if(($propertyUser['Property']['checkout'] == '00:00:00') || ($propertyUser['Property']['checkout'] <= date('H:s:i'))){
							echo $this->Html->link(__l('Check out'), array('controller' => 'messages', 'action' => 'activities','order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id' => 'Checkout', 'title' => __l('Check out')));
						}
					}
					if ($this->Auth->user('id') == $propertyUser['PropertyUser']['owner_user_id'] && ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Completed) && empty($propertyUser['PropertyUser']['is_host_reviewed'])) {
						echo $this->Html->link(__l('Review'), array('controller'=>'property_user_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review')));
					}
				} else {
					echo __l('Under dispute. Continued only after dispute gets closed.');
				}
				echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' => 'view-activities'));
				$note_url = Router::url(array(
				'controller' => 'messages',
				'action' => 'activities',
				'order_id' => $propertyUser['PropertyUser']['id'],
			) , true);
			echo $this->Html->link(__l('Private note'), $note_url.'#Private_Note', array('class' =>'add-note', 'title' => __l('Private note')));
			if (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'negotiation') {
				echo $this->Html->link(__l('Respond'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'], 'admin' => false), array('class' => 'respond', 'title' => __l('Respond')));
			}
			?>
		</td>
		<td><?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkin']);?></td>
		<td><?php echo $this->Html->cDate($propertyUser['PropertyUser']['checkout']);?></td>
		<td>
			<?php echo $this->Html->link($this->Html->cText($propertyUser['Property']['title']), array('controller'=> 'properties', 'action' => 'view', $propertyUser['Property']['slug']), array('title' => $this->Html->cText($propertyUser['Property']['title'], false), 'escape' => false));?>

			<?php
				if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all'):
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
					<span class="round-3 <?php echo $class; ?>">
					<?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name'],false); ?>
					</span>
					<?php if (!empty($propertyUser['PropertyUser']['is_negotiation_requested'])): ?>
						<span class="round-3 negotiationrequested"><?php echo __l('Negotiation'); ?></span>
					<?php endif; ?>
			<?php
				endif;
			?>
		</td>
		<td><?php echo $this->Html->link($this->Html->cText($propertyUser['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['User']['username'],false),'escape' => false)); ?>
		</td>
		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['id']);?></td>
		
		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['guests']);?></td>
		<td><?php 
		    $negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];			
			$traveler_gross = $propertyUser['PropertyUser']['price'] - $propertyUser['PropertyUser']['host_service_amount'];
			
			echo $this->Html->cCurrency($traveler_gross);
		    if(!empty($propertyUser['PropertyUser']['is_negotiated'])):
				?>
					<div class="select-block table-select-block">
                <span class="negotiationrequested"><?php echo __l('Negotiated');?>
                </span>
                </div>

                <?php
				
				echo '(-'.$this->Html->siteCurrencyFormat($negotiate_discount).')';
			endif;
		?></td>
		<?php if(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'confirmed'): ?>
			<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['top_code']);?></td>
			<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['bottum_code']);?></td>
		<?php endif; ?>
		<?php if(empty($this->request->params['named']['status'])): ?>
		<td><?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name']);?></td>
		<?php endif; ?>
		<td><?php 
		$days = (strtotime($propertyUser['PropertyUser']['checkout']) -strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24) + 1;
		if($days == 0) {
			$days = 1;
		}
		echo $this->Html->cInt($days); 
		?></td>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['created']);?></td>
		<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['host_private_note']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
<tr>
	<td colspan="14"><p class="notice"><?php echo __l('No bookings available');?></p></td>
</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($propertyUsers)) {
    echo $this->element('paging_links');
}
?>
<div class="my-property clearfix">
<div class="page-information js-responses-update">
<?php echo __l('In the calendar, you can override your properties prices and also confirm bookings.');?>
<?php echo '<br/>' . __l('If you want to view property wise calendar, visit') . ' ' . $this->Html->link(__l('My Properties'), array('controller' => 'properties', 'action' => 'index', 'type' => 'myproperties'), array('title' => __l('My Properties')));?>
</div>
<div class="my-property-inner-block clearfix">
    <div class="grid_8 alpha omega">
         <?php   echo $this->element('properties-index_lst_my_properties', array('property_id' => isset($this->request->params['named']['property_id']) ? $this->request->params['named']['property_id'] : '')); ?>
		 <div class="clearfix">&nbsp;</div>
        <div class="clearfix">
            <div class="properties-tl">
    		  <div class="properties-tr">
    			<div class="properties-tm"> </div>
    		  </div>
    		</div>
            <div class="properties-middle-block clearfix">
                <h3 class="properties-title"><?php echo __l('Legends');?></h3>
				<div class="clearfix  legends-block">
                <span class="available round-3"><?php echo __l('Available');?></span>
                <span class="notavailable round-3"><?php echo __l('Not Available');?></span>
                <span class="bookingrequested round-3"><?php echo __l('Booking Requested');?></span>
                <span class="bookingconfirmed round-3"><?php echo __l('Booking Confirmed');?></span>
                <span class="negotiationrequested round-3"><?php echo __l('Negotiation Requested');?></span>
				</div>
            </div>

            <div class="properties-bl">
    		  <div class="properties-br">
    			<div class="properties-bm"> </div>
    		  </div>
    		</div>
        </div>
    </div>
    <div class="grid_15 omega">
    <?php   echo $this->element('properties-calendar', array('property_id' => isset($this->request->params['named']['property_id']) ? $this->request->params['named']['property_id'] : '', 'config' => 'sec')); ?>
    </div>
    </div>
</div>
</div>