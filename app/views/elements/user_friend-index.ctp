<?php
    echo $this->requestAction(array('controller' => 'user_friends', 'action' => 'index','user' =>$user_id,'type'=>'user','view'=>'compact'), array('return'));
?>