<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-add form js-responses">
	<?php
	if(!empty($this->request->data['Property']['request_id']) && (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0]=='request')){
		echo $this->element('property-index', array('config' => 'sec', 'type' => 'property', 'request_id' => $this->request->data['Property']['request_id'], 'request_latitude' => $this->request->data['Property']['request_latitude'], 'request_longitude' => $this->request->data['Property']['request_longitude']));
	}
	?>
	<?php
if(!empty($this->request->data['Property']['request_id']) && (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0]=='request')):?>
<?php echo $this->Html->link(__l('List your property'),  array('controller' => 'joinproperties', 'action' => 'add'), array('title' => __l('List your property')));?><?php  else: ?>
	<div class="clearfix">
	<?php if (empty($this->request->params['prefix'])): ?>
		<h2 class="list-property grid_left"> <?php echo __l('List your property');?> </h2>
	<?php endif; ?>
	<p class="import-property dr grid_right">
		<?php echo $this->Html->link(__l('Import Properties'), array('controller' => 'joinproperties', 'action' => 'import', 'admin' => false), array('class' => 'import-properties','title' => __l('Import Properties')));?></p></div>
		<?php if($steps <= 8):  ?>
		<ul id="stage" class="stage tab-link clearfix">
			<li class="tb <?php if($steps == 1): ?>highlight<?php endif; ?> <?php if($steps >= 1): ?>active<?php endif; ?>"><?php echo __l('Address');?></li>
			<li class="tb <?php if($steps == 2): ?>highlight<?php endif; ?> <?php if($steps >= 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('General');?></li>
			<li class="tb <?php if($steps == 3): ?>highlight<?php endif; ?> <?php if($steps >= 3): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Price and terms');?></li>
			<li class="tb <?php if($steps == 4): ?>highlight<?php endif; ?> <?php if($steps >= 4): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Private Details');?></li>
			<li class="tb <?php if($steps == 5): ?>highlight<?php endif; ?> <?php if($steps >= 5): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Photos & Videos');?></li>
		</ul>
	<?php endif; ?>
	<?php echo $this->Form->create(null, array('class' => 'normal form-request add-property check-form js-geo-submit {is_required:"true"}', 'enctype' => 'multipart/form-data'));?>
		<div class="js-validation-part">
			<?php if($steps >= 1 ):  ?>
				<div <?php if($steps > 1): ?>class="hide"<?php endif;?>>
		<?php		if($this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
					<fieldset>

						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<h2><?php echo __l('Users'); ?></h2>
								<?php
									echo $this->Form->input('user_id', array('label' => __l('Users'),'empty'=>__l('Select')));
								?>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>

					</fieldset>
				<?php endif; ?>
				<fieldset>
					<div class="padd-bg-tl">
						<div class="padd-bg-tr">
							<div class="padd-bg-tmid"></div>
						</div>
					</div>
     <div class="padd-center">
						<h2><?php echo __l('Address'); ?></h2>
						 <div class="mapblock-info clearfix pr">
						 <div class="address-left-block grid_14 omega alpha">
							<div class="clearfix address-input-block">
								<?php
                        echo $this->Form->input('Property.address', array('label' => __l('Address'), 'id' => 'PropertyAddressSearch','info'=>'Address suggestion will be listed when you enter location.<br/>
(Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.)'));
                    ?>
							</div>
							<?php
								$class = '';
								if (empty($this->request->data['Property']['address']) || ( !empty($this->request->data['Property']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Property']['country_id']))) {
									$class = 'hide';
								}
							?>
							<div id="js-geo-fail-address-fill-block" class="<?php echo $class;?>">
								<div class="clearfix">
									<div class="grid_16 omega alpha map-address-left-block address-input-block">
							<?php
								echo $this->Form->input('Property.latitude', array('id' => 'latitude', 'type' => 'hidden'));
								echo $this->Form->input('Property.longitude', array('id' => 'longitude', 'type' => 'hidden'));
								echo $this->Form->input('Property.request_id', array('id' => 'request_id', 'type' => 'hidden'));
								echo $this->Form->input('Property.address1', array('id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
	                            echo $this->Form->input('Property.country_id',array('id' => 'js-country_id', 'empty' => __l('Please Select')));
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
							<!-- <div id="address-info sfont dl" class="hide"><?php echo __l('Please select correct address value'); ?></div> -->
							<div id="mapblock" class="pa">
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
					<div class="submit-block clearfix">
                         <?php
    						if($steps == 1):
    							echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step1]','class' => 'inactive-search','id' => 'js-sub',));
    						endif;
                         ?>
                    </div>
				<!--	<?php if($this->Auth->user('user_type_id') != ConstUserTypes::Admin): ?>
						<h2><?php echo __l('Process Flow'); ?></h2>
						<?php echo $this->element('property-guidelines', array('cache' => array('time' => Configure::read('site.element_cache')))); ?>
					<?php endif; ?>-->
				</div>
			<?php endif; ?>
			<?php if($steps >= 2 ):  ?>
				<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
					<?php if ($is_paypal_enabled): ?>
						<?php if (isset($this->request->data['UserProfile']['paypal_account']) || (isset($userProfile) && empty($userProfile['UserProfile']['paypal_account']))): ?>
							<fieldset>
								<div class="padd-bg-tl">
									<div class="padd-bg-tr">
										<div class="padd-bg-tmid"></div>
									</div>
								</div>
								<div class="padd-center">
									<p class="round-5"><?php echo __l('Email');?></p>
									<p class="page-information page-information1">
										<?php echo __l('If you do not have PayPal account,').' '.$this->Html->link(__l('click here'), array('controller' => 'payments', 'action' => 'create_paypal_account', 'admin' => false)).' '.__l('to create a PayPal account Instantly.'); ?>
									</p>
									<div class="input text">
										<?php echo $this->Form->input('UserProfile.paypal_account', array('label' => __l('PayPal Email')));
										echo $this->Form->input('UserProfile.id', array('type' => 'hidden', 'value' => !empty($userProfile['UserProfile']['id']) ? $userProfile['UserProfile']['id'] : ''));?>
									</div>
									<div class="input text">
										<?php echo $this->Form->input('UserProfile.paypal_first_name', array('label' => __l('PayPal First Name'), 'info' => __l('PayPal account first name for account verification')));?>
									</div>
									<div class="input text">
										<?php echo $this->Form->input('UserProfile.paypal_last_name', array('label' => __l('PayPal Last Name'), 'info' => __l('PayPal account last name for account verification')));?>
									</div>
								</div>
								<div class="padd-bg-bl">
									<div class="padd-bg-br">
										<div class="padd-bg-bmid"></div>
									</div>
								</div>
							</fieldset>
						<?php endif; ?>
					<?php endif; ?>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Listing location');?></p>
							<?php echo $this->Form->input('Property.title', array('label' => __l('Title'), 'class' => 'js-property-title {"count":"'.Configure::read('property.maximum_title_length').'"}'));  ?>
							<span class="character-info info"><?php echo __l('You have').' ';?><span id="js-property-title-count"></span><?php echo ' '.__l('characters left');?></span>
							<?php echo $this->Form->input('Property.description', array('label' => __l('Description'), 'class' => 'js-property-description {"count":"'.Configure::read('property.maximum_description_length').'"}')); ?>
							<span class="character-info info"><?php echo __l('You have') . ' ';?><span id="js-property-description-count"></span><?php echo ' ' . __l('characters left'); ?></span>
						<!-- campos harcode -->
							<?php echo $this->Form->input('Property.join_or_item_value', array('type'=>'hidden','value'=>'prop'));?>


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
							<p class="round-5"><?php echo __l('Features'); ?></p>
							<div class="bed-room-block">
                        	<?php
							echo $this->Form->input('Property.property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select'))); ?>
							</div>

							<div class="clearfix">
							<p class="round-5 add-info tb"><?php echo __l('Room Type'); ?></p>
							<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
							<div class="radio-tabs-rblock grid_left">

							<?php echo $this->Form->input('Property.room_type_id',array('type' => 'radio', 'legend' => false, 'id' => 'js-rooms', 'div' => 'js-radio-style', 'default' => $room_default)); ?>

                            </div>
                            </div>
                            </div>
                            <div class="bed-room-block">
                            <?php
							echo $this->Form->input('Property.bed_rooms',array('label' => __l('Bed Rooms'), 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $accomadation));
						  	echo $this->Form->input('Property.beds',array('label' => __l('Beds'), 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $accomadation));
                            ?>
                            </div>

                            <div class="clearfix">
                             <p class="round-5 add-info tb"><?php echo __l('Bed Type'); ?></p>
							<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
							<div class="radio-tabs-rblock grid_left">

                            <?php
                        	echo $this->Form->input('Property.bed_type_id', array('type' => 'radio', 'legend' => false, 'div' => 'js-radio-style pr', 'default' => $bed_default));
                            ?>


                            </div>
                            </div>
                            </div>
                              <div class="bed-room-block">
                            <?php
                            echo $this->Form->input('Property.bath_rooms', array('label' => __l('Bath Rooms'), 'options'=>$bathrroom));
							echo $this->Form->input('Property.accommodates', array('type' => 'select', 'label' => __l('Max number of guests'), 'empty' => __l('Please Select'), 'options' => $accomadation));?>

							<?php echo $this->Form->input('Property.size', array('label' => __l('Property Size')));
						?>
							</div>
						 <div class="clearfix">
                             <p class="round-5 add-info tb">&nbsp;</p>
							<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
							<div class="radio-tabs-rblock grid_left">
						<?php
							echo $this->Form->input('Property.measurement',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style pr','options'=>$moreMeasureActions,'default'=>1));
						?>
						</div>
						</div>
						</div>
						<?php
							echo $this->Form->input('Property.street_view',array('options' => $moreStreetActions,'div'=>'js-street-container input select'));
							echo $this->Form->input('Property.is_street_view',array('type' => 'hidden'));
							echo $this->Form->input('Property.is_pets',array('label'=>__l('Pets live on this property')));

							?>
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
						<div class="amenities-list">
							<p class="label-type"><?php echo __l('Amenities'); ?></p>
							<div class="checkbox-right clearfix">
								<?php echo $this->Form->input('Property.Amenity', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'Amenity1', 'label' => __l('Amenities'))); ?>
							</div>
							</div>
							<div class="amenities-list">
							<p class="label-type"><?php echo __l('Holiday Types'); ?></p>
							<div class="checkbox-right checkbox-bottom clearfix">
							<?php
								echo $this->Form->input('Property.HolidayType', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'label' =>'Holiday Types'));
							?>
							</div>
							</div>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>
					</fieldset>
					<div class="submit-block clearfix">
					<?php 	if($steps == 2):
								echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step2]'));
							endif; ?></div>
				</div>
			<?php endif; ?>
			<?php if($steps >= 3 ):  ?>
				<div <?php if($steps > 3 ): ?>class="hide"<?php endif;?>>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Price'); ?></p>
							<p class="page-information page-information1">
								<?php 	$currency_code = Configure::read('site.currency_id');?>
								<?php echo __l('Please mention your property price details in') . ' ' . $GLOBALS['currencies'][$currency_code]['Currency']['symbol'] . $GLOBALS['currencies'][$currency_code]['Currency']['code']; ?>
							</p>
							<?php
							$guest_limit = 20;
							for ($i = 1; $i <= $guest_limit; $i++) {
								$limits[$i] = $i;
							}
							$currency_code = Configure::read('site.currency_id');
							Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
							echo $this->Form->input('Property.price_per_night',array('label'=>__l('Price Per Night (') . Configure::read('site.currency') . ')'));
							echo $this->Form->input('Property.price_per_week',array('label'=>__l('Price Per Week (') . Configure::read('site.currency').__l(')')));
							echo $this->Form->input('Property.price_per_month',array('label'=>__l('Price Per Month (') . Configure::read('site.currency').__l(')')));
							// @todo "What goodies I want (Host)" ?>
							<div class="clearfix guest-price-block">
							<?php echo $this->Form->input('Property.additional_guest_price' ,array('label'=>__l('Additional Guest Price') . ' (' . Configure::read('site.currency') . ')')); ?>
							<span class="price-infor"><?php echo __l('per night for each additional guest after'); ?></span>
							<?php echo $this->Form->input('Property.additional_guest',array('label' => false, 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $limits)); ?>
							</div>

							<?php // @todo "Discount percentage"
         				    echo $this->Form->input('Property.is_negotiable', array('label' => __l('Negotiable pricing')));?>
							<span class="info"><?php echo  __l('If you enable negotiable then Traveler will contact you for negotiation'); ?></span>
							<?php
							if (Configure::read('property.is_enable_security_deposit')):
								echo $this->Form->input('Property.security_deposit' ,array('label' => __l('Security Deposit') . ' (' . Configure::read('site.currency') . ')', 'info' => __l('This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.')));
							endif;
							?>
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
							<p class="round-5"><?php echo __l('Terms'); ?></p>
							<?php
							echo $this->Form->input('Property.cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
							echo $this->Form->input('Property.minimum_nights',array('label' => __l('Minimum Nights'), 'type'=>'select','options'=>$minNights));
							echo $this->Form->input('Property.maximum_nights',array('label' => __l('Maximum Nights'), 'type'=>'select','options'=>$maxNights,'empty'=>__l('No Maximum')));
							echo $this->Form->input('Property.house_rules', array('label' => __l('House Rules')));
							?>
						<div class="clearfix checkin-checkout-block pr date-time-block">
							<div class="input date-time clearfix">
								<div <?php if($steps == 3 ): ?>class="js-time"<?php endif;?>>
									<?php
										echo $this->Form->input('Property.checkin', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check in')));
									?>
								</div>
							</div>

							<div class="input date-time end-date-time-block clearfix">
								<div <?php if($steps == 3 ): ?>class="js-time"<?php endif;?>>
									<?php
										echo $this->Form->input('Property.checkout', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check out')));
									?>
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
					<div class="submit-block clearfix">
                    <?php 	if($steps == 3):
								echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step3]'));
							endif; ?>
                    </div>
				</div>
			<?php endif; ?>
			<?php if($steps >= 4 ):  ?>
				<div <?php if($steps > 4 ): ?>class="hide"<?php endif;?>>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Private Details'); ?></p>
							<p class="page-information page-information1"><?php echo __l('Private details will be shown after booking request has been confirmed'); ?></p>
							<?php
								echo $this->Form->input('Property.house_manual',array('label' => __l('House Manual'), 'info' => __l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
								echo $this->Form->input('Property.phone', array('label' => __l('Phone')));
								echo $this->Form->input('Property.backup_phone', array('label' => __l('Backup Phone')));
	                            echo $this->Form->input('Property.location_manual', array('label' => __l('Location manual'), 'info' => __l(' Enter complete location details like landmark, complete address, zip code, access details, etc')));
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
                        if($steps == 4):
						  echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step4]'));
					    endif;   ?>
                    </div>
				</div>
			<?php endif; ?>
			<?php if($steps >= 5 ):  ?>
				<div <?php if($steps > 5 ): ?>class="hide"<?php endif;?>>
					<fieldset>
						<div class="padd-bg-tl">
							<div class="padd-bg-tr">
								<div class="padd-bg-tmid"></div>
							</div>
						</div>
						<div class="padd-center">
							<p class="round-5"><?php echo __l('Photos');?></p>
							<!-- @todo "Property image security" -->
							<p class="page-information page-information1">
							<?php
								$message = '';
								if (!Configure::read('property.is_enable_edit_property_image')):
									$message .= __l('Shared property images cannot be delete once uploaded. So please be sure about property images before complete this step.') . ' ';
								endif;
								$message .= __l('Photo caption allows only 255 characters.');
							?>
								<?php echo $message; ?>
							</p>
							<div class="picture">
								<ol class=" upload-list clearfix">
									<?php	for($i = 0; $i<Configure::read('properties.max_upload_photo'); $i++):  ?>
										<li class="dc">
											<div class="property-img dc pr"> <?php echo $this->Form->uploader('Attachment.'.$i.'.filename', array('id' =>'Attachment.'.$i.'.filename', 'type'=>'file', 'uPreview' => '1', 'uFilecount'=>1, 'uController'=> 'joinproperties', 'uId' => 'PropertyImage'.$i.'',  'uFiletype' => Configure::read('photo.file.allowedExt'))); ?>
												<span class="pa property-image-preview" id="preview_image<?php echo $i?>">
													<?php if(!empty($this->request->data['Attachment']) && !empty($this->request->data['Attachment'][$i]['filename'])) :?>
														<?php
															$thumb_url = Router::url(array(
															'controller' => 'joinproperties',
															'action' => 'thumbnail',
															session_id(),
															$this->request->data['Attachment'][$i]['filename'],
															'admin' => false
															) , true);
														?>
														<img src="<?php echo $thumb_url; ?>" /><input type="hidden" name="data[Attachment][<?php echo $i; ?>][filename]" value="<?php echo $this->request->data['Attachment'][$i]['filename']; ?>" /><a href="#" class="js-preview-close {id:<?php echo $i ?>}">&nbsp;</a>
													<?php endif; ?>
												</span>
											</div>
											<div class="js-overlabel">
												<?php  echo $this->Form->input('Property.Attachment.'.$i.'.description', array('type' => 'text', 'maxlength' => '255', 'label' => __l('Caption'))); ?>
											</div>
										</li>
									<?php
									endfor;
									?>
								</ol>

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
							<p class="round-5"><?php echo __l('Video');?></p>
								<?php echo $this->Form->input('Property.video_url',array('label' => __l('Video URL'),'info' => __l('You can post video URL from YouTube, Vimeo etc.'))); ?>
						</div>
						<div class="padd-bg-bl">
							<div class="padd-bg-br">
								<div class="padd-bg-bmid"></div>
							</div>
						</div>
					</fieldset>
					<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin) { ?>
						<fieldset>
							<div class="padd-bg-tl">
								<div class="padd-bg-tr">
									<div class="padd-bg-tmid"></div>
								</div>
							</div>
							<div class="padd-center">
								<p class="round-5"><?php echo __l('Admin Actions'); ?></p>
								<?php
								echo $this->Form->input('Property.is_featured', array('label' => __l('Featured')));
								echo $this->Form->input('Property.is_show_in_home_page', array('label' => __l('Show in home page')));
								?>
							</div>
							<div class="padd-bg-bl">
								<div class="padd-bg-br">
									<div class="padd-bg-bmid"></div>
								</div>
							</div>
						</fieldset>
					<?php } ?>
					<div class="submit-block clearfix">
						<?php if($steps == 5):
								echo $this->Form->input('privacy_id', array('type'=>'hidden','value'=>0));
								echo $this->Form->submit(__l('Finish'),array('name' => 'data[Property][step5]'));
							  endif; ?>
                    </div>
				</div>
			<?php endif; ?>
		</div>
	<?php echo $this->Form->end();?>
</div>
	<?php endif;?>
