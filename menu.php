<?php
session_start();

require 'php/db.php';

// Запрос для получения всех блюд
$sql = "SELECT * FROM Dishes";
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Кафе Фреш</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Главная </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="menu.php">Меню</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Контакты</a>
            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Корзина</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="php/logout.php">Выйти</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Войти</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1><center>Меню</center></h1>
    <div class="row">
        <?php
        // Проверяем, есть ли блюда
        if ($result->rowCount() > 0) {
            // Если есть, выводим их
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <img src="img/<?php echo $row['dish_img']; ?>" class="card-img-top" alt="<?php echo $row['dish_name']; ?> width="100px" height="300px">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['dish_name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text"><strong>Цена: <?php echo $row['price']; ?> руб.</strong></p>
                            <a href="php/add_to_cart.php?dish_id=<?php echo $row['id']; ?>&quantity=1" class="btn btn-primary btn-info">Добавить в корзину</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            // Если блюд нет, выводим сообщение
            echo "Нет блюд в меню.";
        }
        ?>
    </div>
</div>

<footer class="bg-light text-center text-lg-start">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Кафе Фреш</h5>
                <p>
                    Добро пожаловать в Кафе Фреш! Мы рады предложить вам вкусную еду и отличное обслуживание.
                </p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Навигация</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="index.php" class="text-dark">Главная</a>
                    </li>
                    <li>
                        <a href="menu.php" class="text-dark">Меню</a>
                    </li>
                    <li>
                        <a href="contact.php" class="text-dark">Контакты</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Контакты</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="#!" class="text-dark">+7 (915) 275-69-41</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">info@cafefresh.ru</a>
                    </li>
                    <li>
                        <a href="#!" class="text-dark">Авиационная ул., 2Б, рабочий посёлок Монино, Россия</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center p-3 bg-dark text-white">
        © 2023 Кафе Фреш
    </div>
</footer>
</body>
</html>
