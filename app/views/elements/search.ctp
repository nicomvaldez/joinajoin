<?php 
	$type=isset($type)?$type:'home';
	$num_array=array();
	for($i=1;$i<=16;$i++) {
		if($i == 16) {
			$num_array[$i]=$i . '+';
		} else {
			$num_array[$i]=$i;
		}
	}
	if (isset($this->request->params['named']['checkin'])) {
            $this->request->data['Property']['checkin'] = $this->request->params['named']['checkin'];
        }
	if (isset($this->request->params['named']['checkout'])) {
		$this->request->data['Property']['checkout'] = $this->request->params['named']['checkout'];
	}
	if (isset($this->request->params['named']['is_flexible']) && $this->request->params['named']['is_flexible']) {
		$this->request->data['Property']['is_flexible'] = $this->request->params['named']['is_flexible'];
	}

?>
<?php echo $this->Form->create('Property', array('class' => 'normal place-search js-search clearfix', 'action'=>'index', 'enctype' => 'multipart/form-data'));?>
<?php if($type=='home'): ?>
	<?php if(!isset($view)) { ?>
		<h2><?php //echo Configure::read('site.slogan_text'); ?></h2>
	<?php } ?>
			<div class="ui-widget clearfix">
			<div class="grid_10 alpha omega">
            <div class="js-overlabel mapblock-info">
				<?php echo $this->Form->input('Property.cityName', array('label' => __l('Where?'))); ?>
         		<div id="mapblock" >
				    <div id="mapframe">
					   <div id="mapwindow"></div>
				    </div>
			     </div>
			</div>
			<?php
					echo $this->Form->input('Property.latitude', array('id' => 'latitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.longitude', array('id' => 'longitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.ne_latitude', array('id' => 'ne_latitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.ne_longitude', array('id' => 'ne_longitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.sw_latitude', array('id' => 'sw_latitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.sw_longitude', array('id' => 'sw_longitude', 'type' => 'hidden'));
					echo $this->Form->input('Property.type', array( 'value' =>'search', 'type' => 'hidden'));
			?>
			<?php if(!isset($view)) { ?>
			<p class="tipped-info"><?php echo __l('Enter complete address to get better results');?> </p>
			<?php } ?>
					</div>
			</div>
<!--
<?php if(!isset($view)) { ?>
    <div class="clearfix place-search-block">
		 <div class="clearfix show-calender"><span class="js-show-search-calendar"><?php echo __l('Calendar'); ?></span> / <span class="js-show-search-dropdown"><?php echo __l('Dropdown'); ?></span></div>
    	<div id="js-inlineDatepicker-calender" class="hide">
            <div class="clearfix">
                <?php
                echo $this->Form->input('Property.checkin',array('label' => __l('Check in'),'type'=>'date' ,'minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));
                ?>
            </div>
            <div class="alpha omega">
                <?php
                echo $this->Form->input('Property.checkout',array('label' => __l('Check out'), 'type'=>'date','minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));		?>
            </div>
        </div>
        <div id="js-inlineDatepicker"></div>
		<p class="js-date-picker-info"></p>
    </div>
<?php } ?>
    <div class="request-submit-block clearfix">
        <?php if(!isset($view)) { ?>
		<div class="grid_2 guest-select clearfix">
        	<?php

        		echo $this->Form->input('Property.additional_guest', array('label' => __l('Guests'), 'type' => 'select', 'options' => $num_array));
        	?>
        </div>
		<div class="grid_5 checkbox-block  clearfix">
           <?php echo $this->Form->input('Property.is_flexible', array('label' => sprintf(__l('Include non-%s matches (recommended)'), '<span class="exact round-3">' . __l('exact') . '</span>'), 'type' => 'checkbox','checked'=>'checked'));	?>
    	</div>
 -->       
		<?php } ?>
        	<div class="grid_3  clearfix">
        	<?php echo $this->Form->submit(__l('Search'), array('value'=>__l('Search'),'id' => 'js-sub', 'class' => 'inactive-search' ,'disabled' => 'disabled'));?>
    	</div>
	</div>
	<?php echo $this->Form->end();?>
<?php else:?>
<div class="clearfix">
	<div class="grid_11 alpha omega">
		<div class="js-overlabel mapblock-info">
			<?php
				$cityname = !empty($search_keyword['named']['cityname']) ? $search_keyword['named']['cityname'] : '';
				if($is_searching):
				echo $this->Form->input('Property.cityName',array('label' =>false,'id'=>'PropertyCityNameSearch','value'=>$cityname));
				else:
				echo $this->Form->input('Property.cityName',array('label' =>false,'id'=>'PropertyAddressSearch','value'=>$cityname));
				endif;
			?>
			<div id="mapblock">
				<div id="mapframe"><div id="mapwindow"></div></div>
			</div>
		</div>
		<?php
			$lat = !empty($search_keyword['named']['latitude']) ? $search_keyword['named']['latitude'] : '';
			$lng = !empty($search_keyword['named']['longitude']) ? $search_keyword['named']['longitude'] : '';
			echo $this->Form->input('Property.latitude', array('id' => 'latitude', 'type' => 'hidden','value'=>$lat));
			echo $this->Form->input('Property.longitude', array('id' => 'longitude', 'type' => 'hidden','value'=>$lng));
			echo $this->Form->input('Property.ne_latitude', array('id' => 'ne_latitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.ne_longitude', array('id' => 'ne_longitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.sw_latitude', array('id' => 'sw_latitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.sw_longitude', array('id' => 'sw_longitude', 'type' => 'hidden'));
			echo $this->Form->input('Property.type', array( 'value' =>'search', 'type' => 'hidden'));
		?>
		<div class="grid_3">
            <?php echo $this->Form->submit(__l('Search'), array('id' => 'js-sub', 'class' => 'inactive-search' ,'disabled' => 'disabled'));?>
        </div>
		<div class="grid_2 guest-select clearfix">
			<?php //echo $this->Form->input('Property.additional_guest',array('label' => __l('Guests'), 'type'=>'select','options'=>$num_array));	?>
		</div>
		<div class="grid_5 properties-block">
			<?php //echo $this->Form->input('Property.is_flexible', array('label' => sprintf(__l('Include non-%s matches (recommended)'), '<span class="exact round-3">' . __l('exact') . '</span>'), 'type' => 'checkbox', 'checked' => !empty($this->request->data['Property']['is_flexible']) ? 'checked' : '')); ?>
		</div>

	</div>
	<div class="grid_11 alpha omega place-search-block clearfix">
			<div class="clearfix show-calender"><span class="js-show-search-calendar"><!--<?php echo __l('Calendar'); ?></span> / <span class="js-show-search-dropdown"><?php echo __l('Dropdown'); ?>--></span></div>
			<div id="js-inlineDatepicker-calender" class="hide">
				<div class="alpha">
					<?php echo $this->Form->input('Property.checkin',array('label' => __l('Check in'), 'type' => 'date' ,'minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc')); ?>
				</div>
				<div class="">
					<?php echo $this->Form->input('Property.checkout',array('label' => __l('Check out'), 'type' => 'date','minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc'));		?>
				</div>
			</div>
			<div id="js-inlineDatepicker"></div>
			<p class="js-date-picker-info"></p>
	</div>
	<?php echo $this->Form->end();?>
</div>
<?php endif; ?>