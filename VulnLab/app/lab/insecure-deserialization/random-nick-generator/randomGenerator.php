<?php
// Verifica si se proporciona un argumento en la línea de comandos
if(isset($argv[1])) {
    // Sanitiza el valor del argumento
    $input = filter_var($argv[1], FILTER_SANITIZE_STRING);
    
    // Genera un número aleatorio seguro
    $randomNumber = random_int(PHP_INT_MIN, PHP_INT_MAX);
    
    // Imprime el valor del argumento concatenado con el número aleatorio
    print $input . $randomNumber;
} else {
    // Si no se proporciona ningún argumento, muestra un mensaje de error
    echo "Por favor, proporciona un argumento.";
}
?>
