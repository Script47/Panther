-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2013 at 09:27 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `panther_engine`
--

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
('game_description', 'Panther is a free game ''engine'', developed by sniko.'),
('tos', 'Updated soon...');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `stat_id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_name` varchar(25) NOT NULL,
  `default_val` varchar(50) NOT NULL,
  `on_char_creator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no',
  PRIMARY KEY (`stat_id`),
  KEY `stat_id` (`stat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Stores all stats' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`stat_id`, `stat_name`, `default_val`, `on_char_creator`) VALUES
(1, 'hp', '10', 1),
(2, 'str', '5', 1),
(3, 'def', '5', 1),
(4, 'luck', '5', 1),
(5, 'upgrade_points', '15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `char_name` varchar(25) NOT NULL DEFAULT '',
  `avatar` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores core user details' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--


-- --------------------------------------------------------

--
-- Table structure for table `users_stats`
--

CREATE TABLE IF NOT EXISTS `users_stats` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `stat_1` varchar(10) NOT NULL,
  `stat_2` varchar(10) NOT NULL,
  `stat_3` varchar(10) NOT NULL,
  `stat_4` varchar(10) NOT NULL,
  `stat_5` varchar(10) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users_stats`
--

