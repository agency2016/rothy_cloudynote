CREATE TABLE `user_organisation_relation` (
  `uor_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_hash_email` char(32) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_org_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8