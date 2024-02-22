<?php

require("../../../lang/lang.php");
$strings = tr();

// Conexión a la base de datos SQLite utilizando PDO
$db = new PDO('sqlite:hackernews.db');

// Verificar si se enviaron datos del formulario
if (isset($_POST['link']) && isset($_POST['title'])) {
    // Obtener los datos del formulario
    $link = $_POST['link'];
    $title = $_POST['title'];

    try {
        // Preparar la consulta SQL con marcadores de posición
        $q = $db->prepare("INSERT INTO links(title, link) VALUES (:title, :link)");
        
        // Vincular los valores a los marcadores de posición y ejecutar la consulta
        $q->execute([
            ':title' => $title,
            ':link' => $link
        ]);

        // Redireccionar después de la inserción exitosa
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        // Manejar cualquier error de la base de datos aquí
        echo "Error: " . $e->getMessage();
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
    <link rel="stylesheet" type="text/css" href="flaticon.css">
    <style>
        a:hover {
            color: yellow
        }

    </style>
    <title><?php echo $strings['title'] ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center flex-column mt-4" style="text-align: center; color: aliceblue;">
        <div class="col-md-12 row justify-content-center" style="background-color: #212529;">
            <div class=" d-flex row justify-content-center" style="align-items: center;justify-content: center;">
                <h3 class="m-4">You Can Add News too</h3>
                <form action="#" method="POST">
                    <div class="mb-3 row ">
                        <label for="title" class="col-sm-2 col-form-label">News Title</label>
                        <div class="col-md-8 ">
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                    </div>
                    <div class="mb-3 row ">
                        <label for="url" class="col-sm-2 col-form-label">News Url</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="url" name="link">
                        </div>
                        <div class="justify-content-center row ">
                            <button type="submit" class="btn btn-primary col-md-4 m-4">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="news row col-md-12 mt-5">
            <table class="table table-dark table-hover shadow-lg">
                <thead>
                    <tr>
                        <th class="pb-4" style="text-align: center;">
                            <h1>#</h1>
                        </th>
                        <th class="p-4" colspan="1">
                            <h1>News All Around The World</h1>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Establecer el modo de manejo de errores para PDO
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $i = 1;
                    // Ejecutar consulta para seleccionar todos los enlaces
                    $q = $db->query("SELECT * FROM links");

                    if ($q) {
                        while ($cikti = $q->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<th>' . $i++ . '</th>';
                            echo '<td><a href="' . htmlspecialchars($cikti['link'], ENT_QUOTES, 'UTF-8') . '" style="text-decoration: none;">' . htmlspecialchars($cikti['title'], ENT_QUOTES, 'UTF-8') . '</a></td>';
                            echo '<td><a href="" style="text-align: right;text-decoration: none;"><i style="color: aliceblue;margin-right: 5px; " class="flaticon-up-arrow buton"></i></a><a href="" style="text-align: right;text-decoration: none;"><i style="color: aliceblue; " class="flaticon-down-arrow buton"></i></a></td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '<form action="#" method="POST">';
                        echo '<button type="submit" class="btn btn-danger" name="del">' . $strings['delete-all'] . '</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                    // Verificar si se hizo clic en el botón de eliminación
                    if (isset($_POST['del'])) {
                        // Preparar y ejecutar la consulta para eliminar todos los enlaces
                        $q = $db->prepare("DELETE FROM links");
                        $q->execute();
                        // Redireccionar después de eliminar todos los enlaces
                        header("Location: index.php");
                        exit;
                    }

                    ?>
    </div>
    </div>

    <script id="VLBar" title="<?php echo $strings['title'] ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>

</body
