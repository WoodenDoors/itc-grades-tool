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
  `course` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `credits` int(2) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `abbreviation` (`abbreviation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `itc-grades-tool_courses`
--

INSERT INTO `itc-grades-tool_courses` (`ID`, `abbreviation`, `course`, `credits`, `semester`) VALUES
(1, 'GDI1', 'Grundlagen der Informatik 1', 5, 1),
(2, 'GDI2', 'Grundlagen der Informatik 2', 5, 1),
(3, 'P1', 'Programmierung 1', 7, 1),
(4, 'MCI', 'Mensch-Computer-Interaktion', 5, 1),
(5, 'FG1', 'Formale Grundlagen 1', 4, 1),
(6, 'BWL1', 'EinfÃ¼hrung in die BWL A', 5, 1),
(7, 'AT1', 'Arbeitstechik A', 2, 1),
(8, 'E', 'Englisch', 2, 1),
(9, 'GDI3', 'Grundlagen der Informatik 3', 7, 2),
(10, 'P2', 'Programmierung 2', 7, 2),
(11, 'P3', 'Programmierung 3', 7, 2),
(12, 'FG2', 'Formale Grundlagen 2', 4, 2),
(13, 'BWL2', 'EinfÃ¼hrung in die BWL B', 5, 2),
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