<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<h2 class="slider-heading"><?php echo !empty($collections['Collection']['title']) ? $this->Html->cText($collections['Collection']['title'], false) : ''; ?></h2>
<div class="clearfix">
<div class="slider-side1 grid_left">
<div id="photo-1" class="ui-corner-right" style="overflow:hodden;">
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
	<?php if (!empty($properties)): ?>
	<ul id="gallery" class="js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
		<?php foreach($properties As $property) { ?>
		<?php if(isset($property['Attachment'][0])): ?>
			<li>
				<?php echo $this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'medium_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
				<div class="gv-panel-overlay">
                    <div class="clearfix">
                    <div class="clearfix grid_8 omega alpha">
                    <div class="clearfix">
                	<div class="grid_2 user-avatar alpha omega">
                		<?php
							$current_user_details = array(
								'username' => $property['User']['username'],
								'user_type_id' => $property['User']['user_type_id'],
								'id' => $property['User']['id'],
								'fb_user_id' => $property['User']['fb_user_id']
							);
							$current_user_details['UserAvatar'] = array(
								'id' => $property['User']['attachment_id']
							);
							echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
						?>
                	</div>
					<div class="clearfix home-info-block grid_7 omega alpha">
					<h3>
						<?php
						echo $this->Html->link($this->Text->truncate($property['Property']['title'],35,array('ending' => '...','exact' => false)), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false),array('title'=>$this->Html->cText($property['Property']['title'], false)));
						?>
					</h3>
					 <p class="address-info">
            			<?php if(!empty($property['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
            			<?php echo $this->Text->truncate($property['Property']['address'], 40, array('ending' => '...', 'exact' => false));?>
	               	</p>
	               		</div>
	               		</div>
	               		
					<div class="clearfix grid_7 omega alpha">
						<dl class="request-list1 view-list1 guest clearfix">
							<dt class="positive-feedback1" title ="<?php echo __l('Views');?>"><?php echo __l('Views');?></dt>
							<dd class="positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}"><?php  echo $this->Html->cInt($property['Property']['property_view_count']); ?></dd>
						</dl>
						<dl class="ratings-feedback1 clearfix">
							<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
							<dd class="positive-feedback1"><?php  echo $this->Html->cInt($property['Property']['positive_feedback_count']); ?></dd>
						</dl>
						<dl class="ratings-feedback1 clearfix">
							<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
							<dd  class="negative-feedback1"><?php  echo $this->Html->cInt($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?></dd>
						</dl>
						<dl class="clearfix guest request-list1 success-rate-list">
    						<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
							<?php if($property['Property']['property_feedback_count'] == 0): ?>
								<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
							<dd class="success-rating">
                               <?php
										if(!empty($property['Property']['positive_feedback_count'])):
										$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width' => '50px', 'height' => '50px', 'class' => 'js-skip-gallery', 'title' => $positive.'%')); ?>
							</dd>
							<?php endif; ?>
    					</dl>

					</div>
					</div>
				
					<div class="city-price grid_4 grid_right omega alpha">
            		   <div class="clearfix grid_right city-price1">
							  <?php if(configure::read('site.currency_symbol_place')=='left'): ?>
							  <sub><?php echo configure::read('site.currency'); ?></sub>
							  <?php endif; ?>
                              <?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
							  <?php if(configure::read('site.currency_symbol_place')=='right'): ?>
							  <sub><?php echo configure::read('site.currency'); ?></sub>
							  <?php endif; ?>
                              <p class="">
                              <?php echo __l('Per night');?>
                              </p>
              				  </div>
				   </div>
                </div>
				</div>
			</li>
			<?php endif; ?>
		<?php } ?>
	</ul>
	<?php endif; ?>
</div>
</div>
<div class="slider-side2 grid_10">
    <div class="block2 categories">
         <div class="pptview-mblock-tl">
        	   <div class="pptview-mblock-tr">
                    <div class="pptview-mblock-tt"></div>
                </div>
          </div>
            <div class="pptview-mblock-ll">
             <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
              
                <div class="clearfix collection-left-block">
				  <dl class="request-list1 view-list1 collection-list guest clearfix">
                      <dt class="properties" title ="<?php echo __l('Properties');?>">
                      <?php echo __l('Properties');?></dt>
                      <dd class="positive-feedback1">
                      <?php echo !empty($property_count) ? $this->Html->cInt($property_count, false) : 0; ?>
                      </dd>
                  </dl>
               
				  <!-- @todo "Collection city count, country count update" -->
				  <dl class="request-list1 view-list1 collection-list guest clearfix">
				  <dt class="positive-feedback1 cities" title ="<?php echo __l('Cities');?>">
					  <?php echo __l('Cities');?></dt>
					  <dd class="positive-feedback1">
					 <?php echo !empty($city_count) ? $this->Html->cInt($city_count, false) : 0; ?>
					  </dd>
                  </dl>
				   <dl class="request-list1 view-list1 collection-list guest clearfix">
				  <dt class="countries" title ="<?php echo __l('Countries');?>">
					  <?php echo __l('Countries');?></dt>
					  <dd class="positive-feedback1">
					<?php echo !empty($country_count) ? $this->Html->cInt($country_count, false) : 0; ?>
					  </dd>
                  </dl>
                  </div>
                  <div class="collection-view-inner-block">
                <?php echo $this->Html->cText($property['Property']['description']);?>
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


			  <div class="block2 categories">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    <h4 class="slider-heading"><?php echo __l('Share this collection'); ?></h4>
                     <a title="Header Minus" class="" href="#">Header Minus</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-propertyType-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">

				 <?php
						$slug = !empty($this->request->params['named']['slug']) ? $this->request->params['named']['slug'] : (!empty($search_keyword['named']['slug']) ? $search_keyword['named']['slug'] : '');
						$embed_url = Router::url('/',true).'collection/'. $slug;
						echo $this->Form->input('share_collection_url', array('class' => 'clipboard', 'readonly' => 'readonly', 'label' => false, 'value' => $embed_url));
					?>
				  
				  <?php
					// Twitter
						$tw_url = $embed_url;
						$tw_url =$tw_url;
						$tw_message =  !empty($collections['Collection']['title']) ? $collections['Collection']['title'] : '';
						//$tw_message = urlencode_rfc3986($tw_message);
						// Facebook
						$fb_status = $embed_url;
						$fb_status = $fb_status;
?>
    <div class="share-link-block grid_left">
        <div class="clearfix">
          <ul class="share-link1 clearfix">
            <li class="twitter"><a href="http://twitter.com/share?url=<?php echo $tw_url;?>&amp;text=<?php echo $tw_message;?>&amp;via=<?php echo Configure::read('twitter.site_username');?>&amp;lang=en" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
              <li class="facebook">
                <fb:like href="<?php echo $fb_status;?>" layout="button_count" width="50" height="40" action="like"></fb:like>
              </li>

            </ul>
        </div>
            </div>
            </div>
            </div>
			 </div>
          <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
			  
			  
			  
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