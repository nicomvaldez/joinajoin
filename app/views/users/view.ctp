<?php /* SVN: $Id: view.ctp 4973 2010-05-15 13:14:27Z aravindan_111act10 $ */ ?>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<div class="users view user-view-blocks clearfix">
    <div class="user-view-right-block ">
    <div class="clearfix public-stats">
        <div class="block2-tl">
              <div class="block2-tr">
                <div class="block2-tm">

                  <h4><?php echo $this->Html->cText($user['UserProfile']['first_name'].' '.$user['UserProfile']['last_name']);?></h4>
                </div>
              </div>
            </div>
           <div class="block2-cl">
            <div class="block2-cr">
             <div class="block2-cm clearfix">
             	<div class="clearfix">
            			<div class="user-img-block-left grid_left">
						<?php
							$current_user_details = array(
								'username' => $user['User']['username'],
								'user_type_id' =>  $user['User']['user_type_id'],
								'id' =>  $user['User']['id'],
								'fb_user_id' =>  $user['User']['fb_user_id']
							);
							
						?>
	                  	<?php
    						$current_user_details['UserAvatar'] = $this->Html->getUserAvatar($user['User']['id']);
    						echo $this->Html->getUserAvatarLink($current_user_details, 'big_thumb'); ?>
            			</div>
            			<div class="user-img-block-right grid_left">

                				<p class="joined-info">
            					<?php echo  $this->Html->cText($user['UserProfile']['about_me']);?>
            				</p>
            		    </div>
        		    </div>
                <div class="rating-info-block">
		       	<p class="joined-info">
					<span class="date-info"><?php echo __l('Joined on').' '.$this->Html->cDateTimeHighlight($user['User']['created']);?></span>
				</p>
                 </div>
                 <div class="view-contact-link clearfix">
         			<?php if($this->Auth->sessionValid() && ($this->Auth->user('id') != $user['User']['id'])): ?>
                           	<div class="cancel-block">
                        	  <?php echo $this->Html->link(__l('Contact Me'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $user['User']['username']), array('title' => __l('Contact')));?>
                            </div>
                	<?php  endif; ?>

				</div>
              </div>
                </div>
            </div>
            <div class="block2-bl">
              <div class="block2-br">
                <div class="block2-bm"> </div>
              </div>
            </div>
            </div>
<?php echo $this->element('user-stats',array('config' => 'sec')); ?>

</div>

   
	 
<div class="user-view-left-block grid_left">
	<?php
			 //if($this->Auth->user('username') != $user['User']['username'] && Configure::read('friend.is_enabled') && $user['User']['user_type_id'] != ConstUserTypes::Admin) {
				if (!empty($friend)) { ?>
				<div class="add-block js-login-form">
				<?php
					if ($friend['UserFriend']['friend_status_id'] == ConstUserFriendStatus::Pending) {
						$is_requested = ($friend['UserFriend']['is_requested']) ? 'sent' : 'received';
						echo $this->Html->link(__l('Friend Request is Pending'), array('controller' => 'user_friends', 'action' => 'remove', $user['User']['username'], $is_requested), array('class' => 'user-pending js-friend', 'title' => __l('Click to remove from friends list')), array('escape' => false));
					} else {
						$is_requested = ($friend['UserFriend']['is_requested']) ? 'sent' : 'received';
						echo $this->Html->link(__l('Remove Friend'), array('controller' => 'user_friends', 'action' => 'remove', $user['User']['username'], $is_requested), array('class' => 'js-delete remove-user delete js-add-friend', 'title' => __l('Click to remove from friends list')));
					} ?>
				</div>
			  <?php	} else { 
			  
    			
    				if($this->Auth->user('id') != $user['User']['id']) { ?>
    				<div class="add-block js-login-form">
    				   <?php echo $this->Html->link(__l('Add as Friend'), array('controller' => 'user_friends', 'action' => 'add', $user['User']['username']), array('class' => 'add add-friend', 'title' => __l('Add as Friend')));
                        ?>
                      </div>
                	<?php	}
                        }
   	?>
   <h2 class="user-name-title"><?php echo ucfirst($this->Html->cText($user['UserProfile']['first_name'].' '.$user['UserProfile']['last_name'])); ?></h2>
     <div class="js-tabs  clearfix">
         <div class="pptab-menu-left">
         	<div class="pptab-menu-right">
       			<div class="pptab-menu-center clearfix">
             		<ul class="clearfix">
            			<li><?php echo $this->Html->link(__l('Properties'), array('controller' => 'properties', 'action' => 'index', 'user' => $user['User']['id'], 'type'=>'user','view'=>'compact'), array('title' => __l('My Properties')));?></li>
            			<li><?php echo $this->Html->link(__l('Requests'), array('controller' => 'requests', 'action' => 'index', 'user_id' => $user['User']['id'], 'view' => 'compact'), array('title' => __l('My Request')));?></li>
            			<li><?php echo $this->Html->link(__l('Recommendations'), array('controller' => 'user_comments', 'action' => 'index', $user['User']['username']), array('title' => __l('Friends Comments')));?></li>
            			<li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'index', 'user' => $user['User']['id'], 'type' => 'user', 'view' => 'compact'), array('title' => __l('My Friends')));?></li>
						<li><?php echo $this->Html->link(__l('Reviews'), array('controller' => 'property_user_feedbacks', 'action' => 'index','user_id' =>$user['User']['id'],'view'=>'compact'), array('title' => __l('Reviews')));?></li>
            		</ul>
        		</div>
    	 	</div>
	 	</div>
	    <div class="pptview-mblock-ll">
        	<div class="pptview-mblock-rr">
            	<div class="pptview-mblock-mm clearfix">
            		<div id="My_Properties" class="js-response"></div>
                    <div id="My_Request"></div>
                    <div id="Friends_Comments"></div>
                    <div id="My_Friends"></div>
					<div id="Reviews"></div>
        		</div>
        	</div>
        </div>
        <div class="pptview-mblock-bl">
        	<div class="pptview-mblock-br">
            	<div class="pptview-mblock-bb"></div>
        	</div>
        </div>
    </div>


<div class="clearfix"></div>


    
</div>

</div>