-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 13 2024 г., 11:42
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cafe_fresh`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `dish_img` varchar(255) NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `dishes`
--

INSERT INTO `dishes` (`id`, `dish_img`, `dish_name`, `price`, `description`) VALUES
(1, 'plov.jpg', 'Плов с индейкой', 260.00, 'Плов с индейкой'),
(2, 'vok-more.jpg', 'Вок с морепродуктами', 400.00, 'Вок с морепродуктами'),
(3, 'vok-kur.jpg', 'Вок с курицей', 350.00, 'Вок с курицей'),
(4, 'vok-krevet.jpg', 'Вок с креветками', 400.00, 'Вок с креветками'),
(5, 'manti.jpg', 'Манты', 70.00, 'Манты'),
(6, 'mors.jpg', 'Морс из черной смородины', 60.00, 'Морс из черной смородины'),
(7, 'rolls.jpg', 'Роллы Калифорния', 490.00, 'Роллы Калифорния'),
(8, 'misosoupe.jpg', 'Мисо суп', 280.00, 'Мисо суп'),
(9, 'mohito.jpg', 'Мохито классический', 200.00, 'Мохито классический'),
(10, 'mohitoklub.jpg', 'Мохито клубничный', 230.00, 'Мохито клубничный'),
(11, 'molkokt.jpg', 'Молочный коктейль', 200.00, 'Молочный коктейль'),
(12, 'pizzamyaso.jpg', 'Пицца мясная', 399.00, 'Пицца мясная'),
(13, 'pokelosos.jpg', 'Поке с лососем', 450.00, 'Поке с лососем'),
(14, 'pokekrevetki.jpg', 'Поке с лососем и креветками', 500.00, 'Поке с лососем и креветками'),
(15, 'hachapuri.jpg', 'Хачапури по-аджарски', 550.00, 'Хачапури по-аджарски'),
(16, 'cezar.jpeg', 'Салат Цезарь', 200.00, 'Салат Цезарь'),
(17, 'coffee.jpg', 'Кофе', 150.00, 'Кофе'),
(18, 'чай.jpeg', 'Чай', 135.00, 'Чай'),
(19, 'icecream.jpg', 'Мороженое', 200.00, 'Мороженое');

-- --------------------------------------------------------

--
-- Структура таблицы `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `order_id`, `dish_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 3),
(3, 3, 5, 2),
(4, 3, 6, 1),
(5, 4, 1, 1),
(6, 4, 2, 1),
(7, 4, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(1, 1, 590.00, '2024-06-12 15:11:38'),
(2, 1, 1770.00, '2024-06-12 15:31:15'),
(3, 1, 200.00, '2024-06-12 17:17:42'),
(4, 2, 1010.00, '2024-06-12 17:28:46');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `email`, `role`) VALUES
(1, 'test', 'test test test', '$2y$10$a26579hc02FSo.ocoJz5Ce.APyiKOe9dL1wQoqlC.lBbj1/w.VxtS', 'test@test.ru', 'user'),
(2, 'haezzzer', 'эщев эщ эщович', '$2y$10$WcSBMQ9kEzWyhYZ6gFml2.OSPAHqDBTIQCeJRAT3dVnOjRUa14HMe', 'eshesh@mail.ru', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Индексы таблицы `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `dish_id` (`dish_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`);

--
-- Ограничения внешнего ключа таблицы `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
