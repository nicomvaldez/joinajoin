<?php /* SVN: $Id: edit.ctp 4895 2010-05-13 08:49:37Z josephine_065at09 $ */ ?>
<div class="userProfiles userprofiles-form form">
	<?php if (empty($this->request->params['named']['prefix'])): ?>
		<h2><?php echo __l('Edit Profile'); ?></h2>
	<?php endif; ?>
    <div class="side1 grid_18">
    	<?php echo $this->Form->create('UserProfile', array('url'=>array('controller'=>'user_profiles','action' => 'edit',$this->request->data['User']['id']), 'class' => 'normal js-add-map', 'enctype' => 'multipart/form-data'));?>
       <fieldset class="form-block round-5">
       	    <div class="padd-bg-tl">
            <div class="padd-bg-tr">
            <div class="padd-bg-tmid clearfix"></div>
            </div>
        </div>
        <div class="padd-center">
    		<p class="round-5">
    		   <?php echo __l('Profile'); ?>
    		</p>
    		<?php
    			if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
    				echo $this->Form->input('User.id', array('label' => __l('User')));
    			endif;
    			if($this->request->data['User']['user_type_id'] == ConstUserTypes::Admin):
    				echo $this->Form->input('User.username',array('readonly' => 'readonly'));
    			endif;
    			if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
    				echo $this->Form->input('User.email', array('label' => __l('Email')));
    			endif;
    			    echo $this->Form->input('first_name', array('label' => __l('First Name')));
            		echo $this->Form->input('last_name', array('label' => __l('Last Name')));
            		echo $this->Form->input('middle_name', array('label' => __l('Middle Name')));
			?>
					<div class="clearfix required ">
						<p class="round-5 add-info"><?php echo __l('Gender'); ?></p>
						<div class="not-required radio-tabs-lblock radio-tabs-lblock1">
							<div class="radio-tabs-rblock">
								<?php echo $this->Form->input('gender_id', array('type' => 'radio', 'legend' => false, 'id' => 'js-gender', 'div' => 'js-radio-style')); ?>
							</div>
						</div>
					</div>
					<div class="input date-time edit-ptofile-time-block clearfix required">
						<div class="js-datetime">
							<?php echo $this->Form->input('dob', array('label'=>__l('DOB'), 'orderYear' => 'asc', 'maxYear' => date('Y'), 'minYear' => date('Y') - 100, 'div' => false, 'empty' => __l('Please Select'))); ?>
						</div>
					</div>
					<?php echo $this->Form->input('about_me', array('label' => __l('About Me')));?>
					<?php echo $this->Form->input('user_education_id', array('empty' => __l('Please Select'),'label' => __l('Education'))); ?>
					<?php echo $this->Form->input('user_employment_id', array('empty' =>__l('Please Select'),'label' => __l('Employment Status'))); ?>
					<?php $currecncy_place = '<span class="currency">'.Configure::read('site.currency'). '</span>' ; ?>
					<?php echo $this->Form->input('user_incomerange_id', array('empty' => __l('Please Select'),'label' => __l('Income range (').configure::read('site.currency').__l(')'))); ?>
					<?php $options = array('1' => __l('Yes'), '0' => __l('No')); ?>
					<div class="clearfix">
						<p class="round-5 add-info"><?php echo __l('Own Home?'); ?></p>
						<div class="not-required radio-tabs-lblock">
							<div class="radio-tabs-rblock">
								<?php echo $this->Form->input('own_home', array('options' => $options, 'type' => 'radio', 'legend' => false, 'div' => 'js-radio-style', 'default' => 0)); ?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->input('user_relationship_id', array('empty' => __l('Please Select'),'label' => __l('Relationship status'))); ?>
					<div class="clearfix">
						<p class="round-5 add-info"><?php echo __l('Have Children?'); ?></p>
						<div class="not-required radio-tabs-lblock">
							<div class="radio-tabs-rblock">
								<?php echo $this->Form->input('have_children', array('options' => $options, 'type' => 'radio', 'legend' => false, 'div' => 'js-radio-style', 'default' => 0)); ?>
							</div>
						</div>
					</div>
                	<?php echo $this->Form->input('school', array('label' => __l('School')));
                	echo $this->Form->input('work', array('label' => __l('Work'))); ?>
                	<span class="checkbox-label checkbox-label1">Habit</span>
                    <div class="checkbox-right checkbox-right1 clearfix">
                    <?php
                	echo $this->Form->input('Habit', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'Habit1', 'label' => __l('Habit')));
                    ?>
                    </div>
                    <?php
                    echo $this->Form->input('zip_code', array('label' => __l('Zip code')));
            		echo $this->Form->input('phone', array('label' => __l('Phone')));
            		echo $this->Form->input('backup_phone', array('label' => __l('Backup Phone')));
    			echo $this->Form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'),'class' =>'browse-field'));
    		?>
    		<div class="profile-image">
				<?php $this->request->data['User']['UserAvatar'] = !empty($this->request->data['User']['UserAvatar']) ? $this->request->data['User']['UserAvatar'] : array(); ?>
                <?php
					$current_user_details = array(
						'username' => $this->request->data['User']['username'],
						'user_type_id' => $this->request->data['User']['user_type_id'],
						'id' => $this->request->data['User']['id'],
						'fb_user_id' => $this->request->data['User']['fb_user_id']
					);
					$current_user_details['UserAvatar'] = array(
						'id' => $this->request->data['User']['attachment_id']
					);
					echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb');
				?>
    		</div>
    		</div>
    <div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid clearfix"></div>
        </div>
        </div>
    	</fieldset>
       <fieldset class="form-block round-5">
        <div class="padd-bg-tl">
            <div class="padd-bg-tr">
            <div class="padd-bg-tmid clearfix"></div>
            </div>
        </div>
        <div class="padd-center">
    		<p class="round-5">
    		   <?php echo __l('Contact details'); ?>
    		</p>
				<div class="contact-details">
				<div class="mapblock-info">
				<?php
					echo $this->Form->input('address', array('label' => __l('Address')));
					echo $this->Form->input('country_id',array('id'=>'js-country_id','type' => 'hidden'));
					echo $this->Form->input('State.name', array('type' => 'hidden'));
					echo $this->Form->input('City.name', array('type' => 'hidden'));
				?>
					<div id="mapblock">
						<div id="mapframe">
							<div id="mapwindow"></div>
						</div>
					</div>
				</div>
				</div>
    		</div>
    <div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid clearfix"></div>
        </div>
        </div>
    	</fieldset>




