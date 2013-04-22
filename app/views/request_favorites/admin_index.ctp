<?php /* SVN: $Id: $ */ ?>
<div class="requestFavorites index js-response">
<?php if(empty($this->request->params['named']['simple_view'])) : ?>
<?php echo $this->element('paging_counter');?>
<?php endif; ?>
<?php   
	echo $this->Form->create('RequestFavorite' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<table class="list">
    <tr>
	<?php if(empty($this->request->params['named']['simple_view'])) : ?>
		<th class="select"><?php echo __l('Select'); ?></th>
		<?php endif; ?>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Created'), 'created');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Request'), 'Request.name');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Ip'), 'Ip.ip');?></div></th>
    </tr>
<?php
if (!empty($requestFavorites)):

$i = 0;
foreach ($requestFavorites as $requestFavorite):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	<?php if(empty($this->request->params['named']['simple_view'])) : ?>
		<td class="select"><?php echo $this->Form->input('RequestFavorite.'.$requestFavorite['RequestFavorite']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$requestFavorite['RequestFavorite']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
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
			<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $requestFavorite['RequestFavorite']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li> 
			<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $requestFavorite['RequestFavorite']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
         </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>
        </td>
		<td class="dc"><?php echo $this->Html->cDateTime($requestFavorite['RequestFavorite']['created']);?></td>
		<td class="dl"><?php echo $this->Html->cText($requestFavorite['User']['username']);?></td>
		<td class="dl"><?php echo $this->Html->cText($requestFavorite['Request']['title']);?></td>
		<td class="dc">
			<?php 
				if(!empty($requestFavorite['Ip']['ip'])) {
					echo $this->Html->cText($requestFavorite['Ip']['ip']); 
					echo ' ['.$requestFavorite['Ip']['host'].']' . '('. $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $requestFavorite['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false)) .')';
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
		<td colspan="8" class="notice"><?php echo __l('No Request Favorites available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($requestFavorites)):
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
	<div class="hide">
		<?php echo $this->Form->submit(__l('Submit'));  ?>
	</div>
	<?php
endif;
echo $this->Form->end();
    ?>
</div>
