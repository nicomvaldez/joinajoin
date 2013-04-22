<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="properties index">
<?php //echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($properties)):

$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}
	if($property['Property']['is_active']){
		$status='Active';
	}
	else
	{
		$status='Not Active';
	}

	if($property['Property']['is_verified']){
		$status.=' and Approved';
	}
	else
	{
		$status.=' and not Approved';
	}
?>
	<li class=" clearfix <?php echo $class;?>">
	<div class="grid_3 omega alpha">
	  <?php 
	    echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'city' => $property['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));		  
	 ?>
	 </div>
	<div class="grid_3 omega alpha">
	
		<?php if(isset($current_latitude) && isset($current_longitude)): ?>
		<p><?php echo number_format($this->Html->distance($current_latitude,$current_longitude,$property['Property']['latitude'],$property['Property']['longitude'],'k'),1).__l(' KM Away'); ?></p>
		<?php endif;?>
		<p><?php
			echo  $this->Html->siteCurrencyFormat($property['Property']['price_per_night']) ."/Night";
		?>
		</p>
		<?php 
			$current_user_details = array(
				'username' => $property['User']['username'],
				'user_type_id' => $property['User']['user_type_id'],
				'id' => $property['User']['id'],
				'fb_user_id' => $property['User']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $property['User']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
		?>	
		</div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Properties available');?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($properties)) {
	if(count($properties)> 5){
    echo $this->element('paging_links');
	}
}
?>
</div>
