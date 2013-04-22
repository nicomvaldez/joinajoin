
<div class="clearfix public-stats">
<div class="block2-tl">
<div class="block2-tr">
<div class="block2-tm">
	  <h4><?php echo __l('As Host'); ?></h4>
	</div>
</div>
</div>
<div class="block2-cl">
<div class="block2-cr">
<div class="block2-cm clearfix">
<dl class="clearfix posted-list posted-list1">
	<dt><?php echo __l('Properties posted'); ?></dt>
			<dd><span class="stats-val"><?php echo $this->Html->cInt($user['User']['property_count']);?></span></dd>
		</dl>
	  
		   <dl class="ratings-feedback1 clearfix">
<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
<?php echo __l('Positive');?></dt>
<dd class="positive-feedback1">
<?php  echo $this->Html->cInt($user['User']['positive_feedback_count']); ?> 
</dd>
</dl>
<dl class="ratings-feedback1 clearfix">
<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
<dd  class="negative-feedback1">
  <?php  echo $this->Html->cInt($user['User']['property_feedback_count'] - $user['User']['positive_feedback_count']); ?>
</dd>
</dl>
<?php if(($user['User']['property_feedback_count']) == 0): ?>
		<dl class="clearfix request-list1 success-rate-list">
					<dt><?php echo __l('Success Rate'); ?></dt>
					<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php echo __l('n/a'); ?></dd>
			</dl>
		  <?php else: ?>
<dl class="ratings-feedback1 no-booking clearfix success-rate-list">
   <dt class="no-booking"><?php echo __l('Success Rate'); ?></dt>
	<dd class="success-rate"><span class="stats-val">
<?php									if(!empty($user['User']['positive_feedback_count'])):
										$positive = floor(($user['User']['positive_feedback_count']/$user['User']['property_feedback_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?></span>
</dd>
</dl>
		   <?php endif; ?>

  </div>
</div>
 </div>
<div class="block2-bl">
<div class="block2-br">
<div class="block2-bm"> </div>
</div>
</div>
</div>
<div class="clearfix public-stats">
<div class="block2-tl">
  <div class="block2-tr">
	<div class="block2-tm">
	  <h4><?php echo __l('As Traveler'); ?></h4>
		</div>
	  </div>
</div>
<div class="block2-cl">
<div class="block2-cr">
 <div class="block2-cm clearfix">
  <div class="clearfix">
	<dl class="clearfix posted-list posted-list1">
		<dt><?php echo __l('Requests Posted'); ?></dt>
		<dd><span class="stats-val"><?php echo $this->Html->cInt($user['User']['request_count']);?></span></dd>
	</dl>

		   <dl class="ratings-feedback1 clearfix">
<dt class="positive-feedback1" title ="<?php echo __l('Positive');?>">
<?php echo __l('Positive');?></dt>
<dd class="positive-feedback1">
<?php  echo $this->Html->cInt($user['User']['traveler_positive_feedback_count']); ?>
</dd>
</dl>
<dl class="ratings-feedback1 clearfix">
<dt class="negative-feedback1" title ="<?php echo __l('Negative');?>"><?php echo __l('Negative');?></dt>
<dd  class="negative-feedback1">
  <?php  echo $this->Html->cInt($user['User']['traveler_property_user_count'] - $user['User']['traveler_positive_feedback_count']); ?>
</dd>
</dl>
<?php if(($user['User']['traveler_property_user_count']) == 0): ?>
		<dl class="clearfix request-list1 success-rate-list">
					<dt><?php echo __l('Success Rate'); ?></dt>
					<dd class="not-available" title="<?php  echo __l('No bookings available'); ?>"><?php echo __l('n/a'); ?></dd>
			</dl>
		  <?php else: ?>
<dl class="ratings-feedback1 no-booking clearfix success-rate-list">
   <dt class="no-booking"><?php echo __l('Success Rate'); ?></dt>
	<dd class="success-rate"><span class="stats-val">
<?php if(!empty($user['User']['traveler_positive_feedback_count'])):
										$positive = floor(($user['User']['traveler_positive_feedback_count']/$user['User']['traveler_property_user_count']) *100);
										$negative = 100 - $positive;
										else:
										$positive = 0;
										$negative = 100;
										endif;
										
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&chd=t:'.$positive.','.$negative.'&chs=50x50&chco=00FF00|FF0000&chf=bg,s,FFFFFF00', array('width'=>'50px','height'=>'50px','title' => $positive.'%')); ?>
</dd>
</dl>
		   <?php endif; ?>
    </div>
     <span class="info side-info1"><?php echo __l('Rated by host');?></span>
    
	</div>
 </div>
 </div>
<div class="block2-bl">
  <div class="block2-br">
	<div class="block2-bm"> </div>
  </div>
</div>
</div>