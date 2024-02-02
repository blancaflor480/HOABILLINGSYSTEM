-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 03:31 PM
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
  `code` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableaccount`
--

INSERT INTO `tableaccount` (`Id`, `fname`, `mname`, `lname`, `gender`, `contact`, `email`, `bday`, `address`, `uname`, `password`, `copassword`, `image`, `type`, `status`, `date_created`, `code`) VALUES
(1, 'Administrator', NULL, NULL, '', NULL, '', NULL, NULL, 'Admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', NULL, 'Admin', '', '2024-01-10 15:48:07', ''),
(2, 'Jade Ryan', 'L.', 'Blancaflor', 'Male', NULL, 'bryanblancaflor007@gmail.com', NULL, NULL, 'jade123', 'b220e82dde8abcb5dfe247ff49606009', 'b220e82dde8abcb5dfe247ff49606009', 0x696d616765332e706e67, 'Staff', 'Active', '2024-01-24 05:13:50', ''),
(3, 'Maria Angelica', 'M.', 'Rubrico', 'Female', '093805380538', 'ma.angel@gmail.com', '2003-03-20', 'Imus', 'angel123', 'ab1dbd386662b62477b62087a389256a', '$2y$10$aGHr3Oh2nKrfgegz1H1cmOQe9vFPCmyzZlA4yM4ywwAPLwwEglkMG', 0x3430363430313432375f3730353631383034313533313237325f383931373031353531383131373836383934395f6e2e6a7067, 'Staff', 'Active', '2024-01-06 14:09:52', ''),
(4, 'Mona Lyn', 'C', 'Bularon', 'Female', '09380538503', 'monalyh@gmail.com', '2024-01-04', 'Imus', 'mona123', 'ae072073547c70e279230fba9742791c', '$2y$10$dOj8B7jDmQu3yL8m1atug.x50.t8iKRpUdDW0QO3DaQtKh7btSHbu', 0x6d6f6e612e6a7067, 'Admin', '', '2024-01-23 10:58:36', ''),
(5, 'John Paul', 'Allera', 'Magno', 'Admin', NULL, 'baker@gmail.com', NULL, NULL, 'jp123', '$2y$10$juxFaJUDWWjKvu9R.CH/a.EFXkt.nGAKoRaoJZ3.KpE.VCJiXD2Mu', '', 0x75706c6f6164732f54757271756f69736520426569676520486f7573652044657369676e2053747564696f204c6f676f2e706e67, 'Admin', '', '2024-01-07 07:10:32', ''),
(6, 'Bryan', 'L.', 'Blancaflor', 'Female', NULL, 'blancaflor1203@gmail.com', NULL, NULL, 'bry123', '56152d5df8f1f3eec5279955371d9dc3', '', 0x636f6e766572742e6a7067, 'Staff', '', '2024-01-10 15:34:01', ''),
(8, 'kuku', 'M.', 'Blancaflor', 'Admin', NULL, 'baobao17@gmail.com', NULL, NULL, 'kuku123', '$2y$10$.mwIYcg/5GIWbf9rtyAatO8hM/g6Na1hDf.IHNinZKIXKqzpMLR.W', '', 0x75706c6f6164732f6c6f636174696f6e2e706e67, 'Admin', '', '2024-01-10 14:20:59', ''),
(9, 'kristine', 'M.', 'Delmundo123', 'Male', NULL, 'delmundo@gmail.com', NULL, NULL, 'tintin', 'b220e82dde8abcb5dfe247ff49606009', '', 0x6d61646172612e6a7067, 'Admin', '', '2024-01-31 00:11:21', '');

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
-- Table structure for table `tablebilling_list`
--

CREATE TABLE `tablebilling_list` (
  `id` int(30) NOT NULL,
  `tableusers_id` int(30) NOT NULL,
  `reading_date` date NOT NULL,
  `due_date` date NOT NULL,
  `reading` float(12,2) NOT NULL DEFAULT 0.00,
  `previous` float(12,2) NOT NULL DEFAULT 0.00,
  `penalties` float(12,2) NOT NULL DEFAULT 0.00,
  `service` float(12,2) NOT NULL DEFAULT 0.00,
  `total` float(12,2) NOT NULL DEFAULT 0.00,
  `amountpay` float(12,2) NOT NULL DEFAULT 0.00,
  `paymode` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= walkin, 1= online	',
  `referrenceId` varchar(50) NOT NULL,
  `screenshoot` longblob NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= pending,\r\n1= paid',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablebilling_list`
--

