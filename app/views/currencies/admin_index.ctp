<?php /* SVN: $Id: $ */ ?>
<div class="currencies index">
<div class="clearfix page-count-block">
    <div class="grid_left">
        <?php echo $this->element('paging_counter');?>
    </div>
     <div class="clearfix grid_right add-block1">
    	<?php echo $this->Html->link(__l('Add'),array('controller'=>'currencies','action'=>'add'),array('title' => __l('Add New Currency'), 'class' => 'add'));?>
    	<?php echo $this->Html->link(__l('History'),array('controller'=>'currency_conversion_histories','action'=>'index'),array('class'=>'history','title' => __l('History')));?>
    	<?php echo $this->Html->link(__l('Currency Conversion / Exchange Rates'),array('controller'=>'currencies','action'=>'currency_update'),array('title' => __l('Currency Conversion / Exchange Rates'), 'class' => 'update-status'));?>
    </div>
</div>
<div class="overflow-block">
<table class="list">
    <tr>     	
        <th class="actions"><?php echo __l('Action');?></th>
		<th class="dl"><?php echo $this->Paginator->sort(__l('Name'), 'name');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Code'), 'code');?></th>
        <th class="dc"><?php echo $this->Paginator->sort(__l('Symbol'), 'symbol');?></th>
		<th class="dc"><?php echo $this->Paginator->sort(__l('Added On'),'created');?></th>
		<th class="dc"><?php echo $this->Paginator->sort(__l('Decimals'), 'decimals');?></th>
		<th class="dc"><?php echo $this->Paginator->sort(__l('Dec Point'), 'dec_point');?></th>
		<th class="dc"><?php echo $this->Paginator->sort(__l('Thousands Sep'), 'thousands_sep');?></th>
      </tr>
<?php
if (!empty($currencies)):

$i = 0;
$_currencies = Cache::read('site_currencies');
$selected_currency = $_currencies[Configure::read('site.currency_id')];
foreach ($currencies as $currency):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0) {
		$class = 'altrow';
	}
	if(!$currency['Currency']['is_enabled']):
    $active_class = ' inactive-record';
	endif;
	
?>
 <tr class="<?php echo $class.$active_class;?>">
		<td class="actions">
		       <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;
                            </span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        <?php echo __l('Action');?>
                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                	<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $currency['Currency']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                        			<?php if ($selected_currency['Currency']['id'] != $currency['Currency']['id']): ?>
                        			<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $currency['Currency']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                        			<?php endif;?>
        						</ul>
        					   </div>
        						<div class="action-bottom-block"></div>
							  </div>
						 </div>
 	</td>
		<td class="dl">
			<?php echo $this->Html->cText($currency['Currency']['name']);?>
		</td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['code']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['symbol']);?></td>
		<td class="dc"><?php echo $this->Html->cDateTimeHighlight($currency['Currency']['created']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['decimals']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['dec_point']);?></td>
		<td class="dc"><?php echo $this->Html->cText($currency['Currency']['thousands_sep']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No Currencies available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php if (!empty($currencies)) {?>	
	<div>
		<?php echo $this->element('paging_links');?>
	</div>	
	<?php }?>
</div>
