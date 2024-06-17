<?php
$db = 'mysql:host=localhost;dbname=cafe_fresh;charset=utf8';
$username = 'root';
$password = '';

try{
    $pdo = new PDO($db, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Ошибка подключения: ' . $e->getMessage();
    exit();
}
?>