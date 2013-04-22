<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyUsers index side1 grid_18 js-response js-responses">
    <h2><?php echo __l('Trips');?></h2>
	<div class="clearfix">
        <div class="jobs-inbox-option show-block grid_left clearfix">
        	<h5 class="show grid_left"><?php echo __l('Show').':'; ?></h5>
        	<ul class="filter-list grid_left">
        		<li class="list">
        			<?php echo $this->Html->link(__l('List'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'view' => 'list', 'admin' => false), array('title' => __l('List'), 'class' => 'list ','escape' => false));?>
        		</li>
        		<li class="grid">
        			<?php echo $this->Html->link(__l('Grid'), array('controller'=> 'property_users', 'action'=>'index', 'type'=>'mytours', 'status' => $this->request->params['named']['status'], 'admin' => false), array('title' => __l('Grid'), 'class' => 'grid status_selected','escape' => false));?>
        		</li>
           </ul>
        </div>
    </div>
	<div class="inbox-option select-block clearfix">
		<span class="select"><?php echo __l('Filter: '); ?></span>
		<?php 
			$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active' : null;
			$active_filter=(!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'all') ? 'active-filter' : null;
			$links[] ='<span class="all '.$active_filter.'">' . $this->Html->link(__l('All') . ': ' . (!empty($all_count) ? $all_count : '0'), array('controller' => 'property_users', 'action' => 'index','type'=>'mytours', 'status' => 'all', 'admin' => false), array('class' => $stat_class, 'title' => __l('All') . ': '. (!empty($all_count) ? $all_count : '0'))).'</span>';
			foreach($moreActions as $key => $value):
				$class_name = $propertyStatusClass[$value] ? $propertyStatusClass[$value] :"";
				$stat_class = (!empty($this->request->params['named']['status']) && $this->request->params['named']['status'] == $value) ? 'active-filter' : null;
				$links[] = '<span class="'. $class_name.' ' . $stat_class .'">' . $this->Html->link($key, array('controller' => 'property_users', 'action' => 'index','type'=>'mytours','status' => $value,'admin' => false), array('title' => $key)) . '</span>';
			endforeach;
			echo implode(' ',$links);
		?>
		
	</div>
