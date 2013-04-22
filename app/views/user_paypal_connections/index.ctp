<?php /* SVN: $Id: index.ctp 11066 2011-03-09 12:54:49Z usha_111at09 $ */ ?>
<h2><?php echo __l('PayPal Connections');?></h2>
<div class="form">
    <div class="grid_17 side1">
        <div class="userPaypalConnections js-response index">
            <div class="clearfix counter-block">
            <div class="add-block grid_right">
            	<?php echo $this->Html->link(__l('Add New Connection'), array('controller' => 'payments', 'action' => 'connect'), array('class' => 'add','title'=>__l('Add New Connection'))); ?>
            </div>
            <div class="grid_left paging-counter"><?php echo $this->element('paging_counter');?></div>
            </div>
            <div class="page-information">
            <?php echo sprintf('%s %s %s',__l('You can connect your PayPal account with').' ',Configure::read('site.name').'. ', __l('To connect your account, you will be taken to paypal.com and once connected, you can make orders without leaving to paypal.com again.').'<br />'.
            __l('Note: We do not save your PayPal password and the connection is enabled through PayPal standard alone. Anytime, you can disable the connection.')); ?>
            </div>
            <table class="list">
                <tr>
                    <th class="actions"><?php echo __l('Actions');?></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Created On'), 'created');?></div></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Paypal Email'),'sender_email');?></div></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Default?'), 'is_default');?></div></th>
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
                    	<?php if (empty($userPaypalConnection['UserPaypalConnection']['is_default'])): ?>
            			     <span><?php echo $this->Html->link(__l('Set as default'), array('action' => 'update', $userPaypalConnection['UserPaypalConnection']['id']), array('class' => 'update', 'title' => __l('Set as default')));?></span>
            			<?php endif; ?>
                        <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userPaypalConnection['UserPaypalConnection']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
                    </td>
            		<td><?php echo $this->Html->cDateTimeHighlight($userPaypalConnection['UserPaypalConnection']['created']);?></td>
            		<td><?php echo $this->Html->cText($userPaypalConnection['UserPaypalConnection']['sender_email']);?></td>
            		<td><?php echo $this->Html->cBool($userPaypalConnection['UserPaypalConnection']['is_default']);?></td>
            	</tr>
            <?php
                endforeach;
            else:
            ?>
            	<tr>
            		<td colspan="14" class="notice">
            			<?php echo __l('No PayPal Connections available');?>
            		</td>
            	</tr>
            <?php
            endif;
            ?>
            </table>
            <th><div class="js-pagination">
                <?php
                if (!empty($userPaypalConnections)) {
                    echo $this->element('paging_links');
                }
                ?>
            </div>
        </div>
    </div>
    <div class="grid_6 omega side2 user-sidebar">
        <?php
    		echo $this->element('sidebar', array('config' => 'sec'));
    	?>
    </div>
</div>