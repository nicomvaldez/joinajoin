<?php /* SVN: $Id: $ */ ?>
<div class="properties form js-responses">

<?php echo $this->Form->create('Property', array('class' => 'normal  add-property {is_required:"false"}', 'enctype' => 'multipart/form-data'));?>
<?php 
	$per_join = false;
	if(!empty($this->request->data['Property']['price_per_week'])){$per_join = true;}
?>
<div class="js-validation-part">
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


<?php
	
	if(!$isItem){ ?>

	<fieldset>
	  	 <div class="padd-bg-tl">
	        <div class="padd-bg-tr">
	        <div class="padd-bg-tmid"></div>
	        </div>
	    </div>
	    <div class="padd-center">
	      <p class="round-5"><?php echo __l('Features');?></p>
		<?php
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->input('property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select'))); 
		?>
			<div class="clearfix">
			<div class="not-required radio-tabs-lblock">
			<div class="radio-tabs-rblock">
	    		
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
<?php }else{
	echo $this->Form->input('id', array('type' => 'hidden'));
	echo $this->Form->input('property_type_id', array('type'=>'hidden', 'value'=>'16'));} 
?>





<fieldset>
    <div class="padd-bg-tl">
        <div class="padd-bg-tr">
            <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
        <p class="round-5"><?php echo __l('Availability'); ?></p>
        <p class="page-information page-information1"><?php echo __l('When are you available to give this experience?'); ?></p>
            
            <?php //dias 
                $options = array(1 => 'Mondays', 2 => 'Tuesdays', 3 => 'Wednesdays', 4 =>'Thursdays', 5 =>'Fridays', 6 =>'Saturdays', 0 => 'Sundays');
                $selected = $daysAvilable; // dejo la variable selected aunque podria colocar directamente $daysAvilable en el input
            ?>
            
            <?php //horas mientras llegan datos en el arreglo genero campos iden con tag para despues levantar desde javascript al crear los tabs
                if(!empty ($hoursAvilable)){
                    $d=0; 
                    foreach($hoursAvilable as $horas){ //el tag name es el dia de la semana 
                        echo "<input type='hidden' id='dia_".$horas[0]."' name='".$horas[0]."' value='".$horas[1]."'>"; //$horas es un arreglo       
                    $d++;
                    }//fin foreach
                }    //en if no emppty
            ?>
                

            <!--Solapas Tabs-->
       <div id="solapas">
            <ul>
                <li><a id="tabs1" href="#tabs-1"><?php echo $texto = ($isItem==false)?"Which day this Experience is available.":"Which day this Join-able is available."; ?></a></li>
                <li><a id="tabs2" href="#tabs-2">Select times for the days availables.</a></li>
            </ul>
            <div id="tabs-1"><div id="chekDiv"><?php echo $this->Form->input('Properties_day.days_texts' ,array('label'=>'','multiple' => 'checkbox', 'options' => $options, 'selected' => $selected,'class'=>'chkdias'));?></div></div>
               <?php 
               //$horas es un arreglo  
                    echo $this->Form->input('idhour', array('type' => 'hidden', 'value'=> $id_hour));
                    echo $this->Form->input('idday', array('type' => 'hidden', 'value'=> $id_day));
               ?>
            <div id="tabs-2">
                <div class="linea"><label><?php echo __l('Every day the same schedule?');?><input id="todosIgual" type="checkbox" <?php echo ($hoursAvilable[0][0]==9)?'checked="checked"':'';  ?>></label></div>
                <div id="contenido"></div>
            </div>
        </div>
        
       <div class="input text">
            <?php if(!$isItem){echo $this->Form->input('Properties_hour.duration', array('value'=>$duration,'label' => __l('Duration of Join'), 'info' => __l('describe the length of time join')));}else{echo $this->Form->input('Properties_hour.duration',array('type'=>'hidden', 'value'=>'0'));  }  ?>
       </div>

    </div>  
    <div class="padd-bg-bl">
        <div class="padd-bg-br">
            <div class="padd-bg-bmid"></div>
        </div>
    </div>  
</fieldset> 



