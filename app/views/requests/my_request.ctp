<?php /* SVN: $Id: $ */ ?>
<div class="side1 request-left grid_left">
<div class="myrequests index">
<div class="clearfix myrequest-filter">
	<h5 class="sort-head"><?php echo __l('Filter: ');?></h5>
	<div class="select-block">
	<div class="inbox-option">

        <?php $class=(empty($this->request->params['named']['status']) && !empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest')? 'active-filter':'';?>
        <span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('All') . ': ' . $all_count, array('controller'=>'requests','action'=>'index','type' => 'myrequest'), array('title' => __l('All')))?></span>


		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'active')?'active-filter':'';?>
      <span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(__l('Enabled') . ': ' . $active_count, array('controller'=>'requests', 'action'=>'index', 'type' => 'myrequest', 'status'=>'active'), array('title' => __l('Enabled')))?></span>

		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'inactive')?'active-filter':'';?>
        <span class="disabled <?php echo $class; ?>"><?php echo $this->Html->link(__l('Disabled') . ': ' . $inactive_count, array('controller'=>'requests', 'action'=>'index', 'type' => 'myrequest', 'status'=>'inactive'), array('title' => __l('Disabled')))?></span>

		<?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'offered')?'active-filter':'';?>
      <span class="Travelerrejected <?php echo $class; ?>"><?php echo $this->Html->link(__l('Offered') . ': ' . $offered_count, array('controller'=>'requests', 'action'=>'index', 'type' => 'myrequest', 'status'=>'offered'), array('title' => __l('Offered')))?></span>

	  <?php $class=(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myrequest' && !empty($this->request->params['named']['status'])&& $this->request->params['named']['status'] == 'past')?'active-filter':'';?>
      <span class="pendinghostaccept <?php echo $class; ?>"><?php echo $this->Html->link(__l('Past') . ': ' . $past_count, array('controller'=>'requests', 'action'=>'index', 'type' => 'myrequest', 'status'=>'past'), array('title' => __l('Past')))?></span>



 </div>
 </div>

</div>
<?php echo $this->element('paging_counter');?>
<div class="pptab-menu-left">
<div class="pptab-menu-right">
    <div class="pptab-menu-center clearfix">
         <h2><?php echo __l('My Requests');?></h2>   
	</div>

   	</div>
</div>
<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm block1">


<?php 
	echo $this->Form->create('Request' , array('class' => 'normal','action' => 'update'));  
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); 
?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
<ol class="list property-list myrequest-list js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}">
    
