<?php /* SVN: $Id: $ */ ?>
<div class="requests properties-add form">
	<?php if (empty($this->request->params['prefix'])): ?>
		<h2><?php echo $this->pageTitle;?></h2>
	<?php endif; ?>
	<?php if(!empty($steps) && $steps <= 5):  ?>
		<ul id="stage" class="stage tab-link clearfix">
			<li class="<?php if($steps == 1): ?>highlight<?php endif; ?> <?php if($steps >= 1): ?>active<?php endif; ?>"><?php echo __l('Address');?></li>
			<li class="<?php if($steps == 2): ?>highlight<?php endif; ?> <?php if($steps >= 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('General');?></li>
			<li class="<?php if($steps == 3): ?>highlight<?php endif; ?> <?php if($steps >= 3): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Amenities');?></li>
			<?php if($steps >= 4): ?>
			<li class="<?php if($steps == 4): ?>highlight<?php endif; ?> <?php if($steps >= 4): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Related Properties');?></li>
			<?php endif; ?>
		</ul>
	<?php endif; ?>
	<div class="js-response">
		<?php 
			$form_class = '';
				if(!empty($request_filters)):
					$form_class = '';
					if(!empty($this->request->data)):
						// @todo "What goodies I can provide (guest)"
						echo $this->element('related-properties-index', array('config' => 'sec', 'type' => 'related', 'latitude' => $this->request->data['Request']['latitude'], 'longitude' => $this->request->data['Request']['longitude']));
					endif;
				endif;
		?>
	</div>
	<?php
		if(isset($hash_keyword) && isset($salt)):
			echo $this->Form->create('Request', array('class' => 'normal add-property js-geo-submit','id'=>'RequestAddForm','action'=>'add/'.$hash_keyword.'/'.$salt));
		else:
			echo $this->Form->create('Request', array('class' => 'normal add-property js-geo-submit'));
		endif;
	?>
		<div class="clearfix <?php echo $form_class; ?>">
			<?php if (!empty($steps) && $steps >= 1 ): ?>
				<div <?php if ($steps > 1): ?>class="hide"<?php endif;?>>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Address'); ?></p>
							<div class="mapblock-info clearfix">
							<div class="address-left-block grid_14 omega alpha">
								<div class="clearfix address-input-block">
								<?php
                                    echo $this->Form->input('address', array('label' => __l('Location'), 'id' => 'RequestAddressSearch','info'=>'Address suggestion will be listed when you enter location.<br/>
                                    (Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.)','value' => isset($search_keyword) ? $search_keyword['named']['address'] : ''));
                                ?>

								</div>
        		            <?php
								$class = '';
								if (empty($this->request->data['Request']['address']) || ( !empty($this->request->data['Request']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Request']['country_id']))) {
									$class = 'hide';
								}
							?>
							<div id="js-geo-fail-address-fill-block" class="<?php echo $class;?>">
								<div class="clearfix">
									<div class="grid_16 omega alpha map-address-left-block address-input-block">
							<?php
								echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => 'hidden'));
								echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => 'hidden'));
								echo $this->Form->input('request_id', array('id' => 'request_id', 'type' => 'hidden'));
								echo $this->Form->input('Request.address1', array('id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
	                            echo $this->Form->input('Request.country_id',array('id' => 'js-country_id', 'empty' => __l('Please Select')));
								echo $this->Form->input('State.name', array('type' => 'text', 'label' => __l('State')));
								echo $this->Form->input('City.name', array('type' => 'text', 'label' => __l('City')));
							?>
									</div>
							</div>
								</div>
								</div>
								
									<div class="grid_7 omega alpha grid_right js-side-map-div <?php echo $class;?>">
										<h3><?php echo __l('Point Your Location');?></h3>
										<div class="js-side-map">
											<div id="js-map-container"></div>
											<span><?php echo __l('Point the exact location in map by dragging marker');?></span>
										</div>
									</div>
							<!-- <div id="address-info" class="hide"><?php echo __l('Please select correct address value'); ?></div> -->
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
									</div>
					<div class="submit-block clearfix">
						<?php
							if($steps == 1):
								echo $this->Form->submit(__l('Next'),array('name' => 'data[Request][step1]','class' => 'inactive-search','id' => 'js-sub',));
							endif;
						?>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($steps) && $steps >= 2):  ?>
				<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
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
								echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').configure::read('site.currency').__l(')')));
								// @todo "What goodies I can provide (guest)"
								echo $this->Form->input('accommodates', array('label' => __l('Guests'), 'type'=>'select', 'options'=>$accomadation));
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
					<div class="submit-block clearfix">
						<?php 
							if($steps == 2):
								echo $this->Form->submit(__l('Next'),array('name' => 'data[Request][step2]'));
							endif;
						?>
					</div>
				</div>
			<?php endif; ?>
			<?php if (!empty($steps) && $steps >= 3):  ?>
				<div <?php if($steps > 3): ?>class="hide"<?php endif;?>>
					<?php
						if(isset($this->request->params['named']['checkin'])) {
							$checkin_date=explode('-',$this->request->params['named']['checkin']);
							$this->request->data['Request']['checkin']['month']=$checkin_date[1];
							$this->request->data['Request']['checkin']['year']=$checkin_date[0];
							$this->request->data['Request']['checkin']['day']=$checkin_date[2];
						}
						if(isset($this->request->params['named']['checkout'])) {
							$checkout_date=explode('-',$this->request->params['named']['checkout']);
							$this->request->data['Request']['checkout']['month']=$checkout_date[1];
							$this->request->data['Request']['checkout']['year']=$checkout_date[0];
							$this->request->data['Request']['checkout']['day']=$checkout_date[2];
						}
					?>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center amenities-center">
						<div class="amenities-list">
							<span class="round-5 checkbox-label"><?php echo __l('Amenities');?></span>
							<div class="checkbox-right clearfix">
								<?php echo $this->Form->input('Amenity', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'Amenity1')); ?>
							</div>
							</div>
							<div class="amenities-list">
							<span class="round-5 checkbox-label"><?php echo __l('Holiday Types');?></span>
							<div class="checkbox-right clearfix">
								<?php echo $this->Form->input('HolidayType', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'label' =>'Holiday Types')); ?>
							</div>
							</div>
							<div class="clearfix">
								<p class="round-5 add-info"><?php echo __l('Bed Type'); ?></p>
								<div class="not-required radio-tabs-lblock">
									<div class="radio-tabs-rblock">
										<?php
											echo $this->Form->input('bed_type_id', array('empty' => __l('Any Type'),'legend'=>false,'type'=>'radio','div'=>'js-radio-style','value'=>isset($this->request->data['Request']['bed_type_id'])?$this->request->data['Request']['bed_type_id']:1));
										?>
									</div>
								</div>
							</div>
							<div class="clearfix">
								<p class="round-5 add-info"><?php echo __l('Room Type'); ?></p>
								<div class="not-required radio-tabs-lblock">
									<div class="radio-tabs-rblock">
										<?php
											echo $this->Form->input('room_type_id', array('empty' => __l('Any Type'),'type'=>'radio','legend'=>false,'div'=>'js-radio-style','id'=>'RequestRoom','value'=>isset($this->request->data['Request']['room_type_id'])?$this->request->data['Request']['room_type_id']:1));
										?>
									</div>
								</div>
							</div>
							<div class="property-type"><?php echo $this->Form->input('property_type_id', array('empty' => __l('Any Type'))); ?></div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</div>
					</fieldset>
					<div class="submit-block clearfix">
						<?php
							if($steps == 3):
								echo $this->Form->submit(__l('Finish'),array('name' => 'data[Request][step3]'));
							endif;
						?>
					</div>
				</div>
			<?php endif;  ?>
			<?php if(!empty($steps) && $steps >= 4 && !empty($request_filters)):  ?>
				<div>
					<?php echo __l('(OR)'); ?>
					<div class="page-information clearfix"><?php echo __l('If the above related property does not match your exact request . You can click "Post" below to create a new one'); ?></div>
					<div class="submit-block clearfix">
						<?php
							if($steps == 4):
								echo $this->Form->submit(__l('Post'),array('name' => 'data[Request][step4]'));
							endif;
						?>
					</div>
				</div>
			<?php endif; ?>
		<?php echo $this->Form->end();?>
	</div>