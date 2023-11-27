-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 03:03 PM
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
  `contact` int(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `bday` date DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `fname`, `mname`, `lname`, `gender`, `contact`, `email`, `bday`, `address`, `password`, `type`, `code`) VALUES
(1, NULL, NULL, NULL, '', NULL, 'admin@gmail.com', NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', 'Admin', ''),
(2, 'Jade Ryan', 'L.', 'Blancaflor', 'Male', 999, 'blancaflor1203@gmail.com', '2023-11-01', NULL, '21232f297a57a5a743894a0e4a801fc3', 'Staff', '');

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
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `transaction_Id`, `fname`, `mname`, `lname`, `bday`, `gender`, `address`, `email`, `contact`, `password`, `code`) VALUES
(1, 0, 'Jade Ryan', 'Leba', 'Blancaflor', '0000-00-00', '', 'kaingen', 'bryanblancaflor007@gmail.com', 99389022, 'b220e82dde8abcb5dfe247ff49606009', ''),
(2, 1222233, 'ja', 'jad', 'jjjjjjj', '2023-11-01', 'male', 'kaingen', 'blancaflor007@gmail.com', 9999212, 'Hakdog007', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
