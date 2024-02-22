<?php

require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db'); 

session_start();
// Assuming a user's session is established with login, we use session to securely fetch the user's ID.
$user_id = $_SESSION['user_id'] ?? null;

if(isset($_POST['view'])){
    header("Location: index.php?invoice_id=" . urlencode($user_id));
}

if(isset($_GET['invoice_id'])){ 
    // Validate that the invoice belongs to the user
    $query = $db->prepare("SELECT * FROM idor_invoices WHERE id=:id AND user_id=:user_id");
    $query->execute([
        'id' => $_GET['invoice_id'],
        'user_id' => $user_id
    ]);
    $row = $query->fetch();

    if($row){
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=invoice.pdf");
        @readfile($row['file_url']);
    } else {
        // Handle unauthorized access or invoice not found
        echo "Unauthorized access or invoice not found.";
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
        
            <div class="row pt-5 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <h1><?= $strings['title']; ?></h1>
                    
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row pt-2">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="card border-primary mb-4">
                        <div class="card-header text-primary">
                            <?= $strings['card_alert']; ?>
                        </div>
                    </div>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?></h3>

                    <form action="" method="post">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="view"><?= $strings['button']; ?></button>
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
