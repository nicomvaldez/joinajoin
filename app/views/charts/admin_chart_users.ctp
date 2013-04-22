<div class="clearfix js-responses js-loadadmin-chart-users-ctp">
	<?php
		$chart_title = __l('User Registration');
		$chart_y_title = __l('Users');
		$page_title = __l('User');
		$user_type_id = $this->request->data['Chart']['user_type_id'];
		$arrow = "down-arrow";
		if (isset($this->request->params['named']['is_ajax_load'])) {
			$arrow = "up-arrow";
		}
	?>
	<div class="pptab-menu-left">
		<div class="pptab-menu-right">
			<div class="pptab-menu-center clearfix">
				<h2 class="chart-dashboard-title ribbon-title clearfix">
					<span class="ribbon-right">
						<span class="ribbon-inner">
							<?php echo __l('Registration').' - '.$page_title; ?>
						</span>
					</span>
					<span class="js-chart-showhide <?php echo $arrow; ?> {'chart_block':'admin-dashboard-user<?php echo $user_type_id; ?>', 'dataloading':'div.js-loadadmin-chart-users-ctp',  'dataurl':'admin/charts/chart_users/is_ajax_load:1/user_type_id:<?php echo $user_type_id; ?>'}"></span>
				</h2>
			</div>
		</div>
	</div>
	<?php if(isset($this->request->params['named']['is_ajax_load'])) { ?>
	<div class="main-inner clearfix round-3">
		<div class="admin-center-block clearfix dashboard-center-block <?php echo (empty($this->request->params['isAjax']))? 'hide' : ''; ?>" id="admin-dashboard-user<?php echo $user_type_id; ?>">
			<div class="clearfix">
				<?php echo $this->Form->create('Chart' , array('class' => 'grid_right language-form', 'action' => 'chart_users')); ?>
				<?php  
					echo $this->Form->input('user_type_id', array('type' => 'hidden'));
					echo $this->Form->input('is_ajax_load', array('type' => 'hidden', 'value' => 1));
					echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range')));
				?>
				<div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div class="js-load-line-graph grid_left chart-half-section {'data_container':'user_line_data<?php echo $user_type_id; ?>', 'chart_container':'user_line_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
				<div class="dashboard-tl">
					<div class="dashboard-tr">
						<div class="dashboard-tc"></div>
					</div>
				</div>
				<div class="dashboard-cl">
					<div class="dashboard-cr">
						<div class="dashboard-cc clearfix">
							<div id="user_line_chart<?php echo $user_type_id; ?>" class="grid_left admin-dashboard-chart"></div>
							<div class="hide">
								<table id="user_line_data<?php echo $user_type_id; ?>" class="list">
									<thead>
										<tr>
											<th>Period</th>
											<?php foreach($chart_periods as $_period): ?>
												<th><?php echo $_period['display']; ?></th>
											<?php endforeach; ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach($chart_data as $display_name => $chart_data): ?>
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
			<?php if(!empty($chart_pie_data)): ?>
				<div class="js-load-pie-chart grid_left chart-half-section {'data_container':'user_pie_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo $chart_title;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
					<div class="dashboard-tl">
						<div class="dashboard-tr">
							<div class="dashboard-tc"></div>
						</div>
					</div>
					<div class="dashboard-cl">
						<div class="dashboard-cr">
							<div class="dashboard-cc clearfix">
								<div id="user_pie_chart<?php echo $user_type_id; ?>" class="grid_left admin-dashboard-chart"></div>
								<div class="hide">
									<table id="user_pie_data<?php echo $user_type_id; ?>" class="list">								
										<tbody>
											<?php foreach($chart_pie_data as $display_name => $val): ?>
												<tr>
													<th><?php echo $display_name; ?></th>
													<td><?php echo $val; ?></td>
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
				<h3><?php echo __l('Demographics'); ?></h3>
				<?php echo $this->element('chart-user_demographics', array('chart_y_title'=> $chart_y_title, 'user_type_id' => $user_type_id)); ?>
			<?php endif; ?>				
		</div>
	</div>
	<?php }?>
</div>