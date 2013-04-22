<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
<h2><?php echo __l('My Properties');?></h2>
<div class="clearfix">
	<h5 class="sort-head"><?php echo __l('Filter: ');?></h5>
	<div class="select-block">
	<div class="inbox-option">

        <?php $class=(empty($this->request->params['named']['status']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties')? 'active-filter':'';?>
        <span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('All') . ': ' . $all_count, array('controller'=>'properties','action'=>'index','type' => 'myproperties'), array('title' => __l('All')))?></span>
		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'pending')?'active-filter':'';?>
       <span class="pending <?php echo $class; ?>"><?php echo $this->Html->link(__l('Payment Pending') . ': ' . $pending_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'pending'), array('title' => __l('Payment Pending')))?></span>
		
		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'active')?'active-filter':'';?>
      <span class="enabled <?php echo $class; ?>"><?php echo $this->Html->link(__l('Enabled') . ': ' . $active_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'active'), array('title' => __l('Enabled')))?></span>
		
		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'inactive')?'active-filter':'';?>
        <span class="disabled <?php echo $class; ?>"><?php echo $this->Html->link(__l('Disabled') . ': ' . $inactive_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'inactive'), array('title' => __l('Disabled')))?></span>

		<?php if (Configure::read('property.is_property_verification_enabled')): ?>
			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'verified')?'active-filter':'';?>
			<span class="verified <?php echo $class; ?>"><?php echo $this->Html->link(__l('Verified') . ': ' . $verified_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'verified'), array('title' => __l('Verified')))?></span>
			<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_verification')?'active-filter':'';?>
			<span class="waitingforacceptance <?php echo $class; ?>"><?php echo $this->Html->link(__l('Waiting for verification') . ': ' . $waiting_for_verification_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_verification'), array('title' => __l('Waiting for verification')))?></span>
		<?php endif; ?>
	   <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'waiting_for_approval')?'active-filter':'';?>
       <span class="waitingforapproval <?php echo $class; ?>"><?php echo $this->Html->link(__l('Waiting for approval') . ': ' . $waiting_for_approval_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'waiting_for_approval'), array('title' => __l('Waiting for approval')))?></span>
	   <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myproperties' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'imported')?'active-filter':'';?>
       <span class="importedfromairbnb <?php echo $class; ?>"><?php echo $this->Html->link(__l('Imported from AirBnB') . ': ' . $imported_from_airbnb_count, array('controller'=>'properties', 'action'=>'index', 'type' => 'myproperties', 'status'=>'imported'), array('title' => __l('Imported from AirBnB')))?></span>
 </div>
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

$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<table class="list properties-list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
	<tr>
		<th class="properties-title properties-title-section" class="actions">
			<div class="clearfix properties-info-block">
				<?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
				<h3><?php echo $this->Html->link($this->Html->cText($property['Property']['title']), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'] ,'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false)); ?></h3>
			</div>
			<div class="select-block table-select-block">
				<?php if (empty($property['Property']['is_active'])): ?>
					<span class="inactive"> <?php echo __l('Disabled'); ?> </span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::Verified): ?>
    				<span class="verified" title="<?php echo __l('Verified'); ?>">	<?php echo __l('Verified'); ?></span>
    			<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == ConstVerification::WaitingForVerification): ?>
					<span class="waitingforacceptance" title="<?php	echo __l('Waiting for Verfication'); ?>">	<?php	echo __l('Waiting for Verfication'); ?></span>
					<?php endif; ?>
				<?php if($property['Property']['is_approved'] == 0): ?>
					<span class="waitingforacceptance" title="<?php	echo __l('Waiting for Approval'); ?>">	<?php	echo __l('Waiting for Approval'); ?></span>
				<?php endif; ?>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === ConstVerification::VerificationRejected): ?>
					<span class="verificationrejected" title="<?php echo __l('Verification Rejected'); ?>">	<?php echo __l('Verification Rejected'); ?></span>
				<?php endif; ?>
				<?php if($property['Property']['is_paid'] == 0): ?>
					<span class="waitingforacceptance" title="<?php	echo __l('Payment Pending'); ?>">	<?php	echo __l('Payment Pending'); ?></span>
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
				<div class="grid_3 thumb">
					<?php
						$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
						echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
					?>
				</div>
				<div class="properties-action grid_left">
					<span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
					<span><?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Calendar'),'class' => 'calendar'));?></span>
					<span><?php echo $this->Html->link(__l('Post to Craigslist'), array('controller' => 'properties', 'action' => 'post_to_craigslist', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Post to Craigslist'), 'class' => 'craigslist'));?></span>
					<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?>
						<span class="not-verified">	<?php echo $this->Html->link(__l('Get Verified'), array('controller' => 'payments', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Get Verified'),'class' => 'get-verify'));?></span>
					<?php } ?>
					<?php if($property['Property']['is_paid']==0) : ?>
						<span class="listing-fee"><?php echo $this->Html->link(__l('Pay Listing Fee'), array('controller' => 'payments', 'action' => 'property_pay_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Pay Listing Fee'),'class' => 'listing-fee'));?></span>
					<?php endif; ?>
					<span>
						<?php 
							if($property['Property']['is_active'] == 0) {
								echo $this->Html->link(__l('Enable'), array('controller' => 'properties', 'action' => 'updateactions', $property['Property']['id'], 'active', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Enable'),'class' => 'enable'));
							} elseif($property['Property']['is_active'] == 1) { 
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
		<td><span class="highlight-pipeline"><?php echo $this->Html->cCurrency($property['Property']['sales_pipeline_amount']);?></span></td>
		<td><span class="highlight-cleared"><?php echo  $this->Html->cCurrency($property['Property']['sales_cleared_amount']);?></span></td>
		<td><span class="highlight-lost"><?php echo $this->Html->cCurrency($property['Property']['sales_lost_amount']);?></span></td>
	</tr>
</table>
<?php
    endforeach;
else:
?>
<table class="list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
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

	<tr>
		<td colspan="15" class="notice"><?php echo __l('No Properties available');?></td>
	</tr>
	</table>
<?php
endif;
?>
<?php
if (!empty($properties)) :
        ?>
        <div class="admin-select-block">
		<div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
		<?php
endif;
    echo $this->Form->end();
?>
<?php
if (!empty($properties)) {
    echo $this->element('paging_links');
}
?>
</div>