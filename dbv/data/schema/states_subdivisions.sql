CREATE TABLE `states_subdivisions` (
  `state_subdivision_id` int(11) NOT NULL DEFAULT '0',
  `country_code_char2` varchar(5) DEFAULT NULL,
  `country_code_char3` varchar(5) DEFAULT NULL,
  `state_subdivision_name` varchar(80) DEFAULT NULL,
  `state_subdivision_alternate_names` varchar(200) DEFAULT NULL,
  `primary_level_name` varchar(80) DEFAULT NULL,
  `state_subdivision_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`state_subdivision_id`),
  KEY `state_subdivision_id` (`state_subdivision_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1