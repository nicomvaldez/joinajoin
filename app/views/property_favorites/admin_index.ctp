<?php /* SVN: $Id: $ */ ?>
<div class="propertyFavorites index js-response js-responses">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
	<?php echo $this->Form->create('PropertyFavorite' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $this->Form->submit(__l('Search'));?>
	<?php echo $this->Form->end(); ?>
	<?php endif; ?>
</div>
</div>
        <?php echo $this->Form->create('PropertyFavorite' , array('class' => 'normal','action' => 'update')); ?>
        <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

    <div class="overflow-block">
<table class="list">
    <tr>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
	       <th><?php echo __l('Select');?></th>
        <?php endif; ?>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Created'),'created');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'),'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Property Title'), 'Property.title');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Ip'), 'Ip.ip');?></div></th>
    </tr>
<?php
if (!empty($propertyFavorites)):
$i = 0;
foreach ($propertyFavorites as $propertyFavorite):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
		  <td><?php echo $this->Form->input('PropertyFavorite.'.$propertyFavorite['PropertyFavorite']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyFavorite['PropertyFavorite']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
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
        <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $propertyFavorite['PropertyFavorite']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
        </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>

        </td>
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyFavorite['PropertyFavorite']['created']);?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFavorite['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFavorite['User']['username'] , 'admin' => false), array('escape' => false));?></td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyFavorite['Property']['title']), array('controller'=> 'propertys', 'action'=>'view', $propertyFavorite['Property']['slug'] , 'admin' => false), array('escape' => false));?></td>
		<td class="dc">
			<?php 
				if(!empty($propertyFavorite['Ip']['ip'])) {
					echo $this->Html->cText($propertyFavorite['Ip']['ip']); 
					echo ' ['.$propertyFavorite['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $propertyFavorite['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
				} else {
					echo '-';
				}
			?>
		</td> 
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Favorites available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($propertyFavorites)):
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