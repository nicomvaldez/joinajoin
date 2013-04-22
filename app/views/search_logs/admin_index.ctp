<?php /* SVN: $Id: $ */ ?>
<div class="searchLogs index">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php echo $this->Form->create('SearchLog', array('type' => 'get', 'class' => 'normal search-form clearfix', 'action'=>'index')); ?>
		<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		<?php echo $this->Form->submit(__l('Search'));?>
	<?php echo $this->Form->end(); ?>
</div>
</div>

	<?php echo $this->Form->create('SearchLog', array('class' => 'normal', 'action'=>'update')); ?>

<div class="overflow-block">
<table class="list">
    <tr>
        <th rowspan="2"><?php echo __l('Select');?></th>
        <th rowspan="2" class="actions"><?php echo __l('Actions');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Added On'), 'created');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Search Keyword'), 'search_keyword_id');?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('User'), 'user_id');?></th>
        <th colspan="6"><?php echo __l('Auto detected');?></th>
    </tr>
    <tr>
    	<th><?php echo __l('Ip');?></th>
    	<th><?php echo __l('City');?></th>
    	<th><?php echo __l('State');?></th>
    	<th><?php echo __l('Country');?></th>
    	<th><?php echo __l('Latitude');?></th>
    	<th><?php echo __l('Longitude');?></th>
	</tr>
<?php
if (!empty($searchLogs)):

$i = 0;
foreach ($searchLogs as $searchLog):

	$class = null;
	$status_class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

	//salt and hash prepartion
	$keyword_id=$searchLog['SearchLog']['search_keyword_id'];
	$salt = $keyword_id+786;
	$hash=dechex($keyword_id);
	$salt=substr(dechex($salt) , 0, 2);
?>
	<tr<?php echo $class;?>>
    <td><?php echo $this->Form->input('SearchLog.'.$searchLog['SearchLog']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$searchLog['SearchLog']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td class="actions">
       <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                      <?php echo __l('Actions'); ?>                                    </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
		<li><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $searchLog['SearchLog']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
		<li><span><?php echo $this->Html->link(__l('Search'), array('controller'=> 'properties', 'action' => 'index',$hash,$salt, 'admin' => false), array('class' => 'search','escape' => false));?></span></li>
		</ul>
		</div>
		<div class="action-bottom-block"></div>
		</div></div>
        </td>
		<td><?php echo $this->Time->timeAgoInWords($searchLog['SearchLog']['created']);?></td>
		<td><?php echo $this->Html->cText($searchLog['SearchKeyword']['keyword']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($searchLog['User']['username']), array('controller'=> 'users', 'action' => 'view', $searchLog['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td><?php echo $this->Html->cText($searchLog['Ip']['ip']); ?></td>
        <td><?php echo !empty($searchLog['Ip']['City']['name']) ? $this->Html->cText($searchLog['Ip']['City']['name']) : ' - '; ?></td>
        <td><?php echo !empty($searchLog['Ip']['State']['name']) ? $this->Html->cText($searchLog['Ip']['State']['name']) : ''; ?></td>
        <td><?php echo !empty($searchLog['Ip']['Country']['name']) ? $this->Html->cText($searchLog['Ip']['Country']['name']) : ''; ?></td>
        <td><?php echo !empty($searchLog['Ip']['latitude']) ? $this->Html->cText($searchLog['Ip']['latitude']) : ''; ?></td>
        <td><?php echo !empty($searchLog['Ip']['longitude']) ? $this->Html->cText($searchLog['Ip']['longitude']) : ''; ?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6" class="notice"><?php echo __l('No Search Logs available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>

<?php
if (!empty($searchLogs)) {  ?>
	<div class="clearfix">
    <div class="admin-select-block clearfix grid_left">
			<div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
    		</div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
		</div>
		  <div class="js-pagination grid_right">
          <?php echo $this->element('paging_links'); ?>
        </div>
		</div>
<?php
}
echo $this->Form->end();
?>
</div>
