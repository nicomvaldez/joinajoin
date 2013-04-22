<?php /* SVN: $Id: $ */ ?>
<div class="propertyFeedbacks">
<ol class="photos-list clearfix">

<?php
$i=0;
if (!empty($propertyFeedbacks)): ?>
<?php foreach ($propertyFeedbacks as $propertyFeedback): ?>

 <?php if (!empty($propertyFeedback['PropertyFeedback']['video_url'])): $i++?>
 <li>
<div id="video-1" class="ui-corner-right">
		<?php if($this->Embed->parseUrl($propertyFeedback['PropertyFeedback']['video_url'])){
				$this->Embed->setHeight('150px');
				$this->Embed->setWidth('150px');
				echo $this->Embed->getEmbedCode();
			}
		?>		
	</div>
</li>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if($i==0): ?>
<li class="notice-info">
<p class="notice"><?php echo __l('No guest videos available'); ?></p>
</li>
<?php endif; ?>
</ol>

</div>
