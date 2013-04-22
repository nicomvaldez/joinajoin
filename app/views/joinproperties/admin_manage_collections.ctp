<?php /* SVN: $Id: $ */ ?>
<div class="properties index">
<?php echo $this->Form->create('Collection', array('class' => 'normal collectioneditform', 'action'=>'add_collection')); ?>
   <div class="padd-bg-tl">
    	<div class="padd-bg-tr">
    		<div class="padd-bg-tmid"></div>
    	</div>
    </div>
    <div class="padd-center">
        <div class="clearfix">
           <h3 class="grid_left"> <?php echo __l('Selected Properties'); ?></h3>
              <ul class="clearfix collection-list pr grid_left">
                  <?php
                        $i=0;
                        foreach($properties as $property): ?>
                         <li>
                        <?php
                        if($i!=0)
                        {
                        	echo ', ';
                        }
                        echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
                         ?>
                        </li>
                   <?php $i++; endforeach; ?>
                </ul>
        </div>
    	<span class="checkbox-label pa admin-checkbox-label tb"><?php echo __l('Choose collections'); ?></span>
    	<div class="checkbox-right admin-checkbox-right clearfix">
    		<?php echo $this->Form->input('Collection', array('type'=>'select', 'multiple'=>'checkbox',  'label' => false)); ?>
    	</div>
    </div>
    <div class="padd-bg-bl">
    	<div class="padd-bg-br">
    		<div class="padd-bg-bmid"></div>
    	</div>
    </div>
<?php
	echo $this->Form->input('property_list',array('type'=>'hidden','value' =>$property_list));
?>
<div class="clearfix submit-block">
    <?php
    	echo $this->Form->submit(__l('Map it'));
    ?>
</div>
<?php
    echo $this->Form->end();
?>
</div>