<div><?php echo $this->element('paging_counter');?></div>
<table class="js-response-actions revenues-list list">
	<tr>
		<th><?php echo __l('Action'); ?></th>
		<th ><?php echo $this->Paginator->sort(__l('Check in Date'),'checkin'); ?></th>
		<th ><?php echo $this->Paginator->sort(__l('Check out Date'),'checkout'); ?></th>
		<th ><?php echo $this->Paginator->sort(__l('Property'),'Property.title'); ?></th>
		<th><?php echo $this->Paginator->sort(__l('Host'),'User.username'); ?></th>
		<th><?php echo $this->Paginator->sort(__l('Trip Id'),'id'); ?></th>
		<th><?php echo $this->Paginator->sort(__l('Address'),'Property.address'); ?></th>
		<th ><?php echo $this->Paginator->sort(__l('Guests'),'guests'); ?></th>
		<!-- @todo "Guest details" -->
		<th ><?php echo $this->Paginator->sort(__l('Gross') . ' ('. Configure::read('site.currency') . ')', 'price'); ?></th>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?> 
		<th ><?php echo $this->Paginator->sort(__l('Security Deposit') . ' ('. Configure::read('site.currency') . ')', 'security_deposit'); ?></th>
		<?php endif; ?>
		<?php if(empty($this->request->params['named']['status']) || $this->request->params['named']['status']=='negotiation_requested' || $this->request->params['named']['status']=='negotiation_rejected' || $this->request->params['named']['status']=='negotiation_confirmed'): ?>
		<th ><?php echo $this->Paginator->sort(__l('Current Status'),'PropertyUserStatus.name'); ?></th>
		<?php endif; ?>
		<th><?php echo $this->Paginator->sort(__l('Booked Date'),'created');?></th>
		<th><?php echo __l('No of Days');?></th>
		<th><?php echo $this->Paginator->sort(__l('Private Note'),'traveler_private_note'); ?></th>
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
					if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived) {
						echo $this->Html->link(__l('Print Ticket'), array('controller' => 'property_user', 'action' => 'view', $propertyUser['PropertyUser']['id'], 'type'=>'print', 'admin' => false), array('class' => 'print-ticket', 'target' => '_blank', 'title'=>__l('Print Ticket'), false, 'escape' => false));  
					}
					if($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed && $propertyUser['PropertyUser']['checkin'] > date('Y-m-d') || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforAcceptance ) {
							echo $this->Html->link(__l('Cancel'), array('controller' => 'payments', 'action' => 'order', $propertyUser['PropertyUser']['property_id'] , 'order_id'=>$propertyUser['PropertyUser']['id'], 'type' => __l('cancel'), 'admin' => false),array('title' => 'Cancel' ,'class'=>'js-delete delete'));  
					}
					if (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Confirmed) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkin']) && (empty($propertyUser['PropertyUser']['is_traveler_checkin']))) {
						if((($propertyUser['Property']['checkin'] == '00:00:00') || ($propertyUser['Property']['checkin'] <= date('H:i:s'))) || ($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived)){
							echo $this->Html->link(__l('Check in'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkin'), array('class' => 'checkin', 'id'=>'Checkin','title' => __l('Check in')));
						}
					} elseif (($propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::Arrived || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview || $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::PaymentCleared) && (date('Y-m-d') >= $propertyUser['PropertyUser']['checkout']) && empty($propertyUser['PropertyUser']['is_traveler_checkout'])) {
						if (($propertyUser['Property']['checkout'] == '00:00:00') || ($propertyUser['Property']['checkout'] <= date('H:i:s'))) {
							echo $this->Html->link(__l('Check out'), array('controller' => 'messages', 'action' => 'activities', 'order_id' => $propertyUser['PropertyUser']['id'].'#Checkout'), array('class' => 'checkout', 'id'=>'Checkout','title' => __l('Check out')));
						}
					}
					if($this->Auth->user('id') == $propertyUser['PropertyUser']['user_id'] && $propertyUser['PropertyUserStatus']['id'] == ConstPropertyUserStatus::WaitingforReview &&  !empty($propertyUser['PropertyUser']['is_traveler_checkout'])){
						echo $this->Html->link(__l('Review'), array('controller'=>'property_feedbacks','action'=>'add','property_order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'review', 'title' => __l('Review')));
					}
				} else {
					echo '<span class="dispute-open">' . __l('Under dispute. Continued only after dispute gets closed.') . '</span>';
				}
			?>
			<?php echo $this->Html->link(__l('View activities'), array('controller' => 'messages', 'action' => 'activities',  'order_id' => $propertyUser['PropertyUser']['id']), array('class' =>'view-activities'));
			$note_url = Router::url(array(
				'controller' => 'messages',
				'action' => 'activities',
				'order_id' => $propertyUser['PropertyUser']['id'],
			) , true);
			echo $this->Html->link(__l('Private note'), $note_url.'#Private_Note', array('class' => 'add-note',  'title' => __l('Private note')));
			if(($this->request->params['named']['status'] == 'negotiation' && !empty($propertyUser['PropertyUser']['is_negotiation_requested']))|| $this->request->params['named']['status'] == 'payment_pending'){				
					echo $this->Html->link(__l('Book it'), array('controller' => 'payments', 'action' => 'order', $propertyUser['PropertyUser']['property_id'], 'order_id:' . $propertyUser['PropertyUser']['id'], 'admin' => false), array('class' => 'book-it', 'title' => __l('Book it')));
			} ?>
		</td>
		
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['checkin']);?></td>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['checkout']);?></td>
		
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
			<?php
				endif;
			?>
			<?php
				$negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];
				$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];
				if($propertyUser['PropertyUser']['is_negotiation_requested'] == 1) {
			?>
					<span class="round-3 negotiationrequested "><?php echo __l('Negotiation'); ?></span>
					<span class="round-3 negotiate-amount">
						<?php																				
							$traveler_gross = $traveler_gross;	
							echo '(-'.$this->Html->siteCurrencyFormat($negotiate_discount).')';
						?>
					</span>
			<?php
				}
			?>
		</td>

		<td><?php echo !empty($propertyUser['Property']['User']['username']) ? $this->Html->link($this->Html->cText($propertyUser['Property']['User']['username'], false), array('controller' => 'users', 'action' => 'view', $propertyUser['Property']['User']['username'] ,'admin' => false), array('title'=>$this->Html->cText($propertyUser['Property']['User']['username'],false),'escape' => false)) : ''; ?></td>
		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['id']);?></td>
		<td>
			<?php if(!empty($propertyUser['Property']['Country']['iso2'])): ?>
									<span class="flags flag-<?php echo strtolower($propertyUser['Property']['Country']['iso2']); ?>" title ="<?php echo $propertyUser['Property']['Country']['name']; ?>"><?php echo $propertyUser['Property']['Country']['name']; ?></span>
							<?php endif; ?>
							
							<?php echo $this->Html->cText($propertyUser['Property']['address']);?>
		</td>

		<td><?php echo $this->Html->cInt($propertyUser['PropertyUser']['guests']);?></td>
		<td>
	
		<?php 
		     $negotiate_discount = $propertyUser['PropertyUser']['negotiate_amount'];			
			$traveler_gross = $propertyUser['PropertyUser']['price'] + $propertyUser['PropertyUser']['traveler_service_amount'];						
			echo $this->Html->cCurrency($traveler_gross);
		    if(!empty($propertyUser['PropertyUser']['is_negotiated'])):
				?>
				<div class="select-block table-select-block">
                      <span class="negotiationrequested"><?php echo __l('Negotiated');?></span>
               </div>
                <?php
				
				echo '(-'.$this->Html->cCurrency($negotiate_discount).')';
			endif;
		?>
		</td>
		<?php if(empty($this->request->params['named']['status'])): ?>
		<td><?php echo $this->Html->cText($propertyUser['PropertyUserStatus']['name']);?></td>
		<?php endif; ?>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
			<td><?php echo $this->Html->cCurrency($propertyUser['Property']['security_deposit']); ?></td>
		<?php endif; ?>
		<td><?php echo $this->Html->cDateTimeHighlight($propertyUser['PropertyUser']['created']);?></td>
		<td><?php 
		$days = ((strtotime($propertyUser['PropertyUser']['checkout']) -strtotime($propertyUser['PropertyUser']['checkin'])) /(60*60*24)) + 1;
		echo $this->Html->cInt($days); 
		?></td>
		<td><?php echo $this->Html->cText($propertyUser['PropertyUser']['traveler_private_note']);?></td>	
	</tr>
<?php
    endforeach;
else:
?>
<tr>
	<td colspan="15"><p class="notice"><?php echo __l('No trips available');?></p></td>
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
</div>