<h5 class="hidden-info"><?php echo __l('Admin side links'); ?></h5>
<ul class="admin-links clearfix">
	<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_stats') ? 'active' : null; ?>
	<li class="grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center dashboard">
				<?php echo __l('Dashboard'); ?>
				</span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
							<li><h4><?php echo __l('Dashboard'); ?></h4></li>
							<li><?php echo $this->Html->link(__l('Snapshot'), array('controller' => 'users', 'action' => 'stats'),array('title' => __l('Snapshot'))); ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php
		$controller = array('users', 'user_profiles',  'user_logins', 'user_views',  'messages',  'user_paypal_connections',  'paypal_accounts');
		$class = (in_array( $this->request->params['controller'], $controller) && !in_array($this->request->params['action'], array('admin_logs', 'admin_stats'))) ? 'active' : null;
	?>
	<li class="grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-users">
					<?php echo __l('Users'); ?>
				</span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
						    <li><h4><?php echo __l('Users'); ?></h4></li>
							<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Users'), array('controller' => 'users', 'action' => 'index'),array('title' => __l('Users'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'user_logins') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Logins'), array('controller' => 'user_logins', 'action' => 'index'),array('title' => __l('User Logins'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'user_views') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Views'), array('controller' => 'user_views', 'action' => 'index'),array('title' => __l('User Views'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_send_mail') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Send Email to Users'), array('controller' => 'users', 'action' => 'send_mail'),array('title' => __l('Send Email to Users'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'messages') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('User Messages'), array('controller' => 'messages', 'action' => 'index'),array('title' => __l('Messages'))); ?></li>
							<?php if (Configure::read('property.is_paypal_connection_enabled')): ?>
								<?php $class = ($this->request->params['controller'] == 'user_paypal_connections') ? ' class="active"' : null; ?>
								<li <?php echo $class;?>><?php echo $this->Html->link(__l('PayPal Connections'), array('controller' => 'user_paypal_connections', 'action' => 'index'), array('title' => __l('PayPal Connections'))); ?></li>
							<?php endif; ?>
							<?php $class = ($this->request->params['controller'] == 'paypal_accounts' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Paypal Accounts'), array('controller' => 'paypal_accounts', 'action' => 'index'),array('title' => __l('PayPal Accounts'))); ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php
		$controller = array('properties', 'property_views',  'property_favorites', 'property_flags',  'collections',  'property_users',  'property_feedbacks', 'property_user_feedbacks', 'property_user_disputes');
		$class = (in_array( $this->request->params['controller'], $controller)) ? ' active' : null;
	?>
	<li class="masters-block grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-properties"><?php echo __l('Properties'); ?></span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
							<li>
								<ul class="clearfix">
									<li class="admin-sub-links-left grid_left">
										<ul>
											<li><h4><?php echo __l('Properties'); ?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'properties' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Properties'), array('controller' => 'properties', 'action' => 'admin_index'),array('title' => __l('Properties'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'properties' && $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Property'), array('controller' => 'properties', 'action' => 'admin_add'),array('title' => __l('Add Property'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_views') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Views'), array('controller' => 'property_views', 'action' => 'admin_index'),array('title' => __l('Property Views'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_favorites') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Favorites'), array('controller' => 'property_favorites', 'action' => 'admin_index'),array('title' => __l('Property Favorites'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_flags') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Flags'), array('controller' => 'property_flags', 'action' => 'admin_index'),array('title' => __l('Property Flags'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Collections'); ?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'collections' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Collections'), array('controller' => 'collections', 'action' => 'admin_index'),array('title' => __l('Collections'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'collections' && $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Collection'), array('controller' => 'collections', 'action' => 'admin_add'),array('title' => __l('Add Collection'))); ?></li>
										</ul>
									</li>
									<li class="admin-sub-links-right grid_left">
										<ul>
											<li><h4><?php echo __l('Bookings'); ?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'property_users') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Bookings'), array('controller' => 'property_users', 'action' => 'admin_index'),array('title' => __l('Property Bookings'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_feedbacks') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Feedback To Host'), array('controller' => 'property_feedbacks', 'action' => 'admin_index'),array('title' => __l('Feedback To Host'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_user_feedbacks') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Feedback To Traveler'), array('controller' => 'property_user_feedbacks', 'action' => 'admin_index'),array('title' => __l('Feedback To Traveler'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Disputes'); ?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'property_user_disputes') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Disputes'), array('controller' => 'property_user_disputes', 'action' => 'admin_index'),array('title' => __l('Disputes'))); ?></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php
		$controller = array('requests', 'request_views',  'request_favorites', 'request_flags');
		$class = (in_array( $this->request->params['controller'], $controller)) ? ' active' : null;
	?>
	<li class="grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-request"><?php echo __l('Requests'); ?></span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
							<li><h4><?php echo __l('Requests'); ?></h4></li>
							<?php $class = ($this->request->params['controller'] == 'requests' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Requests'), array('controller' => 'requests', 'action' => 'admin_index'),array('title' => __l('Requests'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'requests' && $this->request->params['action'] == 'admin_add') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Add Request'), array('controller' => 'requests', 'action' => 'admin_add'),array('title' => __l('Add Request'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'request_views') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Request Views'), array('controller' => 'request_views', 'action' => 'admin_index'),array('title' => __l('Request Views'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'request_favorites' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'request_favorites', 'action' => 'admin_index'),array('title' => __l('Request Favorites'))); ?></li>
							<?php $class = ($this->request->params['controller'] == 'request_flags') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Request Flags'), array('controller' => 'request_flags', 'action' => 'admin_index'),array('title' => __l('Request Flags'))); ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php
		$controller = array('transactions', 'payment_gateways',  'user_cash_withdrawals', 'affiliate_cash_withdrawals');
		$class = (in_array( $this->request->params['controller'], $controller)) ? 'active' : null;
	?>
	<li class="grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-payments"><?php echo __l('Payments'); ?></span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
							<li>
								<ul>
									<li><h4><?php echo __l('Payments'); ?></h4></li>
									<?php $class = ($this->request->params['controller'] == 'transactions' && $this->request->params['action'] == 'admin_index') ? ' class="active"' : null; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('Transactions'), array('controller' => 'transactions', 'action' => 'admin_index'),array('title' => __l('Transactions'))); ?></li>
									<?php $class = ($this->request->params['controller'] == 'payment_gateways') ? 'active' : null; ?>
									<li class="setting-overview payment-overview <?php echo $class;?>"><?php echo $this->Html->link(__l('Payment Gateways'), array('controller' => 'payment_gateways', 'action' => 'admin_index'),array('title' => __l('Payment Gateways'))); ?></li>
								</ul>
							</li>
							<li>
								<ul>
									<li><h4><?php echo __l('Withdraw Fund Requests'); ?></h4></li>
									<?php $class = ($this->params['controller'] == 'user_cash_withdrawals') ? ' class="active"' : null; ?>
									<li <?php echo $class;?>><?php echo $this->Html->link(__l('Users'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'),array('title' => __l('Users'))); ?></li>
									<?php if (Configure::read('affiliate.is_enabled')):?>
										<?php $class = ($this->params['controller'] == 'affiliate_cash_withdrawals') ? ' class="active"' : null; ?>
										<li><?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending),array('title' => __l('Affiliates'))); ?></li>
									<?php endif; ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php if (Configure::read('affiliate.is_enabled')):?>
		<?php
			$controller = array('affiliates', 'affiliate_requests',  'affiliate_types');
			$class = (in_array( $this->request->params['controller'], $controller)) ? ' active' : null;
		?>
	<li class="grid_3 <?php echo $class;?>">
			<?php echo $this->element('affiliate_admin_sidebar', array('config' => 'sec'));?>
		</li>
	<?php endif; ?>
	<?php
		$controller = array('settings');
		$class = (in_array( $this->request->params['controller'], $controller)) ? ' active' : null;
	?>
	<li class="masters setting-masters-block masters-block grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-settings"><?php echo __l('Settings'); ?></span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links clearfix">
							<li>
								<ul>
									<li class="setting-overview setting-overview1 clearfix">
									<?php echo $this->Html->link(__l('Setting Overview'), array('controller' => 'settings', 'action' => 'index'),array('title' => __l('Setting Overview'), 'class' => 'setting-overview grid_right')); ?></li>
									<li>
										<h4 class="setting-title"><?php echo __l('Settings'); ?></h4>
										<ul>
											<li class="admin-sub-links-left  grid_left">
												<ul>
													<li>
														<ul>
															<li><?php echo $this->Html->link(__l('System'), array('controller' => 'settings', 'action' => 'edit', 1),array('title' => __l('System'))); ?></li>
															<li><?php echo $this->Html->link(__l('Developments'), array('controller' => 'settings', 'action' => 'edit', 2),array('title' => __l('Developments'))); ?></li>
															<li><?php echo $this->Html->link(__l('SEO'), array('controller' => 'settings', 'action' => 'edit', 3),array('title' => __l('SEO'))); ?></li>
															<li><?php echo $this->Html->link(__l('Regional, Currency & Language'), array('controller' => 'settings', 'action' => 'edit', 4),array('title' => __l('Regional, Currency & Language'))); ?></li>
															<li><?php echo $this->Html->link(__l('Account '), array('controller' => 'settings', 'action' => 'edit', 5),array('title' => __l('Account'))); ?></li>
															<li><?php echo $this->Html->link(__l('Payment'), array('controller' => 'settings', 'action' => 'edit', 6),array('title' => __l('Payment'))); ?></li>
															<li><?php echo $this->Html->link(__l('Property'), array('controller' => 'settings', 'action' => 'edit', 7),array('title' => __l('Property'))); ?></li>
															<li><?php echo $this->Html->link(__l('Revenue'), array('controller' => 'settings', 'action' => 'edit', 8),array('title' => __l('Revenue'))); ?></li>
														</ul>
													</li>
												</ul>
											</li>
											<li class="admin-sub-links-right grid_left">
												<ul>
													<li>
														<ul>
															<li><?php echo $this->Html->link(__l('Request'), array('controller' => 'settings', 'action' => 'edit', 9),array('title' => __l('Request'))); ?></li>
															<li><?php echo $this->Html->link(__l('Suspicious Words Detector'), array('controller' => 'settings', 'action' => 'edit', 10),array('title' => __l('Suspicious Words Detector'))); ?></li>
															<li><?php echo $this->Html->link(__l('Messages'), array('controller' => 'settings', 'action' => 'edit', 11),array('title' => __l('Messages'))); ?></li>
															<li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'settings', 'action' => 'edit', 12),array('title' => __l('Friends'))); ?></li>
															<li><?php echo $this->Html->link(__l('Dispute'), array('controller' => 'settings', 'action' => 'edit', 13),array('title' => __l('Dispute'))); ?></li>
															<li><?php echo $this->Html->link(__l('Affiliate'), array('controller' => 'settings', 'action' => 'edit', 14),array('title' => __l('Affiliate'))); ?></li>
															<li><?php echo $this->Html->link(__l('Third Party API'), array('controller' => 'settings', 'action' => 'edit', 15),array('title' => __l('Third Party API'))); ?></li>
															<li><?php echo $this->Html->link(__l('Module Manager'), array('controller' => 'settings', 'action' => 'edit', 16),array('title' => __l('Module Manager'))); ?></li>
														</ul>
													</li>
												</ul>
											</li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
	<?php
		$controller = array('cities', 'states', 'countries', 'currencies', 'banned_ips', 'languages', 'translations', 'user_educations', 'user_employments', 'habits', 'user_income_ranges', 'user_relationships', 'pages', 'email_templates', 'amenities', 'bed_types', 'holiday_types', 'property_types', 'room_types', 'privacies', 'property_flag_categories', 'request_flag_categories', 'cancellation_policies', 'transaction_types', 'ips');
		$class = (in_array( $this->request->params['controller'], $controller)) ? ' active' : null;
	?>
    <li class="masters masters-block grid_3 <?php echo $class;?>">
		<span class="amenu-left">
			<span class="amenu-right">
				<span class="menu-center admin-masters"><?php echo __l('Masters');?></span>
			</span>
		</span>
		<div class="admin-sub-block">
			<div class="admin-top-lblock">
				<div class="admin-top-rblock">
					<div class="admin-top-cblock"></div>
				</div>
			</div>
			<div class="admin-sub-lblock">
				<div class="admin-sub-rblock">
					<div class="admin-sub-cblock">
						<ul class="admin-sub-links">
							<li>
							<div class="page-info master-page-info"><?php echo __l('Warning! Please edit with caution.');?></div>
								<ul class="clearfix">
										<li class="admin-sub-links-left grid_left">
										<ul>
											<li><h4><?php echo __l('Regional');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'cities') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Cities'), array('controller' => 'cities', 'action' => 'admin_index'),array('title' => __l('Cities'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'states') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('States'), array('controller' => 'states', 'action' => 'index'),array('title' => __l('States'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'countries') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Countries'), array('controller' => 'countries', 'action' => 'admin_index'),array('title' => __l('Countries'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'currencies') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Currencies'), array('controller' => 'currencies', 'action' => 'admin_index'),array('title' => __l('Currencies'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'banned_ips') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Banned IPs'), array('controller' => 'banned_ips', 'action' => 'admin_index'),array('title' => __l('Banned IPs'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Languages');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'languages') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Languages'), array('controller' => 'languages', 'action' => 'admin_index'),array('title' => __l('Languages'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'translations') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Translations'), array('controller' => 'translations', 'action' => 'admin_index'),array('title' => __l('Translations'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Demographics');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'user_educations') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Educations'), array('controller' => 'user_educations', 'action' => 'index'), array('title' => __l('Educations'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'user_employments') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Employments'), array('controller' => 'user_employments', 'action' => 'index'), array('title' => __l('Employments'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'habits') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Habits'), array('controller' => 'habits', 'action' => 'admin_index'),array('title' => __l('Habits'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'user_income_ranges') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Income Ranges'), array('controller' => 'user_income_ranges', 'action' => 'index'), array('title' => __l('Income Ranges'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'user_relationships') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Relationships'), array('controller' => 'user_relationships', 'action' => 'index'), array('title' => __l('Relationships'))); ?></li>
										</ul>
									</li>
									<li class="admin-sub-links-right grid_left">
										<ul>
											<li><h4><?php echo __l('Static Pages');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'pages') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Manage Static Pages'), array('controller' => 'pages', 'action' => 'admin_index'),array('title' => __l('Manage Static Pages'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Email Templates');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'email_templates') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Email Templates'), array('controller' => 'email_templates', 'action' => 'admin_index'),array('title' => __l('Email Templates'))); ?></li>
										</ul>
										<ul>
											<li><h4><?php echo __l('Others');?></h4></li>
											<?php $class = ($this->request->params['controller'] == 'amenities') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Amenities'), array('controller' => 'amenities', 'action' => 'admin_index'),array('title' => __l('Amenities'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'bed_types') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Bed Types'), array('controller' => 'bed_types', 'action' => 'admin_index'),array('title' => __l('Bed Types'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'holiday_types') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Holiday Types'), array('controller' => 'holiday_types', 'action' => 'admin_index'),array('title' => __l('Holiday Types'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_types') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Types'), array('controller' => 'property_types', 'action' => 'admin_index'),array('title' => __l('Property Types'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'room_types') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Room Types'), array('controller' => 'room_types', 'action' => 'admin_index'),array('title' => __l('Room Types'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'privacies') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Privacies'), array('controller' => 'privacies', 'action' => 'index'),array('title' => __l('Privacies'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'property_flag_categories') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Property Flag Categories'), array('controller' => 'property_flag_categories', 'action' => 'admin_index'),array('title' => __l('Property Flag Categories'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'request_flag_categories') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Request Flag Categories'), array('controller' => 'request_flag_categories', 'action' => 'admin_index'),array('title' => __l('Request Flag Categories'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'cancellation_policies') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Cancellation Policies'), array('controller' => 'cancellation_policies', 'action' => 'admin_index'),array('title' => __l('Cancellation Policies'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'transaction_types') ? ' class="active"' : null; ?>
											<li <?php echo $class;?>><?php echo $this->Html->link(__l('Transactions Types'), array('controller' => 'transaction_types', 'action' => 'admin_index'),array('title' => __l('Transactions Types'))); ?></li>
											<?php $class = ($this->request->params['controller'] == 'ips') ? ' class="active"' : null; ?>
											<li<?php echo $class;?>><?php echo $this->Html->link(__l('IPs'), array('controller' => 'ips', 'action' => 'index'), array('title' => __l('IPs'))); ?></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="admin-bot-lblock">
				<div class="admin-bot-rblock">
					<div class="admin-bot-cblock"></div>
				</div>
			</div>
		</div>
	</li>
</ul>