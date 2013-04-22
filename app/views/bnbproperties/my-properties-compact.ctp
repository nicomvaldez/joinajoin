<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php if(empty($this->request->params['isAjax'])): ?>
<div class="properties index js-response">
<?php endif; ?>
<h2><?php echo __l('Assign a property for') . ' "' . $this->Html->cText($request_name,false) . '"';?></h2>
<?php
echo $this->Form->create('Property', array('class' => 'normal','action'=>'manage_property', 'enctype' => 'multipart/form-data'));
echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
echo $this->Form->input('request_id',array('type'=>'hidden'));
if (!empty($properties)): ?>
 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
<ol class="properties-list1 clearfix " start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
$i = 0;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow ';
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
	<li class="dc <?php echo $class;?> clearfix">	
	  <?php
		  $options = array($property['Property']['id'] => '');
		echo $this->Form->input('Property.property', array ('type' => 'radio', 'options' => $options, 'value' => $property['Property']['id'] . '#' . $property['Property']['id'])); echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'small_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));		  
	 ?>
		<h3 class="properties-title">
		<?php echo $this->Html->link($this->Text->truncate($property['Property']['title'],22,array('ending' => '...','exact' => false)), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']),array('title' =>$property['Property']['title']));?>
			<?php if(in_array($property['Property']['id'], $available_list)) { ?>	
			<span class="available round-3"> <?php echo __l('exact'); ?></span>
		<?php		} ?>
		</h3>
		
		

	</li>
<?php
    endforeach; ?>
    </ol>
    	</div>
	<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
    <div class="submit-block clearfix">
    <?php
        	echo $this->Form->submit(__l('Assign')); ?>
	</div>
	<?php

else:
?>
<ol class="list clearfix js-response" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
	<li class="dc">
		<p class="notice"><?php echo __l('No Matched Properties available');?></p>
	</li>
	</ol>
<?php
endif;
		echo $this->Form->end();
?>

<div class="js-pagination">
<?php
if (!empty($properties)) {
    echo $this->element('paging_links');
}
?>
</div>
<?php if(empty($this->request->params['isAjax'])): ?>
</div>
 <h3> <?php echo __l('OR'); ?> </h3>
<?php endif; ?>