<!-- voy a guardar el tipo de objeto, item o join para enviarlo al controler y poder preguntar -->
<?php
			echo $this->Form->input('Property.join_or_item_value',array('type'=>'hidden', 'value'=>$join_or_item_value));
?>




	<?php 
		if($isItem){
	?>
		<fieldset>
			<div class="padd-bg-tl">
				<div class="padd-bg-tr">
					<div class="padd-bg-tmid"></div>
				</div>
			</div>
			<div class="padd-center">
				<p class="round-5"><?php echo __l('Details about the Join-able'); ?></p>
            	<p class="page-information page-information1"><?php echo __l('Information about Join-able Condition.'); ?></p>
            
				<div class="input text">
                	<?php 
						echo $this->Form->input('Properties_extra_joinables.item_condition', array('label' => __l('Item Condition'), 'options'=>array('new'=>'New', 'good'=>'Good','fair'=>'Fair','other'=>'Other'), 'default' => $extra_item['Properties_extra_joinables']['item_condition'], 'empty' => '(choose one)'));
						echo $this->Form->input('Properties_extra_joinables.item_is_shipping', array('label' => __l('Can you send it?'), 'options'=>array('1'=>'Yes, is shippable.', '0'=>'Not, can not ship'),'default'=> $extra_item['Properties_extra_joinables']['item_is_shipping'] ,'empty' => '(choose one)'));
		    			echo $this->Form->input('maximum_nights',array('label' => __l('Quantity'), 'type'=>'select','options'=>$maxNights));
                	?>
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
				<p class="round-5"><?php echo __l('Join-able Price Details'); ?></p>
            	<p class="page-information page-information1"><?php echo __l('Tip: Is more attractive offer discounts for most time of rental.  (We recommend you set the daily price as 5% of the value of the item).'); ?></p>
            
				<div class="input text">
                	<?php 
                		echo $this->Form->input('Properties_extra_joinables.item_price_hour', array('label' => __l('Hourly'),'value'=>$extra_item['Properties_extra_joinables']['item_price_hour'] ,'class'=>'campo100' ,'info' => __l('Price per hour.')));
                		echo $this->Form->input('Properties_extra_joinables.item_price_day', array('label' => __l('Daily'),'value'=>$extra_item['Properties_extra_joinables']['item_price_day'], 'info' => __l('Price per day.')));
						echo $this->Form->input('Properties_extra_joinables.item_price_week', array('label' => __l('Weekly'), 'value'=>$extra_item['Properties_extra_joinables']['item_price_week'], 'info' => __l('Price per week.')));
                	?>
            	</div>	
				
				
			</div>
			<div class="padd-bg-bl">
				<div class="padd-bg-br">
					<div class="padd-bg-bmid"></div>
				</div>
			</div>
		</fieldset>
	<?php 
		}			
	?>	





