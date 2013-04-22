<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks index js-response">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>
	<div class="grid_left"><?php if(empty($this->request->params['named']['simple_view'])) : ?>
		<?php echo $this->Form->create('PropertyFeedback' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
 			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>	 
     		<?php echo $this->Form->submit(__l('Search'));?> 
		<?php echo $this->Form->end(); ?>
	<?php endif; ?>
</div>
</div>
    <?php echo $this->Form->create('PropertyFeedback' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>


<div class="overflow-block">
<table class="list">
    <tr>
	    <th><?php echo __l('Select');?></th>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
        <th class="actions"><?php echo __l('Actions');?></th>
        <?php endif; ?>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Created'),'created');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Property'), 'Property.title');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Host'),'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Traveler'),'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Feedback'),'feedback');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('IP'),'Ip.ip');?></div></th>
		<th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Satisfied'), 'is_satisfied'); ?></div></th>
    </tr>
<?php
if (!empty($propertyFeedbacks)):

$i = 0;
foreach ($propertyFeedbacks as $propertyFeedback):
 $class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
	if($propertyFeedback['PropertyFeedback']['is_satisfied']):
		$status_class = 'js-checkbox-active';
	else:
		$status_class = 'js-checkbox-inactive';
	endif;
?>
	<tr<?php echo $class;?>>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
		  <td><?php echo $this->Form->input('PropertyFeedback.'.$propertyFeedback['PropertyFeedback']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyFeedback['PropertyFeedback']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
        <?php endif; ?>
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

        <li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $propertyFeedback['PropertyFeedback']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
		<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $propertyFeedback['PropertyFeedback']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
           </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
        </td>
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyFeedback['PropertyFeedback']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['title']), array('controller'=> 'propertys', 'action'=>'view', $propertyFeedback['Property']['slug'], 'admin' => false), array('escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFeedback['Property']['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFeedback['PropertyUser']['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFeedback['PropertyUser']['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->cText($propertyFeedback['PropertyFeedback']['feedback']);?></td>
		<td class="dc">
			<?php
				if(!empty($propertyFeedback['Ip']['ip'])) {
					echo $this->Html->cText($propertyFeedback['Ip']['ip']); 
					echo ' ['.$propertyFeedback['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $propertyFeedback['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
				} else {
					echo '-';
				}
			?>
		</td>
		<td class="dc"><?php echo $this->Html->cBool($propertyFeedback['PropertyFeedback']['is_satisfied']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="9" class="notice"><?php echo __l('No Feedbacks available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($propertyFeedbacks)):
        ?>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
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
        <?php endif; ?>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
            <div class="hide">
                <?php echo $this->Form->submit(__l('Submit'));  ?>
            </div>
        <?php endif; ?>
        <?php
    endif;
    if(empty($this->request->params['named']['simple_view'])) :
        echo $this->Form->end();
    endif;
    ?>
</div>