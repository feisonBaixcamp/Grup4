<?php

require("../../../lang/lang.php");
$strings = tr();

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);

    try {
        $db->beginTransaction();

        // Verificar si ya existe un registro con el mismo correo electrónico
        $kontrolSql = "SELECT * FROM kayit WHERE email = :email";
        $kontrolStmt = $db->prepare($kontrolSql);
        $kontrolStmt->bindParam(':email', $email);
        $kontrolStmt->execute();

        $results = $kontrolStmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            // Ya existe un registro con el mismo correo electrónico, emitir una advertencia.
            echo $strings['warning']; // Registro fallido: ¡Ya existe una cuenta con el correo electrónico registrado!
        } else {
            // No hay registro con el mismo correo electrónico, agregarlo.
            $ekleSql = "INSERT INTO kayit (ad, soyad, email, tel) VALUES (:ad, :soyad, :email, :tel)";
            $ekleStmt = $db->prepare($ekleSql);
            $ekleStmt->bindParam(':ad', $ad);
            $ekleStmt->bindParam(':soyad', $soyad);
            $ekleStmt->bindParam(':email', $email);
            $ekleStmt->bindParam(':tel', $tel);

            if ($ekleStmt->execute()) {
                $db->commit();
                echo $strings['successful']; // ¡Registro completado!
            } else {
                $db->rollBack();
                echo $strings['unsuccessful']; // Registro fallido.
            }
        }
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Bağlantı hatası: " . $e->getMessage();
    }

    $db = null;
}

if (isset($_POST['email'])) {
    session_start();
    $_SESSION['email'] = $_POST['email'];
}

?>

<!-- Resto del código HTML permanece sin cambios -->
