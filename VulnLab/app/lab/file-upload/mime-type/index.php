<?php
require("../../../lang/lang.php");
$strings = tr();

if (isset($_POST['submit'])) {
    $tmpName = $_FILES['input_image']['tmp_name'];
    $fileName = $_FILES['input_image']['name'];
    $fileType = $_FILES['input_image']['type'];

    if (!empty($fileName)) {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        $uploadPath = "uploads/";

        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Validar la extensión del archivo
        if (!in_array(strtolower($fileExt), $allowedExtensions)) {
            $status = "blocked";
        } else {
            // Validar el tipo MIME del archivo
            if (!in_array($fileType, array("image/jpeg", "image/png", "image/gif"))) {
                $status = "blocked";
            } else {
                // Verificar si existe el directorio de carga
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath);
                }

                // Generar un nombre único para el archivo
                $uniqueFileName = uniqid() . '.' . $fileExt;
                $uploadPath .= $uniqueFileName;

                // Mover el archivo subido al directorio de carga
                if (@move_uploaded_file($tmpName, $uploadPath)) {
                    $status = "success";
                    $uploadedFilePath = $uploadPath;
                } else {
                    $status = "unsuccess";
                }
            }
        }
    } else {
        $status = "empty";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['title']; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>

    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h1><?= $strings['title']; ?></h1>
                    <a href="delete.php"><button type="button" href="" class="btn btn-secondary btn-sm"><?= $strings['delete_button']; ?></button></a>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row pt-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                            <?= $strings['card_formats']; ?> <b><?= $strings['card_formats_type']; ?> </b>
                        </div>
                    </div>
                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>
                    <?php
                    if (isset($status)) {
                        if ($status == "success") {
                            echo '<div class="alert alert-success" role="alert">
                                <b>'.$strings['alert_success'].'</b> 
                                <hr>'.$strings['alert_success_file_path'].'<a class="text-success" href="'.$uploadedFilePath.'"> <b>'.$uploadedFilePath.'</b> </a> 
                                </div>';
                        }
                        if ($status == "unsuccess") {
                            echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_unsuccess'].'</b> 
                                </div>';
                        }
                        if ($status == "blocked") {
                            echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_blocked'].'</b> <hr>'.$strings['alert_blocked_type'].'</div>';
                        }
                        if ($status == "empty") {
                            echo '<div class="alert alert-danger" role="alert">
                                <b>'.$strings['alert_empty'].'</b> 
                                </div>';
                        }
                    }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="input_image" class="form-label"><?= $strings['input_label']; ?></label>
                            <input class="form-control" type="file" id="input_image" name="input_image"> 
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="7" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
