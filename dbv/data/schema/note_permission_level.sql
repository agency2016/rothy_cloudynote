CREATE TABLE `note_permission_level` (
  `permission_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `permission_author_id` bigint(20) NOT NULL COMMENT 'who gaved permission',
  `permission_assigned_id` bigint(20) NOT NULL COMMENT 'whom give permission',
  `permission_note_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'If the id set to 0 that he can read write update remove note based on Permission',
  `permission_read` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Can only read, but if get access of write, update or remove then automatically get access of read operation',
  `permission_update` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'If this permission is given Then can only read and update note or can resend note but cant create new one. But if have the write access automatically get this access',
  `permission_write` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'If have the write permission, then can create new note but cant remove and automatically get access of read and update.',
  `permission_remove` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'This is the super power access. If this permission is given the user get all access of note. So be careful',
  `permission_admin_access` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'If anyone get this access all kinf of access he will be given, thats why he can create class, create note, update note, remove note, remove or move students. In one word everything can do what can do the institute.',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1