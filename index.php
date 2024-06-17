<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Главная</a>
            </li>
            <li class="nav-item">
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

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/slide1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Добро пожаловать в Кафе Фреш</h5>
                <p>Насладитесь вкусной и свежей едой.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slide2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Уютная атмосфера</h5>
                <p>Лучшее место для встреч и отдыха.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slide3.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Широкий выбор блюд</h5>
                <p>Откройте для себя разнообразие нашего меню.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="container mt-5">
    <div class="featurette">
        <div class="row">
            <div class="col-md-7">
                <h2 class="featurette-heading">Наше меню <span class="text-muted">Вкусно и разнообразно.</span></h2>
                <p class="lead">Откройте для себя разнообразие нашего меню, включающее свежие и здоровые блюда, приготовленные с любовью.</p>
                <a class="btn btn-info" href="menu.php">Посмотреть меню</a>
            </div>
            <div class="col-md-5">
                <img src="img/menu.jpg" class="featurette-image img-fluid mx-auto" alt="Меню">
            </div>
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="featurette">
        <div class="row">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">О нас <span class="text-muted">Наша история.</span></h2>
                <p class="lead">Кафе Фреш – это уютное место, где вы можете насладиться вкусной едой и приятной атмосферой. Мы заботимся о каждом клиенте и стремимся сделать ваше посещение незабываемым.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="img/about.jpg" class="featurette-image img-fluid mx-auto" alt="О нас">
            </div>
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="featurette">
        <div class="row">
            <div class="col-md-7">
                <h2 class="featurette-heading">Отзывы <span class="text-muted">Наши клиенты говорят.</span></h2>
                <p class="lead">Мы гордимся отзывами наших клиентов. Прочитайте, что они говорят о нас, и убедитесь сами.</p>
                <a class="btn btn-info" href="https://yandex.ru/maps/?ll=38.200149%2C55.836870&mode=poi&poi%5Bpoint%5D=38.199961%2C55.836944&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D238585214968&tab=reviews&z=21">Оставить отзыв</a>
            </div>
            <div class="col-md-5">
                <img src="img/reviews.jpg" class="featurette-image img-fluid mx-auto" alt="Отзывы">
            </div>
        </div>
    </div>

    <hr class="featurette-divider">
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