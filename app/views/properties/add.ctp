<?php /* SVN: $Id: $ */ ?>
<div class="properties properties-add form js-responses">
	
	<?php 
		$isItem = false;
		if($this->request->data['Property']['join_or_item_value'] == 'item'){$isItem = true;}
	?>
	
<?php
    if(!empty($this->request->data['Property']['request_id']) && (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0]=='request')){
	   echo $this->element('property-index', array('config' => 'sec', 'type' => 'property', 'request_id' => $this->request->data['Property']['request_id'], 'request_latitude' => $this->request->data['Property']['request_latitude'], 'request_longitude' => $this->request->data['Property']['request_longitude']));
    }

    if(!empty($this->request->data['Property']['request_id']) && (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0]=='request')):
        echo $this->Html->link(__l('List your property'),  array('controller' => 'properties', 'action' => 'add'), array('title' => __l('List your property')));?><?php  else: 
?>
	
<div class="clearfix">
    <?php if (empty($this->request->params['prefix'])): ?>
		<h2 class="list-property grid_left"> <?php echo __l('List your property');?> </h2>
    <?php endif; ?>
	
	<p class="import-property grid_right">
		<?php //echo $this->Html->link(__l('Import Properties'), array('controller' => 'properties', 'action' => 'import', 'admin' => false), array('class' => 'import-properties','title' => __l('Import Properties')));?>
	</p>
</div>


<?php if($steps <= 8):  ?>
	<!--    <ul id="stage" class="stage tab-link clearfix">
			<li class="<?php if($steps == 1): ?>highlight<?php endif; ?> <?php if($steps >= 1): ?>active<?php endif; ?>"><?php echo __l('Address');?></li>
			<li class="<?php if($steps == 2): ?>highlight<?php endif; ?> <?php if($steps >= 2): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('General');?></li>
			<li class="<?php if($steps == 3): ?>highlight<?php endif; ?> <?php if($steps >= 3): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Terms & Private Details');?></li>
			<li class="<?php if($steps == 4): ?>highlight<?php endif; ?> <?php if($steps >= 4): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Private Details');?></li>
			<li class="<?php if($steps == 5): ?>highlight<?php endif; ?> <?php if($steps >= 5): ?>active<?php else: ?>inactive<?php endif; ?>"><?php echo __l('Photos & Videos');?></li>
	       	</ul> -->
<?php endif; ?>

<?php echo $this->Form->create('Property', array('class' => 'normal add-property js-geo-submit {is_required:"true"}', 'enctype' => 'multipart/form-data'));?>
<div class="js-validation-part">
        <?php if($steps >= 1 ):  ?>
    <div <?php if($steps > 1): ?>class="hide"<?php endif;?>>
        <?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
        
    <fieldset>
    		<div class="padd-bg-tl">
    			<div class="padd-bg-tr">
    				<div class="padd-bg-tmid"></div>
                </div>
			</div>
			
            <div class="padd-center">
			     <p class="round-5"><?php echo __l('Users'); ?></p>
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
            <p class="round-5"><?php echo __l('Basic Information'); //'Basic Information'; // __l('Address')  ?></p>
