-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 10:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `trs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reminder_list`
--

CREATE TABLE `reminder_list` (
  `id` bigint(30) NOT NULL,
  `user_id` bigint(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `remind_from` date NOT NULL,
  `remind_to` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reminder_list`
--

INSERT INTO `reminder_list` (`id`, `user_id`, `title`, `description`, `remind_from`, `remind_to`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sample Task 101', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum quis nisi tincidunt, fringilla magna eleifend, malesuada justo. Praesent in mi turpis.', '2023-04-17', '2023-04-30', 1, '2023-04-17 16:44:27', NULL),
(2, 14, 'Sample Task 102', 'Cras ante lectus, tempor sit amet nisi vel, faucibus imperdiet diam. Sed urna arcu, egestas at purus pulvinar, ultrices cursus nisl. Phasellus nec nisl vitae nisi rhoncus tincidunt. Sed id quam nisl.', '2023-04-17', '2023-04-22', 1, '2023-04-17 16:44:57', NULL),
(3, 13, 'Sample Task 103', 'Proin sed enim vel quam egestas ultricies non id purus. Nunc dictum luctus nibh. Duis porta dolor vitae nibh porta, sed feugiat augue mattis.', '2023-04-17', '2023-04-20', 1, '2023-04-17 16:45:25', '2023-04-17 16:45:30'),
(4, 13, 'Sample Task 103', 'Proin consectetur lacus sed arcu porta vulputate. Mauris id leo vitae mauris euismod pharetra at quis justo.', '2023-04-17', '2023-04-28', 1, '2023-04-17 16:45:56', '2023-04-17 16:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Task Reminder System - PHP'),
(6, 'short_name', 'PHP - TRS'),
(11, 'logo', 'uploads/logo.png?v=1681720857'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1681694880'),
(17, 'phone', '456-987-1231'),
(18, 'mobile', '09123456987 / 094563212222 '),
(19, 'email', 'info@musicschool.com'),
(20, 'address', 'Here St, Down There City, Anywhere Here, 2306 -updated');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(30) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='2';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', '', 'Admin', 'admin', '$2y$10$fS4Vuy/7p2mTWECVHVS7eeRcDwTL.YRZqTPIQ/Vd2RLIPcNCdZJL2', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2023-04-17 16:40:19'),
(13, 'Mark', '', 'Cooper', 'mcooper', '$2y$10$mNq15lQxmK3Ri2Z8pSLgT.JSzATfhoudrsRlEzuMyaYdkEHcrzC0i', NULL, NULL, 2, '2023-04-17 16:43:19', '2023-04-17 16:43:19'),
(14, 'Claire', '', 'Blake', 'cblake', '$2y$10$lcudJHE4ePC2IHDLW6.q0ugY0iLHrZruGD6Ojx9xSkwFoR9fYWem2', NULL, NULL, 2, '2023-04-17 16:43:46', '2023-04-17 16:43:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reminder_list`
--
ALTER TABLE `reminder_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reminder_list`
--
ALTER TABLE `reminder_list`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reminder_list`
--
ALTER TABLE `reminder_list`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
