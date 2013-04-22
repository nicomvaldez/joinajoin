<?php /* SVN: $Id: $ */ ?>
<div class="requests form">
<?php echo $this->Form->create('Request', array('class' => 'normal add-property '));?>
 	<h2><?php echo __l('Edit Request');?></h2>

<fieldset>
    <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
     <p class="round-5"><?php echo __l('Address'); ?></p>
         <div class="mapblock-info">
               <div class="clearfix address-input-block">
            	<?php
    				echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'RequestAddressSearch','readonly'=>true));
    			?>
    			</div>
          <div id="mapblock">
        		<div id="mapframe">
        			<div id="mapwindow"></div>
        		</div>
        	</div>
    	</div>
		</div>
		 <div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid"></div>
        </div>
    </div>
</fieldset>
<fieldset>
	<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
 		<p class="round-5"><?php echo __l('General');?></p>
    	<div class="clearfix date-time-block">
    		<div class="input date-time clearfix">
    			<div class="js-datetime">
    				<?php echo $this->Form->input('checkin', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
    			</div>
    		</div>
    		<div class="input date-time end-date-time-block clearfix">
    			<div class="js-datetime">
    				<?php echo $this->Form->input('checkout', array('orderYear' => 'asc', 'maxYear' => date('Y') + 10, 'minYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
    			</div>
    		</div>
    	</div>
		<?php 
			$currency_code = Configure::read('site.currency_id');
			Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
			echo $this->Form->input('id',array('type'=>'hidden'));
			echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').configure::read('site.currency').__l(')')));
			// @todo "What goodies I can provide (guest)"
			echo $this->Form->input('accommodates', array('label' => __l('Guests'), 'type'=>'select', 'options'=>$accomadation));
		?>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		?>
		        			</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
	</fieldset>
	
		<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
	<div class="amenities-list">
		<span class="round-5 checkbox-label"><?php echo __l('Amenities');?></span>
 		<div class="checkbox-right clearfix">
 		
	<?php	
		echo $this->Form->input('Amenity', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'Amenity1')); ?>
        </div>
        </div>
		<div class="amenities-list">
			<span class="round-5 checkbox-label"><?php echo __l('Holiday Types');?></span>
 		<div class="checkbox-right clearfix">
 		
    <?php	
								echo $this->Form->input('HolidayType', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'label' =>'Holiday Types')); ?>
        </div>
        </div>
        	<div class="clearfix">
			     <p class="round-5 add-info"><?php echo __l('Bed Type'); ?></p>
    			<div class="not-required radio-tabs-lblock">
        			<div class="radio-tabs-rblock">
                      	<?php
            	       	   echo $this->Form->input('bed_type_id', array('empty' => __l('Any Type'),'legend'=>false,'type'=>'radio','div'=>'js-radio-style'));
                         ?>
                     </div>
                  </div>
             </div>

        	<div class="clearfix">
			<p class="round-5 add-info"><?php echo __l('Room Type'); ?></p>
			<div class="not-required radio-tabs-lblock">
			<div class="radio-tabs-rblock">
              	   <?php
               	echo $this->Form->input('room_type_id', array('empty' => __l('Any Type'),'type'=>'radio','legend'=>false,'div'=>'js-radio-style','id'=>'RequestRoom'));
                ?>
               </div>
              </div>
             </div>
           	   <?php
               	echo $this->Form->input('property_type_id', array('empty' => __l('Any Type')));
                ?>
  
		</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
	</fieldset>

<?php echo $this->Form->end(__l('Update'));?>
</div>
