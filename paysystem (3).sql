-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 12:07 PM
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
-- Database: `paysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `posted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `description`, `created_at`, `posted_by`) VALUES
(1, 'GATE RESTRICTIONS', 'should pay 80% of the fees each student', '0000-00-00 00:00:00', 'Admin'),
(2, 'GATE RESTRICTIONS', 'be  cooperative on fee payment', '2024-11-28 21:03:58', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `detail` text NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch`, `address`, `detail`, `delete_status`) VALUES
(1, 'Thika Branch', 'Thika Town', 'Located along Thika road ', '0'),
(2, 'Nairobi Branch', 'Nairobi Town', 'Located along Mfangano Street', '0'),
(3, 'mombasa', 'mombasa town', 'opposite white house', '0');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_transaction`
--

CREATE TABLE `fees_transaction` (
  `studentId` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `stdid` varchar(255) NOT NULL,
  `paid` int(11) NOT NULL,
  `submitdate` datetime NOT NULL,
  `transcation_remark` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees_transaction`
--

INSERT INTO `fees_transaction` (`studentId`, `id`, `stdid`, `paid`, `submitdate`, `transcation_remark`) VALUES
('BSCCS/2021/96937', 1, '1', 54000, '2021-09-03 00:00:00', 'great'),
('BBIT/2022/35202', 2, '2', 35000, '2022-09-02 00:00:00', 'great'),
('BBM/2022/35202', 3, '3', 35000, '2022-09-09 00:00:00', ''),
('BIT/2020/1234', 4, '4', 60000, '2020-01-03 00:00:00', 'WELL'),
('BSCCS/2021/4567', 5, '5', 34000, '2021-01-01 00:00:00', ''),
('bbit/2022/30788', 6, '6', 12000, '2022-09-02 00:00:00', 'well'),
('BSCCS/2019/34567', 7, '7', 15000, '2019-01-04 00:00:00', 'trial'),
('BIT/2020/89066', 8, '8', 130000, '2020-09-04 00:00:00', 'well'),
('bbm/2023/30434', 9, '9', 40000, '2023-01-02 00:00:00', 'good'),
('bbit/2022/33409', 10, '10', 36000, '2022-09-08 00:00:00', 'excellent'),
('', 11, '10', 15000, '2025-06-04 00:00:00', ''),
('', 12, '8', 200000, '2025-01-01 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `phone`, `amount`, `status`, `created_at`, `timestamp`) VALUES
(1, '25459429143', 1.00, 'Pending', '2024-11-28 11:22:34', '2024-11-28 14:40:46'),
(2, '25459429143', 1.00, 'Pending', '2024-11-28 11:23:58', '2024-11-28 14:40:46'),
(3, '254759429143', 1.00, 'Paid', '2024-11-28 11:25:35', '2024-11-28 14:40:46'),
(4, '254759429143', 1.00, 'Paid', '2024-11-28 11:34:47', '2024-11-28 14:40:46'),
(5, '254759429143', 1.00, 'Paid', '2024-11-28 17:45:58', '2024-11-28 20:45:58'),
(6, '254759429143', 1.00, 'Not Paid', '2024-11-28 17:46:00', '2024-11-28 20:46:00'),
(7, 'O759429143', 5.00, 'Not Paid', '2024-12-03 17:46:22', '2024-12-03 20:46:22'),
(8, 'O759429143', 5.00, 'Not Paid', '2024-12-03 17:46:48', '2024-12-03 20:46:48'),
(9, '254759429143', 5.00, 'Paid', '2024-12-03 17:47:25', '2024-12-03 20:47:25'),
(10, '254721521448', 5.00, 'Paid', '2024-12-03 17:49:07', '2024-12-03 20:49:07'),
(11, '254759429143', 1.00, 'Paid', '2025-01-08 07:35:55', '2025-01-08 10:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `problem_reports`
--

CREATE TABLE `problem_reports` (
  `report_id` int(11) NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `report_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problem_reports`
--

INSERT INTO `problem_reports` (`report_id`, `student_name`, `student_id`, `problem_description`, `report_date`) VALUES
(1, 'sheillah viselah', 'BBIT/2022/35202', 'my phone is stolen ,check on security', '2025-01-08'),
(2, 'ronnie kiprotich', 'BSCCS/2021/96937', 'good morning sir, kindly update my fees on my student portal.am unable to view the fee structure on my side.', '2025-01-08'),
(3, 'ronnie kiprotich', 'BSCCS/2021/96937', 'fees balance not update', '2025-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentId` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `password` varchar(25) NOT NULL,
  `joindate` datetime NOT NULL,
  `about` text NOT NULL,
  `contact` varchar(255) NOT NULL,
  `fees` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  `delete_status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentId`, `id`, `emailid`, `sname`, `password`, `joindate`, `about`, `contact`, `fees`, `branch`, `balance`, `delete_status`) VALUES
('BSCCS/2021/96937', 1, 'ronalkipro18@gmail.com', 'ronnie kiprotich', '1234', '2021-09-03 00:00:00', '', '0115113920', 120000, '1', 66000, '0'),
('BBIT/2022/35202', 2, 'sheilahvisela@gmail.com', 'sheillah viselah', '1234', '2022-09-02 00:00:00', '', '0759429143', 100000, '1', 65000, '0'),
('BBM/2022/35202', 3, 'winniengutuku@gmail.com', 'winnie Ngutuku', '1234', '2022-09-09 00:00:00', '', '0721521448', 100000, '2', 0, '0'),
('BIT/2020/1234', 4, 'allanonyago@gmail.com', 'allan onyango', '1234', '2020-01-03 00:00:00', '', '0711638478', 120000, '1', 60000, '0'),
('BSCCS/2021/4567', 5, 'faith@gmail.com', 'faith muhune', '1234', '2021-01-01 00:00:00', '', '0740429276', 1270000, '1', 1236000, '0'),
('bbit/2022/30788', 6, 'rowena@gmail.com', 'rowena atemo', '1234', '2022-09-02 00:00:00', '', '075689023', 390000, '2', 378000, '0'),
('BSCCS/2019/34567', 7, 'kerubo@gmail.com', 'damackline kerubo', '1234', '2019-01-04 00:00:00', '', '071238903', 390000, '1', 375000, '0'),
('BIT/2020/89066', 8, 'alvinngutuku@gmail.com', 'Alvin ngutuku', '1234', '2020-09-04 00:00:00', '', '0711390751', 345000, '3', 15000, '0'),
('bbm/2023/30434', 9, 'joseph@gmail.com', 'joseph mwangi', '1234', '2023-01-02 00:00:00', '', '0797966245', 80000, '2', 40000, '0'),
('bbit/2022/33409', 10, 'jacklinejeptoo202@gmail.com', 'Jackline Cheptoo', '1234', '2022-09-08 00:00:00', '', '0725513110', 62550, '1', 11550, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `emailid`, `lastlogin`) VALUES
(1, 'admin', '0c3cc2b229a290c98e6b161a607f48d3', 'Admin', 'admin@gmail.com', '0000-00-00 00:00:00'),
(2, 'parent1', '21232f297a57a5a743894a0e4a801fc3', 'parent1', 'parent1@gmail.com', '0000-00-00 00:00:00'),
(3, 'parent2', '21232f297a57a5a743894a0e4a801fc3', 'parent2', 'parent2@gmail.com', '0000-00-00 00:00:00'),
(4, 'kiprono', '1234', 'Ronnie', 'ronnie@gmail.com', '2024-11-28 11:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'rowena', 'rowena178@gmail.com', '$2y$10$RUdaSN1Q4IBm3w18LKVVqO.ej9EB2.0E0ea/u/RZop1lxBNweiEKG', '2024-11-20 01:45:34'),
(2, 'jeptoo', 'jeptoo1778@gmail.com', '$2y$10$0z0hdut45/YPKMGh0RTa5OxLHTywSsXoo0Vm1J13HGGSVZO4ONGXa', '2024-11-20 01:50:11'),
(3, 'obed', 'obed@gmail.com', '$2y$10$eFf.zYxQTvIXKUVAi8.lkueBXFxOsZKpOL16cb.Mx.YHsdTlK1fgW', '2024-11-28 10:06:36'),
(4, 'sheilahviselah', 'sheilahvisela@gmail.com', '$2y$10$R6C3lUdF.V5Arx8fS3/PAOQJxE1C434sh72EvUAS.3cr4p9oMQo56', '2024-11-28 10:29:37'),
(5, 'jackline cheptoo', 'jacklinejeptoo202@gmail.com', '$2y$10$lJ3wvI10WTTYacUQscQpNOi6IyaY82K6XT.5NMD/dpuevD93bj0nq', '2024-12-02 06:58:56'),
(6, 'WINNIE NGUTUKU', 'winniengutuku@gmail.com', '$2y$10$ABsUe3DXsVftMAox3RihBOBCwgRmq.r.tupfVkH8EmHm.z4X.b7g2', '2024-12-03 17:44:35'),
(7, 'jacky cheptoo', 'jackiecheptoo@gmail.com', '$2y$10$j0o9SFu0QBdjm/.p7RPgvuGpz9CckzqkYGMh5.q.2rQpLtI8s4KKy', '2025-01-08 08:11:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `problem_reports`
--
ALTER TABLE `problem_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_transaction`
--
ALTER TABLE `fees_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `problem_reports`
--
ALTER TABLE `problem_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
