<?php /* SVN: $Id: $ */ ?>
<div class="properties form js-responses">
<div class="clearfix">
		 <div class="cancel-block grid_left">
		<?php if(!empty($this->request->params['admin'])){
				echo $this->Html->link(__l('Back'), array('action' => 'index', 'admin' => true), array('title' => __l('Back')));
			}else{
				echo $this->Html->link(__l('Back'), array('action' => 'index', 'type' => 'myproperties', 'admin' => false), array('title' => __l('Back')));
			}?>
		</div>
		</div>

<?php echo $this->Form->create('Property', array('class' => 'normal check-form add-property {is_required:"false"}', 'enctype' => 'multipart/form-data'));?>
<div class="js-validation-part">
<fieldset>
	<div class="padd-bg-tl">
		<div class="padd-bg-tr">
			<div class="padd-bg-tmid"></div>
		</div>
	</div>
	<div class="padd-center">
		<p class="round-5"><?php echo __l('Address'); ?></p>
		<div class="mapblock-info clearfix pr">
			<div class="address-left-block grid_14 omega alpha">
				<div class="clearfix address-input-block">
					<?php echo $this->Form->input('address', array('label' => __l('Address'), 'id' => 'PropertyAddressSearch','info'=>'Address suggestion will be listed when you enter location.<br/>
(Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.)')); ?>
				</div>
				<?php
					$class = '';
					if (empty($this->request->data['Property']['address']) || (!empty($this->request->data['Property']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Property']['country_id']))) {
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
								echo $this->Form->input('Property.address1', array('id' => 'js-street_id','type' => 'text', 'label' => __l('Address')));
	                            echo $this->Form->input('Property.country_id',array('id' => 'js-country_id', 'empty' => __l('Please Select')));
								echo $this->Form->input('State.name', array('type' => 'text', 'label' => __l('State')));
								echo $this->Form->input('City.name', array('type' => 'text', 'label' => __l('City')));
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="grid_7 omega alpha grid_right">
				<h3><?php echo __l('Point Your Location');?></h3>
				<div class="js-side-map">
					<div id="js-map-container"></div>
					<span><?php echo __l('Point the exact location in map by dragging marker');?></span>
				</div>
			</div>
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
<fieldset>
  	 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
		<p class="round-5"><?php echo __l('General');?></p>
		<?php echo $this->Form->input('title', array('label' => __l('Title'), 'class' => 'js-property-title {"count":"'.Configure::read('property.maximum_title_length').'"}'));  ?>
		<span class="character-info info"><?php echo __l('You have').' ';?><span id="js-property-title-count"></span><?php echo ' '.__l('characters left');?></span>
		<?php echo $this->Form->input('description', array('label' => __l('Description'), 'class' => 'js-property-description {"count":"'.Configure::read('property.maximum_description_length').'"}')); ?>
		<span class="character-info info"><?php echo __l('You have') . ' ';?><span id="js-property-description-count"></span><?php echo ' ' . __l('characters left'); ?></span>
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
      <p class="round-5"><?php echo __l('Features');?></p>
	  <div class="bed-room-block">
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select'))); ?>
		</div>
		<div class="clearfix">
		<p class="round-5 add-info tb"><?php echo __l('Room Type'); ?></p>
		<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
		<div class="radio-tabs-rblock grid_left">
    		<?php
    		  echo $this->Form->input('room_type_id',array('type'=>'radio','id'=>'PropertyRoomID','legend'=>false,'div'=>'js-radio-style pr'));
    		?>
		 </div>
        </div>
        </div>
		<div class="bed-room-block">
		<?php
		echo $this->Form->input('bed_rooms',array('label' => __l('Bed Rooms'), 'type'=>'select', 'empty' => __l('Please Select'),'options'=>$accomadation));
		echo $this->Form->input('beds',array('label' => __l('Beds'), 'type'=>'select', 'empty' => __l('Please Select'),'options'=>$accomadation)); ?>
		</div>
		<div class="clearfix">
	       	<p class="round-5 add-info tb"><?php echo __l('Bed Type'); ?></p>
    		<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
        		<div class="radio-tabs-rblock grid_left">
            		<?php
            		echo $this->Form->input('bed_type_id',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style pr'));
                    ?>
                </div>
            </div>
        </div>
        <div class="bed-room-block">
        <?php
        echo $this->Form->input('bath_rooms',array('label' => __l('Bath Rooms'), 'type'=>'select','options'=>$bathrroom,'empty'=>' '));
		echo $this->Form->input('accommodates',array('type'=>'select','label'=>__l('Max number of guests'), 'empty' => __l('Please Select'), 'options'=>$accomadation));
		echo $this->Form->input('size');
						?>
		</div>
						 <div class="clearfix">
                             <p class="round-5 add-info tb">&nbsp;</p>
							<div class="not-required grid_left radio-tabs-lblock radio-tabs-lblock2">
							<div class="radio-tabs-rblock grid_left">
						<?php
							echo $this->Form->input('measurement',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style pr','options'=>$moreMeasureActions));
						?>
						</div>
						</div>
						</div>
		<?php
		
		echo $this->Form->input('street_view',array('options' => $moreStreetActions,'div'=>'js-street-container input select'));
		echo $this->Form->input('is_street_view',array('type' => 'hidden'));

		echo $this->Form->input('is_pets',array('label'=>__l('Pets live on this property')));?>

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
     <p class="round-5"><?php echo __l('Amenities');?></p>
	  <div class="amenities-list">
     <p class="label-type"><?php echo __l('Amenities');?></p>
            <div class="checkbox-right clearfix">
            <?php
            	echo $this->Form->input('Amenity', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'Amenity1', 'label' => __l('Amenities')));
                ?>
            </div>
            </div>
			<div class="amenities-list">
            <p class="label-type"><?php echo __l('Holiday Types'); ?></p>
            <div class="checkbox-right clearfix">
            <?php
        	echo $this->Form->input('HolidayType', array('type'=>'select','label'=>false, 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'label' =>'Holiday Types'));
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

	<fieldset>
	 <div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
      <p class="round-5"><?php echo __l('Price');?></p>
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
		echo $this->Form->input('price_per_night',array('label'=>__l('Price Per Night (').Configure::read('site.currency').__l(')')));
		echo $this->Form->input('price_per_week',array('label'=>__l('Price Per Week (').Configure::read('site.currency').__l(')')));
		echo $this->Form->input('price_per_month',array('label'=>__l('Price Per Month (').Configure::read('site.currency').__l(')')));
		// @todo "What goodies I want (Host)" ?>
		<div class="clearfix guest-price-block">
			<?php echo $this->Form->input('additional_guest_price' ,array('label' => __l('Additional Guest Price') . ' (' . Configure::read('site.currency') . ')'));  ?>
			<span class="price-infor"><?php echo __l('per night for each additional guest after'); ?></span>
			<?php echo $this->Form->input('additional_guest',array('label' => false, 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $limits)); ?>
		</div>
		
		<?php 
		// @todo "Discount percentage"
		echo $this->Form->input('is_negotiable', array('label' => __l('Negotiable pricing')));
		?>
		<span class="info"><?php echo  __l('If you enable negotiable then Traveler will contact you for negotiation'); ?></span>
		<?php
		if (Configure::read('property.is_enable_security_deposit')):
			echo $this->Form->input('security_deposit' ,array('label' => __l('Security Deposit') . ' (' . Configure::read('site.currency') . ')', 'info' => __l('This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.')));
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
      <p class="round-5"><?php echo __l('Terms');?></p>
         <?php
		echo $this->Form->input('cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
		echo $this->Form->input('minimum_nights',array('label' => __l('Minimum Nights'), 'type'=>'select','options'=>$minNights));
		echo $this->Form->input('maximum_nights',array('label' => __l('Maximum Nights'), 'type'=>'select','options'=>$maxNights,'empty'=>'No Maximum'));
		echo $this->Form->input('house_rules',array('label' => __l('House Rules')));
		?>
		<div class="clearfix checkin-checkout-block pr date-time-block">
							<div class="input date-time clearfix">
								<div class="js-time" >
									<?php
										echo $this->Form->input('checkin', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check in'), 'orderYear' => 'asc'));
									?>
								</div>
							</div>
					
							<div class="input date-time end-date-time-block clearfix">
								<div class="js-time" >
									<?php
										echo $this->Form->input('checkout', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check out'), 'orderYear' => 'asc'));
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
   		echo $this->Form->input('house_manual',array('label' => __l('House Manual'), 'info'=>__l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
		echo $this->Form->input('phone', array('label' => __l('Phone')));
		echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
		echo $this->Form->input('location_manual', array('label' => __l('Location manual'), 'info' => __l(' Enter complete location details like landmark, complete address, zip code, access details, etc')));
	?>
   	</div>
		 <div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
		</fieldset>
</div>
		 <fieldset>
		 	<div class="padd-bg-tl">
            <div class="padd-bg-tr">
            <div class="padd-bg-tmid"></div>
            </div>
        </div>
        <div class="padd-center">
        <p class="round-5"><?php echo __l('Photos');?></p>
<p class="page-information page-information1">
	<?php echo __l('Photo caption allows only 255 characters.'); ?>
</p>
	<div class="picture">
			<ol class=" upload-list clearfix">
		   <?php
		   for($i = 0; $i<Configure::read('properties.max_upload_photo'); $i++):  ?>
		   <li class="dc">
			<div class="property-img dc pr"> 
				<?php
				if(!empty($this->request->data['Attachment'][$i])):
					$old_attachment = '';
					if (!empty($this->request->data['Attachment'][$i]['filename'])):
						$old_attachment = (!empty($_SESSION['property_file_info'][$this->request->data['Attachment'][$i]['filename']])) ? '1' :'';
					endif;
					echo $this->Form->input('Attachment.'.$i.'.checked_id', array('value'=>$old_attachment, 'id' =>'old_attachment'.$i, 'type' => 'hidden', 'label' => false));
					echo $this->Form->input('Attachment.'.$i.'.id', array('type'=>'hidden', 'value' => !empty($this->request->data['Attachment'][$i]['id']) ? $this->request->data['Attachment'][$i]['id'] : ''));

				endif;				
				echo $this->Form->uploader('Attachment.'.$i.'.filename', array('id' =>'Attachment.'.$i.'.filename', 'type'=>'file', 'uPreview' => '1', 'uFilecount'=>1, 'uController'=> 'properties', 'uId' => 'PropertyImage'.$i.'',  'uFiletype' => Configure::read('photo.file.allowedExt')));
				echo $this->Form->input('ProductPhoto.'.$i.'.id', array('type' => 'hidden'));
				
				?>
			 <span class="pa property-image-preview" id="preview_image<?php echo $i?>">
			 <?php 				
				   $enable_close = 0;				   
				   if(!empty($this->request->data['Attachment'][$i]) && !empty($this->request->data['Attachment'][$i]['filename']) && !empty($_SESSION['property_file_info'][$this->request->data['Attachment'][$i]['filename']])):
					  $enable_close = 1;
					  $thumb_url = Router::url(array(
						'controller' => 'properties',
						'action' => 'thumbnail',
						 session_id(),
						 $this->request->data['Attachment'][$i]['filename'],
						'admin' => false
					) , true);
				   ?>
				   <img src="<?php echo $thumb_url; ?>" /><input type="hidden" name="data[Attachment][<?php echo $i; ?>][filename]" value="<?php echo $this->request->data['Attachment'][$i]['filename']; ?>" />
				   <?php
				   elseif(!empty($this->request->data['Attachment'][$i]) && !empty($this->request->data['Attachment'][$i]['id'])):
				    $enable_close = 1;
					 $product_photo_title  = (!empty($this->request->data['Attachment'][$i]['description'])) ? $this->request->data['Attachment'][$i]['description'] : $this->request->data['Property']['title'];
					echo $this->Html->showImage('Property', $this->request->data['Attachment'][$i], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($product_photo_title, false)), 'title' => $this->Html->cText($product_photo_title , false))); ?>
				<?php
					endif;
					// @todo "Property image security"
					if($enable_close){
					?>
					<?php if(Configure::read('property.is_enable_edit_property_image')) : ?>
					   <a href="#" class="js-preview-close {id:<?php echo $i ?>}">&nbsp;</a>
					<?php endif; ?>   
					<?php
					}				
				?>			
			</span></div>
			<div class="js-overlabel">
				<?php  echo $this->Form->input('Attachment.'.$i.'.description', array('type' => 'text', 'maxlength' => '255', 'label' => __l('Caption'))); ?>
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
								<?php echo $this->Form->input('video_url',array('label'=>__l('Video URL'),'info' => __l('You can post video URL from YouTube, Vimeo etc.'))); ?>
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
		if (Configure::read('property.is_property_verification_enabled')):
			echo $this->Form->input('is_verified', array('type' => 'checkbox', 'label' => __l('Verified')));
		endif;
		echo $this->Form->input('is_featured', array('label' => __l('Featured')));
		echo $this->Form->input('is_show_in_home_page', array('label' => __l('Show in home page')));
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
      <?php echo $this->Form->submit(__l('Update'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>