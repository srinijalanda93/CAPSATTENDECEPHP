-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2024 at 12:42 AM
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
-- Database: `caps_christ_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `volunteer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`date`, `status`, `volunteer_id`) VALUES
('2024-09-19', 'Absent', 1000004),
('2024-08-01', 'Absent', 1000002),
('2024-08-01', 'Present', 1000003),
('2024-08-01', 'Absent', 1000004),
('2024-08-01', 'Present', 1000005),
('2024-08-02', 'Absent', 1000002),
('2024-08-02', 'Present', 1000003),
('2024-08-02', 'Absent', 1000004),
('2024-08-02', 'Present', 1000005),
('2024-08-03', 'Present', 1000006),
('2024-08-03', 'Absent', 1000007),
('2024-08-03', 'Present', 1000008),
('2024-08-03', 'Absent', 1000009),
('2024-08-03', 'Present', 1000010),
('2024-08-04', 'Present', 1000011),
('2024-08-04', 'Present', 1000013),
('2024-08-04', 'Absent', 1000014),
('2024-08-05', 'Present', 1000016),
('2024-08-05', 'Present', 1000002),
('2024-08-05', 'Absent', 1000003),
('2024-08-05', 'Present', 1000004);

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `coordinator_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `date_of_joining` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`coordinator_id`, `name`, `email`, `phone_number`, `date_of_joining`) VALUES
(1, 'Jacob Stephan', 'jacobstephan@gmail.com', '9658245821', '2022-01-15'),
(2, 'Sarah Joseph', 'sarajoseph@gmail.com', '9652418274', '2023-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE `mentor` (
  `mentor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `wing_id` int(11) DEFAULT NULL,
  `date_of_joining` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentor`
--

INSERT INTO `mentor` (`mentor_id`, `name`, `email`, `phone_number`, `wing_id`, `date_of_joining`) VALUES
(1001, 'John Doe', 'johndoe@gmail.com', '9658245827', 101, '2021-06-10'),
(1002, 'Jane Smith', 'janesmith@gmail.com', '9876543210', 102, '2022-09-05'),
(1003, 'Michael Johnson', 'michaeljohnson@gmail.com', '9653241582', 103, '2020-11-19'),
(1004, 'Emily Brown', 'emilybrown@gmail.com', '9555826354', 104, '2023-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `team_leader`
--

CREATE TABLE `team_leader` (
  `team_leader_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `wing_id` int(11) DEFAULT NULL,
  `date_of_joining` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_leader`
--

INSERT INTO `team_leader` (`team_leader_id`, `name`, `email`, `phone_number`, `mentor_id`, `wing_id`, `date_of_joining`) VALUES
(100001, 'Alice Johnson', 'alicejohnson@gmail.com', '9658745263', 1001, 101, '2022-04-15'),
(100002, 'Bob Smith', 'bobsmith@gmail.com', '9658243568', 1001, 101, '2023-07-10'),
(200001, 'Charlie Brown', 'charliebrown@gmail.com', '9658245826', 1002, 102, '2021-05-25'),
(200002, 'Diana Lee', 'dianalee@gmail.com', '9875421365', 1002, 102, '2020-09-12'),
(300001, 'Eric Davis', 'ericdavis@gmail.com', '9658241425', 1003, 103, '2022-01-18'),
(300002, 'Fiona Carter', 'fionacarter@gmail.com', '9635241415', 1003, 103, '2023-03-05'),
(400001, 'George Wilson', 'georgewilson@gmail.com', '9865325852', 1004, 104, '2021-11-22'),
(400002, 'Helen Miller', 'helenmiller@gmail.com', '9852524152', 1004, 104, '2023-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `volunteer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `team_leader_id` int(11) DEFAULT NULL,
  `date_of_joining` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`volunteer_id`, `name`, `email`, `phone_number`, `team_leader_id`, `date_of_joining`) VALUES
(0, 'Srinija Landa', 'srinija@gmail.com', '8897178758', 100001, '2024-09-01'),
(1000002, 'Bella Davis', 'belladavis@gmail.com', '9652458754', 100001, '2023-08-15'),
(1000003, 'Charlie Green', 'charlieg@gmail.com', '9856325484', 100002, '2021-05-10'),
(1000004, 'Daisy White', 'daisyw@gmail.com', '9852548754', 100002, '2020-03-19'),
(1000005, 'Emily Brown', 'emilyb@gmail.com', '9658214752', 200001, '2023-01-22'),
(1000006, 'Frank Miller', 'frankm@gmail.com', '9658245872', 200001, '2022-10-30'),
(1000007, 'Grace Johnson', 'gracej@gmail.com', '9584712563', 200002, '2021-12-05'),
(1000008, 'Henry Carter', 'henryc@gmail.com', '9658241852', 200002, '2023-04-15'),
(1000009, 'Ivy Lee', 'ivy@gmail.com', '9012345678', 300001, '2020-09-20'),
(1000010, 'Jack Smith', 'jacksmith@gmail.com', '9856235241', 300001, '2021-06-18'),
(1000011, 'Liam Anderson', 'liamanderson@gmail.com', '9678521463', 300002, '2024-01-15'),
(1000013, 'Noah Wilson', 'noahwilson@gmail.com', '9648753012', 400001, '2023-11-12'),
(1000014, 'Olivia Brown', 'oliviabrown@gmail.com', '9632547890', 400001, '2023-12-05'),
(1000016, 'Jackson Lewis', 'jacksonlewis@gmail.com', '9654178205', 400002, '2024-04-18'),
(121320052, 'Avi kumar', 'avi@gmail.com', '9704531318', 100001, '2024-09-17');

-- --------------------------------------------------------

--
-- Table structure for table `wing`
--

CREATE TABLE `wing` (
  `wing_id` int(11) NOT NULL,
  `wing_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wing`
--

INSERT INTO `wing` (`wing_id`, `wing_name`) VALUES
(101, 'Quantum Computing'),
(102, 'Programming'),
(103, 'Soft Skill'),
(104, 'Financial Education');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`coordinator_id`);

--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD PRIMARY KEY (`mentor_id`),
  ADD KEY `wing_id` (`wing_id`);

--
-- Indexes for table `team_leader`
--
ALTER TABLE `team_leader`
  ADD PRIMARY KEY (`team_leader_id`),
  ADD KEY `mentor_id` (`mentor_id`),
  ADD KEY `wing_id` (`wing_id`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD KEY `team_leader_id` (`team_leader_id`);

--
-- Indexes for table `wing`
--
ALTER TABLE `wing`
  ADD PRIMARY KEY (`wing_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteer` (`volunteer_id`);

--
-- Constraints for table `mentor`
--
ALTER TABLE `mentor`
  ADD CONSTRAINT `mentor_ibfk_1` FOREIGN KEY (`wing_id`) REFERENCES `wing` (`wing_id`);

--
-- Constraints for table `team_leader`
--
ALTER TABLE `team_leader`
  ADD CONSTRAINT `team_leader_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `mentor` (`mentor_id`),
  ADD CONSTRAINT `team_leader_ibfk_2` FOREIGN KEY (`wing_id`) REFERENCES `wing` (`wing_id`);

--
-- Constraints for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD CONSTRAINT `volunteer_ibfk_1` FOREIGN KEY (`team_leader_id`) REFERENCES `team_leader` (`team_leader_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
