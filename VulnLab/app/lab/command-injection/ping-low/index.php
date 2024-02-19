<?php
require("../../../lang/lang.php");

$strings = tr();

?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title><?= $strings['ping_title']; ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
    <div class="container text-center">
        <div class="main-wrapper" style="margin-top: 25vh;">
            <div class="header-wrapper">
                <h2 class="col"><?= $strings['ping_title']; ?></h2>
            </div>
            <div class="col-md-auto mt-3 d-flex justify-content-center">
                <form method="POST" class="flex-column">
                    <input class="form-control" type="text" name="ip" style="width: 500px;" placeholder="<?= $strings['ip_placeholder']; ?>">
                    <button type="submit" class="btn btn-primary mt-4" style="width: 500px;"><?= $strings['ping_button']; ?></button>
                </form>
            </div>

            <div class="col-md-auto d-flex justify-content-center" style="">
                <?php
                // Comprova si s'ha enviat la IP
                if (isset($_POST["ip"])) {
                    // Utilitza "strip_tags" per prevenir possibles atacs XSS
                    $input = strip_tags($_POST["ip"]);
                    echo "<br /><br />";

                    // Utilitza "escapeshellarg" per evitar la injecció de comandes
                    exec("ping -c5 " . escapeshellarg($input), $out);

                    if (!empty($out)) {
                        // Mostra la resposta del ping
                        echo '<div class="mt-5 alert alert-primary" role="alert" style="width:500px;" > <strong>  <p style="text-align:center;">';
                        foreach ($out as $line) {
                            // Utilitza "htmlentities" per prevenir possibles atacs XSS
                            echo htmlentities($line);
                            echo "<br>";
                        }
                        echo ' </p></strong></div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title1'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
