<?php
include("permission.php");

class db {
    private $userlist;

    function __construct() {
        $this->userlist = array(
            0 => array(
                'username' => 'administrator',
                'password' => password_hash('a2T%tq+<=VuLJh8,}fBwU@Qttn+YR{rq', PASSWORD_BCRYPT),
                'isAdmin' => 1,
                'permissions' => new Permission(1, 1, 1)
            ),
            1 => array(
                'username' => 'test',
                'password' => password_hash('test', PASSWORD_BCRYPT),
                'isAdmin' => 0,
                'permissions' => new Permission(0, 0, 0)
            )
        );
    }

    function getUsersList() {
        return $this->userlist;
    }
}
?>
