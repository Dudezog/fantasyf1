-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2018 at 07:33 PM
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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(41) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`) VALUES
(1, 'Dudezog', '*196BDEDE2AE4F84CA44C47D54D78478C7E2BD7B7', 'nick@nickherzog.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
