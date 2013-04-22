<?php /* SVN: $Id: $ */ ?>
<?php
$lat = $property['Property']['latitude'];
$lng = $property['Property']['longitude'];

	$num_array=array();

    if (empty($property['Property']['minimum_nights']) || $property['Property']['minimum_nights'] == 0){
    	$min_guest = 1;
    }else{
        $min_guest = $property['Property']['minimum_nights'];
    }

    if (empty($property['Property']['maximum_nights']) || $property['Property']['maximum_nights'] == 0){
        $max_guest = 50;
    }else{
        $max_guest = $property['Property']['maximum_nights'];
    }

    // arreglo que llena combo de guest
    for($i=$min_guest; $i<= $max_guest; $i++) {
        $num_array[$i]=$i;
    }
	/*
	for($i=1;$i<=16;$i++) {
		if($i == 16) {
			$num_array[$i]=$i . '+';
		} else {
			$num_array[$i]=$i;
		}
	}
    */
//************************* SI ES ITEM *****************************//

	if(!empty($extra_item['Properties_extra_joinables'])){
		$is_item = true;
	}else{
		$is_item = false;
	}

//getVar('daysAvilable', $daysAvilable);

?>


<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="properties view clearfix">
	<div class="grid_17 side1">
		<div class="clearfix host-panel-block">
			<?php if($this->Auth->user('id')==$property['Property']['user_id']): ?>
				<div class="block2-tl">
					<div class="block2-tr">
						<div class="block2-tm host-panel clearfix">
							<h4><?php echo __l('Host Panel'); ?></h4>
							<span class="info"><?php echo __l('This is your property'); ?></span>
						</div>
					</div>
				</div>
				<?php $all_count=$property['Property']['sales_pending_count']+$property['Property']['sales_pipeline_count']; ?>
				<div class="properties-middle-block properties-middle-inner-block1 clearfix">
					<div class="inbox-option dashboard-info grid_6 omega alpha">
						<h3><?php echo __l('Reservations'); ?></h3>
						<p class="key-info-block clearfix">
							<span class="all round-3"><?php echo $this->Html->link(__l('All:').' '.$all_count, array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'all', 'admin' => false), array('title' => __l('All'),'class' => ''));?></span>
						</p>
						<p class="key-info-block clearfix">
							<span class="pendinghostaccept round-3"><?php echo $this->Html->link(__l('Waiting for acceptance:').' '.$this->Html->cInt($property['Property']['sales_pending_count'],false), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'waiting_for_acceptance', 'admin' => false), array('title' => __l('Waiting for acceptance'),'class' => ''));?></span>
						</p>
						<p class="key-info-block clearfix">
							<span class="arrivedconfirmed round-3"><?php echo $this->Html->link(__l('Pipeline:').' '.($this->Html->cInt($property['Property']['sales_pipeline_count'],false)), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'in_progress', 'admin' => false), array('title' => __l('Confirmed'),'class' => ''));?></span>
						</p>
					</div>
					<div class="grid_5 verfied-info-block omega alpha">
						<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?>
							<p><?php echo $this->Html->link(__l('Get Verified'), array('controller' => 'payments', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Get Verified'),'class' => 'verified'));?></p>
						<?php } ?>
						<p><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></p>
						<p><?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Calendar'),'class' => 'calendar'));?><span class="info"><?php echo __l('Manage reservations & pricing');?></span></p>
					</div>
					<div class="grid_5 gird_right omega alpha enable-list">
						<h3><?php echo __l('Enable Listing'); ?></h3>
						<?php
							$url = Router::url(array(
								'controller' => 'properties',
								'action' => 'view',
								$property['Property']['slug'],
								'admin' => false
							) , true);
							$this->request->data['Property']['is_active']= $property['Property']['is_active'];
							echo $this->Form->create('Property', array('class' => 'normal js-ajax-form option-form  clearfix '));
						?>
						<div class="js-radio-style ui-button-set">
							<?php
								$options=array('1'=>'ON', '0'=>'OFF');
								$attributes=array('div'=>'js-radio-style',"class" => "js-activeinactive-updated  {'id': '". $property['Property']['id'] ."', 'url':'". $url ."'}", 'legend'=>false, 'value' => $property['Property']['is_active']);
								echo $this->Form->radio('is_active', $options, $attributes);
							?>
						</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
				<div class="properties-bl">
					<div class="properties-br">
						<div class="properties-bm"> </div>
					</div>
				</div>
			<?php endif; ?>
			<?php  if(!empty($this->request->params['pass'][1]) &&  !empty($this->request->params['pass'][2]) && $distance_view) : ?>
				<div class="hovst-view-block page-information clearfix">
					<dl class="request-list1 host-view guest clearfix">
						<dt title ="<?php echo __l('Distance');?>"><?php echo __l('Distance (km)');?></dt>
						<dd><?php echo $this->Html->cInt($this->Html->distance($this->request->params['named']['latitude'],$this->request->params['named']['longitude'],$property['Property']['latitude'],$property['Property']['longitude'],'K')); ?></dd>
					</dl>
					<div class="city-info grid_left">
						<?php echo __l('from') . ' ' . $this->request->params['named']['cityname'];?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="clearfix properties-title-block">
			<?php
				if($this->Auth->sessionValid()):
					if(!empty($property['PropertyFavorite'])):
						foreach($property['PropertyFavorite'] as $favorite):
							if($property['Property']['id'] == $favorite['property_id'] && $property['Property']['user_id'] != $this->Auth->user('id')):
								echo $this->Html->link(__l('Unlike'), array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('class' => 'js-like un-like', 'title' => __l('Unlike')));
							endif;
						endforeach;
					else:
						if( $property['Property']['user_id'] != $this->Auth->user('id')):
							echo $this->Html->link(__l('Like'), array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like like'));
						endif;
					endif;
				else:
					echo $this->Html->link(__l('Like'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Like'),'escape' => false ,'class' =>'like'));
				endif;
			?>
			<h2 class="properties-title"><?php echo $this->Html->cText($property['Property']['title']);?> </h2>
			<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
				<span class="isverified"> <?php echo __l('verified'); ?></span>
			<?php endif; ?>
			<?php if($property['Property']['is_featured']):?>
				<span class="featured isfeatured round-3"> <?php echo __l('featured'); ?></span>
			<?php endif; ?>
		</div>
		<address class="address-info">
			<span>
				<?php if(!empty($property['Country']['iso2'])): ?>
					<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
				<?php echo $this->Html->cText($property['Property']['address']) ?>
			</span>
		</address>
		<dl class="posted-list clearfix">
			<dt title="<?php echo __l('Posted on'); ?>"><?php echo __l('Posted on '); ?></dt>
				<dd title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($property['Property']['created'])); ?>"><?php echo  $this->Time->timeAgoInWords($property['Property']['created']);?></dd>
		</dl>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
		<div class="clearfix js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
			<dl class="request-list1 view-list1 guest clearfix">
				<dt title ="<?php echo __l('View');?>"><?php echo __l('Views');?></dt>
				<dd class="js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo $this->Html->cInt($property['Property']['property_view_count']); ?></dd>
			</dl>
			<dl class="ratings-feedback1 clearfix">
				<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
					<dd class="positive-feedback1"><?php  echo $this->Html->cInt($property['Property']['positive_feedback_count']); ?></dd>
			</dl>
			<dl class="ratings-feedback1 clearfix">
				<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
					<dd  class="negative-feedback1"><?php  echo $this->Html->cInt($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
			</dl>
			<dl class="clearfix  request-list1 request-index-list success-rate-list">
				<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
					<?php if(empty($property['Property']['property_feedback_count'])): ?>
						<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php else:?>
						<dd class="success-rate">
						<?php
							if(!empty($property['Property']['positive_feedback_count'])):
								$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
								$negative = 100 - $positive;
							else:
								$positive = 0;
								$negative = 100;
							endif;
							echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));
						?>
						</dd>
					<?php endif; ?>
			</dl>
			<?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
				<dl class="clearfix request-list1 request-index-list guest network-level">
					<dt title="<?php echo __l('Network Level'); ?>"><?php echo __l('Network'); ?><span class="km"> <?php echo __l('Level');?></span></dt>
					<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
						<dd class="network-level" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
						<dd class="network-level" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
						<dd class="network-level" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
						<dd class="network-level" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
					<?php else: ?>
						<dd class="network-level" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php endif; ?>
				</dl>
			<?php endif; ?>
			<?php
				// Twitter
				$tw_url = Router::url(array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']), true);
				$tw_url =$tw_url;
				$tw_message = $property['Property']['title'];
				// Facebook
				$fb_status = Router::url(array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']), true);
				$fb_status = $fb_status;
			?>
			<div class="share-link-block grid_left">
				<div class="clearfix">
					<ul class="share-link1 clearfix">
						<li class="twitter"><a href="http://twitter.com/share?url=<?php echo $tw_url;?>&amp;text=<?php echo $tw_message;?>&amp;via=<?php echo Configure::read('twitter.site_username');?>&amp;lang=en" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
						<li class="facebook"><fb:like href="<?php echo $fb_status;?>" layout="button_count" width="50" height="40" action="like"></fb:like></li>
					</ul>
				</div>
				<?php
					if (Configure::read('property.is_allow_property_flag')):
						if ($this->Auth->sessionValid()):
							if ($property['Property']['user_id'] != $this->Auth->user('id')):
								echo $this->Html->link(__l('Flag this property'), array('controller' => 'property_flags', 'action' => 'add', $property['Property']['id']), array('title' => __l('Flag this property'),'escape' => false ,'class' =>'flag js-thickbox'));
							endif;
						else :
							echo $this->Html->link(__l('Flag this property'), array('controller' => 'users', 'action' => 'login', '?' => 'f=property/' . $property['Property']['slug'], 'admin' => false), array( 'title' => __l('Flag this property'), 'class' => 'flag'));
						endif;
					endif;
				?>
			</div>
		</div>
		<div class="js-tabs clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix">
							<li><?php echo $this->Html->link(__l('Photos'), '#photo-1', array('title' => __l('Photos'),'class'=>'negrita tabs-bold'));?></li>
							<?php if(!empty($property['Property']['video_url'])): ?>
								<li><?php echo $this->Html->link(__l('Video'),  '#video-1', array('title' => __l('Video'),'class'=>'negrita tabs-bold'));?></li>
							<?php endif; ?>
							<li><?php echo $this->Html->link(__l('Map'), '#map-2', array('title' => __l('Map'),'class'=>'negrita tabs-bold'));?></li>
							<?php if($property['Property']['street_view'] > ConstStreetView::HideStreetView): ?>
								<li><?php echo $this->Html->link(__l('Street View'),  array('controller' => 'properties', 'action' => 'streetview',$lat,$lng), array('title' => __l('Street View'),'class' =>''));?></li>
							<?php endif; ?>
							<div id="info_minmax" class="info_minmax">

                                <?php if(!empty($property['Country']['iso2'])): ?>
                                    <div style="float: right;"><div style="padding-right: 4px; float: right; padding-left: 4px; padding-top: 1px;"><?php echo $property['Country']['name']; ?></div><span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"></span> </div>
                                <?php endif; ?>

							    <div style="float: right; padding-right: 18px;">
							         <img src="/assets/images/icons/persona.png" style="padding-right: 4px; margin-top: -3px" />for <?php echo $property['Property']['minimum_nights']; ?> to <?php if($property['Property']['maximum_nights'] == 0){ echo '<img src="/assets/images/icons/infinito.png">';}else { echo $property['Property']['maximum_nights']; } ?>
                                </div>

							</div>
						</ul>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm">
						<div id="photo-1" class="ui-corner-right">
							<div class="photos-view-block">
								<?php
									$class_id ='';
									$class_id='galleryView';
								?>
								<ul id="<?php echo $class_id;?>">
									<?php foreach($property['Attachment'] as $attachment): ?>
										<li>
											<?php echo $this->Html->showImage('Property', $attachment, array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
											<?php if(!empty($class_id) && !empty($attachment['description'])) { ?>
												<div class="gv-panel-overlay">
													<h3><?php echo $this->Html->cText($attachment['description'],false); ?></h3>
												</div>
											<?php }	?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<?php if (!empty($property['Property']['video_url'])): ?>
							<div id="video-1" class="ui-corner-right">
								<?php
									if($this->Embed->parseUrl($property['Property']['video_url'])) {
										$this->Embed->setHeight('510px');
										$this->Embed->setWidth('647px');
										echo $this->Embed->getEmbedCode();
									}
								?>
							</div>
						<?php endif; ?>
						<div id="map-2" class="ui-corner-right no-padding">
							<?php if(!empty($property['Property']['address'])): ?>
								<?php $map_zoom_level = !empty($property['Property']['map_zoom_level']) ? $property['Property']['zoom_level'] : '10';?>
								<a href="http://maps.google.com/maps?q=<?php echo $property['Property']['latitude']; ?>,<?php echo $property['Property']['longitude']; ?>&z=<?php echo $map_zoom_level; ?>" target="_blank"><?php echo $this->Html->image($this->Html->formGooglemap($property['Property'],'648x402'),array('width'=>'648px','height'=>'402px')); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
		</div>
		<div class="js-tabs clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center">
						<ul class="clearfix">
							<li><?php echo $this->Html->link(__l('Description'), '#tabs-1', array('title' => __l('Description'),'class'=>'negrita tabs-bold'));?></li>
							<li><?php echo $this->Html->link(__l('Time of Join'), '#tabs-time-join', array('title' => __l('Time of Join'),'class'=>'negrita tabs-bold'));?></li>
						    <li><?php echo $this->Html->link(__l('Duration'), '#tabs-duration-join', array('title' => __l('Duration'),'class'=>'negrita tabs-bold'));?></li>
							<li><?php echo $this->Html->link(__l('Rate Details'), '#rate', array('title' => __l('Rate Details'),'class'=>'negrita tabs-bold'));?></li>
							<li><?php echo $this->Html->link(__l('House Rules'), '#tabs-2', array('title' => __l('House Rules'),'class'=>'negrita tabs-bold'));?></li>
							<!-- //@todo "Ask Question" -->
						</ul>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm clearfix">
						<div id="tabs-1" class="ui-corner-right clearfix" >
							<div class="grid_15 alpha omega">
								<?php echo $this->Html->cText($property['Property']['description']);?>
							</div>
						</div>
						<div id="tabs-time-join" class="ui-corner-right clearfix" >
                            <div class="grid_15 alpha omega">
                               <?php
                               function nombredia($d){
                                   //para imprimir el nombre del dia
                                   switch ($d) {
                                        case 0:
                                            $dia = __l('Sunday');
                                            break;
                                        case 1:
                                            $dia = __l('Monday');
                                            break;
                                        case 2:
                                            $dia = __l('Tuesday');
                                            break;
                                        case 3:
                                            $dia = __l('Wednesday');
                                            break;
                                        case 4:
                                            $dia = __l('Thursday');
                                            break;
                                        case 5:
                                            $dia = __l('Friday');
                                            break;
                                        case 6:
                                            $dia = __l('Saturday');
                                            break;
                                        case 9:
                                            $dia = __l('Everyday');
                                            break;
                                    }

                                    return $dia;

                               }

                               //debug($hoursAvilable);
                               $value_true = false;
                               if(!empty($hoursAvilable)){
                                    foreach($hoursAvilable as $hour){
                                        if($hour[1] != ''){
                                            echo '<li>'.nombredia($hour[0]).' : '.$hour[1].'</li>';
                                            $value_true = true;
                                        }
                                    }//end foreach
                               }else{
                                        echo '<li>No details available</li>';
                               }

                               if($value_true == false){ echo '<li>No details available</li>';}
                               ?>
                            </div>
                        </div>

                        <div id="tabs-duration-join" class="ui-corner-right clearfix" >
                            <div class="grid_15 alpha omega">
                            <?php
                                echo '<li>'. $duration .'</li>';
                            ?>
                            </div>
                        </div>

						<div id="feature" class="ui-corner-right clearfix" >
							<div class="properties-left">

							</div>
							<div class="properties-right">
								<div class="detail-block">
									<div class="gryfill-tl">
										<div class="gryfill-tr">
											<div class="gryfill-tblr"></div>
										</div>
									</div>
									<div class="gryfill-m">
									</div>
									<div class="gryfill-bl">
										<div class="gryfill-br">
											<div class="gryfill-tblr"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="rate" class="ui-corner-right" >
							<div class="detail-block">
								<div class="gryfill-tl">
									<div class="gryfill-tr">
										<div class="gryfill-tblr"></div>
									</div>
								</div>
								<div class="gryfill-m">
									<h5> <?php echo __l('Details'); ?></h5>
									<dl class="clearfix">
<?php
	$is_perjoin = false;
	if(!empty($property['Property']['price_per_week'])){$is_perjoin = true;} //si se cargo el pecio por join
?>
										<dt><?php echo (!$is_perjoin)? __l('Price per night'): __l('Price per Join')  ; ?></dt>
										<dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>
									</dl>
								</div>
								<div class="gryfill-bl">
									<div class="gryfill-br">
										<div class="gryfill-tblr"></div>
									</div>
								</div>
							</div>
						</div>
						<div id="tabs-2" class="ui-corner-right" >
							<?php if(!empty($property['Property']['house_rules'])): ?>
								<?php echo $this->Html->cText($property['Property']['house_rules']);?>
							<?php else: ?>
								<p class="notice"><?php echo __l('No house rules available');?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
		</div>
		<?php
			$latitude = '&lat='. $property['Property']['latitude'];
			$longitude = '&lon='.$property['Property']['longitude'];
		?>



<!--

		<div class="js-tabs clearfix">

			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
				<!--
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix">
							<li><?php echo $this->Html->link(__l('Nearby Properties'), '#nearby_property', array('title' => __l('Nearby Properties')));?></li>
							<li><?php // echo $this->Html->link(__l('Tweets Around '), array('controller' => 'properties', 'action' => 'tweet_around',$lat,$lng), array('title' => __l('Tweets Arround')));?></li>
							<li><?php // echo $this->Html->link(__l('Flickr'), array('controller' => 'properties', 'action' => 'flickr',$lat,$lng), array('title' => __l('Flickr')));?></li>
							<li><?php echo $this->Html->link(__l('Weather'), array('controller' => 'properties', 'action' => 'weather_data', $property['City']['name']), array('title' => __l('Weather'),'class'=>""));?></li>
							<li><?php echo $this->Html->link(__l('Amenities Around'), array('controller' => 'properties', 'action' => 'amenities_around',$lat,$lng), array('title' => __l('Amenity Map')));?></li>
						</ul>
					</div>

				</div>
			</div>
			<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm clearfix">
						<div id="nearby_property" class="ui-corner-right">
							<?php
								$hash = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
								$salt = !empty($this->request->params['pass'][2]) ? $this->request->params['pass'][2] : '';
								//echo $this->element('property-index', array('config' => 'sec','property_id' => $property['Property']['id'],'city_id' =>$property['City']['id'],'hash'=>$hash,'salt'=>$salt,'type'=>'similar','limit'=>5));
							?>
						</div>
						<div id="weather" class="ui-corner-right"></div>
					</div>
				</div>
			</div>


			<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
		</div>


-->



		<div class="js-tabs  clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix">
							<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'properties', 'action' => 'review_index','property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('Reviews')));?></li>
							<li><?php echo $this->Html->link(__l('Recommendations'), array('controller' => 'user_comments', 'action' => 'index', $property['User']['username']), array('title' => __l('Top comments')));?></li>
							<li><?php echo $this->Html->link(__l('Other Property Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','user_id'=>$property['Property']['user_id'],'property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('All users')));?></li>
							<li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'index','user'=>$property['Property']['user_id'],'type'=>'user','view'=>'compact'), array('title' => __l('Friends')));?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm clearfix">
						<div id="Shopping_friends"></div>
						<div id="Reviews"></div>
						<div id="Top_comments"></div>
						<div id="All_users"></div>
					</div>
				</div>
			</div>
			<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
		</div>
		<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
			<div class="admin-tabs-block">
				<div class="js-tabs">
					<div class="pptab-menu-left">
						<div class="pptab-menu-right">
							<div class="pptab-menu-center clearfix">
								<ul class="clearfix admin-property-menu">
									<li><?php echo $this->Html->link(__l('Property Feedbacks'), array('controller' => 'property_feedbacks', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property feedbacks','escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__l('Property Favorites'), array('controller' => 'property_favorites', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property favorites','escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__l('Property Flags'), array('controller' => 'property_flags', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Property flags','escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__l('Bookings'), array('controller' => 'property_users', 'action' => 'index', 'property_id' => $property['Property']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Bookings','escape' => false)); ?></li>
									<li><?php echo $this->Html->link(__l('Property Views'), array('controller' => 'property_views', 'action' => 'index', 'property_id' => $property['Property']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Property views','escape' => false)); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="pptview-mblock-ll">
						<div class="pptview-mblock-rr">
							<div class="pptview-mblock-mm clearfix">
								<div class="admin-properties">
									<div id="Property_feedbacks"></div>
									<div id="Property_favorites"></div>
									<div id="Property_users"></div>
									<div id="Property_views"></div>
									<div id="Property_flags"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="pptview-mblock-bl">
						<div class="pptview-mblock-br">
							<div class="pptview-mblock-bb"></div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="side2 grid_7 ">
		<?php if($this->Auth->user('id') != $property['Property']['user_id']) : ?>
			<div class="book-block js-book-blok">
				<div class="book-tl">
					<div class="book-tr">
						<div class="book-tm"></div>
					</div>
				</div>
				<div class="book-ll">
					<div class="book-rr">
						<div class="book-center clearfix">
							<div class="browse js-responses">
								<?php echo $this->Form->create('PropertyUser', array('class' => 'normal property-view-form clearfix js-search')); ?>
								<div class="form-block city-search-block-top">
									<?php
										$num_array=array();
                                        if($property['Property']['maximum_nights'] == 0){$property['Property']['maximum_nights'] = 50;}//cuando es 0 es porque se cargo sin maximo, le ponemos 50 de momento
                                        for($i=$property['Property']['minimum_nights'];$i<= $property['Property']['maximum_nights']; $i++) {
												$num_array[$i]=$i;
										}

//*************************************************** modificando para items y funcionar por price per join ****************************************//
$is_perjoin = false;
if(!empty($property['Property']['price_per_week'])){$is_perjoin = true;} //si se cargo el pecio por join


										if($is_perjoin) { //&& $property['Property']['price_per_week']!=0 quito el diferente de 0 porque sera 0 para los items
											if($property['Property']['join_or_item_value'] == 'join'){
												$properties_prices['price_per_night']='<span class="clearfix city-price1">'.'<sub>'. Configure::read('site.currency').'</sub>'.'<span class="cr">'.$this->Html->siteWithCurrencyFormat($property['Property']['price_per_night']).'</span>'.'<span class="price-info">'.__l('Per Join')."</span></span><div style='clear:both'></div>";
											}elseif($property['Property']['join_or_item_value'] == 'item'){
												$properties_prices['price_per_night'] = '';//'<span class="clearfix city-price1">'.'<sub>'. Configure::read('site.currency').'</sub>'.'<span class="cr">'.$this->Html->siteWithCurrencyFormat($property['Property']['price_per_item']).'</span>'.'<span class="price-info">'.__l('Per item')."</span></span><div style='clear:both'></div>";
											}
										}else{
											$properties_prices['price_per_night']='<span class="clearfix city-price1">'.'<sub>'. Configure::read('site.currency').'</sub>'.'<span class="cr">'.$this->Html->siteWithCurrencyFormat($property['Property']['price_per_night']).'</span>'.'<span class="price-info">'.__l('Per night')."</span></span><div style='clear:both'></div>";
										}

										echo $this->Form->input('property_id',array('type'=>'hidden'));
										echo $this->Form->input('property_slug',array('type'=>'hidden'));
										echo $this->Form->input('price',array('type'=>'hidden'));

									?>
									<div class="booking-option-block clearfix">
										<?php echo ($is_item == true)?$this->Form->radio('booking_option', $properties_prices, array("legend" => false, "class" => "hide js-price-list")) : $this->Form->radio('booking_option', $properties_prices, array("legend" => false, "class" => "js-price-list", "checked"=> "checked")); ?>
									</div>
									<!-- <div class="clearfix show-calender"><span class="js-show-calendar"><?php echo __l('Calendar'); ?></span> / <span class="js-show-dropdown"><?php echo __l('Dropdown'); ?></span></div> -->
									<?php echo $this->element('host-calendar', array('type' => 'guest', 'ids' => $property['Property']['id'], 'config' => 'sec')); ?>
									<div class="js-calender-formfield hide">
										<div class="clearfix checkin-form-field">
											<?php
												echo $this->Form->input('checkin', array('label' => __l('Check in'), 'type' => 'date', 'minYear' => date('Y'), 'maxYear' => date('Y')+1, 'orderYear' => 'asc'));
												echo $this->Form->input('checkout', array('label' => __l('Check out'), 'type' => 'date','minYear' => date('Y'), 'maxYear' => date('Y')+1, 'orderYear' => 'asc'));
											?>
										</div>
									</div>
								</div>
								<div class="cals-status">
								<p class="js-date-picker-info js-cal-status "></p>
									<div class="full-calendar js-calender-form-calender" style="margin-bottom: -8px !important;">
										<?php
											//echo $this->Html->link(__l('Check in/Check out dates are not in this month? Select both dates'), array('controller' => 'properties', 'action' => 'calendar', 'guest_list', 'ids' =>  $property['Property']['id']), array('title'=> __l('Check in/Check out dates are not in this month? Select both dates'), 'escape' => false, 'class' => 'js-guest_list_calender_opening'));
										?>
									</div>
<!-- area de turnos -->					



								<div id="turnos_container" class="separador_linea">
									
<!-- Este contenido se borra si hay horarios definidos, sino queda el predefinido que es a consultar -->	
									<h4>Select Time:</h4>					
									<div class="properties-tl" style="margin-top: 4px;">
										<div class="properties-tr">
											<div class="properties-tm"> </div>
										</div>
									</div>
									<div class="properties-middle-block clearfix">
										<dl class="suresh condition-list condition-list1 clearfix">
										<dt style="width: 200px !important;"> <label><span> <input id="turno0" type="radio" name="data[PropertyUser][turno_nro]" data-max="<?php if($property['Property']['maximum_nights'] == 0){ echo '100';} else { echo $property['Property']['maximum_nights']; } ?>"  value="0"> Contact host to Set Up Time. </span></label> </dt>
										</dl>
									</div>
									<div class="properties-bl">
										<div class="properties-br">
											<div class="properties-bm"> </div>
										</div>
									</div>
<!-- Fin area de reemplazo de horarios     -->								
								</div>
									
					
<!-- fin area de turnos -->		
						
									<div class="guest-info condition-block">

									<?php

									if(!$is_perjoin){
										if($property['Property']['join_or_item_value'] != 'join'){
											echo $this->Form->input('guests',array('label' => 'Guests', 'type'=>'select','options'=>$num_array));
										}else{
											echo $this->Form->input('guests',array('label' => 'Participants', 'type'=>'select','options'=>$num_array));
										}
									}else{// si se cobra por join
										echo "<p>" . $this->Form->input('guests',array('type'=>'hidden','value'=>1)) . "</p>";
										echo "<p> Max participants per join: ".max($num_array)." </p>";
									}

									?>
<!--//************************************************************ ITEMS **************************************************************************************//-->
									<?php

									if($is_item){
										$typeJoin = 'i';
									}else{
										$typeJoin = (!empty($property['Property']['price_per_week']))?'j':'p';
									}
//lo necesito para saber desde jquery que calculo hacer i= item  p= per person j= per join
									echo $this->Form->input('Property.joinType',array('type'=>'hidden','value'=>$property['Property']['join_or_item_value']));


									if($is_item){

										$extras = $extra_item['Properties_extra_joinables']; //para no trabajar cpon cadena tan larga
										$price_options = array();

										if(!empty($extras['item_price_hour'])){
											$price_options[$extras['item_price_hour']] = $extras['item_price_hour'].' Per Hour';
										}
										if(!empty($extras['item_price_day'])){
											$price_options[$extras['item_price_day']] = $extras['item_price_day'].' Per Day';
										}
										if(!empty($extras['item_price_week'])){
											$price_options[$extras['item_price_week']] = $extras['item_price_week'].' Per Week';
										}

										//debug($property);

										echo $this->Form->input('pricePeriod',array('label'=>'Price','type'=>'select','options' => $price_options));

									}

									?>

<!--//*********************************************************************************************************************************************************//-->

									<!-- @todo "Guest details" -->
                                    </div>
									<?php if(isset($this->request->params['named']['cityname'])): ?>
										<?php echo $this->Form->input('original_search_address',array('type'=>'hidden','value'=>$this->request->params['named']['cityname'])); ?>
									<?php endif; ?>
								</div>
								<div class="js-price-details-response">
									<div class="condition-block">
										<h3><?php echo __l('Price Details');?></h3>
										
<!-- ZONA DE FEE VARIABLE   -->										
									
									<!-- fee client -->
									<input id="pro_fee_client" type="hidden" value="<?php echo $property['Property']['fee_client'];?>" />
									<!-- fee provider -->
									<input id="pro_fee_provider" type="hidden" value="<?php echo $property['Property']['fee_provider'];?>" />
										
<!-- END FEE --> 							
										<p id="js-checkinout-date"></p>
										<dl class="condition-list clearfix js-price-for-product {'per_night': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_night'],false);?>', 'per_week': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_week'],false);?>', 'per_month': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_month'],false);?>' , 'additional_guest_price': '<?php echo $property['Property']['additional_guest_price'];?>', 'property_commission_amount': '<?php echo Configure::read('property.booking_service_fee');?>', 'additional_guest': '<?php echo $property['Property']['additional_guest'];?>'}">
											<dt><?php echo ($is_perjoin)?__l('Joins') : __l('Participants');?></dt>
												<dd class="js-property-no_day-night"><?php echo $this->Html->cInt($property['Property']['minimum_nights']); ?></dd>
											<dt><?php echo __l('Price');?></dt>
												<dd><?php echo Configure::read('site.currency'); ?><span class="js-property-per-night-amount">0</span></dd>
											<!--<dt><?php echo __l('Additional Guest Prices ');?><span class="js-no_of_guest-price"></span></dt>
												<dd><?php echo Configure::read('site.currency'); ?><span class="js-property-guest-amount">0</span></dd>
											--><dt><?php echo __l('Sub Total');?></dt>
												<dd><?php echo Configure::read('site.currency'); ?><span class="js-property-subtotal-amount">0</span></dd>
											<dt><?php echo __l('Service Tax');?></dt>
												<dd><?php echo Configure::read('site.currency'); ?><span class="js-property-servicetax-amount">0</span></dd>
											<?php if (Configure::read('property.is_enable_security_deposit')): ?>
												<dt><?php echo __l('Security Deposit');?><span class="refundable round-3"><?php echo __l('Refundable'); ?></span></dt>
												<dd><?php echo Configure::read('site.currency'); ?><span class="js-property-desposit-amount"><?php echo $this->Html->siteWithCurrencyFormat($property['Property']['security_deposit'],false); ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></dd>
											<?php endif; ?>
										</dl>
									</div>
									<div class="condition-block">
										<dl class="condition-list clearfix">
											<dt class="total"><?php echo __l('Total');?></dt>
												<dd class="total"><?php echo Configure::read('site.currency'); ?> <span class="js-property-total-amount">0</span></dd>
										</dl>
									</div>
								</div>
								<div class="clearfix">
									<?php echo $this->Form->submit(__l('Book it!'),array('id'=>'bookitJoin', 'data-select'=>'no')); ?>
								</div>
								<?php if (!empty($property['Property']['is_negotiable'])): ?>
									<div class="negotiate-block clearfix">
										<div class="clearfix negotiate-contact-block ">
											<span><?php echo __l('or'); ?></span>
											<?php echo $this->Form->submit(__l('Contact'), array('name' => 'data[PropertyUser][contact]', 'div' => false , 'class' => 'contact-link')); ?>
											<div class="clearfix for-info">
												<span class="info"><?php echo __l('For pricing negotiation');?></span>
											</div>
										</div>
									</div>
								<?php endif; ?>
								<div class="condition-block1">
									<div class="properties-tl">
										<div class="properties-tr">
											<div class="properties-tm"> </div>
										</div>
									</div>
									<div class="properties-middle-block clearfix">
										<h3><?php echo __l('Conditions');?></h3>
										<dl class="suresh condition-list condition-list1 clearfix">
										<?php if(!empty($property['CancellationPolicy'])) { ?>
											<?php
												if ($property['CancellationPolicy']['percentage'] == '0.00') {
													$percentage = 'No';
												} elseif ($property['CancellationPolicy']['percentage'] == '100.00') {
													$percentage = 'Full';
												} else {
													$percentage = $this->Html->cFloat($property['CancellationPolicy']['percentage'], false) . '%';
												}
											?>
											<dt><?php echo __l('Cancellation Policy'); ?></dt>
												<dd class="clearfix"><?php echo $this->Html->cText($property['CancellationPolicy']['name']); ?> <span class="info" title="<?php echo sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($property['CancellationPolicy']['days'], false)); ?>">&nbsp;</span></dd>
										<?php } ?>
											<dt></dd>
											<dt></dt>
										</dl>
									</div>
									<div class="properties-bl">
										<div class="properties-br">
											<div class="properties-bm"> </div>
										</div>
									</div>
								</div>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="book-bl">
				<div class="book-br">
					<div class="book-bm"></div>
				</div>
			</div>
	<?php endif; ?>
				<div class="rightbox">
		<div class="block2-tl">
			<div class="block2-tr">
				<div class="block2-tm">
					<h4><?php echo __l('Host Stats');?></h4>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-ll">
			<div class="pptview-mblock-rr">
				<div class="pptview-mblock-mm similar-block similar-block1">
					<div class="User index">
						<div class="clearfix user-view-blocks">
							<div class="user-img-block-left grid_left">
								<?php
									$current_user_details = array(
										'username' => $property['UserProfile']['username'],
										'user_type_id' =>  $property['User']['user_type_id'],
										'id' =>  $property['User']['id'],
										'fb_user_id' =>  $property['User']['fb_user_id']
									);
										$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($property['User']['id']);
										echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb');
								?>
							</div>
							<div class="user-img-block-right grid_left">
								<h4> <?php echo $this->Html->link($this->Html->cText($userProfile['UserProfile']['first_name'] . ' ' . $userProfile['UserProfile']['last_name'], false), array('controller' => 'users', 'action' => 'view', $property['User']['username'], 'admin' => false), array('title'=>$this->Html->cText($property['User']['username'], false))); ?></h4>
								<div class="clearfix">
								<dl class="clearfix posted-list">
									<dt><?php echo __l('Properties posted'); ?></dt>
									<dd><span class="stats-val"><?php echo $this->Html->cInt($property['User']['property_count']);?></span></dd>
									</dl>
								</div>
							</div>
						</div>






								<div class="condition-block1">
									<div class="properties-tl">
										<div class="properties-tr">
											<div class="properties-tm"> </div>
										</div>
									</div>
									<div class="properties-middle-block clearfix">
										<h3><?php echo __l('More about me');?></h3>
										<hr>
										<dl class="suresh condition-list condition-list1 clearfix">

											<?php echo $userProfile['UserProfile']['about_me']; ?>
											<br /><br /><br />
											<?php echo $this->Html->link($this->Html->cText(__l('View full profile'), false), array('controller' => 'users', 'action' => 'view', $property['User']['username'], 'admin' => false), array('title'=>$this->Html->cText($property['User']['username'], false))); ?>
											<br />

										</dl>
									</div>
									<div class="properties-bl">
										<div class="properties-br">
											<div class="properties-bm"> </div>
										</div>
									</div>
								</div>





						<div class="clearfix">
						<dl class="ratings-feedback1 clearfix">
										<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
											<dd class="positive-feedback1"><?php  echo $this->Html->cInt($property['User']['positive_feedback_count']); ?></dd>
									</dl>
									<dl class="ratings-feedback1 clearfix">
										<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
											<dd  class="negative-feedback1"><?php  echo $this->Html->cInt($property['User']['property_feedback_count'] - $property['User']['positive_feedback_count']); ?></dd>
									</dl>
							<dl class="ratings-feedback1 no-booking clearfix">
								<?php
									if(!empty($property['User']['positive_feedback_count'])):
										$positive = floor(($property['User']['positive_feedback_count']/$property['User']['property_feedback_count']) *100);
										$negative = 100 - $positive;
									else:
										$positive = 0;
										$negative = 100;
									endif;
								?>
								<?php if(($property['User']['property_feedback_count']) == 0): ?>
									<dt class=""><?php echo __l('Success Rate'); ?></dt>
										<dd class="not-available"><span class="stats-val"><?php echo  __l('n/a');?></span></dd>
								<?php else: ?>
									<dt class="no-booking"><?php echo __l('Success Rate'); ?></dt>
										<dd class="success-rate"><span class="stats-val"><?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?></span></dd>
								<?php endif; ?>
							</dl>
						</div>
						<?php if($this->Auth->user('id')!= $property['Property']['user_id']) : ?>
							<div class="view-contact-link clearfix">
								<div class="cancel-block">
									<?php echo $this->Html->link(__l('Contact Me'), array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $property['Property']['slug']), array('title' => __l('Contact')));?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-bl">
			<div class="pptview-mblock-br">
				<div class="pptview-mblock-bb"></div>
			</div>
		</div>
	</div>
<?php if ($this->Auth->user('id') && $this->Auth->user('id') != $property['Property']['user_id']): ?>
	<div class="rightbox">
		<div class="block2-tl">
			<div class="block2-tr">
				<div class="block2-tm clearfix social-network-block">
					<h4 class="grid_left"><?php echo __l('Social Networks');?></h4>
					<?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
						<dl class="clearfix request-list1 request-index-list guest network-level">
							<dt title="<?php echo __l('Network Level'); ?>"></dt>
							<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
								<dd class="network-level" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
								<dd class="network-level" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
								<dd class="network-level" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
								<dd class="network-level" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
							<?php else: ?>
								<dd class="network-level" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php endif; ?>
						</dl>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-ll">
			<div class="pptview-mblock-rr">
				<div class="pptview-mblock-mm similar-block similar-block1">
					<div class="User index">
						<div class="clearfix user-view-blocks social-networks-block">
							<?php
								if ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched')):
									echo $this->Html->link(__l('Connect with Facebook'), $fb_login_url, array('class' => 'facebook-connect-link', 'title' => __l('Connect with Facebook')));
									echo '<span>' . ' ' . __l('to filter by Social Network level') . '</span>';
								elseif (!$this->Auth->user('is_show_facebook_friends')):
									echo '<span class="warning">' . __l('Enable Facebook friends level display in social networks page') . '</span>';
								elseif (empty($property['User']['is_facebook_friends_fetched'])):
									echo '<span class="warning">' . __l('Host is not connected with Facebook') . '<span>';
								else:
									$network_level_arr = array(
										'1' => 'st',
										'2' => 'nd',
										'3' => 'rd',
										'4' => 'th',
									);
									if (!empty($network_level[$property['Property']['user_id']])):
										echo '<span>' . sprintf(__l('You and host are connected at %s%s level through Facebook'), $network_level[$property['Property']['user_id']], $network_level_arr[$network_level[$property['Property']['user_id']]]) . '</span>';
									endif;
							?>
									<?php if (!empty($common_friends)): ?>
										<div>
											<ul class="socila-users-list clearfix">
										<?php foreach($common_friends as $common_friend_id => $common_friend_name): ?>
											<li><img src="http://graph.facebook.com/<?php echo $common_friend_id; ?>/picture"><br/><?php echo $common_friend_name; ?></li>
										<?php endforeach; ?>
											</ul>
										</div>
										<span class="info"><?php echo __l('Common friends connected through Facebook'); ?></span>
									<?php endif; ?>
							<?php
								endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-bl">
			<div class="pptview-mblock-br">
				<div class="pptview-mblock-bb"></div>
			</div>
		</div>
	</div>
<?php endif; ?>
	</div>
</div>
<div id="fb-root"></div>
<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
</script>