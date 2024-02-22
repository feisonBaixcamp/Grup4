<?php

class User {
    public $username;
    public $password;

    function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    function __toString() {
        return "Name : " . $this->username . " Surname : " . $this->password;
    }

    // Evita la serialización de la instancia de usuario
    public function __sleep() {
        return [];
    }

    // Evita la deserialización de la instancia de usuario
    public function __wakeup() {
        // Se puede agregar alguna lógica adicional aquí si es necesario
    }
}

?>
