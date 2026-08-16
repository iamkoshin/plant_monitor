-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 11:36 PM
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
-- Database: `plant_monitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(6, 'admin', '202cb962ac59075b964b07152d234b70', 'admin@example.com', '2026-06-25 18:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `pump_commands`
--

CREATE TABLE `pump_commands` (
  `id` int(11) NOT NULL,
  `command` varchar(10) DEFAULT 'auto',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pump_commands`
--

INSERT INTO `pump_commands` (`id`, `command`, `updated_at`) VALUES
(1, 'auto', '2026-06-25 18:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `data_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `temperature` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `soil_moisture` int(11) DEFAULT NULL,
  `pump_status` tinyint(1) DEFAULT 0,
  `pump_mode` varchar(10) DEFAULT 'auto',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_data`
--

INSERT INTO `sensor_data` (`data_id`, `user_id`, `temperature`, `humidity`, `soil_moisture`, `pump_status`, `pump_mode`, `created_at`) VALUES
(59, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:40:30'),
(60, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:40:35'),
(61, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:40:40'),
(62, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:40:45'),
(63, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:40:50'),
(64, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:40:55'),
(65, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:41:00'),
(66, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:41:05'),
(67, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:41:10'),
(68, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:15'),
(69, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:20'),
(70, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:25'),
(71, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:30'),
(72, 1, 28.1, 76, 0, 0, 'manual', '2026-06-07 00:41:35'),
(73, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:40'),
(74, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:45'),
(75, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:50'),
(76, 1, 28.1, 75, 0, 0, 'manual', '2026-06-07 00:41:55'),
(77, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:42:00'),
(78, 1, 28.2, 75, 0, 1, 'manual', '2026-06-07 00:42:05'),
(79, 1, 28.1, 76, 0, 1, 'manual', '2026-06-07 00:42:11'),
(80, 1, 28.2, 76, 0, 1, 'manual', '2026-06-07 00:42:15'),
(81, 1, 28.2, 76, 0, 1, 'auto', '2026-06-07 00:42:20'),
(82, 1, 28.2, 76, 0, 1, 'auto', '2026-06-07 00:42:25'),
(83, 1, 28.2, 76, 0, 1, 'auto', '2026-06-07 00:42:30'),
(84, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:42:35'),
(85, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:42:40'),
(86, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:42:45'),
(87, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:42:50'),
(88, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:42:55'),
(89, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:00'),
(90, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:05'),
(91, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:10'),
(92, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:43:15'),
(93, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:20'),
(94, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:43:25'),
(95, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:31'),
(96, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:35'),
(97, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:43:40'),
(98, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:45'),
(99, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:43:50'),
(100, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:43:55'),
(101, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:44:00'),
(102, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:44:05'),
(103, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:44:10'),
(104, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:44:15'),
(105, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:44:20'),
(106, 1, 28.2, 76, 0, 0, 'manual', '2026-06-07 00:44:25'),
(107, 1, 28.2, 75, 0, 0, 'manual', '2026-06-07 00:44:30'),
(108, 1, 28.2, 77, 0, 0, 'manual', '2026-06-07 00:44:35'),
(109, 1, 28.5, 79, 0, 0, 'manual', '2026-06-07 00:44:40'),
(110, 1, 28.9, 80, 0, 0, 'manual', '2026-06-07 00:44:45'),
(111, 1, 29.2, 80, 0, 0, 'manual', '2026-06-07 00:44:50'),
(112, 1, 29.5, 80, 0, 0, 'manual', '2026-06-07 00:44:56'),
(113, 1, 29.7, 78, 0, 0, 'manual', '2026-06-07 00:45:00'),
(114, 1, 29.8, 77, 0, 0, 'manual', '2026-06-07 00:45:05'),
(115, 1, 29.9, 76, 0, 0, 'manual', '2026-06-07 00:45:10'),
(116, 1, 29.8, 74, 0, 0, 'manual', '2026-06-07 00:45:15'),
(117, 1, 29.9, 74, 0, 0, 'manual', '2026-06-07 00:46:02'),
(118, 1, 29, 73, 0, 0, 'manual', '2026-06-07 00:46:02'),
(119, 1, 29, 73, 0, 0, 'manual', '2026-06-07 00:46:07'),
(120, 1, 0, 0, 0, 0, 'auto', '2026-06-25 18:40:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'koshin', '202cb962ac59075b964b07152d234b70', 'koshin@example.com', '2026-06-06 19:18:46'),
(5, 'omar', '202cb962ac59075b964b07152d234b70', 'omar@example.com', '2026-06-06 21:41:49'),
(7, 'farhia', '202cb962ac59075b964b07152d234b70', 'farhia@example.com', '2026-06-22 16:51:45'),
(8, 'zaki', '202cb962ac59075b964b07152d234b70', 'zaki@example.com', '2026-06-24 05:57:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pump_commands`
--
ALTER TABLE `pump_commands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pump_commands`
--
ALTER TABLE `pump_commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD CONSTRAINT `sensor_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
