<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="requests index js-response">
<?php
	$view_count_url = Router::url(array(
		'controller' => 'requests',
		'action' => 'update_view_count',
	), true);
?>
<ol class="list clearfix property-list comments-list js-view-count-update {'model':'request','url':'<?php echo $view_count_url; ?>'}">
<?php
if (!empty($requests)):

$i = 0;
foreach ($requests as $request):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li class="clearfix <?php echo $class; ?>">
                                	 <div class="grid_11 request-left-block omega">
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
                		<div class="grid_10 alpha omega">

                    	<div class="clearfix">
                    		<h2>
                    		<?php
                				$lat = $request['Request']['latitude'];
                				$lng = $request['Request']['longitude'];
                				$id = $request['Request']['id'];

                				echo $this->Html->link($this->Html->cText($request['Request']['title']), array('controller' => 'requests', 'action' => 'view', $request['Request']['slug'], 'admin' => false), array('id'=>"js-map-side-$id", 'class'=>"js-map-data {'lat':'$lat','lng':'$lng'}", 'title'=>$this->Html->cText($request['Request']['title'],false),'escape' => false));
                			?>
                    		</h2>
                    		<?php
                    			$flexible_class = '';
                    			if(isset($is_flexible_check)) {
                    				if(!in_array($property['Property']['id'], $booked_property_ids)) { ?>
                    			<span class="available"> <?php echo __l('Exact'); ?></span>
                    		<?php		}
                    			}
                    		?>
                    		</div>
                        	<p class="address-info">
								<?php if(!empty($request['Country']['iso2'])): ?>
										<span class="flags flag-<?php echo strtolower($request['Country']['iso2']); ?>" title ="<?php echo $request['Country']['name']; ?>"><?php echo $request['Country']['name']; ?></span>
								<?php endif; ?>
								<?php echo $this->Html->cText($request['Request']['address']);?>
							<?php echo  '(' . $this->Time->timeAgoInWords($request['Request']['created']) . ')';?></p>
                   		<div class="request-description"><?php echo $this->Html->truncate($request['Request']['description']);?>
	                    </div>
                     


                		<div class="clearfix">
                        <dl class="request-list1 guest count-list1 clearfix">
                		      <dt><?php echo __l('Views'); ?></dt>
                		   <dd class="js-view-count-request-id js-view-count-request-id-<?php echo $request['Request']['id']; ?> {'id':'<?php echo $request['Request']['id']; ?>'}"><?php echo $request['Request']['request_view_count']; ?>  </dd>
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
										echo $this->Html->cInt($days);
									?>
							   </dd>
							</dl>
                		</div>
                		<?php if($request['User']['id']==$this->Auth->user('id')): ?>
                		<div class=" edit-info-block clearfix">
                		<div class="actions">
                        <?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $request['Request']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?>
                        <?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $request['Request']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></div>
                        </div>
                		<?php endif; ?>
                    </div>
	                </div>
               		</div>
                		<div class="grid_4 request-right-block omega alpha">
                		<p class="address-info"><?php echo $this->Html->cDateTimeHighlight($request['Request']['checkin']);?><?php echo __l(' - '); ?><?php echo $this->Html->cDateTimeHighlight($request['Request']['checkout']);?></p>
                        <div class="clearfix city-price1">
						<?php if (Configure::read('site.currency_symbol_place') == 'left'): ?>
						  <sub> <?php echo Configure::read('site.currency').' '?></sub>
						 <?php endif; ?>                           
                        <?php echo $this->Html->cCurrency($request['Request']['price_per_night']); ?>
						<?php if (Configure::read('site.currency_symbol_place') == 'right'): ?>
					      <sub> <?php echo Configure::read('site.currency').' '?></sub>
						<?php endif; ?>
                             <p class="pernight-info"><?php echo __l('per night');?></p>
                            </div>

                    	<?php if($request['User']['id']!=$this->Auth->user('id')): ?>
                		<?php if($request['Request']['checkin']>=date('Y-m-d') && $request['Request']['checkout']>=date('Y-m-d')): ?>
                                <div class="clearfix">
                                <div class="cancel-block"><?php echo $this->Html->link(__l('Make an offer'), array('controller' => 'properties', 'action' => 'add','request',$request['Request']['id'], 'admin' => false), array('title'=>__l('Make an offer'), 'escape' => false)); ?></div>
                                </div>
                        <?php endif; endif; ?>
                		</div>
	</li>
<?php
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
 <div class="js-pagination">
<?php
if (!empty($requests)) {
	if(count($requests)>10) {
    echo $this->element('paging_links');
	}
}
?>
</div>
</div>
