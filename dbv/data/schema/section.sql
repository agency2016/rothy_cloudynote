CREATE TABLE `section` (
  `section_id` char(32) NOT NULL COMMENT 'There will be huge number of class. So that int will not suitable for this id. Always generate  unique id with timestamp using md5 hash',
  `section_hash_organisation_id` char(32) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `section_created_date` datetime NOT NULL,
  `section_remove` enum('1','0') NOT NULL DEFAULT '0',
  UNIQUE KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8