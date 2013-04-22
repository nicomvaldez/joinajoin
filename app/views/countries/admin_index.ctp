<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="countries index js-response">
<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>
<div class="grid_left">

    <?php echo $this->Form->create('Country', array('type' => 'get', 'class' => 'normal search-form','action'=>'index'));?>
 <?php echo $this->Form->input('q', array('label' => 'Keyword')); ?>
  <?php echo $this->Form->submit(__l('Filter')); ?>
   <?php echo $this->Form->end(); ?>
</div>
<div class="add-block clearfix grid_right">
          <?php echo $this->Html->link(__l('Add'),array('controller'=>'countries','action'=>'add'),array('title' => __l('Add New Country'), 'class' => 'add'));?>
  </div>
</div>
    <div>
          <div>
            <?php echo $this->Form->create('Country' , array('action' => 'update','class'=>'normal'));?>
            <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
          <div class="overflow-block">
            <table class="list">
                <tr>
                    <th rowspan="2"><?php echo __l('Select'); ?></th>
                    <th rowspan="2"><?php echo __l('Actions');?></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Name'), 'name');?></div></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Fips104'), 'fips104');?></div></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('ISO2'), 'iso2');?></div></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('ISO3'), 'iso3');?></div></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('ISON'), 'ison');?></div></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Internet'), 'internet');?></div></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Capital'), 'capital');?></div></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Map Reference'), 'map_reference');?></div></th>
                    <th colspan="2"><?php echo __l('Nationality');?></th>
                    <th colspan="2"><?php echo __l('Currency');?></th>
                    <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Population'), 'population');?></div></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Title'), 'title');?></div></th>
                    <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Comment'), 'comment');?></div></th>
                </tr>
                <tr>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Singular'), 'nationality_singular');?></div></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Plural'), 'nationality_plural');?></div></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Name'), 'currency');?></div></th>
                    <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Code'), 'currency_code');?></div></th>

                </tr>
                <?php
                if (!empty($countries)):
                    $i = 0;
                    foreach ($countries as $country):
                        $class = null;
                         $active_class = '';
                        if ($i++ % 2 == 0) :
                             $class = 'altrow';
                        endif;
                        ?>
                        <tr class="<?php echo $class;?>">
                            <td><?php
                                echo $this->Form->input('Country.'.$country['Country']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$country['Country']['id'],'label' => false , 'class' => 'js-checkbox-list'));
                                ?>
                            </td>
                  <td class="actions">
             	<div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;&nbsp;</span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        Action   </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                <li><?php
                                    echo $this->Html->link(__l('Edit'), array('action'=>'edit', $country['Country']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                                    <li><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $country['Country']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));
                                ?></li>
                                			 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 </div>
                             </td>
                            <td class="dl"><?php echo $this->Html->cText($country['Country']['name']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['fips104']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['iso2']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['iso3']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['ison']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['internet']);?></td>
                            <td class="dl"><?php echo $this->Html->cText($country['Country']['capital']);?></td>
                            <td class="dl"><?php echo $this->Html->cText($country['Country']['map_reference']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['nationality_singular']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['nationality_plural']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['currency']);?></td>
                            <td><?php echo $this->Html->cText($country['Country']['currency_code']);?></td>
                            <td><?php echo $this->Html->cInt($country['Country']['population']);?></td>
                            <td class="dl"><?php echo $this->Html->cText($country['Country']['title']);?></td>
                            <td class="dl"><?php echo $this->Html->cText($country['Country']['comment']);?></td>
                        </tr>
                        <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td class="notice" colspan="19"><?php echo __l('No countries available');?></td>
                    </tr>
                    <?php
                endif;
                ?>
            </table>
            </div>
            <?php if (!empty($countries)): ?>
            <div class="admin-select-block clearfix">
                <div>
                    <?php echo __l('Select:'); ?>
                    <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
                    <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
                </div>
              
                <div class="admin-checkbox-button">
                    <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
                </div>
                </div>
                  <div class="js-pagination">
                    <?php echo $this->element('paging_links');  ?>
                </div>
                <div class="hide">
                    <?php echo $this->Form->submit(__l('Submit'));  ?>
                </div>
                <?php
					endif;
					echo $this->Form->end();
				?>
        </div>
    </div>
</div>