<!-- ****************************   BLOQUE 1 CONTENEDOR   ****************************************-->            
                <div class="mapblock-info clearfix">
				    <div class="address-left-block grid_14 omega alpha">
					   <div class="clearfix address-input-block required">
    						<?php echo $this->Form->input('address', array('label' => __l('Location / City'), 'id' => 'PropertyAddressSearch','info'=>'Address suggestion will be listed when you enter location.<br/> ')); //(Note: If address entered is not exact/incomplete, you will be prompted to fill the missing address fields.) ?> 
    						<?php
    								$class = '';
    								if (empty($this->request->data['Property']['address']) || ( !empty($this->request->data['Property']['address1']) && !empty($this->request->data['City']['name']) &&  !empty($this->request->data['Property']['country_id']))) {
    									$class = 'hide';
    								}
                             ?>
                                
                            <div>
                                <?php 
                                    echo $this->Form->input('title', array('label' => __l('Title'), 'class' => 'js-property-title {"count":"'.Configure::read('property.maximum_title_length').'"}'));  ?>
                                    <span class="character-info info"><?php echo __l('You have').' ';?><span id="js-property-title-count"></span><?php echo ' '.__l('characters left');?></span>   
                            </div>
                        </div>     

                        <div id="js-geo-fail-address-fill-block" class="<?php echo $class;?>">
                            <div class="clearfix">
                                <div class="grid_16 omega alpha map-address-left-block address-input-block">
            							<?php
            								echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => 'hidden'));
            								echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => 'hidden'));
            								echo $this->Form->input('request_id', array('id' => 'request_id', 'type' => 'hidden'));
                                        ?>
                                            <p class="page-information page-information1" style="width: 525px;">
                                                In what city the will the Join be provided?
                                            </p>
                                        <?php
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
                        <!-- <h3><?php echo __l('Point Your Location');?></h3> -->
                            <div class="js-side-map">
                                <div id="js-map-container"></div>
								   <!-- <span><?php echo __l('Point the exact location in map by dragging marker');?></span> -->
							</div>
				    </div>
                    <!-- <div id="address-info" class="hide"><?php echo __l('Please select correct address value'); ?></div> -->
					<div id="mapblock">
                        <div id="mapframe">
                            <div id="mapwindow"></div>
						</div>
					</div>
				</div>
				
<!-- ****************************   BLOQUE 1 CONTENEDOR FIN ****************************************-->  				
		</div>
		<div class="padd-bg-bl">
            <div class="padd-bg-br">
			    <div class="padd-bg-bmid"></div>
			</div>
		</div>
	</fieldset>
             
             
<!-- *********************** // nueva funcion para join-ables -->                               
<!--   
    <fieldset>
        <div class="padd-bg-tl">
            <div class="padd-bg-tr">
                <div class="padd-bg-tmid"></div>
			</div>
		</div>
		
		<div class="padd-center">
            <p class="round-5"><?php echo __l('Select Join Type'); ?></p>
			<p class="page-information page-information1">Here you can choose which type of join will share. 
			</p>			

       <div class="input checkbox" style="margin-left: -120px;"><!-- si quiero utilizar, tambien dispongo del estilo para id="radios_price" --> 
            <?php   
                //radio buttons
                //$options=array('join'=>'Add an Adventure or Experience (Join)','item'=>'Add an Item (Join-able)');
               // $attributes=array('id'=>'joinOrItem','legend'=>false,'default'=>'join');
                //echo $this->Form->radio('join_or_item_value',$options,$attributes);
               echo $this->Form->input('join_or_item_value', array('type'=>'hidden', 'value'=>'join'));
            ?>   
 <!--       </div>
		
        </div>
    	<div class="padd-bg-bl">
            <div class="padd-bg-br">
                <div class="padd-bg-bmid"></div>
    		</div>
    	</div>	
	</fieldset>		
