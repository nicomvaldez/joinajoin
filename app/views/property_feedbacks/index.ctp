<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyFeedbacks index property-feedbacks-block">
 
<ol class="feedback-list list property-list clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php

if (!empty($propertyFeedbacks)):
$i = 0;
$num = 1;
foreach ($propertyFeedbacks as $propertyFeedback):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = '';
	}else{
		$class = '';
	}
	$class.= ($propertyFeedback['PropertyFeedback']['is_satisfied']) ? ' positive-feedback' : ' negative-feedback';
?>
	<li class="clearfix">
	 <?php if(isset($this->request->params['named']['user_id'])): ?>
		<div class="grid_3 thumb">
    	 <div class="map_number map_number1" ><?php echo $num; ?></div>
    	  <?php

    	  echo $this->Html->link($this->Html->showImage('Property', $propertyFeedback['Property']['Attachment'][0], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($propertyFeedback['Property']['title'], false)), 'title' => $this->Html->cText($propertyFeedback['Property']['title'], false))), array('controller' => 'properties', 'action' => 'view', $propertyFeedback['Property']['slug'],  'admin' => false), array('title'=>$this->Html->cText($propertyFeedback['Property']['title'],false),'escape' => false));
    	 ?>
	 </div>
	 <?php endif; ?>
		<div class="grid_12">
    		<div class="grid_1">
        		<?php
					$current_user_details = array(
						'username' => $propertyFeedback['PropertyUser']['User']['username'],
						'user_type_id' => $propertyFeedback['PropertyUser']['User']['user_type_id'],
						'id' => $propertyFeedback['PropertyUser']['User']['id'],
						'fb_user_id' => $propertyFeedback['PropertyUser']['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $propertyFeedback['PropertyUser']['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
				?>
            </div>
			<?php if(isset($this->request->params['named']['user_id'])): ?>
        	<div class="grid_10" >
			<?php else: ?>
			<div class="grid_10 <?php echo $class;?>" >
			<?php endif;?>
			 <?php if(isset($this->request->params['named']['user_id'])): ?>
				<h3>
				<?php 
				echo $this->Html->link($this->Html->cText($propertyFeedback['Property']['title'], false), array('controller' => 'properties', 'action' => 'view', $propertyFeedback['Property']['slug'], 'admin' => false), array('title'=>$this->Html->cText($propertyFeedback['Property']['title'], false),'escape' => false)); ?>
				</h3>
			<?php else: ?>
        		<h3><?php echo $this->Html->link($this->Html->cText($propertyFeedbacks[$num-1]['PropertyUser']['User']['UserProfile']['first_name'] . ' ' . $propertyFeedbacks[$num-1]['PropertyUser']['User']['UserProfile']['last_name']), array('controller'=> 'users', 'action' => 'view', $propertyFeedback['PropertyUser']['User']['username']), array('title' => $this->Html->cText($propertyFeedback['PropertyUser']['User']['username'],false), 'escape' => false));?></h3>
		<?php endif; ?>
			<?php if(isset($this->request->params['named']['user_id'])): ?>
				<div class="feedback-section <?php echo $class;?>">
			<?php endif; ?>
                <dl class="clearfix list feedback-list">
        				 <dt><?php echo __l('Reviewed on');?></dt>
        				 <dd title="<?php echo strftime(Configure::read('site.datetime.tooltip'), strtotime($propertyFeedback['PropertyFeedback']['created'])); ?>"><?php echo $this->Time->timeAgoInWords($propertyFeedback['PropertyFeedback']['created']);?></dd>
        		</dl>
			<?php if(isset($this->request->params['named']['user_id'])): ?>
				</div>
			<?php endif; ?>
        		<p class="feedback-info1"><?php echo $this->Html->cText($propertyFeedback['PropertyFeedback']['feedback']);?></p>
    		</div>
		</div>
	</li>
<?php
$num=$num+1;
    endforeach;
	else:
?>
	<li class="notice-info">
		<p class="notice"><?php echo __l('No Reviews available');?></p>
	</li>
<?php
endif;
?>
</ol>
	<div class="js-pagination">
		<?php
		if (!empty($propertyFeedbacks)) {
			if(count($propertyFeedbacks) > 10) {
			echo $this->element('paging_links');
			}
		}
		?>
	</div>
</div>