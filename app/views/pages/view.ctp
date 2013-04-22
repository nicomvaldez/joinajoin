	<h2 class="disclaimer-head"><?php echo $page['Page']['title']; ?></h2>
<?php echo $page['Page']['content']; ?>
<?php if($this->request->params['pass'][0]=='order-purchase-completed'): ?>
	<div class="cancel-block clearfix">
		<?php echo $this->Html->link(__l('Continue'), array('controller' => 'property_users', 'action' => 'index', 'type' => 'mytours', 'status' => 'waiting_for_acceptance', 'view' => 'list', 'admin' => false), array('class' => 'cancel-order', 'title' => __l('Continue')));?>
	</div>
<?php endif; ?>