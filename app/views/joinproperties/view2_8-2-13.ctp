<?php /* SVN: $Id: $ */ ?>
<?php 
$this->loadHelper('Embed');
$lat =$property['Property']['latitude']; 
$lng = $property['Property']['longitude'];
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
						<p class="key-info-block clearfix sfont">
							<span class="all round-3"><?php echo $this->Html->link(__l('All:').' '.$all_count, array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'all', 'admin' => false), array('title' => __l('All'),'class' => ''));?></span>
						</p>
						<p class="key-info-block clearfix sfont">
							<span class="waitingforacceptance round-3"><?php echo $this->Html->link(__l('Waiting for acceptance:').' '.$this->Html->cInt($property['Property']['sales_pending_count'],false), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'waiting_for_acceptance', 'admin' => false), array('title' => __l('Waiting for acceptance'),'class' => ''));?></span>
						</p>
						<p class="key-info-block clearfix sfont">
							<span class="arrivedconfirmed round-3"><?php echo $this->Html->link(__l('Pipeline:').' '.($this->Html->cInt($property['Property']['sales_pipeline_count'],false)), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'],'status' => 'pipeline', 'admin' => false), array('title' => __l('Pipeline'),'class' => ''));?></span>
						</p>
					</div>
					<div class="grid_5 verfied-info-block omega alpha">
						<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] === null) { ?>
						<?php echo $this->Html->link(__l('Get Verified'), array('controller' => 'payments', 'action' => 'property_verify_now', $property['Property']['id'], 'admin' => false), array('title' => __l('Get Verified'),'class' => 'verified'));?>
						<?php } ?>
						<?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
						<?php echo $this->Html->link(__l('Calendar'), array('controller' => 'property_users', 'action' => 'index', 'type'=>'myworks', 'property_id' => $property['Property']['id'], 'admin' => false), array('title' => __l('Calendar'),'class' => 'calendar'));?><span class="info"><?php echo __l('Manage reservations & pricing');?></span>
                        <h3><?php echo __l('Enable Listing'); ?></h3>
						<?php
							$url = Router::url(array(
								'controller' => 'properties',
								'action' => 'view',
								$property['Property']['slug'],
								'admin' => false
							) , true);
							$this->request->data['Property']['is_active']= $property['Property']['is_active'];
							echo $this->Form->create('Property', array('class' => 'normal js-ajax-form option-form no-pad clearfix '));
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
                  	<div class="grid_5 gird_right omega alpha enable-list">
                            <?php
                            $day1= date("D j", mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
                            $day2=date("D j", mktime(0, 0, 0, date("m"),date("d")-2,date("Y")));
                            $day3=date("D j", mktime(0, 0, 0, date("m"),date("d")-3,date("Y")));
                            $axis1=ceil($chart_data['max_count']/3);
                            $axis2=ceil($chart_data['max_count']/3)*2;
                            $axis3=ceil($chart_data['max_count']/3)*3;
                            	 $image_url='http://chart.apis.google.com/chart?chf=a,s,000000FA|bg,s,67676700&amp;chxl=0:|0|'.$day3.'|'.$day2.'|'.$day1.'|1:|0|'.$axis1.'|'.$axis2.'|'.$axis3.'&amp;chxs=0,676767,11.5,0,lt,676767&amp;chxtc=0,4&amp;chxt=x,y&amp;chs=200x100&amp;cht=lxy&amp;chco=0066E4,FF0285&amp;chds=0,3,0,'.$axis3.',0,3,0,'.$axis3.'&amp;chd=t:1,2,3|'. $chart_data['PropertyView'][3]['count'].','.$chart_data['PropertyView'][2]['count'].','.$chart_data['PropertyView'][1]['count'].'|1,2,3|'.$chart_data['PropertyUser'][3]['count'].','.$chart_data['PropertyUser'][2]['count'].','.$chart_data['PropertyUser'][1]['count'].'&amp;chdl=Views|Bookings&amp;chdlp=b&amp;chls=2,4,1|1&amp;chma=5,5,5,25';
                            echo $this->Html->image($image_url); ?>
					
					</div>
				</div>
				<div class="properties-bl">
					<div class="properties-br">
						<div class="properties-bm"> </div>
					</div>
				</div>
			<?php endif; ?>
			<?php  if(!empty($this->request->params['pass'][1]) &&  !empty($this->request->params['pass'][2]) && $distance_view) : ?>
				<div class="hovst-view-block pr page-information clearfix">
					<dl class="request-list1 host-view guest clearfix">
						<dt title ="<?php echo __l('Distance');?>"><?php echo __l('Distance (km)');?></dt>
						<dd class="dc"><?php echo $this->Html->cInt($this->Html->distance($this->request->params['named']['latitude'],$this->request->params['named']['longitude'],$property['Property']['latitude'],$property['Property']['longitude'],'K')); ?></dd>
					</dl>
					<div class="city-info grid_left">
						<?php echo __l('from') . ' ' . $this->request->params['named']['cityname'];?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="clearfix">
		    <div class="clearfix">
                <div class="grid_left">
        			<?php
        				if($this->Auth->sessionValid()):
        					if(!empty($property['PropertyFavorite'])):
        						foreach($property['PropertyFavorite'] as $favorite):
        							if($property['Property']['id'] == $favorite['property_id'] && $property['Property']['user_id'] != $this->Auth->user('id')):
        								echo $this->Html->link(__l('Unlike'), array('controller' => 'property_favorites', 'action'=>'delete', $property['Property']['slug']), array('class' => 'js-like un-like tb sfont', 'title' => __l('Unlike')));
        							endif;
        						endforeach;
        					else:
        						if( $property['Property']['user_id'] != $this->Auth->user('id')):
        							echo $this->Html->link(__l('Like'), array('controller' => 'property_favorites', 'action' => 'add', $property['Property']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like like tb'));
        						endif;
        					endif;
        				else:
        					echo $this->Html->link(__l('Like'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Like'),'escape' => false ,'class' =>'like tb'));
        				endif;
        			?>
    			</div>
			    <h2 class="properties-title no-pad grid_left"><?php echo $this->Html->cText($property['Property']['title'],false);?> </h2>
      
                	<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
        				<span class="isverified"> <?php echo __l('verified'); ?></span>
        			<?php endif; ?>
        			<?php if($property['Property']['is_featured']):?>
        				<span class="featured isfeatured round-3"> <?php echo __l('featured'); ?></span>
        			<?php endif; ?>
        	
            </div>
		</div>
		<address class="address-info sfont dl clearfix">
			<span>
				<?php if(!empty($property['Country']['iso2'])): ?>
					<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
				<?php echo $this->Html->cText($property['Property']['address']) ?>
			</span>
		</address>
		<dl class="posted-list clearfix">
			<dt title="<?php echo __l('Posted on'); ?>"><?php echo __l('Posted on '); ?></dt>
			<dd class="tb" title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($property['Property']['created'])); ?>"><?php echo  $this->Time->timeAgoInWords($property['Property']['created']);?></dd>
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
				<dd class="dc js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php echo ($property['Property']['property_view_count']); ?></dd>
			</dl>
			<dl class="ratings-feedback1 clearfix">
				<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
				<dd class="positive-feedback1">
				    <?php  echo ($property['Property']['positive_feedback_count']); ?>
				</dd>
			</dl>
			<dl class="ratings-feedback1 clearfix">
				<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
				<dd  class="negative-feedback1">
				    <?php echo ($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>
				</dd>
			</dl>
			<dl class="clearfix  request-list1 request-index-list success-rate-list">
				<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
					<?php if(empty($property['Property']['property_feedback_count'])): ?>
						<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
					<?php else:?>
						<dd class="success-rate dc">
						<?php
							if(!empty($property['Property']['positive_feedback_count'])):
								$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
								$negative = 100 - $positive;
							else:
								$positive = 0;
								$negative = 100;
							endif;
							echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=00FF00|FF0000&amp;chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%'));
						?>
						</dd>
					<?php endif; ?>
			</dl>
			<?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
				<dl class="clearfix request-list1 request-index-list guest network-level">
					    <dt title="<?php echo __l('Network Level'); ?>"><?php echo __l('Network'); ?><span class="km dc"> <?php echo __l('Level');?></span></dt>
					<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
						<dd class="network-level dc" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
						<dd class="network-level dc" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
						<dd class="network-level dc" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
					<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
						<dd class="network-level dc" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
					<?php else: ?>
						<dd class="network-level dc" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
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
			<div class="share-link-block grid_right">
				<?php
					if (Configure::read('property.is_allow_property_flag')):
						if ($this->Auth->sessionValid()):
							if ($property['Property']['user_id'] != $this->Auth->user('id')):
								echo $this->Html->link(__l('Flag this property'), array('controller' => 'property_flags', 'action' => 'add', $property['Property']['id']), array('title' => __l('Flag this property'),'escape' => false ,'class' =>'flag dr grid_right js-thickbox'));
							endif;
						else :
							echo $this->Html->link(__l('Flag this property'), array('controller' => 'users', 'action' => 'login', '?' => 'f=property/' . $property['Property']['slug'], 'admin' => false), array( 'title' => __l('Flag this property'), 'class' => 'flag dr grid_right'));
						endif;
					endif;
				?>
			</div>
		</div>
		<div class="lazy-share-block clearfix">
  				<div class="js-share {'url':'<?php echo Router::url(array('controller' => 'properties', 'action' => 'view', $property['Property']['slug']), true);?>','title':'<?php echo $property['Property']['title'];?>','id':'<?php echo $property['Property']['id'];?>'}">
					<div class="lazy-share-widget js-init-share-<?php echo $property['Property']['id'];?>">
						<div class="platform facebook" id="fb-newshare-<?php echo $property['Property']['id'];?>"></div>
						<div class="platform twitter" id="tweet-newshare-<?php echo $property['Property']['id'];?>"></div>
						<div class="platform linked-in" id="linkedin-newshare-<?php echo $property['Property']['id'];?>"></div>
						<div class="platform google-plus" id="gplus-newshare-<?php echo $property['Property']['id'];?>"></div>
					</div>
				</div>
    	</div>
		<div class="js-tabs clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix menu-tabs">
							<li><?php echo $this->Html->link(__l('Photos'), '#photo-1', array('title' => __l('Photos')));?></li>
							<?php if(!empty($property['Property']['video_url'])): ?>
							<li><?php echo $this->Html->link(__l('Video'),  '#video-1', array('title' => __l('Video')));?></li>
							<?php endif; ?>
							<li><?php echo $this->Html->link(__l('Map'), '#map-2', array('title' => __l('Map')));?></li>
							<?php if($property['Property']['street_view'] > ConstStreetView::HideStreetView): ?>
							<li><?php echo $this->Html->link(__l('Street View'),  array('controller' => 'properties', 'action' => 'streetview',$lat,$lng), array('title' => __l('Street View'),'class' =>''));?></li>
							<?php endif; ?>
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
						<div id="map-2" class="ui-corner-right">
							<?php if(!empty($property['Property']['address'])): ?>
								<?php $map_zoom_level = !empty($property['Property']['map_zoom_level']) ? $property['Property']['zoom_level'] : '10';?>
								<a href="http://maps.google.com/maps?q=<?php echo $property['Property']['latitude']; ?>,<?php echo $property['Property']['longitude']; ?>&amp;z=<?php echo $map_zoom_level; ?>" target="_blank"><?php echo $this->Html->image($this->Html->formGooglemap($property['Property'],'648x402'),array('width'=>'648px','height'=>'402px')); ?></a>
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
						<ul class="clearfix menu-tabs">
							<li><?php echo $this->Html->link(__l('Description'), '#tabs-1', array('title' => __l('Description')));?></li>
							<li><?php echo $this->Html->link(__l('Features'), '#feature', array('title' => __l('Features')));?></li>
							<li><?php echo $this->Html->link(__l('Rate Details'), '#rate', array('title' => __l('Rate Details')));?></li>
							<li><?php echo $this->Html->link(__l('House Rules'), '#tabs-2', array('title' => __l('House Rules')));?></li>
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
						<div id="feature" class="ui-corner-right clearfix" >
							<div class="properties-left">
								<div class="clearfix">
    								<h3 class="grid_left"><?php echo __l('Amenities'); ?></h3>
    								<div class="clearfix grid_right">
    									<span class="hide-button hide js-amenities-show"><?php echo __l('Hide'); ?> </span>
    								</div>
								</div>
								<?php if(!empty($amenities_list)) { ?>
									<ol class="amenities-list clearfix js-amenity">
										<?php    
											foreach($amenities_list as $key => $amenity) {
												$class='not-allowed';
												foreach($property['Amenity'] as $amen) {
													if ($amen['name']==$amenity) {
														$class='allowed';
													}
												}
										?>
										<?php $amenity_class_name = 'amenities-am-' . $key; ?>
										<li class="clearfix">
											<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
											<span class="<?php echo $amenity_class_name ?>"><?php echo  $this->Html->cText($amenity); ?></span>
										</li>
										<?php } ?>
									</ol>
								<?php } ?>
								<h3> <?php echo __l('Holiday Types'); ?></h3>
								<?php if (!empty($holiday_list)) {?>
									<ol class="amenities-list clearfix">
										<?php
											foreach($holiday_list as $h_key => $holiday) {
												$class='not-allowed';
												foreach($property['HolidayType'] as $holi) {
													if($holi['name']==$holiday) {
														$class='allowed';
													}
												}
										?>
										<li>
											<?php $holiday_class_name = 'amenities-ht-' . $h_key; ?>
											<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
											<span class="<?php echo $holiday_class_name; ?>"><?php echo  $this->Html->cText($holiday); ?></span>
										</li>
										<?php } ?>
									</ol>
								<?php } ?>
							</div>
							<div class="properties-right">
								<div class="detail-block">
									<div class="gryfill-tl">
										<div class="gryfill-tr">
											<div class="gryfill-tblr"></div>
										</div>
									</div>
									<div class="gryfill-m">
										<h5> <?php echo __l('Additional Features'); ?></h5>
										<dl class="clearfix">
											<dt class="db"><?php echo __l('Room Type');?></dt>
											<dd><?php echo $this->Html->cText($property['RoomType']['name']);?></dd>
											<dt class="db"><?php echo __l('Bed Type');?></dt>
											<dd><?php echo $this->Html->cText($property['BedType']['name']);?></dd>
											<dt class="db"><?php echo __l('Accommodates');?></dt>
											<dd><?php echo $this->Html->cInt($property['Property']['accommodates']);?></dd>
											<dt class="db"><?php echo __l('Bed rooms');?></dt>
											<dd><?php echo $this->Html->cInt($property['Property']['bed_rooms']);?></dd>
											<dt class="db"><?php echo __l('Bath rooms');?></dt>
											<dd><?php echo $this->Html->cInt($property['Property']['bath_rooms']);?></dd>
											<?php if (!empty($property['Property']['property_size'])): ?>
											<dt class="db"><?php echo __l('Size');?></dt>
											<?php $measure=(ConstMeasureAction::Squarefeet==$property['Property']['measurement'])?__l('Square Feet'):__l('Square Meters'); ?>
											<dd><?php echo $this->Html->cInt($property['Property']['property_size']).' '.$this->Html->cText($measure,false);?></dd>
											<?php endif; ?>
											<dt class="db"><?php echo __l('Pets allowed');?></dt>
											<?php $allowed=($property['Property']['is_pets'])?__l('Yes'):__l('No'); ?>
											<dd><?php echo $this->Html->cText($allowed);?></dd>
										</dl>
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
										<dt class="db"><?php echo __l('Price per night');?></dt>
										<dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']);?></dd>
										<dt class="db"><?php echo __l('Price per week');?></dt>
										<dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);?></dd>
										<dt class="db"><?php echo __l('Price per month');?></dt>
										<dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);?></dd>
										<dt class="db"><?php echo __l('Extra people');?></dt>
										<?php if($property['Property']['additional_guest_price']>0): ?>
										<dd><?php echo $this->Html->siteCurrencyFormat($property['Property']['additional_guest_price']);?><?php echo ' ' . __l('per night after') . ' ' . $this->Html->cInt($property['Property']['additional_guest']) . ' ' . __l('guest');?></dd>
										<?php else: ?>
										<dd><?php echo __l('No Additional Cost'); ?> </dd>
										<?php endif; ?>
										<dt class="db"><?php echo __l('Minimum Stay');?></dt>
										<dd><?php echo $this->Html->cInt($property['Property']['minimum_nights']) . ' ' . __l('nights');?></dd>
										<dt class="db"><?php echo __l('Maximum Stay');?></dt>
										<dd><?php echo ($property['Property']['maximum_nights'])?$this->Html->cInt($property['Property']['maximum_nights']) . ' ' . __l('nights') : __l('No Maximum');?></dd>
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


		<div class="js-tabs clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix menu-tabs">
							<li><?php echo $this->Html->link(__l('Nearby Properties'), '#nearby_property', array('title' => __l('Nearby Properties')));?></li>
							<?php if(Configure::read('property.is_show_twitter_around')) : ?>
							<li><?php echo $this->Html->link(__l('Tweets Around '), array('controller' => 'properties', 'action' => 'tweet_around',$lat,$lng), array('title' => __l('Tweets Arround')));?></li>
							<?php endif; ?>
							<?php if(Configure::read('property.is_show_flickr')) : ?>
							<li><?php echo $this->Html->link(__l('Flickr'), array('controller' => 'properties', 'action' => 'flickr',$lat,$lng), array('title' => __l('Flickr')));?></li>
							<?php endif; ?>
							<?php if(Configure::read('property.is_show_weather')) : ?>
							<li><?php echo $this->Html->link(__l('Weather'), array('controller' => 'properties', 'action' => 'weather_data', $property['City']['name']), array('title' => __l('Weather'),'class'=>""));?></li>
							<?php endif; ?>
							<?php if(Configure::read('property.is_show_amenities_around')) : ?>
							<li><?php echo $this->Html->link(__l('Amenities Around'), array('controller' => 'properties', 'action' => 'amenities_around',$lat,$lng), array('title' => __l('Amenity Map')));?></li>
							<?php endif; ?>
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
								echo $this->element('property-index', array('config' => 'sec','property_id' => $property['Property']['id'],'city_id' =>$property['City']['id'],'hash'=>$hash,'salt'=>$salt,'type'=>'similar','limit'=>5));
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
		<div class="js-tabs  clearfix">
			<div class="pptab-menu-left">
				<div class="pptab-menu-right">
					<div class="pptab-menu-center clearfix">
						<ul class="clearfix menu-tabs">
							<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'properties', 'action' => 'review_index','property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('Reviews')));?></li>
							<li><?php echo $this->Html->link(__l('Recommendations'), array('controller' => 'user_comments', 'action' => 'index', $property['User']['username']), array('title' => __l('Top comments')));?></li>
							<li><?php echo $this->Html->link(__l('Other Property Reviews'), array('controller' => 'property_feedbacks', 'action' => 'index','user_id'=>$property['Property']['user_id'],'property_id' =>$property['Property']['id'],'type'=>'property','view'=>'compact'), array('title' => __l('All users')));?></li>
							<?php if(Configure::read('friend.is_enabled')){?>
							<li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'index','user'=>$property['Property']['user_id'],'type'=>'user','view'=>'compact'), array('title' => __l('Friends')));?></li>
							<?php } ?>
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
								<ul class="clearfix menu-tabs admin-property-menu">
									<li><?php echo $this->Html->link(__l('Action'), '#admin-action'); ?></li>
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
		 <div id="admin-action">
		 <ul class="action-link action-link-view clearfix">
			<?php if(empty($property['Property']['is_deleted'])):?>
				<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
				<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Disappear property from user side')));?></li>
				<?php if($property['Property']['is_system_flagged']):?>

					<?php if($property['User']['is_active']):?>
						<li>	<?php echo $this->Html->link(__l('Deactivate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'deactivate'), array('class' => 'js-admin-update-property deactive-user', 'title' => __l('Deactivate user')));?>
					</li>
					<?php else:?>
							<li><?php echo $this->Html->link(__l('Activate User'), array('controller' => 'users', 'action' => 'admin_update_status', $property['User']['id'], 'status' => 'activate'), array('class' => 'js-admin-update-property active-user', 'title' => __l('Activate user')));?>
							</li>
					<?php endif;?>

				<?php endif;?>
				<?php if($property['Property']['is_featured']):?>
					<li>	<?php echo $this->Html->link(__l('Not Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'deactivate'), array('class' => 'js-admin-update-property js-unfeatured not-featured', 'title' => __l('Not Featured')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link(__l('Featured'), array('action' => 'admin_update_status', $property['Property']['id'], 'featured' => 'activate'), array('class' => 'js-admin-update-property js-featured featured', 'title' => __l('Featured')));?>
					</li>
				<?php endif;?>

					<?php if($property['Property']['is_system_flagged']):?>
						<li>	<?php echo $this->Html->link(__l('Clear flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'deactivate'), array('class' => 'js-admin-update-property js-unflag clear-flag', 'title' => __l('Clear flag')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Flag'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'active'), array('class' => 'js-admin-update-property js-flag flag', 'title' => __l('Flag')));?>
						</li>
					<?php endif;?>
					<?php if($property['Property']['admin_suspend']):?>
							<li><?php echo $this->Html->link(__l('Unsuspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'unsuspend'), array('class' => 'js-admin-update-property  js-unsuspend unsuspend', 'title' => __l('Unsuspend')));?>
						</li>
					<?php else:?>
						<li>	<?php echo $this->Html->link(__l('Suspend'), array('action' => 'admin_update_status', $property['Property']['id'], 'flag' => 'suspend'), array('class' => 'js-admin-update-property js-suspend suspend', 'title' => __l('Suspend')));?>
					</li>
					<?php endif;?>
				<?php else:?>
					<li><?php echo $this->Html->link(__l('Permanent Delete'), array('action' => 'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Permanent Delete')));?>
                    </li>

				<?php endif; ?>
				<li><?php echo $this->Html->link((($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), array('action' => 'admin_update_status',  $property['Property']['id'], 'status' => (($property['Property']['is_approved']) ? 'disapproved' : 'approved')), array('title' => (($property['Property']['is_approved']) ? __l('Disapprove') : __l('Approve')), 'class' => (( $property['Property']['is_approved']) ? 'js-admin-update-property js-pending pending' : 'js-admin-update-property js-approve approve'))); ?></li>
				<?php if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 2):?>
					<li><?php echo $this->Html->link(__l('Waiting for verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'active'), array('class' => 'js-admin-update-property  unsuspend', 'title' => __l('Waiting for verify')));?></li>
				<?php elseif(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified'] == 1):?>
					<li><?php echo $this->Html->link(__l('Clear verify'), array('action' => 'admin_update_status', $property['Property']['id'], 'verify' => 'deactivate'), array('class' => 'js-admin-update-property clear', 'title' => __l('Clear verify')));?></li>
				<?php endif;?>
					<?php if($property['Property']['is_show_in_home_page']):?>
					<li>	<?php echo $this->Html->link(__l('Hide in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'deactivate'), array('class' => 'js-admin-update-property hide-home-page', 'title' => __l('Hide in home page')));?>
					</li>
				<?php else:?>
					<li>	<?php echo $this->Html->link(__l('Show in home page'), array('action' => 'admin_update_status', $property['Property']['id'], 'show' => 'activate'), array('class' => 'js-admin-update-property show-home-page', 'title' => __l('Show in home page')));?>
					</li>
				<?php endif;?>
			   </ul>
		</div>
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
										for($i=1;$i<= $property['Property']['accommodates'];$i++) {
											if($i == $property['Property']['accommodates']) {
												$num_array[$i]=$i . '+';
											} else {
												$num_array[$i]=$i;
											}
										}
										$properties_prices['price_per_night']='<span class="clearfix city-price1 dc">'.'<sub class="tb">'. Configure::read('site.currency').'</sub>'.'<span class="cr tb">'.$this->Html->siteWithCurrencyFormat($property['Property']['price_per_night']).'</span>'.'<span class="price-info">'.__l('per night')."</span></span><span  style='clear:both;display:block;'></span>";
										if(!empty($property['Property']['price_per_week']) && $property['Property']['price_per_week']!=0) {
											$properties_prices['price_per_week']='<span class="clearfix city-price1 dc"><span class="price-amount tb dc sfont">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_week']).'</span>'.'<span class="price-info dl">'.__l('per week')."</span></span>";
										} else {
											$properties_prices['price_per_week']='<span class="clearfix city-price1 dc"><span class="price-amount tb dc sfont">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7).'</span>'.'<span class="price-info dl">'.__l('per week')."</span></span>";
										}
										if (!empty($property['Property']['price_per_month'])&& $property['Property']['price_per_month']!=0) {
											$properties_prices['price_per_month']= '<span class="clearfix dc city-price1"><span class="price-amount tb dc sfont">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_month']).'</span>'.'<span class="price-info dl">'.__l('per month')."</span></span>";
										} else {
											$properties_prices['price_per_month']= '<span class="clearfix dc city-price1"><span class="price-amount tb tb dc sfont">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30).'</span>'.'<span class="price-info dl">'.__l('per month')."</span></span>";
											$properties_prices['price_per_month']= '<span class="clearfix dc city-price1"><span class="price-amount tb dc sfont">'. $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30).'</span>'.'<span class="price-info dl">'.__l('per month')."</span></span>";
										}
										echo $this->Form->input('property_id',array('type'=>'hidden'));
										echo $this->Form->input('property_slug',array('type'=>'hidden'));
										echo $this->Form->input('price',array('type'=>'hidden'));
									?>
									<div class="booking-option-block clearfix">
										<?php echo $this->Form->radio('booking_option', $properties_prices, array("legend" => false, "class" => "js-price-list")); ?>
									</div>
									<div class="clearfix show-calender dr">
                                         <span class="js-show-calendar"><?php echo __l('Calendar'); ?></span> / <span class="js-show-dropdown"><?php echo __l('Dropdown'); ?></span>
                                    </div>
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
									<div class="full-calendar dr js-calender-form-calender">
										<?php 
											echo $this->Html->link(__l('Check in/Check out dates are not in this month? Select both dates'), array('controller' => 'properties', 'action' => 'calendar', 'guest_list', 'ids' =>  $property['Property']['id']), array('title'=> __l('Check in/Check out dates are not in this month? Select both dates'), 'escape' => false, 'class' => 'js-guest_list_calender_opening')); 
										?>
									</div>
									<div class="guest-info">
    									<?php echo $this->Form->input('guests',array('label' => __l('Guests'), 'type'=>'select','options'=>$num_array)); ?>
    									<!-- @todo "Guest details" -->
                                    </div>
									<?php if(isset($this->request->params['named']['cityname'])): ?>
										<?php echo $this->Form->input('original_search_address',array('type'=>'hidden','value'=>$this->request->params['named']['cityname'])); ?>
									<?php endif; ?>
								</div>
								<div class="js-price-details-response js-highlight">
									<div class="condition-block">
										<h3><?php echo __l('Price Details');?></h3>
										<p id="js-checkinout-date"></p>
										<dl class="condition-list clearfix js-price-for-product {'per_night': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_night'],false);?>', 'per_week': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_week'],false);?>', 'per_month': '<?php echo $this->Html->siteWithCurrencyFormat($property['Property']['price_per_month'],false);?>' , 'additional_guest_price': '<?php echo $property['Property']['additional_guest_price'];?>', 'property_commission_amount': '<?php echo Configure::read('property.booking_service_fee');?>', 'additional_guest': '<?php echo $property['Property']['additional_guest'];?>'}">
											<dt><?php echo __l('No. of nights');?></dt>
												<dd class="js-property-no_day-night dl tb"><?php echo $this->Html->cInt($property['Property']['minimum_nights']); ?></dd>
											<dt><?php echo __l('Price');?></dt>
												<dd class="dl tb"><?php echo Configure::read('site.currency'); ?><span class="js-property-per-night-amount">0</span></dd>
											<dt><?php echo __l('Additional Guest Prices ');?><span class="js-no_of_guest-price"></span></dt>
												<dd class="dl tb"><?php echo Configure::read('site.currency'); ?><span class="js-property-guest-amount">0</span></dd>
											<dt><?php echo __l('Sub Total');?></dt>
												<dd class="dl tb"><?php echo Configure::read('site.currency'); ?><span class="js-property-subtotal-amount">0</span></dd>
											<dt><?php echo __l('Service Tax');?></dt>
												<dd class="dl tb"><?php echo Configure::read('site.currency'); ?><span class="js-property-servicetax-amount">0</span></dd>
											<?php if (Configure::read('property.is_enable_security_deposit')): ?>
												<dt><?php echo __l('Security Deposit');?><span class="refundable sfont round-3"><?php echo __l('Refundable'); ?></span></dt>
												<dd class="dl tb"><?php echo Configure::read('site.currency'); ?><span class="js-property-desposit-amount"><?php echo $this->Html->siteWithCurrencyFormat($property['Property']['security_deposit'],false); ?></span><span title="<?php echo __l('Ths deposit is for security purpose. When host raise any dispute on property damage, this amount may be used for compensation. So, total refund is limited to proper stay and booking cancellation/rejection/expiration. Note that site decision on this is final.'); ?>" class="info">&nbsp;</span></dd>
											<?php endif; ?>
										</dl>
									</div>
									<div class="condition-block">
										<dl class="condition-list clearfix">
											<dt class="total"><?php echo __l('Total');?></dt>
											<dd class="total dl tb"><?php echo Configure::read('site.currency'); ?> <span class="js-property-total-amount">0</span></dd>
										</dl>
									</div>
								</div>
								<?php if($property['Property']['is_active'] && $property['Property']['is_approved']) { ?>
								<div class="clearfix">
									<?php echo $this->Form->submit(__l('Book it!')); ?>
								</div>
								<?php } if (!empty($property['Property']['is_negotiable']) && !empty($property['Property']['is_active']) && !empty($property['Property']['is_approved'])): ?>
									<div class="negotiate-block clearfix">
										<div class="clearfix negotiate-contact-block dr tb ">
											<span class="btn-or"><?php echo __l('or'); ?></span>

											<div class="clearfix"><div class="cancel-block"><?php echo $this->Form->submit(__l('Contact'), array('name' => 'data[PropertyUser][contact]', 'div' => false , 'class' => 'contact-link')); ?></div>
											</div>
											<div class="clearfix for-info">
												<span class="info sfont"><?php echo __l('For pricing negotiation');?></span>
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
										<dl class="condition-list condition-list1 no-pad clearfix">
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
												<dd class="clearfix dl tb"><?php echo $this->Html->cText($property['CancellationPolicy']['name']); ?> <span class="info" title="<?php echo sprintf(__l('%s refund %s day(s) prior to arrival, except fees'), $percentage, $this->Html->cText($property['CancellationPolicy']['days'], false)); ?>">&nbsp;</span></dd>
										<?php } ?>
											<dt><?php echo __l('Min nights'); ?></dt>
												<dd class="dl tb"><?php echo $this->Html->cInt($property['Property']['minimum_nights']); ?></dd>
											<dt><?php echo __l('Max nights'); ?></dt>
												<dd class="dl tb"><?php echo ($property['Property']['maximum_nights'] == 0) ? __l('No Maximum') : $this->Html->cInt($property['Property']['maximum_nights']); ?></dd>
											<dt><?php echo __l('Max Guests'); ?></dt>
												<dd class="dl tb"><?php echo $this->Html->cInt($property['Property']['accommodates']); ?></dd>
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
										'username' => $property['User']['username'],
										'user_type_id' =>  $property['User']['user_type_id'],
										'id' =>  $property['User']['id'],
										'fb_user_id' =>  $property['User']['fb_user_id']
									);
													$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($property['User']['id']);
													echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb'); 
								?>
							</div>
							<div class="user-img-block-right grid_left">
								<h4><?php echo $this->Html->link($this->Html->cText($property['User']['username'], false), array('controller' => 'users', 'action' => 'view', $property['User']['username'], 'admin' => false), array('title'=>$this->Html->cText($property['User']['username'], false))); ?></h4>
								<div class="clearfix">
    								<dl class="clearfix posted-list">
    									<dt><?php echo __l('Properties posted'); ?></dt>
    			                        <dd class="tb"><span class="stats-val"><?php echo $this->Html->cInt($property['User']['property_count']);?></span></dd>
    								</dl>
								</div>
							</div>
						</div>
						<div class="clearfix">
					        <dl class="ratings-feedback1 clearfix">
								<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
								<dd class="positive-feedback1">
									<?php echo ($property['User']['positive_feedback_count']); ?>
								</dd>
							</dl>
							<dl class="ratings-feedback1 clearfix">
								<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
								<dd  class="negative-feedback1">
									<?php echo ($property['User']['property_feedback_count'] - $property['User']['positive_feedback_count']); ?>
								</dd>
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
									<dd class="success-rate"><span class="stats-val"><?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=00FF00|FF0000&amp;chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?></span></dd>
								<?php endif; ?>
							</dl>
						</div>
						<?php if($this->Auth->user('id')!= $property['Property']['user_id']) : ?>
							<div class="view-contact-link clearfix">
								<div class="cancel-block">
									<?php echo $this->Html->link(__l('Contact Me'), array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $property['Property']['slug']), array('title' => __l('Contact'), 'class' => 'dc'));?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-bl clearfix">
			<div class="pptview-mblock-br clearfix">
				<div class="pptview-mblock-bb clearfix"></div>
			</div>
		</div>
	</div>
<?php if ($this->Auth->user('id') && $this->Auth->user('id') != $property['Property']['user_id']): ?>
	<div class="rightbox">
		<div class="block2-tl clearfix">
			<div class="block2-tr clearfix">
				<div class="block2-tm clearfix social-network-block">
					<h4 class="grid_left"><?php echo __l('Social Networks');?></h4>
					<?php if ($this->Auth->user('id') != $property['Property']['user_id']): ?>
						<dl class="clearfix request-list1 request-index-list guest network-level grid_right">
							<dt title="<?php echo __l('Network Level'); ?>"></dt>
							<?php if (!$this->Auth->user('is_facebook_friends_fetched')): ?>
							<dd class="network-level dc" title="<?php  echo __l('Connect with Facebook to find your friend level with host'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(!$this->Auth->user('is_show_facebook_friends')): ?>
							<dd class="network-level dc" title="<?php  echo __l('Enable Facebook friends level display in social networks page'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(empty($property['User']['is_facebook_friends_fetched'])): ?>
							<dd class="network-level dc" title="<?php  echo __l('Host is not connected with Facebook'); ?>"><?php  echo '?'; ?></dd>
							<?php elseif(!empty($network_level[$property['Property']['user_id']])): ?>
							<dd class="network-level dc" title="<?php  echo __l('Network Level'); ?>"><?php  echo $network_level[$property['Property']['user_id']]; ?></dd>
							<?php else: ?>
							<dd class="network-level dc" title="<?php  echo __l('Not available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php endif; ?>
						</dl>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="pptview-mblock-ll clearfix">
			<div class="pptview-mblock-rr clearfix">
				<div class="pptview-mblock-mm similar-block similar-block1 clearfix">
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
											<li class="dc grid_left"><img src="http://graph.facebook.com/<?php echo $common_friend_id; ?>/picture"><br/><?php echo $common_friend_name; ?></li>
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
		<div class="pptview-mblock-bl clearfix">
			<div class="pptview-mblock-br clearfix">
				<div class="pptview-mblock-bb clearfix"></div>
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