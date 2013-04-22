<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php 


		 $hash = !empty($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
		 $salt = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
		 $allow=true;
		if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite' || isset($near_by) || (isset($this->request->params['named']['view']) && $this->request->params['named']['view']=='compact') ):
			$allow=false;
		endif; 

?>

<?php
//debug($search_keyword);
$allow=true;
if((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user'  && $this->request->params['named']['type'] != 'favorite' && !isset($near_by)) || empty($this->request->params['named'])) {
//debug($this->request->params);    
//debug($user);    
if($search_keyword){
	$city=isset($search_keyword['named']['cityname'])?$search_keyword['named']['cityname']:'';
	$latitude=isset($search_keyword['named']['latitude'])?$search_keyword['named']['latitude']:'';
	$longitude=isset($search_keyword['named']['longitude'])?$search_keyword['named']['longitude']:'';
	$checkin=isset($search_keyword['named']['checkin'])?$search_keyword['named']['checkin']:'';
	$checkout=isset($search_keyword['named']['checkout'])?$search_keyword['named']['checkout']:'';
	$additional_guest=isset($search_keyword['named']['additional_guest'])?$search_keyword['named']['additional_guest']:'';
	$type=isset($search_keyword['named']['type'])?$search_keyword['named']['type']:'';
	$is_flexible=isset($search_keyword['named']['is_flexible'])?$search_keyword['named']['is_flexible']:'';
	$holidaytype=isset($search_keyword['named']['holidaytype'])?$search_keyword['named']['holidaytype']:'';
	$roomtype=isset($search_keyword['named']['roomtype'])?$search_keyword['named']['roomtype']:'';
	$amenity=isset($search_keyword['named']['amenity'])?$search_keyword['named']['amenity']:'';
	$rangefrom=isset($search_keyword['named']['range_from'])?$search_keyword['named']['range_from']:'1';
	$rangeto=isset($search_keyword['named']['range_to'])?$search_keyword['named']['range_to']:'300+';
	$depositfrom=isset($search_keyword['named']['deposit_from'])?$search_keyword['named']['deposit_from']:'0';
	$depositto=isset($search_keyword['named']['deposit_to'])?$search_keyword['named']['deposit_to']:'300+';
	$keyword=isset($search_keyword['named']['keyword'])?$search_keyword['named']['keyword']:'';
	$cityy=isset($search_keyword['named']['city'])?$search_keyword['named']['city']:'all';
	$min_beds=isset($search_keyword['named']['min_beds'])?$search_keyword['named']['min_beds']:'1';
	$min_bedrooms=isset($search_keyword['named']['min_bedrooms'])?$search_keyword['named']['min_bedrooms']:'1';
	$min_bathrooms=isset($search_keyword['named']['min_bathrooms'])?$search_keyword['named']['min_bathrooms']:'1';
	if(!empty($rangeto))
	{
		$this->request->data['Property']['range_to']=$rangeto;
	}
}else{
    
	$city=isset($this->request->params['named']['cityname'])?$this->request->params['named']['cityname']:'';
	$latitude=isset($this->request->params['named']['latitude'])?$this->request->params['named']['latitude']:'';
	$longitude=isset($this->request->params['named']['longitude'])?$this->request->params['named']['longitude']:'';
	$checkin=isset($this->request->params['named']['checkin'])?$this->request->params['named']['checkin']:'';
	$checkout=isset($this->request->params['named']['checkout'])?$this->request->params['named']['checkout']:'';
	$additional_guest=isset($this->request->params['named']['additional_guest'])?$this->request->params['named']['additional_guest']:'';
	$type=isset($this->request->params['named']['type'])?$this->request->params['named']['type']:'';
	$is_flexible=isset($this->request->params['named']['is_flexible'])?$this->request->params['named']['is_flexible']:'';
	$holidaytype=isset($this->request->params['named']['holidaytype'])?$this->request->params['named']['holidaytype']:'';
	$roomtype=isset($this->request->params['named']['roomtype'])?$this->request->params['named']['roomtype']:'';
	$amenity=isset($this->request->params['named']['amenity'])?$this->request->params['named']['amenity']:'';
	$rangefrom=isset($this->request->params['named']['range_from'])?$this->request->params['named']['range_from']:'1';
	$rangeto=isset($this->request->params['named']['range_to'])?$this->request->params['named']['range_to']:'300+';
	$depositfrom=isset($this->request->params['named']['deposit_from'])?$this->request->params['named']['deposit_from']:'0';
	$depositto=isset($this->request->params['named']['deposit_to'])?$this->request->params['named']['deposit_to']:'300+';
	$keyword=isset($this->request->params['named']['keyword'])?$this->request->params['named']['keyword']:'';
	$cityy=isset($this->request->params['named']['city'])?$this->request->params['named']['city']:'all';
	$min_beds=isset($this->request->params['named']['min_beds'])?$this->request->params['named']['min_beds']:'1';
	$min_bedrooms=isset($this->request->params['named']['min_bedrooms'])?$this->request->params['named']['min_bedrooms']:'1';
	$min_bathrooms=isset($this->request->params['named']['min_bathrooms'])?$this->request->params['named']['min_bathrooms']:'1';

	if(!empty($rangeto))
	{
		$this->request->data['Property']['range_to']=$rangeto;
	}
}
$network_level_arr = array(
	'1' => 'st',
	'2' => 'nd',
	'3' => 'rd',
	'4' => 'th',
);
for($n=1;$n<=Configure::read('property.network_level');$n++) {
	$network_count = !empty($network_property_count[$n]) ? $network_property_count[$n] : 0;
	$networkLevels[$n] = $n . $network_level_arr[$n] . ' ' . __l('level') . ' (' . $network_count . ')';
}
?>
<?php  
if($search=='normal'): ?>
<div class="city-search-block-tl">
    <div class="city-search-block-tr">
      <!--  <div class="city-search-block-tm city-search-block-top clearfix"> -->
			<?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection'): 
				 echo $this->element('slider', array('config' => 'sec','properties' => $properties)); 
			/* elseif($allow): 
		        echo $this->element('search', array('config' => 'sec','type'=>'search')); */ 
		 	endif;  ?>
	  <!--  </div> --> 
    </div>
</div>
<?php endif; ?>


<?php
if((!empty($this->request->params['named']['latitude']) && !empty($this->request->params['named']['longitude'])) || (!empty($search_keyword['named']['latitude']) && !empty($search_keyword['named']['longitude'])))
{
	if(empty($current_latitude))
	{
		$current_latitude=!empty($property['Property']['latitude'])?$property['Property']['latitude']:'';
		$current_longitude=!empty($property['Property']['longitude'])?$property['Property']['longitude']:'';
	}
}
?>
<?php } ?>
<?php if($is_searching): ?>
<?php if($search=='normal'): ?>
<span class="js-search-lat {'cur_lat':'<?php echo $current_latitude; ?>','cur_lng':'<?php echo $current_longitude; ?>'}"></span>
<div class="request-index-block js-request-responses js-responses js-response clearfix <?php if($allow){ ?> properties-index-page <?php } ?>">
<?php endif; ?>
<div class="properties-side1 grid_18" style="float:left !important;">

    <?php
	if((!empty($search_keyword['named']['sw_latitude'])) ): ?>
		<div class="page-information">
			<?php echo __l('Narrow your search to street or at least city level to get better results.'); ?>
		</div>
	<?php endif; ?>
            <div class="block1">
            <div class="block1-tl">
              <div class="block1-tr">
                  <div class="block1-tm property-share-results">

                  <?php if($allow): ?>
                  <div class="sort-block grid_left clearfix">
                     <ul class="sort-list1 grid_left clearfix">
                         <li class="recommended-filter-list clearfix">
                                   <h5 class="sort grid_left"><?php echo __l('Sort by: '); ?></h5>
							
                               	<ul class="recommended-list grid_left clearfix">
									 <?php if((!empty($search_keyword['named']['latitude'])) ): ?>
								<?php $class=((isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='distance') || !isset($this->request->params['named']['sortby']))?'active':''; ?>
                            	<li  class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Distance'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'distance','admin' => false), array('title'=>$this->Html->cText('Distance',false),'escape' => false));	?>	</li>
								<?php endif; ?>
									<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='favorites')?'active':''; ?>

                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Favorites'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'favorites',  'admin' => false), array('title'=>__l('Favorites'),'escape' => false));	?>	</li>
								<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='high')?'active':''; ?>
                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price low to high'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'high',  'admin' => false), array('title'=>__l('Price low to high'),'escape' => false));	?>	</li>
								<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='low')?'active':''; ?>
                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price high to low'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'low', 'admin' => false), array('title'=>__l('Price high to low'),'escape' => false));	?>	</li>
								<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='recent')?'active':''; ?>
                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Recent'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'recent',  'admin' => false), array('title'=>__l('Recent'),'escape' => false));	?>	</li>
								<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='reviews')?'active':''; ?>
                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'reviews',  'admin' => false), array('title'=>__l('Reviews'),'escape' => false));	?>	</li>
								<?php $class=(isset($this->request->params['named']['sortby'])&& $this->request->params['named']['sortby']=='featured')?'active':''; ?>
                            	<li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Featured'), array('controller' => 'properties', 'action' => 'index',$hash,$salt,'sortby' =>'featured',  'admin' => false), array('title'=>__l('Featured'),'escape' => false));	?>	</li>
                            	</ul>
        	           	</li>
                    </ul>
                 <span class="search_results grid_left"><?php echo $this->Html->Cint($total_result); ?> <?php echo __l('results'); ?></span> </div>
				<div class="js-toggle-show-block">
                  <span class="share-results grid_right">
					<a class="js-toggle-show {'container':'js-share-results'}" href="#"><?php echo __l('Share Results'); ?></a>
				  </span>
				</div>
				<div class="js-share-results hide share-results-code">
					<?php
						if(isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection' ) { 
							$slug=isset( $this->request->params['named']['slug'])? $this->request->params['named']['slug']:$search_keyword['named']['slug'];
							$embed_code = Router::url('/',true).'collection/'.$slug;
						} else {
							$embed_code = Router::url(array('controller'=>'properties','action'=>'index',$hash,$salt), true);
						}
						echo $this->Form->input('share_url', array('class' => 'clipboard js-selectall', 'readonly' => 'readonly', 'label' => false, 'value' => $embed_code));
					?>
					<span class="share-close js-share-close"><?php echo __l('Close'); ?></span>
				</div>
				<?php elseif(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='favorite'):?>
    				<h2><?php  echo __l('Liked Properties'); ?></h2>
                      <?php endif; ?>
                  </div>
                
              </div>
            </div>


            
             <div class="block1-cl">
              <div class="block1-cr">
                <div class="block1-cm clearfix">

