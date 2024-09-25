-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2024 at 07:36 PM
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
-- Database: `qamar_tamer`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(9) NOT NULL,
  `user_id` int(9) DEFAULT NULL,
  `appointment_time` datetime DEFAULT NULL,
  `appointment_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `appointment_time`, `appointment_description`, `created_at`, `updated_at`, `user_name`) VALUES
(11, 206954778, '2024-08-02 11:30:00', 'החלקה', '2024-07-29 08:43:32', '2024-07-29 08:43:32', 'rami tamer'),
(16, 206954788, '2024-08-03 15:55:00', 'החלקה', '2024-07-29 08:55:36', '2024-07-29 08:55:36', 'qamar qamar'),
(17, 206954788, '2024-08-03 15:55:00', 'החלקה', '2024-07-29 09:05:17', '2024-07-29 09:05:17', 'qamar qamar'),
(18, 206954788, '2024-08-11 17:00:00', 'החלקה', '2024-08-10 10:43:59', '2024-08-10 10:43:59', 'qamar qamar'),
(19, 206954894, '2024-08-11 19:00:00', 'החלקה', '2024-08-10 10:46:27', '2024-08-10 10:46:27', 'mariana qamarmariana'),
(20, 212533889, '2024-08-10 15:00:00', 'מילוי ציפורניים', '2024-08-10 10:50:55', '2024-08-10 10:50:55', 'rami cohen'),
(22, 211533889, '2024-09-25 18:00:00', 'איפור כלה', '2024-09-25 13:42:56', '2024-09-25 13:42:56', 'Firas Sayegh'),
(23, 211533889, '2024-09-25 18:00:00', 'תוספת לשיער', '2024-09-25 13:43:24', '2024-09-25 13:43:24', 'Firas Sayegh'),
(24, 212533888, '2024-09-25 18:00:00', 'איפור כלה', '2024-09-25 13:45:05', '2024-09-25 13:45:05', 'qamarrr aborayyyaa'),
(26, 206954122, '2024-09-26 10:00:00', 'איפור כלה', '2024-09-25 16:05:55', '2024-09-25 16:05:55', 'mariana qamar'),
(27, 206954122, '2024-09-26 11:00:00', 'איפור כלה', '2024-09-25 16:06:28', '2024-09-25 16:06:28', 'mariana qamar'),
(28, 206954122, '2024-09-26 10:00:00', 'איפור כלה', '2024-09-25 16:07:41', '2024-09-25 16:07:41', 'mariana qamar'),
(29, 206954122, '2024-09-26 10:00:00', 'תסרוקת כלה', '2024-09-25 16:11:02', '2024-09-25 16:11:02', 'mariana qamar'),
(31, 206954778, '2024-09-30 11:00:00', 'החלקה', '2024-09-25 16:34:12', '2024-09-25 16:34:12', 'rami tamer'),
(32, 206954122, '2024-09-30 12:00:00', 'איפור מקצועי', '2024-09-25 17:01:27', '2024-09-25 17:01:27', 'mariana qamar'),
(33, 206954122, '2024-09-26 18:34:00', 'החלקה', '2024-09-25 17:33:20', '2024-09-25 17:33:20', 'mariana qamar'),
(34, 206954122, '2024-09-26 20:34:00', 'החלקה', '2024-09-25 17:34:12', '2024-09-25 17:34:12', 'mariana qamar');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `Feedback_ID` int(10) NOT NULL,
  `Feedback_Text` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`Feedback_ID`, `Feedback_Text`) VALUES
(1, 'מעולה'),
(2, 'צוות מעלוה תודה רבה מאוד '),
(3, 'מעולה'),
(4, 'אחלה שירות אבל בבקשה רוצים מזגן חדש חם לנו'),
(5, 'השירות לא טוב בכלל מבקש לטפל דחוף'),
(6, 'אחלה צוות'),
(7, 'msh mna7');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `Services_Name` varchar(20) NOT NULL,
  `Services_ID` int(10) NOT NULL,
  `Price` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`Services_Name`, `Services_ID`, `Price`) VALUES
('איפור כלה', 1, 200),
('תסרוקת כלה', 2, 2500),
('איפור מקצועי', 3, 350),
('צביעת שיער', 4, 1000),
('תוספת לשיער', 5, 1200),
('בניית ציפורניים', 7, 250),
('החלקה', 9, 1000),
('מילוי ציפורניים', 13, 130),
('hairr', 17, 2500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(9) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Phone` int(10) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Birthday` date NOT NULL,
  `Address` varchar(40) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `Role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Last_Name`, `Phone`, `Email`, `Birthday`, `Address`, `Password`, `Role`) VALUES
(44445, 'RAGAD', 'RHAL', 525808797, 'ragad@gmail.com', '2024-12-25', 'aa', '$2y$10$K21ZfaiBctwYda9kwGS4geNwles1b6uw4VdUU9l5aQEHCTqOtrzZm', 'user'),
(206954122, 'mariana', 'qamar', 524125234, 'qamar_marianna245@gmail.com', '2007-02-17', 'haifa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(206954778, 'rami', 'tamer', 524785697, 'rami.tamer@gmail.com', '1998-02-25', 'haifa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(206954784, 'qamarr', 'awad', 524586987, 'lamar232@gmail.com', '2024-04-06', 'haifaaa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'admin'),
(206954788, 'qamar', 'qamar', 521452365, 'qamar_2024_qamar@gmail.com', '2011-06-19', 'nazareth', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(206954894, 'mariana', 'qamarmariana', 524024036, 'qamar_mariana24@gmail.com', '2011-01-17', 'haifa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(211533889, 'Firas', 'Sayegh', 524024088, 'feras.feras@gmail.com', '2011-01-17', 'haifa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(212533888, 'qamarrr', 'aborayyyaa', 525808599, 'qamar.2002.q@gmail.com', '2002-08-02', 'sakhnin', '$2y$10$afqBrgiayrreJJDWaTk/AOnCjrFp6zinQj7yu446bXjYRu04UslOq', 'user'),
(212533889, 'rami', 'cohen', 524024085, 'rami.cohen@gmail.com', '2007-01-17', 'haifa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'user'),
(213784192, 'Tamer', 'nicola', 522365891, 'tamer_2024@gmail.com', '2000-07-20', 'haifaaa', '$2y$10$kAFCZ4ftklHDGHxscnE8ZeTKeTD0NCybboUZIGdBHZBaMGtVNdg.q', 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD UNIQUE KEY `Feedback_ID` (`Feedback_ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`Services_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`,`Phone`,`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Feedback_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `Services_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
