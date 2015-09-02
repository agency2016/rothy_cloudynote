CREATE TABLE `assign_section_temp` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_access_id` char(32) NOT NULL,
  `assign_section_id` char(32) NOT NULL,
  `assign_group_id` char(32) DEFAULT NULL,
  PRIMARY KEY (`assign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1