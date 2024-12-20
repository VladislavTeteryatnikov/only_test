-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 20 2024 г., 19:50
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
-- База данных: `only_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `connects`
--

CREATE TABLE `connects` (
  `connect_id` int(10) UNSIGNED NOT NULL,
  `connect_user_id` int(10) UNSIGNED NOT NULL,
  `connect_token` char(32) NOT NULL,
  `connect_token_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `connects`
--

INSERT INTO `connects` (`connect_id`, `connect_user_id`, `connect_token`, `connect_token_time`) VALUES
(2, 8, 'g551ecfe36854f42db16474d0806cf31', '2024-12-20 15:10:16'),
(8, 8, '36aeb1f46b2af08ga842e16d3fa21a87', '2024-12-20 20:38:24');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_password` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_login`, `user_phone`, `user_password`) VALUES
(1, 'dyliva@mailinator.com', 'Distinctio Id minim', '+1 (724) 472-69', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(2, 'guzeqofidu@mailinator.com', 'Minim rerum et volup', '+1 (655) 788-20', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(3, 'zisenyma@mailinator.com', 'Dolore consequatur ', '+1 (184) 791-48', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(4, 'sarabopop@mailinator.com', 'Doloribus quas aut m', '+1 (765) 772-62', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(5, 'patevamyxe@mailinator.com', 'Ea id voluptate veni', '+1 (669) 164-76', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(6, 'fejikyvyqe@mailinator.com', 'Et nobis neque odio ', '+1 (147) 345-48', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(7, 'gufimucel@mailinator.com', 'Aliquip fugit labor', '+1 (155) 978-39', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(8, '1234@mail.ru', 'login12', '111', '827ccb0eea8a706c4c34a16891f84e7b'),
(9, 'nobula@mailinator.com', 'Quia aliquip debitis', '+1 (681) 694-24', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(10, 'lypofo@mailinator.com', 'Quidem sint vel sequ', '+1 (748) 337-63', 'f3ed11bbdb94fd9ebdefbaf646ab94d3');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `connects`
--
ALTER TABLE `connects`
  ADD PRIMARY KEY (`connect_id`),
  ADD KEY `connect_user_id` (`connect_user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`user_email`),
  ADD UNIQUE KEY `login` (`user_login`),
  ADD UNIQUE KEY `number` (`user_phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `connects`
--
ALTER TABLE `connects`
  MODIFY `connect_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `connects`
--
ALTER TABLE `connects`
  ADD CONSTRAINT `connects_ibfk_1` FOREIGN KEY (`connect_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
