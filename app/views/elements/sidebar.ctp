<?php
if(
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'dashboard') ||
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'social') ||
	($this->request->params['controller'] == 'messages' && $this->request->params['action'] == 'index') ||
	($this->request->params['controller'] == 'affiliates') ||
	($this->request->params['controller'] == 'affiliate_cash_withdrawals') ||
	($this->request->params['controller'] == 'user_cash_withdrawals') ||
	($this->request->params['controller'] == 'money_transfer_accounts') ||
	($this->request->params['controller'] == 'user_notifications' && $this->request->params['action'] == 'edit') ||
	($this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit') ||
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'change_password') ||
	($this->request->params['controller'] == 'user_friends' && $this->request->params['action'] == 'import') ||
	($this->request->params['controller'] == 'user_paypal_connections') ||
	($this->request->params['controller'] == 'user_payment_profiles') ||
	($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'add_to_wallet')
):
?>
<div class="block2">
<div class="block2-tl">
              <div class="block2-tr">
                <div class="block2-tm">
                  <h4><?php echo $this->request->data['UserProfile']['first_name'].' '.$this->request->data['UserProfile']['last_name'] ;?></h4>
                </div>
              </div>
            </div>
            <div class="block2-cl">
                <div class="block2-cr">
                    <div class="block2-cm clearfix">
						<ul class="admin-links users-links">
                                                        <!-- Grace Basilio 21/02/2012 -->
                                                        <li><?php echo $this->Html->link(__l('My Joins'), array('controller' => 'myproperties', 'action' => 'index'),array('title' => __l('My Joins'))); ?></li>
                                                        <li><?php echo $this->Html->link(__l('My Calendar'), array('controller' => 'calendar', 'action' => 'index'),array('title' => __l('My Calendar'))); ?></li>
                                                        <li><?php echo $this->Html->link(__l('My Requests'), array('controller' => 'myrequests', 'action' => 'index'),array('title' => __l('My Requests'))); ?></li>
                                                        <li><?php echo $this->Html->link(__l('Request Favorites'), array('controller' => 'requests', 'action' => 'favorites'),array('title' => __l('Request Favorites'))); ?></li>
                                                        <li><?php echo $this->Html->link(__l('Join Favorites'), array('controller' => 'properties', 'action' => 'favorites'),array('title' => __l('Join Favorites'))); ?></li>
                                                        <li><?php echo $this->Html->link(__l('Request a Join'), array('controller' => 'requests', 'action' => 'add'),array('title' => __l('Request a Join'))); ?></li>
                                                        <!-- Grace Basilio 21/02/2012 -->
							<?php $class = ($this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Edit Profile'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('Edit profile')));?></li>
							<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'social') ? ' class="active"' : null; ?>
							<li><?php echo $this->Html->link(__l('Social Networks'), array('controller' => 'users', 'action' => 'social'), array('title' => __l('Social Networks')));?></li>
							<?php $class = ($this->request->params['controller'] == 'user_notifications' && $this->request->params['action'] == 'edit') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Email settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email settings')));?></li>
							<?php if (!$this->Auth->user('is_openid_register') && !$this->Auth->user('fb_user_id') && !$this->Auth->user('twitter_user_id') && !$this->Auth->user('is_gmail_register') && !$this->Auth->user('is_yahoo_register')): ?>
								<?php $class = ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'change_password') ? ' class="active"' : null; ?>
								<li <?php echo $class;?>><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change password')));?></li>
							<?php endif; ?>
							<?php $class = ($this->request->params['controller'] == 'user_paypal_connections' && $this->request->params['action'] == 'index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('PayPal Connections'), array('controller' => 'user_paypal_connections', 'action' => 'index'), array('title' => __l('PayPal connections')));?></li>
							<?php $class = ($this->request->params['controller'] == 'user_payment_profiles') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index'), array('title' => __l('Credit Cards')));?></li>
							<?php $class = ($this->request->params['controller'] == 'user_cash_withdrawals' && $this->request->params['action'] == 'index') ? ' class="active"' : null; ?>
							<li <?php echo $class;?>><?php echo $this->Html->link(__l('Withdraw Fund Request'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Withdraw Fund Request')));?></li>
							<?php $class = ($this->request->params['controller'] == 'money_transfer_accounts' && $this->request->params['action'] == 'index') ? ' class="active"' : null; ?>
							<li><?php echo $this->Html->link(__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('title' => __l('Money Transfer Accounts')));?></li>
						</ul>
                    </div>
                </div>
            </div>
            
            <div class="block2-bl">
              <div class="block2-br">
                <div class="block2-bm"> </div>
              </div>
            </div>
</div>
<?php endif; ?>

