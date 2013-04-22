<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="cities index js-response">

<div class="record-info select-block clearfix">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
	<span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(__l('Approved').': '.$this->Html->cInt($active), array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('title' => __l('Approved'), 'escape' => false)); ?></span>
	
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
	<span class="notverified <?php echo $class; ?>"><?php echo $this->Html->link(__l('Disapproved').': '.$this->Html->cInt($inactive), array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('title' => __l('Disapproved'), 'escape' => false)) ?></span>
	
	<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active-filter' : null; ?>
	<span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('All').': '.$this->Html->cInt($active + $inactive), array('controller' => 'cities', 'action' => 'index'),array('title' => __l('All'), 'escape' => false)) ?></span>
</div>

<div class="page-count-block clearfix">
	<div class="grid_left">
	<?php echo $this->element('paging_counter'); ?>
	</div>
<div class="grid_left">
    <?php echo $this->Form->create('City', array('type' => 'get', 'class' => 'normal search-form', 'action'=>'index')); ?>
            <?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $this->Form->submit(__l('Search'));?>
 	<?php echo $this->Form->end(); ?>
</div>
<div class="add-block clearfix grid_right">
 	<?php echo $this->Html->link(__l('Add'), array('controller' => 'cities', 'action' => 'add'), array('class' => 'add','title'=>__l('Add'))); ?>       
  </div>
</div>


    <div>
              <div>
            <?php
            echo $this->Form->create('City', array('action' => 'update','class'=>'normal')); ?>
            <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
        <div class="overflow-block">
            <table class="list">
                <tr>
                    <th><?php echo __l('Select'); ?></th>
                    <th><?php echo __l('Actions');?></th>
                    <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Country'), 'Country.name', array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>
                    <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('State'), 'State.name', array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>
                    <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Name'), 'name');?></div></th>
                    <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Latitude'), 'latitude');?></div></th>
                    <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Longitude'), 'longitude');?></div></th>
                    <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Timezone'), 'timezone');?></div></th>
                    <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('County'), 'county');?></div></th>
                    <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Code'), 'code');?></div></th>
                </tr>
                <?php
                if (!empty($cities)):
                    $i = 0;
                    foreach ($cities as $city):
                        $class = null;
                        $active_class = '';
                        if ($i++ % 2 == 0) :
                             $class = 'altrow';
                        endif;
                        if($city['City']['is_approved'])  :
                            $status_class = 'js-checkbox-active';
                        else:
                            $active_class = ' inactive-record';
                            $status_class = 'js-checkbox-inactive';
                        endif;
                    ?>
                         <tr class="<?php echo $class.$active_class;?>">
                            <td>
                                <?php
                                echo $this->Form->input('City.'.$city['City']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$city['City']['id'],'label' => false , 'class' => $status_class.' js-checkbox-list'));
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
                                                <?php
                                    if($city['City']['is_approved']): ?>
                                      <li>  <?php echo $this->Html->link(__l('Approved'),array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'disapprove'),array('class' =>'approve','title' => __l('Approved')));
                                    else: ?></li>
                                   <li> <?php echo $this->Html->link(__l('Disapproved'),array('controller'=>'cities','action'=>'update_status',$city['City']['id'],'approve') ,array('class' =>'pending','title' => __l('Disapproved')));
                                      endif; ?></li>
                                  <li>  <?php  echo $this->Html->link(__l('Edit'), array('action'=>'edit', $city['City']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));
                                      ?></li>

                                     <li> <?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $city['City']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));
                                ?></li>
                                             			 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>
							 </div>
                            </td>
                            <td class="dl"><?php echo $this->Html->cText($city['Country']['name'], false);?></td>
                            <td class="dl"><?php echo $this->Html->cText($city['State']['name'], false);?></td>
                            <td class="dl"><?php echo $this->Html->cText($city['City']['name'], false);?></td>
                            <td class="dc"><?php echo $this->Html->cFloat($city['City']['latitude']);?></td>
                            <td class="dc"><?php echo $this->Html->cFloat($city['City']['longitude']);?></td>
                            <td class="dc"><?php echo $this->Html->cText($city['City']['timezone']);?></td>
                            <td class="dc"><?php echo $this->Html->cText($city['City']['county']);?></td>
                            <td class="dc"><?php echo $this->Html->cText($city['City']['code']);?></td>
                        </tr>
                    <?php
                    endforeach;
                    else:
                    ?>
                    <tr>
                        <td class="notice" colspan="10"><?php echo __l('No cities available');?></td>
                    </tr>
                    <?php
                    endif;
                    ?>
            </table>
            </div>
            <?php
                if (!empty($cities)) :
                    ?>
                    <div class="admin-select-block">
                    <div>
                        <?php echo __l('Select:'); ?>
                        <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
                        <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
                        <?php echo $this->Html->link(__l('Unapproved'), '#', array('class' => 'js-admin-select-pending','title' => __l('Unapproved'))); ?>
                        <?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-admin-select-approved','title' => __l('Approved'))); ?>
                    </div>
               
                    <div class="admin-checkbox-button">
                        <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
                    </div>
                    </div>
                         <div class="js-pagination">
                        <?php  echo $this->element('paging_links'); ?>
                    </div>
                    <div class="hide">
                        <?php echo $this->Form->submit(__l('Submit'));  ?>
                    </div>
                    <?php
                endif;
            ?>
        <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>