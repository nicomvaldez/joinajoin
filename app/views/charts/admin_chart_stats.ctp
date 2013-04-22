<?php echo $this->element('chart-admin_chart_overview'); ?>
<?php echo $this->element('chart-admin_chart_users', array('user_type_id'=> ConstUserTypes::User)); ?>
<?php echo $this->element('chart-admin_chart_user_logins', array('user_type_id'=> ConstUserTypes::User)); ?>
<?php echo $this->element('chart-admin_chart_properties');?>
<?php echo $this->element('chart-admin_chart_requests');?>