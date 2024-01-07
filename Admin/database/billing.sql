-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2024 at 04:59 AM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
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
  `image` longblob DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` text NOT NULL,
  `delete_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `fname`, `mname`, `lname`, `gender`, `contact`, `email`, `bday`, `address`, `uname`, `password`, `image`, `type`, `date_created`, `code`, `delete_flag`) VALUES
(1, 'Anonymous', NULL, NULL, '', NULL, '', NULL, NULL, 'Admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'Admin', '2024-01-04 02:22:46', '', 0),
(2, 'Jade Ryan', 'L.', 'Blancaflor', '', NULL, 'bryanblancaflor007@gmail.com', NULL, NULL, 'jade123', 'b220e82dde8abcb5dfe247ff49606009', 0x75706c6f6164732f75736572622e706e67, 'Staff', '2024-01-04 02:41:49', '', 0),
(3, 'Maria Angelica', 'M.', 'Rubrico', 'Staff', '093805380538', 'ma.angel@gmail.com', '2003-03-20', 'Imus', '', '$2y$10$aGHr3Oh2nKrfgegz1H1cmOQe9vFPCmyzZlA4yM4ywwAPLwwEglkMG', 0x75706c6f6164732f64617368626f6172642e504e47, 'Staff', '2024-01-02 15:09:56', '', 0),
(4, 'John Paul', 'M', 'Magno', 'Admin', '09380538503', 'monalyh@gmail.com', '2024-01-04', 'Imus', 'admin123', '$2y$10$dOj8B7jDmQu3yL8m1atug.x50.t8iKRpUdDW0QO3DaQtKh7btSHbu', 0x75706c6f6164732f7072696e74736c69702e504e47, 'Admin', '2024-01-04 03:48:41', '', 0);

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
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
  `code` text NOT NULL,
  `datereg` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `transaction_Id`, `fname`, `mname`, `lname`, `bday`, `gender`, `address`, `email`, `contact`, `password`, `status`, `code`, `datereg`, `delete_flag`) VALUES
(1, 202110123, 'Jade Ryan', 'Leba', 'Blancaflor', '0000-00-00', '', '', 'bryanblancaflor007@gmail.com', 0, 'b220e82dde8abcb5dfe247ff49606009', 'Active', '', '2023-12-28 13:28:03', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminId` (`adminId`),
  ADD KEY `usersid` (`usersid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admin` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `complaint_ibfk_2` FOREIGN KEY (`usersid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
