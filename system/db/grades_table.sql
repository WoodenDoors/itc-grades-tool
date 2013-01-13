-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2013 at 03:42 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `itc`
--

-- --------------------------------------------------------

--
-- Table structure for table `itc-grades-tool_grades`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_grades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` float(2,1) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7;

--
-- Dumping data for table `itc-grades-tool_grades`
--

INSERT INTO `itc-grades-tool_grades` (`ID`, `user_id`, `course_id`, `grade`, `comment`) VALUES
(1, 1, 1, 2.0, ''),
(2, 1, 5, 2.3, ''),
(3, 1, 3, 3.0, 'Mit dem falschen Fuß aufgestanden'),
(4, 1, 4, 1.0, ''),
(5, 1, 2, 1.3, ''),
(6, 1, 6, 1.5, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
