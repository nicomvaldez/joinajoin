<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="propertyFlags index js-response">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>
<div class="grid_left">
    <?php if(empty($this->request->params['named']['simple_view'])) : ?>
    <?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
          <?php echo $this->Form->create('PropertyFlag' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
        			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
        			<?php echo $this->Form->submit(__l('Search'));?>
        	<?php echo $this->Form->end(); ?>
   <?php endif; ?>
</div>
</div>
   <?php echo $this->Form->create('PropertyFlag' , array('class' => 'normal','action' => 'update')); ?>
   <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<?php endif; ?>

   <div class="overflow-block">
    <table class="list">
        <tr>
            <?php if(empty($this->request->params['named']['simple_view'])) : ?>
                <th><?php echo __l('Select'); ?></th>
            <?php endif; ?>
            <th class="actions"><?php echo __l('Actions');?></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Username'),'User.username');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Property'), 'Property.title');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Category'), 'PropertyFlagCategory.name');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Message'),'message');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('IP'),'Ip.ip');?></div></th>
            <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Posted on'), 'created');?></div></th>
        </tr>
        <?php
         if (!empty($propertyFlags)):
            $i = 0;
            foreach ($propertyFlags as $propertyFlag):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <?php if(empty($this->request->params['named']['simple_view'])) : ?>
                        <td><?php echo $this->Form->input('PropertyFlag.'.$propertyFlag['PropertyFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$propertyFlag['PropertyFlag']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
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
                    <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $propertyFlag['PropertyFlag']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                     </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
                    </td>
                    <td>
                        <?php echo $this->Html->link($this->Html->cText($propertyFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $propertyFlag['User']['username'], 'admin' => false), array('escape' => false));?>
                        <span><?php echo  $this->Html->link(sprintf(__l('All Property flagged by %s'),$propertyFlag['User']['username']), array('controller' => 'property_flags', 'action' => 'index', 'username' => $propertyFlag['User']['username']), array('title' => sprintf(__l('Show all propertys flagged by %s '),$propertyFlag['User']['username']), 'escape' => false));?></span>
                    </td>
                    <td>
					<p><?php echo $this->Html->link($this->Html->showImage('Property', $propertyFlag['Property']['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyFlag['Property']['title'], false)), 'title' => $this->Html->cText($propertyFlag['Property']['title'], false))), array('controller' => 'propertys', 'action' => 'view', $propertyFlag['Property']['slug'], 'admin' => false), array('escape' => false));?></p>
                     <?php echo $this->Html->link($this->Html->cText($propertyFlag['Property']['title']), array('controller'=> 'propertys', 'action'=>'view', $propertyFlag['Property']['slug'], 'admin' => false), array('escape' => false));?>
                    </td>
                    <td><?php echo $this->Html->cText($propertyFlag['PropertyFlagCategory']['name']);?></td>
                    <td><?php echo $this->Html->Truncate($propertyFlag['PropertyFlag']['message']);?></td>
                    <td>
						<?php 
							if(!empty($propertyFlag['Ip']['ip'])) {
								echo $this->Html->cText($propertyFlag['Ip']['ip']); 
								echo ' ['.$propertyFlag['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $propertyFlag['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
							} else {
								echo '--';
							}
						?>
					</td>
                    <td><?php echo $this->Html->cDateTimeHighlight($propertyFlag['PropertyFlag']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="9" class="notice"><?php echo __l('No Flags available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    </div>
    <?php
    if (!empty($propertyFlags)):
        ?>
        <?php if(empty($this->request->params['named']['simple_view'])) : ?>
            <div class="admin-select-block">
            <div>
    			<?php echo __l('Select:'); ?>
    			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
    			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
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
    echo $this->Form->end();
    ?>
</div>