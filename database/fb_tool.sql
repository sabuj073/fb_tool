-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 28, 2021 at 06:59 PM
-- Server version: 5.7.36
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fb_tool`
--

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
CREATE TABLE IF NOT EXISTS `info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` text,
  `app_id` text,
  `app_secret` text,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`info_id`, `shop_name`, `app_id`, `app_secret`) VALUES
(1, 'Facebook Tool', '402679514712480', '180d29e99453af41dc370ab1a01b0a6b');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` text,
  `fb_page_name` text,
  `fb_page_id` text,
  `fb_page_token` text,
  `instagram_name` text,
  `instagram_id` text,
  `instagram_token` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `client_name`, `fb_page_name`, `fb_page_id`, `fb_page_token`, `instagram_name`, `instagram_id`, `instagram_token`) VALUES
(1, 'Doinik Kenakat', 'Doinik Kena Kata', '129378672178304', 'EAAFuPCFuyaABADG35eGLmnVbPmpQCYfYHtIG0LQBpbFPcPY0n8hF0E1qj4JwRUz4vuwgoTNkRuVjlmD2YzS5nRpCCfk7YSVqPffcINxoSuDpJbcl7346ndMXXZBMngcG5Suypa1ZCtOKHA4lasnqYeGxImDjUukJZCemNCqDmnbzZBzKEyXOHQCaR04AL7oZD', '', '17841402342500761', '');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `content` text,
  `image` text,
  `platform` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
