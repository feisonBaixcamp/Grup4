<?php
require("../../../lang/lang.php");
$strings = tr();

try {
    $db = new PDO('sqlite:database.db');
} catch (PDOException $e) {
    // Controlar l'error de connexió a la base de dades d'una manera adequada
    die("Error de connexió a la base de dades");
}

session_start();

if (isset($_POST['uname']) && isset($_POST['passwd'])) {

    // Utilitzar declaracions preparades per prevenir la injecció de SQL
    $q = $db->prepare("SELECT * FROM users WHERE username=:user AND password=:pass");
    $q->execute(array(
        'user' => $_POST['uname'],
        'pass' => $_POST['passwd']
    ));

    $_select = $q->fetch(PDO::FETCH_ASSOC);

    // Verificar si s'ha trobat l'usuari
    if ($_select) {
        // Establir la variable de sessió i redirigir a la pàgina 
        $_SESSION['username'] = $_POST['uname'];
        header("Location: blind.php");
        exit;
    } else {
        echo '<h1>usuari o contrasenya incorrectes</h1>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?php echo $strings['title']; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h4>VULNLAB</h4>

            <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Usuari</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="uname" id="inputEmail3">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Contrasenya</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passwd" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $strings['submit']; ?></button>
                <p>mandalorian / mandalorian</p>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
