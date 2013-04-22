<?php /* SVN: $Id: admin_index.ctp 11071 2011-03-09 14:02:56Z usha_111at09 $ */ ?>
<div class="userPaypalConnections index">


    <div class="select-block clearfix">
		<?php $class = (isset($this->request->params['named']['is_active']) && $this->request->params['named']['is_active'] == 1) ? ' active-filter' : null; ?>
        <span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(sprintf('%s %s', __l('Active:'), $active_count), array('controller' => 'user_paypal_connections', 'action' => 'index', 'is_active' => 1)); ?></span>
		<?php $class = (isset($this->request->params['named']['is_active']) && $this->request->params['named']['is_active'] == 0) ? ' active-filter' : null; ?>
        <span class="waitingforyourreview <?php echo $class; ?>"><?php echo $this->Html->link(sprintf('%s %s', __l('Inactive:'), $inactive_count), array('controller' => 'user_paypal_connections', 'action' => 'index', 'is_active' => 0)); ?></span>
		<?php $class = (!isset($this->request->params['named']['is_active'])) ? ' active-filter' : null; ?>
        <span class="all <?php echo $class; ?>"><?php echo $this->Html->link(sprintf('%s %s', __l('All:'),$active_count+$inactive_count), array('controller' => 'user_paypal_connections', 'action' => 'index')); ?></span>
  </div>
 
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>

<div class="grid_left">
<?php echo $this->Form->create('UserPaypalConnection', array('type' => 'get', 'class' => 'normal search-form clearfix', 'action'=>'index')); ?>		
            <?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $this->Form->submit(__l('Search'));?>	
<?php echo $this->Form->end(); ?>
</div>
</div>
<div class="page-information"><?php echo __l('If you want to delete any of the connections, you can click the "Inactive" link.').'<br />'.
__l('It will deactivate the connection. It will not displayed in User side, where as it will displayed here for your reference.');?></div>
<div class="overflow-block">
<table class="list">
    <tr>
        <th rowspan="2" class="actions"><?php echo __l('Actions');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Created On'), 'created');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Sender Email'), 'sender_email');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Pre Approval Key'), 'pre_approval_key');?></th>
        <th colspan="2"><?php echo __l('Validity'); ?></th>
        <th colspan="2"><?php echo __l('Amount'); ?></th>
		<th rowspan="2"><?php echo $this->Paginator->sort(__l('Purchases'), 'charged_count');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Active?'), 'is_active');?></th>
        <th rowspan="2"><?php echo $this->Paginator->sort(__l('Default?'), 'is_default');?></th>
    </tr>
    <tr>
        <th><?php echo $this->Paginator->sort(__l('From'), 'valid_from');?></th>
        <th><?php echo $this->Paginator->sort(__l('To'), 'valid_to');?></th>
        <th><?php echo $this->Paginator->sort(__l('Total'), 'amount');?></th>
        <th><?php echo $this->Paginator->sort(__l('Charged'), 'charged_amount');?></th>        
    </tr>
<?php
if (!empty($userPaypalConnections)):

$i = 0;
foreach ($userPaypalConnections as $userPaypalConnection):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        Action                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
            <?php if($userPaypalConnection['UserPaypalConnection']['is_active']) : ?>
                <li><?php echo $this->Html->link(__l('Inactive'), array('action' => 'delete', $userPaypalConnection['UserPaypalConnection']['id']), array('class' => 'delete js-delete', 'title' => __l('Click inactive to delete PayPal connection')));?></li>
            <?php endif; ?>
       </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 
							 </div>

        </td>
		<td><?php echo $this->Html->cDateTimeHighlight($userPaypalConnection['UserPaypalConnection']['created']);?></td>
		<td><?php echo $this->Html->link($this->Html->cText($userPaypalConnection['User']['username']), array('controller'=> 'users', 'action'=>'view', $userPaypalConnection['User']['username'], 'admin' => false), array('escape' => false));?></td>
		<td><?php echo $this->Html->cText($userPaypalConnection['UserPaypalConnection']['sender_email']);?></td>
		<td><?php echo $this->Html->cText($userPaypalConnection['UserPaypalConnection']['pre_approval_key']);?></td>
		<td><?php echo $this->Html->cDate($userPaypalConnection['UserPaypalConnection']['valid_from']);?></td>
		<td><?php echo $this->Html->cDate($userPaypalConnection['UserPaypalConnection']['valid_to']);?></td>
		<td><?php echo $this->Html->siteCurrencyFormat($userPaypalConnection['UserPaypalConnection']['amount']);?></td>
		<td><?php echo $this->Html->siteCurrencyFormat($userPaypalConnection['UserPaypalConnection']['charged_amount']);?></td>
		<td><?php echo $this->Html->link($this->Html->cInt($userPaypalConnection['UserPaypalConnection']['charged_count']), array('controller'=> 'property_users', 'action'=>'index', 'user_paypal_connection_id' => $userPaypalConnection['UserPaypalConnection']['id'] , 'admin' => true), array('escape' => false));?></td>
		<td><?php echo $this->Html->cBool($userPaypalConnection['UserPaypalConnection']['is_active']);?></td>
		<td><?php echo $this->Html->cBool($userPaypalConnection['UserPaypalConnection']['is_default']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="14" class="notice"><?php echo __l('PayPal Connections available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($userPaypalConnections)) {
    echo $this->element('paging_links');
}
?>
</div>
