<?php

// Se incluyen los archivos necesarios
require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

// Se crea una instancia de la clase DB para obtener la lista de usuarios
$db = new DB();
$users = $db->getUsersList();

// Verificación de credenciales al enviar el formulario
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Se obtienen las credenciales del primer usuario (posición 0)
    $username = $users[0]['username'];
    $password = $users[0]['password'];

    // Se verifica si las credenciales enviadas coinciden con las del primer usuario
    if ($username === $_POST['username'] && $password === $_POST['password']) {
        // Si las credenciales son correctas, se redirige al usuario a la página principal

        // Se crea una instancia del usuario autenticado
        $user = new User($username, $password);

        // Se serializa el objeto del usuario
        $serializedStr = serialize($user);

        // Se codifica en base64 para mayor seguridad
        $extremeSecretCookie = base64_encode($serializedStr);

        // Se establece la cookie
        setcookie('V2VsY29tZS1hZG1pbgo', $extremeSecretCookie);

        // Se redirige al usuario a la página principal
        header("Location: index.php");
        exit;
    } else {
        // Si las credenciales son incorrectas, se redirige al usuario a la página de inicio de sesión con un mensaje de error
        header("Location: login.php?msg=1");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['sign-in']; ?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <style>
        /* Estilos CSS */
    </style>
</head>
<body>
<div class="container">
    <div class="login">
        <?php 
            // Se muestra un mensaje de error si existe la variable GET 'msg'
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 2) {
                    echo "<h2 style='color:red'>" . $strings['enter-system'] . "</h2>";
                } else {
                    echo "<h2 style='color:red'>" . $strings['invalid-credentials'] . "</h2>";
                }
            }
        ?>
        <br>
        <h1><?= $strings['sign-in']; ?></h1>
        <br>
        <form method="post">
            <input type="text" name="username" placeholder="<?= $strings['username']; ?>" required="required" />
            <input type="password" name="password" placeholder="<?= $strings['password']; ?>" required="required" />
            <button type="submit" class="btn btn-primary btn-block btn-large"><?= $strings['login']; ?></button>
        </form>
    </div>
</div>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
