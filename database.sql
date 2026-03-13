-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.byethost7.com
-- Generation Time: Mar 13, 2026 at 12:44 PM
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
(7, 2, 'The Culinary Loft', 'Spacious open-plan kitchen with industrial ovens and marble stations.', '123 Baker St, London', '35.00', 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800', 'Available 24/7', 1, '2026-03-13 15:58:44'),
(8, 2, 'Elite Pastry Studio', 'Perfect for bakers. Temperature controlled with high-end stand mixers.', '45 Pastry Lane, Paris', '50.00', 'https://images.unsplash.com/photo-1565538810643-b5bdb714032a?w=800', 'Mon-Fri, 8am - 6pm', 1, '2026-03-13 15:58:44'),
(9, 2, 'Gourmet Central', 'A professional heavy-duty kitchen for high-volume catering prep.', '88 Chef Road, Berlin', '40.00', 'https://images.unsplash.com/photo-1590794056226-79ef3a8147e1?w=800', 'Weekends only', 1, '2026-03-13 15:58:44'),
(10, 2, 'Artisan Bread Lab', 'Specialized wood-fired ovens and large proofing cabinets for sourdough.', '12 Crust St, Rome', '30.00', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800', 'Available evenings', 1, '2026-03-13 15:58:44'),
(11, 2, 'Cloud Kitchen Hub', 'Optimized for delivery-only brands. Shared cold storage included.', '10 Tech Plaza, New York', '25.00', 'https://media.istockphoto.com/id/1316339846/photo/home-improvement-remodeled-contemporary-kitchen-design-in-residential-home.jpg?s=612x612&w=0&k=20&c=d4RvFesqi5EFLVw19X-xNcNf-ArNw9t_7y-_AJNoiQk=', '24-hour access', 1, '2026-03-13 15:58:44'),
(12, 2, 'Zen Vegan Kitchen', 'Certified 100% plant-based equipment only. Calm and bright atmosphere.', '7 Green Way, Amsterdam', '45.00', 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800', 'Daily 9am - 9pm', 1, '2026-03-13 15:58:44'),
(13, 2, 'The Butcher Block', 'Industrial grade meat processing and walk-in freezers.', '33 Market Blvd, Chicago', '60.00', 'https://media.istockphoto.com/id/1768884488/photo/modern-kitchen.jpg?s=612x612&w=0&k=20&c=SM_E7wgrJ6jzFcizcrnino7atPPj7FSK_5k9JjhZcrU=', 'Morning slots only', 1, '2026-03-13 15:58:44'),
(14, 2, 'Pastry Paradise', 'Small, cozy boutique kitchen for cake decorators and chocolatiers.', '5 Sweet St, Brussels', '38.00', 'https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?w=800', 'Available Mon-Thu', 1, '2026-03-13 15:58:44'),
(15, 2, 'Rooftop Prep Space', 'Beautiful lighting and modern induction hobs for food photography.', '99 Skyview, Madrid', '70.00', 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=800', 'Daylight hours only', 1, '2026-03-13 15:58:44'),
(16, 4, 'Deep Fryer Factory', 'High-ventilation space equipped with multiple deep-fry units.', '22 Oil Rd, Tokyo', '28.00', 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?w=800', 'Late night availability', 1, '2026-03-13 15:58:44'),
(17, 4, 'The Pizza Oven Yard', 'Authentic Italian stone ovens. Large outdoor prep area.', '14 Napoli Dr, Naples', '32.00', 'https://www.thespruce.com/thmb/LJfeQVLvn6UpdiHdyCaGIQd8CLg=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/CathieHong-Saratoga_9-65822678d6c649768760c780b534aed7.jpg', 'Summer season only', 1, '2026-03-13 15:58:44'),
(18, 4, 'Modern Minimalist', 'Sleek, white kitchen for clean aesthetic video shoots and classes.', '55 Nordic Way, Oslo', '55.00', 'https://images.unsplash.com/photo-1522444195799-478538b28823?w=800', 'Daily bookings', 1, '2026-03-13 15:58:44'),
(19, 4, 'Industrial Catering', 'Huge space for wedding catering and large batch cooking.', '101 Cargo St, Sydney', '80.00', 'https://images.unsplash.com/photo-1564069114553-7215e1ff1890?w=800', '24/7 Security', 1, '2026-03-13 15:58:44'),
(20, 4, 'Sushi Master Suite', 'Stainless steel surfaces and precise chilling cabinets.', '4 Sushi Ave, Kyoto', '65.00', 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=800', 'Reservation required', 1, '2026-03-13 15:58:44'),
(21, 4, 'The Spice Corner', 'Specifically for high-aroma cooking with extra-strength ventilation.', '11 Saffron St, Delhi', '22.00', 'https://images.unsplash.com/photo-1506484381205-f7945653044d?w=800', 'Open all days', 1, '2026-03-13 15:58:44'),
(22, 4, 'The Smokehouse Garage', 'Industrial BBQ setup with smokers, wood-fired grills, and heavy-duty extraction.', '55 Pitmaster Way, Austin', '45.00', 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800', 'Open daily 10am - midnight', 1, '2026-03-13 15:59:40'),
(23, 4, 'Family Feast Kitchen', 'Home-style setup with multiple ovens and large prep islands for group cooking.', '202 Heritage Ln, London', '28.00', 'https://media.istockphoto.com/id/1456242777/photo/modern-japandi-mock-up-room-interior-design-and-decoration-with-green-pastel-counter-and.jpg?s=612x612&w=0&k=20&c=xWIYFrx09O-FGo1pizfoEz0A1E6Lsz_pIffTTnypI6U=', 'Weekend bookings preferred', 1, '2026-03-13 15:59:40'),
(24, 4, 'Tech-Chef Lab', 'High-tech kitchen featuring sous-vide machines, dehydrators, and liquid nitrogen prep.', '404 Silicon Rd, San Francisco', '65.00', 'https://images.unsplash.com/photo-1504386106331-3e4e71712b38?w=800', 'Requires technical training', 1, '2026-03-13 15:59:40'),
(25, 4, 'Coastal Seafood Studio', 'Specially designed for seafood prep with ice-storage and specialized filleting stations.', '88 Ocean View, Lisbon', '35.00', 'https://images.unsplash.com/photo-1498654077810-12c21d4d6dc3?w=800', 'Fresh morning slots available', 1, '2026-03-13 15:59:40'),
(26, 4, 'The Juicery Prep Space', 'Cold-press stations and industrial blenders for health-focused meal prep.', '12 Vitality Blvd, Sydney', '22.00', 'https://images.unsplash.com/photo-1610970881699-44a5587cabec?w=800', '24/7 access available', 1, '2026-03-13 15:59:40'),
(27, 2, 'Demo', 'Demo dgsgf g sgg dwef sddv', 'Arafsd', '14.00', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRpiFedKZoHskn7kMhDlFwiM3bW6-j5_hZ_jw&s', 'dfsdf', 0, '2026-03-13 16:32:35');

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
(3, 'Admin', 'admin@kitchenhop.com', '$2y$10$PpLh6NYGMrYdwYpolNcvV.CVaMSnLUtHp.AvTlYTZEnfJjW4sb.kK', 'admin', '2026-03-11 20:55:15'),
(4, 'Sarah Miller', 'sarah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', '2026-03-13 15:59:34');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
