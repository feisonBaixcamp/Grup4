<?php

// Incluye la definición de la clase Usuario para evitar errores
include("user.php");

// Incluye el archivo de idioma
require("../../../lang/lang.php");
$strings = tr();

// Deshabilita la visualización de errores y la notificación de errores
error_reporting(0);
ini_set('display_errors', 0);

// Verifica si existe la cookie 'V2VsY29tZS1hZG1pbgo' y si es válida
if( isset($_COOKIE['V2VsY29tZS1hZG1pbgo']) ){
    // Intenta deserializar la cookie de forma segura
    $userData = base64_decode($_COOKIE['V2VsY29tZS1hZG1pbgo']);
    $user = unserialize($userData, ['allowed_classes' => ['User']]);
    
    // Verifica si el usuario es un objeto válido de la clase User
    if ($user instanceof User) {
        $text = "";
        // Evita la comparación de cadenas sensibles al caso, usar ===
        // Se recomienda comparar con valores literales, no con el contenido de la cookie
        switch ($user->username) {
            case "admin":
                $text = $strings['welcome-admin'];
                break;
            case "test":
                $text = $strings['welcome-test'];
                break;
            default:
                $text = $strings['welcome-another'];
                break;
        }
    } else {
        // Redirecciona si la deserialización no fue exitosa o el objeto no es de la clase esperada
        header("Location: login.php?msg=3");
        exit;
    }
} else {
    // Redirecciona si la cookie no está presente
    header("Location: login.php?msg=2");
    exit;
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titulo de tu página</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <style>
        h1 {
            text-align: center;
            color: red;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <!-- Se mueve la impresión del texto al inicio del cuerpo del HTML -->
    <h2><?php echo $text; ?></h2>
    <!-- Se agrega el script al final del cuerpo del HTML -->
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
