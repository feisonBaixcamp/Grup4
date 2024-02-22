<?php
$db = new PDO('sqlite:users.db');
$html = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Utiliza declaracions preparades per evitar injecció SQL
    $q = $db->prepare("SELECT * FROM users_ WHERE username=:user AND password=:pass");
    $q->execute(array(
        'user' => $_POST['username'],
        'pass' => $_POST['password']
    ));
    $_select = $q->fetch();

    if (isset($_select['id'])) {
        // Inicia sessió y estableix variables de sessió
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $html = $strings["cong"];
    } else {
        $html = $strings["wrong"];
    }
}
?>
