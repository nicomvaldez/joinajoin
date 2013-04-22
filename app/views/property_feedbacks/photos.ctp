<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks">
<ol class="photos-list clearfix">
<?php
$i=0;
if (!empty($propertyFeedbacks)): ?>
<?php foreach ($propertyFeedbacks as $propertyFeedback): ?>
 <?php foreach ($propertyFeedback['Attachment'] as $Feedback): $i++; ?>
<li>
  <?php

    	  echo $this->Html->showImage('PropertyFeedback', $Feedback, array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText(($Feedback['description'])?$Feedback['description']:$propertyFeedback['Property']['title'], false)), 'title' => $this->Html->cText(($Feedback['description'])?$Feedback['description']:$propertyFeedback['Property']['title'], false)));
    	 ?>
</li>
<?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if($i==0): ?>
<li class="notice-info">
    <p class="notice"><?php echo __l('No guest photos available'); ?></p>
</li>
<?php endif; ?>
</ol>

</div>
