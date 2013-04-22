<?php
class TempContactsController extends AppController
{
    public $name = 'TempContacts';
    public function beforeFilter() 
    {
        $this->Security->validatePost = false;
        parent::beforeFilter();
    }
    public function index($member = null, $contacts_source = null) 
    {
        $this->pageTitle = __l('Temp Contacts');
        $this->paginate = array(
            'conditions' => array(
                'TempContact.user_id = ' => $this->Auth->user('id') ,
                'TempContact.is_member = ' => $member
            ) ,
            'contain' => array(
                'ContactUser'
            ) ,
            'limit' => 10,
            'recursive' => 1
        );
        $invite_friend_options = array(
            '0' => __l('No Action') ,
            '1' => __l('Invite')
        );
        $this->set('invite_friend_options', $invite_friend_options);
        $add_friend_options = array(
            '0' => __l('No Action') ,
            '1' => __l('Add as friend')
        );
        $this->set('add_friend_options', $add_friend_options);
        $exist_friend_options = array(
            '0' => __l('No Action') ,
            '1' => __l('Remove')
        );
        $this->set('exist_friend_options', $exist_friend_options);
        $this->set('tempContacts', $this->paginate());
        $this->set('member', $member);
        $this->set('contacts_source', $contacts_source);
    }
}
?>
