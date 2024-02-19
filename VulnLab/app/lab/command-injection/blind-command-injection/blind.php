<?php
require("../../../lang/lang.php");
$strings = tr();

try {
    $db = new PDO('sqlite:database.db');
} catch (PDOException $e) {
    // Conrollar l'error de connexió a la base de dades d'una manera adequada
    die("Error de connexió a la base de dades");
}

session_start();

// Verificar l'existència i validesa de la sessió
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Validar i sanititzar el user agent abans d'escriure al log
$userAgent = filter_var($_SERVER["HTTP_USER_AGENT"], FILTER_SANITIZE_STRING);
$filePath = '/tmp/userAgent.log';

file_put_contents($filePath, $userAgent . PHP_EOL, FILE_APPEND | LOCK_EX);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?= $strings['title']; ?></title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center" style="flex-direction: column;align-items:center;margin-top:20vh;">
            <div class="alert alert-info col-md-6" role="alert" style="text-align:center;">
                <h5><?= $strings["text"]; ?></h5>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="tbl" style="margin-top: 30px;"></div>
    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
