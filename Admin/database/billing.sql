-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2024 at 04:32 AM
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
(1, 'Administrator', NULL, NULL, '', NULL, '', NULL, NULL, 'Admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', NULL, 'Admin', '', '2024-01-10 15:48:07', '', 0),
(2, 'Jade Ryan', 'L.', 'Blancaflor', 'Male', NULL, 'bryanblancaflor007@gmail.com', NULL, NULL, 'jade123', '787ef356921f7a10832eba796f20c329', 'b220e82dde8abcb5dfe247ff49606009', 0x696d616765332e706e67, 'Staff', 'Active', '2024-01-10 15:00:07', '', 0),
(3, 'Maria Angelica', 'M.', 'Rubrico', 'Female', '093805380538', 'ma.angel@gmail.com', '2003-03-20', 'Imus', 'angel123', 'ab1dbd386662b62477b62087a389256a', '$2y$10$aGHr3Oh2nKrfgegz1H1cmOQe9vFPCmyzZlA4yM4ywwAPLwwEglkMG', 0x3430363430313432375f3730353631383034313533313237325f383931373031353531383131373836383934395f6e2e6a7067, 'Staff', 'Active', '2024-01-06 14:09:52', '', 0),
(4, 'Mona Lyn', 'C', 'Bularon', 'Female', '09380538503', 'monalyh@gmail.com', '2024-01-04', 'Imus', 'mona123', '72df8e56a8307e2c308808841fcfb3c3', '$2y$10$dOj8B7jDmQu3yL8m1atug.x50.t8iKRpUdDW0QO3DaQtKh7btSHbu', 0x6d6f6e612e6a7067, 'Staff', '', '2024-01-06 04:51:12', '', 0),
(5, 'John Paul', 'Allera', 'Magno', 'Admin', NULL, 'baker@gmail.com', NULL, NULL, 'jp123', '$2y$10$juxFaJUDWWjKvu9R.CH/a.EFXkt.nGAKoRaoJZ3.KpE.VCJiXD2Mu', '', 0x75706c6f6164732f54757271756f69736520426569676520486f7573652044657369676e2053747564696f204c6f676f2e706e67, 'Admin', '', '2024-01-07 07:10:32', '', 0),
(6, 'Bryan', 'L.', 'Blancaflor', 'Female', NULL, 'blancaflor1203@gmail.com', NULL, NULL, 'bry123', '56152d5df8f1f3eec5279955371d9dc3', '', 0x636f6e766572742e6a7067, 'Staff', '', '2024-01-10 15:34:01', '', 0);

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

--
-- Dumping data for table `tablearchives`
--

INSERT INTO `tablearchives` (`Id`, `fname`, `mname`, `lname`, `gender`, `contact`, `email`, `bday`, `address`, `uname`, `password`, `copassword`, `image`, `type`, `status`, `date_created`, `code`, `delete_flag`) VALUES
(8, 'kuku', 'M.', 'Blancaflor', 'Admin', NULL, 'baobao17@gmail.com', NULL, NULL, 'kuku123', '$2y$10$.mwIYcg/5GIWbf9rtyAatO8hM/g6Na1hDf.IHNinZKIXKqzpMLR.W', '', 0x75706c6f6164732f6c6f636174696f6e2e706e67, 'Admin', '', '2024-01-10 14:20:59', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tablebilling_list`
--

CREATE TABLE `tablebilling_list` (
  `id` int(30) NOT NULL,
  `tableusers_id` int(30) NOT NULL,
  `reading_date` date NOT NULL,
  `due_date` date NOT NULL,
  `reading` float(12,2) NOT NULL DEFAULT 0.00,
  `previous` float(12,2) NOT NULL DEFAULT 0.00,
  `rate` float(12,2) NOT NULL DEFAULT 0.00,
  `total` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= pending,\r\n1= paid',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablebilling_list`
--

INSERT INTO `tablebilling_list` (`id`, `tableusers_id`, `reading_date`, `due_date`, `reading`, `previous`, `rate`, `total`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, '2022-04-01', '2022-04-15', 1100.00, 1001.00, 10.75, 1064.25, 0, '2022-05-02 15:14:03', '2024-01-11 10:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `tablecomplaint`
--

CREATE TABLE `tablecomplaint` (
  `Id` int(11) NOT NULL,
  `tableusers_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablecomplaint`
--

INSERT INTO `tablecomplaint` (`Id`, `tableusers_id`, `message`, `status`, `date_time`) VALUES
(1, 1, 'Bill is not accurate \r\n', 'Processed', '2024-01-11 13:51:36');

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
  `contact` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `copassword` varchar(250) NOT NULL,
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

INSERT INTO `tableusers` (`id`, `transaction_Id`, `fname`, `mname`, `lname`, `bday`, `gender`, `address`, `email`, `contact`, `password`, `copassword`, `status`, `category`, `image`, `code`, `datereg`, `delete_flag`) VALUES
(1, 202110123, 'Jade Ryan', 'Leba', 'Blancaflor', '2002-08-17', 'Female', 'Tramo St. Kaingen, Bacoor City of Cavite', 'bryanblancaflor007@gmail.com', '09380538503', 'b220e82dde8abcb5dfe247ff49606009', 'b220e82dde8abcb5dfe247ff49606009', 'Active', 'Residences', 0x77616c6c7061706572666c6172652e636f6d5f77616c6c7061706572202833292e6a7067, '', '2023-12-28 13:28:03', 0),
(2, 0, 'Bryan', 'M.', 'Leba', '0000-00-00', '', '', 'blancaflor480@gmail.com', '', 'b220e82dde8abcb5dfe247ff49606009', '', '', '', '', '', '2024-01-11 14:28:21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tableaccount`
--
ALTER TABLE `tableaccount`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tablebilling_list`
--
ALTER TABLE `tablebilling_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tableusers_id` (`tableusers_id`);

--
-- Indexes for table `tablecomplaint`
--
ALTER TABLE `tablecomplaint`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `tableusers_id` (`tableusers_id`);

--
-- Indexes for table `tableusers`
--
ALTER TABLE `tableusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tableaccount`
--
ALTER TABLE `tableaccount`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tablebilling_list`
--
ALTER TABLE `tablebilling_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tablecomplaint`
--
ALTER TABLE `tablecomplaint`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tableusers`
--
ALTER TABLE `tableusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tablebilling_list`
--
ALTER TABLE `tablebilling_list`
  ADD CONSTRAINT `tableusers_id_fk_bl` FOREIGN KEY (`tableusers_id`) REFERENCES `tableusers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `tablecomplaint`
--
ALTER TABLE `tablecomplaint`
  ADD CONSTRAINT `tablecomplaint_ibfk_1` FOREIGN KEY (`tableusers_id`) REFERENCES `tableusers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
