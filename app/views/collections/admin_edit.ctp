<?php /* SVN: $Id: $ */ ?>
<div class="collections form">
<?php echo $this->Form->create('Collection', array('class' => 'normal js-propertiesdrag', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title', array('label' => __l('Title')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => 'Upload Photo','class' =>'browse-field'));
		if(isset($this->request->data['Attachment']['id']))
		{
			echo $this->Form->input('Attachment.id',array('type'=>'hidden'));
		} ?>
		<?php if(isset($this->request->data['Attachment']['id'])): ?>
		<div class="profile-image">
				<?php $this->request->data['Attachment'] = !empty($this->request->data['Attachment']) ? $this->request->data['Attachment'] : array(); ?>
                <?php echo $this->Html->showImage('Collection', $this->request->data['Attachment'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Collection']['title'], false)), 'title' => $this->Html->cText($this->request->data['Collection']['title'], false))); ?>
    		</div>
			<?php endif; ?>
	<?php
		echo $this->Form->input('is_active', array('label' => __l('Active')));
	?>
	</fieldset>
	<h2><?php echo __l('Manage Properties'); ?></h2>
	<div>
<a class="js-dragdrop {'met_tab':'js-tab-list', 'met_drag_cls':'js-drag_property','met_data_action':'js-reorder','met_tr_drag':'js-dragbox', 'met_form_cls':'js-propertiesdrag', 'met_tab_order':'js-propertyorder'}" rel="reorder" title="Reorder" href="#"><?php echo __l('Reorder'); ?></a>
</div>

	<fieldset>
						<table class="list js-tab-list">
	  <tr>
	    <th class="select"><?php echo __l('Select');?></th>
        <th class="actions" ><?php echo __l('Actions');?></th>
        <th class="dc"><?php echo __l('Created');?></th>
        <th class="dl"><?php echo __l('Title');?></th>
        <th class="dl"><?php echo __l('Address');?></th>
        <th class="dl"><?php echo __l('User');?></th>
    </tr>
<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	$class = null;
	if ($i++ % 2 == 0):
		$class = ' class="altrow"';
	endif;
?>
	<tr<?php echo $class;?>>
	    <td><?php echo $this->Form->input('Property.'.$property['Property']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$property['Property']['id'], 'label' => false, 'class' => ' js-checkbox-list')); ?></td>
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
					<span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete_property', $property['Property']['id'],$this->request->data['Collection']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
                    </span></li></ul>
				
			</div>
			<div class="action-bottom-block"></div>
			</div></div>
		</td>

		
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($property['Property']['created']);?></td>
		<td class="propertys-title-info dl">
        <div class="clearfix properties-title-details">
		<?php $attachment = '';?>
		<?php if(!empty($property['Attachment']['0'])){?>
			<?php if($property['Property']['is_negotiable']):?>

			<?php endif;?>
			<p><?php echo $this->Html->link($this->Html->showImage('Property', $property['Attachment']['0'], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('escape' => false));?></p>
		<?php }else{ ?>
				<p><?php echo $this->Html->link($this->Html->showImage('Property', $attachment, array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false), array('escape' => false));?></p>
		<?php } ?>
        <p class="title">
		<?php 
		
			echo $this->Html->link($this->Html->cText($property['Property']['title']), array('controller'=> 'properties', 'action'=>'view', $property['Property']['slug'] , 'admin' => false), array('escape' => false));?>
            </p></div>
        	<?php
			if($property['Property']['admin_suspend']):
				echo '<span class="adminsuspended round-3">'.__l('Admin Suspended').'</span>';
			else:
				if(!empty($property['PropertyFlag'])):
					echo '<span class="flagged round-3">'.__l('Flagged').'</span>';
				endif;
				if($property['Property']['is_system_flagged']):
					echo '<span class="systemflagged round-3">'.__l('System Flagged').'</span>';
				endif;
				if(empty($property['Property']['is_active'])):
					echo '<span class="usersuspended round-3">'.__l('User Suspended').'</span>';
				endif;
				 
				if($property['Property']['is_featured']==1):
					echo '<span class="featured round-3">'.__l('Featured').'</span>';
				endif;
				if($property['Property']['is_show_in_home_page']==1):
					echo '<span class="homepage round-3">'.__l('Home Page').'</span>';
				endif;
				if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==1):
					echo '<span class="verified round-3">'.__l('Verified').'</span>';
				endif;
			endif;
		?>
            </td>
		<td class="dl"><?php if(!empty($property['Country']['iso2'])): ?>
									<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
							<?php endif; ?>
							
							<?php echo $this->Html->cText($property['Property']['address']);?>

        </td>
		  <td class="hide js-dragbox">
            <?php echo $this->Form->input('CollectionsProperty.'.$property['Property']['id'].'.display_order', array('value' =>  $property['Property']['display_order'], 'class' => 'js-propertyorder'));?>
        </td>
		<td class="dl"><?php echo $this->Html->link($this->Html->cText($property['User']['username']), array('controller'=> 'users', 'action'=>'view', $property['User']['username'] , 'admin' => false), array('escape' => false));?></td>

    </tr>
<?php
    endforeach;
 
else:
?>
	<tr>
		<td colspan="51" class="notice"><?php echo __l('No Properties available');?></td>
	</tr>
<?php
endif;
?>

</table>
	</fieldset>
<?php
if (!empty($properties)) :
        ?>
		<div class="clearfix">
        <div class="admin-select-block clearfix grid_left"> 
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
       
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
		<?php
endif; ?>

<?php echo $this->Form->end(__l('Update'));?>
        </div>
</div>
