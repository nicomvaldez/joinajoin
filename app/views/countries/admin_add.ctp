<?php /* SVN: $Id: $ */ ?>
<div class="countries form">
    <div>
        <div>
            <h3><?php echo $this->Html->link(__l('Countries'), array('action' => 'index'),array('title' => __l('Countries')));?> &raquo; <?php echo __l('Add Country'); ?></h3>
        </div>
        <div>
            <?php echo $this->Form->create('Country', array('class' => 'normal','action'=>'add'));?>
        	 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
<div class="padd-center clearfix">
<?php
        		echo $this->Form->input('name', array('label' => __l('Name')));
        		echo $this->Form->input('fips104', array('label' => __l('Fips104')));
        		echo $this->Form->input('iso2', array('label' => __l('ISO2')));
        		echo $this->Form->input('iso3', array('label' => __l('ISO3')));
        		echo $this->Form->input('ison', array('label' => __l('ISON')));
        		echo $this->Form->input('internet', array('label' => __l('Interner')));
        		echo $this->Form->input('capital', array('label' => __l('Capital')));
        		echo $this->Form->input('map_reference', array('label' => __l('Map Reference')));
        		echo $this->Form->input('nationality_singular', array('label' => __l('Nationality Singular')));
        		echo $this->Form->input('nationality_plural', array('label' => __l('Nationality Plural')));
        		echo $this->Form->input('currency', array('label' => __l('Currency')));
        		echo $this->Form->input('currency_code', array('label' => __l('Currency Code')));
        		echo $this->Form->input('population', array('label' => __l('Population'), 'info' => 'Ex: 2001600'));
        		echo $this->Form->input('title', array('label' => __l('Title')));
        		echo $this->Form->input('comment', array('label' => __l('Comment')));
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
