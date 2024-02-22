<?php

class User {
    public $username;
    public $password;
    public $isAdmin;

    function __construct($username, $isAdmin) {
        $this->username = $username;
        $this->isAdmin = $isAdmin;
    }

    function __toString() {
        return "Username: " . $this->username . " isAdmin: " . $this->isAdmin;
    }
}

?>
