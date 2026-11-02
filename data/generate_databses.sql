-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 29, 2026 at 02:54 PM
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
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `ID` int(3) NOT NULL,
  `Address` varchar(80) DEFAULT NULL,
  `Town` varchar(38) DEFAULT NULL,
  `Postcode` varchar(11) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `CompanyID` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ethos`
--

CREATE TABLE `ethos` (
  `ID` int(11) NOT NULL,
  `CompanyID` int(6) NOT NULL,
  `Ethos` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ethosList`
--

CREATE TABLE `ethosList` (
  `ID` int(2) NOT NULL,
  `Name` varchar(17) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firms`
--

CREATE TABLE `firms` (
  `Company` varchar(50) NOT NULL,
  `CompanySimple` varchar(20) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `Phone` varchar(39) DEFAULT NULL,
  `website` varchar(128) DEFAULT NULL,
  `Placement List` varchar(216) DEFAULT NULL,
  `ID` int(4) NOT NULL,
  `Logo` varchar(60) DEFAULT NULL,
  `Hide` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `ID` int(11) NOT NULL,
  `CompanyID` int(6) NOT NULL,
  `History` int(2) NOT NULL,
  `YEAR` int(4) NOT NULL DEFAULT 2026,
  `MONTH` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historyList`
--

CREATE TABLE `historyList` (
  `ID` int(2) NOT NULL,
  `Name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postcodeCoordsEN`
--

CREATE TABLE `postcodeCoordsEN` (
  `EASTING` varchar(8) DEFAULT NULL,
  `NORTHING` varchar(9) DEFAULT NULL,
  `postcode_district` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `ID` int(2) NOT NULL,
  `Source` varchar(139) DEFAULT NULL,
  `CompanyID` int(3) DEFAULT NULL,
  `Resources` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resourcesList`
--

CREATE TABLE `resourcesList` (
  `ID` int(1) NOT NULL,
  `Type` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `ID` int(7) NOT NULL,
  `CompanyID` int(6) NOT NULL,
  `Sectors` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectorsList`
--

CREATE TABLE `sectorsList` (
  `ID` int(2) NOT NULL,
  `Name` varchar(19) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizesList`
--

CREATE TABLE `sizesList` (
  `ID` int(11) NOT NULL,
  `Name` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `ID` int(1) NOT NULL,
  `Type ID` int(1) NOT NULL,
  `Company ID` int(1) NOT NULL,
  `Name` varchar(37) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `socialsList`
--

CREATE TABLE `socialsList` (
  `ID` int(1) NOT NULL,
  `Type` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weighting`
--

CREATE TABLE `weighting` (
  `ID` int(1) NOT NULL,
  `Rating` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CompanyID` (`CompanyID`),
  ADD KEY `Town` (`Town`,`Postcode`);

--
-- Indexes for table `ethos`
--
ALTER TABLE `ethos`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CompanyID-Ethos` (`CompanyID`,`Ethos`) USING BTREE,
  ADD KEY `Ethos` (`Ethos`),
  ADD KEY `CompanyID` (`CompanyID`);

--
-- Indexes for table `ethosList`
--
ALTER TABLE `ethosList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `firms`
--
ALTER TABLE `firms`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Company` (`Company`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CompanyID` (`CompanyID`),
  ADD KEY `History` (`History`);

--
-- Indexes for table `historyList`
--
ALTER TABLE `historyList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `postcodeCoordsEN`
--
ALTER TABLE `postcodeCoordsEN`
  ADD PRIMARY KEY (`postcode_district`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Source` (`Source`,`Resources`),
  ADD KEY `Resource Type` (`CompanyID`),
  ADD KEY `Resources` (`Resources`);

--
-- Indexes for table `resourcesList`
--
ALTER TABLE `resourcesList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Type` (`Type`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CompanyID-Sectors` (`CompanyID`,`Sectors`) USING BTREE,
  ADD KEY `Sectors` (`Sectors`),
  ADD KEY `CompanyID` (`CompanyID`);

--
-- Indexes for table `sectorsList`
--
ALTER TABLE `sectorsList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `sizesList`
--
ALTER TABLE `sizesList`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `Type ID` (`Type ID`,`Company ID`),
  ADD KEY `Company ID` (`Company ID`);

--
-- Indexes for table `socialsList`
--
ALTER TABLE `socialsList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Type` (`Type`);

--
-- Indexes for table `weighting`
--
ALTER TABLE `weighting`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ethos`
--
ALTER TABLE `ethos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ethosList`
--
ALTER TABLE `ethosList`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firms`
--
ALTER TABLE `firms`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historyList`
--
ALTER TABLE `historyList`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resourcesList`
--
ALTER TABLE `resourcesList`
  MODIFY `ID` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectorsList`
--
ALTER TABLE `sectorsList`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizesList`
--
ALTER TABLE `sizesList`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `ID` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weighting`
--
ALTER TABLE `weighting`
  MODIFY `ID` int(1) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ethos`
--
ALTER TABLE `ethos`
  ADD CONSTRAINT `ethos_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ethos_ibfk_2` FOREIGN KEY (`Ethos`) REFERENCES `ethosList` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`History`) REFERENCES `historyList` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resources_ibfk_2` FOREIGN KEY (`Resources`) REFERENCES `resourcesList` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `sectors_ibfk_1` FOREIGN KEY (`CompanyID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sectors_ibfk_2` FOREIGN KEY (`Sectors`) REFERENCES `sectorsList` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `socials_ibfk_1` FOREIGN KEY (`Company ID`) REFERENCES `firms` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `socials_ibfk_2` FOREIGN KEY (`Type ID`) REFERENCES `socialsList` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Database: `test_public`
--
CREATE DATABASE IF NOT EXISTS `test_public` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test_public`;

-- --------------------------------------------------------

--
-- Table structure for table `Submissions`
--

CREATE TABLE `Submissions` (
  `ID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `Submission` text NOT NULL,
  `user` int(6) NOT NULL,
  `Moderation-conclusion` tinyint(1) DEFAULT NULL,
  `Moderation-date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Submissions`
--
ALTER TABLE `Submissions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Submissions`
--
ALTER TABLE `Submissions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Submissions`
--
ALTER TABLE `Submissions`
  ADD CONSTRAINT `Submissions_ibfk_1` FOREIGN KEY (`user`) REFERENCES `test_users`.`UserList` (`ID`);
--
-- Database: `test_users`
--
CREATE DATABASE IF NOT EXISTS `test_users` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test_users`;

-- --------------------------------------------------------

--
-- Table structure for table `Blocklist`
--

CREATE TABLE `Blocklist` (
  `ID` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `IPLog`
--

CREATE TABLE `IPLog` (
  `ID` int(11) NOT NULL,
  `IP` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `UserList`
--

CREATE TABLE `UserList` (
  `ID` int(11) NOT NULL,
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Blocklist`
--
ALTER TABLE `Blocklist`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `IPLog`
--
ALTER TABLE `IPLog`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user` (`user`),
  ADD KEY `IP` (`IP`);

--
-- Indexes for table `UserList`
--
ALTER TABLE `UserList`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Blocklist`
--
ALTER TABLE `Blocklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `IPLog`
--
ALTER TABLE `IPLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserList`
--
ALTER TABLE `UserList`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Blocklist`
--
ALTER TABLE `Blocklist`
  ADD CONSTRAINT `Blocklist_ibfk_1` FOREIGN KEY (`user`) REFERENCES `UserList` (`ID`);

--
-- Constraints for table `IPLog`
--
ALTER TABLE `IPLog`
  ADD CONSTRAINT `IPLog_ibfk_1` FOREIGN KEY (`user`) REFERENCES `UserList` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
