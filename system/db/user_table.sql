-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Nov 2012 um 08:46
-- Server Version: 5.5.27
-- PHP-Version: 5.4.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `itc`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `itc-grades-tool_users`
--

INSERT INTO `itc-grades-tool_users` (`ID`, `vorname`, `nachname`, `email`, `pass`, `username`) VALUES
(1, 'Peter', 'Zwegat', 'mathes@myopera.com', '098f6bcd4621d373cade4e832627b4f6', 'tester', 1),
(2, 'Klaus', 'Fels', 'hallohallo@klausfels.com', '098f6bcd4621d373cade4e832627b4f6', 'tester2', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
