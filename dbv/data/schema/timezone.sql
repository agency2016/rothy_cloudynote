CREATE TABLE `timezone` (
  `timezone_id` int(11) NOT NULL AUTO_INCREMENT,
  `timezone_full_name` char(200) NOT NULL,
  `timezone_shown_as` char(50) NOT NULL,
  `timezone_location` char(50) DEFAULT NULL,
  `timezone_abbreviation` char(5) DEFAULT NULL,
  PRIMARY KEY (`timezone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1