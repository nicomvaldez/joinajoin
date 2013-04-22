<?php //echo $this->element('search', array('config' => 'sec','type'=>'search')); ?>

<?php
$hash = 0;
$salt = 0;
$allow=true;
?>


<?php


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

<!--
<?php if($search=='normal'): ?>
<div class="city-search-block-tl">
    <div class="city-search-block-tr">
        <div class="city-search-block-tm city-search-block-top clearfix">
            <?php if(isset($this->request->params['named']['type']) && $this->request->params['named']['type']=='collection'): ?>
                <?php echo $this->element('slider', array('config' => 'sec','properties' => $properties)); ?>
            <?php elseif($allow): ?>
               <?php echo $this->element('search', array('config' => 'sec','type'=>'search')); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

-->



<div class="properties-side1 grid_18">
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
                                   
	     <?php if(isset($_GET['sortby'])){
	          $ordenarx = $_GET['sortby']; 
	     }     
	     ?>  
     
                          
                                <ul class="recommended-list grid_left clearfix">
                                <?php if((!empty($search_keyword['named']['latitude'])) ): ?>
                                    <?php $class=((!empty($ordenarx) && $ordenarx=='distance') || !isset($ordenarx))?'active':''; ?>
                                    <li  class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Distance'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=distance'); ?>  </li>
                                <?php endif; ?>
                                
                                <?php $class=(!empty($ordenarx)&& $ordenarx =='favorites')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Favorites'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=favorites'); ?>  </li>
                                <?php $class=(!empty($ordenarx) && $ordenarx =='high')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price low to high'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=high'); ?>  </li>
                                <?php $class=(!empty($ordenarx) && $ordenarx =='low')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Price high to low'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=low'); ?>  </li>
                                <?php $class=(!empty($ordenarx) && $ordenarx =='recent')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Recent'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=recent'); ?>  </li>
                                <?php $class=(!empty($ordenarx)&& $ordenarx =='reviews')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Reviews'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=reviews'); ?>  </li>
                                <?php $class=(!empty($ordenarx) && $ordenarx =='featured')?'active':''; ?>
                                <li class="<?php echo $class; ?>"><?php echo $this->Html->link(__l('Featured'), '/searches/mostrar?do=search&city='.$city.'&property_type='.$property_type.'&sortby=featured'); ?>  </li>
                                </ul>
                        </li>
                    </ul>
                 <span class="search_results grid_left"><?php echo $this->Html->Cint($total_result); ?> <?php echo $num; ?> <?php echo __l('results'); ?></span> </div>
                <div class="js-toggle-show-block">

                </div>
                <div class="js-share-results hide share-results-code">
                    <?php
                        if(isset($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'collection' ) { 
                            $slug=isset( $this->request->params['named']['slug'])? $this->request->params['named']['slug']:$search_keyword['named']['slug'];
                            $embed_code = Router::url('/',true).'collection/'.$slug;
                        } else {
                            $embed_code = Router::url(array('controller'=>'searches','action'=>'mostrar',$hash,$salt), true);
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




<br />
<hr class="hr_stilo_1" noshade="noshade">





<?php

if (!empty($properties)):
$i = 0;
$num = 1;
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
<br />
    <li class="<?php echo $class;?> js-map-num<?php echo $num; ?> clearfix">
        <div class="grid_3 thumb">
            <div class="map_number" ><?php //echo $num; ?></div>
            <?php
                $property['Attachment'][0] = !empty($property['Attachment'][0]) ? $property['Attachment'][0] : array();
                echo $this->Html->link($this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'],$hash, $salt,  'admin' => false), array('title'=>$this->Html->cText($property['Property']['title'],false),'escape' => false));
            ?>
        </div>
    <div class="grid_14 alpha omega">
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
    <div class="grid_12 alpha omega">
    <div class="clearfix">
        <h2>
        <?php

        $lat = $property['Property']['latitude'];
        $lng = $property['Property']['longitude'];
        $id = $property['Property']['id'];

        echo $this->Html->link($this->Html->cText($property['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], $hash, $salt, 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"font-titulo-listado js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($property['Property']['title'], false),'escape' => false));
        ?>
    
        <?php 
            $flexible_class = '';
             if(isset($search_keyword['named']['is_flexible'])&& $search_keyword['named']['is_flexible'] ==1 && !empty($search_keyword['named']['latitude']))
             {
                if(!in_array($property['Property']['id'], $booked_property_ids) && in_array($property['Property']['id'], $exact_ids)) { ?>
                    <span class="exact round-3"> <?php echo __l('exact'); ?></span>
        <?php       } }
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
                  <?php echo (empty($property['Property']['price_per_week']))?__l('Per night'):__l('Per Join');?>
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
    <br />
    <hr class="hr_stilo_1" noshade="noshade">
<?php
    $num++;
	endforeach;

	//paginador 
	//echo $this->Paginator->counter();

	if($_GET['do']=='search'){
		$this->Paginator->options(array('url' => array('do'=>$_GET['do'], 'city' => $_GET['city'], 'property_type'=> $_GET['property_type'], 'tipo'=> $_GET['tipo'])));	
	}
	
	echo $this->Paginator->counter(array(
    'format' => 'Page %page% of %pages%, showing %current% records out of
             %count% total, starting on record %start%, ending on %end%'
	));
	echo '<br>';
	echo $this->Paginator->prev('« Previous ', null, null, array('class' => 'disabled')) . ' ---- ';
	echo $this->Paginator->numbers();
	echo ' ---- ' . $this->Paginator->next(' Next »', null, null, array('class' => 'disabled'));


endif;
?>
</div>





