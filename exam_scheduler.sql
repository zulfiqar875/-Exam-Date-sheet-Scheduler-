-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 09:57 AM
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
-- Database: `exam_scheduler`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `enrollment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `enrollment`) VALUES
(1, 'CYS1001', 'Intro. Cyber Security', 7),
(2, 'CYS1002', 'Security in IoT', 8),
(3, 'CYS1003', 'Secure Software Design', 25);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_code`) VALUES
(1, 4, 'CYS1003'),
(2, 4, 'CYS1001'),
(3, 4, 'CYS1002');

-- --------------------------------------------------------

--
-- Table structure for table `examination_halls`
--

CREATE TABLE `examination_halls` (
  `id` int(11) NOT NULL,
  `hall_name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination_halls`
--

INSERT INTO `examination_halls` (`id`, `hall_name`, `capacity`) VALUES
(1, 'G01', 30),
(2, 'G03', 30),
(3, 'G05', 25);

-- --------------------------------------------------------

--
-- Table structure for table `exam_datesheet`
--

CREATE TABLE `exam_datesheet` (
  `id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `exam_date` date NOT NULL,
  `hall_id` int(11) NOT NULL,
  `superintendent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_datesheet`
--

INSERT INTO `exam_datesheet` (`id`, `course_code`, `exam_date`, `hall_id`, `superintendent_id`) VALUES
(1, 'CYS1003', '2024-09-28', 1, 1),
(2, 'CYS1002', '2024-09-28', 2, 3),
(3, 'CYS1002', '2024-09-28', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `superintendents`
--

CREATE TABLE `superintendents` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superintendents`
--

INSERT INTO `superintendents` (`id`, `name`, `contact`) VALUES
(1, 'Usman Abbas', '+9230698095'),
(2, 'Bilal dar', '0302906791'),
(3, 'Yasir Ali Nazi', '03005001000'),
(6, 'Noman Asim', '03006008000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student','superintendent','exam_coordinator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sid`, `username`, `password`, `role`) VALUES
(1, 0, 'admin', 'admin123', 'admin'),
(2, 0, 'coordinator', 'coordinator123', 'exam_coordinator'),
(3, 2, 'superintendent1', 'super1', 'superintendent'),
(4, 0, 'student1', 'student123', 'student'),
(5, 3, 'yasirnazai', 'yasir123', 'superintendent'),
(6, 6, 'nomanasim', '$2y$10$vCX0y7wV4RJeYZhFcHRzjeCbC8BM8pAddPAauzGQ8w6A8MhDisJqi', 'superintendent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_code` (`course_code`);

--
-- Indexes for table `examination_halls`
--
ALTER TABLE `examination_halls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_datesheet`
--
ALTER TABLE `exam_datesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`),
  ADD KEY `superintendent_id` (`superintendent_id`);

--
-- Indexes for table `superintendents`
--
ALTER TABLE `superintendents`
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
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `examination_halls`
--
ALTER TABLE `examination_halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_datesheet`
--
ALTER TABLE `exam_datesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `superintendents`
--
ALTER TABLE `superintendents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_datesheet`
--
ALTER TABLE `exam_datesheet`
  ADD CONSTRAINT `exam_datesheet_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `examination_halls` (`id`),
  ADD CONSTRAINT `exam_datesheet_ibfk_2` FOREIGN KEY (`superintendent_id`) REFERENCES `superintendents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
