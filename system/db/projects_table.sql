-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2013 at 12:28 AM
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
-- Table structure for table `itc-grades-tool_projects`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `grade` float(2,1) NOT NULL DEFAULT '0.0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `grade_id` (`grade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `itc-grades-tool_projects`
--

INSERT INTO `itc-grades-tool_projects` (`ID`, `course_id`, `grade`, `name`, `text`) VALUES
(1, 1, 1.0, 'Eine Webseite erstellen', 'Ja genau diese Webseite hier'),
(2, 3, 0.0, 'Ausarbeitung Zuhause', 'eine kleine Ausarbeitung\r\nsteht noch aus');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