-->		
<!-- ************************* // end form joinables -->
		
		
<div id="fieldset-price">	
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
    				// PRECIO
    				//$currency_code = Configure::read('site.currency_id');
    				//Configure::write('site.currency', $GLOBALS['currencies'][$currency_code]['Currency']['symbol']);
    				echo $this->Form->input('price_per_night',array('label'=>'Price'));
                ?>
                <div class="input checkbox"><!-- si quiero utilizar, tambien dispongo del estilo para id="radios_price" --> 
                    <?php   
                        //radio buttons
                        $options=array('p'=>'Per Person','j'=>'Per Join');
                        $attributes=array('id'=>'radioprice','legend'=>false,'default'=>'p');
                        echo $this->Form->radio('price_type',$options,$attributes);
                    ?>   
                </div>
               	<?php
				//echo $this->Form->input('price_per_week',array('label'=>__l('Price Per Week (') . Configure::read('site.currency').__l(')')));
                //echo $this->Form->input('price_per_month',array('label'=>__l('Price Per Month (') . Configure::read('site.currency').__l(')')));
                
                //@todo "What goodies I want (Host)" ?>
                                                        
       <!--    reemplazo los campos seleccionables por fijos ocultos
        <div class="clearfix guest-price-block">
            <?php echo $this->Form->input('additional_guest_price' ,array('label'=>__l('Additional Guest Price') . ' (' . Configure::read('site.currency') . ')')); ?>	
			<span class="price-infor"><?php echo __l('per night for each additional guest after'); ?></span>
			<?php echo $this->Form->input('additional_guest',array('label' => false, 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $limits)); ?>
		</div>
		-->
		<?php echo $this->Form->input('additional_guest_price' ,array('type'=> 'hidden')); ?>
		<?php echo $this->Form->input('additional_guest' ,array('type'=> 'hidden')); ?>
		
		
							
		<?php // @todo "Discount percentage"
            //echo $this->Form->input('is_negotiable', array('label' => __l('Negotiable pricing')));
            echo $this->Form->input('is_negotiable', array('type'=>'hidden'));
       	?> 
		<!-- <span class="info"><?php echo  __l('If you enable negotiable then Traveler will contact you for negotiation'); ?></span> -->
		
		

        </div>
    	<div class="padd-bg-bl">
            <div class="padd-bg-br">
                <div class="padd-bg-bmid"></div>
    		</div>
    	</div>	
	</fieldset>
</div><!-- fin funcion ocultar fieldset -->	
<!-- ****************************   BLOQUE 2 CONTENEDOR FIN ****************************************-->





<?php
	if (Configure::read('property.is_enable_security_deposit')):
