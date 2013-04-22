<?php
class UserLogin extends AppModel
{
    public $name = 'UserLogin';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    function insertUserLogin($user_id) 
    {
        $this->data['UserLogin']['user_id'] = $user_id;
		// @todo "IP table logic"
        $this->data['UserLogin']['user_login_ip'] = RequestHandlerComponent::getClientIP();
        $this->data['UserLogin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->save($this->data);
        $language = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $_SESSION['Auth']['User']['id'],
            ) ,
            'fields' => array(
                'Language.iso2'
            ) ,
            'recursive' => 0
        ));
        if (!empty($language['Language']['iso2'])) {
            App::import('Core', 'ComponentCollection');
            $collection = new ComponentCollection();
            App::import('Component', 'Cookie');
            $objCookie = new CookieComponent($collection);
            $objCookie->write('user_language', $language['Language']['iso2'], false);
        }
		if (!empty($_SESSION['Auth']['User']['is_facebook_friends_fetched']) && !empty($_SESSION['Auth']['User']['is_show_facebook_friends']) && (strtotime($_SESSION['Auth']['User']['last_facebook_friend_fetched_date']) <= strtotime('now -' . Configure::read('user.days_after_fetch_facebook_friends') . ' days'))) {
			$oldFacebookFriends = $this->User->UserFacebookFriend->find('list', array(
				'conditions' => array(
					'UserFacebookFriend.user_id' => $_SESSION['Auth']['User']['id']
				) ,
				'fields' => array(
					'UserFacebookFriend.facebook_friend_id',
					'UserFacebookFriend.facebook_friend_name',
				) ,
				'recursive' => -1
			));
			App::import('Core', 'HttpSocket');
            $HttpSocket = new HttpSocket();
            $friends = $HttpSocket->get('https://graph.facebook.com/me/friends?access_token=' . $_SESSION['Auth']['User']['fb_access_token']);
			$friends = json_decode($friends->body);
			if (!empty($friends->data)) {
				foreach($friends->data as $friend) {
					$currentFacebookFriends[$friend->id] = $friend->name;
				}
				$newFacebookFriends = array_diff_key($currentFacebookFriends, $oldFacebookFriends);
				if (!empty($newFacebookFriends)) {
					foreach($newFacebookFriends as $newFacebookFriendId => $newFacebookFriendName) {
						$_data['UserFacebookFriend']['user_id'] = $_SESSION['Auth']['User']['id'];
						$_data['UserFacebookFriend']['facebook_friend_name'] = $newFacebookFriendName;
						$_data['UserFacebookFriend']['facebook_friend_id'] = $newFacebookFriendId;
						$this->User->UserFacebookFriend->create();
						$this->User->UserFacebookFriend->save($_data['UserFacebookFriend']);
					}
					$this->User->updateAll(array(
						'User.last_facebook_friend_fetched_date' => "'" . date('Y-m-d') . "'",
						'User.user_facebook_friend_count' => 'User.user_facebook_friend_count + ' . count($newFacebookFriends),
					) , array(
						'User.id' => $_SESSION['Auth']['User']['id']
					));
				}
			}
		}
		if (empty($_SESSION['Auth']['User']['cim_profile_id'])) {
			App::import('Model', 'Payment');
			$this->Payment = new Payment();
            $this->Payment->_createCimProfile($_SESSION['Auth']['User']['id']);
        }
    }
    function afterSave($is_created) 
    {
		// @todo "IP table logic"
        $this->User->updateAll(array(
            'User.last_login_ip' => '\'' . RequestHandlerComponent::getClientIP() . '\'',
            'User.last_logged_in_time' => '\'' . date('Y-m-d H:i:s') . '\'',
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
    }
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>