CREATE TABLE `section_group` (
  `group_id` char(32) NOT NULL,
  `section_id` char(32) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1