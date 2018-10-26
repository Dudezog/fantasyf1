-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2018 at 04:21 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fantasyf1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `AdminName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `AdminName`, `Password`, `FirstName`, `LastName`, `Email`) VALUES
(1, 'Dudezog', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'Nick', 'Herzog', 'nherzog1126@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE IF NOT EXISTS `drivers` (
  `DriverID` int(11) NOT NULL AUTO_INCREMENT,
  `DriverName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Salary` int(2) NOT NULL,
  PRIMARY KEY (`DriverID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`DriverID`, `DriverName`, `Salary`) VALUES
(1, 'Lewis Hamilton', 6),
(2, 'Sebastian Vettel', 5),
(3, 'Daniel Ricciardo', 4),
(4, 'Kimi Raikkonen', 4),
(5, 'Valtteri Bottas', 4),
(6, 'Max Verstappen', 4),
(7, 'Sergio Perez', 3),
(8, 'Esteban Ocon', 3),
(9, 'Fernando Alonso', 3),
(10, 'Kevin Magnussen', 2),
(11, 'Romain Grosjean', 2),
(12, 'Stoffel Vandoorne', 2),
(13, 'Nico Hulkenberg', 2),
(14, 'Carlos Sainz', 2),
(15, 'Marcus Ericsson', 1),
(16, 'Brendon Hartley', 1),
(17, 'Sergey Sirotkin', 1),
(18, 'Lance Stroll', 1),
(19, 'Pierre Gasly', 1),
(20, 'Charles Leclerc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `leagues`
--

CREATE TABLE IF NOT EXISTS `leagues` (
  `LeagueID` int(11) NOT NULL AUTO_INCREMENT,
  `LeagueName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ModeratorID` int(11) NOT NULL,
  `IsDraft` tinyint(1) NOT NULL,
  `IsSeason` tinyint(1) NOT NULL,
  `TotalPlayers` int(3) NOT NULL,
  `ActivePlayer` int(11) NOT NULL,
  `LeagueNote` text COLLATE utf8_unicode_ci NOT NULL,
  `CreatedOn` datetime NOT NULL,
  PRIMARY KEY (`LeagueID`),
  KEY `ModeratorID` (`ModeratorID`),
  KEY `ActivePlayer` (`ActivePlayer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `leagues`
--

INSERT INTO `leagues` (`LeagueID`, `LeagueName`, `ModeratorID`, `IsDraft`, `IsSeason`, `TotalPlayers`, `ActivePlayer`, `LeagueNote`, `CreatedOn`) VALUES
(1, 'Test League', 1, 0, 1, 2, 1, 'Testing', '2018-10-10 00:00:00'),
(14, 'League 2', 1, 0, 0, 6, 1, 'League 2 Note', '2018-10-11 16:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
  `MembershipID` int(11) NOT NULL AUTO_INCREMENT,
  `LeagueID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `IsJoined` tinyint(1) NOT NULL,
  PRIMARY KEY (`MembershipID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`MembershipID`, `LeagueID`, `UserID`, `IsJoined`) VALUES
(1, 1, 1, 1),
(9, 14, 1, 1),
(11, 14, 2, 1),
(12, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `picks`
--

CREATE TABLE IF NOT EXISTS `picks` (
  `PickID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `LeagueID` int(11) NOT NULL,
  `RaceNumber` int(2) NOT NULL,
  `DriverID` int(11) NOT NULL,
  `Season` year(4) NOT NULL,
  PRIMARY KEY (`PickID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `picks`
--

INSERT INTO `picks` (`PickID`, `UserID`, `LeagueID`, `RaceNumber`, `DriverID`, `Season`) VALUES
(1, 1, 1, 18, 1, 2018),
(2, 1, 1, 18, 2, 2018),
(15, 1, 1, 19, 14, 2018),
(16, 1, 1, 19, 8, 2018),
(21, 1, 1, 20, 11, 2018),
(22, 1, 1, 20, 10, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `ResultID` int(11) NOT NULL AUTO_INCREMENT,
  `TrackID` int(11) NOT NULL,
  `DriverID` int(11) NOT NULL,
  `QualifyingPoints` int(2) NOT NULL,
  `FastLapPoints` int(2) NOT NULL,
  `PositionChangePoints` int(2) NOT NULL,
  `ResultPoints` int(2) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`ResultID`),
  KEY `TrackID` (`TrackID`),
  KEY `DriverID` (`DriverID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `TrackID` int(11) NOT NULL AUTO_INCREMENT,
  `RaceName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `RaceNumber` int(2) NOT NULL,
  PRIMARY KEY (`TrackID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`TrackID`, `RaceName`, `RaceNumber`) VALUES
(1, 'Australia', 1),
(2, 'Bahrain', 2),
(3, 'China', 3),
(4, 'Azerbaijan', 4),
(5, 'Spain', 5),
(6, 'Monaco', 6),
(7, 'Canada', 7),
(8, 'France', 8),
(9, 'Austria', 9),
(10, 'Great Britain', 10),
(11, 'Germany', 11),
(12, 'Hungary', 12),
(13, 'Belgium', 13),
(14, 'Italy', 14),
(15, 'Singapore', 15),
(16, 'Russia', 16),
(17, 'Japan', 17),
(18, 'United States', 18),
(19, 'Mexico', 19),
(20, 'Brazil', 20),
(21, 'Abu Dhabi', 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(41) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `LastName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FirstName`, `LastName`) VALUES
(1, 'Dudezog', '*196BDEDE2AE4F84CA44C47D54D78478C7E2BD7B7', 'nick@nickherzog.com', 'Nick', 'Herzog'),
(2, 'Test', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'test@email.com', 'John', 'User');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leagues`
--
ALTER TABLE `leagues`
  ADD CONSTRAINT `Foreign Key Users.UserID` FOREIGN KEY (`ModeratorID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `leagues_ibfk_1` FOREIGN KEY (`ActivePlayer`) REFERENCES `users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `Key Foreign to Drivers.DriverID` FOREIGN KEY (`DriverID`) REFERENCES `drivers` (`DriverID`),
  ADD CONSTRAINT `Key Foreign to Tracks.TrackID` FOREIGN KEY (`TrackID`) REFERENCES `tracks` (`TrackID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
