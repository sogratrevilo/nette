-- Adminer 4.8.1 MySQL 5.5.5-10.4.22-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `post_id`, `name`, `email`, `content`, `created_at`) VALUES
(1,	1,	'balo',	'norbert@fula.sk',	'No pekne to ide zatial',	'2022-02-11 11:51:24'),
(23,	1,	'Varga',	'',	'Asi aj hej',	'2022-02-14 18:06:39');

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `post` (`id`, `user`, `title`, `content`, `created_at`) VALUES
(1,	'',	'Article One',	'Lorem ipusm dolor one',	'2022-02-11 04:35:20'),
(2,	'',	'Article Two',	'Lorem ipsum dolor two kindaloaa',	'2022-02-11 04:35:20'),
(3,	'',	'Article Three',	'Lorem ipsum dolor three',	'2022-02-11 04:35:20'),
(26,	'admin',	'valo',	'menejp',	'0000-00-00 00:00:00'),
(27,	'adam',	'mozem',	'asias',	'0000-00-00 00:00:00');

-- 2022-02-14 17:41:45