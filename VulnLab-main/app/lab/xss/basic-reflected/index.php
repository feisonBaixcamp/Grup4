<?php
require("../../../lang/lang.php");
$strings = tr();

// Función para escapar y eliminar scripts de la entrada del usuario
function sanitize_input($data) {
    // Eliminar etiquetas <script> y su contenido
    return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data);
}

$db = new PDO('sqlite:database.db');

if (isset($_POST['uname']) && isset($_POST['passwd'])) {
    $username = $_POST['uname'];
    $password = $_POST['passwd'];

    // Sanitizar la entrada del usuario para eliminar scripts
    $username = sanitize_input($username);
    $password = sanitize_input($password);

    $q = $db->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
    $q->execute(array(
        ':username' => $username,
        ':password' => $password
    ));

    $_select = $q->fetch();
    if ($_select) {
        session_start();
        $_SESSION['username'] = $username;
        header("Location: stored.php");
        exit;
    } else {
        echo '<h1>' . htmlspecialchars($strings['wrong_username_or_pass']) . '</h1>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h4>VULNLAB</h4>

            <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo htmlspecialchars($strings['user']); ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="uname" id="inputEmail3">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label"><?php echo htmlspecialchars($strings['pass']); ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passwd" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($strings['submit']); ?></button>
                <p><?php echo htmlspecialchars($strings['sample_credentials']); ?></p>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?php echo htmlspecialchars($strings['title']); ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
