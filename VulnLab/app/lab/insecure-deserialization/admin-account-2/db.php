<?php

class DB {
    private $userlist;

    function __construct() {
        $this->userlist = array(
            0 => array(
                'username' => 'administrator',
                'password' => 'a2T%tq+<=VuLJh8,}fBwU@Qttn+YR{rq',
                'isAdmin' => true
            ),
            1 => array(
                'username' => 'test',
                'password' => 'test',
                'isAdmin' => false
            )
        );
    }

    function getUsersList() {
        return $this->userlist;
    }
}

?>
