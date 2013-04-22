<?php /* SVN: $Id: $ */ ?>
<div class="adaptiveIpnLogs index">
<h2><?php echo __l('Adaptive Ipn Logs');?></h2>
<?php echo $this->element('paging_counter');?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo $this->Paginator->sort(__l('Added On'), 'created');?></th>
        <th><?php echo $this->Paginator->sort(__l('IP'), 'ip');?></th>
        <th><?php echo $this->Paginator->sort(__l('Post Variable'), 'post_variable');?></th>
    </tr>
<?php
if (!empty($adaptiveIpnLogs)):

$i = 0;
foreach ($adaptiveIpnLogs as $adaptiveIpnLog):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>		
		<td><?php echo $this->Html->cDateTimeHighlight($adaptiveIpnLog['AdaptiveIpnLog']['created']);?></td>
		<td><?php echo $this->Html->cText($adaptiveIpnLog['AdaptiveIpnLog']['ip']);?></td>
		<td><?php echo $this->Html->cText($adaptiveIpnLog['AdaptiveIpnLog']['post_variable']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6" class="notice"><?php echo __l('No Adaptive Ipn Logs available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($adaptiveIpnLogs)) {
    echo $this->element('paging_links');
}
?>
</div>
