<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
   <ul class="filter-list-block clearfix">
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Disapproved) ? 'active-filter' : null; ?>
			<li class="waitingforapproval <?php echo $class; ?>"  title="<?php echo __l('Waiting For Approval'); ?>"><?php echo $this->Html->link( $this->Html->cInt($waiting_for_approval, false) . '<span>' . __l('Waiting for approval') . '</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Disapproved), array('escape' => false));?>
           </li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
			<li class="green <?php echo $class; ?>" title="<?php echo __l('Enabled');?>"><?php echo $this->Html->link( $this->Html->cInt($active_properties ,false) . '<span>' . __l('Enabled').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Active), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
			<li class="gray <?php echo $class; ?>" title="<?php echo __l('Disabled'); ?>"><?php echo $this->Html->link( $this->Html->cInt($inactive_properties ,false) . '<span>' . __l('Disabled') . '</span>' , array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Suspend) ? 'active-filter' : null; ?>
			<li class="suspended <?php echo $class; ?>" title="<?php echo __l('Admin Suspended'); ?>"><?php echo $this->Html->link( $this->Html->cInt($suspended_properties ,false) . '<span>' . __l('Admin Suspended').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Flagged) ? 'active-filter' : null; ?>
			<li class="system-flagged <?php echo $class; ?>" title="<?php echo __l('System flagged'); ?>"><?php echo $this->Html->link( $this->Html->cInt($system_flagged ,false) . '<span>' . __l('System Flagged').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') ? 'active-filter' : null; ?>
			<li class="user-flagged <?php echo $class; ?>" title="<?php echo __l('User flagged'); ?>"><?php echo $this->Html->link( $this->Html->cInt($user_flagged ,false) . '<span>' . __l('User Flagged').'</span>', array('controller'=>'properties','action'=>'index','type' => 'user-flag'), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Featured) ? 'active-filter' : null; ?>
			<li class="featured <?php echo $class; ?>" title="<?php echo __l('Featured'); ?>"><?php echo $this->Html->link( $this->Html->cInt($featured ,false) . '<span>' . __l('Featured').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Featured), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::HomePage) ? 'active-filter' : null; ?>
			<li class="home-page <?php echo $class; ?>" title="<?php echo __l('Home Page'); ?>"><?php echo $this->Html->link( $this->Html->cInt($home ,false) . '<span>' . __l('Home Page').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::HomePage), array('escape' => false));?></li>
            <?php if (Configure::read('property.is_property_verification_enabled')): ?>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Verified) ? 'active-filter' : null; ?>
			<li class="verified <?php echo $class; ?>" title="<?php echo __l('Verified'); ?>"><?php echo $this->Html->link( $this->Html->cInt($verified ,false) . '<span>' . __l('Verified').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Verified), array('escape' => false));?></li>
			<?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::WaitingForVerification) ? 'active-filter' : null; ?>
			<li class="waitingforverfication <?php echo $class; ?>" title="<?php echo __l('Waiting For Verification');?>"><?php echo $this->Html->link( $this->Html->cInt($waiting_for_verification ,false) . '<span>' . __l('Waiting For Verification').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::WaitingForVerification), array('escape' => false));?></li>
		    <?php endif; ?>
		    <?php $class = (!empty($this->request->data['Property']['filter_id']) && $this->request->data['Property']['filter_id'] == ConstMoreAction::Imported) ? 'active-filter' : null; ?>
			<li class="import <?php echo $class; ?>" title="<?php echo __l('Imported from AirBnB');?>"><?php echo $this->Html->link( $this->Html->cInt($imported_from_airbnb_count ,false) . '<span>' . __l('Imported from AirBnB').'</span>', array('controller'=>'properties','action'=>'index','filter_id' => ConstMoreAction::Imported), array('escape' => false));?></li>
			<?php $class = (empty($this->request->data['Property']['filter_id']) && empty($this->request->params['named']['type'])) ? ' active-filter' : null; ?>
			<li class="black <?php echo $class; ?> " title="<?php echo __l('Total');?>"><?php echo $this->Html->link( $this->Html->cInt($total_properties ,false) . '<span>' . __l('Total').'</span>', array('controller'=>'properties','action'=>'index'), array('escape' => false)); ?></li>
    </ul>
	<div class="page-count-block clearfix">
    	<div class="grid_left">
    	   <?php echo $this->element('paging_counter'); ?>
    	</div>
        <div class="grid_left">
    		<?php echo $this->Form->create('Property', array('type' => 'get', 'class' => 'normal search-form clearfix', 'action'=>'index')); ?>
    		<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
         	<?php echo $this->Form->submit(__l('Search'));?>
    		<?php echo $this->Form->end(); ?>
        </div>
    </div>
    <?php echo $this->Form->create('Property' , array('class' => 'normal','action' => 'update')); ?>
   <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <div class="overflow-block">
    <?php
    	$view_count_url = Router::url(array(
    		'controller' => 'properties',
    		'action' => 'update_view_count',
    	), true);
    ?>
    <table id="js-expand-table" class="list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
	 <tr class="js-even">
	    <th class="select" rowspan="2"><?php echo __l('Select');?></th>
        <th class="dl" rowspan="2"><?php echo $this->Paginator->sort(__l('Title'),'title');?></th>
        <th class="dl" rowspan="2"><?php echo $this->Paginator->sort(__l('Address'),'address');?></th>
        <th class="dl" rowspan="2"><?php echo $this->Paginator->sort(__l('Host'),'User.username');?></th>	
		<th class="dc" colspan="3"><?php echo  __l('Bookings');  ?></th>
		<th class="dr" rowspan="2"><?php echo $this->Paginator->sort(__l('Revenue') . ' (' . Configure::read('site.currency') . ')', 'revenue');?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Approved?'), 'is_approved'); ?></th>
    </tr>
	<tr class="js-even">
		<th class="dc"><?php echo  __l('Waiting for Acceptance'); ?></th>
		<th class="dc"><?php echo  __l('Pipeline'); ?></th>
		<th class="dc"><?php echo  __l('Successful'); ?></th>
	</tr>


