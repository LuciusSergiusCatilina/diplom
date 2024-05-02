-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 02 2024 г., 12:21
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
(1, 1, NULL, 4, 'ул. Кутузная д.62 кв.6', '2024-02-04 11:21:10', '79004825567', 'Консультация'),
(2, 1, 797, 9, 'ул. Восточная д. 233 кв. 765', '2023-04-25 11:21:46', '79994562218', 'Вызов бригады'),
(3, 1, 111, NULL, 'ул. Коновалова д.41', '2022-06-09 11:27:47', '79998456121', 'Вызов бригады'),
(4, 1, NULL, 4, 'ул. Достоевского д. 32', '2022-01-24 10:17:12', '79004562222', 'Консультация'),
(5, 1, 797, 4, 'ул. Шиловская д.51 кв.521', '2024-03-12 12:18:08', '79004825608', 'Вызов бригады'),
(6, 1, 402, 4, 'Улица Профсоюзная, дом 15, квартира 25', '2024-05-02 10:31:38', '74951234567', 'Вызов бригады'),
(7, 1, 56, NULL, '', '2024-05-02 11:20:47', '', 'Вызов бригады'),
(8, 1, 56, 2, '', '2024-05-02 11:24:42', '', 'Вызов бригады'),
(9, 1, 56, 9, 'Проспект Вернадского, дом 102, квартира 18', '2024-05-02 11:24:56', '', 'Вызов бригады'),
(10, 1, 56, NULL, '', '2024-05-02 11:25:12', '74958765666', 'Вызов бригады'),
(11, 1, 56, NULL, '', '2024-05-02 11:26:54', '74958765666', 'Вызов бригады'),
(12, 1, 56, NULL, '', '2024-05-02 11:27:08', '74958765666', 'Вызов бригады'),
(13, 1, 56, NULL, 'Проспект Мира, дом 87, квартира 44', '2024-05-02 11:27:18', '', 'Вызов бригады'),
(14, 1, NULL, 4, '', '2024-05-02 11:27:58', '74958765432', 'Консультация');

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
(22, 8, 24, 7, 13),
(56, 6, 18, 3, 10),
(111, 3, 18, 9, 11),
(402, 4, 20, NULL, 9),
(797, 5, 19, 6, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `name`, `number`, `specialization`) VALUES
(18, 'Айболит', '+79004821224', 'Педиатр'),
(19, 'Биша Мари-Франсуа Ксавье sadsa', '+79991235421', 'Психиатр'),
(20, 'Джокушка Джокер', '+7993291312', 'Психиатр'),
(21, 'Алкалаев Константин Константинович', '+79704512323', 'Травматолог'),
(24, 'Аничков Николай Николаевич ', '+79907764545', 'Травматолог');

-- --------------------------------------------------------

--
-- Структура таблицы `drivers`
--

CREATE TABLE `drivers` (
  `id_drivers` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `drivers`
--

INSERT INTO `drivers` (`id_drivers`, `name`, `phone`) VALUES
(3, 'Райан Гослинг', '79931925607'),
(4, 'Соколов Павел Александрович', '79161234560'),
(5, 'Иванов Алексей Сергеевич', '79271234561'),
(6, 'Петрова Елена Ивановна', '79381234562'),
(7, 'Сидорова Анастасия Петровна', '79491234563'),
(8, 'Федоров Игорь Александрович', '79501234564'),
(9, 'Кузнецова Ольга Владимировна', '79601234565'),
(10, 'Морозова Мария Сергеевна', '79701234566');

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
(5, 'Сидорова Анна Сергеевна', '79172345678'),
(6, 'Иванов Петр Иванович', '79282345678'),
(7, 'Петрова Ольга Владимировна', '79392345678'),
(8, 'Смирнов Сергей Алексеевич', '79402345678'),
(9, 'Козлова Екатерина Дмитриевна', '79512345678'),
(10, 'Смирнова Анастасия Ивановна', '79161234568'),
(11, 'Петров Алексей Сергеевич', '79271234569'),
(12, 'Иванова Елена Владимировна', '79381234570'),
(13, 'Сидоров Игорь Петрович', '79491234571'),
(14, 'Федорова Ольга Александровна', '79501234572');

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
(3, 'Римма Николаевна', '+79165432424'),
(4, 'Фирсов Антон Павлович', '79964205555'),
(5, 'Соколова Елена Алексеевна', '79161234567'),
(6, 'Игнатов Александр Владимирович', '79271234567'),
(7, 'Григорьева Ольга Дмитриевна', '79381234567'),
(8, 'Михайлов Петр Сергеевич', '79491234567'),
(9, 'Кузнецова Ирина Андреевна', '79501234567');

-- --------------------------------------------------------

--
-- Структура таблицы `patient`
--

CREATE TABLE `patient` (
  `id_patient` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `number` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adress` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `patient`
--

INSERT INTO `patient` (`id_patient`, `name`, `number`, `adress`) VALUES
(2, 'Аксёнов Пётр', '79000012312', 'ул. Победы д.6'),
(4, 'Петрова Екатерина Сергеевна\r\n', '79167890123', 'Москва, улица Тверская, дом 15, квартира 7'),
(5, 'Иванова Анна Петровна', '79101234567', 'Москва, улица Ленина, дом 10, квартира 5'),
(6, 'Петров Иван Сергеевич', '79202222222', 'Москва, проспект Победы, дом 20, квартира 10'),
(7, 'Сидорова Мария Александровна', '79303333333', 'Москва, улица Гагарина, дом 30, квартира 15'),
(8, 'Козлов Павел Андреевич', '79404444444', 'Москва, проспект Воробьева, дом 40, квартира 20'),
(9, 'Никитина Ольга Дмитриевна', '79505555555', 'Москва, улица Кирова, дом 50, квартира 25'),
(10, 'Смирнов Дмитрий Игоревич', '79606666666', 'Москва, проспект Строителей, дом 60, квартира 30'),
(11, 'Васильева Елена Сергеевна', '79707777777', 'Москва, улица Строителей, дом 70, квартира 35'),
(12, 'Попов Алексей Владимирович', '79808888888', 'Москва, проспект Победы, дом 80, квартира 40'),
(13, 'Морозова Анна Ивановна', '79909999999', 'Москва, улица Победы, дом 90, квартира 45'),
(14, 'Федоров Александр Александрович', '79111000000', 'Москва, улица Ленина, дом 100, квартира 50');

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
  ADD KEY `id_patient` (`id_patient`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_crew` (`id_crew`) USING BTREE;

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
  ADD UNIQUE KEY `number` (`number`);

--
-- Индексы таблицы `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id_drivers`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Индексы таблицы `orderly`
--
ALTER TABLE `orderly`
  ADD PRIMARY KEY (`id_orderly`);

--
-- Индексы таблицы `paramedic`
--
ALTER TABLE `paramedic`
  ADD PRIMARY KEY (`id_paramedic`);

--
-- Индексы таблицы `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD UNIQUE KEY `number` (`number`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `calls`
--
ALTER TABLE `calls`
  MODIFY `id_call` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id_doctor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id_drivers` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `orderly`
--
ALTER TABLE `orderly`
  MODIFY `id_orderly` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `paramedic`
--
ALTER TABLE `paramedic`
  MODIFY `id_paramedic` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
