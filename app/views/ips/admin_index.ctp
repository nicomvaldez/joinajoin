<?php /* SVN: $Id: $ */ ?>
<div class="ips index">
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th class="actions"><?php echo __l('Actions');?></th>
        <th><?php echo $this->Paginator->sort('created');?></th>
        <th><?php echo $this->Paginator->sort(__l('IP'), 'ip');?></th>
        <th class="dl"><?php echo $this->Paginator->sort('city_id');?></th>
        <th class="dl"><?php echo $this->Paginator->sort('state_id');?></th>
        <th class="dl"><?php echo $this->Paginator->sort('country_id');?></th>
        <th><?php echo $this->Paginator->sort('latitude');?></th>
        <th><?php echo $this->Paginator->sort('longitude');?></th>
    </tr>
<?php
if (!empty($ips)):

$i = 0;
foreach ($ips as $ip):
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
                                      <?php echo __l('Actions'); ?>                                   </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
		<li><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $ip['Ip']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
		</ul></div><div class="action-bottom-block"></div>
		</div></div>
		</td>
		<td><?php echo $this->Html->cDateTime($ip['Ip']['created']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['ip']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['City']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['State']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($ip['Country']['name']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['latitude']);?></td>
		<td><?php echo $this->Html->cText($ip['Ip']['longitude']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice"><?php echo __l('No IPs available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($ips)) {
    echo $this->element('paging_links');
}
?>
</div>
