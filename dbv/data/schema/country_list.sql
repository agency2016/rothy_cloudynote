CREATE TABLE `country_list` (
  `country_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) NOT NULL,
  `country_code_char2` char(2) NOT NULL,
  `country_code_char3` char(3) NOT NULL,
  `un_region` varchar(100) DEFAULT NULL,
  `un_subregion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='country list'