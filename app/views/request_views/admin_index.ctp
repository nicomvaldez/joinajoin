<div class="requestViews index js-response">
<?php if(empty($this->request->params['named']['view_type'])) : ?>
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
    <?php echo $this->Form->create('RequestView' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>	
			<?php echo $this->Form->submit(__l('Search'));?>
			<?php echo $this->Form->end();?>
</div>
</div>
	<?php endif; ?>

    <?php echo $this->Form->create('RequestView' , array('class' => 'normal clearfix','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <table class="list">
        <tr>
            <?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th><?php echo __l('Select'); ?></th>
            <?php endif; ?>
            <th class="actions"><?php echo __l('Actions');?></th>
			<?php if(empty($this->request->params['named']['view_type'])) : ?>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Request'), 'RequestView.title');?></div></th>
			<?php endif; ?>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Viewed By'), 'User.username');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('IP'), 'Ip.ip');?></div></th>
           	<th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Viewed On'),'created');?></div></th>
        </tr>
        <?php
               if (!empty($requestViews)):
            $i = 0;
            foreach ($requestViews as $requestView):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <?php if(empty($this->request->params['named']['view_type'])) : ?>
                    <td><?php echo $this->Form->input('RequestView.'.$requestView['RequestView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestView['RequestView']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
                    <?php endif; ?>
                <td class="actions">
    	<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                      <?php echo __l('Actions'); ?>                                   </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
								<li>
                    <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $requestView['RequestView']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li></ul>
                    </div>
					<div class="action-bottom-block"></div>
					</div></div>
                    </td>
					<?php if(empty($this->request->params['named']['view_type'])) : ?>
	                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($requestView['Request']['title']), array('controller'=> 'requests', 'action'=>'view', $requestView['Request']['slug'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($requestView['Request']['title'],false)));?>
                        </td>
					<?php endif; ?>
                    <td class="dl"><?php echo !empty($requestView['User']['username']) ? $this->Html->link($this->Html->cText($requestView['User']['username']), array('controller'=> 'users', 'action'=>'view', $requestView['User']['username'], 'admin' => false), array('escape' => false,'title' => $this->Html->cText($requestView['User']['username'],false))) : __l('Guest');?></td>
                    <td>
						<?php 
							if(!empty($requestView['Ip']['ip'])) {
								echo $this->Html->cText($requestView['Ip']['ip']); 
								echo ' ['.$requestView['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $requestView['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
							} else {
								echo '-';
							}
						?>
					</td>
					<td><?php echo $this->Html->cDateTimeHighlight($requestView['RequestView']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="7" class="notice"><?php echo __l('No Request Views available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>

    <?php
    if (!empty($requestViews)) :
        ?>
        <div class="admin-select-block clearfix">
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