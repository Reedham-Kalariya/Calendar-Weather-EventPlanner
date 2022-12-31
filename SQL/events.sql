/* first create database called calendar */
create database userCalendar;

/*switch to use the database calendar */
use userCalendar;


/**Table structure for table 'users' **/
+-------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Table | Create Table

                                                                        |
+-------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| users | CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 |
+-------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.00 sec)
/** same query as above, you can just copy and paste it into the command line **/
CREATE TABLE IF NOT EXISTS users ( id mediumint unsigned not null auto_increment, username varchar(50) NOT NULL, password char(255) NOT NULL, created_at datetime DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (id), UNIQUE KEY unique_username (username) ) ENGINE=InnoDB default character set = utf8 collate = utf8_general_ci;


/** Table structure for table `events` **/
+--------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Table  | Create Table




                                                                             |
+--------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| events | CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `event_date` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `event_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active | 0=Inactive',
  PRIMARY KEY (`event_id`,`title`,`username`),
  UNIQUE KEY `unique_title_username` (`title`,`username`),
  KEY `username` (`username`),
  CONSTRAINT `events_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 |
+--------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
1 row in set (0.00 sec)
CREATE TABLE IF NOT EXISTS events (   event_id int(11) NOT NULL NULL AUTO_INCREMENT,  title varchar(255) COLLATE utf8_unicode_ci NOT NULL,  event_date date NOT NULL,  username varchar(50) NOT NULL,  created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,  modified datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,  event_status tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive',  PRIMARY KEY (event_id, title, username),  UNIQUE KEY unique_title_username (title, username),  foreign key (username) references users(username) on delete cascade) ENGINE=InnoDB default character set = utf8 collate = utf8_general_ci;



-- create Table share for shared events
| Table | Create Table                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
+-------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| share | CREATE TABLE `share` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) NOT NULL,
  `event_date` date NOT NULL,
  PRIMARY KEY (`event_id`,`title`,`event_date`),
  UNIQUE KEY `unique_title_username` (`event_id`,`title`),
  KEY `username` (`username`),
  CONSTRAINT `share_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE,
  CONSTRAINT `share_ibfk_2` FOREIGN KEY (`event_id`, `title`) REFERENCES `events` (`event_id`, `title`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 |
+-------+----------------------------------------------------------------------------------------------------------------------
-- testing the table
insert into users (username, password) values ('Terry', 'Foolery');
INSERT INTO `events` (`event_id`, `title`, `event_date`, `username`, `created`, `modified`, `event_status`) VALUES (1, 'Internet of Things World Forum', '2022-04-17', 'Terry', '2022-06-04 16:41:40', '2022-06-04 16:41:40', 1);
SELECT title FROM events WHERE event_date = '2022-07-08' AND event_status = 1 AND username='Terry';
DELETE FROM events WHERE title = 'LauraVisitsMiami' AND username = 'Laura';
