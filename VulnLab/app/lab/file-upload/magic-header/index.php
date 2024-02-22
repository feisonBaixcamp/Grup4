<?php
require("../../../lang/lang.php");
$strings = tr();

if (isset($_POST['submit'])) {
    if (isset($_FILES['input_image']) && $_FILES['input_image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['input_image']['tmp_name'];
        $fileName = $_FILES['input_image']['name'];

        $allowedExtensions = array("gif", "png", "jpeg");
        $maxFileSize = 1048576; // 1 MB

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uploadPath = "uploads/" . basename($fileName);

        if (!in_array($fileExt, $allowedExtensions)) {
            $status = "blocked";
        } elseif ($_FILES['input_image']['size'] > $maxFileSize) {
            $status = "oversize";
        } elseif (!getimagesize($tmpName)) {
            $status = "invalid_image";
        } elseif (!move_uploaded_file($tmpName, $uploadPath)) {
            $status = "unsuccess";
        } else {
            $status = "success";
        }
    } else {
        $status = "empty";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($strings['lang']); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($strings['title']); ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    
    <div class="container">

        <div class="container-wrapper">
            <div class="row pt-5 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h1><?= htmlspecialchars($strings['title']); ?></h1>
                    <a href="delete.php"><button type="button" href="" class="btn btn-secondary btn-sm"><?= htmlspecialchars($strings['delete_button']); ?></button></a>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row pt-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                        <?= htmlspecialchars($strings['card_formats']); ?> <b><?= htmlspecialchars($strings['card_formats_type']); ?> </b>
                        </div>
                    </div>
                    <h3 class="mb-3"><?= htmlspecialchars($strings['middle_title']); ?></h3>
                    <?php
                    if (isset($status)) {
                        if ($status == "success") {
                            echo '<div class="alert alert-success" role="alert">
                            <b>' . htmlspecialchars($strings['alert_success']) . '</b> 
                            <hr>' . htmlspecialchars($strings['alert_success_file_path']) . '<a class="text-success" href="' . htmlspecialchars($uploadPath) . '"> <b>' . htmlspecialchars($uploadPath) . '</b> </a> 
                            </div>';
                        } elseif ($status == "unsuccess") {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>' . htmlspecialchars($strings['alert_unsuccess']) . '</b> 
                            </div>';
                        } elseif ($status == "blocked") {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>' . htmlspecialchars($strings['alert_blocked']) . '</b> <hr>' . htmlspecialchars($strings['alert_blocked_type']) . '
                            </div>';
                        } elseif ($status == "empty") {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>' . htmlspecialchars($strings['alert_empty']) . '</b> 
                            </div>';
                        } elseif ($status == "oversize") {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>File size exceeds the maximum limit</b> 
                            </div>';
                        } elseif ($status == "invalid_image") {
                            echo '<div class="alert alert-danger" role="alert">
                            <b>Invalid image file</b> 
                            </div>';
                        }
                    }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="input_image" class="form-label"><?= htmlspecialchars($strings['input_label']); ?></label>
                            <input class="form-control" type="file" id="input_image" name="input_image"> 
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit"><?= htmlspecialchars($strings['button']); ?></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title']); ?>" category-id="7" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
