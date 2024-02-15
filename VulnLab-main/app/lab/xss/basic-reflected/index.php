<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

function sanitize_input($input) {
    // Eliminar etiquetas HTML y PHP
    $input = strip_tags($input);
    // Reemplazar caracteres especiales HTML
    $input = htmlspecialchars($input, ENT_QUOTES);
    return $input;
}

if (isset($_GET['q'])) {
    $q = sanitize_input($_GET['q']);
    echo '<div class="alert alert-danger" style="margin-top: 30vh;" role="alert" >';
    echo htmlspecialchars($strings['text']) . ' <b>' . htmlspecialchars($q, ENT_QUOTES) . '</b> ';
    echo '<a href="index.php">' . htmlspecialchars($strings['try'], ENT_QUOTES) . '</a>';
    echo "</div>";
} else {
    echo '<form method="GET" action="#" style="margin-top: 30vh;" class="row g-3 col-md-6 row justify-content-center mx-auto">';
    echo '<input class="form-control" type="text" placeholder="' . htmlspecialchars($strings['search'], ENT_QUOTES) . '" name="q" oninput="this.value = this.value.replace(/[<>]/g, \'\')">';
    echo '<button type="submit" class="col-md-3 btn btn-primary mb-3">' . htmlspecialchars($strings['s_button'], ENT_QUOTES) . '</button>';
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
    <title><?php echo htmlspecialchars($strings['title'], ENT_QUOTES); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center h-100 mx-auto">

        <script id="VLBar" title="<?= htmlspecialchars($strings['title'], ENT_QUOTES) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>

    </div>
    <script>
        // Codificar la salida JavaScript correctamente
        var title = "<?php echo htmlspecialchars($strings['title'], ENT_QUOTES); ?>";
        // Usar la variable 'title' de manera segura en el script
    </script>
</body>

</html>
