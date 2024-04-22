-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 22 2024 г., 10:12
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `station_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calls`
--

CREATE TABLE `calls` (
  `id_call` int NOT NULL,
  `id_user` int NOT NULL DEFAULT '1',
  `id_crew` int DEFAULT NULL,
  `id_patient` int DEFAULT NULL,
  `adress` text COLLATE utf8mb4_general_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `number` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `calls`
--

INSERT INTO `calls` (`id_call`, `id_user`, `id_crew`, `id_patient`, `adress`, `time`, `number`, `type`) VALUES
(1, 1, 456, 2, 'ул. Мира д.7', '2024-04-14 00:00:00', '+7900000001', 'Консультация'),
(2, 1, 111, 2, 'ЛД', '2024-04-14 19:59:53', '+79000452', 'смэрть'),
(3, 1, NULL, NULL, 'Ул Убийц д.666', '2024-04-15 19:36:09', '+7999999999', 'Консультация'),
(4, 1, NULL, NULL, 'Ул ЗЛАААА', '2024-04-15 20:34:15', '+7988888888', 'Консультация'),
(5, 1, NULL, 2, '', '2024-04-15 20:34:40', '', 'Консультация');

-- --------------------------------------------------------

--
-- Структура таблицы `crews`
--

CREATE TABLE `crews` (
  `id_crew` int NOT NULL,
  `id_driver` int NOT NULL,
  `id_doctor` int NOT NULL,
  `id_paramedic` int DEFAULT NULL,
  `id_orderly` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `crews`
--

INSERT INTO `crews` (`id_crew`, `id_driver`, `id_doctor`, `id_paramedic`, `id_orderly`) VALUES
(55, 3, 19, NULL, 4),
(111, 3, 18, 3, 4),
(456, 3, 18, NULL, 4),
(666, 3, 18, NULL, 4),
(777, 3, 18, NULL, 4),
(888, 3, 18, NULL, 4),
(999, 3, 18, NULL, 4),
(9991, 3, 18, NULL, 4),
(99912, 3, 18, NULL, 4),
(99913, 3, 18, NULL, 4),
(99914, 3, 18, NULL, 4),
(99915, 3, 18, NULL, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `number` text COLLATE utf8mb4_general_ci NOT NULL,
  `specialization` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `name`, `number`, `specialization`) VALUES
(18, 'Айболит', '+79004821224', 'Педиатр'),
(19, 'Биша Мари-Франсуа Ксавье sadsa', '+79991235421', 'Психиатр'),
(20, 'Джокушка Джокер', '+7993291312', 'Психиатр');

-- --------------------------------------------------------

--
-- Структура таблицы `drivers`
--

CREATE TABLE `drivers` (
  `id_drivers` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `phone` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `drivers`
--

INSERT INTO `drivers` (`id_drivers`, `name`, `phone`) VALUES
(3, 'Райан Гослинг', '+7 (993) 192-56-07');

-- --------------------------------------------------------

--
-- Структура таблицы `orderly`
--

CREATE TABLE `orderly` (
  `id_orderly` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `number` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orderly`
--

INSERT INTO `orderly` (`id_orderly`, `name`, `number`) VALUES
(4, 'Санитар', '+79004825606');

-- --------------------------------------------------------

--
-- Структура таблицы `paramedic`
--

CREATE TABLE `paramedic` (
  `id_paramedic` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `number` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `paramedic`
--

INSERT INTO `paramedic` (`id_paramedic`, `name`, `number`) VALUES
(3, 'Римма Николаевна', '+79165432424');

-- --------------------------------------------------------

--
-- Структура таблицы `patient`
--

CREATE TABLE `patient` (
  `id_patient` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `number` text COLLATE utf8mb4_general_ci NOT NULL,
  `adress` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `patient`
--

INSERT INTO `patient` (`id_patient`, `name`, `number`, `adress`) VALUES
(2, 'Аксёнов Пётр', '+79000012312', 'ул. Победы д.6');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `name`, `login`, `password`, `role`) VALUES
(1, 'Админ Админыч', 'admin', 'admin', 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id_call`),
  ADD KEY `id_crew` (`id_crew`),
  ADD KEY `id_patient` (`id_patient`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `crews`
--
ALTER TABLE `crews`
  ADD PRIMARY KEY (`id_crew`),
  ADD KEY `id_doctor` (`id_doctor`),
  ADD KEY `id_driver` (`id_driver`),
  ADD KEY `id_orderly` (`id_orderly`),
  ADD KEY `id_paramedic` (`id_paramedic`);

--
-- Индексы таблицы `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id_doctor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
