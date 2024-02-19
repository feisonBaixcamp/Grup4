<?php
    session_start();
    $_SESSION['authority'] = "user";
    $db = new PDO('sqlite:database.db');
    require("../../../lang/lang.php");
    $strings = tr();
    $selectUser = $db->prepare("SELECT * FROM csrf_money_transfer WHERE authority=:authority");
    $selectUser->execute(array('authority' => $_SESSION['authority']));
    $selectUser_Info = $selectUser->fetch();
    $selectUsers = $db->prepare("SELECT * FROM csrf_money_transfer");
    $selectUsers->execute();
    $selectUsers_Infos = $selectUsers->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['transfer_amount']) && isset($_GET['receiver'])) {
        if ($_GET['transfer_amount'] > 0) {
            if ($selectUser_Info['money'] >= $_GET['transfer_amount']) {
                $sender_new_money = $selectUser_Info['money'] - $_GET['transfer_amount'];
                $sender_update = $db->prepare("UPDATE csrf_money_transfer SET money=:money WHERE authority=:authority");
                $status_sender_update = $sender_update->execute(array(
                    'authority' => $_SESSION['authority'],
                    'money' => $sender_new_money
                ));
                $selectReceiver = $db->prepare("SELECT * FROM csrf_money_transfer WHERE authority=:authority");
                $selectReceiver->execute(array('authority' => $_GET['receiver']));
                $selectReceiver_Info = $selectReceiver->fetch();
                $receiver_new_money = $selectReceiver_Info['money'] + $_GET['transfer_amount'];
                $receiver_update = $db->prepare("UPDATE csrf_money_transfer SET money=:money WHERE authority=:authority");
                $status_receiver_update = $receiver_update->execute(array(
                    'authority' => $_GET['receiver'],
                    'money' => $receiver_new_money
                ));
                if ($status_receiver_update && $status_sender_update) {
                    header("Location: index.php?status=success");
                    exit;
                } else {
                    header("Location: index.php?status=unsuccess");
                    exit;
                }
            } else {
                header("Location: index.php?status=no_money");
                exit;
            }
        } else {
            header("Location: index.php?status=wrong_entry");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">

<head>
    <!-- Your head content here -->
</head>

<body>
    <!-- Your body content here -->
</body>

</html>
