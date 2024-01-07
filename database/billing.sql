-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 05:40 AM
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
-- Database: `billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `id` int(14) NOT NULL,
  `usersid` int(14) NOT NULL,
  `adminId` int(14) NOT NULL,
  `complaint` varchar(140) NOT NULL,
  `stats` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `usersid`, `adminId`, `complaint`, `stats`) VALUES
(1, 1, 1, 'Billing not match', 'Not Process');

-- --------------------------------------------------------

--
-- Table structure for table `tableaccount`
--

CREATE TABLE `tableaccount` (
  `Id` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `bday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `uname` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `copassword` varchar(250) NOT NULL,
  `image` longblob DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` text NOT NULL,
  `delete_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableaccount`
--

INSERT INTO `tableaccount` (`Id`, `fname`, `mname`, `lname`, `gender`, `contact`, `email`, `bday`, `address`, `uname`, `password`, `copassword`, `image`, `type`, `status`, `date_created`, `code`, `delete_flag`) VALUES
(1, 'Anonymous', NULL, NULL, '', NULL, '', NULL, NULL, 'Admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', NULL, 'Admin', '', '2024-01-06 04:16:43', '', 0),
(2, 'Jade Ryan', 'L.', 'Blancaflor', 'Male', NULL, 'bryanblancaflor007@gmail.com', NULL, NULL, 'jade123', 'e4245c55cca03ed92731c4e29fca20cc', 'b220e82dde8abcb5dfe247ff49606009', 0x32303233313130395f3137353633362e6a7067, 'Staff', 'Active', '2024-01-06 14:09:55', '', 0),
(3, 'Maria Angelica', 'M.', 'Rubrico', 'Female', '093805380538', 'ma.angel@gmail.com', '2003-03-20', 'Imus', 'angel123', 'ab1dbd386662b62477b62087a389256a', '$2y$10$aGHr3Oh2nKrfgegz1H1cmOQe9vFPCmyzZlA4yM4ywwAPLwwEglkMG', 0x3430363430313432375f3730353631383034313533313237325f383931373031353531383131373836383934395f6e2e6a7067, 'Staff', 'Active', '2024-01-06 14:09:52', '', 0),
(4, 'Mona Lyn', 'C', 'Bularon', 'Female', '09380538503', 'monalyh@gmail.com', '2024-01-04', 'Imus', 'mona123', '72df8e56a8307e2c308808841fcfb3c3', '$2y$10$dOj8B7jDmQu3yL8m1atug.x50.t8iKRpUdDW0QO3DaQtKh7btSHbu', 0x6d6f6e612e6a7067, 'Staff', '', '2024-01-06 04:51:12', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tablearchives`
--

CREATE TABLE `tablearchives` (
  `Id` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `gender` varchar(50) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `bday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `uname` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `copassword` varchar(250) NOT NULL,
  `image` longblob DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` text NOT NULL,
  `delete_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tableusers`
--

CREATE TABLE `tableusers` (
  `id` int(11) NOT NULL,
  `transaction_Id` int(100) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `bday` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `category` varchar(250) NOT NULL,
  `image` longblob NOT NULL,
  `code` text NOT NULL,
  `datereg` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableusers`
--

INSERT INTO `tableusers` (`id`, `transaction_Id`, `fname`, `mname`, `lname`, `bday`, `gender`, `address`, `email`, `contact`, `password`, `status`, `category`, `image`, `code`, `datereg`, `delete_flag`) VALUES
(1, 202110123, 'Jade Ryan', 'Leba', 'Blancaflor', '2002-08-17', '', '', 'bryanblancaflor007@gmail.com', 0, 'b220e82dde8abcb5dfe247ff49606009', 'Active', 'Residents', '', '', '2023-12-28 13:28:03', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminId` (`adminId`),
  ADD KEY `usersid` (`usersid`);

--
-- Indexes for table `tableaccount`
--
ALTER TABLE `tableaccount`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tableusers`
--
ALTER TABLE `tableusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tableaccount`
--
ALTER TABLE `tableaccount`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tableusers`
--
ALTER TABLE `tableusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `tableaccount` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaint_ibfk_2` FOREIGN KEY (`usersid`) REFERENCES `tableusers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
