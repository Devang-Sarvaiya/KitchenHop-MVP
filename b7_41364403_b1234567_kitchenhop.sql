-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.byethost7.com
-- Generation Time: Mar 12, 2026 at 12:32 PM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b7_41364403_b1234567_kitchenhop`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `kitchen_id` int(11) DEFAULT NULL,
  `chef_id` int(11) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `kitchen_id`, `chef_id`, `start_datetime`, `end_datetime`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 1, '2026-03-12 01:00:00', '2026-03-14 21:37:00', '4117.00', 'Rejected', '2026-03-11 20:37:15'),
(2, 1, 1, '2026-03-11 01:00:00', '2026-03-11 03:00:00', '120.00', 'Approved', '2026-03-11 21:24:03'),
(3, 2, 1, '2026-03-12 16:14:00', '2026-03-19 19:17:00', '2394.70', 'Approved', '2026-03-12 15:14:56'),
(4, 3, 1, '2026-03-13 17:07:00', '2026-03-14 17:07:00', '1248.00', 'Approved', '2026-03-12 16:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Dhwev', 'hsdbh@gmail.com', 'judvfehjb', 'kjbfhdwbf \r\n\' higgdwlbkug ij  kjghjs\r\nsdfkhbvuhbkdjhdsuhng', '2026-03-12 16:17:31'),
(2, 'wdfds', 'acfsas@gmail.com', 'hdjdkbjk', 'bvkbndk\r\nnjdfg jfnk fk\r\ng\r\nfd nk. fgfkg klnvskh\r\n\r\nfff\r\nklnfbl\r\n ndf\r\nbfs\r\nnd \r\nklvbnklfd', '2026-03-12 16:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `kitchens`
--

CREATE TABLE `kitchens` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `hourly_rate` decimal(10,2) DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `availability_notes` text DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kitchens`
--

INSERT INTO `kitchens` (`id`, `owner_id`, `name`, `description`, `address`, `hourly_rate`, `image_url`, `availability_notes`, `is_verified`, `created_at`) VALUES
(3, 2, 'Amkwnm', 'qsnk', 'nwmq,s', '52.00', '', 'mkqwk', 1, '2026-03-12 16:01:53'),
(2, 2, 'demo', 'dsfdffds', 'hjgfj', '14.00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgnEx235ueoxt4OzMvWqCmS-jvyQSl6DaUXQ&s', 'sggggggggggggggggggggggggggggggg', 1, '2026-03-12 15:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('chef','owner','admin') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Dg', 'aff@gmail.com', '$2y$10$aGE3p1O5WyDpPSn4BkKLZ.XN7neJHX6L1h9cuhZQ7G8g/zCJ5t.EW', 'chef', '2026-03-11 15:35:52'),
(2, 'Dt', 'abc@gmail.com', '$2y$10$o8ggAh2XT2s3Q6T/n3/VJuMhggsafmudaKpRTFHj3zhJRAIiMQ1Hy', 'owner', '2026-03-11 15:37:46'),
(3, 'Admin', 'admin@kitchenhop.com', '$2y$10$PpLh6NYGMrYdwYpolNcvV.CVaMSnLUtHp.AvTlYTZEnfJjW4sb.kK', 'admin', '2026-03-11 20:55:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kitchens`
--
ALTER TABLE `kitchens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kitchens`
--
ALTER TABLE `kitchens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
