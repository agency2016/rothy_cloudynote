CREATE TABLE `assign_section` (
  `assign_id` char(32) NOT NULL,
  `assign_organisation_id` char(32) NOT NULL,
  `assign_access_id` char(32) NOT NULL COMMENT 'hashing email of invited email addr',
  `assign_section_id` char(32) NOT NULL COMMENT 'Section id(foreign key)',
  `assign_group_id` char(32) DEFAULT NULL,
  `assign_hit` enum('1','0') NOT NULL DEFAULT '0',
  `assign_hit_counter` int(11) NOT NULL DEFAULT '0',
  `assign_status_id` tinyint(4) NOT NULL DEFAULT '1',
  `assign_time` bigint(20) NOT NULL,
  `assign_creation_date` datetime NOT NULL,
  `assign_update_date` datetime DEFAULT NULL,
  UNIQUE KEY `assign_id` (`assign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1