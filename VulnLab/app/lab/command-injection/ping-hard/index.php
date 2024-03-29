<?php
require("../../../lang/lang.php");

$strings = tr();

?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $strings['title1']; ?></title>
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

            <div class="col-md-auto d-flex justify-content-center">
                <?php
                // Comprovar si s'ha enviat la IP
                if (isset($_POST["ip"])) {
                    $input = $_POST["ip"];

                    // Llista de paraules prohibides
                    $blacklists = array(" ", "&", ";", "@", "%", "^", "'", "<", ">", ",", "\\", "/", "ls", "cat", "less", "tail", "more", "whoami", "pwd", "echo", "ps");

                    $status = 0;

                    // Comprovar si la IP no conté paraules prohibides
                    foreach ($blacklists as $blacklist) {
                        if (!stristr($input, $blacklist)) {
                            $status++;
                        }
                    }

                    // Si la IP és vàlida, fer un ping
                    if (count($blacklists) === $status) {
                        exec("ping -c5 " . escapeshellarg($input), $out);

                        if (!empty($out)) {
                            echo '<div class="mt-5 alert alert-primary" role="alert" style="width:500px;"> <strong>  <p style="text-align:center;">';
                            foreach ($out as $line) {
                                echo htmlentities($line) . "<br>"; // Evitar possibles vulnerabilitats XSS
                            }
                            echo ' </p></strong></div>';
                        }
                    } else {
                        echo '<div class="mt-5 alert alert-danger" role="alert" style="width:500px;"> <strong>  <p style="text-align:center;">' . $strings['error_message'] . '</p></strong></div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title1'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
