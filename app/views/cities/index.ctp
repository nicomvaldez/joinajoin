<?php /* SVN: $Id: index.ctp 7130 2012-01-09 10:09:35Z ramkumar_136act10 $ */ ?>
<div class="cities-index-block">
<div class="cities-info-block clearfix">
<h2 class="properties-title grid_left"><span><?php echo __l('Properties'); ?></span></h2>
	<?php
		$count =0;
		$url = Router::url('/',true).'properties';
		$count =0;
		if (!empty($cities)):
			foreach ($cities as $city):
				if (!empty($city['City']['slug'])):
					$url = Router::url('/',true) . $city['City']['slug'] . '/properties';
					$count += $city['City']['property_count'];
				endif;
			endforeach;
		endif;
	?>
		<?php $url = Router::url('/',true).'properties'; ?>
		<?php $class = (empty($this->request->params['named']['is_request']) && !empty($this->request->params['named']['city']) && $this->request->params['named']['city'] == 'all') ? 'active' : ''; ?>
		<?php if(!Configure::read('property.is_enable_property_count')):?>
		<div class="cities-bottom gird_left clearfix">
	       <p class="all-cities"><?php echo $this->Html->link(__l('All') . ' (' . $this->Html->cInt($all_property_count, false) . ')', $url , array('title' => __l('All'), 'class' => $class));?><span class="count-block"></span></p>
	</div>
	<?php endif; ?>
		<ol class="cities-list grid_left clearfix">
		<?php
			$count = 0;
			if (!empty($cities)):
				foreach ($cities as $city):
					if (!empty($city['City']['property_count'])):
						$url = Router::url('/',true) . $city['City']['slug'] . '/properties';
		?>
						<li class="clearfix">
							<?php
								$class = '';
								if (empty($this->request->params['named']['is_request']) && !empty($this->request->params['named']['city']) && $this->request->params['named']['city'] == $city['City']['slug']):
									$class = 'active';
								endif;
								if ($city['City']['property_count']):
									$display_count =  '(' . $this->Html->cInt($city['City']['property_count'], false) . ')';
									$count += $city['City']['property_count'];
								else:
									$display_count = '(0)';
								endif;
								echo $this->Html->link('<span class="flags flag-'. strtolower($city['Country']['iso2']) .'" title ="'. $city['Country']['name'] .'">'. $city['Country']['name'] .'</span>' . ' <span>' . $city['City']['name'] . '</span> ' . $display_count , $url, array('title' => $city['City']['name'], 'escape' => false, 'class' => $class));
							?>
						</li>
		<?php
					endif;
				endforeach;
			endif;
		?>
	</ol>
	</div>
	<?php $url = Router::url('/',true).'requests'; ?>
<div class="cities-info-block clearfix">
<h2 class="properties-title grid_left"><span><?php echo __l('Requests'); ?></span></h2>
	<?php
		$count = 0;
		if (!empty($cities)):
			foreach ($cities as $city):
				if (!empty($city['City']['slug'])):
					$count += $city['City']['request_count'];
				endif;
			endforeach;
		endif;
	?>
	<?php $class = (!empty($this->request->params['named']['is_request']) && !empty($this->request->params['named']['city']) && $this->request->params['named']['city'] == 'all') ? 'active' : ''; ?>
	<?php if(!Configure::read('property.is_enable_property_count')):?>
	<div class="cities-bottom gird_left clearfix">
	<p class="all-cities"><?php echo $this->Html->link(__l('All') . ' (' . $this->Html->cInt($all_request_count, false) . ')', $url , array('title' => __l('All'), 'class' => $class));?><span class="count-block"></span></p>
	</div> 
	<?php endif; ?>
	<ol class="cities-list grid_left clearfix">
		<?php
			$count =0;		
			if (!empty($cities)):
				foreach ($cities as $city):
					if (!empty($city['City']['request_count'])):
						$url = Router::url('/',true) . $city['City']['slug'] . '/requests';
		?>
					<li class="clearfix">
						<?php
							$class = '';
							if (!empty($this->request->params['named']['is_request']) && !empty($this->request->params['named']['city']) && $this->request->params['named']['city'] == $city['City']['slug']):
								$class = 'active';
							endif;
							if($city['City']['request_count']):
								$display_count = '(' . $this->Html->cInt($city['City']['request_count'], false) . ')';
								$count += $city['City']['request_count'];
							else:
								$display_count = '(0)';
							endif;
							echo $this->Html->link('<span class="flags flag-'. strtolower($city['Country']['iso2']) .'" title ="'. $city['Country']['name'] .'">'. $city['Country']['name'] .'</span>' . ' <span>' . $city['City']['name'] . '</span> ' . $display_count, $url, array('class' => $class . ' clearfix', 'title' => $city['City']['name'], 'escape' => false));
						?>
					</li>
		<?php
					endif;
				endforeach;
			endif;
		?>
	</ol>
	<?php $class = (!empty($this->request->params['named']['city']) && $this->request->params['named']['city'] == 'all') ? ' class="active"' : null; ?>
	</div>
</div>