?>
    <fieldset>
        <div class="padd-bg-tl">
            <div class="padd-bg-tr">
                <div class="padd-bg-tmid"></div>
			</div>
		</div>
		<div class="padd-center">
            <p class="round-5"><?php echo __l('Secure Deposit'); ?></p>	
            <p class="page-information page-information1">Enter here the amount you wish to order as a security deposit.</p>
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







        <div class="submit-block clearfix">
         <?php
        	if($steps == 1):
        		echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step1]','class' => 'inactive-search','id' => 'js-sub',));
        	endif;
         ?>
        </div>
        <!--
            
            <?php if($this->Auth->user('user_type_id') != ConstUserTypes::Admin): ?>
        	<h2><?php echo __l('Process Flow'); ?></h2>
        	<?php echo $this->element('property-guidelines', array('cache' => array('time' => Configure::read('site.element_cache')))); ?>
        	<?php endif; ?>
        -->    
    </div>
			<?php endif; ?>
			<?php if($steps >= 2 ):  ?>
	<div <?php if($steps > 2): ?>class="hide"<?php endif;?>>
		<?php if ($is_paypal_enabled): ?>
			
			<?php  if (isset($this->request->data['UserProfile']['paypal_account']) || (isset($userProfile))): ?> <!--&& empty($userProfile['UserProfile']['paypal_account'])-->
				
    
        
     <!--       
            <fieldset>
                <div class="padd-bg-tl">
                    <div class="padd-bg-tr">
                        <div class="padd-bg-tmid"></div>
                    </div>
                </div>
                                                    
                <div class="padd-center">
                    <p class="round-5"><?php echo __l('Features'); ?></p>
                    <?php
                        echo $this->Form->input('property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select'))); 
                    ?>
   -->                                                            
                <input type="hidden" name="data[Property][room_type_id]" value="3"/>
                <input type="hidden" name="data[Property][bed_rooms]" value="1"/>
                <input type="hidden" name="data[Property][beds]" value="1"/>
                <input type="hidden" name="data[Property][bed_type_id]" value="1"/>
                <input type="hidden" name="data[Property][bath_rooms]" value="1"/>
                <input type="hidden" name="data[Property][accommodates]" value="1"/>
                <input type="hidden" name="data[Property][size]" value="1"/>
                <input type="hidden" name="data[Property][measurement]" value="1"/>
                <input type="hidden" name="data[Property][street_view]" value="1"/>
                <input type="hidden" name="data[Property][is_street_view]" />
                <input type="hidden" name="data[Property][is_pets]" value="0"/>
                <input type="hidden" name="data[Amenity][Amenity]" value=""/>
                <input type="hidden" name="data[HolidayType][HolidayType]" value=""/>
                
                
                <!-- Grace Basilio :: 23-02-2012 - Let's hide this sucker -->
                <!--
                                    <div class="clearfix">
                                    <p class="round-5 add-info"><?php echo __l('Room Type'); ?></p>
                                    <div class="not-required radio-tabs-lblock">
                                    <div class="radio-tabs-rblock">
                                                                
                                    <?php echo $this->Form->input('room_type_id',array('type' => 'radio', 'legend' => false, 'id' => 'js-rooms', 'div' => 'js-radio-style', 'default' => $room_default)); ?>
                                   
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                    echo $this->Form->input('bed_rooms',array('label' => __l('Bed Rooms'), 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $accomadation));
                                    echo $this->Form->input('beds',array('label' => __l('Beds'), 'type' => 'select', 'empty' => __l('Please Select'), 'options' => $accomadation));
                                    ?>
                                     
                                    <div class="clearfix">
                                     <p class="round-5 add-info"><?php echo __l('Bed Type'); ?></p>
                                    <div class="not-required radio-tabs-lblock">
                                    <div class="radio-tabs-rblock">
                                  
                                    <?php
                                    echo $this->Form->input('bed_type_id', array('type' => 'radio', 'legend' => false, 'div' => 'js-radio-style', 'default' => $bed_default));
                                    ?>
                                  
                               
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                    echo $this->Form->input('bath_rooms', array('label' => __l('Bath Rooms'), 'options'=>$bathrroom));
                                    echo $this->Form->input('accommodates', array('type' => 'select', 'label' => __l('Max number of guests'), 'empty' => __l('Please Select'), 'options' => $accomadation));
                                    echo $this->Form->input('size', array('label' => __l('Property Size')));
                                ?>
                                 <div class="clearfix">
                                     <p class="round-5 add-info">&nbsp;</p>
                                    <div class="not-required radio-tabs-lblock">
                                    <div class="radio-tabs-rblock">
                                <?php
                                    echo $this->Form->input('measurement',array('type'=>'radio','legend'=>false,'div'=>'js-radio-style','options'=>$moreMeasureActions,'default'=>1));
                                ?>
                                </div>
                                </div>
                                </div>
                                <?php
                                    echo $this->Form->input('street_view',array('options' => $moreStreetActions,'div'=>'js-street-container input select'));
                                    echo $this->Form->input('is_street_view',array('type' => 'hidden'));
                                    echo $this->Form->input('is_pets',array('label'=>__l('Pets live on this property')));
        
                                    ?>
                -->
                <!-- Grace Basilio :: 23-02-2012 - Let's hide this sucker -->
                </div>
     <!--                                        
                <div class="padd-bg-bl">
                    <div class="padd-bg-br">
                        <div class="padd-bg-bmid"></div>
                    </div>
                </div>
            </fieldset>
    
