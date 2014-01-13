# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.9)
# Database: mdular
# Generation Time: 2012-04-11 01:18:55 +0200
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tbl_comment
# ------------------------------------------------------------

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) NOT NULL DEFAULT '',
  `ip` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(128) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`post_id`),
  CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;



# Dump of table tbl_lookup
# ------------------------------------------------------------

CREATE TABLE `tbl_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `code` int(11) NOT NULL,
  `type` varchar(128) NOT NULL DEFAULT '',
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_post
# ------------------------------------------------------------

CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `tags` text,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `publish_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_author` (`author_id`),
  CONSTRAINT `FK_post_author` FOREIGN KEY (`author_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tbl_tag
# ------------------------------------------------------------

CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '',
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table tbl_image
# ------------------------------------------------------------
CREATE TABLE `tbl_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `file` varchar(128) NOT NULL DEFAULT '',
  `size` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;



# Dump of table tbl_user
# ------------------------------------------------------------

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `salt` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `profile` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dump of table tbl_user
# ------------------------------------------------------------

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;

INSERT INTO `tbl_user` (`id`, `username`, `password`, `salt`, `email`, `profile`)
VALUES
  (1,'user','7bf4aff59d8fab5fb2c0907f7f28170f','52d307f8d4a390.83624804','','');

/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
