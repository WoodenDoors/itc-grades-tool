--
-- Database: `itc`
--

-- --------------------------------------------------------

--
-- Table structure for table `itc-grades-tool_courses`
--

CREATE TABLE IF NOT EXISTS `itc-grades-tool_courses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `credits` int(2) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `abbreviation` (`abbreviation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `itc-grades-tool_courses`
--

INSERT INTO `itc-grades-tool_courses` (`ID`, `abbreviation`, `subject`, `credits`) VALUES
(1, 'GDI1', 'Grundlagen der Infromatik 1', 5),
(2, 'GDI2', 'Grundlagen der Infromatik 2', 5),
(3, 'P1', 'Programmierung 1', 7),
(4, 'MCI', 'Mensch-Computer-Interaktion', 5),
(5, 'FG1', 'Formale Grundlagen 1', 4),
(6, 'BWL1', 'Einführung in die BWL A', 5),
(7, 'AT1', 'Arbeitstechik A', 2),
(8, 'E', 'Englisch', 2),
(9, 'GDI3', 'Grundlagen der Informatik 3', 7),
(10, 'P2', 'Programmierung 2', 7),
(11, 'P3', 'Programmierung 3', 7),
(12, 'FG2', 'Formale Grundlagen 2', 4),
(13, 'BWL2', 'Einführung in die BWL B', 5),
(14, 'AT2', 'Arbeitstechik B', 2),
(15, 'ST1', 'Softwaretechnik 1', 6),
(16, 'WE', 'Web-Engineering', 5),
(17, 'SQL', 'Datenbank-applikationen', 5),
(18, 'RN', 'Rechnernetze', 5),
(19, 'PI1', 'Praktikum in der Industrie 1', 5),
(20, 'ST2', 'Softwaretechnik 2', 6),
(21, 'SSO', 'Standard-software', 5),
(22, 'C', 'Componentware', 5),
(23, 'B', 'Betriebssysteme', 5),
(24, 'PI2', 'Praktikum in der Industrie 2', 10),
(25, 'H', 'Hypermedia', 5),
(26, 'ITS', 'IT-Sicherheit', 5),
(27, 'AFS', 'Automaten und Formale Sprachen', 4),
(28, 'ITK', 'IT-Kosten-Planung', 5),
(29, 'NAO', 'Neue Arbeits- und Organisationsformen', 2),
(30, 'SEM', 'Seminar', 2),
(31, 'ST3', 'Softwaretechnik 3', 5),
(32, 'ST4', 'Softwaretechnik 4', 5),
(33, 'SS', 'Statistik, Stochastik', 4),
(34, 'IT-R', 'Aspekte des IT-Rechts', 4),
(35, 'AA', 'Projekt-/Studienarbeit', 4);
