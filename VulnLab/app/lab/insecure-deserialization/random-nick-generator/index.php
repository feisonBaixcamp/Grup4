<?php
error_reporting(0);
ini_set('display_errors', 0);
include("user.php");
require("../../../lang/lang.php");
$strings = tr();
$user;
$randomNames;

// Verificar si la cookie de sesión está establecida
if (isset($_COOKIE['Session'])) {
    try {
        // Deserializar el objeto User de la cookie de sesión
        $user = unserialize(base64_decode($_COOKIE['Session']));
        $randomNames = $user->generatedStrings;

        // Verificar si la lista de nombres aleatorios está vacía o nula
        if (empty($randomNames) || is_null($randomNames)) {
            $randomNames = ["test"]; // Asignar un nombre de prueba por defecto si la lista está vacía o nula
        }
    } catch (Exception $e) {
        header("Location: login.php?msg=3");
        exit;
    }

    // Verificar si se ha enviado una solicitud para generar un nuevo nombre aleatorio
    if (isset($_GET['generate'])) {
        // Generar un nuevo nombre aleatorio y agregarlo a la lista
        array_push($randomNames, $user->getRandomString());
        $user->generatedStrings = $randomNames;

        // Serializar el objeto User actualizado y actualizar la cookie de sesión
        $serializedStr = serialize($user);
        setcookie('Session', base64_encode($serializedStr), time() + 3600, '/');
    }
} else {
    // Si la cookie de sesión no está establecida, redirigir al usuario a la página de inicio de sesión con un mensaje de error
    header("Location: login.php?msg=2");
    exit;
}
?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        h1 {
            text-align: center;
        }
    </style>
    <link rel='stylesheet prefetch' href='css/normalize.min.css'>
    <script src='js/prefixfree.min.js'></script>
</head>

<body>
    <div style="text-align:middle">
        <?php
        // Mostrar un mensaje de bienvenida
        echo "<h1>" . $strings['welcome-test'] . "</h1>";
        ?>
    </div>
    <div class="container">
        <h2></h2>
        <table class="table">
            <thead>
                <tr>
                    <th><?= $strings['generated-names']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Iterar sobre la lista de nombres aleatorios y mostrarlos en una tabla
                foreach ($randomNames as $randomName) {
                    echo "<tr>";
                    echo "<td>" . $randomName . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="text-align:center;">
            <form method="get">
                <!-- Agregar un campo oculto para enviar la solicitud de generación de nombre aleatorio -->
                <input value="generate" type="hidden" name="generate">
                <button type="submit"><?= $strings['generate-nick']; ?></button>
            </form>
        </div>
    </div>
</body>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>

</html>
