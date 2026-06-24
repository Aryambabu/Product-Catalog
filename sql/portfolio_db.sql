-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2025 at 01:14 PM
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
-- Database: `portfolio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `user_app_url` varchar(255) DEFAULT NULL,
  `admin_app_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `name`, `category`, `short_description`, `long_description`, `image`, `price`, `user_app_url`, `admin_app_url`, `created_at`) VALUES
(1, 'CRM System', 'Business', 'Manage clients efficiently', '', 'assets/uploads/app_68f7734d47268.png', 14999.00, 'https://example.com/usercrm', 'https://example.com/admincrm', '2025-10-11 08:50:30'),
(2, 'Inventory Tracker', 'Logistics', 'Track your stock levels', '', 'assets/uploads/app_68f773db1b0ed.png', 9999.00, 'https://example.com/userinv', 'https://example.com/admininv', '2025-10-11 08:50:30'),
(3, 'HR Portal', 'HR', 'Employee management portal', 'Onboard, manage and review employees.', 'assets/uploads/sample3.jpg', 7999.00, 'https://example.com/userhr', 'https://example.com/adminhr', '2025-10-11 08:50:30'),
(4, 'E-Commerce Store', 'Retail', 'Online store platform', 'Sell products with payments and orders.', 'assets/uploads/sample4.jpg', 19999.00, 'https://example.com/userstore', 'https://example.com/adminstore', '2025-10-11 08:50:30'),
(5, 'Accounting Suite', 'Finance', 'Manage accounts and invoicing', 'Complete accounting and GST reports.', 'assets/uploads/sample5.jpg', 12999.00, 'https://example.com/useracc', 'https://example.com/adminacc', '2025-10-11 08:50:30'),
(6, 'Learning LMS', 'Education', 'Online courses and quizzes', 'Create courses, track students.', 'assets/uploads/sample6.jpg', 8999.00, 'https://example.com/userlms', 'https://example.com/adminlms', '2025-10-11 08:50:30'),
(7, 'Support Desk', 'Support', 'Ticketing and SLA management', 'Customer support ticketing system.', 'assets/uploads/sample7.jpg', 6999.00, 'https://example.com/usersupport', 'https://example.com/adminsupport', '2025-10-11 08:50:30'),
(8, 'Project Manager', 'Productivity', 'Plan and track projects', 'Tasks, timelines, Gantt charts.', 'assets/uploads/sample8.jpg', 10999.00, 'https://example.com/userpm', 'https://example.com/adminpm', '2025-10-11 08:50:30'),
(9, 'Analytics Dashboard', 'BI', 'Visualize business metrics', 'Dashboards and reports.', 'assets/uploads/sample9.jpg', 15999.00, 'https://example.com/userbio', 'https://example.com/adminbio', '2025-10-11 08:50:30'),
(10, 'Appointment Scheduler', 'Services', 'Book appointments online', 'Calendar, reminders and slots.', 'assets/uploads/sample10.jpg', 4999.00, 'https://example.com/usersched', 'https://example.com/adminsched', '2025-10-11 08:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `popular`
--

CREATE TABLE `popular` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `popular`
--

INSERT INTO `popular` (`id`, `user_id`, `app_id`, `created_at`) VALUES
(17, 1, 2, '2025-10-22 08:36:41'),
(18, 1, 1, '2025-10-22 09:31:05'),
(19, 1, 3, '2025-10-22 09:31:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Demo User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 1, '2025-10-11 08:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `title`, `description`, `created_at`) VALUES
(2, 1, 'ecommerce', 'ecommerce website', '2025-10-22 10:16:16'),
(3, 1, 'GDSGH', 'DGDG', '2025-10-22 10:19:37'),
(4, 1, 'sfa', 'sfaf', '2025-10-22 11:10:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popular`
--
ALTER TABLE `popular`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`user_id`,`app_id`),
  ADD KEY `app_id` (`app_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `popular`
--
ALTER TABLE `popular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `popular`
--
ALTER TABLE `popular`
  ADD CONSTRAINT `popular_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `popular_ibfk_2` FOREIGN KEY (`app_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
