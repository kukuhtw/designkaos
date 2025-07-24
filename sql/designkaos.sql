-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2025 at 03:37 PM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 8.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `designkaos`
--

-- --------------------------------------------------------

--
-- Table structure for table `masterdesign`
--

CREATE TABLE `masterdesign` (
  `id` int NOT NULL,
  `titledesign` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `imagesdesign` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ispublish` tinyint(1) NOT NULL DEFAULT '1',
  `submitdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterdesign`
--


--
-- Table structure for table `msadmin`
--

CREATE TABLE `msadmin` (
  `adminid` int NOT NULL,
  `loginadmin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `loginpassword` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int NOT NULL,
  `titleperson` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `person_images` text COLLATE utf8mb4_general_ci NOT NULL,
  `submitdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--


-- --------------------------------------------------------

--
-- Table structure for table `photosample`
--

CREATE TABLE `photosample` (
  `id` int NOT NULL,
  `predictionid` text COLLATE utf8mb4_general_ci NOT NULL,
  `designid` int NOT NULL,
  `personid` int NOT NULL,
  `urlimagesdesign` text COLLATE utf8mb4_general_ci NOT NULL,
  `urlimagesperson` text COLLATE utf8mb4_general_ci NOT NULL,
  `imagesresult` text COLLATE utf8mb4_general_ci NOT NULL,
  `ispublish` tinyint(1) NOT NULL,
  `generateddate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'REPLICATE_API_TOKEN', '........'),
(2, 'HOST_DOMAIN', 'https://yourdomain.com/yourfolder/public');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `masterdesign`
--
ALTER TABLE `masterdesign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `msadmin`
--
ALTER TABLE `msadmin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photosample`
--
ALTER TABLE `photosample`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `masterdesign`
--
ALTER TABLE `masterdesign`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `msadmin`
--
ALTER TABLE `msadmin`
  MODIFY `adminid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `photosample`
--
ALTER TABLE `photosample`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
