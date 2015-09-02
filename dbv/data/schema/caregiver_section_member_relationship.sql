CREATE TABLE `caregiver_section_member_relationship` (
  `relation_id` char(32) NOT NULL,
  `caregiver_unique_id` char(32) NOT NULL,
  `section_member_unique_id` char(32) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1