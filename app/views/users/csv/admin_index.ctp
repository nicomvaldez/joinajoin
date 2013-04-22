<?php
$i = 0;
do {
    $user->paginate = array(
        'conditions' => $conditions,
        'offset' => $i,
        'fields' => array(
            'User.username',
            'User.email',
            'ReferredByUser.username',
            'User.is_active',
            'User.user_openid_count',
            'User.user_login_count',
            'User.user_view_count',
            'User.user_referred_count',
            'User.fb_user_id',
            'User.twitter_user_id',
            'User.signup_ip',
            'User.created',
            'User.is_email_confirmed',
        ),
		'order' => array(
			'User.id' => 'desc'
		) ,
        'recursive' => 0
    );
    if(!empty($q)){
        $user->paginate['search'] = $q;
    }
    $Users = $user->paginate();
    if (!empty($Users)) {
        $data = array();
        foreach($Users as $User) {
	        $data[]['User'] = array(
				__l('Username') => $User['User']['username'],
				__l('Email') => $User['User']['email'],
				__l('Referred by') => (!empty($User['ReferredByUser']['username'])) ? $User['ReferredByUser']['username'] : '',
				__l('Active') => ($User['User']['is_active']) ? __l('Active') : __l('Inactive') ,
				__l('Email confirmed') => ($User['User']['is_email_confirmed']) ? __l('Yes') : __l('No') ,
				__l('OpenID count') => $User['User']['user_openid_count'],
				__l('Login count') => $User['User']['user_login_count'],
				__l('View count') => $User['User']['user_view_count'],
				__l('Reffered count') => $User['User']['user_referred_count'],
				__l('Facebook user id') => $User['User']['fb_user_id'],
				__l('twitter user id') => $User['User']['twitter_user_id'],
				__l('Signup IP') => $User['User']['signup_ip'],
				__l('Created') => $User['User']['created'],
          	);
        }
        if (!$i) {
            $this->Csv->addGrid($data);
        } else {
            $this->Csv->addGrid($data, false);
        }
    }
    $i+= 20;
}
while (!empty($Users));
echo $this->Csv->render(true);
?>