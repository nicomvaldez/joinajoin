<!--WELCOME AREA-->
    <div class="gray_bg">
        <div class="container">
            <div class="row welcome">
                <div class="span12">
                    <h1><?php echo __l('Adventures and Experiences provided by YOU');?></h1>
                    <p><em>Powerful HTML5 / CSS3 template very flexible, very easy for customizing and well documented, approaches for personal and professional use.</em></p>
                </div>
            </div>
        </div>
    </div>
    <!--/WELCOME AREA-->
    <!--SLIDER AREA-->
    <div class="slider_area">
        <div class="container">
            <div class="row">
                <div class="span4 hidden-phone">
                    <h2><span class="label">Join a Join, Super Easy!</span></h2>
                    <p class="intro">Simple and flexible HTML, CSS, and Javascript for popular user interface components and interactions.</p>
                    <p><span class="pun"><em>Valera is designed to help people of all skill levels designer or developer, huge nerd or early beginner. Use it as a complete kit or use to start something more complex.</em></span></p>
                    <hr class="visible-desktop">
                    <h4 class="visible-desktop">Some of Template Features:</h4>
                    <div class="row visible-desktop">
                        <div class="span2">
                            <ul style="margin-top:10px;" class="unstyled">
                                <li><i class="icon-user"></i> Built for and by nerds</li>
                                <li><i class="icon-th"></i> 12-column grid</li>
                                <li><i class="icon-resize-horizontal"></i> Max-width 1200px</li>
                                <li><i class="icon-book"></i> Growing library</li>
                            </ul>
                        </div>
                        <div class="span2">
                            <ul style="margin-top:10px;" class="unstyled">
                                <li><i class="icon-resize-small"></i> Responsive design</li>
                                <li><i class="icon-eye-open"></i> Cross-everything</li>
                                <li><i class="icon-list-alt"></i> Styleguide docs</li>
                                <li><i class="icon-cog"></i> jQuery plugins</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <a href="<?=$link; ?>" class="btn btn-large btn-success mega"></i>Let's GO!</a>
                </div>
                <div class="span8 mainslider">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <img src="../assets/img/slide1.jpg" />
                            </li>
                            <li>
                                <a href="#"><img src="../assets/img/slide2.jpg" /></a>
                            </li>
                            <li>
                                <img src="../assets/img/slide3.jpg" />
                            </li>
                            <li>
                                <img src="../assets/img/slide2.jpg" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/SLIDER AREA-->






<!--
<?php /* SVN: $Id: home.ctp 7045 2012-01-06 14:09:22Z vinothraja_091at09 $ */ ?>
<?php
	$view_count_url = Router::url(array(
		'controller' => 'properties',
		'action' => 'update_view_count',
	), true);
?>
<div id="photo-1" class="ui-corner-right">
	<ul id="gallery" class="js-view-count-update {'model':'property','url':'<?php echo $view_count_url; ?>'}">
		<?php foreach($properties As $property) { ?>
			<?php if(isset($property['Attachment'][0])): ?>
				<li>
					<?php echo $this->Html->showImage('Property', $property['Attachment'][0], array('dimension' => 'medium_big_thumb','class'=>'js-skip-gallery  gallery-image', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($property['Property']['title'], false)), 'title' => $this->Html->cText($property['Property']['title'], false))); ?>
					<div class="gv-panel-overlay">
						<div class="clearfix">
							<div class="clearfix grid_8 omega alpha">
								<div class="clearfix">
									<div class="grid_2 user-avatar alpha omega">
										<div>
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
									</div>
									<div class="clearfix home-info-block grid_7 omega alpha">
										<h3>
											<?php
												echo $this->Html->link($this->Text->truncate($property['Property']['title'], 30, array('ending' => '...','exact' => false)), array('controller' => 'properties', 'action' => 'view', $property['Property']['slug'], 'admin' => false),array('title'=>$this->Html->cText($property['Property']['title'], false)));
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
									<dl class="clearfix guest request-list1">
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
												echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width' => '50px', 'height' => '50px', 'class' => 'js-skip-gallery', 'title' => $positive.'%'));
											?>
											</dd>
										<?php endif; ?>
									</dl>
								</div>
							</div>
							<div class="city-price grid_4 grid_right omega alpha">
								<div class="clearfix city-price1">
									<?php if(configure::read('site.currency_symbol_place')=='left'): ?>
										<sub><?php echo configure::read('site.currency'); ?></sub>
									<?php endif; ?>
									<?php echo $this->Html->cCurrency($property['Property']['price_per_night']);?>
									<?php if(configure::read('site.currency_symbol_place')=='right'): ?>
										<sub><?php echo configure::read('site.currency'); ?></sub>
									<?php endif; ?>
									<p class=""><?php echo __l('Per night');?></p>
								</div>
								<div class="clearfix price-info-right">
									<dl class="clearfix request-list grid_2 omega alpha">
										<dt>
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

-->