<?php /* SVN: $Id: $ */ ?>
<div>
    <div>
        <div>
            <?php echo $this->Form->create('City', array('class' => 'normal','action'=>'edit'));?>
             <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
<div class="padd-center clearfix">
 <?php
                echo $this->Form->input('id');
                echo $this->Form->input('country_id', array('empty' => __l('Please Select'), 'label' => __l('Country')));
                echo $this->Form->input('state_id', array('empty' => __l('Please Select'), 'label' => __l('State')));
                echo $this->Form->input('name', array('label' => __l('Name')));
                echo $this->Form->input('latitude', array('label' => __l('Latitude')));
                echo $this->Form->input('longitude', array('label' => __l('Longitude')));
                echo $this->Form->input('timezone', array('label' => __l('Timezone')));
                echo $this->Form->input('county', array('label' => __l('County')));
                echo $this->Form->input('code', array('label' => __l('Code')));
                echo $this->Form->input('is_approved', array('label' => __l('Approved?')));
            ?>
            </div>
            	<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
            <?php echo $this->Form->end(__l('Update'));?>
        </div>
    </div>
</div>