<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		$class = 'altrow';
	endif;
	if ($property['Property']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
	    $active_class = ' inactive-record';
		$status_class = 'js-checkbox-inactive';
	endif;
	if ($property['Property']['is_approved']):
		$status_class = 'js-checkbox-active';
	else:
	    $active_class = ' inactive-record';
		$status_class = 'js-checkbox-inactive';
	endif;
	if($property['Property']['is_featured']):
		$status_class.= ' js-checkbox-featured';
	else:
		$status_class.= ' js-checkbox-notfeatured';
	endif;
	if($property['Property']['is_show_in_home_page']):
		$status_class.= ' js-checkbox-homepage';
	else:
		$status_class.= ' js-checkbox-nothomepage';
	endif;
	if($property['Property']['is_verified']):
		$status_class.= ' js-checkbox-verified';
	else:
		$status_class.= ' js-checkbox-notverified';
	endif;
	if($property['Property']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($property['Property']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($property['PropertyFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($property['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
 

?>
	  <tr class="<?php echo $class.$active_class;?> expand-row js-odd">
	    <td class="<?php echo $class;?> select">
            <div class="arrow"></div><?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
        <td class="tl">
           
           
                <?php
				if($property['Property']['admin_suspend']): ?>
				<div class="property-status-info">
					<span class="suspended round-3" title="<?php echo __l('Admin Suspended'); ?>"><?php echo __l('Admin Suspended'); ?></span>
				</div>
				<?php	
				endif;
				if(!empty($property['PropertyFlag'])): ?>
				<div class="property-status-info">
					<span class="flagged round-3" title="<?php echo __l('Flagged'); ?>"><?php echo __l('Flagged'); ?></span>
				</div>
				<?php 	
				endif;
				if($property['Property']['is_system_flagged']): ?>
				<div class="property-status-info">
					<span class="systemflagged round-3" title="<?php echo __l('System Flagged'); ?>"><?php echo __l('System Flagged'); ?></span>
				</div>
				<?php	
				endif;
						
				if($property['Property']['is_featured']==1): ?>
				<div class="property-status-info">
					<span class="featured round-3" title="<?php echo __l('Featured'); ?>"><?php echo __l('Featured'); ?></span>
				</div>
				<?php
				endif;
				if($property['Property']['is_show_in_home_page']==1): ?>
				<div class="property-status-info">
					<span class="homepage round-3" title="<?php echo __l('Home Page'); ?>"><?php echo __l('Home Page'); ?></span>
				</div>
				<?php	
				endif;
				if (Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1): ?>
				<div class="property-status-info">
					<span class="verified round-3" title="<?php echo __l('Verified'); ?>"><?php echo __l('Verified'); ?></span>
				</div>
				<?php 	
				endif; 
			?>
			 <div class="grid_left"><?php echo $this->Html->cText($property['Property']['title']);?></div>
			<?php $user_flagged_count = count($property['PropertyFlag']);
						if($user_flagged_count >0){?>
							<div class ="user-flagged">
								<?php echo $this->Html->link(__l('User Flagged') . ' (' . $user_flagged_count . ')', array('controller'=> 'property_flags', 'action' => 'index', 'property'=>$property['Property']['slug'], 'admin' => true), array('escape' => false,'class'=>'round-3','title'=>__l('User Flagged') . ' (' . $user_flagged_count . ')'));?>
							</div>
						<?php } ?> 
            </td>
		<td class="dl"><?php if(!empty($property['Country']['iso2'])): ?>
									<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
							<?php endif; ?>
							
							<?php echo $this->Html->cText($property['Property']['address']);?>

        </td>
		<td class="dl"><?php echo $this->Html->cText($property['User']['username']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></td>
		<td class="dc"><?php echo $this->Html->cInt($property['Property']['sales_cleared_count']);?></td>
		<td class="dr site-amount"><?php echo $this->Html->cCurrency($property['Property']['revenue']);?></td>
		<td class="dc"><?php echo $this->Html->cBool($property['Property']['is_approved']);?></td>
		
    </tr>
    <tr class="hide">
<td colspan="6" class="action-block">
        <div class="action-info-block clearfix">
            <div class="action-left-block">
            	<h3 class="sfont"> <?php echo __l('Action'); ?> </h3>
                   <ul class="action-link clearfix">
			<?php if(empty($property['Property']['is_deleted'])):?>
				<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
				<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Disappear property from user side')));?></li>
				<?php if($property['Property']['is_system_flagged']):?>

					<?php if($property['User']['is_active']):?>
						<li>	<?php echo $this->Html->link(__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link(__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-property active-user', 'title' => __l('Activate user')));?>
							</li>
					<?php endif;?>

				<?php endif;?>
				<?php if($property['Property']['is_featured']):?>
					<li>	<?php echo $this->Html->link(__l('Not Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'deactivate'), array('class' => 'js-admin-update-property js-unfeatured not-featured', 'title' => __l('Not Featured')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link(__l('Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'activate'), array('class' => 'js-admin-update-property js-featured featured', 'title' => __l('Featured')));?>
					</li>
				<?php endif;?>

					<?php if($property['Property']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link(__l('Clear system flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear system flag')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-property js-flag flag', 'title' => __l('Flag')));?>
						</li>
					<?php endif;?><?php if($property['Property']['is_user_flagged']):?>
						<li>	<?php echo $this->Html->link(__l('Clear user flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'user_flag' => 'deactivate'), array('class' => 'js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear user flag')));?>
						</li>
					<?php endif;?>
					<?php if($property['Property']['admin_suspend']):?>
							<li><?php echo $this->Html->link(__l('Unsuspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-property  js-unsuspend unsuspend', 'title' => __l('Unsuspend')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Suspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-property js-suspend suspend', 'title' => __l('Suspend')));?>
					</li>
					<?php endif;?>
				<?php else:?>
					<li><?php echo $this->Html->link(__l('Permanent Delete'), array('action' => 'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Permanent Delete')));?>
                    </li>

				<?php endif; ?>
				<li><?php echo $this->Html->link((($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), array('action' => 'admin_update_status',  $property['Property']['id'], 'status' => (($property['Property']['is_approved']) ? 'disapproved' : 'approved')), array('title' => (($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), 'class' => (( $property['Property']['is_approved']) ? 'js-admin-update-property js-pending pending' : 'js-admin-update-property js-approve approve'))); ?></li>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 2):?>
					<li><?php echo $this->Html->link(__l('Waiting for verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'active'), array('class' => 'js-admin-update-property  unsuspend', 'title' => __l('Waiting for verify')));?></li>
				<?php elseif(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1):?>
					<li><?php echo $this->Html->link(__l('Clear verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'deactivate'), array('class' => 'js-admin-update-property clear', 'title' => __l('Clear verify')));?></li>
				<?php endif;?>
				<?php if(empty($property['Property']['admin_suspend']) && !empty($property['Property']['is_active']) && !empty($property['Property']['is_paid']) && !empty($property['Property']['is_approved'])) {?>
					<?php if($property['Property']['is_show_in_home_page']):?>
					<li>	<?php echo $this->Html->link(__l('Hide in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'deactivate'), array('class' => 'js-admin-update-property hide-home-page', 'title' => __l('Hide in home page')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link(__l('Show in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'activate'), array('class' => 'js-admin-update-property show-home-page', 'title' => __l('Show in home page')));?>
					</li>
				<?php endif;?>
				<?php } ?>
			   </ul>
            </div>
            <div class="action-right-block item-action-right-block clearfix">
                <div class="clearfix">
                   <div class="action-right action-right1 pr">
                   <h3><?php echo __l('Price');?></h3>
                     <dl class="clearfix price-list">
                        <dt><?php echo __l('Per Night'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>
                        <dt><?php echo __l('Per Week'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);?></dd>
                        <dt><?php echo __l('Per Month'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);?></dd>
                        <dt><?php echo __l('Additional Guest'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['additional_guest_price']);?>
						<?php if($property['Property']['additional_guest_price']) :?>
							<span title="<?php echo __l('per night for each guest after') . " " . $property['Property']['additional_guest']; ?>" class="additional-guest-info"><?php echo __l('per night for each guest after') . " " . $property['Property']['additional_guest']; ?></span>
						<?php endif; ?>
						</dd>						
                      </dl>
                      </div>
                   <div class="action-right">
                     <h3><?php echo __l('Booking');?></h3>
                     <dl class="clearfix">
                        <dt><?php echo __l('Waiting for Acceptance'); ?></dt><dd><?php echo $this->Html->cInt($property['Property']['sales_pending_count']);?></dd>
                        <dt><?php echo __l('Pipeline'); ?></dt><dd><?php echo $this->Html->cInt($property['Property']['sales_pipeline_count']);?></dd>
                        <dt><?php echo __l('Lost'); ?></dt><dd><?php echo $this->Html->cInt($property['Property']['sales_lost_count']);?></dd>
                        <dt><?php echo __l('Successful'); ?></dt><dd><?php echo $this->Html->cInt($property['Property']['sales_cleared_count']);?></dd>
                      </dl>
                   </div>
                   <div class="action-right action-right3">
                   <h3><?php echo __l('Revenue');?></h3>
                    <dl class="clearfix">
                        <dt><?php echo __l('Cleared'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_cleared_amount']);?></dd>
                        <dt><?php echo __l('Lost'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_lost_amount']);?></dd>
                        <dt><?php echo __l('Pipeline'); ?></dt><dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['sales_pipeline_amount']);?></dd>

                    </dl>
                    </div>
                </div>
				<div class="action-right city-action">
				<h3><?php echo __l('Reviews'); ?></h3>
            <dl class="ratings-feedback1 clearfix">
				<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
					<dd class="positive-feedback1">
					<?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?>
					</dd>
			</dl>
			<dl class="ratings-feedback1 clearfix">
				<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
					<dd  class="negative-feedback1">
					<?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>
					</dd>
			</dl>
			<dl class="clearfix request-list1 request-index-list success-rate-list">
				<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
					<?php if(empty($property['Property']['property_feedback_count'])): ?>
						<dd class="not-available dc" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php else:?>
						<dd class="success-rate dc">
						<?php
							if(!empty($property['Property']['positive_feedback_count'])):
								$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
								$negative = 100 - $positive;
							else:
								$positive = 0;
								$negative = 100;
							endif;
							echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=00FF00|FF0000&amp;chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));
						?>
						</dd>
					<?php endif; ?>
			</dl>
				</div>
            </div>
            <div class="action-right action-right-block action-right4">
            <div class="item-img-block">
                   <?php echo $this->Html->link($this->Html->showImage('Property', (!empty($property['Attachment'][0]) ? $property['Attachment'][0] : ''), array('dimension' => 'normal_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));?>
            </div>
            <dl class="clearfix">
                <dt><?php echo __l('Added 0n')?>  </dt>
                <dd><?php echo $this->Html->cDateTimeHighlight($property['Property']['created']); ?> </dd>
                <dt><?php echo __l('Views'); ?> </dt>
                <dd><?php echo $this->Html->cInt($property['Property']['property_view_count']);?></dd>
                <dt><?php echo __l('Favorites');?></dt>
                <dd><?php echo $this->Html->cInt($property['Property']['property_favorite_count']);?></dd>
                <dt><?php echo __l('Flags');?></dt>
                <dd><?php echo $this->Html->cInt($property['Property']['property_flag_count']);?></dd>
                <dt><?php echo __l('IP');?></dt>
                <dd>
                <?php if(!empty($property['Ip']['ip'])): ?>
                            <?php echo  $this->Html->link($property['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $property['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => 'whois '.$property['Ip']['host'], 'escape' => false));
							?>
							<p>
							<?php
                            if(!empty($property['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($property['Ip']['Country']['iso2']); ?>" title ="<?php echo $property['Ip']['Country']['name']; ?>">
									<?php echo $property['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($property['Ip']['City'])):
                            ?>
                            <span> 	<?php echo $property['Ip']['City']['name']; ?>    </span>
                            <?php endif; ?>
                            </p>
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
                </dd>
				<dt><?php echo __l('Listing Fee Paid'); ?></dt>
				<dd><?php if($property['Property']['is_paid']) { echo __l('Yes'); } else { echo __l('No');}?></dd>
            </dl>
            </div>
        </div>
    </td>

    </tr>
<?php
    endforeach;
 
else:
?>
	<tr class="js-odd">
		<td colspan="51" class="notice"><?php echo __l('No Properties available');?></td>
	</tr>
<?php
endif;
?>

</table>
</div>
<?php
if (!empty($properties)) :
        ?>
        <div class="clearfix">
       <div class="admin-select-block clearfix grid_left">
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('User Deactivated'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('User Deactivated'))); ?>
			<?php echo $this->Html->link(__l('Admin Suspended'), '#', array('class' => 'js-admin-select-suspended', 'title' => __l('Admin Suspended'))); ?>
			<?php echo $this->Html->link(__l('Featured'), '#', array('class' => 'js-admin-select-featured', 'title' => __l('Featured'))); ?>
			<?php echo $this->Html->link(__l('HomePage'), '#', array('class' => 'js-admin-select-homepage', 'title' => __l('HomePage'))); ?>
			<?php
				if (Configure::read('property.is_property_verification_enabled')):
					echo $this->Html->link(__l('Verified'), '#', array('class' => 'js-admin-select-verified', 'title' => __l('Verified')));
				endif;
			?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'js-admin-select-flagged', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-admin-select-unflagged', 'title' => __l('Unflagged'))); ?>    		  
        </div>
       
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
</div>
<div class="js-pagination grid_right">
<?php
if (!empty($properties)) {
    echo $this->element('paging_links');
}
?>
</div>
</div>
		<?php
endif;
    echo $this->Form->end();
?>
</div>