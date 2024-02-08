<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    // Validar la entrada del usuario para asegurarse de que solo contiene caracteres alfanuméricos y espacios
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $q)) {
        echo '<div class="alert alert-danger" style="margin-top: 30vh;" role="alert" >';
        echo htmlspecialchars($strings['invalid_input']);
        echo '<a href="index.php">' . htmlspecialchars($strings['try']) . '</a>';
        echo "</div>";
        exit; // Detener la ejecución si la entrada no es válida
    }
    
    echo '<div class="alert alert-danger" style="margin-top: 30vh;" role="alert" >';
    echo '' . htmlspecialchars($strings['text']) . ' <b>' . $q . '</b> ';
    echo '<a href="index.php">' . htmlspecialchars($strings['try']) . '</a>';
    echo "</div>";
} else {
    echo '<form method="GET" action="#" style="margin-top: 30vh;" class="row g-3 col-md-6 row justify-content-center mx-auto">';
    echo '<input class="form-control" type="text" placeholder="' . htmlspecialchars($strings['search']) . '" name="q">';
    echo '<button type="submit" class="col-md-3 btn btn-primary mb-3">' . htmlspecialchars($strings['s_button']) . '</button>';
    echo '</form>';
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
    <div class="container d-flex justify-content-center align-items-center h-100 mx-auto">

        <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>

    </div>
</body>

</html>
