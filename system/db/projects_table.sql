
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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `itc-grades-tool_projects`
--

INSERT INTO `itc-grades-tool_projects` (`ID`, `course_id`, `grade`, `name`, `text`) VALUES
(1, 1, 1.0, 'Eine Webseite erstellen', 'Ja genau diese Webseite hier'),
(2, 3, 0.0, 'Ausarbeitung Zuhause', 'eine kleine Ausarbeitung\r\nsteht noch aus');