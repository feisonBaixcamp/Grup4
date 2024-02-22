<?php

require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

$db = new DB();
$users = $db->getUsersList();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Iterar sobre la lista de usuarios para encontrar coincidencias
    foreach ($users as $user) {
        if ($user['username'] === md5($username) && $user['password'] === md5($password)) {
            // Si las credenciales son correctas, crear un objeto User y serializarlo
            $userObject = new User($username, $user['isAdmin']);
            $serializedUser = serialize($userObject);
            $encodedUser = base64_encode(urlencode($serializedUser));
            // Establecer la cookie y redirigir al usuario a la página de inicio
            setcookie('d2VsY29tZS1hZG1pbmlzdHJhdG9y', $encodedUser);
            header("Location: index.php");
            exit;
        }
    }

    // Si no se encontraron coincidencias, redirigir de nuevo a la página de inicio de sesión con un mensaje de error
    header("Location: login.php?msg=1");
    exit;
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/normalize.min.css">
    <script src="js/prefixfree.min.js"></script>
    <style>
        /* Estilos CSS aquí */
    </style>
</head>
<body>
<div class="container">
    <div class="login">
        <?php
        // Mostrar mensaje de error si existe
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 2)
                echo "<h2 style='color:red'>" . $strings['enter-system'] . "</h2>";
            else
                echo "<h2 style='color:red'>" . $strings['invalid-credentials'] . "</h2>";
        }
        ?>
        <h1><?= $strings['sign-in']; ?></h1>
        <form method="post">
            <input type="text" name="username" placeholder="<?= $strings['username']; ?>" required="required"/>
            <input type="password" name="password" placeholder="<?= $strings['password']; ?>" required="required"/>
            <button type="submit" class="btn btn-primary btn-block btn-large"><?= $strings['login']; ?></button>
        </form>
    </div>
</div>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
