CREATE TABLE `package_list` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_code` char(4) NOT NULL,
  `package_max_send_note` int(11) NOT NULL DEFAULT '0',
  `package_yearly_price` float(8,2) NOT NULL,
  `package_min_members` int(11) NOT NULL,
  `package_max_members` int(11) NOT NULL,
  `package_recurring_payment` enum('Y','N') NOT NULL DEFAULT 'N',
  `package_fixed` enum('Y','N') NOT NULL DEFAULT 'N',
  `package_description` varchar(200) NOT NULL,
  PRIMARY KEY (`package_id`),
  UNIQUE KEY `package_code` (`package_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1