CREATE TABLE `authentication_log` (
  `authentication_id` char(32) NOT NULL,
  `authentication_role_id` tinyint(4) NOT NULL,
  `authentication_log_for_whom` varchar(200) NOT NULL,
  `authentication_log_for_whom_id` bigint(20) NOT NULL,
  `authentication_log_date` date NOT NULL,
  `authentication_log_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `authentication_id` (`authentication_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1