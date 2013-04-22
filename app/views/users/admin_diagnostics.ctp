<div class="js-response">
<div class="info-details"><?php echo __l('Diagnostics are for developer purpose only.'); ?></div>
	<ul class="setting-links   clearfix">		
			<li class="grid_12 omega alpha">
    			<div class="setting-details-info setting-details-info1 payment-transaction-log">
                    <h3><?php echo $this->Html->link(__l('Adaptive Payment Transaction Log'), array('controller' => 'adaptive_transaction_logs', 'action' => 'index'), array('title' => __l('Adaptive Payment Transaction Log'))); ?></h3>
                    <div><?php echo __l('View the transaction details done via PayPal Adaptive Payment'); ?></div>
                </div>
            </li>
			<li class="grid_12 omega alpha">
    			<div class="setting-details-info setting-details-info1 mass-payment">
                    <h3><?php echo $this->Html->link(__l('Mass Payment Transaction Log'), array('controller' => 'paypal_transaction_logs', 'action' => 'index'),array('title' => __l('Mass Payment Transaction Log'))); ?></h3>
                    <div><?php echo __l('View the transaction details done via Mass PayPal'); ?></div>
                </div>
            </li>
			<li class="grid_12 omega alpha">
    			<div class="setting-details-info setting-details-info1 authorizenet-docapture">
                    <h3><?php echo $this->Html->link(__l('Authorizenet Docapture Log'), array('controller' => 'authorizenet_docapture_logs', 'action' => 'index'),array('title' => __l('Authorizenet Docapture Log'))); ?></h3>
                    <div><?php echo __l('View the transaction logs done via Authorizenet'); ?></div>
                </div>
            </li>
			<li class="grid_12 omega alpha">
    			<div class="setting-details-info setting-details-info1 debug-error">
                    <h3><?php echo $this->Html->link(__l('Debug & Error Log'), array('controller' => 'devs', 'action' => 'logs'),array('title' => __l('Debug & Error Log'))); ?></h3>
                    <div><?php echo __l('View debug, error log, used cache memory and used log memory'); ?></div>
                </div>
            </li>
			<li class="grid_12 omega alpha">
    			<div class="setting-details-info setting-details-info1 search-log">
                    <h3><?php echo $this->Html->link(__l('Search Log'), array('controller' => 'search_logs', 'action' => 'index'),array('title' => __l('Search Log'))); ?></h3>
                    <div><?php echo __l('View the search log searched in property and request page'); ?></div>
                </div>
            </li>
    </ul>
</div>