<?php
$view_count_url = Router::url(array(
	'controller' => 'properties',
	'action' => 'update_view_count',
), true);
?>
<ol class="list property-list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
//debug($properties);
if (!empty($properties)):

$i = 0;
$num=1;
foreach ($properties as $property):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' altrow';
	}

	if($property['Property']['is_featured'])
	{
		$featured_class='featured';
	}
	else
	{
		$featured_class='';
	}
?>
	<li class="<?php echo $class;?> js-map-num<?php echo $num; ?> clearfix">
	<div class="grid_3 thumb">
	 <div class="map_number" ><?php echo $num; ?></div>
	  <?php
		$property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
		echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],$hash, $salt,  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
	 ?>
	 </div>
	<div class="grid_10 alpha omega">
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
	<div class="grid_8 alpha omega">
	<div class="clearfix">
		<h2>
		<?php

		$lat = $property['Property']['latitude'];
		$lng = $property['Property']['longitude'];
		$id = $property['Property']['id'];

		echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], $hash, $salt, 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
		?>
	
		<?php 
			$flexible_class = '';
			 if(isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] ==1 && !empty($search_keyword['named']['latitude']))
			 {
				if(!in_array($property['Property']['id'], $booked_property_ids) && in_array($property['Property']['id'], $exact_ids)) { ?>
					<span class="exact round-3"> <?php echo __l('exact'); ?></span>
		<?php		} }
			if(Configure::read('property.is_property_verification_enabled') && $property['Property']['is_verified']==ConstVerification::Verified):?>
			<span class="isverified"> <?php echo __l('Verified'); ?></span>
		<?php
			endif;
		?>

		<?php		
			if($property['Property']['is_featured']):?>
			<span class="featured round-3 isfeatured"> <?php echo __l('featured'); ?></span>
		<?php
			endif; 
		?>
			</h2>
	</div>
        <p class="address-info">
			<?php if(!empty($property['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
				<?php endif; ?>
			<?php echo $this->Html->cText($property['Property']['address']);?>
		</p>
	 </div>
	</div>
		<div class="clearfix">
    <?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($property[0]['distance'])): ?>
        <dl class="clearfix guest request-list1 ">
			<dt><?php echo __l('Distance');?><span class="km"> <?php echo __l('(km)');?></span></dt>
			<dd><?php echo $this->Html->cInt($property[0]['distance']*1.60934 ,false); ?></dd>
		</dl>
			<?php endif; ?>
					<dl class="request-list1 view-list1 guest clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('View');?>">
                      <?php echo __l('Views');?></dt>
                      <dd class="positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}">
                        <?php  echo $this->Html->cInt($property['Property']['property_view_count']); ?>
                      </dd>
                  </dl>
		           <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
                        <?php  echo $this->Html->cInt($property['Property']['positive_feedback_count']); ?>
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
                            <?php  echo $this->Html->cInt($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>
                      </dd>
                    </dl>
				  <dl class="clearfix request-list1 request-index-list success-rate-list">
    				        <dt  title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success');?><span class="km"> <?php echo __l('Rate');?></span></dt>
                          <?php if(empty($property['Property']['property_feedback_count'])): ?>
					<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
								 <dd class="success-rate">
										<?php if(!empty($property['Property']['positive_feedback_count'])):
										$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?>
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
			</div>
		 </div>
		  <div class="city-price grid_right grid_4 omega alpha">
		  <div class="clearfix edit-info-block">
		  	<div class="rating-block grid_left">
              <div class="rating clearfix">
                <ul class="star-rating">
				<li style="width: 100%;" class="current-rating">
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
				</li>
                    </ul>
                  </div>
                </div>
            <?php if ($property['Property']['user_id'] == $this->Auth->user('id')) : ?>

		<div class="actions clearfix"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $property['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $property['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
        </div>
		   <?php endif; ?>
		   </div>
		   
		   <!-- //***************************** BLOQUE PARA ITEMS *******************************// -->

        	<?php 
			if(!empty($property['PropertiesExtraJoinables'])){
					
				if($property['PropertiesExtraJoinables'][0]['item_price_hour'] != ''){
					$precio = $property['PropertiesExtraJoinables'][0]['item_price_hour'];
				}elseif($property['PropertiesExtraJoinables'][0]['item_price_day'] != ''){
					$precio = $property['PropertiesExtraJoinables'][0]['item_price_day'];
				}elseif($property['PropertiesExtraJoinables'][0]['item_price_week'] != ''){
					$precio = $property['PropertiesExtraJoinables'][0]['item_price_week'];
				}else{
					$precio = 0;
				}
				
				$property['Property']['price_per_night'] = $precio;
			}
				
           	?>
           <!-- //******************************************************************************// -->
		   
		   
		   
		   <div class="city-price grid_4 omega alpha city-price1">
				<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
                 <sub> <?php echo Configure::read('site.currency').' '?></sub>
				 <?php endif; ?>
                  <?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
				<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
                 <sub> <?php echo ' '.Configure::read('site.currency'); ?></sub>
				 <?php endif; ?>
                  <p>
                  <?php //echo __l('Per night');?>
                  </p>
				  </div>
				  <?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='related' ): ?>
					  <?php if($this->Auth->user('id')!=$property['Property']['user_id']): ?>
						  <div class="clearfix">
						 <div class="cancel-block"><?php echo $this->Html->link(__l('Book it!'), array('controller' => 'properties', 'action' => 'view',$property['Property']['slug'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false)); ?></div></div>
					 <?php endif; ?>
				 <?php endif; ?>
         </div>
		
	</li>
<?php
$num++;
    endforeach;
else:
?>

	<li>
		  <?php if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'search'): ?>
			<p class="notice"><?php echo sprintf(__l('No properties available. You may %s on this address for others to respond.'), $this->Html->link(__l('create a request'), array('controller' => 'requests', 'action' => 'add', $hash,$salt,'admin' => false), array('title'=>__l('create a request'))));?></p>
		<?php else: ?>
			<p class="notice"> <?php echo __l('No properties available.'); ?> </p>
		<?php endif; ?>
	</li>

            <?php
            endif;
            ?>
</ol>	
	</li>
</div>
</div>
</div>
 <div class="block2-bl">
              <div class="block2-br">
                <div class="block2-bm"> </div>
              </div>
            </div>
            </div>
<?php
if (!empty($properties)) {

	if(count($properties)>0) {
		//$this->request->params['named'] = array();
	?>
<div class="js-pagination">
<?php
    echo $this->element('paging_links'); ?>
	</div>
<?php
	}
}
?>	
</div>

<?php 

if((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'user' && $this->request->params['named']['type'] != 'related' && !isset($near_by) && $allow) || empty($this->request->params['named']) || (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite')) { 
	
?>

<div class=" grid_6 omega side2 properties-side2">
<?php
	 if(isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite'){ ?>
        <?php echo $this->element('user-stats'); ?>
<?php } else { ?>
	<!--
		<div class="block2-tl">
          <div class="block2-tr">
            <div class="block2-tm">
                  <h4 class="refine"><?php echo __l('Refine'); ?></h4>
                </div>
            </div>
       	</div>
       -->
        <div class="block2-cl">
        <div class="block2-cr">
        	<div class=" clearfix"> <!-- quite el estilo block2-cm de este div por bug, pero puede ser necesario a la hora de usar el request o los filtros  -->
        	
       	
<?php //echo $this->Form->create('Property', array('id'=> 'KeywordsSearchForm','class' => 'check-form js-search-map js-ajax-search-form norma keywords','action'=>'index')); ?>
<!--
        <div class="block2 clearfix">
              <div class="grid_6 alpha omega">
            	<div class="js-side-map">
            		<div id="js-map-container">
            		</div>
               </div>
             </div>
             <div class="cancel-block">
             <span class="submit_button map-button js-mapsearch-button"><?php echo __l('Update'); ?></span></div>
              </div>
            <div class="Fmap block2 clearfix js-overlabel">
			<?php echo $this->Form->input('Property.keyword', array('label' =>__l('Keywords'),'value'=>$keyword)); ?><span class="submit_button js-submit-button">Button</span>
 </div>
-->

           <div class="clearfix">
 <!--      
    	 <div class="block2 clearfix categories" style="display: none;">
              <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">

              
                  </div>
                </div>
              </div>

              <div class="block2-cl js-room-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">
				  
             </div>
             </div>
             </div>
             <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
-->
<!--
        <div class="block2 categories">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    <h4><?php echo __l('Property Types'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-propertyType-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-propertyType-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">

				  <?php echo $this->Form->input('Property.PropertyType', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'PropertyTypes', 'label' =>false)); ?>
            </div>
            </div>
            </div>
          <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
        </div>
-->
<!--
	 <div class="block2 categories" style="display: none;">
	              <div class="block2-tl">
	                <div class="block2-tr">
	                  <div class="block2-tm">
	
	                  </div>
	                </div>
	              </div>
	              <div class="block2-cl js-holiday-type">
	                <div class="block2-cr">
	                  <div class="block2-cm clearfix">
				 
	    		 </div>
	    		 </div>
	    		 </div>
			        <div class="block2-bl">
			                <div class="block2-br">
			                  <div class="block2-bm"> </div>
			                </div>
			        </div>
	  </div>
-->	  
    <div class="block2 price-range">
    	<!--
        <div class="block2-tl">
            <div class="block2-tr">
              <div class="block2-tm">
                <h4><?php echo __l('Price Range'); ?></h4>
                 <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-price-range-type'}" href="#">Show/Hide</a>
              </div>
            </div>
          </div>
	       <div class="block2-cl js-price-range-type">
	            <div class="block2-cr">
	              <div class="block2-cm price-range-form-block clearfix">
				  	<div class="price-range-info-block"><span class="price-range"><?php echo __l('Price range ');?></span><span class='js-rang-from'><?php echo $rangefrom; ?></span><?php echo __l(' to '); ?><span class='js-rang-to'><?php echo $rangeto; ?></span></div>
					  <?php echo $this->Form->input('Property.range_from', array('type'=>'select', 'options'=>$range_from, 'id'=>'js-range_from', 'label' =>false, 'class' => 'hide')); ?>
					  <?php echo $this->Form->input('Property.range_to', array('type'=>'select', 'options'=>$range_to, 'id'=>'js-range_to', 'value'=> $rangeto,'label' =>false, 'class' => 'hide'));
					  ?>
	        		</div>
	        	</div>
	        </div>
-->	        
		<?php if (Configure::read('property.is_enable_security_deposit')): ?>
			<div class="block2-bl">
	                <div class="block2-br">
	                  <div class="block2-bm"> </div>
	                </div>
	        </div>
     </div>
     
     
     
        <div class="block2 price-range">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    <h4><?php echo __l('Security Deposit'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-price-securitydeposit-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-price-securitydeposit-type">
                <div class="block2-cr">
                  <div class="block2-cm price-range-form-block clearfix">
				  <div class="price-range-info-block"><span class="price-range"><?php echo __l('Deposit range ');?></span><span class='js-deposit-from'><?php echo $depositfrom; ?></span><?php echo __l(' to '); ?><span class='js-deposit-to'><?php echo $depositto; ?></span></div>
    		  <?php echo $this->Form->input('Property.deposit_from', array('type'=>'select', 'options'=>$deposit_from, 'id'=>'js-deposit_from', 'label' =>false, 'class' => 'hide')); ?>
    		  <?php echo $this->Form->input('Property.deposit__to', array('type'=>'select', 'options'=>$deposit_to, 'id'=>'js-deposit_from_to', 'value'=> $rangeto,'label' =>false, 'class' => 'hide'));
			  ?>

            </div>
            </div>
            </div>
	<?php endif; ?>
        <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
    		 </div>
           <div class="block2 categories" style="display: none;">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                                </div>
            </div>
            </div>
          <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
	<?php if (!empty($_SESSION['network_level']) || ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched'))): ?>
		<div class="block2">
			<div class="block2-tl">
				<div class="block2-tr">
					<div class="block2-tm">
						<h4><?php echo __l('Social Networks'); ?></h4>
						<a title="Header Minus" class="minus js-toggle-properties-types {'typetoggle': 'js-social-networks'}" href="#">Header Minus</a>
					</div>
				</div>
			</div>
			<div class="block2-cl js-social-networks">
				<div class="block2-cr">
					<div class="block2-cm clearfix">
						<?php if (!empty($_SESSION['network_level'])): ?>
							<?php echo $this->Form->input('Property.network_level', array('type' => 'select', 'multiple' => 'checkbox', 'id' => 'SocialNetworks', 'options' => $networkLevels, 'label' => false)); ?>
						<?php elseif ($this->Auth->user('id') && !$this->Auth->user('is_facebook_friends_fetched')): ?>
							<div class="social-network-connect">
								<?php echo $this->Html->link(__l('Connect with Facebook'), $fb_login_url, array('class' => 'facebook-connect-link', 'title' => __l('Connect with Facebook'))); ?>
								<?php echo '<span>' . ' ' . __l('to filter by Social Network level') . '</span>'; ?>
							</div>
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
	<?php endif; ?>
        <div class="block2 price-range" style="display:none;">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    
                  </div>
                </div>
              </div>
              <div class="block2-cl js-size-type">
                <div class="block2-cr">
                  <div class="block2-cm minimum-select-block clearfix">
        		  <?php echo $this->Form->input('Property.min_bedrooms', array('type'=>'select', 'options'=>$minimum, 'id'=>'minimumBedRooms', 'label' =>__l('') . '<span class="js-min-bedroom-range">' . $min_bedrooms . '</span>', 'class' => 'hide')); ?>
        		    <?php echo $this->Form->input('Property.min_bathrooms', array('type'=>'select', 'options'=>$minimum, 'id'=>'minimumBathRooms', 'label' =>__l('') . '<span class="js-min-bath-range">' . $min_bathrooms . '</span>', 'class' => 'hide')); ?>
        			<?php echo $this->Form->input('Property.min_beds', array('type'=>'select', 'options'=>$minimumBeds, 'id'=>'minimumBeds', 'label' =>__l('') . '<span class="js-min-bed-range">' . $min_beds . '</span>', 'class' => 'hide')); ?>
            </div>
            </div>
            </div>
          <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
	<?php if(count($languages) > 0): ?>
        <div class="block2">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    <h4><?php echo __l('Languages Spoken'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-language-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-language-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">
		  <?php echo $this->Form->input('Property.language', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'Languages', 'label' =>false)); ?>
            </div>
            </div>
            </div>
          <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
		<?php endif; ?>
        	</div>

        	<?php
				echo $this->Form->input('cityName',array('type'=>'hidden','id'=>'city_index','value' =>$city));
				echo $this->Form->input('latitude',array('type'=>'hidden','value' =>$latitude));
				echo $this->Form->input('longitude',array('type'=>'hidden','value' =>$longitude));
				echo $this->Form->input('checkin',array('type'=>'hidden','value' =>$checkin));
				echo $this->Form->input('checkout',array('type'=>'hidden','value' =>$checkout));
				echo $this->Form->input('additional_guest',array('type'=>'hidden','value' =>$additional_guest));
				echo $this->Form->input('type',array('type'=>'hidden','value' =>(!empty($search_keyword['named']['type'])?$search_keyword['named']['type']:$this->request->params['named']['type'])));
				$type=!empty($search_keyword['named']['type'])?$search_keyword['named']['type']:$this->request->params['named']['type'];
				if($type=='collection')
				{
					echo $this->Form->input('slug',array('type'=>'hidden','value' =>$collections['Collection']['slug']));
				}
				echo $this->Form->input('roomtype',array('type'=>'hidden','value' =>$roomtype));
				echo $this->Form->input('holidaytype',array('type'=>'hidden','value' =>$holidaytype));
				echo $this->Form->input('amenity',array('type'=>'hidden','value' =>$amenity));
				echo $this->Form->input('city',array('type'=>'hidden','value' =>$cityy));
				echo $this->Form->input('ne_longitude',array('type'=>'hidden', 'id'=> 'ne_longitude_index'));
				echo $this->Form->input('sw_longitude',array('type'=>'hidden', 'id'=> 'sw_longitude_index'));
				echo $this->Form->input('sw_latitude',array('type'=>'hidden', 'id'=> 'sw_latitude_index'));
				echo $this->Form->input('ne_latitude',array('type'=>'hidden', 'id'=> 'ne_latitude_index'));
			?>

	<div class="submit hide">
	<?php echo $this->Form->submit(__l('Search'),array('div'=>false)); ?>
	</div>
	<?php echo $this->Form->end(); ?>
	<?php } ?>

	</div>
	</div>
</div>
<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] !='favorite'){ ?>
 <div class="block2-bl">
                      <div class="block2-br">
                        <div class="block2-bm"> </div>
                      </div>
                    </div>
<?php }?>
</div>
<?php //endif;?>
<?php } ?>
<?php if($search=='normal'): ?>
</div>
<?php endif;?>
<?php else:?>
<div class="page-information"><?php echo __l('Please enter your search criteria'); ?></div>
<?php endif;?>
