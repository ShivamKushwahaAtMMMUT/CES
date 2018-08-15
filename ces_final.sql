-- Table structure for table `admin`
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `email` text NOT NULL,
  `password` text NOT NULL
);

INSERT INTO `admin` VALUES ('ironkushwaha@outlook.com','hesoyam26');


--
-- Table structure for table `event_group`
--

DROP TABLE IF EXISTS `event_group`;
CREATE TABLE `event_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `weight` int(11) DEFAULT '9',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
);

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_group` varchar(100) NOT NULL,
  `event_title` varchar(200) NOT NULL,
  `event_category` varchar(200) NOT NULL,
  `event_poster` varchar(200) DEFAULT 'event_poster_default.jpg',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_desc` text NOT NULL,
  `event_rules` text NOT NULL,
  `event_coordinators` text,
  `display_flag` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`event_id`),
  KEY `event_group` (`event_group`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_group`) REFERENCES `event_group` (`group_name`) ON DELETE CASCADE ON UPDATE CASCADE
);

--
-- Table structure for table `mail_history`
--

DROP TABLE IF EXISTS `mail_history`;
CREATE TABLE `mail_history` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `document` varchar(200) DEFAULT NULL,
  `receivers` text NOT NULL,
  PRIMARY KEY (`mail_id`)
);

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` text,
  `year` int(11) DEFAULT NULL,
  `designation` varchar(100) DEFAULT 'Executive Member',
  `linkedin` text,
  `facebook` text,
  `email` text,
  `passout_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
);

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `image` text,
  `video` text,
  `document` text,
  `link` text,
  `associates` text,
  PRIMARY KEY (`notice_id`)
);

--
-- Table structure for table `notice_temp`
--

DROP TABLE IF EXISTS `notice_temp`;
CREATE TABLE `notice_temp` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `validity` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text NOT NULL,
  `image` text,
  `video` text,
  `document` text,
  `link` text,
  `associates` text,
  PRIMARY KEY (`notice_id`)
);

--
-- Table structure for table `subscriber_varification`
--

DROP TABLE IF EXISTS `subscriber_varification`;
CREATE TABLE `subscriber_varification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `designation` enum('firstYear','secondYear','thirdYear','finalYear') DEFAULT NULL,
  `conf_code` text NOT NULL,
  `link_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `designation` enum('firstYear','secondYear','thirdYear','finalYear') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

--
-- View structure for `activity_log`
--

CREATE VIEW activity_log AS (SELECT 'notice' AS identity, notice_id AS id, title, issue_date AS activity_date FROM notice) UNION (SELECT 'mail' AS identity, mail_id AS id, subject AS title, mail_date AS activity_date FROM mail_history) ORDER BY activity_date DESC LIMIT 200;