INSERT INTO `tablebilling_list` (`id`, `tableusers_id`, `reading_date`, `due_date`, `reading`, `previous`, `penalties`, `service`, `total`, `amountpay`, `paymode`, `referrenceId`, `screenshoot`, `status`, `date_created`, `date_updated`) VALUES
(8, 1, '2024-02-02', '2024-02-29', 100.00, 0.00, 10.00, 10.00, 110.00, 100.00, 0, '', '', 2, '2024-01-28 16:33:25', '2024-02-02 22:26:24'),
(38, 3, '2024-01-30', '2024-01-31', 300.00, 0.00, 0.00, 10.00, 310.00, 310.00, 1, '', '', 1, '2024-01-30 18:20:57', '2024-02-02 22:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `tablecomplaint`
--

CREATE TABLE `tablecomplaint` (
  `Id` int(11) NOT NULL,
  `tableusers_id` int(11) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `typecomplaint` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablecomplaint`
--

INSERT INTO `tablecomplaint` (`Id`, `tableusers_id`, `email`, `typecomplaint`, `description`, `status`, `date_time`) VALUES
(1, 1, '', 'Bill is not accurate \r\n', '', 'unprocessed', '2024-01-11 13:51:36'),
(2, 3, 'bryanblancaflor007@gmail.com', 'audi', 'hahahahhaha', '', '2024-01-02 18:06:24'),
(3, 1, '', 'Transaction not processed', 'ppppppanget', '', '2024-01-01 18:06:32'),
(4, 1, '', 'Bill not correct', 'hahahahahah', 'Unprocessed', '2024-01-25 10:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `tablepayments`
--

CREATE TABLE `tablepayments` (
  `id` int(11) NOT NULL,
  `billing_id` int(30) NOT NULL,
  `amount` float(12,2) NOT NULL,
  `reference_id` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `receipt_path` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablepayments`
--

INSERT INTO `tablepayments` (`id`, `billing_id`, `amount`, `reference_id`, `date_created`, `receipt_path`) VALUES
(1, 8, 200.00, '20110211', '2024-02-02 21:52:24', 0x75706c6f6164732f6d61646172612e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `tablesystem_info`
--

CREATE TABLE `tablesystem_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablesystem_info`
--

INSERT INTO `tablesystem_info` (`id`, `meta_field`, `meta_value`) VALUES
(16, 'name', 'ROSEDALE RESIDENCE');

-- --------------------------------------------------------

--
-- Table structure for table `tableusers`
--

CREATE TABLE `tableusers` (
  `Id` int(11) NOT NULL,
  `transaction_Id` int(100) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `bday` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `copassword` varchar(250) NOT NULL,
  `status` tinyint(50) NOT NULL,
  `category` varchar(250) NOT NULL,
  `image` longblob NOT NULL,
  `code` text NOT NULL,
  `datereg` datetime NOT NULL DEFAULT current_timestamp(),
  `Logintime` timestamp NOT NULL DEFAULT current_timestamp(),
  `logoutime` timestamp NOT NULL DEFAULT current_timestamp(),
  `delete_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableusers`
--

INSERT INTO `tableusers` (`Id`, `transaction_Id`, `fname`, `mname`, `lname`, `bday`, `gender`, `address`, `email`, `contact`, `password`, `copassword`, `status`, `category`, `image`, `code`, `datereg`, `Logintime`, `logoutime`, `delete_flag`) VALUES
(1, 202110123, 'Jade Ryan', 'Leba', 'Blancaflor', '2002-08-17', 'Male', 'Tramo St. Kaingen, Bacoor City of Cavite', 'bryanblancaflor007@gmail.com', '09679559166', '21232f297a57a5a743894a0e4a801fc3', 'b220e82dde8abcb5dfe247ff49606009', 1, 'Residences', 0x313238783132382e706e67, '', '2023-12-28 13:28:03', '2024-01-17 14:14:42', '2024-01-17 14:15:15', 0),
(3, 0, 'Kristine joy', 'M', 'Delmundo', '2003-01-28', 'Female', 'Molino 1, Paula', 'blancaflor480@gmail.com', '09380438403', '21232f297a57a5a743894a0e4a801fc3', '', 1, 'Residences', 0x6d61646172612e6a7067, '', '2024-01-22 22:57:00', '2024-01-22 14:57:00', '2024-01-22 14:57:00', 0),
(5, 0, 'jaderyan', 'leba', 'blancaflor', '2024-01-31', 'Male', 'Kaingen', 'delmundo@gmail.com', '0099999', '21232f297a57a5a743894a0e4a801fc3', '', 0, 'Residences', '', '', '2024-01-27 14:43:55', '2024-01-27 06:43:55', '2024-01-27 06:43:55', 0);

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
-- Indexes for table `tablepayments`
--
ALTER TABLE `tablepayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `tablesystem_info`
--
ALTER TABLE `tablesystem_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tableusers`
--
ALTER TABLE `tableusers`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tableaccount`
--
ALTER TABLE `tableaccount`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tablebilling_list`
--
ALTER TABLE `tablebilling_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tablecomplaint`
--
ALTER TABLE `tablecomplaint`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tablepayments`
--
ALTER TABLE `tablepayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tablesystem_info`
--
ALTER TABLE `tablesystem_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tableusers`
--
ALTER TABLE `tableusers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Constraints for table `tablepayments`
--
ALTER TABLE `tablepayments`
  ADD CONSTRAINT `tablepayments_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `tablebilling_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