<?php
if (!empty($requests)):
$i = 0;
foreach ($requests as $requestt):
	$class = null;
	foreach($requestt as $request):
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li <?php echo $class;?>>
		<div class="my-request">

            <div class="clearfix">
            <div class="grid_9 omega alpha">
			<p class="address-info request-address-info">
        		<span><?php echo $this->Html->cDate($request['Request']['checkin']).' - '.$this->Html->cDate($request['Request']['checkout']);?></span> 
    		</p>
                <div class="clearfix">
            	<h2>
            	<?php echo $this->Form->input('Request.'.$request['Request']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$request['Request']['id'], 'label' => false, 'class' => 'js-checkbox-list' , 'div' =>false)); ?>
    			<?php echo $this->Html->link($this->Html->cText($request['Request']['title']), array('controller'=> 'requests', 'action' => 'view', $request['Request']['slug']), array('title' => $this->Html->cText($request['Request']['title'], false), 'escape' => false));?>
    				<?php
    					if(!$request['Request']['is_active']) { ?>
        					<span class="inactive"><?php	echo $this->Html->cText(__l('Disabled')); ?></span>
    					<?php } ?>
    		
    		</h2>
    		</div>
			<p class="address-info">
								<?php if(!empty($request['Country']['iso2'])): ?>
									<span class="flags flag-<?php echo strtolower($request['Country']['iso2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
							<?php endif; ?>
								<?php echo $this->Html->cText($request['Request']['address']);?>
							<?php echo  '(' . $this->Time->timeAgoInWords($request['Request']['created']) . ')';?></p>

     		

		</div>
		<div class="clearfix grid_4 omega alpha request-count-block">
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
							$days = ((strtotime($request['Request']['checkout']) -strtotime($request['Request']['checkin'])) /(60*60*24)) + 1;
							echo  $this->Html->cInt($days);
						?>
				   </dd>
				</dl>
			</div>
		<div class="grid_4 city-price grid_right omega alpha">
            <div class="clearfix city-price1">
                 <sub> <?php echo Configure::read('site.currency').' '?> </sub>
                 <?php echo  $this->Html->cCurrency($request['Request']['price_per_night']);?>
                  <p class="">
                  <?php echo __l('Per night');?>
                  </p>
             </div>
            </div>
        </div>
            <div class="edit-info-block" id="js-confirm-message-block">
            	<div class="actions">
			<span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
			<span>
				<?php
					if($request['Request']['is_active'] == 0) {
						echo $this->Html->link(__l('Enable'), array('controller' => 'requests', 'action' => 'updateactions', $request['Request']['id'], 'active', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Enable'), 'class' => 'enable js-confirm-mess'));
					} elseif($request['Request']['is_active'] == 1) {
						echo $this->Html->link(__l('Disable'), array('controller' => 'requests', 'action' => 'updateactions', $request['Request']['id'], 'inactive', 'admin' => false, '?r=' . $this->request->url), array('title' => __l('Disable'), 'class' => 'disable js-confirm-mess'));
					}
				?>
			</span>
		</div>
		</div>
		</div>
		<?php 
		if(!empty($request['PropertiesRequest'])): ?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
			<ol class="list property-list js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
				<?php 
					foreach($request['PropertiesRequest'] as $requestProperty):
					if(!empty($requestProperty['Property'])):
				?>
					<li class="clearfix">
					<div class="property-index-list">
	<div class="grid_3 thumb">
	  <?php

	  echo $this->Html->link($this->Html->showImage('Property', $requestProperty['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($requestProperty['Property']['title'], false)), 'title' => $this->Html->cText($requestProperty['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $requestProperty['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($requestProperty['Property']['title'],false),'escape' => false));
	 ?>
	 </div>
	<div class="grid_9 alpha omega">
	<div class="clearfix">
	<div class="grid_2 user-avatar alpha omega">
		<?php 
			$current_user_details = array(
				'username' => $requestProperty['Property']['User']['username'],
				'user_type_id' => $requestProperty['Property']['User']['user_type_id'],
				'id' => $requestProperty['Property']['User']['id'],
				'fb_user_id' => $requestProperty['Property']['User']['fb_user_id']
			);
			$current_user_details['UserAvatar'] = array(
				'id' => $requestProperty['Property']['User']['attachment_id']
			);
			echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
		?>
    </div>
	<div class="grid_8 alpha omega">
	<div class="clearfix">
		<h2>
		<?php

		$lat = $requestProperty['Property']['latitude'];
		$lng = $requestProperty['Property']['longitude'];
		$id = $requestProperty['Property']['id'];

		echo $this->Html->link($this->Html->cText($requestProperty['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $requestProperty['Property']['slug'], 'admin' => false), array('id'=>"js-map-side-$id",'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}",'title'=>$this->Html->cText($requestProperty['Property']['title'], false),'escape' => false));
		?>
	
		<?php 
			$flexible_class = '';
			if(isset($is_flexible_check)) {
				if(!in_array($requestProperty['Property']['id'], $booked_property_ids)) { ?>
			<span class="available"> <?php echo __l('Exact'); ?></span>
		<?php		}
			}
			if(Configure::read('property.is_property_verification_enabled') && $requestProperty['Property']['is_verified']):?>
			<span class="isverified"> <?php echo __l('Verified'); ?></span>
		<?php
			endif;
		?>
			</h2>
		</div>
        <p class="address-info">
			<?php if(!empty($requestProperty['Property']['Country']['iso2'])): ?>
						<span class="flags flag-<?php echo strtolower($requestProperty['Property']['Country']['iso2']); ?>" title ="<?php echo $requestProperty['Property']['Country']['name']; ?>"><?php echo $requestProperty['Property']['Country']['name']; ?></span>
				<?php endif; ?>
			<?php echo $this->Html->cText($requestProperty['Property']['address']);?>
		</p>
	 </div>
	</div>
		<div class="clearfix">
    <?php if((!empty($search_keyword['named']['latitude']) || isset($near_by)) && !empty($requestProperty[0]['distance'])): ?>

        <dl class="clearfix guest request-list1">
			<dt><?php echo __l('Distance');?><span class="km"> <?php echo __l('(km)');?></span></dt>
			<dd><?php echo $this->Html->cInt($requestProperty[0]['distance']*1.60934 ,false); ?></dd>
		</dl>

			<?php endif; ?>
					<dl class="request-list1 view-list1 guest clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('View');?>">
                      <?php echo __l('Views');?></dt>
                      <dd class="positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $requestProperty['Property']['id']; ?> {'id':'<?php echo $requestProperty['Property']['id']; ?>'}"><?php echo $this->Html->cInt($requestProperty['Property']['property_view_count']); ?></dd>
                  </dl>
		           <dl class="ratings-feedback1 clearfix">
                      <dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
                      <?php echo __l('Positive');?></dt>
                      <dd class="positive-feedback1">
                        <?php  echo $this->Html->cInt($requestProperty['Property']['positive_feedback_count']); ?>
                      </dd>
                  </dl>
                   <dl class="ratings-feedback1 clearfix">
                      <dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
                      <dd  class="negative-feedback1">
                            <?php  echo $this->Html->cInt($requestProperty['Property']['property_feedback_count'] - $requestProperty['Property']['positive_feedback_count']); ?>
                      </dd>
                    </dl>
				  <dl class="clearfix guest request-list1 success-rate-list">
    				        <dt  title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
                          <?php if(empty($requestProperty['Property']['property_feedback_count'])): ?>
								<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
							<?php else:?>
								  <dd class="success-rating">
										<?php
										if(!empty($requestProperty['Property']['positive_feedback_count'])):
											$positive = floor(($requestProperty['Property']['positive_feedback_count']/$requestProperty['Property']['property_feedback_count']) *100);
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
		</div>
		 </div>
		  <div class="city-price grid_4 omega alpha">
		  <div class="clearfix edit-info-block">
		  	<div class="rating-block grid_left">
              <div class="rating clearfix">
                <ul class="star-rating">
				<li style="width: 100%;" class="current-rating">
                     <?php
					if($this->Auth->sessionValid()):
						if(!empty($requestProperty['PropertyFavorite'])):
						foreach($requestProperty['PropertyFavorite'] as $favorite):
								if($requestProperty['Property']['id'] == $favorite['property_id'] && $favorite['user_id'] == $this->Auth->user('id')):
									 echo $this->Html->link(__l('Unlike'), array('controller' => 'property_favorites', 'action'=>'delete', $requestProperty['Property']['slug']), array('class' => 'js-like un-like', 'title' => __l('Unlike')));
								endif;
							endforeach;
						else:
							echo $this->Html->link(__l('Like'), array('controller' => 'property_favorites', 'action' => 'add', $requestProperty['Property']['slug']), array('title' => __l('Like'),'escape' => false ,'class' =>'js-like like'));
						endif;
					endif;
					?>

                      </li>
                    </ul>
                  </div>
                </div>
            <?php if ($requestProperty['Property']['user_id'] == $this->Auth->user('id')) : ?>

		<div class="actions clearfix"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $requestProperty['Property']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $requestProperty['Property']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
        </div>
		   <?php endif; ?>
		   </div>
		   <div class="grid_4 omega alpha">
		   <div class="clearfix city-price1">
                 <sub> <?php echo Configure::read('site.currency').' '?></sub>
                  <?php echo $this->Html->cCurrency($requestProperty['Property']['price_per_night']);?>
                  <p class="">
                  <?php echo __l('Per night');?>
                  </p>
            </div>
            </div>
			<div class="cancel-block clearfix">
			<?php if(!empty($requestProperty['Property']['PropertiesRequest'])): ?>
			<?php foreach($requestProperty['Property']['PropertiesRequest'] as $propertyrequest):
					if($propertyrequest['request_id']==$request['Request']['id']): ?>
			<?php echo $this->Html->link(__l('Book it'), array('controller' => 'payments', 'action' => 'order', $requestProperty['Property']['id'],'order_id' =>$propertyrequest['order_id'],'request_id' =>$request['Request']['id'], 'admin' => false), array('class'=>'bookit','title'=>__l('Book it'),'escape' => false)); ?> 
			<?php break;endif; ?>
			<?php endforeach; ?>
			<?php else: ?>
			<?php echo $this->Html->link(__l('Book it'), array('controller' => 'properties', 'action' => 'view', $requestProperty['Property']['slug'], 'admin' => false), array('class'=>'bookit','title'=>__l('Book it'),'escape' => false));
		?>
		<?php endif; ?>
			</div>
         </div>
		</div>
	</li>
							
				<?php 
				endif;
					endforeach;
				?>
			</ol>
		<?php endif; ?>


	</li>
<?php
 endforeach;
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo __l('No Requests available');?></p>
	</li>
<?php
endif;
?>
</ol>
<?php
if (!empty($requests)) :
        ?>
		<div class="admin-select-block">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
       
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
		<?php
endif;
    echo $this->Form->end();
?>
<?php
if (!empty($requests)) {
	if(count($requests) > 10) {
    echo $this->element('paging_links');
	}
}
?>
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
<div class="side2 request-right grid_right">
	<?php echo $this->element('user-stats'); ?>
</div>