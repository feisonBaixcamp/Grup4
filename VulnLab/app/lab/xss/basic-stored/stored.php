<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

// Manejo de Sesiones
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['del'])) {
    // Evitar SQL Injection en DELETE
    $q = $db->prepare("DELETE FROM `mandalorian_content` WHERE 1");
    $q->execute();

    // Redirigir después de operación POST
    header("Location: stored.php");
    exit;
}

if (isset($_POST['mes'])) {
    // Evitar SQL Injection en INSERT
    $q = $db->prepare("INSERT INTO mandalorian_content (username,content) VALUES (:username,:message)");
    $q->execute(array(
        "username" => $_SESSION['username'],
        "message" => $_POST['mes'],
    ));

    // Redirigir después de operación POST
    header("Location: stored.php");
    exit;
}
?>

<!DOCTYPE html>
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
    <div class="alert alert-primary d-flex justify-content-center" style="text-align: center;width: fit-content;margin: auto;margin-top: 3vh;">
        <h6><?php echo htmlspecialchars($strings['text']); ?></h6>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="wrapper col-md-6  shadow-lg" style="border-radius: 15px; margin-top: 4vh;">
            <div class="shadow-sm m-2 scrollspy-example chat-log d-flex flex-column justify-content-end align-items-end overflow-auto" style="min-height: 350px;border: rgb(206, 206, 206) 1px solid; border-radius: 15px;" data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" tabindex="0">
                <?php
                // SQL Injection: Evitar repetir la llamada a fetch
                $q = $db->query("SELECT * FROM mandalorian_content");
                if ($q) {
                    while ($cikti = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="msg col-md-6 m-3 px-4 bg-primary text-wrap " style="border-radius: 20px; padding: 5px;width: fit-content;color: aliceblue;">';
                        echo htmlspecialchars($cikti['content']);
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="p-3 pb-0" style="text-align: center;">
                <form action="#" method="POST" style="margin: 0;">
                    <textarea placeholder="<?php echo htmlspecialchars($strings['message']); ?>" class="form-control" rows="3" name="mes"></textarea>
                    <button type="submit" class="btn btn-primary m-3"><?php echo htmlspecialchars($strings['submit']); ?></button>
                </form>
            </div>
        </div>
    </div>
    <form action="#" method="POST">
        <button type="submit" name="del" class="btn btn-primary m-3"><?php echo htmlspecialchars($strings['delete']); ?></button>
    </form>

    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
