<?php /* SVN: $Id: admin_index.ctp 74194 2011-12-15 13:33:05Z meganathan_203ac11 $ */ ?>
	<?php
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="languages index">

    <div class="js-response js-response js-responses js-search-responses">
    	<div class="record-info select-block clearfix inbox-option">

			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id']== ConstMoreAction::Active) ? 'active-filter' : null; ?>
			<span class="arrivedconfirmed <?php echo $class; ?>"><?php echo $this->Html->link(__l('Active Records').': '.$this->Html->cInt($approved), array('controller' => 'languages', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('title' => __l('Approved Records'), 'escape' => false)); ?></span>

			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
			<span class="notverified <?php echo $class; ?>"><?php echo $this->Html->link(__l('Inactive Records').': '.$this->Html->cInt($pending), array('controller' => 'languages', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('title' => __l('Disapproved Records'), 'escape' => false)) ?></span>

			<?php $class = (empty($this->request->params['named']['filter_id'])) ? ' active-filter' : null; ?>
			<span class="all <?php echo $class; ?>"><?php echo $this->Html->link(__l('Total Records').': '.$this->Html->cInt(($pending + $approved)), array('controller' => 'languages', 'action' => 'index'),array('title' => __l('Total Records'), 'escape' => false)) ?></span>
         </div>
    <div class="page-count-block clearfix">
   	<div class="grid_left">
        <?php echo $this->element('paging_counter');?>
       </div>
     	<div class="grid_left">
        <?php       echo $this->Form->create('Language', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form {"container" : "js-search-responses"}', 'action'=>'index'));
                      echo $this->Form->input('q', array('label' => __l('Keyword')));
                      echo $this->Form->input('filter_id', array('type' => 'hidden', 'value' => !empty($this->request->params['named']['filter_id'])?$this->request->params['named']['filter_id']:''));
                      echo $this->Form->submit(__l('Search'));
                      echo $this->Form->end();
                ?>
        </div>
		<div class="clearfix grid_right add-block1">
    		<?php echo $this->Html->link(__l('Add'), array('controller' => 'languages', 'action' => 'add'), array('class' => 'add', 'title' => __l('Add'), 'escape' => false)); ?>
         </div>
      </div>
    <?php echo $this->Form->create('Language' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <?php if(!empty($this->request->params['named']['filter_id'])){?>
    <?php echo $this->Form->input('redirect_url', array('type' => 'hidden', 'value' => $this->request->params['named']['filter_id'])); ?>
    <?php } ?>


    <table class="list">
        <tr>
            <th class="select"></th>
            <th class="actions"><?php echo __l('Actions'); ?></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Name'), 'Language.name');?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('ISO2'), 'Language.iso2');?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('ISO3'), 'Language.iso3');?></div></th>
			</tr>
         <?php
            if (!empty($languages)):
                $i = 0;
				foreach ($languages as $language):
                    $class = null;
                     $active_class = '';
                    if ($i++ % 2 == 0) :
                        $class = 'altrow';
                    endif;
                    if($language['Language']['is_active'])  :
                        $status_class = 'js-checkbox-active';
                    else:
                    $active_class = ' inactive-record';
                        $status_class = 'js-checkbox-inactive';
                    endif;
                ?>


                <tr class="<?php echo $class.$active_class;?>">
                    <td class="select">
                    	 <?php echo $this->Form->input('Language.'.$language['Language']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$language['Language']['id'],'label' => false , 'class' => $status_class.' js-checkbox-list'));?>
                    </td>
                   <td  class="actions">
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
                                	 <li> <?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $language['Language']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                                	 <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $language['Language']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
        						</ul>
        					   </div>
        						<div class="action-bottom-block"></div>
							  </div>
						 </div>
                    </td>
                    <td class="dl"><?php echo $this->Html->cText($language['Language']['name']);?></td>
                    <td class="dc"><?php echo $this->Html->cText($language['Language']['iso2']);?></td>
                    <td class="dc"><?php echo $this->Html->cText($language['Language']['iso3']);?></td>
					          </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="5" class="notice"><?php echo __l('No Languages available');?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>

    <?php
    if (!empty($languages)) :
        ?>
        	<div class="clearfix">
          <div class="admin-select-block grid_left">
            <div class="select-options">
        		<?php echo __l('Select:'); ?>
    			<?php if(isset($this->request->params['named']['filter_id'])) {?>
        		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
        		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
    			<?php }
    				  else { ?>
        		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
        		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
        		<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Inactive'))); ?>
        		<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
                <?php } ?>
        	</div>
               <div class="admin-checkbox-button">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
        </div>
        	<div class="js-pagination grid_right">
            <?php echo $this->element('paging_links'); ?>
        </div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
     </div>
     </div>