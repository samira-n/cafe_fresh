<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

require 'db.php';

if (isset($_GET['dish_id']) && isset($_GET['quantity'])) {
    $dish_id = $_GET['dish_id'];
    $quantity = $_GET['quantity'];

    // Проверяем, существует ли уже этот товар в корзине пользователя
    $sql_check = "SELECT * FROM Cart WHERE user_id = :user_id AND dish_id = :dish_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_check->bindParam(':dish_id', $dish_id, PDO::PARAM_INT);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Если товар уже есть в корзине, обновляем количество
        $sql_update = "UPDATE Cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND dish_id = :dish_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt_update->bindParam(':dish_id', $dish_id, PDO::PARAM_INT);
        $stmt_update->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt_update->execute();
    } else {
        // Если товара нет в корзине, добавляем его
        $sql_insert = "INSERT INTO Cart (user_id, dish_id, quantity) VALUES (:user_id, :dish_id, :quantity)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt_insert->bindParam(':dish_id', $dish_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt_insert->execute();
    }

    // Перенаправляем пользователя обратно на страницу меню
    header("Location: ../menu.php");
    exit();
} else {
    // Если не переданы необходимые данные, выводим сообщение об ошибке
    echo "Ошибка: недостаточно данных для добавления в корзину.";
}
?>
