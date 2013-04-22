<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
		 $hash = !empty($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
		 $salt = !empty($this->request->params['pass'][1]) ? $this->request->params['pass'][1] : '';
         
if ($search_keyword) {
    $city = isset($search_keyword['named']['cityname']) ? $search_keyword['named']['cityname'] : '';
    $latitude = isset($search_keyword['named']['latitude']) ? $search_keyword['named']['latitude'] : '';
    $longitude = isset($search_keyword['named']['longitude']) ? $search_keyword['named']['longitude'] : '';
    $checkin = isset($search_keyword['named']['checkin']) ? $search_keyword['named']['checkin'] : '';
    $checkout = isset($search_keyword['named']['checkout']) ? $search_keyword['named']['checkout'] : '';
    $additional_guest = isset($search_keyword['named']['additional_guest']) ? $search_keyword['named']['additional_guest'] : '';
    $type = isset($search_keyword['named']['type']) ? $search_keyword['named']['type'] : '';
    $is_flexible = isset($search_keyword['named']['is_flexible']) ? $search_keyword['named']['is_flexible'] : '';
    $holidaytype = isset($search_keyword['named']['holidaytype']) ? $search_keyword['named']['holidaytype'] : '';
    $roomtype = isset($search_keyword['named']['roomtype']) ? $search_keyword['named']['roomtype'] : '';
    $amenity = isset($search_keyword['named']['amenity']) ? $search_keyword['named']['amenity'] : '';
    $rangefrom = isset($search_keyword['named']['range_from']) ? $search_keyword['named']['range_from'] : '10';
    $rangeto = isset($search_keyword['named']['range_to']) ? $search_keyword['named']['range_to'] : '300+';
    $keyword = isset($search_keyword['named']['keyword']) ? $search_keyword['named']['keyword'] : '';
    $cityy = isset($search_keyword['named']['city']) ? $search_keyword['named']['city'] : 'all';
    //this->request->data['Request']=$search_keyword['named'];
    if (!empty($rangeto)) {
        $this->request->data['Request']['range_to'] = $rangeto;
    }
} else {
    $city = isset($this->request->params['named']['cityname']) ? $this->request->params['named']['cityname'] : '';
    $latitude = isset($this->request->params['named']['latitude']) ? $this->request->params['named']['latitude'] : '';
    $longitude = isset($this->request->params['named']['longitude']) ? $this->request->params['named']['longitude'] : '';
    $checkin = isset($this->request->params['named']['checkin']) ? $this->request->params['named']['checkin'] : '';
    $checkout = isset($this->request->params['named']['checkout']) ? $this->request->params['named']['checkout'] : '';
    $additional_guest = isset($this->request->params['named']['additional_guest']) ? $this->request->params['named']['additional_guest'] : '';
    $type = isset($this->request->params['named']['type']) ? $this->request->params['named']['type'] : '';
    $is_flexible = isset($this->request->params['named']['is_flexible']) ? $this->request->params['named']['is_flexible'] : '';
    $holidaytype = isset($this->request->params['named']['holidaytype']) ? $this->request->params['named']['holidaytype'] : '';
    $roomtype = isset($this->request->params['named']['roomtype']) ? $this->request->params['named']['roomtype'] : '';
    $amenity = isset($this->request->params['named']['amenity']) ? $this->request->params['named']['amenity'] : '';
    $rangefrom = isset($this->request->params['named']['range_from']) ? $this->request->params['named']['range_from'] : '10';
    $rangeto = isset($this->request->params['named']['range_to']) ? $this->request->params['named']['range_to'] : '300+';
    $keyword = isset($this->request->params['named']['keyword']) ? $this->request->params['named']['keyword'] : '';
    $cityy = isset($this->request->params['named']['city']) ? $this->request->params['named']['city'] : 'all';
    //$this->request->data['Request']=$this->request->params['named'];
    if (!empty($rangeto)) {
        $this->request->data['Request']['range_to'] = $rangeto;
    }
}
if (isset($is_favorite)) {
    $class_name = '';
} else {
    $class_name = 'request-index-page';
}
?>
<?php
if ($search == 'normal' && !isset($is_favorite)): ?>
<div class="city-search-block-tl ">
    <div class="city-search-block-tr">
        <div class="city-search-block-tm city-search-block-top clearfix">
          <?php
        echo $this->element('request_search', array(
        'config' => 'sec',
        'type' => 'search'
    )); ?>
        </div>
    </div>
</div>
<?php
endif; ?>
<?php
if ($search == 'normal'): ?>
<div class="js-response js-responses clearfix">
<?php
endif; ?>
<div class="requests index <?php
echo $class_name; ?>  properties-side1 grid_18">

<span class="js-search-lat {'cur_lat':'<?php
echo $current_latitude; ?>','cur_lng':'<?php
echo $current_longitude; ?>'}"></span>
        <div class="block1-tl">
              <div class="block1-tr">
                    <div class="block1-tm">
                            <?php
if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'favorite'): ?>
                            <h2><?php
    echo __l('Liked Requests'); ?></h2>
                            <?php
