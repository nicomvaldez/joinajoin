<div class="users form register-form-block">
<h2><?php echo __l('Register'); ?></h2>
<?php echo $this->Form->create('User', array('action' => 'register', 'class' => 'normal')); ?>
	<div class="padd-bg-tl">
        <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
        </div>
    </div>
    <div class="padd-center">
 <div class="clearfix">
	 <div class="open-id-block clearfix">
        <h5 class="grid_left"><?php echo __l('Connect with facebook: '); ?></h5>
		<ul class="open-id-list grid_left clearfix">
			<li class="face-book-2">
				 <?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>
					<?php echo $this->Html->link(__l('Sign up with Facebook'), array('controller' => 'users', 'action' => 'login','type'=>'facebook'), array('title' => __l('Sign up with Facebook'), 'escape' => false)); ?>
				 <?php endif; ?>
			</li>
			<!--<?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
				<li class="twiiter"><?php echo $this->Html->link(__l('Sign up with Twitter'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'admin'=>false), array('class' => 'Twitter', 'title' => __l('Sign up with Twitter')));?></li>
			<?php endif;?>-->
			<?php if(Configure::read('user.is_enable_openid')):?>
				<li class="yahoo"><?php echo $this->Html->link(__l('Sign up with Yahoo'), array('controller' => 'users', 'action' => 'login', 'type'=>'yahoo'), array('alt'=> __l('[Image: Yahoo]'),'title' => __l('Sign up with Yahoo')));?></li>
				<li class="gmail"><?php echo $this->Html->link(__l('Sign up with Gmail'), array('controller' => 'users', 'action' => 'login', 'type'=>'gmail'), array('alt'=> __l('[Image: Gmail]'),'title' => __l('Sign up with Gmail')));?></li>
				<li class="open-id"><?php 	echo $this->Html->link(__l('Sign up with Open ID'), array('controller' => 'users', 'action' => 'login','type'=>'openid'), array('class'=>'js-ajax-colorbox-openid {source:"js-dialog-body-open-login"}','title' => __l('Sign up with Open ID')));?></li>
			<?php endif;?>

		</ul>
	</div>
	</div>
<hr>
<div class="register_subtitle sub_texto">Or, sign up the usual way</div>
<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
	<?php
		$terms = $this->Html->link(__l('Terms & Policies'), array('controller' => 'pages', 'action' => 'view', 'term-and-policies'), array('target' => '_blank'));	
		if(!empty($this->request->data['User']['openid_url'])):
			echo $this->Form->input('openid_url', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_url']));
		endif;
		
			//echo $this->Form->input('username',array('info' => __l('* Remember, Your username will be visible to the public, try to be formal.')));

			echo $this->Form->input('UserProfile.first_name', array('label' => __l('First Name')));
			echo $this->Form->input('UserProfile.last_name', array('label' => __l('Last Name')));
		
		
		?>
		<!-- <div class="sub_texto">Your real first name.</div> -->
		<?php
		if(empty($this->request->data['User']['openid_url']) && empty($this->request->data['User']['fb_user_id']) && empty($this->request->data['User']['twitter_user_id'])):
			echo $this->Form->input('passwd', array('label' => __l('Password')));
		endif;
		echo $this->Form->input('email'); ?>
<?php endif; ?>
		<div>
          <?php
		    if(!empty($this->request->params['named']['order_id'])) :
                echo $this->Form->input('order_id', array('type' => 'hidden', 'value' => $this->request->params['named']['order_id']));
            endif;

            if(!empty($this->request->data['User']['fb_user_id'])) :
                echo $this->Form->input('fb_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['fb_user_id']));
            endif;
			if(!empty($this->request->data['User']['twitter_user_id'])) :
                echo $this->Form->input('twitter_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_user_id']));
            endif;		 
			if(!empty($this->request->data['User']['twitter_access_token'])) :
                echo $this->Form->input('twitter_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_token']));
            endif;		 
			if(!empty($this->request->data['User']['twitter_access_key'])) :
                echo $this->Form->input('twitter_access_key', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_key']));
            endif;	
			if(!empty($this->request->data['User']['is_yahoo_register'])) :
                echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
            endif;
            if(!empty($this->request->data['User']['is_gmail_register'])) :
                echo $this->Form->input('is_gmail_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_gmail_register']));
            endif;				
			echo $this->Form->input('referred_by_user_id',array('type' => 'hidden'));
		  ?>
		  
        </div>
	<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
        <?php
		if(empty($this->request->data['User']['openid_url'])): ?>            
        	<div class="captcha-block clearfix js-captcha-container">
    			<div class="captcha-left grid_left">
    	          <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', 'register', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
    	        </div>
    	        <div class="captcha-right grid_left">
        	        <?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
	               <div class="play-link">
		              <?php echo $this->Html->link(__l('Click to play'), Router::url('/', true)."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play', 'register'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
				   </div>
    	        </div>
            </div>
        	<?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
    		<?php echo $this->Form->input('is_agree_terms_conditions', array('label' => __l('I have read, understood & agree to the').' '.$terms)); ?>
            <?php
        endif; endif; ?>


  
        			</div>
<div class="padd-bg-bl">
    <div class="padd-bg-br">
    <div class="padd-bg-bmid"></div>
    </div>
    </div>
<?php if(Configure::read('user.is_enable_normal_registration') || !empty($facebook_connect) || !empty($twitter_connect) || !empty($openid_connect)): ?>
      <div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Submit')); ?>
</div>
<?php endif; ?>
<?php echo $this->Form->end(); ?>
</div>
