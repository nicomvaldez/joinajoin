<?php /* SVN: $Id: lst.ctp 13910 2010-07-16 14:34:46Z siva_063at09 $ */ ?>
<div class="userFriends lst">
    <div class="main-content-block js-corner round-5 grid_17">
		<h2><?php echo __l('My Friends');?></h2>
        <p class="add-block people-information"><?php echo $this->Html->link(sprintf(__l('Find people you know on %s'), Configure::read('site.name')), array('controller' => 'user_friends', 'action' => 'import'), array('class' => 'add-friend  people-find js-people-find', 'title' => sprintf(__l('Find people you know on %s'), Configure::read('site.name'))));?></p>
	<div class="js-tabs">
            <div class="pptab-menu-left">
            <div class="pptab-menu-right">
            <div class="pptab-menu-center">

            <ul class="clearfix">
				<li class="received"><?php echo $this->Html->link(__l('Received Friends Requests'), '#received-request'); ?></li>
				<li class="sent"><?php echo $this->Html->link(__l('Sent Friends Requests'), '#sent-request'); ?></li>
			</ul>
</div></div></div>

<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
            <div id="received-request" class="friends-request">
	            <div class="friend-lst-block">
					<div class="js-tabs">
					<div class="pptab-menu-left">
					<div class="pptab-menu-right">
            <div class="pptab-menu-center">
						<ul class="clearfix">
							<li class="accepted"><?php echo $this->Html->link(__l('Accepted'), '#received-accepted'); ?></li>
							<li class="pending"><?php echo $this->Html->link(__l('Pending'), '#received-pending'); ?></li>
							<li class="rejected"><?php echo $this->Html->link(__l('Rejected'), '#received-rejected'); ?></li>
						</ul></div></div></div>
						<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
						<div id="received-accepted" class="js-responses">
							<?php
								echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Approved, 'type' => 'received', 'config' => 'sec'));
							?>
						</div>
                        <div id="received-pending" class="js-responses">
                            <?php
                                echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Pending, 'type' => 'received', 'config' => 'sec'));
                            ?>
                        </div>
						<div id="received-rejected" class="js-responses">
							<?php
								echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Rejected, 'type' => 'received', 'config' => 'sec'));
							?>
						</div>
							</div></div></div>
						<div class="pptview-mblock-bl">
						 <div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
           </div>
          </div>
					</div>
				</div>
			</div></div></div></div>


<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
        	<div id="sent-request" class="friends-request">
				<div class="friend-lst-block">
					<div class="js-tabs">
					<div class="pptab-menu-left">
					<div class="pptab-menu-right">
            <div class="pptab-menu-center">
						<ul class="clearfix">
							<li class="accepted"><?php echo $this->Html->link(__l('Accepted'), '#sent-accepted'); ?></li>
                            <li class="pending"><?php echo $this->Html->link(__l('Pending'), '#sent-pending'); ?></li>
							<li class="rejected"><?php echo $this->Html->link(__l('Rejected'), '#sent-rejected'); ?></li>
						</ul></div></div></div>
						<div class="pptview-mblock-ll">
            <div class="pptview-mblock-rr">
              <div class="pptview-mblock-mm clearfix">
						<div id="sent-accepted" class="js-responses">
							<?php
								echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Approved, 'type' => 'sent', 'config' => 'sec'));
							?>
						</div>
                        <div id="sent-pending" class="js-responses">
                            <?php
                                echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Pending, 'type' => 'sent', 'config' => 'sec'));
                            ?>
                        </div>
						<div id="sent-rejected" class="js-responses">
							<?php
								echo $this->element('user_friends-index', array('status' => ConstUserFriendStatus::Rejected, 'type' => 'sent', 'config' => 'sec'));
							?>
						</div>
						</div></div></div>
						<div class="pptview-mblock-bl">
						<div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
            </div>
          </div>
					</div>
				</div>
             </div></div></div></div>

            <div class="pptview-mblock-bl">
            <div class="pptview-mblock-br">
            <div class="pptview-mblock-bb"></div>
            </div>
          </div>

        </div>

     </div>
</div>
<div class="side2 grid_6">
	<?php echo $this->element('user-stats'); ?>
</div>