else: ?>
                            <h2><?php
    echo __l('Requests'); ?></h2>
                            <?php
endif; ?>
                      </div>
              </div>
            </div>
            <div class="block1-cl">
            <div class="block1-cr">
            <div class="block1-cm  block1 clearfix">
                <?php
echo $this->element('paging_counter'); ?>
                <?php
if (!empty($requests)):
    $num = 1;
    foreach($requests as $key => $requests_date): ?>
              <div class="clearfix">
				<div class="grid_3 date-info-block1 date-info-block">


						 <p class="date-info1 date-info">
							<?php
        $date = explode('-', $key);
?>
							<span class="month"><?php
        echo date('M', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span>
							<span class="date"><?php
        echo date('d', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span>
							<span class="days"><?php
        echo date('l', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></span>
						</p>


				</div>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
			    <ol class="clearfix property-list list request-comment-list grid_left comments-list js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}" start="<?php
        echo $this->Paginator->counter(array(
            'format' => '%start%'
        )); ?>">
                <?php
        $i = 0;
        foreach($requests_date as $request):
            $class = null;
            if ($i++%2 == 0) {
                $class = ' class="altrow"';
            }
?>
                	<li class="clearfix  js-map-request-num<?php
            echo $num; ?>">
                	 <div class="grid_10 request-left-block omega">
                	   <div class="clearfix">
                        <div class="grid_2 user-avatar alpha omega">
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
								echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
							?>
                    	</div>
                		<div class="grid_9 alpha omega">

                    	<div class="clearfix">
                    		<h2>
                    		<?php
            $lat = $request['Request']['latitude'];
            $lng = $request['Request']['longitude'];
            $id = $request['Request']['id'];
            echo $this->Html->link($this->Html->cText($request['Request']['title']) , array(
                'controller' => 'requests',
                'action' => 'view',
                $request['Request']['slug'],
				 $hash,
				 $salt,
                'admin' => false
            ) , array(
                'id' => "js-map-side-$id",
                'class' => "js-map-data {'lat':'$lat','lng':'$lng'}",
                'title' => $this->Html->cText($request['Request']['title'], false) ,
                'escape' => false
            ));
?>
                    		</h2>
                    		<?php
            $flexible_class = '';
            if (isset($search_keyword['named']['is_flexible']) && $search_keyword['named']['is_flexible'] == 1) {
                if (in_array($request['Request']['id'], $exact_ids)) { ?>
					<span class="exact round-3"> <?php
                    echo __l('exact'); ?></span>
		<?php
                }
            } ?>
                    		</div>
                        	<p class="address-info">
								<?php
            if (!empty($request['Country']['iso2'])): ?>
										<span class="flags flag-<?php
                echo strtolower($request['Country']['iso2']); ?>" title ="<?php
                echo $request['Country']['name']; ?>"><?php
                echo $request['Country']['name']; ?></span>
								<?php
            endif; ?>
								<?php
            echo $this->Html->cText($request['Request']['address']); ?>
							<?php
            echo '(' . $this->Time->timeAgoInWords($request['Request']['created']) . ')'; ?></p>
                   		<div class="request-description"><?php
            echo $this->Html->truncate($request['Request']['description']); ?>
	                    </div>



                		<div class="clearfix">
						    <?php if(!empty($search_keyword['named']['latitude']) || !empty($request[0]['distance'])): ?>
        <dl class="clearfix guest distance-list request-list1 ">
			<dt><?php echo __l('Distance');?><span class="km"> <?php echo __l('(km)');?></span></dt>
			<dd><?php echo $this->Html->cInt($request[0]['distance']*1.60934 ,false); ?></dd>
		</dl>
			<?php endif; ?>
                        <dl class="request-list1 guest count-list1 clearfix">

                		      <dt><?php
            echo __l('Views'); ?></dt>
                		   <dd class="js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo $this->Html->cInt($request['Request']['request_view_count']); ?></dd>
                		</dl>
                		  <dl class="request-list1 guest count-list1 clearfix">
                		      <dt><?php
            echo __l('Offered'); ?></dt>
                		      <dd><?php
            echo $this->Html->cInt($request['Request']['property_count']); ?></dd>
                		  </dl>
                			<dl class="request-list1 days count-list1 clearfix">
								  <dt><?php
            echo __l('Days'); ?></dt>
							   <dd>
									<?php
            $days = ((strtotime($request['Request']['checkout']) -strtotime($request['Request']['checkin'])) /(60*60*24)) + 1;
            echo $this->Html->cInt($days);
?>
							   </dd>
							</dl>
                		</div>

                		<div class=" edit-info-block clearfix">
                		<div class="rating-block grid_left">
              <div class="rating clearfix">
                <ul class="star-rating">
				<li style="width: 100%;" class="current-rating">
                     <?php
            if ($this->Auth->sessionValid()):
                if (!empty($request['RequestFavorite'])):
                    foreach($request['RequestFavorite'] as $favorite):
                        if ($request['Request']['id'] == $favorite['request_id'] && $request['Request']['user_id'] != $this->Auth->user('id')):
                            echo $this->Html->link(__l('Unlike') , array(
                                'controller' => 'request_favorites',
                                'action' => 'delete',
                                $request['Request']['slug']
                            ) , array(
                                'class' => 'js-like un-like',
                                'title' => __l('Unlike')
                            ));
                        endif;
                    endforeach;
                else:
                    if ($request['Request']['user_id'] != $this->Auth->user('id')):
                        echo $this->Html->link(__l('Like') , array(
                            'controller' => 'request_favorites',
                            'action' => 'add',
                            $request['Request']['slug']
                        ) , array(
                            'title' => __l('Like') ,
                            'escape' => false,
                            'class' => 'js-like like'
                        ));
                    endif;
                endif;
            else:
                echo $this->Html->link(__l('Like') , array(
                    'controller' => 'users',
                    'action' => 'login'
                ) , array(
                    'title' => __l('Like') ,
                    'escape' => false,
                    'class' => ' like'
                ));
            endif;
?>

                      </li>
                    </ul>
                  </div>
                </div>
                <?php
            if ($request['User']['id'] == $this->Auth->user('id')): ?>
                		<div class="actions">
                        <?php
                echo $this->Html->link(__l('Edit') , array(
                    'action' => 'edit',
                    $request['Request']['id']
                ) , array(
                    'class' => 'edit js-edit',
                    'title' => __l('Edit')
                )); ?>
                        <?php
                echo $this->Html->link(__l('Delete') , array(
                    'action' => 'delete',
                    $request['Request']['id']
                ) , array(
                    'class' => 'delete js-delete',
                    'title' => __l('Delete')
                )); ?>
                        </div>
                <?php
            endif; ?>
                        </div>

                    </div>
	                </div>
               		</div>
                		<div class="grid_4 request-right-block omega alpha">
                		<p class="address-info"><?php
            echo $this->Html->cDate($request['Request']['checkin']); ?><?php
            echo __l(' - '); ?><?php
            echo $this->Html->cDate($request['Request']['checkout']); ?></p>
                        <div class="clearfix city-price1">
							<?php
            if (Configure::read('site.currency_symbol_place') == 'left'): ?>
							 <sub> <?php
                echo Configure::read('site.currency') . ' ' ?></sub>
							 <?php
            endif; ?>
                        <?php
            echo $this->Html->cCurrency($request['Request']['price_per_night']); ?>
						<?php
            if (Configure::read('site.currency_symbol_place') == 'right'): ?>
			                 <sub> <?php
                echo Configure::read('site.currency') . ' ' ?></sub>
						 <?php
            endif; ?>
                             <p class="pernight-info"><?php
            echo __l('per night'); ?></p>
                            </div>

                    	<?php
            if ($request['User']['id'] != $this->Auth->user('id')): ?>
                		<?php
                if ($request['Request']['checkin'] >= date('Y-m-d') && $request['Request']['checkout'] >= date('Y-m-d')): ?>
                                <div class="clearfix">
                                <div class="cancel-block"><?php
                    echo $this->Html->link(__l('Make an offer') , array(
                        'controller' => 'properties',
                        'action' => 'add',
                        'request',
                        $request['Request']['id'],
                        'admin' => false
                    ) , array(
                        'title' => __l('Make an offer') ,
                        'escape' => false
                    )); ?></div>
                                </div>
                        <?php
                endif;
            endif; ?>
                		</div>

                	</li>
                <?php
        endforeach; ?>
                                </ol>
                                </div>
<?php
        $num++;
    endforeach;
else:
?>
                 <ol class="clearfix property-list list request-comment-list comments-list grid_left" start="<?php
    echo $this->Paginator->counter(array(
        'format' => '%start%'
    )); ?>">
                	<li>
                		<p class="notice"><?php
    echo __l('No Requests available'); ?></p>
                	</li>
                	                </ol>
                <?php
endif;
?>
                <?php
if (!empty($requests)) {
    if (count($requests) > 10) {
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
        </div>
    </div>
    <div class="block2-bl">
              <div class="block2-br">
                <div class="block2-bm"> </div>
              </div>
            </div>
</div>
<div class=" grid_6 omega side2 properties-side2">
<?php
if (!isset($is_favorite)): ?>
<div class="block2-tl">
                      <div class="block2-tr">
                        <div class="block2-tm">
                              <h4 class="refine"><?php
    echo __l('Refine'); ?></h4>
                            </div>
                        </div>
                    </div>
                      <div class="block2-cl">
                    <div class="block2-cr">
                     <div class="block2-cm clearfix">
<?php
    echo $this->Form->create('Request', array(
        'id' => 'KeywordsSearchForm',
        'class' => 'check-form norma keywords js-ajax-search-form',
        'action' => 'index'
    )); ?>

 <div class="block2 clearfix">

             <div class="grid_6 alpha omega">
            	<div class="js-side-map">
            		<div id="js-map-container">
            		</div>
               </div>
             </div>
             <div class="cancel-block">
             <span class="submit_button map-button js-mapsearch-button"><?php
    echo __l('Update'); ?></span></div>
              </div>

 <div class="Fmap block2 js-overlabel clearfix">
				<?php
    echo $this->Form->input('Request.keyword', array(
        'label' => __l('Keywords') ,
        'value' => $keyword
    )); ?><span class="submit_button js-submit-button">Button</span>
          </div>
           <div class="clearfix">
               
    	 <div class="block2" style="display: none;">
             <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">

                     <h4><?php
    echo __l('Room Types'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-room-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
             
             
              <div class="block2-cl js-room-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">
				<?php
    echo $this->Form->input('RoomType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'RoomType',
        'label' => false
    )); ?>
             </div>
             </div>
             </div>
             <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
              </div>
 <div class="block2">
              <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">

                    <h4><?php
    echo __l('Property Types'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-property-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-property-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">

    		  <?php
    echo $this->Form->input('Request.PropertyType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'PropertyTypes',
        'label' => false
    )); ?>
    		 </div>
    		 </div>
    		 </div>
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

                    <h4><?php
    echo __l('Holiday Types'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-holiday-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-holiday-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">
			  <?php
    echo $this->Form->input('Request.HolidayType', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'HolidayTypes',
        'label' => false
    )); ?>
    		 </div>
    		 </div>
    		 </div>
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
                    <h4><?php
    echo __l('Price Range'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-price-range-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-price-range-type">
                <div class="block2-cr">
                  <div class="block2-cm price-range-form-block clearfix">
				   <div class="price-range-info-block"><span class="price-range"><?php
    echo __l('Price range '); ?></span><span class='js-rang-from'><?php
    echo $rangefrom; ?></span><?php
    echo __l(' to '); ?><span class='js-rang-to'><?php
    echo $rangeto; ?></span></div>
    		  <?php
    echo $this->Form->input('Request.range_from', array(
        'type' => 'select',
        'options' => $range_from,
        'id' => 'js-range_from',
        'label' => false,
        'class' => 'hide'
    )); ?>
    		  <?php
    echo $this->Form->input('Request.range_to', array(
        'type' => 'select',
        'options' => $range_to,
        'id' => 'js-range_to',
        'value' => $rangeto,
        'label' => false,
        'class' => 'hide'
    )); ?>
            </div>
            </div>
            </div>
        <div class="block2-bl">
                <div class="block2-br">
                  <div class="block2-bm"> </div>
                </div>
              </div>
    		 </div>
           <div class="block2" style="display: none;">
            <div class="block2-tl">
                <div class="block2-tr">
                  <div class="block2-tm">
                    <h4><?php
    echo __l('Amenities'); ?></h4>
                     <a title="Show/Hide" class="minus js-toggle-properties-types {'typetoggle': 'js-amenities-type'}" href="#">Show/Hide</a>
                  </div>
                </div>
              </div>
              <div class="block2-cl js-amenities-type">
                <div class="block2-cr">
                  <div class="block2-cm clearfix">
				  <?php
    echo $this->Form->input('Request.Amenity', array(
        'type' => 'select',
        'multiple' => 'checkbox',
        'id' => 'Amenities',
        'label' => false
    )); ?>
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
      	<?php
    echo $this->Form->input('cityName', array(
        'type' => 'hidden',
        'id' => 'city_index',
        'value' => $city
    ));
    echo $this->Form->input('latitude', array(
        'type' => 'hidden',
        'value' => $latitude
    ));
    echo $this->Form->input('longitude', array(
        'type' => 'hidden',
        'value' => $longitude
    ));
    echo $this->Form->input('checkin', array(
        'type' => 'hidden',
        'value' => $checkin
    ));
    echo $this->Form->input('checkout', array(
        'type' => 'hidden',
        'value' => $checkout
    ));
    echo $this->Form->input('additional_guest', array(
        'type' => 'hidden',
        'value' => $additional_guest
    ));
    echo $this->Form->input('type', array(
        'type' => 'hidden',
        'value' => 'search'
    ));
    echo $this->Form->input('search', array(
        'type' => 'hidden',
        'value' => 'side'
    ));
    echo $this->Form->input('roomtype', array(
        'type' => 'hidden',
        'value' => $roomtype
    ));
    echo $this->Form->input('holidaytype', array(
        'type' => 'hidden',
        'value' => $holidaytype
    ));
    echo $this->Form->input('amenity', array(
        'type' => 'hidden',
        'value' => $amenity
    ));
    echo $this->Form->input('ne_longitude', array(
        'type' => 'hidden',
        'id' => 'ne_longitude_index'
    ));
    echo $this->Form->input('sw_longitude', array(
        'type' => 'hidden',
        'id' => 'sw_longitude_index'
    ));
    echo $this->Form->input('sw_latitude', array(
        'type' => 'hidden',
        'id' => 'sw_latitude_index'
    ));
    echo $this->Form->input('ne_latitude', array(
        'type' => 'hidden',
        'id' => 'ne_latitude_index'
    ));
?>
			<?php
    echo $this->Form->end(); ?>
<?php
endif; ?>
<?php
if (isset($is_favorite)): ?>
<div class="Fmap block2">
            <?php
    echo $this->element('user-stats'); ?>

</div>
<?php
endif; ?>
</div></div></div>
<?php
if ((isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'favorite') || empty($this->request->params['named']['type'])): ?>
 <div class="block2-bl">
                      <div class="block2-br">
                        <div class="block2-bm"> </div>
                      </div>
                    </div>
<?php
endif; ?>

</div>
<?php
if ($search == 'normal'): ?>
</div>
<?php
endif; ?>