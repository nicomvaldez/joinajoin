<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="requests index js-response">

<div class="record-info clearfix select-block inbox-option">
		<div>
			<?php $class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
			<span class="active <?php echo $class; ?>"><?php echo $this->Html->link(__l('Active:'), array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => $class, 'title' => __l('Active')));?>  <?php echo $this->Html->cInt($active_requests); ?></span>
			
		</div>
				<div>
			<?php $class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Suspend) ? 'active-filter' : null; ?>
			<span class="adminsuspended  <?php echo $class; ?>"><?php echo $this->Html->link(__l('Admin Suspended:'), array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Suspend), array('class' => $class, 'title' => __l('Admin Suspended')));?><?php echo $this->Html->cInt($suspended_requests); ?></span>
			  
		</div>
		<div>
			<?php $class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
			<span class="systemflagged <?php echo $class; ?>"><?php echo $this->Html->link(__l('User Suspended:'), array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => $class, 'title' => __l('User Suspended')));?>
			  <?php echo $this->Html->cInt($user_suspended_requests); ?></span>
		</div>
		<div>
			<?php $class = (!empty($this->request->data['Request']['filter_id']) && $this->request->data['Request']['filter_id'] == ConstMoreAction::Flagged) ? 'active-filter' : null; ?>
			<span class="filter-suspended-negotiable <?php echo $class; ?>"><?php echo $this->Html->link(__l('System Flagged:'), array('controller'=>'requests','action'=>'index','filter_id' => ConstMoreAction::Flagged), array('class' => $class, 'title' => __l('System flagged')));?> <?php echo $this->Html->cInt($system_flagged); ?></span>
			 
		</div>	
		<div>
			<?php $class = (empty($this->request->data['Request']['filter_id'])) ? 'active-filter' : null; ?>
			<span class="all <?php echo $class; ?> "><?php echo $this->Html->link(__l('Total:'), array('controller'=>'requests','action'=>'index'), array('class' => $class, 'title' => __l('Total')));?>  <?php echo $this->Html->cInt($total_requests); ?></span>
			
		</div>
       
      
	</div>
	<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
	  <?php echo $this->Form->create('Request' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
				<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
					<?php echo $this->Form->submit(__l('Search'));?>
		<?php echo $this->Form->end(); ?>
<?php endif; ?> 
</div>
</div>
<?php echo $this->Form->create('Request' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
<table class="list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}" id="js-expand-table">
	<tr class="js-even">
		<th><?php echo __l('Select'); ?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Name'), 'name'); ?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Address'), 'address'); ?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Username'), 'User.username');?></th>
	   	<th class="dc"><?php echo $this->Paginator->sort(__l('Offered'), 'property_count'); ?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Approved?'), 'is_approved'); ?></th>
	</tr>
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		 $class = 'altrow';
	endif;
	if($request['Request']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
		$active_class = ' inactive-record';
       	$status_class = 'js-checkbox-inactive';
	endif;
	if($request['Request']['admin_suspend']):
		$status_class.= ' js-checkbox-suspended';
	else:
		$status_class.= ' js-checkbox-unsuspended';
	endif;
	if($request['Request']['is_system_flagged']):
		$status_class.= ' js-checkbox-flagged';
	else:
		$status_class.= ' js-checkbox-unflagged';
	endif;
	if(!empty($Request['RequestFlag'])):
		$status_class.= ' js-checkbox-user-reported';
	else:
		$status_class.= ' js-checkbox-unreported';
	endif;
	if($request['User']['is_active']):
		$status_class.= ' js-checkbox-activeusers';
	else:
		$status_class.= ' js-checkbox-deactiveusers';
	endif;
	if ($request['Request']['is_approved']):
		$status_class = 'js-checkbox-approved';
		$style_class = 'pending';
	else:
		$style_class = 'approve';
		$active_class = ' inactive-record';
		$status_class = 'js-checkbox-disapproved';
	endif;
?>
	 <tr class="<?php echo $class.$active_class;?> expand-row js-odd">
		<td class="<?php echo $class;?> select"><div class="arrow"></div><?php echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="dl">
			<?php echo $this->Html->link($this->Html->cText($request['Request']['title']), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], 'admin' => false), array('title' => $this->Html->cText($request['Request']['title'], false),'escape' => false));?>
			<?php
				if (empty($request['Request']['is_active'])):
					echo '<span class="disabled round-3">'.__l('Disabled').'</span>';
				endif;
				if ($request['Request']['admin_suspend']):
					echo '<span class="adminsuspended round-3">'.__l('Admin Suspended').'</span>';
				endif;
				if (!empty($request['RequestFlag'])):
					echo '<span class="flagged round-3">'.__l('Flagged').'</span>';
				endif;
				if ($request['Request']['is_system_flagged']):
					echo '<span class="systemflagged round-3">'.__l('System Flagged').'</span>';
				endif;
			?>
		</td>
		<td class="dl"><?php echo $this->Html->cText($request['Request']['address']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($request['User']['username']), array('controller'=> 'users', 'action'=>'view', $request['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dc"><?php echo $this->Html->cInt($request['Request']['property_count']);?></td>
       	<td class="dc"><?php echo $this->Html->cText(($request['Request']['is_approved']) ? __l('Approved') : __l('Waiting for approval'));?></td>
	</tr>
	<tr class="hide">
         <td colspan="6" class="action-block">
           <div class="action-info-block clearfix">
            <div class="action-left-block">
            <h3> <?php echo __l('Action'); ?> </h3>
                 <ul class="action-link clearfix">
		        <li>	<?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
            </li>
           <li> <?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
                </li>
            <?php if($request['Request']['is_system_flagged']):?>

					<?php if($request['User']['is_active']):?>
						<li>	<?php echo $this->Html->link(__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link(__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $request['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-property active-user', 'title' => __l('Activate user')));?>
							</li>
					<?php endif;?>
             <?php endif;?>
             <?php if($request['Request']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link(__l('Clear flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-property clear-flag', 'title' => __l('Clear flag')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Flag'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-property flag', 'title' => __l('Flag')));?>
						</li>
			 <?php endif;?>
             <?php if($request['Request']['admin_suspend']):?>
							<li><?php echo $this->Html->link(__l('Unsuspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-property  unsuspend', 'title' => __l('Unsuspend')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Suspend'), array('action' => 'admin_update_status', $request['Request']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-property suspend', 'title' => __l('Suspend')));?>
					</li>
			<?php endif;?>
		<li>	<?php echo $this->Html->link((($request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve')), array('action' => 'admin_update_status',  $request['Request']['id'], 'status' => (($request['Request']['is_approved']) ? 'disapproved' : 'approved')), array('class' => 'js-admin-update-property ' . $style_class, 'title' => (( $request['Request']['is_approved']) ? __l('Disapprove') : __l('Approve')))); ?>
              </li> </ul>
                
            </div>
            <div class="action-right action-right-block">
           <h3><?php echo __l('Details'); ?></h3>
                  <dl class="clearfix">
        		   <dt><?php echo __l('Price'); ?></dt><dd><?php echo Configure::read('site.currency').$this->Html->cCurrency($request['Request']['price_per_night']);?></dd>
        		   <dt><?php echo __l('Check in'); ?></dt><dd><?php echo $this->Html->cDate($request['Request']['checkin']);?></dd>
        		   <dt><?php echo __l('Check out'); ?></dt><dd><?php echo $this->Html->cDate($request['Request']['checkout']);?></dd>
        		   <dt><?php echo __l('Accomodates'); ?></dt><dd><?php echo $this->Html->cInt($request['Request']['accommodates']);?></dd>
                  </dl>
            </div>
            <div class="action-right action-right-block action-right4">
               <h3><?php echo __l('Others'); ?></h3>
                  <dl class="clearfix">
        		   <dt><?php echo __l('Posted On');?></dt><dd><?php echo $this->Html->cDateTimeHighlight($request['Request']['created']);?></dd>
        		   <dt><?php echo __l('Offered');?></dt><dd><?php echo $this->Html->cInt($request['Request']['property_count']);?></dd>
        		   <dt><?php echo __l('Views');?></dt><dd><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_view_count']), array('controller'=> 'request_views', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?>	</dd>
        		   <dt><?php echo __l('Flags');?></dt><dd><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_flag_count']), array('controller'=> 'request_flags', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?></dd>
        		   <dt><?php echo __l('Favorites');?></dt><dd><?php echo $this->Html->link($this->Html->cInt($request['Request']['request_favorite_count']), array('controller'=> 'request_favorites', 'action'=>'index', 'request_id'=>$request['Request']['id'], 'admin' => true), array('escape' => false));?></dd>
                  </dl>
            </div>
           
           </div>
         </td>
    </tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><?php echo __l('No requests available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
    <?php
    if (!empty($requests)) :
        ?>
        <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
                <?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-admin-select-propertydisapproved','title' => __l('Disapprove'))); ?>
                <?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-admin-select-propertyapproved','title' => __l('Approve'))); ?>

            </div>
           <div class="admin-checkbox-button">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
         </div>
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