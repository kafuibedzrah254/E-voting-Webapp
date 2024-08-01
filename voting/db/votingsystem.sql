-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 13, 2024 at 12:28 AM
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
-- Database: `votingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--
DROP DATABASE IF EXISTS votingsystem;
CREATE DATABASE votingsystem;
USE votingsystem;
CREATE TABLE `polls` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` varchar(255) NOT NULL,
  `first_option` varchar(255) NOT NULL,
  `second_option` varchar(255) NOT NULL,
  `third_option` varchar(255) NOT NULL,
  `fourth_option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `question`, `first_option`, `second_option`, `third_option`, `fourth_option`) VALUES
(1, 'Richest Man?', 'Messi', 'Ronaldo', 'Mbappe', 'Tevez'),
(2, 'Richest Man?', 'Messi', 'Ronaldo', 'Mbappe', 'Tevez');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `standard` enum('group','single voter','poll creator') NOT NULL,
  `status` int(11) NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `mobile`, `password`, `photo`, `standard`, `status`, `votes`) VALUES
(1, 'bybyj', '0208158255', 'Pa$$w0rd!', '', 'group', 1, 3),
(2, 'weneleruny', '0263164169', 'Pa$$w0rd!', 'ashesi.png', 'group', 0, 2),
(3, 'sepumukav', '0000000000', '1234', 'comp3.png', 'single voter', 1, 0),
(4, 'vusegujo', '0277815825', '4567', 'ddsa.png', 'group', 0, 2),
(5, 'wizakafuwi', '0575102024', 'lego', 'curry.png', 'group', 0, 4),
(6, 'zavorypu', '9999999990', '9999', '', 'single voter', 1, 0),
(7, 'sivydujyma', '7777777777', '7777777777', '', 'single voter', 1, 0),
(8, 'ciguc', '0204561234', '5678', '', 'single voter', 1, 0),
(9, 'kuqyvam', '7878787878', '8888', '', 'poll creator', 0, 0),
(10, 'Bismark Bedzrah', '8090000000', '123456', '', 'poll creator', 0, 0),
(11, 'Kwadwo', '7777777777', '0000', '', 'poll creator', 0, 0),
(12, 'qojeg', '0200000000', 'Pa$$w0rd!', '', 'single voter', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
