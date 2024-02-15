<?php
require("../../../lang/lang.php");
$strings = tr();
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
    <div class="container d-flex justify-content-center p-4">
        <div class="wrapper d-flex flex-column justify-content-center align-items-center shadow rounded p-5 mb-5" style="margin-top: 15vh;max-width: 50vw;">
            <div class="headerx row">
                <h4><?php echo htmlspecialchars($strings['text']); ?></h4>
            </div>
            <div class="bodyx row p-4">
                <form id="nameForm" class="">
                    <label for="name" class="form-label"><?php echo htmlspecialchars($strings['name']); ?></label>
                    <input type="text" name="name" id="nameInput" class="form-control" readonly>
                    <button type="submit" class="btn btn-success " style="margin-top: 10px;"><?php echo htmlspecialchars($strings['button']); ?></button>
                </form>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center ">
        <?php
        if (isset($_GET['name'])) {
            $ticketname = htmlspecialchars($_GET['name']);
            echo '<div class="ticket alert alert-primary" style="max-width: 50vw;"><h6><a href="ticket.php?name=' . $ticketname . '"> ' . htmlspecialchars($strings['gate']) . ' </a></h6></div>';
        }
        ?>
    </div>
    <script>
        // Script para manipular el formulario y redireccionar
        document.getElementById('nameForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario
            var name = document.getElementById('nameInput').value; // Obtener el valor del campo de entrada
            window.location.href = 'ticket.php?name=' + name; // Redireccionar a ticket.php con el nombre como parámetro
        });
    </script>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
