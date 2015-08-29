CREATE TABLE `edd_session` (
`session_id` varchar(255) NOT NULL,
`session_expire` int(11) NOT NULL,
`session_data` varchar(255) default NULL,
UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8; 
