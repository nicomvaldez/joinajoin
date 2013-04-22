<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
<h2><?php echo __l('My Properties');?></h2>
<div class="properties-staus-block clearfix">
    <div class="grid_left grid_18">
        <ul class="filter-list-block clearfix">
              <?php $class=(empty($this->request->params['named']['status']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties')? 'active-filter':'';?>
                <li class="blue <?php echo $class; ?>" title="<?php echo __l('all');?>"><?php echo $this->Html->link( $this->Html->cInt($all_count, false). '<span>' . __l('All') . '</span>', array('controller'=>'properties','action'=>'index','type' => 'myproperties'), array('escape' => false))?></li>
             	<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'pending')?'active-filter':'';?>
                <li class="orange <?php echo $class; ?>" title="<?php echo __l('Payment Pending');?>"><?php echo $this->Html->link( $this->Html->cInt($pending_count, false) . '<span>'. __l('Payment Pending') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'pending'), array('escape' => false))?></li>
        		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'active')?'active-filter':'';?>
                <li class="green <?php echo $class; ?>" title="<?php echo __l('Enabled');?>"><?php echo $this->Html->link( $this->Html->cInt($active_count, false) . '<span>' . __l('Enabled') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'active'), array('escape' => false))?></li>
        		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'inactive')?'active-filter':'';?>
                <li class="gray <?php echo $class; ?>" title="<?php echo __l('Disabled');?>"><?php echo $this->Html->link( $this->Html->cInt($inactive_count, false) . '<span>' . __l('Disabled') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'inactive'), array('escape' => false))?></li>
        		<?php if (Configure::read('property.is_property_verification_enabled')): ?>
        			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'verified')?'active-filter':'';?>
        			<li class="yellow <?php echo $class; ?>" title="<?php echo __l('Verified');?>"><?php echo $this->Html->link( $this->Html->cInt($verified_count, false) . '<span>' . __l('Verified') . '</span>' , array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'verified'), array('escape' => false))?></li>
        			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_verification')?'active-filter':'';?>
        			<li class="red <?php echo $class; ?>" title="<?php echo __l('Waiting for verification');?>"><?php echo $this->Html->link( $this->Html->cInt($waiting_for_verification_count, false) . '<span>' . __l('Waiting for verification') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_verification'), array('escape' => false))?></li>
        		<?php endif; ?>
        	   <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_approval')?'active-filter':'';?>
               <li class="dark-yellow <?php echo $class; ?>" title="<?php echo __l('Waiting for approval');?>"><?php echo $this->Html->link( $this->Html->cInt($waiting_for_approval_count, false) . '<span>' . __l('Waiting for approval') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_approval'), array('escape' => false))?></li>
        	   <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'imported')?'active-filter':'';?>
               <li class="purple <?php echo $class; ?>" title="<?php echo __l('Imported from AirBnB');?>"><?php echo $this->Html->link( $this->Html->cInt($imported_from_airbnb_count, false) . '<span>' . __l('Imported from AirBnB') . '</span>', array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'imported'), array('escape' => false))?></li>
        </ul>
    </div>
    <div class="properties-staus-inner grid_right">
         <?php
            $day1= date("D j", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
            $day2=date("D j", mktime(0, 0, 0, date("m"),date("d")-2,date("Y")));
            $day3=date("D j", mktime(0, 0, 0, date("m"),date("d")-3,date("Y")));
            $axis1=ceil($chart_data['max_count']/3);
            $axis2=ceil($chart_data['max_count']/3)*2;
            $axis3=ceil($chart_data['max_count']/3)*3;
            	 
				 $image_url='http://chart.apis.google.com/chart?chf=a,s,000000FA|bg,s,67676700&amp;chxl=0:|0|'.$day3.'|'.$day2.'|'.$day1.'|1:|0|'.$axis1.'|'.$axis2.'|'.$axis3.'&amp;chxs=0,676767,11.5,0,lt,676767&amp;chxtc=0,4&amp;chxt=x,y&amp;chs=200x100&amp;cht=lxy&amp;chco=0066E4,FF0285&amp;chds=0,3,0,'.$axis3.',0,3,0,'.$axis3.'&amp;chd=t:1,2,3|'. $chart_data['PropertyView'][3]['count'].','.$chart_data['PropertyView'][2]['count'].','.$chart_data['PropertyView'][1]['count'].'|1,2,3|'.$chart_data['PropertyUser'][3]['count'].','.$chart_data['PropertyUser'][2]['count'].','.$chart_data['PropertyUser'][1]['count'].'&amp;chdl=Views|Bookings&amp;chdlp=b&amp;chls=2,4,1|1&amp;chma=5,5,5,25';
            echo $this->Html->image($image_url);
            ?>
    </div>
</div>
<?php echo $this->element('paging_counter');?>
<?php 
	echo $this->Form->create('Property' , array('class' => 'normal','action' => 'update'));  
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>

<?php
if (!empty($properties)):
?>
<table class="list properties-list no-bor js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
<?php
$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>

	<tr>
		<th class="properties-title properties-title-section" class="actions">
			<div class="clearfix properties-info-block">
				<?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
				<h3 class="dl"><?php echo $this->Html->link($this->Html->cText($property['Property']['title'],false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'] ,'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false)); ?></h3>
			</div>
			<div class="select-block table-select-block dl">
              	<?php if (empty($property['Property']['is_active'])): ?>
					<span class="disabled"> <?php echo __l('Disabled'); ?> </span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::Verified): ?>
    			     <span class="verified" title="<?php echo __l('Verified'); ?>">	<?php echo __l('Verified'); ?></span>
    			<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::WaitingForVerification): ?>
				    <span class="waitingforverfication" title="<?php	echo __l('Waiting for Verification'); ?>">	<?php	echo __l('Waiting for Verification'); ?></span>
				<?php endif; ?>
				<?php if($property['Property']['is_approved'] == 0): ?>
				    <span class="waitingforapproval" title="<?php	echo __l('Waiting for Approval'); ?>">	<?php	echo __l('Waiting for Approval'); ?></span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === ConstVerification::VerificationRejected): ?>
				    <span class="verificationrejected" title="<?php echo __l('Verification Rejected'); ?>">	<?php echo __l('Verification Rejected'); ?></span>
				<?php endif; ?>
				<?php if($property['Property']['is_paid'] == 0): ?>
				    <span class="paymentpending" title="<?php	echo __l('Payment Pending'); ?>">	<?php	echo __l('Payment Pending'); ?></span>
				<?php endif; ?>
				<?php if($property['Property']['is_featured'] == 1): ?>
					<span class="featured" title="<?php echo __l('Featured'); ?>">	<?php echo __l('Featured'); ?></span>
				<?php endif; ?>
            </div>
		</th>
		<?php if(!Configure::read('property.is_enable_security_deposit')): ?>
		<th colspan="3"><?php echo __l('Price'); ?></th>
		<?php else: ?>
		<th colspan="4"><?php echo __l('Price'); ?></th>
		<?php endif; ?>
		<th colspan="3"><?php echo __l('Booked'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Views'),'property_view_count');?></th>
		<th colspan="3"><?php echo __l('Revenue');?></th>
	</tr>
	<tr class="sub-title">
	<td rowspan="2" class="actions properties-title dl">
			<div class="clearfix properties-action-block">
				<div class="grid_4 thumb">
					<?php
						$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
						echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
					?>
				</div>
				<div class="grid_2 grid_left">
					<span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
					<span><?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Calendar'),'class' => 'calendar'));?></span>
					<?php if (!empty($property['Property']['is_active']) && !empty($property['Property']['is_paid'])) { ?>
						<span><?php echo $this->Html->link(__l('Post to Craigslist'), array('controller' => 'properties', 'action' => 'post_to_craigslist', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Post to Craigslist'), 'class' => 'craigslist'));?></span>
					<?php } ?>
					<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?>
						<span class="not-verified">	<?php echo $this->Html->link(__l('Get Verified'), array('controller' => 'payments', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Get Verified'),'class' => 'get-verify'));?></span>
					<?php } ?>
					<?php if (empty($property['Property']['is_paid'])): ?>
						<span class="listing-fee"><?php echo $this->Html->link(__l('Pay Listing Fee'), array('controller' => 'payments', 'action' => 'property_pay_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Pay Listing Fee'),'class' => 'listing-fee'));?></span>
					<?php endif; ?>
					<span>
						<?php 
							if (empty($property['Property']['is_active'])) {
								echo $this->Html->link(__l('Enable'), array('controller' => 'properties', 'action' => 'updateactions', $property['Property']['id'], 'active', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Enable'),'class' => 'enable'));
							} elseif(!empty($property['Property']['is_active'])) {
								echo $this->Html->link(__l('Disable'), array('controller' => 'properties', 'action' => 'updateactions', $property['Property']['id'], 'inactive', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Disable'),'class' => 'disable'));
							} 
						?>
					</span>
				</div>
			</div>
		</td>
		<th><?php echo $this->Paginator->sort(__l('Per Night').' ('.Configure::read('site.currency').')','price_per_night');?></th>
        <th><?php echo $this->Paginator->sort(__l('Per Week').' ('.Configure::read('site.currency').')','price_per_week');?></th>
        <th><?php echo $this->Paginator->sort(__l('Per Month').' ('.Configure::read('site.currency').')','price_per_month');?></th>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
			<th><?php echo $this->Paginator->sort(__l('Security Deposit').' ('.Configure::read('site.currency').')','security_deposit');?></th>
		<?php endif; ?>
		<!-- @todo "Discount percentage" -->
		<th><?php echo $this->Paginator->sort(__l('Pending'),'sales_pending_count');?></th>
        <th><?php echo $this->Paginator->sort(__l('Active'),'sales_pipeline_count');?></th>
        <th><?php echo $this->Paginator->sort(__l('Completed'),'sales_completed_count');?></th>
		<th><?php echo $this->Paginator->sort(__l('Pipeline').' ('.Configure::read('site.currency').')','sales_pipeline_amount');?></th>
        <th><?php echo $this->Paginator->sort(__l('Cleared').' ('.Configure::read('site.currency').')','sales_cleared_amount');?></th>
        <th><?php echo $this->Paginator->sort(__l('Lost').' ('.Configure::read('site.currency').')','sales_lost_amount');?></th>
	</tr>
	<tr<?php echo $class;?>>
		
		<td><?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?></td>
		<td><?php echo ($property['Property']['price_per_week']!=0)?$this->Html->cCurrency($property['Property']['price_per_week']):'-';?></td>
		<td><?php echo ($property['Property']['price_per_month']!=0)?$this->Html->cCurrency($property['Property']['price_per_month']):'-';?></td>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
		<td><?php echo ($property['Property']['security_deposit']!=0)?$this->Html->cCurrency($property['Property']['security_deposit']):'-';?></td>
		<?php endif; ?>
		<td><span><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></span></td>
		<td><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></td>
		<td><?php echo $this->Html->cInt($property['Property']['sales_completed_count']);?></td>
		<td class="js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo $this->Html->cInt($property['Property']['property_view_count']);?></td>
		<td><span class="highlight-pipeline tb"><?php echo $this->Html->cCurrency($property['Property']['sales_pipeline_amount']);?></span></td>
		<td><span class="highlight-cleared tb"><?php echo  $this->Html->cCurrency($property['Property']['revenue']);?></span></td>
		<td><span class="highlight-lost tb"><?php echo $this->Html->cCurrency($property['Property']['sales_lost_amount']);?></span></td>
	</tr>
	<tr><td colspan="12" class="empty-list">&nbsp;</td></tr>
<?php
    endforeach;
else:
?>
<?php if (!empty($properties)) :?>
    <tr>
		<th rowspan="2"><?php echo __l('Select');?></th>
        <th rowspan="2" class="actions"><?php echo __l('Actions');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Title'), 'title');?></th>
		<?php if(!Configure::read('property.is_enable_security_deposit')): ?>
        <th colspan="3"><?php echo __l('Price'); ?></th>
		<?php else: ?>
        <th colspan="4"><?php echo __l('Price'); ?></th>
		<?php endif; ?>
		<th colspan="3"><?php echo __l('Booked'); ?></th>
        <th colspan="3"><?php echo __l('Revenue');?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Views'),'property_view_count');?></th>
    </tr>
	<tr>
        <th><?php echo $this->Paginator->sort(__l('Per Night').' ('.Configure::read('site.currency').')','price_per_night');?></th>
        <th><?php echo $this->Paginator->sort(__l('Per Week').' ('.Configure::read('site.currency').')','price_per_week');?></th>
        <th><?php echo $this->Paginator->sort(__l('Per Month').' ('.Configure::read('site.currency').')','price_per_month');?></th>
		<?php if(Configure::read('property.is_enable_security_deposit')): ?>
		 <th><?php echo $this->Paginator->sort(__l('Security Deposit').' ('.Configure::read('site.currency').')','security_deposit');?></th>
		<?php endif; ?>
		<!-- @todo "Discount percentage" -->
		<th><?php echo $this->Paginator->sort(__l('Pending'),'sales_pending_count');?></th>
        <th><?php echo $this->Paginator->sort(__l('Active'),'sales_pipeline_count');?></th>
        <th><?php echo $this->Paginator->sort(__l('Completed'),'sales_completed_count');?></th>
		<th><?php echo $this->Paginator->sort(__l('Pipeline').' ('.Configure::read('site.currency').')','sales_pipeline_amount');?></th>
        <th><?php echo $this->Paginator->sort(__l('Cleared').' ('.Configure::read('site.currency').')','sales_cleared_amount');?></th>
        <th><?php echo $this->Paginator->sort(__l('Lost').' ('.Configure::read('site.currency').')','sales_lost_amount');?></th>
	</tr>
  <?php endif;?>
	<tr>
		<td colspan="15" class="notice"><p class="notice"><?php echo __l('No Properties available');?></p></td>
	</tr>
<?php
endif;
?>
</table>

<div class="clearfix">
<?php
if (!empty($properties)) :
        ?>
        <div class="select-block grid_left clearfix">
		<div class="select-block-links grid_left">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select-none','title' => __l('None'))); ?>
        </div>
        <div class="admin-checkbox-button grid_left">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
		<?php endif; ?>
		
<div class="grid_right">
<?php if (!empty($properties)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
<?php
    echo $this->Form->end();
?>

</div>