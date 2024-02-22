<?php

class User {
    public $username;
    public $isAdmin;

    function __construct($username, $isAdmin) {
        $this->username = $username;
        $this->isAdmin = $isAdmin;
    }

    function __toString() {
        return "Name : " . $this->username . " Is Admin : " . $this->isAdmin;
    }

    // Retorna el nombre de usuario
    public function getUsername() {
        return $this->username;
    }

    // Retorna si el usuario es administrador
    public function isAdmin() {
        return $this->isAdmin;
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
