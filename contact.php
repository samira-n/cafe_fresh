<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">Кафе Фреш</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php">Меню</a>
                </li>
                <li class="nav-item active">
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
        <h1 class="mb-4">Свяжитесь с нами</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Наши контакты</h2>
                <p><strong>Адрес:</strong> Авиационная ул., 2Б, рабочий посёлок Монино, Россия</p>
                <p><strong>Телефон:</strong> +7 (915) 275-69-41</p>
                <p><strong>Часы работы:</strong></p>
                <ul>
                    <li>Понедельник - Четверг: 8:00 - 21:00</li>
                    <li>Пятница - Воскресенье: 09:00 - 23:00</li>
                </ul>
            </div>
        </div>

        <div class="mt-5">
            <h2>Наше местоположение</h2>
            <div class="embed-responsive embed-responsive-16by9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2240.6368168898643!2d38.19533867740849!3d55.83426287311449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x414ad05224f38d8b%3A0x61ffbd862b5cd7ce!2z0JDQstC40LDRhtC40L7QvdC90LDRjyDRg9C7LiwgMiwg0JzQvtC90LjQvdC-LCDQnNC-0YHQutC-0LLRgdC60LDRjyDQvtCx0LsuLCDQoNC-0YHRgdC40Y8sIDE0MTE3MA!5e0!3m2!1sru!2sus!4v1718212369642!5m2!1sru!2sus" width="300" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
