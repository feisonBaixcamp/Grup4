<?php
require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$db = new DB();
$users = $db->getUsersList();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $users[1]['username'];
    $storedPassword = $users[1]['password'];

    // Comparación de contraseñas usando password_verify
    if ($username === $_POST['username'] && password_verify($_POST['password'], $storedPassword)) {
        $isAdmin = $users[1]['isAdmin'];
        $permissions = $users[1]['permissions'];

        $user = new User($username, $storedPassword, $isAdmin, $permissions);

        // Almacenamiento en sesión en lugar de cookies
        $_SESSION['user'] = $user;

        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?msg=1");
        exit;
    }
}
?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang='en' class=''>
<head>
    <style class="cp-pen-styles">
        /* ... (Estilo CSS existente) ... */
    </style>
</head>
<body>
    <div class="container">
        <div class="login">
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 2)
                    echo "<h2 style='color:red'>" . $strings['enter-system'] . "</h2>";
                else
                    echo "<h2 style='color:red'>" . $strings['invalid-credentials'] . "</h2>";
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
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
