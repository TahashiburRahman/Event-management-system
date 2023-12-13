-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 08:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'Tashu', 'tahashiburrahman5@gmail.com', '$2y$10$55dlwNDwC5muKz9XcE3R2OlZI1oMkARoL/X.m.nEwqiF42R/OCgeC');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_type_name` varchar(255) DEFAULT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_price` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','accepted','declined') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `event_type_name`, `organizer_id`, `organization_name`, `event_date`, `event_price`, `status`) VALUES
(2, 1, 'Anniversary', 1, 'mirpur convention hall', '2023-10-10', 12000.00, 'accepted'),
(4, 1, 'Wedding', 1, 'mirpur convention hall', '2023-12-12', 150000.00, 'pending'),
(5, 1, 'Wedding', 1, 'mirpur convention hall', '2024-12-11', 150000.00, 'pending'),
(6, 1, 'Birthday', 1, 'mirpur convention hall', '2024-08-07', 5000.00, 'pending'),
(7, 1, 'Birthday', 1, 'mirpur convention hall', '2023-12-12', 5000.00, 'pending'),
(8, 1, 'Anniversary', 1, 'mirpur convention hall', '2024-01-12', 12000.00, 'pending'),
(9, 1, 'Anniversary', 1, 'mirpur convention hall', '2023-12-10', 12000.00, 'pending'),
(10, 1, 'Anniversary', 2, 'Bashundhora Convention Hall', '2023-12-11', 12300.00, 'pending'),
(11, 1, 'Wedding', 2, 'Bashundhora Convention Hall', '2023-10-10', 34500.00, 'pending'),
(12, 1, 'Birthday', 2, 'Bashundhora Convention Hall', '2023-08-11', 1900.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`id`, `name`, `description`) VALUES
(1, 'Anniversary', 'enjoy a beautiful day with your life partner.'),
(2, 'Wedding', 'get married with your partner,invite family and friends.'),
(3, 'Birthday', 'Celebrate your birthday with friends and family.');

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `id` int(11) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`id`, `organization_name`, `email`, `contact`, `password`, `location`) VALUES
(1, 'mirpur convention hall', 'msc@gmail.com', '01712021086', '$2y$10$aUIaPfz.b4HSRxrm/PYc6uXRBBBy0L7XEvWe1yJV5cqcGb55wYISO', 'mirpur-1,Dhaka'),
(2, 'Bashundhora Convention Hall', 'bch@gmail.com', '03456789123', '$2y$10$D1uMSCqvwfmmvvDHcNHmeO3xbMv1pHA49yeiOL25VKCrfV7X0xqjm', 'Panthapath,Bashundhora,Dhaka-1216');

-- --------------------------------------------------------

--
-- Table structure for table `organizer_event_prices`
--

CREATE TABLE `organizer_event_prices` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizer_event_prices`
--

INSERT INTO `organizer_event_prices` (`id`, `organizer_id`, `event_type_id`, `price`) VALUES
(1, 1, 1, 12000.00),
(2, 1, 2, 150000.00),
(3, 1, 3, 5000.00),
(4, 2, 1, 12300.00),
(5, 2, 2, 34500.00),
(6, 2, 3, 1900.00);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `organizer_id`, `image_path`) VALUES
(1, 1, 'uploads/64f1ed6e0a699_U.jpeg'),
(2, 2, 'uploads/64fcb6f62c3c8_T.jpeg'),
(3, 2, 'uploads/64fcb765e11c5_V.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `contact`, `password`) VALUES
(1, 'Tahashibur', 'Rahman', 'tahashiburrahman5@gmail.com', '01615999469', '$2y$10$PkYaANLj0qGmKVoJdKivRudv2emCoUEdSIEJlGNL1RTD2awmEXM3q'),
(3, 'mahima', 'rahman', 'mahimarahman@gmail.com', '65656565', '$2y$10$iYGR5RCtTERMQ6n.gRcOdOLKJmoubBwQCI3zpHVYXBqvAhnRlkt9q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizer_event_prices`
--
ALTER TABLE `organizer_event_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organizer_event_prices`
--
ALTER TABLE `organizer_event_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`id`);

--
-- Constraints for table `organizer_event_prices`
--
ALTER TABLE `organizer_event_prices`
  ADD CONSTRAINT `organizer_event_prices_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`id`),
  ADD CONSTRAINT `organizer_event_prices_ibfk_2` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`);

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
