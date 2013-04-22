<?php /* SVN: $Id: $ */ ?>
<div class="holidayTypes index js-response">

<div class="record-info select-block clearfix">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
	<span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(__l('Active').': '.$this->Html->cInt($active), array('controller' => 'holiday_types', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('title' => __l('Active'), 'escape' => false)); ?></span>
	
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
	<span class="notverified <?php echo $class; ?>"><?php echo $this->Html->link(__l('Inactive').': '.$this->Html->cInt($inactive), array('controller' => 'holiday_types', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('title' => __l('Inactive'), 'escape' => false)) ?></span>
	
	<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active-filter' : null; ?>
	<span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('All').': '.$this->Html->cInt($active + $inactive), array('controller' => 'holiday_types', 'action' => 'index'),array('title' => __l('All'), 'escape' => false)) ?></span>
</div>

<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="add-block grid_right">
	<?php echo $this->Html->link(__l('Add'), array('controller' => 'holiday_types', 'action' => 'admin_add'),array('class' => 'add', 'title' => __l('Add'))); ?>
</div>
</div>

<?php   
	echo $this->Form->create('HolidayType' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<table class="list">
    <tr>
		<th><?php echo __l('Select'); ?></th>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort(__l('Created'), 'created');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Name'), 'name');?></th>
       </tr>
<?php
if (!empty($holidayTypes)):

$i = 0;
foreach ($holidayTypes as $holidayType):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0) {
		$class = 'altrow';
	}
	if($holidayType['HolidayType']['is_active']):
		$status_class = 'js-checkbox-active';
	else:
	    $active_class = ' inactive-record';
		$status_class = 'js-checkbox-inactive';
	endif;
?>
	<tr class="<?php echo $class.$active_class;?>">
		<td class="select"><?php echo $this->Form->input('HolidayType.'.$holidayType['HolidayType']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$holidayType['HolidayType']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
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
        <li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $holidayType['HolidayType']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li> 
		<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $holidayType['HolidayType']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
      </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
        </td>
		<td class="dc"><?php echo $this->Html->cDateTime($holidayType['HolidayType']['created']);?></td>
		<td class="dl"><?php echo $this->Html->cText($holidayType['HolidayType']['name']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Holiday Types available');?></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($holidayTypes)):
?>
       <div class="admin-select-block">
            <div>
				<?php echo __l('Select:'); ?>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
				<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Inactive'))); ?>
				<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
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
