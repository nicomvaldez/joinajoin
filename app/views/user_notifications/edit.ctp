<?php /* SVN: $Id: $ */ ?>
<h2><?php echo __l("Manage Email Settings");?></h2>
<div class="userNotifications form">
<div class="grid_17 side1 usernotification-block">
<?php echo $this->Form->create('UserNotification', array('action' => 'edit', 'class' => 'normal'));?>
	<fieldset>
	<?php
		if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
			echo $this->Form->input('id');
		endif;
	?>
	<table class="list">
		<tr>
			<th class="dl"><?php echo __l('Host');?></th>
			<th class="dl"><?php echo __l('Traveler');?></th>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_new_property_order_host_notification', array('label' => __l('Send notification when you receive a booking for your property')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_new_property_order_traveler_notification', array('label' => __l('Send notification when you make an booking')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_accept_property_order_host_notification', array('label' => __l('Send notification when you accept an booking')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_accept_property_order_traveler_notification', array('label' => __l('Send notification when your property booking was accepted')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_admin_cancel_property_order_host_notification', array('label' => __l('Send notification when your property booking by a traveler was canceled by admin')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_admin_cancel_traveler_notification', array('label' => __l('Send notification when the property booking made by you was canceled by admin')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_arrival_host_notification', array('label' => __l('Send notification when you make change the status of traveler to checkin'))); ?></td>
			<td class="dl"><?php echo $this->Form->input('is_arrival_traveler_notification', array('label' => __l('Send notification when you change the status to checkin on arrival to the host location')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_complete_property_order_host_notification', array('label' => __l('Send notification when your property booked was reviewed by the traveler')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_complete_property_order_traveler_notification', array('label' => __l('Send notification when you make an review for the book made'))); ?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_expire_property_order_host_notification', array('label' => __l('Send notification when your property booked was expired on non-acceptance by you')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_expire_property_order_traveler_notification', array('label' => __l('Send notification when the booking made by you was expired on non-acceptance by the host')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_cancel_property_order_host_notification', array('label' => __l('Send notification when your property booked was canceled by the traveler')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_cancel_property_order_traveler_notification', array('label' => __l('Send notification when you cancel the booked you have made')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_reject_property_order_host_notification', array('label' => __l('Send notification when you reject an booking')));?></td>
			<td class="dl"><?php echo $this->Form->input('is_reject_property_order_traveler_notification', array('label' => __l('Send notification when your booking was rejected by the host')));?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo $this->Form->input('is_cleared_notification', array('label' => __l('Send notification when your amount for the booking was cleared for withdrawal')));?></td>
			<td class="dl"><?php echo '-';?></td>
		</tr>
		<tr>
			<td class="dl"><?php echo '-';?></td>
			<td class="dl"><?php echo $this->Form->input('is_review_property_order_traveler_notification', array('label' => __l('Send notification when your booking was completed and waiting for your review')));?></td>
		</tr>
		<tr>
			<td colspan ="2" class="dl"><?php echo $this->Form->input('is_contact_notification', array('label' => __l('Send notification when you have contacted by other users')));?></td>
		</tr>
	</table>
</fieldset>
<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Update'));?>
</div>
<?php echo $this->Form->end();?>
</div>
<div class="grid_6 omega side2">
<?php
		echo $this->element('sidebar', array('config' => 'sec'));
	?>
</div>
</div>