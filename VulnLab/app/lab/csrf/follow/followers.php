<?php
    ob_start();
    session_start();
    
    if (!isset($_SESSION['authority'])) {
        exit;
    }

    $db = new PDO('sqlite:database.db');
    
    require("../../../lang/lang.php");
    $strings = tr();
    
    $selectFollowers = $db->prepare("SELECT * FROM csrf_follow WHERE follow_status=:follow_status");
    $selectFollowers->execute(array('follow_status' => 'true'));
    $selectFollowers_Infos = $selectFollowers->fetchAll(PDO::FETCH_ASSOC);
    
    sleep(1);
    
    $id = 1;
    foreach ($selectFollowers_Infos as $selectFollowers_Info) {
        echo '<tr class="text-center">
        <th scope="row">' . $id . '</th>
        <td>' . htmlspecialchars($selectFollowers_Info['authority'], ENT_QUOTES, 'UTF-8') . '</td>
        </tr>';
        $id++;
    }
?>
