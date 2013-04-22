<?php /* SVN: $Id: $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>

<div class="requests view clearfix">

<div class="grid_17 side1">
<div class="clearfix">
    <h2 class="request-title">
	 <?php
        if($this->Auth->sessionValid()):
        	if(!empty($request['RequestFavorite'])):
        		foreach($request['RequestFavorite'] as $favorite):
        			if($request['Request']['id'] == $favorite['request_id'] && $favorite['user_id'] == $this->Auth->user('id')):
						if($this->Auth->user('id')!=$request['Request']['user_id']):
							 echo $this->Html->link(__l('Unlike'), array('controller' => 'request_favorites', 'action'=>'delete', $request['Request']['slug']), array('class' => 'js-like un-like', 'title' => __l('Unlike')));
					    else:
						 echo $this->Html->link(__l('Unlike'), '#', array('class' => 'un-like', 'title' => __l('Unlike')));
						endif;
					
        			endif;
        		endforeach;
        	else:
			  if($this->Auth->user('id')!=$request['Request']['user_id']):
        		echo $this->Html->link(__l('Like'), array('controller' => 'request_favorites', 'action' => 'add', $request['Request']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like like'));
			  else:
			  echo $this->Html->link(__l('Like'), '#', array('title' => __l('Like'),'escape' => false ,'class' =>'like'));
			  endif;
        	endif;

        endif;
        ?>
    <?php echo $this->Html->cText($request['Request']['title']); ?></h2>
	<?php  if(!empty($this->request->params['pass'][1]) &&  !empty($this->request->params['pass'][2]) && $distance_view) : ?>
				<div class="hovst-view-block page-information clearfix">
					<dl class="request-list1 host-view guest clearfix">
						<dt title ="<?php echo __l('Distance');?>"><?php echo __l('Distance (km)');?></dt>
						<dd><?php echo $this->Html->cInt($this->Html->distance($this->request->params['named']['latitude'],$this->request->params['named']['longitude'],$request['Request']['latitude'],$request['Request']['longitude'],'K')); ?></dd>
					</dl>
					<div class="city-info grid_left">
						<?php echo __l('from') . ' ' . $this->request->params['named']['cityname'];?>
					</div>
				</div>
			<?php endif; ?>
     <div class="tripped-address">
	        <address> 
				<?php if(!empty($request['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($request['Country']['iso2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
				<?php endif; ?>
				<?php 
					if(empty($request['Request']['address'])) {
						echo $this->Html->cText($request['City']['name']);?>, <?php echo $this->Html->cText($request['State']['name']);?>,<?php echo $this->Html->cText($request['Country']['name']);
					} else {
						echo $this->Html->cText($request['Request']['address']);
					}
				?>
			</address>
     </div>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
     <div class="clearfix js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}">
            <dl class=" count-list  clearfix">
    		  <dt><?php echo __l('Posted'); ?></dt>
    		  <dd><?php echo $this->Time->timeAgoInWords($request['Request']['created']); ?>

    		  </dl>
  			<dl class="request-list1 guest count-list1 clearfix">
				  <dt><?php echo __l('Views'); ?></dt>
			   <dd class="js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo  $this->Html->cInt($request['Request']['request_view_count']); ?>  </dd>
			</dl>
			  <dl class="request-list1 guest count-list1 clearfix">
				  <dt><?php echo __l('Offered'); ?></dt>
				  <dd><?php echo $this->Html->cInt($request['Request']['property_count']);?></dd>
			  </dl>
				<dl class="request-list1 days count-list1 clearfix">
					  <dt><?php echo __l('Days'); ?></dt>
				   <dd>
						<?php
							$days = ((strtotime($request['Request']['checkout']) -strtotime($request['Request']['checkin'])) / (60*60*24)) + 1;
							echo  $this->Html->cInt($days);
						?>
				   </dd>
				</dl>
		
		<div class="share-link-block grid_right">
		<div class="clearfix">
		<?php
	// Twitter
	$tw_url = Router::url(array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), true);
	$tw_url =$tw_url;
	$tw_message = $request['Request']['title'];
	//$tw_message = urlencode_rfc3986($tw_message);
	// Facebook
	$fb_status = Router::url(array('controller' => 'requests', 'action' => 'view', $request['Request']['slug']), true);
	$fb_status = $fb_status;
?>
            <ul class="share-link1">
            	<li class="twitter"><a href="http://twitter.com/share?url=<?php echo $tw_url;?>&amp;text=<?php echo $tw_message;?>&amp;via=<?php echo Configure::read('twitter.site_username');?>&amp;lang=en" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
        	<li class="facebook">
        	<fb:like href="<?php echo $fb_status;?>" layout="button_count" width="50" height="40" action="like"></fb:like>
        	</li>
        
        </ul>
        </div>
		<?php 
		if (Configure::read('request.is_allow_request_flag')):
			if ($this->Auth->user('id')):
				if($request['Request']['user_id'] != $this->Auth->user('id')) :
        			echo $this->Html->link(__l('Flag this request'), array('controller' => 'request_flags', 'action' => 'add', $request['Request']['id']), array('title' => __l('Flag this request'),'escape' => false ,'class' =>'flag js-thickbox'));
				endif;
			else :
				echo $this->Html->link(__l('Flag this request'), array('controller' => 'users', 'action' => 'login', '?' => 'f=request/' . $request['Request']['slug'], 'admin' => false), array( 'title' => __l('Flag this request'), 'class' => 'flag'));
			 endif;

		endif;


?>
        
        
        </div>
        
	
	
		</div>

</div>
<div class="js-tabs clearfix">
    <div class="pptab-menu-left">
    <div class="pptab-menu-right">
        <div class="pptab-menu-center">
        	<ul class="clearfix">
        		<li><?php echo $this->Html->link(__l('Description'), '#tabs-1', array('title' => __l('Description')));?></li>
        		<li><?php echo $this->Html->link(__l('Trip Details'), '#tabs-2', array('title' => __l('Trip Details')));?></li>
        	</ul>
	   </div>
	   </div>
	</div>
	<div class="pptview-mblock-ll">
        <div class="pptview-mblock-rr">
            <div class="pptview-mblock-mm clearfix">
                <div id="tabs-1" class="ui-corner-right clearfix" >
            	   <div class="grid_15 alpha omega">
            	       <?php echo $this->Html->cText($request['Request']['description']);?>
            	   </div>
            	</div>
            	<div id="tabs-2" class="ui-corner-right clearfix" >
            	          <div class="detail-block">
                    <div class="gryfill-tl">
                    <div class="gryfill-tr">
                        <div class="gryfill-tblr"></div>
                        </div>
                   </div>
				   <div class="gryfill-m">
						<dl class="clearfix">
							<dt><?php echo __l('Property Type'); ?></dt>
							<dd><?php echo !empty($request['PropertyType']['name']) ? $request['PropertyType']['name'] : __l('Any Type'); ?></dd>
						</dl>
						<dl class="clearfix">
							<dt><?php echo __l('Room Type'); ?></dt>
							<dd><?php echo $request['RoomType']['name']; ?></dd>
						</dl>
						<dl class="clearfix">
							<dt><?php echo __l('Bed Type'); ?></dt>
							<dd><?php echo $request['BedType']['name']; ?></dd>
						</dl>
						<dl class="clearfix">
							<dt><?php echo __l('Accomodates'); ?></dt>
							<dd><?php echo $request['Request']['accommodates']; ?></dd>
						</dl>
                  </div>
		      	<div class="gryfill-bl">
		      	 <div class="gryfill-br">
                    <div class="gryfill-tblr"></div>
                   </div>
                  </div>
                  </div>
                    <div class="grid_17 alpha omega">
                        <div class="clearfix" id="feature">
                               <h5> <?php echo __l('Amenities'); ?></h5>
				<div class="clearfix">
<span class="hide-button hide js-amenities-show"><?php echo __l('Hide'); ?> </span>
</div>
                <?php  if(!empty($amenities_list)){
                	?>
                			<ol class="amenities-list clearfix">
                			<?php
                				foreach($amenities_list as $key => $amenity) {
                					$class='not-allowed';
                					foreach($request['Amenity'] as $amen) {
                						if($amen['name']==$amenity)
                						{
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
                           <?php }?>
						   <h5> <?php echo __l('Holiday Types'); ?></h5>

<?php  if(!empty($holiday_list)){?>
			<ol class="amenities-list clearfix">
            <?php    foreach($holiday_list as $h_key => $holiday){
    			$class='not-allowed';
    			foreach($request['HolidayType'] as $holi)
    			{
    				if($holi['name']==$holiday)
    				{
    					$class='allowed';
    				}
    			}
    		?>
            <li>
            <?php $holiday_class_name = 'amenities-ht-' . $h_key; ?>
			<span class="<?php echo $class; ?>" title ="<?php echo ($class == 'allowed') ? __l('Yes') : __l('No'); ?>"><?php echo ($class == 'allowed') ? __l('Yes') : __l('No');?></span>
			<span class="<?php echo $holiday_class_name; ?>"><?php echo  $this->Html->cText($holiday); ?></span>
			</li>
            <?php }?>
			</ol>
           <?php }?>
    		            
                        </div>
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
   <div class="js-tabs  clearfix">
     <div class="pptab-menu-left">
     <div class="pptab-menu-right">
       <div class="pptab-menu-center clearfix">
            <ul class="clearfix">
                <li><?php echo $this->Html->link(__l('Related Requests'), array('controller' => 'requests', 'action' => 'index', 'type' => 'related', 'request_id' => $request['Request']['id'], 'view' => 'compact'), array('title' => __l('Related Requests')));?></li>
                <li><?php echo $this->Html->link(__l('Other Request by ').$request['User']['username'], array('controller' => 'requests', 'action' => 'index', 'user_id' => $request['User']['id'], 'type' => 'other', 'request_id' => $request['Request']['id'], 'view' => 'compact'), array('title' => __l('Other Request by ').$request['User']['username']));?></li>
            </ul>
        </div>
	 </div>
 	</div>
     <div class="pptview-mblock-ll">
        <div class="pptview-mblock-rr">
          <div class="pptview-mblock-mm clearfix">
    <div id="Related_Requests"></div>
    <div id="Other_Request_by"></div>
  
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

					<ul class="clearfix">
					<li><?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'request_favorites', 'action' => 'index', 'request_id' => $request['Request']['id'], 'simple_view' => 'user_view', 'admin' => true), array('title'=>'Request favorites','escape' => false)); ?></li>
					<li><?php echo $this->Html->link(__l('Request Views'), array('controller' => 'request_views', 'action' => 'index', 'request_id' => $request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Request views','escape' => false)); ?></li>
						<li><?php echo $this->Html->link(__l('Request Flags'), array('controller' => 'request_flags', 'action' => 'index', 'request_id' => $request['Request']['id'], 'view_type' => 'user_view', 'admin' => true), array('title'=>'Request flags','escape' => false)); ?></li>
					</ul>

        </div>
    	</div>
	 	</div>
	     	     <div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">

		<div id="Request_favorites"></div>
		<div id="Request_views"></div>
		<div id="Request_flags"></div>

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
   <div class="side2 grid_7">
    <div class="price-info-block">
         <div class="book-tl">
          <div class="book-tr">
              <div class="book-tm"></div>
             </div>
            </div>
            <div class="book-ll">
                <div class="book-rr">
                    <div class="book-center clearfix">
                        <p class="price-amount">
							<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							 <sub> <?php echo Configure::read('site.currency').' '?></sub>
							 <?php endif; ?>
                                  <?php echo $this->Html->cCurrency($request['Request']['price_per_night']); ?>
							<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
							 <sub> <?php echo Configure::read('site.currency').' '?></sub>
							 <?php endif; ?>
	                   	</p>
						<p class="address-info"><?php echo $this->Html->cDate($request['Request']['checkin']);?><?php echo ' - '; ?><?php echo $this->Html->cDate($request['Request']['checkout']);?></p>
						<div id="js-rangeinline" class="{'checkin':'<?php echo $request['Request']['checkin']; ?>','checkout':'<?php echo $request['Request']['checkout']; ?>'}"></div>
	                   	 	<?php if($request['User']['id']!=$this->Auth->user('id')): ?>
	                   	 	<div class="clearfix make-offerblock">
                                  <div class="cancel-block">
                    				<?php echo $this->Html->link(__l('Make an offer'), array('controller' => 'properties', 'action' => 'add','request',$request['Request']['id'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false)); ?>
                                 </div>
                                </div>
                    	<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="book-bl">
            <div class="book-br">
                  <div class="book-bm"></div>
                  </div>
            </div>
        </div>

         <div class="block2-tl">
              <div class="block2-tr">
                <div class="block2-tm">
                 <h4 class="request-username"><?php echo  __l('Traveler Stats'); ?></h4>
               

                    </div>
                  </div>
                </div>
           <div class="block2-cl">
            <div class="block2-cr">
             <div class="block2-cm clearfix">


<div class="User index">
	<div class="clearfix user-view-blocks">
	<div class="user-img-block-left grid_left">
	  <?php
		$current_user_details = array(
			'username' => $request['User']['username'],
			'user_type_id' => $request['User']['user_type_id'],
			'id' => $request['User']['id'],
			'fb_user_id' => $request['User']['fb_user_id']
		);
		$current_user_details['UserAvatar'] = array(
			'id' => $request['User']['attachment_id']
		);
		echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb');
	 ?>
	 </div>
	<div class="user-img-block-right grid_left">
		<h4> <?php echo $this->Html->link($this->Html->cText($request['User']['username'], false), array('controller' => 'users', 'action' => 'view', $request['User']['username'], 'admin' => false), array('title'=>$this->Html->cText($request['User']['username'], false))); ?>
		</h4>
				<div class="clearfix">
				 <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
                       <?php  echo $this->Html->cInt($request['User']['traveler_positive_feedback_count']); ?>
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
                          <?php  echo $this->Html->cInt($request['User']['traveler_property_user_count'] - $request['User']['traveler_positive_feedback_count']); ?>
                      </dd>
                    </dl>
                   </div>
                   	</div>
                    </div>
				  <div class="clearfix">
				   <dl class="clearfix posted-list success-rate-list">

			    <?php if(($request['User']['traveler_property_user_count']) == 0): ?>
							<dt><?php echo __l('Success Rate'); ?></dt>
							<dd class="not-available"><span class="stats-val"><?php echo  __l('n/a');?></span></dd>
                  <?php else: ?>
							<dt class="success-rate"><?php echo __l('Success Rate'); ?></dt>
							<dd><span class="stats-val">
			<?php if(!empty($request['User']['traveler_positive_feedback_count'])):
										$positive = floor(($request['User']['traveler_positive_feedback_count']/$request['User']['traveler_property_user_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?>                    </dd>
                   <?php endif; ?>
                   </dl>
				   </div>
	<?php if($this->Auth->user('id')!= $request['Request']['user_id']) : ?>
			<div class="view-contact-link clearfix">
				<div class="cancel-block">
					<?php echo $this->Html->link(__l('Contact Me'), array('controller'=>'messages','action'=>'compose','type' => 'contact','slug' => $request['Request']['slug'],'from'=>'request'), array('title' => __l('Contact')));?>
				</div>
			</div>
			<?php endif; ?>


</div>
			</div>
                </div>
            </div>
            <div class="block2-bl">
              <div class="block2-br">
                <div class="block2-bm"> </div>
              </div>
            </div>

<div class="public-stats">
 <div class="block2-tl">
   <div class="block2-tr">
                <div class="block2-tm">
                 <h4 class="request-username"><?php echo __l('Map');?></h4>
                    </div>
                  </div>
                </div>
           <div class="block2-cl">
            <div class="block2-cr">
             <div class="block2-cm clearfix">
    		<?php if(!empty($request['Request']['city_id'])): ?>
			<?php $map_zoom_level = !empty($request['Request']['map_zoom_level']) ? $request['Request']['zoom_level'] : '10';?>
						<?php echo $this->Html->image($this->Html->formGooglemap($request['Request'],'260x224'),array('width'=>'260px','height'=>'224px'));?>
			<?php endif; ?>
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