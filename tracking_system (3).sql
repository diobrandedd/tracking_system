-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 02:36 PM
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
-- Database: `tracking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `p_id` int(11) NOT NULL,
  `tracking_num` varchar(255) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_num` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_num` varchar(255) NOT NULL,
  `package_weight` varchar(255) NOT NULL,
  `current_location` varchar(255) NOT NULL,
  `estimated_delivery` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company_name` varchar(250) NOT NULL,
  `delivery_status` varchar(50) DEFAULT 'In Transit',
  `record_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`p_id`, `tracking_num`, `delivery_address`, `recipient_name`, `recipient_num`, `sender_name`, `sender_email`, `sender_num`, `package_weight`, `current_location`, `estimated_delivery`, `updated_at`, `company_name`, `delivery_status`, `record_status`) VALUES
(15, '5551', 'porokokokok', 'nigga', '1241', 'supahnigga', 'n1gg@gmail.com', '16123', '79', 'sainyongboto', '2024-12-17', '2024-12-10 12:35:11', 'LBC Express', 'Delivered', 'A'),
(16, '1111111', 'ZONE 1 PUROK VICENTE FIN', 'noli', '3e1', 'abdunigga', 'wmoon146@gmail.com', '09090909', '79', 'sainyong yawa na balay', '2024-12-17', '2024-12-10 13:05:35', 'LBC Express', 'Delivered', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `package_history`
--

CREATE TABLE `package_history` (
  `id` int(11) NOT NULL,
  `tracking_num` varchar(255) NOT NULL,
  `status_update` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `courier` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracking_updates`
--

CREATE TABLE `tracking_updates` (
  `id` int(11) NOT NULL,
  `tracking_num` varchar(50) NOT NULL,
  `current_location_1` text DEFAULT NULL,
  `current_location_2` text DEFAULT NULL,
  `current_location_3` text DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking_updates`
--

INSERT INTO `tracking_updates` (`id`, `tracking_num`, `current_location_1`, `current_location_2`, `current_location_3`, `delivery_status`, `updated_at`) VALUES
(1, '5551', 'luzigga', 'visayanigga', 'sainyongboto', 'Delivered', '2024-12-10 12:35:11'),
(2, '1111111', 'Gensannigga', 'polom olok', 'sainyong yawa na balay', 'Delivered', '2024-12-10 13:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `company_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `Username`, `Password`, `Position`, `company_name`) VALUES
(1, 'lbcexpress', '123', 'courier', 'LBC Express'),
(2, 'dhlexpress', '123', 'courier', 'DHL Express'),
(3, 'admin', '123', 'admin', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `tracking_num` (`tracking_num`);

--
-- Indexes for table `package_history`
--
ALTER TABLE `package_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_updates`
--
ALTER TABLE `tracking_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracking_num` (`tracking_num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `package_history`
--
ALTER TABLE `package_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tracking_updates`
--
ALTER TABLE `tracking_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tracking_updates`
--
ALTER TABLE `tracking_updates`
  ADD CONSTRAINT `tracking_updates_ibfk_1` FOREIGN KEY (`tracking_num`) REFERENCES `packages` (`tracking_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
