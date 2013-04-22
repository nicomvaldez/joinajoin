<div class="clearfix js-responses js-loadadmin-chart-requests">
	<?php
		$class = 'grid_left admin-dashboard-chart';
		$class_pass = 'admin-dashboard-pass-usage-chart';
		$arrow = "down-arrow";
		if (isset($this->request->params['named']['is_ajax_load'])) {
			$arrow = "up-arrow";
		}
	?>
	<div class="pptab-menu-left">
		<div class="pptab-menu-right">
			<div class="pptab-menu-center clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix">
					<span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Requests'); ?></span></span>
					<span  class="js-chart-showhide <?php echo $arrow; ?> {'chart_block':'admin-dashboard-requests', 'dataloading':'div.js-loadadmin-chart-requests',  'dataurl':'admin/charts/chart_requests/is_ajax_load:1'}"></span>
				</h2>
			</div>
		</div>
	</div>
	<?php if(isset($this->request->params['named']['is_ajax_load'])){ ?>
		<div class="main-inner clearfix round-3">	
			<div class="admin-center-block clearfix dashboard-center-block <?php echo (empty($this->request->params['isAjax']))? 'hide' : ''; ?>" id="admin-dashboard-requests">
				<div class="clearfix">
					<?php echo $this->Form->create('Chart' , array('class' => 'grid_right language-form', 'action' => 'chart_requests'));
					echo $this->Form->input('is_ajax_load', array('type' => 'hidden', 'value' => 1));
					?>
					<?php echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range'))); ?>
					<div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
					<?php echo $this->Form->end(); ?>
				</div>
				<div class="js-load-line-graph grid_left chart-half-section {'data_container':'items_line_data', 'chart_container':'items_line_chart', 'chart_title':'<?php echo __l('Requests') ;?>', 'chart_y_title': '<?php echo __l('Requests');?>'}">
					<div class="dashboard-tl">
						<div class="dashboard-tr">
							<div class="dashboard-tc"></div>
						</div>
					</div>
					<div class="dashboard-cl">
						<div class="dashboard-cr">
							<div class="dashboard-cc clearfix">
								<div id="items_line_chart" class="<?php echo $class; ?>"></div>
								<div class="hide">
									<table id="items_line_data" class="list">
										<thead>
											<tr>
												<th>Period</th>
												<?php foreach($chart_requests_periods as $_period): ?>
													<th><?php echo $_period['display']; ?></th>
												<?php endforeach; ?>              	
											</tr>
										</thead>
										<tbody>
											<?php foreach($chart_requests_data as $display_name => $chart_data): ?>
												<tr>
													<th><?php echo $display_name; ?></th>
													<?php foreach($chart_data as $val): ?>
														<td><?php echo $val; ?></td>
													<?php endforeach; ?> 
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-bl">
						<div class="dashboard-br">
							<div class="dashboard-bc"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>