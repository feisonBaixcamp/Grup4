<?php

class DB {
    private $userlist;

    function __construct() {
        $this->userlist = array(
            0 => array(
                'username' => 'test',
                'password' => 'test'
            ),
            1 => array(
                'username' => 'admin',
                'password' => password_hash('HRGJFSOORWIEJ^C2341*029!2-3523', PASSWORD_DEFAULT)
            ),
        );
    }

    function getUsersList(){
        return $this->userlist;
    }

    // Método para obtener un usuario por nombre de usuario
    function getUserByUsername($username){
        foreach ($this->userlist as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null; // Devuelve null si no se encuentra el usuario
    }
}

?>
