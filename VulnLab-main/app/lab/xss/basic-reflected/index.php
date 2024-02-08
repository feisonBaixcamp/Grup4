<?php
require("../../../lang/lang.php");
$strings = tr();

// Función para escapar y representar de forma segura los datos
function safe_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
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
  <title><?php echo safe_output($strings['title']); ?></title>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center h-100 mx-auto">
    <?php

    if (isset($_GET['q'])) {
      $q = safe_output($_GET['q']);
      echo '<div class="alert alert-danger" style="margin-top: 30vh;" role="alert" >';
      echo safe_output($strings['text']) . ' <b>' . $q . ' </b> ';
      echo '<a href="index.php">' . safe_output($strings['try']) . '</a>';
      echo "</div>";
    } else {
      echo '<form method="GET" action="#" style="margin-top: 30vh;" class="row g-3 col-md-6 row justify-content-center mx-auto">';
      echo '<input class="form-control" type="text" placeholder="' . safe_output($strings['search']) . '" name="q">';
      echo '<button type="submit" class="col-md-3 btn btn-primary mb-3">' . safe_output($strings['s_button']) . '</button>';
      echo '</form>';
    }

    ?>

  </div>

  <script id="VLBar" title="<?= safe_output($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>

</body>

</html>
