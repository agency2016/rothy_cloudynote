CREATE TABLE `activity_label` (
  `activity_label_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_label_type` varchar(50) NOT NULL,
  `activity_type_id` int(11) NOT NULL,
  PRIMARY KEY (`activity_label_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1