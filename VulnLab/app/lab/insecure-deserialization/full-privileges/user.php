<?php

class User {

    public $username;
    public $password;
    public $isAdmin;
    public $permissions;

    public function __construct($username, $password, $isAdmin, $permissions) {
        $this->username = $username;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
        $this->permissions = $permissions;
    }

    public function __toString() {
        return "Username: " . $this->username . " Password: " . $this->password . " Is admin? : " . $this->isAdmin . " Permissions: " . $this->permissions;
    }

}