-->

		
		
			  <fieldset>
		            <div class="padd-bg-tl">
		                <div class="padd-bg-tr">
		                    <div class="padd-bg-tmid"></div>
		                </div>
		            </div>
		            <div class="padd-center">
		                <p class="round-5"><?php echo __l('General');?></p>
		                    <span class="moreinfo">Title: <h4><?php echo $this->data['Property']['title']; ?></h4></span>
		                        <?php // echo $this->Form->input('title', array('label' => __l('Title'), 'class' => 'js-property-title {"count":"'.Configure::read('property.maximum_title_length').'"}'));  ?>
		                        <?php 
		                            if($isItem){
		                            	echo $this->Form->input('property_type_id', array('type'=>'hidden', 'value'=>'16'));	
		                            }else{
										echo $this->Form->input('property_type_id', array('label' => __l('Property Type'), 'empty' => __l('Please Select')));
									}	
		                       	?>
		
		                        <!-- <span class="character-info info"><?php echo __l('You have').' ';?><span id="js-property-title-count"></span><?php echo ' '.__l('characters left');?></span> -->
		                        <?php $text_description = ($isItem==false)?'What will people be doing? Provide a brief itinerary if possible. Make sure to include all important information & details about the experience. You can always edit this later':'Describe any important detail about your Join-able such as its condition, when it was bought, how many times it has been used, etc...'; ?>
		                        <?php echo $this->Form->input('description', array('label' => __l('Description'),'value' => $text_description, 'class' => 'default vacio js-property-description {"count":"2000"}', 'msn'=>$text_description)); ?>
		                        <!-- <?php echo $this->Form->input('description', array('label' => __l('Description'), 'class' => 'js-property-description {"count":"'.Configure::read('property.maximum_description_length').'"}')); ?> -->
		                    <span class="character-info info"><?php echo __l('You have') . ' ';?><span id="js-property-description-count"></span><?php echo ' ' . __l('characters left'); ?></span>
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
            <p class="round-5"><?php echo __l('Availability'); ?></p>
            <p class="page-information page-information1"><?php echo ($isItem == false)? __l('When are you available to give this experience?'): __l('Choose the dates this joinable would be available.'); ?></p>
                <?php 
                	$options = array(1 => 'Mondays', 2 => 'Tuesdays', 3 => 'Wednesdays', 4 =>'Thursdays', 5 =>'Fridays', 6 =>'Saturdays', 0 => 'Sundays');
                	$selected = array(1,2,3,4,5,6,0);
                ?>

            <!--Solapas Tabs-->
           <div id="solapas">
                <ul>
                    <li><a id="tabs1" href="#tabs-1"><?php echo $texto = ($isItem==false)?"Which day this Experience is available.":"Which day this Join-able is available."; ?></a></li>
                    <li><a id="tabs2" href="#tabs-2">Select times for the days availables.</a></li>
                </ul>
                <div id="tabs-1"><div id="chekDiv"><?php echo $this->Form->input('Properties_day.days_texts' ,array('label'=>'','multiple' => 'checkbox', 'options' => $options, 'selected' => $selected,'class'=>'chkdias'));?></div></div>
                <div id="tabs-2">
                    <div class="linea"><label><?php echo __l('Every day the same schedule?');?><input id="todosIgual" type="checkbox"></label></div>
                    <?php echo $this->element('hours'); ?>
                    <?php echo $this->Form->input('PropertyPlaza.horas', array('type'=>'hidden', 'id'=>'fullArreglo')); ?>	
                    <div id="contenido"></div>
                </div>
            </div>
            
           <div class="input text">
                <?php if(!$isItem){echo $this->Form->input('Properties_hour.duration', array('label' => __l('Duration of Join'), 'info' => __l('describe the length of time join')));}else{echo $this->Form->input('Properties_hour.duration',array('type'=>'hidden', 'value'=>'0'));  }  ?>
                <?php echo $this->Form->input('PropertyPlaza.plazas', array('type'=>'text', 'id'=>'plazasCant', 'label'=>'Spaces Available')); ?>	
                
           </div>

        </div>  
        <div class="padd-bg-bl">
            <div class="padd-bg-br">
                <div class="padd-bg-bmid"></div>
            </div>
        </div>  
    </fieldset> 
    
    

