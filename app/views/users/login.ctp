<div class="users form clearfix">
    <h2><?php echo __l('Login'); ?></h2>
        <?php
	    echo $this->Form->create('User', array('action' => 'login', 'class' => 'normal clearfix')); ?>
    	<div class="padd-bg-tl">
            <div class="padd-bg-tr">
            <div class="padd-bg-tmid"></div>
            </div>
     </div>
    <div class="padd-center">
	<?php if (empty($this->request->params['prefix'])): ?>
	 <div class="clearfix">
	 <div class="open-id-block clearfix">
        <h5 class="grid_left"><?php echo __l('Connect with facebook: '); ?></h5>
		<ul class="open-id-list grid_left clearfix">
			<li class="face-book-2">
				 <?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>
					<?php echo $this->Html->link(__l('Sign in with Facebook'), array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), array('title' => __l('Sign in with Facebook'), 'escape' => false)); ?>
				 <?php endif; ?>
			</li>

			<!-- <?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
				<li class="twiiter"><?php echo $this->Html->link(__l('Sign in with Twitter'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'admin' => false), array('class' => 'Twitter', 'title' => __l('Sign in with Twitter')));?></li>
			<?php endif;?>
		-->
			<?php if(Configure::read('user.is_enable_openid')):?>
				<li class="yahoo"><?php echo $this->Html->link(__l('Sign in with Yahoo'), array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), array('alt'=> __l('[Image: Yahoo]'),'title' => __l('Sign in with Yahoo')));?></li>
				<li class="gmail"><?php echo $this->Html->link(__l('Sign in with Gmail'), array('controller' => 'users', 'action' => 'login', 'type' => 'gmail', 'admin' => false), array('alt'=> __l('[Image: Gmail]'),'title' => __l('Sign in with Gmail')));?></li>
				<li class="open-id"><?php 	echo $this->Html->link(__l('Sign in with Open ID'), array('controller' => 'users', 'action' => 'login','type' => 'openid', 'admin' => false), array('class'=>'js-ajax-colorbox-openid {source:"js-dialog-body-open-login"}','title' => __l('Sign in with Open ID')));?></li>
			<?php endif;?>
		</ul>
	</div>
	</div>
	<?php endif; ?>
<hr>
	<div class="register_subtitle sub_texto">Or, log in the usual way.</div>
	
<?php if(Configure::read('user.is_enable_normal_registration') || (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')): ?>

	    <?php
		echo $this->Form->input(Configure::read('user.using_to_login'));
	    echo $this->Form->input('passwd', array('label' => __l('Password')));
        ?>
                 	         
		<?php
		echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));?>
	  	<div class="fromleft"> 	<?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin'=>false),array('title' => __l('Forgot your password?')));
	?>
	<?php if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')):	?> |
	<?php 
			echo $this->Html->link(__l('Signup') , array('controller' => 'users',	'action' => 'register'),array('title' => __l('Signup')));
		endif;
		$type = !empty($this->request->params['named']['type']) ? '/type:' . $this->request->params['named']['type'] : '';
        $f = (!empty($_GET['f'])) ? $_GET['f'] : (!empty($this->request->data['User']['f']) ? $this->request->data['User']['f'] : (!empty($this->request->params['named']['payment_id'])? '/payments/order/' . $this->request->params['named']['payment_id'] . '/order_id:' . $this->request->params['named']['order_id'] . $type : ''));
		if(!empty($f)) :
            echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
        endif;
		if(isset($this->request->params['named']['order_id'])) :
            echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
        endif;
        ?>
        	</div>
<?php endif; ?>
		
			        				</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
    <?php if(Configure::read('user.is_enable_normal_registration') || (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')): ?>
     	<div class="clearfix submit-block">
			<?php echo $this->Form->submit(__l('Submit'));?>
			<?php if (!empty($this->request->params['named']['payment_id'])): ?>
				<div class="js-login-form cancel-block"><span class="map-button"><?php echo __l('Cancel'); ?></span></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
			<?php echo $this->Form->end();?>
</div>