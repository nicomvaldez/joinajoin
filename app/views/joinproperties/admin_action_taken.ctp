<div class="clearfix admin-center-block">
	<div class="block2-tl">
			<div class="block2-tr">
				<div class="block2-tm">
                    <h3 class="action-taken"><?php echo __l('Actions to Be Taken'); ?></h3>
		          </div></div></div>
		<div class="pptview-mblock-ll">
				<div class="pptview-mblock-rr">
					<div class="pptview-mblock-mm">
    	<div class="dashboard-center-block">
			<h4><?php echo __l('Properties');?></h4>
			<ul class="admin-dashboard-links">
			<li><?php echo $this->Html->link(__l('Waiting For Approval') . ' (' . $pending_for_approval_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' =>ConstMoreAction::Disapproved, 'admin' => true));?></li>
			<li class="action-taken-link"><?php echo $this->Html->link(__l('Waiting for verification') . ' (' . $pending_for_verification_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' => ConstMoreAction::WaitingForVerification, 'admin' => true));?></li>
			</ul>
			<h4><?php echo __l('Requests');?></h4>
			<ul class="admin-dashboard-links">
			<li class="action-taken-link"><?php echo $this->Html->link(__l('Waiting For Approval') . ' (' . $request_pending_for_approval_count. ')', array('controller'=> 'requests', 'action' => 'index', 'filter_id' =>ConstMoreAction::Inactive, 'admin' => true));?></li>
			</ul>
			<h4><?php echo __l('Withdrawal Requests');?></h4>
			<ul class="admin-dashboard-links">
			<li class="action-taken-link"><?php echo $this->Html->link(__l('Users') . ' (' . $pending_withdraw_count. ')', array('controller'=> 'user_cash_withdrawals', 'action' => 'index', 'filter_id' =>ConstWithdrawalStatus::Pending, 'admin' => true));?></li>
			<li class="action-taken-link"><?php echo $this->Html->link(__l('Affiliates') . ' (' . $afffiliate_pending_withdraw_count. ')', array('controller'=> 'affiliate_cash_withdrawals', 'action' => 'index', 'filter_id' => ConstAffiliateCashWithdrawalStatus::Pending, 'admin' => true));?></li>
			</ul>
			<h4><?php echo __l('Disputes');?></h4>
			<ul class="admin-dashboard-links">
			<li class="action-taken-link"><?php echo $this->Html->link(__l('Waiting for Administrator Decision') . ' (' . $propery_displute_count. ')', array('controller'=> 'property_user_disputes', 'action' => 'index', 'filter_id' => ConstDisputeStatus::Open, 'admin' => true));?></li>
			</ul>
			<h4><?php echo __l('Flagged Properties');?></h4>
			<ul class="admin-dashboard-links">
			<li class="action-taken-link"><?php echo $this->Html->link(__l('User') . ' (' . $property_user_flagged_count. ')', array('controller'=> 'properties', 'action' => 'index', 'type' =>'user-flag','admin' => true));?></li>
			<li class="action-taken-link"><?php echo $this->Html->link(__l('System') . ' (' . $property_system_flagged_count. ')', array('controller'=> 'properties', 'action' => 'index', 'filter_id' =>ConstMoreAction::Flagged, 'admin' => true));?></li>
			</ul>
			<h4><?php echo __l('Flagged Requests');?></h4>
			<ul class="admin-dashboard-links">
			<li class="action-taken-link"><?php echo $this->Html->link(__l('User') . ' (' . $request_user_flagged_count. ')', array('controller'=> 'requests', 'action' => 'index', 'type' =>'user-flag',  'admin' => true));?></li>
			<li class="action-taken-link"><?php echo $this->Html->link(__l('System') . ' (' . $request_system_flagged_count. ')', array('controller'=> 'requests', 'action' => 'index', 'filter_id' =>ConstMoreAction::Flagged, 'admin' => true));?></li>
			</ul>
		</div>
		</div>
		</div>
		</div>
			<div class="pptview-mblock-bl">
				<div class="pptview-mblock-br">
					<div class="pptview-mblock-bb"></div>
				</div>
			</div>
	</div>
