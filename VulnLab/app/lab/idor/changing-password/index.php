<?php

require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');    

session_start();
// Assuming a user's session is established with login, we use session to securely fetch the user's ID.
$user_id = $_SESSION['user_id'] ?? null;

$query = $db->prepare("SELECT * FROM idor_changing_password WHERE id=:user_id");
$query->execute([
    'user_id' => $user_id
]);
$user_info = $query->fetch();
$your_username = $user_info['username'];

if(isset($_POST['password'])){
    // The password change request now only applies to the logged-in user, removing the ability to specify a different user_id
    $new_password = $_POST['password'];
    
    $query3 = $db->prepare("UPDATE idor_changing_password SET password=:new_password WHERE id=:user_id ");
    $update = $query3->execute([
        'user_id' => $user_id,
        'new_password' => $new_password
    ]);

    if($update){
        $message1 = '<div class="alert alert-success" role="alert"> <b>'.$strings['alert_success'].'</b> <br> <hr>'
        .'<b>'.$your_username.'</b>'.$strings['success_username'].'<br>'
        .'</div>';
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
        
            <div class="row pt-5 mt-5 mb-3">
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
                        <?= $strings['card_username']; ?> <b> <?php echo $your_username; ?> </b> 
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <?php 
                    if(isset($message1)){
                        echo $message1;
                    }
                    ?>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="password" class="form-label"><?= $strings['input_label']; ?></label>
                            <input class="form-control" type="password" name="password" id="password" placeholder="<?= $strings['input_placeholder']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>

                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="3" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
