<?php /* SVN: $Id: home.ctp 8982 2012-07-21 11:33:27Z ramkumar_136act10 $ */ ?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
<div id="photo-1" class="section2 grid_14 grid_right clearfix ui-corner-right">
	<ul id="gallery" class="pr js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
		<?php foreach($properties As $property) { ?>
			<?php if(isset($property['Attachment'][0])): ?>
				<li>
					<?php echo $this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'medium_big_thumb','class'=>'js-skip-gallery  gallery-image', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
					<div class="gv-panel-overlay">
						<div class="clearfix">
							<div class="clearfix grid_8 omega alpha">
								<div class="clearfix">
									<div class="grid_1 user-avatar alpha omega">
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
												echo $this->Html->link($this->Text->truncate($this->Html->cText($property['Property']['title'],false), 30, array('ending' => '...','exact' => false)), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false),array('title'=>$this->Html->cText($property['Property']['title'], false)));
											?>
										</h3>
										<p class="address-info sfont dl clearfix">
											<?php if(!empty($property['Country']['iso2'])): ?>
												<span class="flags flag-<?php echo strtolower($property['Country']['iso2']); ?>" title ="<?php echo $property['Country']['name']; ?>"><?php echo $property['Country']['name']; ?></span>
											<?php endif; ?>
											<span class="request-info"><?php echo $this->Text->truncate($property['Property']['address'], 40, array('ending' => '...', 'exact' => false));?></span>
										</p>
									</div>
								</div>
								<div class="clearfix grid_7 omega alpha">
									<dl class="request-list1 view-list1 guest clearfix">
										<dt class="positive-feedback1" title ="<?php echo __l('Views');?>"><?php echo __l('Views');?></dt>
										<dd class="dc positive-feedback1 js-view-count-property-id js-view-count-property-id-<?php echo $property['Property']['id']; ?> {'id':'<?php echo $property['Property']['id']; ?>'}">
										<?php echo numbers_to_higher($property['Property']['property_view_count']); ?>										
										</dd>
									</dl>
									<dl class="ratings-feedback1 clearfix">
										<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>"><?php echo __l('Positive');?></dt>
										<dd class="positive-feedback1">
										<?php echo numbers_to_higher($property['Property']['positive_feedback_count']); ?>
										</dd>
									</dl>
									<dl class="ratings-feedback1 clearfix">
										<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
										<dd  class="negative-feedback1">
										<?php echo numbers_to_higher($property['Property']['property_feedback_count'] - $property['Property']['positive_feedback_count']); ?>										
										</dd>
									</dl>
									<dl class="clearfix guest request-list1">
										<dt title ="<?php echo __l('Success Rate');?>"><?php echo __l('Success Rate');?></dt>
										<?php if($property['Property']['property_feedback_count'] == 0): ?>
											<dd class="not-available dc" title="<?php  echo __l('No bookings available'); ?>"><?php  echo __l('n/a'); ?></dd>
										<?php else:?>
											<dd class="success-rating no-bimg dc">
											<?php
												if(!empty($property['Property']['positive_feedback_count'])):
													$positive = floor(($property['Property']['positive_feedback_count']/$property['Property']['property_feedback_count']) *100);
													$negative = 100 - $positive;
												else:
													$positive = 0;
													$negative = 100;
												endif;
												echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$positive.','.$negative.'&amp;chs=50x50&amp;chco=00FF00|FF0000&amp;chf=bg,s,FFFFFF00', array('width' => '50px', 'height' => '50px', 'class' => 'js-skip-gallery', 'title' => $positive.'%'));
											?>
											</dd>
										<?php endif; ?>
									</dl>
								</div>
							</div>
							<div class="city-price grid_4 grid_right omega alpha">
								<div class="clearfix city-price1 dc">
									<?php if(configure::read('site.currency_symbol_place')=='left'): ?>
										<sub class="tb"><?php echo configure::read('site.currency'); ?></sub>
									<?php endif; ?>
									<?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
									<?php if(configure::read('site.currency_symbol_place')=='right'): ?>
										<sub class="tb"><?php echo configure::read('site.currency'); ?></sub>
									<?php endif; ?>
									<p class=""><?php echo __l('Per night');?></p>
								</div>
								<div class="clearfix price-info-right">
									<dl class="clearfix request-list dc grid_2 omega alpha">
										<dt><?php echo __l('Per Week');?></dt>
										<dd>
											<?php
												if($property['Property']['price_per_week']!=0):
													echo $this->Html->siteCurrencyFormat($property['Property']['price_per_week']);
												else:
													echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*7);
												endif;
											?>
										</dd>
									</dl>
									<dl class="clearfix request-list dc grid_2 omega alpha">
										<dt><?php echo __l('Per Month');?></dt>
										<dd>
											<?php
												if($property['Property']['price_per_month']!=0):
													echo $this->Html->siteCurrencyFormat($property['Property']['price_per_month']);
												else:
													echo $this->Html->siteCurrencyFormat($property['Property']['price_per_night']*30);
												endif;
											?>
										</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php endif; ?>
		<?php } ?>
	</ul>
</div>