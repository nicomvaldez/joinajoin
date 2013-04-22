<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
<h2><?php echo __l('Manage Collections');?></h2>
<?php echo $this->Form->create('Collection', array('class' => 'normal collectioneditform', 'action'=>'add_collection')); ?>
<dl>
<dt><?php echo __l('Selected Properties'); ?></dt>
<dd>
<?php 
$i=0;
foreach($properties as $property): ?>
<?php 
if($i!=0)
{
	echo ', ';
}
echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
 ?>
<?php $i++; endforeach; ?>
</dd>
</dl>
						<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>

						<div class="padd-center">
							<span class="checkbox-label"><?php echo __l('Choose collections'); ?></span>
							<div class="checkbox-right clearfix">
								<?php echo $this->Form->input('Collection', array('type'=>'select', 'multiple'=>'checkbox',  'label' => false)); ?>
							</div>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>
					</fieldset>
<?php
	echo $this->Form->input('property_list',array('type'=>'hidden','value' =>$property_list));
	echo $this->Form->submit(__l('Map it'));
    echo $this->Form->end();
?>
</div>