<fieldset class="form-block round-5">
    	      <div class="padd-bg-tl">
            <div class="padd-bg-tr">
            <div class="padd-bg-tmid clearfix"></div>
            </div>
        </div>
        <div class="padd-center">
    		<p class="round-5">
    		   <?php echo __l('Language'); ?>
    		</p>
    		<?php
    			//echo $this->Form->input('language_id', array('label' => __l('Language'), 'empty' => __l('Please Select')));
    		?>
    		<?php
    			echo $this->Form->input('language_id', array('type' => 'hidden', 'value'=>'42'));
    		?>
    	</div>
    <div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid clearfix"></div>
        </div>
        </div>
</fieldset>


   
   <fieldset class="form-block round-5">
       <div class="padd-bg-tl">
            <div class="padd-bg-tr">
            	<div class="padd-bg-tmid clearfix"></div>
            </div>
        </div>
        <div class="padd-center">
    		<p class="round-5">
    		   <?php echo __l('Paypal'); ?>
    		</p>
    		<div class="page-information clearfix">
    		<?php echo __l('If you do not have PayPal account,').' '.$this->Html->link(__l('click here'), array('controller' => 'payments', 'action' => 'create_paypal_account')).' '.__l('to create a PayPal account Instantly.'); ?>
    		</div>
    		<?php
    			echo $this->Form->input('paypal_account', array('label' => __l('PayPal Email')));
    			echo $this->Form->input('paypal_first_name', array('label' => __l('PayPal First Name'), 'info'=> __l('As given in PayPal')));
    			echo $this->Form->input('paypal_last_name', array('label' => __l('PayPal Last Name'), 'info'=> __l('As given in PayPal')));
    		?>
    			<?php
    		if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
    			echo $this->Form->input('User.is_active', array('label' => __l('Active')));
    		endif;
    	?>
    			</div>
    <div class="padd-bg-bl">
        <div class="padd-bg-br">
        <div class="padd-bg-bmid clearfix"></div>
        </div>
        </div>
    	</fieldset>

    	<div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Update'));?>
    </div>
    <?php echo $this->Form->end();?>
    </div>
    <div class="side2">
        <?php
        		echo $this->element('sidebar', array('config' => 'sec'));
        ?>
    </div>
</div>