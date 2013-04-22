	<div class="js-flickr-link  {'url':'<?php echo Configure::read('flickr.url').'='.Configure::read('flickr.api_key').'&lat='.$lat.'&lon='.$lng;?>&radius=30&safe_search=1&per_page=20'}" id="flicker">
		 <div id="flicker-images" class="clearfix flicker-images">
			<?php echo __l('Loading...'); ?>
		</div>
   </div>