<?php
if(!$isItem){
?>  	
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
		echo $this->Form->input('price_per_night',array('label'=>__l('Price (').Configure::read('site.currency').__l(')')));
		?>
        <div class="input checkbox"><!-- si quiero utilizar, tambien dispongo del estilo para id="radios_price" --> 
            <?php   
                //radio buttons
                $options=array('p'=>'Per Person','j'=>'Per Join');
                $attributes=array('id'=>'radioprice','legend'=>false,'default'=>($per_join)?'j':'p');
                echo $this->Form->radio('price_type',$options,$attributes);
            ?>   
        </div>
		<?php
		echo $this->Form->input('accommodates', array('type' => 'hidden', 'value' => '1'));
		
		// @todo "What goodies I want (Host)" ?>
		<div class="clearfix guest-price-block">
			<?php echo $this->Form->input('additional_guest_price' ,array('type' => 'hidden'));  ?>
		<!-- 	<span class="price-infor"><?php echo __l('per night for each additional guest after'); ?></span> -->
			<?php echo $this->Form->input('additional_guest',array('type' => 'hidden', 'value'=> '0')); ?>
		</div>
		
		<?php 
		// @todo "Discount percentage"
		echo $this->Form->input('is_negotiable', array('type' =>'hidden', 'value' =>false));
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
<?php
	}else{ ?>
		
		<?php		
			echo $this->Form->input('price_per_night',array('type'=>'hidden', 'value' => 0));
			echo $this->Form->input('accommodates', array('type' => 'hidden', 'value' => 1));
			echo $this->Form->input('additional_guest_price',array('type'=>'hidden', 'value' => 0));
			echo $this->Form->input('additional_guest',array('type'=>'hidden', 'value' => 0));
			echo $this->Form->input('is_negotiable', array('type' =>'hidden'));
			
			if (Configure::read('property.is_enable_security_deposit')):?>
				<fieldset>
				  	 <div class="padd-bg-tl">
				        <div class="padd-bg-tr">
				        <div class="padd-bg-tmid"></div>
				        </div>
				    </div>	
				    <div class="padd-center">
					<?php
						echo $this->Form->input('security_deposit' ,array('label' => __l('Security Deposit') . ' (' . Configure::read('site.currency') . ')', 'info' => __l('This deposit is for security purpose. When you raise any dispute with the guest, this amount may be used for compensation on any property damages. Note that site decision on this is final.')));
					?>	
					</div>
			    	<div class="padd-bg-bl">
			            <div class="padd-bg-br">
			            <div class="padd-bg-bmid"></div>
			            </div>
			        </div>
				</fieldset>
				<?php
			endif;	
	?>

	
<?php } ?>










<fieldset>
    <div class="padd-bg-tl">
        <div class="padd-bg-tr">
            <div class="padd-bg-tmid"></div>
		</div>
	</div>
		<div class="padd-center">
	    <p class="round-5"><?php echo __l('Terms'); ?></p>
			<?php
			echo $this->Form->input('checkin', array('type' => 'hidden', 'timeFormat' => 12, 'label' => __l('Check in'), 'orderYear' => 'asc'));
			echo $this->Form->input('checkout', array('type' => 'hidden', 'timeFormat' => 12, 'label' => __l('Check out'), 'orderYear' => 'asc'));
			
			echo $this->Form->input('cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
			
						
			if(!$isItem){
				echo $this->Form->input('minimum_nights',array('label' => __l('Minimum Nights'), 'type'=>'select','options'=>$minNights));
				echo $this->Form->input('maximum_nights',array('label' => __l('Maximum Nights'), 'type'=>'select','options'=>$maxNights,'empty'=>__l('No Maximum')));
				$text_specific = $house_rules;
				echo $this->Form->input('house_rules', array('label' => __l('House Rules'),'class'=>'vacio ','value'=>$text_specific));
			}else{
				echo $this->Form->input('minimum_nights',array('type'=>'hidden','value'=>1));
				($this->request->data['Property']['house_rules'] == '')?$text_specific='Something Specific you want to share with your Join Seeker.': $text_specific = $this->request->data['Property']['house_rules'];
				echo $this->Form->input('house_rules', array('label' => __l('Join-able Specifics'),'class'=>'vacio default','value'=>$text_specific));	
			}
			
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
        <p class="round-5"><?php echo __l('Private Details'); ?></p>
		<p class="page-information page-information1"><?php echo __l('Private details will be shown after booking request has been confirmed'); ?></p>
		<?php
		if(!$isItem){
			$text_description = $house_manual; 
            echo $this->Form->input('house_manual',array('label' => __l('Join Manual'),'class'=>'vacio','value'=>$text_description, 'msn'=>$text_description, 'info' => __l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
            echo $this->Form->input('phone', array('label' => __l('Phone')));
            echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
            //echo $this->Form->input('location_manual', array('label' => __l('Location manual'), 'info' => __l(' Enter complete location details like landmark, complete address, zip code, access details, etc')));
		}else{
		    echo $this->Form->input('phone', array('label' => __l('Phone')));
            echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
			echo $this->Form->input('house_manual', array('type' => 'hidden'));
		}
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
		   <li>
			<div class="property-img"> 
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
			 <span class="property-image-preview" id="preview_image<?php echo $i?>">
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
					   <a href="#" class="js-preview-close {id:<?php echo $i ?>}">&nbsp;</a>
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