CREATE TABLE `user_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_access_role_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1