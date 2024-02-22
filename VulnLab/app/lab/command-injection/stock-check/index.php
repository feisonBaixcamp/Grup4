<?php
require("../../../lang/lang.php");

$strings = tr();

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title><?= $strings['title'] ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row pt-5 mt-2" style="margin-left: 140px;">
            <h1><?= $strings['title'] ?></h1>
        </div>
        <div class="row pt-2 mt-5 " style="margin-left: 200px;">
            <div class="col-md-4">
                <img src="images/resim.jpg" style="width: 140px" alt="<?= $strings['image_alt'] ?>"></a>
            </div>
            <div class="col-md-4">
                <img src="images/resim2.jpg" style="width: 140px" alt="<?= $strings['image_alt'] ?>"></a>
            </div>
            <div class="col-md-4">
                <img src="images/resim3.jpg" style="width: 130px" alt="<?= $strings['image_alt'] ?>"></a>
            </div>
        </div>

        <div class="row pt-5" style="margin-left: 230px;">
            <div class="col-md-4">
                <a class="btn btn-primary" href="?product_id=1" role="button" style="margin-right: 20px"><?= $strings['button'] ?></a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary" href="?product_id=2" role="button" style="margin-left: 15px"><?= $strings['button'] ?></a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary" href="?product_id=3" role="button" style="margin-left: 30px"><?= $strings['button'] ?></a>
            </div>
        </div>

        <div class="row pt-2 mt-5 mb-3" style="margin-right: 70px;">
            <div class="col-md-5" style="margin-left: 150px;">
                <?php
                // Comprova si s'ha rebut un paràmetre vàlid
                if (isset($_GET['product_id'])) {
                    // Utilitza "htmlspecialchars" per prevenir atacs XSS
                    $cmd = htmlspecialchars($_GET["product_id"]);
                    
                    // Utilitza "escapeshellarg" per evitar la injecció de comandes
                    $result = shell_exec("perl stok.pl " . escapeshellarg($cmd));

                    // Mostra el resultat amb un missatge informatiu
                    echo '<div class="alert alert-primary" role="alert" style="width:1000px;" > <strong>  <p style="text-align:center;">' . $strings['result'] . '' . $result . ' ' . $strings['pieces'] . '</p></strong></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
