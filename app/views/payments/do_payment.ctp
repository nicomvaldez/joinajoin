<?php /* SVN: $Id: do_payment.ctp 41573 2011-01-19 06:42:15Z josephine_065at09 $ */ ?>
<div id="<?php echo $action;?>-authorizecontainer">
    <div id="theme" class="clearfix">
		<span class="site-logo"><?php echo Configure::read('site.name'); ?></span>
		<span class="openid-to"><?php echo __l('to'); ?></span>
		<span class="openid-logo"><?php echo $action; ?></span>        
    </div>
	<div class="message-content">
		<h2><?php echo __l('Redirecting you to ').$action; ?><?php echo $this->Html->image('loading.gif'); ?></h2>
		<?php
			$this->PagSeguro->form($gateway_options);
			$this->PagSeguro->data();
		?>
		<p>
			<?php echo __l('If your browser doesn\'t redirect you pleaseclick here to continue.'); ?>
			<?php $this->PagSeguro->submit($gateway_options); ?>
		</p>
	</div>
</div>