<!-- //************************************** EXCLUSIVE ITEMS AREA *************************************// -->	
	
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
						echo $this->Form->input('Properties_extra_joinables.item_condition', array('label' => __l('Item Condition'), 'options'=>array('new'=>'New', 'good'=>'Good','fair'=>'Fair','other'=>'Other'), 'empty' => '(choose one)'));
						echo $this->Form->input('Properties_extra_joinables.item_is_shipping', array('label' => __l('Can you send it?'), 'options'=>array('1'=>'Yes, is shippable.', '0'=>'Not, can not ship'), 'empty' => '(choose one)'));
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
                		echo $this->Form->input('Properties_extra_joinables.item_price_hour', array('label' => __l('Hourly'),'class'=>'campo100' ,'info' => __l('Price per hour.')));
                		echo $this->Form->input('Properties_extra_joinables.item_price_day', array('label' => __l('Daily'), 'info' => __l('Price per day.')));
						echo $this->Form->input('Properties_extra_joinables.item_price_week', array('label' => __l('Weekly'), 'info' => __l('Price per week.')));
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
	
                                 
    <fieldset>
        <div class="padd-bg-tl">
            <div class="padd-bg-tr">
                <div class="padd-bg-tmid"></div>
			</div>
		</div>
		<div class="padd-center">
            <p class="round-5"><?php echo __l('Terms'); ?></p>
    			<?php
    			echo $this->Form->input('cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
    			
    			if(!$isItem){
	    			echo $this->Form->input('minimum_nights',array('label' => __l('Minimum Participants'), 'type'=>'select','options'=>$minNights));
	    			echo $this->Form->input('maximum_nights',array('label' => __l('Maximum Participants'), 'type'=>'select','options'=>$maxNights,'empty'=>__l('No Maximum')));
	    			$text_specific='Special Instruction and/or Restrictions such as bring snacks, warm clothes, coat, sunscreen, if there is a minimum/maximum in weight, height and age. Should be relatively physically fit, must be able to walk and run etc etc';
	    			echo $this->Form->input('house_rules', array('label' => __l('Join Rules'),'class'=>'vacio default','value'=>$text_specific));
				}else{
					echo $this->Form->input('minimum_nights',array('type'=>'hidden','value'=>1));
	    			$text_specific='Something Specific you want to share with your Join Seeker.';
	    			echo $this->Form->input('house_rules', array('label' => __l('Join-able Specifics'),'class'=>'vacio default','value'=>$text_specific));	
				}
    			
    			?>
            <div class="clearfix checkin-checkout-block date-time-block">
                <div class="input date-time clearfix">                                                            
                    <div <?php if($steps == 2 ): ?>class="js-time"<?php endif;?>>
    				    <?php
                            //echo $this->Form->input('checkin', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check in')));
    					?>
    				</div>
    			</div>
    					
    			<div class="input date-time end-date-time-block clearfix">                                                            
                    <div <?php if($steps == 2 ): ?>class="js-time"<?php endif;?>>
    				    <?php
    					   //echo $this->Form->input('checkout', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check out')));
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
			if(!$isItem){
				$text_description = 'Meeting point - only Join Seekers who have booked your Join will see the exact location. Remember to include the exact address, time & any additional description below if necessary.'; 
                echo $this->Form->input('house_manual',array('label' => __l('House Manual'),'class'=>'default vacio','value'=>$text_description, 'msn'=>$text_description, 'info' => __l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
                echo $this->Form->input('phone', array('label' => __l('Phone')));
                echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
                //echo $this->Form->input('location_manual', array('label' => __l('Location manual'), 'info' => __l(' Enter complete location details like landmark, complete address, zip code, access details, etc')));
			}else{
			    echo $this->Form->input('phone', array('label' => __l('Phone')));
                echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
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
            <p class="round-5"><?php echo __l('Photos');?></p>
			<!-- @todo "Property image security" -->

			
			
			<div class="condition-block1">
				<div class="properties-tl">
					<div class="properties-tr">
						<div class="properties-tm"> </div>
					</div>
				</div>
				<div class="properties-middle-block clearfix">
					<h3><?php echo __l('Upload your photos - 1 photos minimum.'); ?></h3>
					<dt><?php echo __l('Photo caption allows only 255 characters.'); ?></dt>
				</div>
				<div class="properties-bl">
					<div class="properties-br">
						<div class="properties-bm"> </div>
					</div>
				</div>
			</div>
			

            <div class="picture">
                <ol class=" upload-list clearfix">
				    <?php	
				    for($i = 0; $i<Configure::read('properties.max_upload_photo'); $i++):  ?>
    					<li>
                            <div class="property-img"> <?php echo $this->Form->uploader('Attachment.'.$i.'.filename', array('id' =>'Attachment.'.$i.'.filename', 'type'=>'file', 'uPreview' => '1', 'uFilecount'=>1, 'uController'=> 'joinproperties', 'uId' => 'PropertyImage'.$i.'',  'uFiletype' => Configure::read('photo.file.allowedExt'))); ?> 
                                <span class="property-image-preview" id="preview_image<?php echo $i?>">
        							<?php if(!empty($this->request->data['Attachment']) && !empty($this->request->data['Attachment'][$i]['filename'])) :?>
        							<?php
        								$thumb_url = Router::url(array(
        								'controller' => 'properties',
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
                <?php echo $this->Form->input('video_url',array('label' => __l('Video URL'),'info' => __l('You can post video URL from YouTube, Vimeo etc.'))); ?>
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
			<p class="round-5"><?php echo __l('PayPal Information');?></p>
	        <p class="page-information page-information1">
	            Since Join a Join pays through paypal it will be helpful for you to Provide your Paypal information.
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
                                    
        <!-- Grace Basilio :: 23-02-2012 - Let's hide this sucker -->
        <!--
	<fieldset>
    	<div class="padd-bg-tl">
    		<div class="padd-bg-tr">
    			<div class="padd-bg-tmid"></div>
    		</div>
    	</div>

    	<div class="padd-center">
        	<div class="amenities-list">
        		<span class="checkbox-label"><?php echo __l('Amenities'); ?></span>
            		<div class="checkbox-right clearfix">
            			<?php echo $this->Form->input('Amenity', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'Amenity1', 'label' => __l('Amenities'))); ?>
            		</div>
        	</div>
        	<div class="amenities-list">
        	   <span class="checkbox-label"><?php echo __l('Holiday Types'); ?></span>
        		  <div class="checkbox-right checkbox-bottom clearfix">
        		      <?php
        			     echo $this->Form->input('HolidayType', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'HolidayType1', 'label' =>'Holiday Types'));					
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
    -->
    <!-- Grace Basilio :: 23-02-2012 - Let's hide this sucker -->
		<div class="submit-block clearfix">
            <?php 	if($steps == 2):
                        echo $this->Form->submit(__l('Finish'),array('name' => 'data[Property][step5]','id'=>'finish'));
				    endif; ?>
		</div>
                    	<!-- </div> -->
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
            <p class="round-5"><?php echo __l('Terms'); ?></p>
                <?php
				echo $this->Form->input('cancellation_policy_id', array('label' => __l('Cancellation Policy'), 'empty' => __l('Please Select')));
				echo $this->Form->input('minimum_nights',array('label' => __l('Minimum Nights'), 'type'=>'select','options'=>$minNights));
				echo $this->Form->input('maximum_nights',array('label' => __l('Maximum Nights'), 'type'=>'select','options'=>$maxNights,'empty'=>__l('No Maximum')));
				echo $this->Form->input('house_rules', array('label' => __l('House Rules')));
				?>
                <div class="clearfix checkin-checkout-block date-time-block">
                    <div class="input date-time clearfix">
								<!-- Check In <select name="data[Property][checkin][hour]">
                                                                    <? for ($i=1; $i<13; $i++) : ?>
                                                                    <option value="<?= $i < 10 ? "0" . $i : $i; ?>"><?= $i < 10 ? "0" . $i : $i; ?></option>
                                                                    <? endfor; ?>
                                                                </select>

                                                                <select name="data[Property][checkin][min]">
                                                                    <? for ($i=0; $i<60; $i++) : ?>
                                                                    <option value="<?= $i < 10 ? "0" . $i : $i; ?>"><?= $i < 10 ? "0" . $i : $i; ?></option>
                                                                    <? endfor; ?>
                                                                </select>

                                                                <select name="data[Property][checkin][meridian]">
                                                                    <option value="am">am</option>
                                                                    <option value="pm">pm</option>
                                                                </select> -->
                                                            
                        <div <?php if($steps == 3 ): ?>class="js-time"<?php endif;?>>
						  <?php echo $this->Form->input('checkin', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check in')));?>
						</div>
					</div>
					
                    <div class="input date-time end-date-time-block clearfix">
                                                           <!-- Check Out <select name="data[Property][checkout][hour]">
                                                                <? for ($i=1; $i<13; $i++) : ?>
                                                                <option value="<?= $i < 10 ? "0" . $i : $i; ?>"><?= $i < 10 ? "0" . $i : $i; ?></option>
                                                                <? endfor; ?>
                                                            </select>

                                                            <select name="data[Property][checkout][min]">
                                                                <? for ($i=0; $i<60; $i++) : ?>
                                                                <option value="<?= $i < 10 ? "0" . $i : $i; ?>"><?= $i < 10 ? "0" . $i : $i; ?></option>
                                                                <? endfor; ?>
                                                            </select>

                                                            <select name="data[Property][checkout][meridian]">
                                                                <option value="am">am</option>
                                                                <option value="pm">pm</option>
                                                            </select> -->
                                                            
                        <div <?php if($steps == 3 ): ?>class="js-time"<?php endif;?>>
					       	<?php
							 echo $this->Form->input('checkout', array('type' => 'time', 'timeFormat' => 12, 'label' => __l('Check out')));
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
    			echo $this->Form->input('house_manual',array('label' => __l('House Manual'), 'info' => __l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
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
                                    
        <div class="submit-block clearfix">
            <?php
            if($steps == 3):
                echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step4]'));
			endif; 
			?>
        </div>
    </div>
		<?php
		 endif; 
		 if($steps >= 4 ):  ?>

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
    			echo $this->Form->input('house_manual',array('label' => __l('House Manual'), 'info' => __l('Private: Traveler will get this information after confirmed reservation. For example, Parking information, Internet access details.')));
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
    	<div class="submit-block clearfix">
            <?php
         	if($steps == 4):
    	       	echo $this->Form->submit(__l('Next'),array('name' => 'data[Property][step4]'));
    		endif;   
    		?>
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
			     	<?php echo __l('Photo caption allows only 255 characters.'); ?>
				</p>
                    <div class="picture">
                        <ol class=" upload-list clearfix">
							<?php
							for($i = 0; $i<Configure::read('properties.max_upload_photo'); $i++):  ?>
								<li>
							     	<div class="property-img"> <?php echo $this->Form->uploader('Attachment.'.$i.'.filename', array('id' =>'Attachment.'.$i.'.filename', 'type'=>'file', 'uPreview' => '1', 'uFilecount'=>1, 'uController'=> 'joinproperties', 'uId' => 'PropertyImage'.$i.'',  'uFiletype' => Configure::read('photo.file.allowedExt'))); ?> 
								    	<span class="property-image-preview" id="preview_image<?php echo $i?>">
									       	<?php if(!empty($this->request->data['Attachment']) && !empty($this->request->data['Attachment'][$i]['filename'])) :?>
											<?php
												$thumb_url = Router::url(array(
												'controller' => 'properties',
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
                <p class="round-5">
                <?php echo __l('Video');?></p>        				
    			<?php echo $this->Form->input('video_url',array('label' => __l('Video URL'),'info' => __l('You can post video URL from YouTube, Vimeo etc.'))); ?>
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
    			<p class="round-5">
    			    <?php echo __l('Admin Actions'); ?></p>
                    <?php
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
    		<?php 
    		if($steps == 5):
    		    echo $this->Form->submit(__l('Finish'),array('name' => 'data[Property][step5]'));
    		endif; 
    		?>
        </div>
    </div>
		<?php endif; ?>
</div>
<?php echo $this->Form->end();?>
</div>
<?php endif;?>
</div>