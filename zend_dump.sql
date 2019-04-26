-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 22 2019 г., 14:30
-- Версия сервера: 5.7.25-0ubuntu0.16.04.2
-- Версия PHP: 7.1.26-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `zend`
--
CREATE DATABASE IF NOT EXISTS `zend` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zend`;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `city`) VALUES
(17, 'Acapulco'),
(18, 'Barcelona'),
(6, 'Beijing'),
(7, 'Berlin'),
(5, 'Bern'),
(11, 'Boston'),
(4, 'Chita'),
(22, 'City'),
(14, 'Lissabonв'),
(1, 'London'),
(9, 'Los Angeles'),
(13, 'Manila'),
(8, 'Moscow'),
(20, 'Munchen'),
(2, 'Paris'),
(16, 'Reikjavik'),
(12, 'Rome'),
(10, 'Sacramento'),
(19, 'Sankt-Petersburg'),
(3, 'Tokyo'),
(21, 'Warsava'),
(15, 'Zurich'),
(23, 'Проверка');

-- --------------------------------------------------------

--
-- Структура таблицы `customer_city`
--

CREATE TABLE `customer_city` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='связь пользователя с городами';

--
-- Дамп данных таблицы `customer_city`
--

INSERT INTO `customer_city` (`id`, `customer_id`, `city_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 3, 1),
(5, 3, 5),
(6, 4, 2),
(7, 4, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `name`) VALUES
(1, 'Michael'),
(2, 'Valento'),
(3, 'Ruby'),
(4, 'V.Nord'),
(5, 'Evance Baudes'),
(6, 'Dr. Paul'),
(7, 'Mitchell'),
(8, 'Stephan Shepard'),
(9, 'R.D. Brown');

-- --------------------------------------------------------

--
-- Структура таблицы `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grade` enum('среднее','бакалавр','магистр','ученая степень') NOT NULL DEFAULT 'среднее'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `grades`
--

INSERT INTO `grades` (`id`, `user_id`, `grade`) VALUES
(1, 9, 'ученая степень'),
(2, 1, 'бакалавр'),
(3, 2, 'магистр'),
(4, 6, 'магистр'),
(5, 3, 'бакалавр'),
(6, 4, 'бакалавр'),
(7, 5, 'магистр'),
(8, 7, 'среднее'),
(9, 8, 'ученая степень');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city` (`city`);

--
-- Индексы таблицы `customer_city`
--
ALTER TABLE `customer_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `customer_city`
--
ALTER TABLE `customer_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `customer_city`
--
ALTER TABLE `customer_city`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk101` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Ограничения внешнего ключа таблицы `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`user_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
