<?php

class User {
    public $username;
    public $password;
    public $generatedStrings;
    
    function __construct($username, $password, $generatedStrings) {
        $this->username = $username;
        $this->password = $password;
        $this->generatedStrings = $generatedStrings;
    }
    
    public function getRandomString() {
        // Generar una cadena aleatoria de forma segura utilizando funciones de PHP
        $randomString = bin2hex(random_bytes(16)); // Ejemplo de cadena aleatoria de 16 bytes en hexadecimal
        return $randomString;
    }
}

?>
