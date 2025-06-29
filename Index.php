<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=plant_db', 'root', '');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>