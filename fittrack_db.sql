-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 01:21 AM
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
-- Database: `fittrack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `Mtime_in` time DEFAULT NULL,
  `Mtime_out` time DEFAULT NULL,
  `Ntime_in` time DEFAULT NULL,
  `Ntime_out` time DEFAULT NULL,
  `Atime_in` time DEFAULT NULL,
  `Atime_out` time DEFAULT NULL,
  `Etime_in` time DEFAULT NULL,
  `Etime_out` time DEFAULT NULL,
  `attendance_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contract_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `contract_Renewal` date NOT NULL,
  `contract_Expiration` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`contract_id`, `members_id`, `contract_Renewal`, `contract_Expiration`) VALUES
(3, 2, '2024-09-12', '2024-10-12'),
(4, 3, '2024-09-12', '2024-10-12'),
(5, 1, '2024-09-12', '2024-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `users_id` int(11) NOT NULL,
  `fullName` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `age` int(3) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`users_id`, `fullName`, `email`, `address`, `phone_no`, `gender`, `age`, `profile_picture`, `member_id`) VALUES
(3, 'MARCO JEAN F. PAGOTAISIDRO', 'marcojean@gmail.com', 'MALAGUTAY', '09755684574', 'MALE', 20, '670b8121611df-pose-muscle-muscle-rod-press-hd-wallpaper-preview.jpg', 1),
(4, 'LUCAY-LUCAY ERIAL KATE', 'k8@gmai.com', 'EWAN KO PO', '09357745262', 'MALE', 22, NULL, 2),
(5, '1', '1@gmail.com', '1', '1', 'MALE', 1, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plans_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `workout_day` varchar(20) NOT NULL,
  `diet_plan` text NOT NULL,
  `exercise` varchar(255) NOT NULL,
  `day` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `plan_at` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plans_id`, `members_id`, `workout_day`, `diet_plan`, `exercise`, `day`, `date`, `plan_at`) VALUES
(1, 1, 'LEG DAY', 'ewrwerwerwerqwfewqweqr\r\nfsdfsdf\r\nsdfsdfsdf\r\nfsdfsdf\r\nadrfsdfsdfsdf', 'Squats,Bulgarian Split Squat,Glute Bridge,Calf Raises', 'THURSDAY', '2024-10-10', '2024-10-13'),
(3, 1, 'PUSH DAY', 'sdfbgszadfgarastg', 'Push-ups,Bench Press,Overhead Press,Dips', 'TUESDAY', '2024-10-15', '2024-10-15'),
(4, 1, 'PULL DAY', 'asdASDXa', 'Pull-ups,Barbell Rows,Lat Pulldown,Deadlifts', 'WEDNESDAY', '2024-10-04', '2024-10-15'),
(5, 1, 'UPPER BODY', 'sadcAw', 'Bicep Curls,Tricep Dips,Chest Fly,Shoulder Press', 'WEDNESDAY', '2024-10-10', '2024-10-15'),
(6, 1, 'UPPER BODY', 'aadasCFQF', 'Chest Fly', 'THURSDAY', '2024-10-19', '2024-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `day` varchar(10) NOT NULL,
  `exercise` varchar(255) NOT NULL,
  `workout_day` varchar(15) NOT NULL,
  `image_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `members_id`, `date`, `day`, `exercise`, `workout_day`, `image_file`) VALUES
(1, 1, '2024-10-10', 'MONDAY', 'Leg Press', 'LEG DAY', '670b80d3f0738-10jkhhg.png'),
(2, 1, '2024-10-02', 'WEDNESDAY', 'Lunges,Bulgarian Split Squat,Step-Ups,Leg Extensions,Glute Bridge,Hip Thrusts', 'LEG DAY', '670d7504422a7-starbucks-strawberry-acai-refresher-drink.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `user_Role` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_Role`, `created_at`) VALUES
(2, 'admin', '$2y$10$GytK7Uke1MTduUJD7pkns..QvIArlKc0SeN1ob791uRuK82vuunBG', 'admin', '2024-10-13 14:22:37'),
(3, 'jean', '$2y$10$JWiQuVuVED7xiOX3aSP5rO4P94rKV89uEjeJ20fRAciHLfFs3msT2', 'members', '2024-10-13 14:24:06'),
(4, 'kate', '$2y$10$Ds8opDp1mpx.JEvTxxz1RuO6mmwIgUnBfLrPiW92ZO3pVkPoBLyOO', 'members', '2024-10-13 14:26:07'),
(5, '1', '$2y$10$WXrtS28bTYHR20jQw55JmO9i9MLxxbK1mitD8TzRq6retFfyFm9TW', 'members', '2024-10-13 15:54:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `members_id` (`members_id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contract_id`),
  ADD KEY `members_id` (`members_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plans_id`),
  ADD KEY `members_id` (`members_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `members_id` (`members_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `contract_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
