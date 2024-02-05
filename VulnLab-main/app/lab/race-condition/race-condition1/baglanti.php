<?php
$lockFile = 'connection.lock';

// Intentar obtener un bloqueo exclusivo
$lock = fopen($lockFile, 'w');

if (flock($lock, LOCK_EX)) {
    try {
        $db = new PDO('sqlite:database.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
        die();
    }

    // Liberar el bloqueo
    flock($lock, LOCK_UN);
} else {
    echo "No se pudo obtener el bloqueo.";
    die();
}

fclose($lock);
?>
