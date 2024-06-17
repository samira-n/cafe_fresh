<?php
session_start();

require 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare('INSERT INTO users (username, fullname, email, password) VALUES (?, ?, ?, ?)');
    if($stmt->execute([$username, $fullname, $email, $password])){
        header('Location: ../login.html');
        exit();
    } else {
        echo 'Ошибка регистрации';
    }
}
?>