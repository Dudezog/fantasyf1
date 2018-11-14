-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2018 at 12:30 AM
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
-- Table structure for table `champions`
--

CREATE TABLE IF NOT EXISTS `champions` (
  `ChampionID` int(11) NOT NULL AUTO_INCREMENT,
  `LeagueID` int(11) NOT NULL,
  `Season` year(4) NOT NULL,
  `Winner1UserID` int(11) DEFAULT NULL,
  `Winner2UserID` int(11) DEFAULT NULL,
  `ChampionUserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ChampionID`),
  KEY `LeagueID` (`LeagueID`),
  KEY `Winner1UserID` (`Winner1UserID`),
  KEY `Winner2UserID` (`Winner2UserID`),
  KEY `ChampionUserID` (`ChampionUserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `champions`
--

INSERT INTO `champions` (`ChampionID`, `LeagueID`, `Season`, `Winner1UserID`, `Winner2UserID`, `ChampionUserID`) VALUES
(3, 1, 2018, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `constructors`
--

CREATE TABLE IF NOT EXISTS `constructors` (
  `ConstructorID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Logo` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Flag` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ConstructorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `constructors`
--

INSERT INTO `constructors` (`ConstructorID`, `Name`, `Logo`, `Flag`) VALUES
(1, 'Ferrari', '\\images\\constructors\\ferrari_logo.jpg', '\\images\\constructors\\ferrari_flag.jpg'),
(2, 'Mercedes', '\\images\\constructors\\merc_logo.jpg', '\\images\\constructors\\merc_flag.png'),
(3, 'Red Bull', '\\images\\constructors\\redbull_logo.jpg', '\\images\\constructors\\redbull_flag.gif'),
(4, 'Renault', '\\images\\constructors\\renault_logo.jpg', '\\images\\constructors\\renault_flag.gif'),
(5, 'McLaren', '\\images\\constructors\\mclaren_logo.jpg', '\\images\\constructors\\mclaren_flag.jpg'),
(6, 'Force India', '\\images\\constructors\\force_india_logo.jpg', '\\images\\constructors\\force_india_flag.jpg'),
(7, 'Haas', '\\images\\constructors\\haas_logo.jpg', '\\images\\constructors\\hass_flag.jpg'),
(8, 'Sauber', '\\images\\constructors\\sauber_logo.jpg', '\\images\\constructors\\sauber_flag.jpg'),
(9, 'Torro Rosso', '\\images\\constructors\\torro_logo.jpg', '\\images\\constructors\\torro_flag.jpg'),
(10, 'Williams', '\\images\\constructors\\williams_logo.jpg', '\\images\\constructors\\williams_flag.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE IF NOT EXISTS `drivers` (
  `DriverID` int(11) NOT NULL AUTO_INCREMENT,
  `DriverName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ConstructorID` int(11) NOT NULL,
  `Salary` int(2) NOT NULL,
  PRIMARY KEY (`DriverID`),
  KEY `ConstructorID` (`ConstructorID`),
  KEY `ConstructorID_2` (`ConstructorID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`DriverID`, `DriverName`, `ConstructorID`, `Salary`) VALUES
(0, 'No Pick', 0, 0),
(1, 'Lewis Hamilton', 2, 6),
(2, 'Sebastian Vettel', 1, 5),
(3, 'Daniel Ricciardo', 3, 4),
(4, 'Kimi Raikkonen', 1, 4),
(5, 'Valtteri Bottas', 2, 4),
(6, 'Max Verstappen', 3, 4),
(7, 'Sergio Perez', 6, 3),
(8, 'Esteban Ocon', 6, 3),
(9, 'Fernando Alonso', 5, 3),
(10, 'Kevin Magnussen', 7, 2),
(11, 'Romain Grosjean', 7, 2),
(12, 'Stoffel Vandoorne', 5, 2),
(13, 'Nico Hulkenberg', 4, 2),
(14, 'Carlos Sainz', 4, 2),
(15, 'Marcus Ericsson', 8, 1),
(16, 'Brendon Hartley', 9, 1),
(17, 'Sergey Sirotkin', 10, 1),
(18, 'Lance Stroll', 10, 1),
(19, 'Pierre Gasly', 9, 1),
(20, 'Charles Leclerc', 8, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`MembershipID`, `LeagueID`, `UserID`, `IsJoined`) VALUES
(1, 1, 1, 1),
(9, 14, 1, 1),
(11, 14, 2, 1),
(12, 1, 2, 1),
(13, 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `picks`
--

CREATE TABLE IF NOT EXISTS `picks` (
  `PickID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `LeagueID` int(11) NOT NULL,
  `TrackID` int(2) NOT NULL,
  `DriverID` int(11) NOT NULL,
  `Season` year(4) NOT NULL,
  PRIMARY KEY (`PickID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=93 ;

--
-- Dumping data for table `picks`
--

INSERT INTO `picks` (`PickID`, `UserID`, `LeagueID`, `TrackID`, `DriverID`, `Season`) VALUES
(1, 1, 1, 18, 17, 2018),
(2, 1, 1, 18, 2, 2018),
(15, 1, 1, 19, 14, 2018),
(16, 1, 1, 19, 8, 2018),
(41, 1, 1, 17, 4, 2018),
(42, 1, 1, 17, 20, 2018),
(43, 2, 1, 18, 3, 2018),
(44, 2, 1, 18, 4, 2018),
(47, 4, 1, 0, 0, 2018),
(48, 4, 1, 0, 0, 2018),
(49, 4, 1, 1, 0, 2018),
(50, 4, 1, 1, 0, 2018),
(51, 4, 1, 2, 0, 2018),
(52, 4, 1, 2, 0, 2018),
(53, 4, 1, 3, 0, 2018),
(54, 4, 1, 3, 0, 2018),
(55, 4, 1, 4, 0, 2018),
(56, 4, 1, 4, 0, 2018),
(57, 4, 1, 5, 0, 2018),
(58, 4, 1, 5, 0, 2018),
(59, 4, 1, 6, 0, 2018),
(60, 4, 1, 6, 0, 2018),
(61, 4, 1, 7, 0, 2018),
(62, 4, 1, 7, 0, 2018),
(63, 4, 1, 8, 0, 2018),
(64, 4, 1, 8, 0, 2018),
(65, 4, 1, 9, 0, 2018),
(66, 4, 1, 9, 0, 2018),
(67, 4, 1, 10, 0, 2018),
(68, 4, 1, 10, 0, 2018),
(69, 4, 1, 11, 0, 2018),
(70, 4, 1, 11, 0, 2018),
(71, 4, 1, 12, 0, 2018),
(72, 4, 1, 12, 0, 2018),
(73, 4, 1, 13, 0, 2018),
(74, 4, 1, 13, 0, 2018),
(75, 4, 1, 14, 0, 2018),
(76, 4, 1, 14, 0, 2018),
(77, 4, 1, 15, 0, 2018),
(78, 4, 1, 15, 0, 2018),
(79, 4, 1, 16, 0, 2018),
(80, 4, 1, 16, 0, 2018),
(81, 4, 1, 17, 0, 2018),
(82, 4, 1, 17, 0, 2018),
(83, 4, 1, 18, 0, 2018),
(84, 4, 1, 18, 0, 2018),
(85, 4, 1, 19, 0, 2018),
(86, 4, 1, 19, 0, 2018),
(87, 4, 1, 20, 2, 2018),
(88, 4, 1, 20, 1, 2018),
(91, 1, 1, 20, 2, 2018),
(92, 1, 1, 20, 1, 2018);

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
  `RaceFinishPoints` int(2) NOT NULL,
  `Total` int(11) NOT NULL,
  `Season` year(4) NOT NULL,
  PRIMARY KEY (`ResultID`),
  KEY `TrackID` (`TrackID`),
  KEY `DriverID` (`DriverID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=565 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`ResultID`, `TrackID`, `DriverID`, `QualifyingPoints`, `FastLapPoints`, `PositionChangePoints`, `RaceFinishPoints`, `Total`, `Season`) VALUES
(0, 0, 0, 0, 0, 0, 0, -15, 2018),
(1, 1, 0, 0, 0, 0, 0, -15, 2018),
(2, 2, 0, 0, 0, 0, 0, -15, 2018),
(3, 3, 0, 0, 0, 0, 0, -15, 2018),
(4, 4, 0, 0, 0, 0, 0, -15, 2018),
(5, 5, 0, 0, 0, 0, 0, -15, 2018),
(6, 6, 0, 0, 0, 0, 0, -15, 2018),
(7, 7, 0, 0, 0, 0, 0, -15, 2018),
(8, 8, 0, 0, 0, 0, 0, -15, 2018),
(9, 9, 0, 0, 0, 0, 0, -15, 2018),
(10, 10, 0, 0, 0, 0, 0, -15, 2018),
(11, 11, 0, 0, 0, 0, 0, -15, 2018),
(12, 12, 0, 0, 0, 0, 0, -15, 2018),
(13, 13, 0, 0, 0, 0, 0, -15, 2018),
(14, 14, 0, 0, 0, 0, 0, -15, 2018),
(15, 15, 0, 0, 0, 0, 0, -15, 2018),
(16, 16, 0, 0, 0, 0, 0, -15, 2018),
(17, 17, 0, 0, 0, 0, 0, -15, 2018),
(18, 18, 0, 0, 0, 0, 0, -15, 2018),
(20, 20, 0, 0, 0, 0, 0, -15, 2018),
(123, 0, 1, 5, 0, -2, 38, 41, 2018),
(124, 0, 5, 0, 0, 14, 12, 26, 2018),
(125, 0, 2, 0, 0, 4, 50, 54, 2018),
(126, 0, 4, 0, 0, -2, 30, 28, 2018),
(127, 0, 3, 0, 2, 8, 24, 34, 2018),
(128, 0, 6, 0, 0, -4, 16, 12, 2018),
(129, 0, 20, 0, 0, 10, 6, 16, 2018),
(130, 0, 15, 0, 0, -15, 0, -15, 2018),
(131, 0, 10, 0, 0, -15, 0, -15, 2018),
(132, 0, 11, 0, 0, -15, 0, -15, 2018),
(133, 0, 8, 0, 0, 4, 8, 12, 2018),
(134, 0, 7, 0, 0, 2, 8, 10, 2018),
(135, 0, 13, 0, 0, 0, 14, 14, 2018),
(136, 0, 14, 0, 0, -2, 10, 8, 2018),
(137, 0, 9, 0, 0, 10, 20, 30, 2018),
(138, 0, 12, 0, 0, 4, 10, 14, 2018),
(139, 0, 17, 0, 0, -15, 0, -15, 2018),
(140, 0, 18, 0, 0, -2, 6, 4, 2018),
(141, 0, 19, 0, 0, -15, 0, -15, 2018),
(142, 0, 16, 0, 0, 2, 4, 6, 2018),
(143, 1, 1, 0, 0, 12, 30, 42, 2018),
(144, 1, 5, 0, 2, 2, 38, 42, 2018),
(145, 1, 2, 5, 0, 0, 50, 55, 2018),
(146, 1, 4, 0, 0, -15, 0, -15, 2018),
(147, 1, 3, 0, 0, -15, 0, -15, 2018),
(148, 1, 6, 0, 0, -15, 0, -15, 2018),
(149, 1, 20, 0, 0, 14, 8, 22, 2018),
(150, 1, 15, 0, 0, 16, 10, 26, 2018),
(151, 1, 10, 0, 0, 2, 20, 22, 2018),
(152, 1, 11, 0, 0, 6, 6, 12, 2018),
(153, 1, 8, 0, 0, -4, 10, 6, 2018),
(154, 1, 7, 0, 0, -8, 4, -4, 2018),
(155, 1, 13, 0, 0, 2, 16, 18, 2018),
(156, 1, 14, 0, 0, -2, 8, 6, 2018),
(157, 1, 9, 0, 0, 12, 14, 26, 2018),
(158, 1, 12, 0, 0, 12, 12, 24, 2018),
(159, 1, 17, 0, 0, 6, 4, 10, 2018),
(160, 1, 18, 0, 0, 12, 6, 18, 2018),
(161, 1, 19, 0, 0, 2, 24, 26, 2018),
(162, 1, 16, 0, 0, -12, 2, -10, 2018),
(163, 2, 1, 0, 0, 0, 24, 24, 2018),
(164, 2, 5, 0, 0, 2, 38, 40, 2018),
(165, 2, 2, 5, 0, -14, 12, 3, 2018),
(166, 2, 4, 0, 0, -2, 30, 28, 2018),
(167, 2, 3, 0, 2, 10, 50, 62, 2018),
(168, 2, 6, 0, 0, 0, 20, 20, 2018),
(169, 2, 20, 0, 0, 0, 1, 1, 2018),
(170, 2, 15, 0, 0, 8, 4, 12, 2018),
(171, 2, 10, 0, 0, 2, 10, 12, 2018),
(172, 2, 11, 0, 0, -14, 2, -12, 2018),
(173, 2, 8, 0, 0, 2, 8, 10, 2018),
(174, 2, 7, 0, 0, -8, 8, 0, 2018),
(175, 2, 13, 0, 0, 2, 16, 18, 2018),
(176, 2, 14, 0, 0, 0, 10, 10, 2018),
(177, 2, 9, 0, 0, 12, 14, 26, 2018),
(178, 2, 12, 0, 0, 2, 6, 8, 2018),
(179, 2, 17, 0, 0, 2, 4, 6, 2018),
(180, 2, 18, 0, 0, 8, 6, 14, 2018),
(181, 2, 19, 0, 0, -2, 2, 0, 2018),
(182, 2, 16, 0, 0, -10, 1, -9, 2018),
(183, 3, 1, 0, 0, 2, 50, 52, 2018),
(184, 3, 5, 0, 2, -22, 6, -14, 2018),
(185, 3, 2, 5, 0, -6, 24, 23, 2018),
(186, 3, 4, 0, 0, 8, 38, 46, 2018),
(187, 3, 3, 0, 0, -15, 0, -15, 2018),
(188, 3, 6, 0, 0, -15, 0, -15, 2018),
(189, 3, 20, 0, 0, 14, 16, 30, 2018),
(190, 3, 15, 0, 0, 14, 8, 22, 2018),
(191, 3, 10, 0, 0, 4, 6, 10, 2018),
(192, 3, 11, 0, 0, -15, 0, -15, 2018),
(193, 3, 8, 0, 0, -15, 0, -15, 2018),
(194, 3, 7, 0, 0, 10, 30, 40, 2018),
(195, 3, 13, 0, 0, -15, 0, -15, 2018),
(196, 3, 14, 0, 0, 8, 20, 28, 2018),
(197, 3, 9, 0, 0, 10, 14, 24, 2018),
(198, 3, 12, 0, 0, 14, 10, 24, 2018),
(199, 3, 17, 0, 0, -15, 0, -15, 2018),
(200, 3, 18, 0, 0, 4, 12, 16, 2018),
(201, 3, 19, 0, 0, 10, 8, 18, 2018),
(202, 3, 16, 0, 0, 18, 10, 28, 2018),
(223, 4, 1, 5, 0, 0, 50, 55, 2018),
(224, 4, 5, 0, 0, 0, 38, 38, 2018),
(225, 4, 2, 0, 0, -2, 24, 22, 2018),
(226, 4, 4, 0, 0, -15, 0, -15, 2018),
(227, 4, 3, 0, 2, 2, 20, 24, 2018),
(228, 4, 6, 0, 0, 4, 30, 34, 2018),
(229, 4, 20, 0, 0, 8, 10, 18, 2018),
(230, 4, 15, 0, 0, 8, 6, 14, 2018),
(231, 4, 10, 0, 0, 2, 16, 18, 2018),
(232, 4, 11, 0, 0, -15, 0, -15, 2018),
(233, 4, 8, 0, 0, -15, 0, -15, 2018),
(234, 4, 7, 0, 0, 12, 10, 22, 2018),
(235, 4, 13, 0, 0, -15, 0, -15, 2018),
(236, 4, 14, 0, 0, 4, 14, 18, 2018),
(237, 4, 9, 0, 0, 0, 12, 12, 2018),
(238, 4, 12, 0, 0, -15, 0, -15, 2018),
(239, 4, 17, 0, 0, 10, 6, 16, 2018),
(240, 4, 18, 0, 0, 14, 8, 22, 2018),
(241, 4, 19, 0, 0, -15, 0, -15, 2018),
(242, 4, 16, 0, 0, 16, 8, 24, 2018),
(243, 5, 1, 0, 0, 0, 30, 30, 2018),
(244, 5, 5, 0, 0, 0, 20, 20, 2018),
(245, 5, 2, 0, 0, 0, 38, 38, 2018),
(246, 5, 4, 0, 0, 0, 24, 24, 2018),
(247, 5, 3, 5, 0, 0, 50, 55, 2018),
(248, 5, 6, 0, 2, 22, 10, 34, 2018),
(249, 5, 20, 0, 0, -8, 2, -6, 2018),
(250, 5, 15, 0, 0, 10, 8, 18, 2018),
(251, 5, 10, 0, 0, 12, 6, 18, 2018),
(252, 5, 11, 0, 0, 6, 4, 10, 2018),
(253, 5, 8, 0, 0, 0, 16, 16, 2018),
(254, 5, 7, 0, 0, -6, 8, 2, 2018),
(255, 5, 13, 0, 0, 6, 12, 18, 2018),
(256, 5, 14, 0, 0, -4, 10, 6, 2018),
(257, 5, 9, 0, 0, -15, 0, -15, 2018),
(258, 5, 12, 0, 0, -4, 6, 2, 2018),
(259, 5, 17, 0, 0, -6, 4, -2, 2018),
(260, 5, 18, 0, 0, 0, 2, 2, 2018),
(261, 5, 19, 0, 0, 6, 14, 20, 2018),
(262, 5, 16, 0, 0, -8, 1, -7, 2018),
(263, 6, 1, 0, 0, -2, 20, 18, 2018),
(264, 6, 5, 0, 0, 0, 38, 38, 2018),
(265, 6, 2, 5, 0, 0, 50, 55, 2018),
(266, 6, 4, 0, 0, -2, 16, 14, 2018),
(267, 6, 3, 0, 0, 4, 24, 28, 2018),
(268, 6, 6, 0, 2, 0, 30, 32, 2018),
(269, 6, 20, 0, 0, 6, 10, 16, 2018),
(270, 6, 15, 0, 0, 6, 4, 10, 2018),
(271, 6, 10, 0, 0, -4, 6, 2, 2018),
(272, 6, 11, 0, 0, 16, 8, 24, 2018),
(273, 6, 8, 0, 0, -2, 10, 8, 2018),
(274, 6, 7, 0, 0, -8, 6, -2, 2018),
(275, 6, 13, 0, 0, 0, 14, 14, 2018),
(276, 6, 14, 0, 0, 2, 12, 14, 2018),
(277, 6, 9, 0, 0, -15, 0, -15, 2018),
(278, 6, 12, 0, 0, -2, 4, 2, 2018),
(279, 6, 17, 0, 0, 0, 2, 2, 2018),
(280, 6, 18, 0, 0, -15, 0, -15, 2018),
(281, 6, 19, 0, 0, 16, 8, 24, 2018),
(282, 6, 16, 0, 0, -15, 0, -15, 2018),
(283, 7, 1, 5, 0, 0, 50, 55, 2018),
(284, 7, 5, 0, 2, -10, 14, 6, 2018),
(285, 7, 2, 0, 0, -4, 20, 16, 2018),
(286, 7, 4, 0, 0, 6, 30, 36, 2018),
(287, 7, 3, 0, 0, 2, 24, 26, 2018),
(288, 7, 6, 0, 0, 4, 38, 42, 2018),
(289, 7, 20, 0, 0, -4, 10, 6, 2018),
(290, 7, 15, 0, 0, 4, 6, 10, 2018),
(291, 7, 10, 0, 0, 6, 16, 22, 2018),
(292, 7, 11, 0, 0, -2, 8, 6, 2018),
(293, 7, 8, 0, 0, -15, 0, -15, 2018),
(294, 7, 7, 0, 0, -15, 0, -15, 2018),
(295, 7, 13, 0, 0, 6, 10, 16, 2018),
(296, 7, 14, 0, 0, -2, 12, 10, 2018),
(297, 7, 9, 0, 0, 0, 4, 4, 2018),
(298, 7, 12, 0, 0, 10, 8, 18, 2018),
(299, 7, 17, 0, 0, 6, 4, 10, 2018),
(300, 7, 18, 0, 0, 4, 2, 6, 2018),
(301, 7, 19, 0, 0, -15, 0, -15, 2018),
(302, 7, 16, 0, 0, 12, 6, 18, 2018),
(303, 8, 1, 0, 0, -15, 0, -15, 2018),
(304, 8, 5, 5, 0, -15, 0, -10, 2018),
(305, 8, 2, 0, 0, 6, 30, 36, 2018),
(306, 8, 4, 0, 2, 2, 38, 42, 2018),
(307, 8, 3, 0, 0, -15, 0, -15, 2018),
(308, 8, 6, 0, 0, 6, 50, 56, 2018),
(309, 8, 20, 0, 0, 16, 10, 26, 2018),
(310, 8, 15, 0, 0, 16, 10, 26, 2018),
(311, 8, 10, 0, 0, 6, 20, 26, 2018),
(312, 8, 11, 0, 0, 2, 24, 26, 2018),
(313, 8, 8, 0, 0, 10, 16, 26, 2018),
(314, 8, 7, 0, 0, 16, 14, 30, 2018),
(315, 8, 13, 0, 0, -15, 0, -15, 2018),
(316, 8, 14, 0, 0, -6, 8, 2, 2018),
(317, 8, 9, 0, 0, 24, 12, 36, 2018),
(318, 8, 12, 0, 0, -2, 4, 2, 2018),
(319, 8, 17, 0, 0, 6, 6, 12, 2018),
(320, 8, 18, 0, 0, -2, 6, 4, 2018),
(321, 8, 19, 0, 0, 2, 8, 10, 2018),
(322, 8, 16, 0, 0, -15, 0, -15, 2018),
(323, 9, 1, 5, 0, -2, 38, 41, 2018),
(324, 9, 5, 0, 0, 0, 24, 24, 2018),
(325, 9, 2, 0, 2, 2, 50, 54, 2018),
(326, 9, 4, 0, 0, 0, 30, 30, 2018),
(327, 9, 3, 0, 0, 2, 20, 22, 2018),
(328, 9, 6, 0, 0, -20, 4, -16, 2018),
(329, 9, 20, 0, 0, -15, 0, -15, 2018),
(330, 9, 15, 0, 0, -15, 0, -15, 2018),
(331, 9, 10, 0, 0, -4, 10, 6, 2018),
(332, 9, 11, 0, 0, -15, 0, -15, 2018),
(333, 9, 8, 0, 0, 6, 14, 20, 2018),
(334, 9, 7, 0, 0, 4, 10, 14, 2018),
(335, 9, 13, 0, 0, 10, 16, 26, 2018),
(336, 9, 14, 0, 0, -15, 0, -15, 2018),
(337, 9, 9, 0, 0, 10, 12, 22, 2018),
(338, 9, 12, 0, 0, 12, 8, 20, 2018),
(339, 9, 17, 0, 0, 0, 6, 6, 2018),
(340, 9, 18, 0, 0, 0, 8, 8, 2018),
(341, 9, 19, 0, 0, 2, 6, 8, 2018),
(342, 9, 16, 0, 0, -15, 0, -15, 2018),
(343, 10, 1, 0, 2, 26, 50, 78, 2018),
(344, 10, 5, 0, 0, 0, 38, 38, 2018),
(345, 10, 2, 5, 0, -15, 0, -10, 2018),
(346, 10, 4, 0, 0, 0, 30, 30, 2018),
(347, 10, 3, 0, 0, -15, 0, -15, 2018),
(348, 10, 6, 0, 0, 0, 24, 24, 2018),
(349, 10, 20, 0, 0, -12, 4, -8, 2018),
(350, 10, 15, 0, 0, 8, 10, 18, 2018),
(351, 10, 10, 0, 0, -12, 8, -4, 2018),
(352, 10, 11, 0, 0, 0, 16, 16, 2018),
(353, 10, 8, 0, 0, 14, 12, 26, 2018),
(354, 10, 7, 0, 0, 6, 14, 20, 2018),
(355, 10, 13, 0, 0, 4, 20, 24, 2018),
(356, 10, 14, 0, 0, -8, 8, 0, 2018),
(357, 10, 9, 0, 0, -10, 4, -6, 2018),
(358, 10, 12, 0, 0, 10, 6, 16, 2018),
(359, 10, 17, 0, 0, -15, 0, -15, 2018),
(360, 10, 18, 0, 0, -15, 0, -15, 2018),
(361, 10, 19, 0, 0, 12, 6, 18, 2018),
(362, 10, 16, 0, 0, 12, 10, 22, 2018),
(363, 11, 1, 5, 0, 0, 50, 55, 2018),
(364, 11, 5, 0, 0, -6, 20, 14, 2018),
(365, 11, 2, 0, 0, 4, 38, 42, 2018),
(366, 11, 4, 0, 0, 0, 30, 30, 2018),
(367, 11, 3, 0, 2, 16, 24, 42, 2018),
(368, 11, 6, 0, 0, -15, 0, -15, 2018),
(369, 11, 20, 0, 0, -15, 0, -15, 2018),
(370, 11, 15, 0, 0, -2, 4, 2, 2018),
(371, 11, 10, 0, 0, 4, 14, 18, 2018),
(372, 11, 11, 0, 0, 0, 10, 10, 2018),
(373, 11, 8, 0, 0, 8, 6, 14, 2018),
(374, 11, 7, 0, 0, 8, 6, 14, 2018),
(375, 11, 13, 0, 0, 2, 8, 10, 2018),
(376, 11, 14, 0, 0, -8, 10, 2, 2018),
(377, 11, 9, 0, 0, 6, 12, 18, 2018),
(378, 11, 12, 0, 0, -15, 0, -15, 2018),
(379, 11, 17, 0, 0, 6, 4, 10, 2018),
(380, 11, 18, 0, 0, 6, 2, 8, 2018),
(381, 11, 19, 0, 0, 0, 16, 16, 2018),
(382, 11, 16, 0, 0, -6, 8, 2, 2018),
(383, 12, 1, 5, 0, -2, 38, 41, 2018),
(384, 12, 5, 0, 2, 26, 24, 52, 2018),
(385, 12, 2, 0, 0, 2, 50, 52, 2018),
(386, 12, 4, 0, 0, -15, 0, -15, 2018),
(387, 12, 3, 0, 0, -15, 0, -15, 2018),
(388, 12, 6, 0, 0, 8, 30, 38, 2018),
(389, 12, 20, 0, 0, -15, 0, -15, 2018),
(390, 12, 15, 0, 0, 6, 10, 16, 2018),
(391, 12, 10, 0, 0, 2, 12, 14, 2018),
(392, 12, 11, 0, 0, -4, 14, 10, 2018),
(393, 12, 8, 0, 0, -6, 16, 10, 2018),
(394, 12, 7, 0, 0, -2, 20, 18, 2018),
(395, 12, 13, 0, 0, -15, 0, -15, 2018),
(396, 12, 14, 0, 0, 16, 8, 24, 2018),
(397, 12, 9, 0, 0, -15, 0, -15, 2018),
(398, 12, 12, 0, 0, 10, 4, 14, 2018),
(399, 12, 17, 0, 0, 6, 8, 14, 2018),
(400, 12, 18, 0, 0, 6, 6, 12, 2018),
(401, 12, 19, 0, 0, 2, 10, 12, 2018),
(402, 12, 16, 0, 0, -6, 6, 0, 2018),
(423, 13, 1, 0, 2, 4, 50, 56, 2018),
(424, 13, 5, 0, 0, 2, 30, 32, 2018),
(425, 13, 2, 0, 0, -4, 24, 20, 2018),
(426, 13, 4, 5, 0, -2, 38, 41, 2018),
(427, 13, 3, 0, 0, -15, 0, -15, 2018),
(428, 13, 6, 0, 0, 0, 20, 20, 2018),
(429, 13, 20, 0, 0, 8, 8, 16, 2018),
(430, 13, 15, 0, 0, 6, 4, 10, 2018),
(431, 13, 10, 0, 0, -10, 4, -6, 2018),
(432, 13, 11, 0, 0, -15, 0, -15, 2018),
(433, 13, 8, 0, 0, 4, 16, 20, 2018),
(434, 13, 7, 0, 0, 14, 14, 28, 2018),
(435, 13, 13, 0, 0, 14, 6, 20, 2018),
(436, 13, 14, 0, 0, -2, 12, 10, 2018),
(437, 13, 9, 0, 0, -15, 0, -15, 2018),
(438, 13, 12, 0, 0, 10, 8, 18, 2018),
(439, 13, 17, 0, 0, 4, 10, 14, 2018),
(440, 13, 18, 0, 0, 2, 10, 12, 2018),
(441, 13, 19, 0, 0, -10, 6, -4, 2018),
(442, 13, 16, 0, 0, -15, 0, -15, 2018),
(443, 14, 1, 5, 0, 0, 50, 55, 2018),
(444, 14, 5, 0, 0, 0, 24, 24, 2018),
(445, 14, 2, 0, 0, 0, 30, 30, 2018),
(446, 14, 4, 0, 0, 0, 20, 20, 2018),
(447, 14, 3, 0, 0, 0, 16, 16, 2018),
(448, 14, 6, 0, 0, 0, 38, 38, 2018),
(449, 14, 20, 0, 0, 8, 10, 18, 2018),
(450, 14, 15, 0, 0, 6, 8, 14, 2018),
(451, 14, 10, 0, 2, -4, 2, 0, 2018),
(452, 14, 11, 0, 0, -14, 4, -10, 2018),
(453, 14, 8, 0, 0, -15, 0, -15, 2018),
(454, 14, 7, 0, 0, -18, 4, -14, 2018),
(455, 14, 13, 0, 0, 0, 10, 10, 2018),
(456, 14, 14, 0, 0, 8, 12, 20, 2018),
(457, 14, 9, 0, 0, 8, 14, 22, 2018),
(458, 14, 12, 0, 0, 12, 8, 20, 2018),
(459, 14, 17, 0, 0, 0, 1, 1, 2018),
(460, 14, 18, 0, 0, 12, 6, 18, 2018),
(461, 14, 19, 0, 0, 4, 6, 10, 2018),
(462, 14, 16, 0, 0, 0, 2, 2, 2018),
(463, 15, 1, 0, 0, 2, 50, 52, 2018),
(464, 15, 5, 5, 2, -2, 38, 43, 2018),
(465, 15, 2, 0, 0, 0, 30, 30, 2018),
(466, 15, 4, 0, 0, 0, 24, 24, 2018),
(467, 15, 3, 0, 0, 24, 16, 40, 2018),
(468, 15, 6, 0, 0, 28, 20, 48, 2018),
(469, 15, 20, 0, 0, 0, 14, 14, 2018),
(470, 15, 15, 0, 0, -6, 6, 0, 2018),
(471, 15, 10, 0, 0, -6, 12, 6, 2018),
(472, 15, 11, 0, 0, -4, 8, 4, 2018),
(473, 15, 8, 0, 0, -6, 10, 4, 2018),
(474, 15, 7, 0, 0, -4, 10, 6, 2018),
(475, 15, 13, 0, 0, 0, 8, 8, 2018),
(476, 15, 14, 0, 0, -12, 2, -10, 2018),
(477, 15, 9, 0, 0, 4, 6, 10, 2018),
(478, 15, 12, 0, 0, -2, 4, 2, 2018),
(479, 15, 17, 0, 0, -10, 2, -8, 2018),
(480, 15, 18, 0, 0, -2, 4, 2, 2018),
(481, 15, 19, 0, 0, -15, 0, -15, 2018),
(482, 15, 16, 0, 0, -15, 0, -15, 2018),
(483, 16, 1, 5, 0, 0, 50, 55, 2018),
(484, 16, 5, 0, 0, 0, 38, 38, 2018),
(485, 16, 2, 0, 2, 4, 16, 22, 2018),
(486, 16, 4, 0, 0, -2, 20, 18, 2018),
(487, 16, 3, 0, 0, 22, 24, 46, 2018),
(488, 16, 6, 0, 0, 0, 30, 30, 2018),
(489, 16, 20, 0, 0, -15, 0, -15, 2018),
(490, 16, 15, 0, 0, 16, 8, 24, 2018),
(491, 16, 10, 0, 0, -15, 0, -15, 2018),
(492, 16, 11, 0, 0, -6, 12, 6, 2018),
(493, 16, 8, 0, 0, 4, 10, 14, 2018),
(494, 16, 7, 0, 0, 4, 14, 18, 2018),
(495, 16, 13, 0, 0, -15, 0, -15, 2018),
(496, 16, 14, 0, 0, 6, 10, 16, 2018),
(497, 16, 9, 0, 0, 8, 6, 14, 2018),
(498, 16, 12, 0, 0, 8, 4, 12, 2018),
(499, 16, 17, 0, 0, 2, 4, 6, 2018),
(500, 16, 18, 0, 0, -6, 2, -4, 2018),
(501, 16, 19, 0, 0, -8, 8, 0, 2018),
(502, 16, 16, 0, 0, -14, 6, -8, 2018),
(503, 18, 1, 0, 0, -2, 24, 22, 2018),
(504, 18, 5, 0, 2, 0, 20, 22, 2018),
(505, 18, 2, 0, 0, 4, 38, 42, 2018),
(506, 18, 4, 0, 0, 6, 30, 36, 2018),
(507, 18, 3, 5, 0, -15, 0, -10, 2018),
(508, 18, 6, 0, 0, 2, 50, 52, 2018),
(509, 18, 20, 0, 0, 4, 14, 18, 2018),
(510, 18, 15, 0, 0, 2, 10, 12, 2018),
(511, 18, 10, 0, 0, 2, 4, 6, 2018),
(512, 18, 11, 0, 0, 4, 4, 8, 2018),
(513, 18, 8, 0, 0, 0, 8, 8, 2018),
(514, 18, 7, 0, 0, -15, 0, -15, 2018),
(515, 18, 13, 0, 0, 2, 16, 18, 2018),
(516, 18, 14, 0, 0, -15, 0, -15, 2018),
(517, 18, 9, 0, 0, -15, 0, -15, 2018),
(518, 18, 12, 0, 0, 14, 12, 26, 2018),
(519, 18, 17, 0, 0, 12, 6, 18, 2018),
(520, 18, 18, 0, 0, 10, 8, 18, 2018),
(521, 18, 19, 0, 0, 20, 10, 30, 2018),
(522, 18, 16, 0, 0, 0, 6, 6, 2018),
(523, 17, 1, 5, 2, -4, 30, 33, 2018),
(524, 17, 5, 0, 0, -4, 20, 16, 2018),
(525, 17, 2, 0, 0, 2, 24, 26, 2018),
(526, 17, 4, 0, 0, 2, 50, 52, 2018),
(527, 17, 3, 0, 0, -15, 0, -15, 2018),
(528, 17, 6, 0, 0, 32, 38, 70, 2018),
(529, 17, 20, 0, 0, -15, 0, -15, 2018),
(530, 17, 15, 0, 0, 12, 10, 22, 2018),
(531, 17, 10, 0, 0, -15, 0, -15, 2018),
(532, 17, 11, 0, 0, -15, 0, -15, 2018),
(533, 17, 8, 0, 0, -15, 0, -15, 2018),
(534, 17, 7, 0, 0, 4, 12, 16, 2018),
(535, 17, 13, 0, 0, 2, 16, 18, 2018),
(536, 17, 14, 0, 0, 8, 14, 22, 2018),
(537, 17, 9, 0, 0, -15, 0, -15, 2018),
(538, 17, 12, 0, 0, 12, 8, 20, 2018),
(539, 17, 17, 0, 0, 2, 6, 8, 2018),
(540, 17, 18, 0, 0, 2, 6, 8, 2018),
(541, 17, 19, 0, 0, 14, 8, 22, 2018),
(542, 17, 16, 0, 0, 22, 10, 32, 2018),
(562, 19, 0, 0, 0, 0, 0, -15, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `TrackID` int(11) NOT NULL AUTO_INCREMENT,
  `RaceName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `RaceNumber` int(2) NOT NULL,
  PRIMARY KEY (`TrackID`),
  KEY `RaceNumber` (`RaceNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`TrackID`, `RaceName`, `RaceNumber`) VALUES
(0, 'Australia', 1),
(1, 'Bahrain', 2),
(2, 'China', 3),
(3, 'Azerbaijan', 4),
(4, 'Spain', 5),
(5, 'Monaco', 6),
(6, 'Canada', 7),
(7, 'France', 8),
(8, 'Austria', 9),
(9, 'Great Britain', 10),
(10, 'Germany', 11),
(11, 'Hungary', 12),
(12, 'Belgium', 13),
(13, 'Italy', 14),
(14, 'Singapore', 15),
(15, 'Russia', 16),
(16, 'Japan', 17),
(17, 'United States', 18),
(18, 'Mexico', 19),
(19, 'Brazil', 20),
(20, 'Abu Dhabi', 21);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FirstName`, `LastName`) VALUES
(1, 'Dudezog', '*196BDEDE2AE4F84CA44C47D54D78478C7E2BD7B7', 'nick@nickherzog.com', 'Nick', 'Herzog'),
(2, 'Test', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'test@email.com', 'John', 'User'),
(4, 'Jackers', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'nherzog1126@gmail.com', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `champions`
--
ALTER TABLE `champions`
  ADD CONSTRAINT `champions_ibfk_1` FOREIGN KEY (`LeagueID`) REFERENCES `leagues` (`LeagueID`);

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
