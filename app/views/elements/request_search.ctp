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
	if (isset($search_keyword['named']['checkin'])) {
            $this->request->data['Request']['checkin'] = $search_keyword['named']['checkin'];
        }
	if (isset($search_keyword['named']['checkout'])) {
		$this->request->data['Request']['checkout'] = $search_keyword['named']['checkout'];
	}
	if (isset($search_keyword['named']['is_flexible']) && $search_keyword['named']['is_flexible']) {
		$this->request->data['Request']['is_flexible'] = $search_keyword['named']['is_flexible'];
	}
?>
<div class="request-search">
	<?php echo $this->Form->create('Request', array('class' => 'normal place-search clearfix js-search', 'action'=>'index', 'enctype' => 'multipart/form-data'));?>
	<div class="clearfix">
		<div class="grid_12 alpha omega">
			<div class="js-overlabel mapblock-info">
				<?php echo $this->Form->input('Request.cityName', array('value'=>$search_keyword['named']['cityname'],'label' => __l('Where?'))); ?>
				<div id="mapblock" >
					<div id="mapframe"><div id="mapwindow"></div></div>
				</div>
			</div>
			<?php
				$lat = !empty($search_keyword['named']['latitude']) ? $search_keyword['named']['latitude'] : '';
				$lng = !empty($search_keyword['named']['longitude']) ? $search_keyword['named']['longitude'] : '';

				echo $this->Form->input('Request.latitude', array('id' => 'latitude', 'type' => 'hidden','value'=>$lat));
				echo $this->Form->input('Request.longitude', array('id' => 'longitude', 'type' => 'hidden','value'=>$lng));
				echo $this->Form->input('Request.type', array( 'value' =>'search', 'type' => 'hidden'));
			?>
			<div class="grid_2 guest-select clearfix">
				<?php echo $this->Form->input('Request.additional_guest', array('label' => __l('Guests'), 'type' => 'select', 'options' => $num_array)); ?>
			</div>
			<div class="grid_5 checkbox-block  clearfix">
				<?php echo $this->Form->input('Request.is_flexible', array('label' => sprintf(__l('Include non-%s matches (recommended)'), '<span class="exact round-3">' . __l('exact') . '</span>'), 'type' => 'checkbox','checked'=>'checked', 'checked' => !empty($this->request->data['Request']['is_flexible']) ? 'checked' : ''));	?>
			</div>
			<div class="grid_3  clearfix">
				<?php echo $this->Form->submit(__l('Search'), array('id' => 'js-sub', 'class' => 'inactive-search' ,'disabled' => 'disabled'));?>
			</div>
		</div>
		<div class="grid_10 alpha omega place-search-block">
			<div class="clearfix ">
				<div class="clearfix show-calender"><span class="js-show-search-calendar"><?php echo __l('Calendar'); ?></span> / <span class="js-show-search-dropdown"><?php echo __l('Dropdown'); ?></span></div>
				<div id="js-inlineDatepicker-calender" class="hide">
					<div class="clearfix">
						<?php echo $this->Form->input('Request.checkin',array('label' => __l('Check in'), 'type' => 'date' ,'minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc')); ?>
					</div>
					<div class="alpha omega">
						<?php echo $this->Form->input('Request.checkout',array('label' => __l('Check out'),'type'=>'date','minYear'=>date('Y'), 'maxYear'=>date('Y')+1, 'orderYear' => 'asc')); ?>
					</div>
				</div>
				<div id="js-inlineDatepicker"></div>
				<p class="js-date-picker-info"></p>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end();?>
</div>