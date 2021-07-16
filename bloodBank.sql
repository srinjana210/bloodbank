-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 10, 2021 at 07:31 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodBank`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospitalBloodData`
--

CREATE TABLE `hospitalBloodData` (
  `id` int(11) NOT NULL,
  `AP` int(11) NOT NULL,
  `AN` int(11) NOT NULL,
  `BP` int(11) NOT NULL,
  `BN` int(11) NOT NULL,
  `ABP` int(11) NOT NULL,
  `ABN` int(11) NOT NULL,
  `OP` int(11) NOT NULL,
  `ONeg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospitalBloodData`
--

INSERT INTO `hospitalBloodData` (`id`, `AP`, `AN`, `BP`, `BN`, `ABP`, `ABN`, `OP`, `ONeg`) VALUES
(4, 5, 3, 8, 88, 8, 7, 9, 9),
(5, 55, 2, 3, 4, 5, 6, 7, 8),
(6, 55, 55, 55, 55, 55, 55, 55, 55);

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(61) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `address`, `email`, `password`) VALUES
(4, 'Max Hospital', 'dwarka sector-7', 'max@gmail.com', '$2y$10$rDdNFE5ZF0oerpBI73mtmeVnkkCyrpG1xH2w1C3rb4YO5fZhKOgtO'),
(5, 'Mani Hospital', 'dwarka sector-7', 'mani@gmail.com', '$2y$10$tB3QzchB3HCC.e8vWuREhuM7NpVF.AuJJDm9qEOzJTmO0ifm3jH82'),
(6, 'Aims Hospital', 'dwarka', 'aims@gmail.com', '$2y$10$tdmQCEQHZqiK0jOakf29Z.rzzQ3yvh5wwNUv/OHz87ag6DWSspjTK');

-- --------------------------------------------------------

--
-- Table structure for table `receivers`
--

CREATE TABLE `receivers` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(61) DEFAULT NULL,
  `bloodGroup` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receivers`
--

INSERT INTO `receivers` (`id`, `name`, `email`, `password`, `bloodGroup`) VALUES
(1, 'vipul gupta', 'itsmevipulgupta.2011@gmail.com', '$2y$10$IcrFqWIJYn.RFUxAhO8mVeEOUwfxs4rUZT0K1cZzayJV2f6.E.0ze', 'A+'),
(2, 'anjali gupta', 'itsmevipulgupta@gmail.com', '$2y$10$Ydh9vBQ8MvSbNlOIkPBOzuWduqjkTAQQU.rb47ypXWgaUZtZqqgCW', 'B+'),
(5, 'vipul gupta', 'itsmevipulgupta.201@gmail.com', '$2y$10$55mU0cAO/i.C8u9LfDB2UuAWiSkOUx3Lp/7AhRoxr.AtbJweoi18W', 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `requestedBloods`
--

CREATE TABLE `requestedBloods` (
  `receiverId` int(11) NOT NULL,
  `receiverName` varchar(20) NOT NULL,
  `hospitalId` int(11) NOT NULL,
  `hospitalName` varchar(50) NOT NULL,
  `bloodGroup` varchar(5) NOT NULL,
  `units` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requestedBloods`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `hospitalBloodData`
--
ALTER TABLE `hospitalBloodData`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receivers`
--
ALTER TABLE `receivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `requestedBloods`
--
ALTER TABLE `requestedBloods`
  ADD KEY `hospitalId` (`hospitalId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `receivers`
--
ALTER TABLE `receivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hospitalBloodData`
--
ALTER TABLE `hospitalBloodData`
  ADD CONSTRAINT `hospitalBloodData_ibfk_1` FOREIGN KEY (`id`) REFERENCES `hospitals` (`id`);

--
-- Constraints for table `requestedBloods`
--
ALTER TABLE `requestedBloods`
  ADD CONSTRAINT `requestedBloods_ibfk_1` FOREIGN KEY (`hospitalId`) REFERENCES `hospitals` (`id`),
  ADD CONSTRAINT `requestedBloods_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `receivers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
