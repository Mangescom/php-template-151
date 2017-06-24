-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE app;

DROP TABLE IF EXISTS `blogpost`;
CREATE TABLE `blogpost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `title` varchar(50) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `author` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  CONSTRAINT `blogpost_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `blogpost` (`id`, `created`, `title`, `text`, `author`, `image`) VALUES
(1,	'2017-06-04 18:50:32',	'test1',	'super text extremely liong such wow even misspelled',	1,	'http://de.narutopedia.eu/images/thumb/9/9c/Kakashi%2Bsharingan.png/300px-Kakashi%2Bsharingan.png');

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(250) NOT NULL,
  `author` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `posted` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `post` (`post`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post`) REFERENCES `blogpost` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `comment`, `author`, `post`, `posted`) VALUES
(1,	'Wow, this is reeealy interesting',	1,	1,	'2017-06-14 16:57:51'),
(2,	'LOL',	6,	1,	'2017-06-14 18:24:01');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT '0',
  `reset` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `vorname`, `nachname`, `admin`, `reset`) VALUES
(1,	'jonas@portmann.com',	'$2y$10$evJ4otkU4uduM1M4a2ZZI.fIxYGDVR9upQvv4godn3Qr2LKmL4bte',	'Jonas',	'Portmann',	1,	NULL),
(6,	'Test@account.com',	'$2y$10$evJ4otkU4uduM1M4a2ZZI.fIxYGDVR9upQvv4godn3Qr2LKmL4bte',	'Test',	'Tester',	0,	NULL);
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(15) NOT NULL,
  `title` varchar(50) NOT NULL,
  `posted` datetime NOT NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  CONSTRAINT `video_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `video` (`id`, `url`, `title`, `posted`, `author`) VALUES
(1,	'-wXjs6DXoeY',	'Ryan the builder',	'2017-06-15 06:40:55',	1),
(3,	'E6TUs69Cw94',	'Rick and Morty',	'2017-06-15 06:41:43',	6);

-- 2017-06-24 12:30:29
        