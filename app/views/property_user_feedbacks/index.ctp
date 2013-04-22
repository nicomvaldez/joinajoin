<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="propertyUserFeedbacks index property-feedbacks-block">
 
<?//php echo $this->element('paging_counter');?>
<ol class="feedback-list list property-list clearfix" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($propertyUserFeedbacks)):
$i = 0;
 $num=1;
foreach ($propertyUserFeedbacks as $propertyUserFeedback):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = '';
	}else{
		$class = '';
	}
	$class.= ($propertyUserFeedback['PropertyUserFeedback']['is_satisfied']) ? ' positive-feedback' : ' negative-feedback';
?>
	<li class="clearfix">

	
    		<div class="grid_1">
        		<?php
					$current_user_details = array(
						'username' => $propertyUserFeedback['User']['username'],
						'user_type_id' => $propertyUserFeedback['User']['user_type_id'],
						'id' => $propertyUserFeedback['User']['id'],
						'fb_user_id' => $propertyUserFeedback['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $propertyUserFeedback['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'small_thumb');
				?>
            </div>
			<div class="grid_14 <?php echo $class;?>" >
        		<h3><?php echo $this->Html->link($this->Html->cText($propertyUserFeedback['User']['username']), array('controller'=> 'users', 'action' => 'view', $propertyUserFeedback['User']['username']), array('title' => $this->Html->cText($propertyUserFeedback['User']['username'],false), 'escape' => false));?></h3>

                <p class="feedback-information">
        				 <?php echo __l('Reviewed on');?>
        				 <?php echo $this->Time->timeAgoInWords($propertyUserFeedback['PropertyUserFeedback']['created']);?>
        		</p>

        		<p ><?php echo $this->Html->cText($propertyUserFeedback['PropertyUserFeedback']['feedback']);?></p>
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
		if (!empty($propertyUserFeedbacks)) {
			if(count($propertyUserFeedbacks) > 10) {
			echo $this->element('paging_links');
			}
		}
		?>
	</div>
</div>