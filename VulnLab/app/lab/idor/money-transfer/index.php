<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');

session_start();
// Assuming session contains logged-in user ID
$user_id = $_SESSION['user_id'] ?? null;

$query = $db->prepare("SELECT * FROM idor_money_transfer WHERE id=:user_id");
$query->execute(['user_id' => $user_id]);
$active_row = $query->fetch();
$account_name = $active_row['name'];
$account_money = $active_row['money']; //active account

if (isset($_POST['transfer_amount']) && isset($_POST['recipient_id'])) {
    $transfer_amount = $_POST['transfer_amount'];
    $recipient_id = $_POST['recipient_id'];

    // Ensure transfer amount is a positive number
    if ($transfer_amount <= 0) {
        header("Location: index.php?message=wrong_entry");
        exit;
    }

    // Begin a transaction to ensure atomicity
    $db->beginTransaction();

    try {
        // Check sender's balance
        $sender_money = $active_row['money']; // Using active_row fetched earlier for sender's account
        if ($sender_money >= $transfer_amount) {
            // Update recipient's balance
            $query = $db->prepare("UPDATE idor_money_transfer SET money = money + :amount WHERE id = :recipient_id");
            $query->execute(['amount' => $transfer_amount, 'recipient_id' => $recipient_id]);

            if ($query->rowCount() == 0) {
                // Recipient not found or update failed
                throw new Exception("Recipient update failed");
            }

            // Update sender's balance
            $query = $db->prepare("UPDATE idor_money_transfer SET money = money - :amount WHERE id = :sender_id");
            $query->execute(['amount' => $transfer_amount, 'sender_id' => $user_id]);

            if ($query->rowCount() == 0) {
                // Sender update failed
                throw new Exception("Sender update failed");
            }

            $db->commit();
            header("Location: index.php?message=success");
            exit;
        } else {
            header("Location: index.php?message=no_money");
            exit;
        }
    } catch (Exception $e) {
        $db->rollBack();
        header("Location: index.php?message=transaction_failed");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['title']; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    
    <div class="container">

        <div class="container-wrapper">
        
            <div class="row pt-4 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <h1><?= $strings['title']; ?></h1>

                    <a href="reset.php"><button type="button" class="btn btn-secondary btn-sm"><?= $strings['reset_button']; ?></button></a>
                    
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row pt-2">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    
                    <div class="card border-primary mb-3">
                        <div class="card-header text-primary">
                            <?= $strings['card_name']; ?> <b> <?php echo $account_name; ?> </b> 
                            <br>
                            <?= $strings['card_money']; ?> <b> <?php echo $account_money; ?> <?= $strings['money_symbol']; ?> </b>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <?php 
                        if( isset($_GET['message']) ){
                            if($_GET['message'] == "wrong_entry"){
                                echo '<div class="alert alert-danger mt-2" role="alert">'
                                .$strings['alert_wrong_entry'].
                                '</div>';
                            }
                            if($_GET['message'] == "success"){
                                echo '<div class="alert alert-success" role="alert"> <b>'.$strings['alert_success'].'</b> <br> </div>';
                            }
                            if($_GET['message'] == "no_id"){
                                echo '<div class="alert alert-danger" role="alert"> <b>'.$strings['alert_no_id'].'</b> <br> </div>';
                            }
                           
