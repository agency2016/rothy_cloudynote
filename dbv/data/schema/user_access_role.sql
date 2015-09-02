CREATE TABLE `user_access_role` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_label` varchar(50) NOT NULL,
  `access_level_parent_id` int(11) NOT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1