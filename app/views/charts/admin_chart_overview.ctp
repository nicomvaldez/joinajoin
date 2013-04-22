<div class="clearfix js-responses">
	<div class="main-tl">
		<div class="main-tr">
			<div class="main-tm"> </div>
		</div>
	</div>
<div class="pptab-menu-left">
		<div class="pptab-menu-right">
			<div class="pptab-menu-center clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix"><span class="ribbon-right">	<span class="ribbon-inner"><?php echo __l('Overview'); ?></span></span><span class="js-chart-showhide up-arrow {'chart_block':'admin-dashboard-overview'}"></span></h2>
				<div class="admin-center-block dashboard-center-block clearfix" id="admin-dashboard-overview">
					<div class="clearfix">
						<?php echo $this->Form->create('Chart' , array('class' => 'language-form grid_right', 'action' => 'chart_overview')); ?>
						<?php echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range'))); ?>
						<div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
						<?php echo $this->Form->end(); ?>
					</div>
					<div class="js-load-line-graph grid_left chart-half-section {'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="transactions_line_chart" class="grid_left admin-dashboard-chart"></div>
									<div class="hide">
										<table id="transactions_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_transactions_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_transactions_data as $display_name => $chart_data): ?>
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
					<div class="js-load-column-chart grid_left chart-half-section {'data_container':'property_views_column_data', 'chart_container':'property_views_column_chart', 'chart_title':'<?php echo __l('Property Views') ;?>', 'chart_y_title': '<?php echo __l('Property Views');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="property_views_column_chart" class="grid_left admin-dashboard-chart"></div>
									<div class="hide">
										<table id="property_views_column_data" class="list">
											<tbody>
												<?php foreach($chart_property_views_data as $key => $_data): ?>
													<tr>
														<th><?php echo $key; ?></th>
														<td><?php echo $_data[0]; ?></td>
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
					<div class="js-load-line-graph grid_left chart-half-section {'data_container':'booking_line_data', 'chart_container':'booking_line_chart', 'chart_title':'<?php echo __l('Total Bookings') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="booking_line_chart" class="grid_left admin-dashboard-chart"></div>
									<div class="hide">
										<table id="booking_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_booking_data_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_booking_data as $display_name => $chart_data): ?>
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
					<div class="js-load-line-graph grid_left chart-half-section {'data_container':'revenue_line_data', 'chart_container':'revenue_line_chart', 'chart_title':'<?php echo __l('Revenue') ;?>', 'chart_y_title': '<?php echo __l('Value');?>'}">
						<div class="dashboard-tl">
							<div class="dashboard-tr">
								<div class="dashboard-tc"></div>
							</div>
						</div>
						<div class="dashboard-cl">
							<div class="dashboard-cr">
								<div class="dashboard-cc clearfix">
									<div id="revenue_line_chart" class="grid_left admin-dashboard-chart"></div>
									<div class="hide">
										<table id="revenue_line_data" class="list">
											<thead>
												<tr>
													<th>Period</th>
													<?php foreach($chart_revenue_data_periods as $_period): ?>
														<th><?php echo $_period['display']; ?></th>
													<?php endforeach; ?>
												</tr>
											</thead>
											<tbody>
												<?php foreach($chart_revenue_data as $display_name => $chart_data): ?>
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
		</div>
	</div>
	<div class="main-bl">
		<div class="main-br">
			<div class="main-bm"> </div>
		</div>
	</div>
</div>