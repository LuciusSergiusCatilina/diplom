-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 08:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `station_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `calls`
--

CREATE TABLE `calls` (
  `id_call` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT 1,
  `id_crew` int(6) DEFAULT NULL,
  `id_patient` int(11) DEFAULT NULL,
  `adress` text NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `number` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calls`
--

INSERT INTO `calls` (`id_call`, `id_user`, `id_crew`, `id_patient`, `adress`, `time`, `number`, `type`) VALUES
(1, 1, 456, 2, 'ул. Мира д.7', '2024-04-14 00:00:00', '+7900000001', 'Консультация'),
(2, 1, 111, 2, 'ЛД', '2024-04-14 19:59:53', '+79000452', 'смэрть'),
(3, 1, NULL, NULL, 'Ул Убийц д.666', '2024-04-15 19:36:09', '+7999999999', 'Консультация'),
(4, 1, NULL, NULL, 'Ул ЗЛАААА', '2024-04-15 20:34:15', '+7988888888', 'Консультация'),
(5, 1, NULL, 2, '', '2024-04-15 20:34:40', '', 'Консультация');

-- --------------------------------------------------------

--
-- Table structure for table `crews`
--

CREATE TABLE `crews` (
  `id_crew` int(6) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL,
  `id_paramedic` int(11) DEFAULT NULL,
  `id_orderly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crews`
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
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id_doctor` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL,
  `specialization` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id_doctor`, `name`, `number`, `specialization`) VALUES
(18, 'Айболит', '+79004821224', 'Педиатр'),
(19, 'Биша Мари-Франсуа Ксавье sadsa', '+79991235421', 'Психиатр'),
(20, 'Джокушка Джокер', '+7993291312', 'Психиатр');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id_drivers` int(11) NOT NULL,
  `name` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id_drivers`, `name`, `phone`) VALUES
(3, 'Райан Гослинг', '+7 (993) 192-56-07');

-- --------------------------------------------------------

--
-- Table structure for table `orderly`
--

CREATE TABLE `orderly` (
  `id_orderly` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderly`
--

INSERT INTO `orderly` (`id_orderly`, `name`, `number`) VALUES
(4, 'Санитар', '+79004825606');

-- --------------------------------------------------------

--
-- Table structure for table `paramedic`
--

CREATE TABLE `paramedic` (
  `id_paramedic` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paramedic`
--

INSERT INTO `paramedic` (`id_paramedic`, `name`, `number`) VALUES
(3, 'Римма Николаевна', '+79165432424');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id_patient` int(11) NOT NULL,
  `name` text NOT NULL,
  `number` text NOT NULL,
  `adress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id_patient`, `name`, `number`, `adress`) VALUES
(2, 'Аксёнов Пётр', '+79000012312', 'ул. Победы д.6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `login`, `password`, `role`) VALUES
(1, 'Админ Админыч', 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id_call`),
  ADD KEY `id_crew` (`id_crew`),
  ADD KEY `id_patient` (`id_patient`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `crews`
--
ALTER TABLE `crews`
  ADD PRIMARY KEY (`id_crew`),
  ADD KEY `id_doctor` (`id_doctor`),
  ADD KEY `id_driver` (`id_driver`),
  ADD KEY `id_orderly` (`id_orderly`),
  ADD KEY `id_paramedic` (`id_paramedic`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id_doctor`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id_drivers`),
  ADD UNIQUE KEY `phone` (`phone`) USING HASH,
  ADD UNIQUE KEY `phone_2` (`phone`) USING HASH;

--
-- Indexes for table `orderly`
--
ALTER TABLE `orderly`
  ADD PRIMARY KEY (`id_orderly`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Indexes for table `paramedic`
--
ALTER TABLE `paramedic`
  ADD PRIMARY KEY (`id_paramedic`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id_patient`),
  ADD UNIQUE KEY `number` (`number`) USING HASH;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calls`
--
ALTER TABLE `calls`
  MODIFY `id_call` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id_doctor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id_drivers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orderly`
--
ALTER TABLE `orderly`
  MODIFY `id_orderly` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `paramedic`
--
ALTER TABLE `paramedic`
  MODIFY `id_paramedic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calls`
--
ALTER TABLE `calls`
  ADD CONSTRAINT `calls_ibfk_1` FOREIGN KEY (`id_crew`) REFERENCES `crews` (`id_crew`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calls_ibfk_2` FOREIGN KEY (`id_patient`) REFERENCES `patient` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calls_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crews`
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
