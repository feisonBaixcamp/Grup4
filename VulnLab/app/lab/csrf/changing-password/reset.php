<?php

$db = new PDO('sqlite:database.db');

for ($id = 1; $id <= 2; $id++) {
    switch ($id) {
        case 1:
            $password = "3cc22e4367e2d2525ea28a7d33731c12";
            break;
        case 2:
            $password = "user";
            break;
    }

    $query = $db->prepare("UPDATE csrf_changing_password SET password=:password WHERE id=:id");
    $query->execute(array(
        'id' => $id,
        'password' => $password
    ));
}

// Truncate the csrf_chat table instead of dropping and recreating it
$queryTruncate = $db->prepare('DELETE FROM csrf_chat');
$queryTruncate->execute();

header("Location: index.php");
exit;

?>
