<?php
    require("user.php");
    require("db.php");
    require("../../../lang/lang.php");
    $strings = tr();

    // Crear una instancia de la clase DB para acceder a la lista de usuarios
    $db = new DB();
    $users = $db->getUsersList();

    // Verificar si se enviaron datos de inicio de sesión a través del método POST
    if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
        
        // Obtener el nombre de usuario y la contraseña del usuario administrador de la lista de usuarios
        $username = $users[0]['username'];
        $password = $users[0]['password'];
        
        // Verificar si el nombre de usuario y la contraseña coinciden con los valores almacenados en la base de datos
        if( $username === md5($_POST['username']) && $password === md5($_POST['password']) ){

            // Crear un nuevo objeto User con los datos del usuario y serializarlo
            $user = new User($_POST['username'], $_POST['password'], 1);
            $serializedStr = serialize($user);

            // Establecer una cookie de sesión con el objeto User serializado
            setcookie('Session', base64_encode($serializedStr), time() + 3600, '/');

            // Redirigir al usuario a la página de inicio
            header("Location: index.php");
            exit;
        }
        else{
            // Si las credenciales son inválidas, redirigir al usuario a la página de inicio de sesión con un mensaje de error
            header("Location: login.php?msg=1");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel='stylesheet prefetch' href='css/normalize.min.css'>
    <style>
        /* Estilos CSS */
    </style>
</head>
<body>
    <div class="container">
        <div class="login">
            <?php 
                // Mostrar mensaje de error si se proporciona uno en la URL
                if( isset($_GET['msg'])){           
                    if ( $_GET['msg'] == 2 )
                        echo "<h2 style = 'color:red'>".$strings['enter-system']."</h2>";
                    else
                        echo "<h2 style = 'color:red'>".$strings['invalid-credentials']."</h2>";
                }
            ?>
            <h1><?= $strings['sign-in']; ?></h1>
            <form method="post">
                <input type="text" name="username" placeholder="<?= $strings['username']; ?>" required="required" />
                <input type="password" name="password" placeholder="<?= $strings['password']; ?>" required="required" />
                <button type="submit" class="btn btn-primary btn-block btn-large"><?= $strings['login']; ?></button>
            </form>
        </div>
    </div>
    <script src='js/prefixfree.min.js'></script>
</body>
</html>
