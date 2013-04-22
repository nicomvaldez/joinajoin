<?php /* SVN: $Id: $ */ ?>
<div class="states form">
    <div>
        <div>
            <h3><?php echo $this->Html->link(__l('States'), array('action' => 'index'),array('title' => __l('States')));?> &raquo; <?php echo __l('Add State'); ?> </h3>
        </div>
        <div>
            <?php echo $this->Form->create('State',  array('class' => 'normal','action'=>'add'));?>
           <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
<div class="padd-center clearfix">
 <?php
                echo $this->Form->input('country_id',array('empty'=>__l('Please Select')));
                echo $this->Form->input('name', array('label' => __l('Name')));
                echo $this->Form->input('code', array('label' => __l('Code')));
                echo $this->Form->input('adm1code', array('label' => __l('Adm1code')));
                echo $this->Form->input('is_approved', array('label' => __l('Approved?')));
            ?>
            </div>
            	<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
            <?php echo $this->Form->end(__l('Add'));?>
        </div>
    </div>
</div>