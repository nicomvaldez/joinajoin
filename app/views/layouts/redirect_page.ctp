<?php if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'hashbang')) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<?php
		echo $this->Html->meta('icon'), "\n";
		echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
		echo $this->Html->css('redirect.cache', null, array('inline' => true));
		echo $this->Javascript->link('default.cache', true);
		echo $this->Javascript->link('common', true);   
		echo $this->Javascript->link('libs/guest-calendar', true); 
        echo $this->element('site_tracker');
	?>
</head>
<body id="authorize">
<?php } ?>
<?php
	$meta = '';
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'hashbang') {
		$meta_arr = array(
			'title' => Configure::read('site.name') . ' | ' . $this->Html->cText($title_for_layout, false),
			'keywords' => $meta_for_layout['keywords'],
			'description' => $meta_for_layout['description'],
			'refresh' => '5;url=' . $redirect_url
		);
		$meta = ' js-meta ' . str_replace('"', '\'', json_encode($meta_arr));
	}
?>
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content">
		  	<div class="authorize-page<?php echo $meta; ?>">
    			<?php echo $content_for_layout;?>
            </div>
	</div>
  <?php if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'hashbang')) { ?>
</body>
</html>
<?php } ?>