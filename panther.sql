-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2018 at 09:02 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `panther`
--

-- --------------------------------------------------------

--
-- Table structure for table `cron`
--

CREATE TABLE `cron` (
  `file` varchar(30) NOT NULL,
  `every` int(11) NOT NULL,
  `next_execution` bigint(20) UNSIGNED NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cron`
--

INSERT INTO `cron` (`file`, `every`, `next_execution`, `created`) VALUES
('cron-1-second', 1, 1529952022, '2018-06-25 18:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `crons`
--

CREATE TABLE `crons` (
  `file` varchar(20) NOT NULL,
  `last_update` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crons`
--

INSERT INTO `crons` (`file`, `last_update`) VALUES
('cron_5mins.php', 1529879112),
('cron_5mins.php', 1529879112);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` mediumint(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `category` smallint(3) NOT NULL,
  `description` varchar(200) NOT NULL,
  `buy_price` smallint(3) NOT NULL,
  `sell_price` smallint(3) NOT NULL,
  `equip_slot` enum('head','weapon','shield','torso','legs','boots','') NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items_categories`
--

CREATE TABLE `items_categories` (
  `category_id` smallint(3) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mailbox`
--

CREATE TABLE `mailbox` (
  `ID` int(11) NOT NULL,
  `SendTo` int(11) NOT NULL,
  `SentFrom` int(11) NOT NULL,
  `Subject` varchar(225) NOT NULL,
  `Message` text NOT NULL,
  `SentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mailbox`
--

INSERT INTO `mailbox` (`ID`, `SendTo`, `SentFrom`, `Subject`, `Message`, `SentOn`) VALUES
(1, 2, 1, 'test', '<script>alert(\'test\')</script>', '2018-06-24 21:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `name` varchar(25) NOT NULL,
  `val` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds game settings';

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`name`, `val`) VALUES
('game_description', 'Description soon.'),
('tos', 'Updated soon...'),
('game_description', 'Description soon.'),
('tos', 'Updated soon...');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `stat_id` int(11) NOT NULL,
  `stat_name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `default_val` varchar(50) NOT NULL,
  `on_char_creator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no',
  `in_gym` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=no|1=yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores all stats';

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`stat_id`, `stat_name`, `description`, `default_val`, `on_char_creator`, `in_gym`) VALUES
(1, 'HP', 'Your health points.', '10', 1, 1),
(2, 'backpack', 'The amount of items you can hold', '10', 1, 1),
(3, 'attack', 'How much you can attack', '5', 1, 1),
(4, 'defend', 'How much attack you can withstand', '5', 1, 1),
(5, 'upgrade_points', '', '15', 0, 0),
(6, 'test', 'new stat', '10', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(60) NOT NULL,
  `char_name` varchar(25) NOT NULL DEFAULT '',
  `money` int(11) NOT NULL DEFAULT '100',
  `new_mail` int(11) NOT NULL DEFAULT '0',
  `new_events` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='stores core user details';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `char_name`, `money`, `new_mail`, `new_events`, `avatar`) VALUES
(1, '1$AsiRlODyi/2', '1$jZpN/buYGDo', '0', 100, 0, 0, 'public/avatars/avatar-3.jpg'),
(2, 'Script47@hotmail.com', '36c892e836414ca8e63d5049648feadd1b4bb044', 'Script47', -4, 0, 0, 'public/avatars/avatar-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_equip`
--

CREATE TABLE `users_equip` (
  `uid` int(11) NOT NULL,
  `head` mediumint(5) NOT NULL DEFAULT '0',
  `weapon` mediumint(5) NOT NULL DEFAULT '0',
  `shield` mediumint(5) NOT NULL DEFAULT '0',
  `torso` mediumint(5) NOT NULL DEFAULT '0',
  `legs` mediumint(5) NOT NULL DEFAULT '0',
  `boots` mediumint(5) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_equip`
--

INSERT INTO `users_equip` (`uid`, `head`, `weapon`, `shield`, `torso`, `legs`, `boots`) VALUES
(2, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_stats`
--

CREATE TABLE `users_stats` (
  `uid` int(11) NOT NULL,
  `stat_1` varchar(10) NOT NULL COMMENT 'HP',
  `stat_2` varchar(10) NOT NULL COMMENT 'backpack',
  `stat_3` varchar(5) NOT NULL COMMENT 'attack',
  `stat_4` varchar(15) NOT NULL COMMENT 'defend',
  `stat_5` varchar(15) NOT NULL COMMENT 'upgrade_points',
  `stat_6` varchar(10) NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_stats`
--

INSERT INTO `users_stats` (`uid`, `stat_1`, `stat_2`, `stat_3`, `stat_4`, `stat_5`, `stat_6`) VALUES
(1, '12', '11', '12', '10', '0', '10'),
(2, '10', '10', '20', '5', '200', '10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cron`
--
ALTER TABLE `cron`
  ADD UNIQUE KEY `file` (`file`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `items_categories`
--
ALTER TABLE `items_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD KEY `name` (`name`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`stat_id`),
  ADD KEY `stat_id` (`stat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_equip`
--
ALTER TABLE `users_equip`
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users_stats`
--
ALTER TABLE `users_stats`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` mediumint(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items_categories`
--
ALTER TABLE `items_categories`
  MODIFY `category_id` smallint(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `stat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_stats`
--
ALTER TABLE `users_stats`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
