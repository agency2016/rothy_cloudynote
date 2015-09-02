CREATE TABLE `note_updates_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_notes_id` int(11) NOT NULL,
  `log_notes_changer_id` int(11) NOT NULL,
  `log_notes_changing_time` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1