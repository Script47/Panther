-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2014 at 05:49 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE IF NOT EXISTS `crons` (
  `file` varchar(20) NOT NULL,
  `last_update` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crons`
--

INSERT INTO `crons` (`file`, `last_update`) VALUES
('cron_5mins.php', 1367801958);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `category` smallint(3) NOT NULL,
  `description` varchar(200) NOT NULL,
  `buy_price` smallint(3) NOT NULL,
  `sell_price` smallint(3) NOT NULL,
  `equip_slot` enum('head','weapon','shield','torso','legs','boots','') NOT NULL DEFAULT '',
  PRIMARY KEY (`item_id`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items_categories`
--

CREATE TABLE IF NOT EXISTS `items_categories` (
  `category_id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mailbox`
--

CREATE TABLE IF NOT EXISTS `mailbox` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SendTo` int(11) NOT NULL,
  `SentFrom` int(11) NOT NULL,
  `Subject` varchar(225) NOT NULL,
  `Message` text NOT NULL,
  `SentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(25) NOT NULL,
  `val` varchar(200) NOT NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds game settings';

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `val`) VALUES
('game_description', 'Description soon.'),
('tos', 'Updated soon...');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `default_val` varchar(50) NOT NULL,
  `on_char_creator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no',
  `in_gym` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=no|1=yes',
  PRIMARY KEY (`stat_id`),
  KEY `stat_id` (`stat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Stores all stats' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`stat_id`, `stat_name`, `description`, `default_val`, `on_char_creator`, `in_gym`) VALUES
(1, 'HP', 'Your health points.', '10', 1, 1),
(2, 'backpack', 'The amount of items you can hold', '10', 1, 1),
(3, 'attack', 'How much you can attack', '5', 1, 1),
(4, 'defend', 'How much attack you can withstand', '5', 1, 1),
(5, 'upgrade_points', '', '15', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) NOT NULL,
  `password` varchar(60) NOT NULL,
  `char_name` varchar(25) NOT NULL DEFAULT '',
  `money` int(11) NOT NULL DEFAULT '100',
  `new_mail` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='stores core user details' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `char_name`, `money`, `new_mail`, `avatar`) VALUES
(1, '1$AsiRlODyi/2', '1$jZpN/buYGDo', 'admin', 100, 0, 'public/avatars/avatar-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_equip`
--

CREATE TABLE IF NOT EXISTS `users_equip` (
  `uid` int(11) NOT NULL,
  `head` mediumint(5) NOT NULL DEFAULT '0',
  `weapon` mediumint(5) NOT NULL DEFAULT '0',
  `shield` mediumint(5) NOT NULL DEFAULT '0',
  `torso` mediumint(5) NOT NULL DEFAULT '0',
  `legs` mediumint(5) NOT NULL DEFAULT '0',
  `boots` mediumint(5) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_stats`
--

CREATE TABLE IF NOT EXISTS `users_stats` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `stat_1` varchar(10) NOT NULL COMMENT 'HP',
  `stat_2` varchar(10) NOT NULL COMMENT 'backpack',
  `stat_3` varchar(5) NOT NULL COMMENT 'attack',
  `stat_4` varchar(15) NOT NULL COMMENT 'defend',
  `stat_5` varchar(15) NOT NULL COMMENT 'upgrade_points',
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users_stats`
--

INSERT INTO `users_stats` (`uid`, `stat_1`, `stat_2`, `stat_3`, `stat_4`, `stat_5`) VALUES
(1, '12', '11', '12', '10', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
