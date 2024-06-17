<?php
session_start();

require 'php/db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

// Получаем ID пользователя из сессии
$user_id = $_SESSION['user_id'];

// Инициализируем переменную для сообщения о заказе
$order_message = "";

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Если был отправлен запрос на удаление товара из корзины
    if (isset($_POST['remove_product_id'])) {
        $remove_product_id = $_POST['remove_product_id'];

        // Удаляем товар из корзины
        $delete_stmt = $pdo->prepare("DELETE FROM Cart WHERE user_id = :user_id AND dish_id = :dish_id");
        $delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $delete_stmt->bindParam(':dish_id', $remove_product_id, PDO::PARAM_INT);
        $delete_stmt->execute();
        
        // Перенаправляем пользователя на страницу корзины
        header("Location: cart.php");
        exit;
    } elseif (isset($_POST['update_product_id']) && isset($_POST['action'])) {
        // Если был отправлен запрос на изменение количества товара в корзине
        $update_product_id = $_POST['update_product_id'];
        $action = $_POST['action'];
    
        // Получаем текущее количество товара в корзине
        $current_quantity_stmt = $pdo->prepare("SELECT quantity FROM Cart WHERE user_id = :user_id AND dish_id = :product_id");
        $current_quantity_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $current_quantity_stmt->bindParam(':product_id', $update_product_id, PDO::PARAM_INT);
        $current_quantity_stmt->execute();
        $current_quantity_row = $current_quantity_stmt->fetch(PDO::FETCH_ASSOC);
    
        // Если удалось получить текущее количество товара
        if ($current_quantity_row) {
            $current_quantity = $current_quantity_row['quantity'];
    
            // Увеличиваем или уменьшаем количество товара в зависимости от действия
            if ($action == "increase") {
                $new_quantity = $current_quantity + 1;
            } elseif ($action == "decrease") {
                $new_quantity = max(1, $current_quantity - 1);
            }
    
            // Обновляем количество товара в корзине
            $update_stmt = $pdo->prepare("UPDATE Cart SET quantity = :quantity WHERE user_id = :user_id AND dish_id = :dish_id");
            $update_stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
            $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $update_stmt->bindParam(':dish_id', $update_product_id, PDO::PARAM_INT);
            $update_stmt->execute();
            
            // Перенаправляем пользователя на страницу корзины
            header("Location: cart.php");
            exit;
        }
    } elseif (isset($_POST['total_price'])) {
        // Получаем общую сумму заказа из POST-запроса
        $total_price = $_POST['total_price'];

        // Проверяем, что корзина не пуста
        $cart_check_stmt = $pdo->prepare("SELECT COUNT(*) AS cart_count FROM Cart WHERE user_id = :user_id");
        $cart_check_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $cart_check_stmt->execute();
        $cart_count_row = $cart_check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_count_row['cart_count'] == 0) {
            // Если корзина пуста, выведите сообщение об ошибке или выполните необходимые действия
            $order_message = "Ваша корзина пуста. Пожалуйста, добавьте товары в корзину перед оформлением заказа.";
        } else {
            // Начинаем транзакцию для оформления заказа
            $pdo->beginTransaction();

            try {
                // Вставляем новую запись в таблицу "Orders"
                $order_insert_stmt = $pdo->prepare("INSERT INTO Orders (user_id, total_price) VALUES (:user_id, :total_price)");
                $order_insert_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $order_insert_stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
                $order_insert_stmt->execute();
                $order_id = $pdo->lastInsertId(); // Получаем ID нового заказа

                // Получаем товары из корзины и добавляем их в таблицу "OrderDetails"
                $cart_select_stmt = $pdo->prepare("SELECT dish_id, quantity FROM Cart WHERE user_id = :user_id");
                $cart_select_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $cart_select_stmt->execute();

                while ($row = $cart_select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dish_id = $row['dish_id'];
                    $quantity = $row['quantity'];

                    // Вставляем запись в таблицу "OrderDetails"
                    $order_details_insert_stmt = $pdo->prepare("INSERT INTO OrderDetails (order_id, dish_id, quantity) VALUES (:order_id, :dish_id, :quantity)");
                    $order_details_insert_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                    $order_details_insert_stmt->bindParam(':dish_id', $dish_id, PDO::PARAM_INT);
                    $order_details_insert_stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                    $order_details_insert_stmt->execute();
                }

                // Очищаем корзину пользователя
                $cart_delete_stmt = $pdo->prepare("DELETE FROM Cart WHERE user_id = :user_id");
                $cart_delete_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $cart_delete_stmt->execute();

                // Подтверждаем транзакцию
                $pdo->commit();

                $order_message = "Заказ успешно оформлен!";
            } catch (PDOException $e) {
                // В случае ошибки откатываем транзакцию и выводим сообщение об ошибке
                $pdo->rollBack();
                $order_message = "Не удалось оформить заказ: " . $e->getMessage();
            }
        }
    }
}

// Подготавливаем запрос для получения товаров в корзине пользователя
$stmt = $pdo->prepare("SELECT Dishes.id, Dishes.dish_name, Dishes.price, Cart.quantity FROM Cart JOIN Dishes ON Cart.dish_id = Dishes.id WHERE Cart.user_id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
// Инициализируем переменную для общей суммы заказа
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Контакты</a>
            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link active" href="cart.php">Корзина</a>
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
    <h1>Ваша корзина</h1>
    <?php if ($order_message): ?>
        <div class="alert alert-info">
            <?php echo $order_message; ?>
        </div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['dish_name']; ?></td>
                <td><?php echo $row['price']; ?> рублей</td>
                <td>
                    <form action="cart.php" method="post" class="d-inline-block">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit" class="btn btn-outline-info btn-sm">-</button>
                    </form>
                    <?php echo $row['quantity']; ?>
                    <form action="cart.php" method="post" class="d-inline-block">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="increase">
                        <button type="submit" class="btn btn-outline-info btn-sm">+</button>
                    </form>
                </td>
                <td><?php echo $row['price'] * $row['quantity']; ?> рублей</td>
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="remove_product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php $total_price += $row['price'] * $row['quantity']; ?>
        <?php endwhile; ?>
        </tbody>
    </table>
    <h2>Общая сумма: <?php echo $total_price; ?> рублей</h2>
    <form action="cart.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <button type="submit" class="btn btn-info">Оформить заказ</button>
    </form>
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
