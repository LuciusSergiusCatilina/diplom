-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 10 2024 г., 22:21
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
-- База данных: `station_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calls`
--

CREATE TABLE `calls` (
  `id_call` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_crew` int(6) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `adress` text NOT NULL,
  `time` date NOT NULL DEFAULT current_timestamp(),
  `number` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `crews`
--

CREATE TABLE `crews` (
  `id_crew` int(6) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `id_paramedic` int(11) DEFAULT NULL,
  `id_orderly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `crews`
--

INSERT INTO `crews` (`id_crew`, `id_driver`, `id_doctor`, `id_paramedic`, `id_orderly`) VALUES
(43, 3, 18, 3, 3),
(666, 3, 18, NULL, 3),
(777, 3, 18, 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL,
  `specialization` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `name`, `number`, `specialization`) VALUES
(18, 'Айболит', '+79004821223', 'Педиатр'),
(19, 'Биша Мари-Франсуа Ксавье ', '+79991235421', 'Психиатр');

-- --------------------------------------------------------

--
-- Структура таблицы `drivers`
--

CREATE TABLE `drivers` (
  `id_drivers` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL
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
  `id_orderly` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orderly`
--

INSERT INTO `orderly` (`id_orderly`, `name`, `number`) VALUES
(3, 'Артём Франк', '+73249117534');

-- --------------------------------------------------------

--
-- Структура таблицы `paramedic`
--

CREATE TABLE `paramedic` (
  `id_paramedic` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL
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
  `id_patient` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL,
  `adress` text NOT NULL
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
  `id_user` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_doctor`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Индексы таблицы `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id_drivers`),
  ADD UNIQUE KEY `phone` (`phone`) USING HASH,
  ADD UNIQUE KEY `phone_2` (`phone`) USING HASH;

--
-- Индексы таблицы `orderly`
--
ALTER TABLE `orderly`
  ADD PRIMARY KEY (`id_orderly`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Индексы таблицы `paramedic`
--
ALTER TABLE `paramedic`
  ADD PRIMARY KEY (`id_paramedic`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Индексы таблицы `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `calls`
--
ALTER TABLE `calls`
  MODIFY `id_call` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id_doctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id_drivers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orderly`
--
ALTER TABLE `orderly`
  MODIFY `id_orderly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `paramedic`
--
ALTER TABLE `paramedic`
  MODIFY `id_paramedic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `calls`
--
ALTER TABLE `calls`
  ADD CONSTRAINT `calls_ibfk_1` FOREIGN KEY (`id_crew`) REFERENCES `crews` (`id_crew`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calls_ibfk_2` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calls_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `crews`
--
ALTER TABLE `crews`
  ADD CONSTRAINT `crews_ibfk_1` FOREIGN KEY (`id_doctor`) REFERENCES `doctor` (`id_doctor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crews_ibfk_2` FOREIGN KEY (`id_driver`) REFERENCES `drivers` (`id_drivers`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crews_ibfk_3` FOREIGN KEY (`id_orderly`) REFERENCES `orderly` (`id_orderly`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `crews_ibfk_4` FOREIGN KEY (`id_paramedic`) REFERENCES `paramedic` (`id_paramedic`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
