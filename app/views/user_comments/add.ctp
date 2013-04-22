<?php /* SVN: $Id: add.ctp 40929 2011-01-11 12:15:19Z ramkumar_136act10 $ */ ?>
<div class="userComments form js-ajax-form-container">
    <div class="userComments-add-block js-corner round-5">
        <?php echo $this->Form->create('UserComment', array('class' => "normal comment-form clearfix js-comment-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
        	<fieldset>

				<h3><?php 
					if(!empty($user['User']['username'])):
						echo __l('Add your recommendation for ').$user['UserProfile']['first_name'] .' '.$user['UserProfile']['last_name']; 
					else:
						echo __l('Add your recommendation'); 
					endif;
				?></h3>

        	<?php
        		echo $this->Form->input('user_id', array('type' => 'hidden'));
        		echo $this->Form->input('comment', array('type' => 'textarea','label' =>false));
        	?>
        	</fieldset>
<div class="submit-block clearfix">
<?php
	echo $this->Form->submit(__l('Add'));
?>
</div>
<?php
	echo $this->Form->end();
?>
    </div>
</div>