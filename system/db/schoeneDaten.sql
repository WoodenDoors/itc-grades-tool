-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Jan 2013 um 21:04
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `itc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itc-grades-tool_courses`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_courses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `course` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `credits` int(2) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `abbreviation` (`abbreviation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Daten für Tabelle `itc-grades-tool_courses`
--

INSERT INTO `itc-grades-tool_courses` (`ID`, `abbreviation`, `course`, `credits`, `semester`) VALUES
(1, 'GDI1', 'Grundlagen der Informatik 1', 5, 1),
(2, 'GDI2', 'Grundlagen der Informatik 2', 5, 1),
(3, 'P1', 'Programmierung 1', 7, 1),
(4, 'MCI', 'Mensch-Computer-Interaktion', 5, 1),
(5, 'FG1', 'Formale Grundlagen 1', 4, 1),
(6, 'BWL1', 'Einf&uuml;hrung in die BWL A', 5, 1),
(7, 'AT1', 'Arbeitstechik A', 2, 1),
(8, 'E', 'Englisch', 2, 1),
(9, 'GDI3', 'Grundlagen der Informatik 3', 7, 2),
(10, 'P2', 'Programmierung 2', 7, 2),
(11, 'P3', 'Programmierung 3', 7, 2),
(12, 'FG2', 'Formale Grundlagen 2', 4, 2),
(13, 'BWL2', 'Einf&uuml;hrung in die BWL B', 5, 2),
(14, 'AT2', 'Arbeitstechik B', 2, 2),
(15, 'ST1', 'Softwaretechnik 1', 6, 3),
(16, 'WE', 'Web-Engineering', 5, 3),
(17, 'SQL', 'Datenbank-applikationen', 5, 3),
(18, 'RN', 'Rechnernetze', 5, 3),
(19, 'PI1', 'Praktikum in der Industrie 1', 5, 3),
(20, 'ST2', 'Softwaretechnik 2', 6, 4),
(21, 'SSO', 'Standard-Software', 5, 4),
(22, 'C', 'Componentware', 5, 4),
(23, 'B', 'Betriebssysteme', 5, 4),
(24, 'PI2', 'Praktikum in der Industrie 2', 10, 4),
(25, 'H', 'Hypermedia', 5, 5),
(26, 'ITS', 'IT-Sicherheit', 5, 5),
(27, 'AFS', 'Automaten und Formale Sprachen', 4, 5),
(28, 'ITK', 'IT-Kosten-Planung', 5, 5),
(29, 'NAO', 'Neue Arbeits- und Organisationsformen', 2, 5),
(30, 'SEM', 'Seminar', 2, 5),
(31, 'ST3', 'Softwaretechnik 3', 5, 6),
(32, 'ST4', 'Softwaretechnik 4', 5, 6),
(33, 'SS', 'Statistik, Stochastik', 4, 6),
(34, 'IT-R', 'Aspekte des IT-Rechts', 4, 6),
(35, 'AA', 'Projekt-/Studienarbeit', 4, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itc-grades-tool_grades`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_grades` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` float(2,1) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `itc-grades-tool_grades`
--

INSERT INTO `itc-grades-tool_grades` (`ID`, `user_id`, `course_id`, `grade`, `comment`) VALUES
(1, 1, 1, 1.3, ''),
(2, 1, 2, 1.7, ''),
(3, 1, 3, 1.0, ''),
(4, 1, 4, 5.0, ''),
(5, 1, 5, 2.0, ''),
(6, 1, 6, 3.3, ''),
(7, 1, 7, 3.0, ''),
(8, 1, 8, 2.0, ''),
(9, 3, 16, 1.0, ''),
(10, 3, 16, 1.3, ''),
(11, 3, 17, 1.3, ''),
(12, 3, 18, 3.7, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itc-grades-tool_projects`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `grade` float(2,1) NOT NULL DEFAULT '0.0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `itc-grades-tool_projects`
--

INSERT INTO `itc-grades-tool_projects` (`ID`, `course_id`, `grade`, `name`, `text`) VALUES
(1, 1, 1.3, 'ITC-Grades-Tool', 'Erstellen einer Website in PHP'),
(2, 5, 0.0, 'PDF-Tool', 'PDF-Tool machen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itc-grades-tool_project_participants`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_project_participants` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `itc-grades-tool_project_participants`
--

INSERT INTO `itc-grades-tool_project_participants` (`project_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `itc-grades-tool_users`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nachname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `semester` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`,`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `itc-grades-tool_users`
--
-- Passwörter: asdf

INSERT INTO `itc-grades-tool_users` (`ID`, `vorname`, `nachname`, `email`, `pass`, `username`, `semester`) VALUES
(1, 'Mathias', 'Wegmann', 'm.wegmann@host.com', '912ec803b2ce49e4a541068d495ab570', 'Mathes', 1),
(2, 'Sebastian', 'Zier', 'zier.seb@host.com', '912ec803b2ce49e4a541068d495ab570', 'Sebi', 2),
(3, 'Marius', 'Rüter', 'marius.rueter@host.com', '912ec803b2ce49e4a541068d495ab570', 'Kreisverkehr', 3),
(4, 'Michael', 'Stein', 'michael.stein@host.com', '912ec803b2ce49e4a541068d495ab570', 'Micha', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
