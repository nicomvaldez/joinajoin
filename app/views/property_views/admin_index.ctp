<div class="propertyViews index js-response">
	<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
   <?php if(empty($this->request->params['named']['view_type'])) : ?>
    <?php echo $this->Form->create('PropertyView' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $this->Form->submit(__l('Search'));?>
			<?php echo $this->Form->end();?>
	<?php endif; ?>
	</div>
	</div>
    <?php echo $this->Form->create('PropertyView' , array('class' => 'normal clearfix','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <?php if(empty($this->request->params['named']['view_type'])) : ?>

    <?php endif; ?>
    <table class="list">
        <tr>
            <?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="select"><?php echo __l('Select'); ?></th>
            <?php endif; ?>
            <th class="actions"><?php echo __l('Actions');?></th>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Property'), 'PropertyView.title');?></div></th>
			<?php endif; ?>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Viewed By'), 'User.username');?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('IP'), 'Ip.ip');?></div></th>
           	<th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Viewed On'),'created');?></div></th>
        </tr>
        <?php
               if (!empty($propertyViews)):
            $i = 0;
            foreach ($propertyViews as $propertyView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <?php if(empty($this->request->params['named']['view_type'])) : ?>
                    <td><?php echo $this->Form->input('PropertyView.'.$propertyView['PropertyView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyView['PropertyView']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
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
								    <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $propertyView['PropertyView']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>                   
                                 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
                    </td>
					<?php if(empty($this->request->params['named']['view_type'])) : ?>
	                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($propertyView['Property']['title']), array('controller'=> 'properties', 'action'=>'view', $propertyView['Property']['slug'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($propertyView['Property']['title'],false)));?>
                        </td>
					<?php endif; ?>
                    <td class="dl"><?php echo !empty($propertyView['User']['username']) ? $this->Html->link($this->Html->cText($propertyView['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyView['User']['username'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($propertyView['User']['username'],false))) : __l('Guest');?></td>
                    <td class="dc">
						<?php 
							if(!empty($propertyView['Ip']['ip'])) {
								echo $this->Html->cText($propertyView['Ip']['ip']); 
								echo ' ['.$propertyView['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $propertyView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
							} else {
								echo '--';
							}
						?>
					</td>
					<td class="dc"><?php echo $this->Html->cDateTimeHighlight($propertyView['PropertyView']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7" class="notice"><?php echo __l('No Property Views available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>

    <?php
    if (!empty($propertyViews)) :
        ?>
		<div class="clearfix">
        <div class="admin-select-block clearfix grid_left">
        <?php if(empty($this->request->params['named']['view_type'])) : ?>
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
        <?php endif; ?>
      
        <?php if(empty($this->request->params['named']['view_type'])) : ?>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <?php endif; ?>
        </div>
          <div class="js-pagination  grid_right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit(__l('Submit'));  ?>
        </div>
		</div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>