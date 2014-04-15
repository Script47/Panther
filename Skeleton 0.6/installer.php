<?php

/**
 * Panther Installer File
 * Developed By: Script47
 */

require_once('config/config.php');

echo '<center>';

$isInstalled = FALSE;

if($isInstalled == TRUE) {
    exit("Game has already been installed.".header("Location:2; index"));
} else {
    echo '<form method="post">
            <input type="submit" name="installSQL" title="Install Game" value="Install Game">
         </form>';
    
    if(isset($_POST['installSQL'])) {        
        $cronQuery = "CREATE TABLE IF NOT EXISTS `crons` (
        `file` varchar(20) NOT NULL,
        `last_update` int(11) NOT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

        $insertCrons = "INSERT INTO `crons` (`file`, `last_update`) VALUES
        ('cron_5mins.php', 1367801958)";

        $createCronsTable = $db->query($cronQuery);
        $insertCronsInToTable = $db->query($insertCrons);

        if($createCronsTable && $insertCronsInToTable) {
            echo '<font color="green">Created Cron table & inserted crons.</font><br/>';
        } else {
            echo '<font color="red">Could not create table or insert crons.</font><br/>';
            exit();
        }

        $itemsQuery = "CREATE TABLE IF NOT EXISTS `items` (
        `item_id` mediumint(5) NOT NULL AUTO_INCREMENT,
        `name` varchar(30) NOT NULL,
        `category` smallint(3) NOT NULL,
        `description` varchar(200) NOT NULL,
        `buy_price` smallint(3) NOT NULL,
        `sell_price` smallint(3) NOT NULL,
        `equip_slot` enum('head','weapon','shield','torso','legs','boots','') NOT NULL DEFAULT '',
        PRIMARY KEY (`item_id`),
        KEY `category` (`category`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $createItemsTable = $db->query($itemsQuery);

        if($createCronsTable && $insertCronsInToTable) {
            echo '<font color="green">Created Items table.</font><br/>';
        } else {
            echo '<font color="red">Could not create table.</font><br/>';
            exit();
        }

        $itemCategoriesQuery = "CREATE TABLE IF NOT EXISTS `items_categories` (
        `category_id` smallint(3) NOT NULL AUTO_INCREMENT,
        `name` varchar(35) NOT NULL,
        PRIMARY KEY (`category_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $createCategoriesTable = $db->query($itemCategoriesQuery);

        if($createCategoriesTable) {
            echo '<font color="green">Created Item Categories table.</font><br/>';
        } else {
            echo '<font color="red">Could not create Item Categories table.</font><br/>';
            exit();
        }

        $settingsTableQuery = "CREATE TABLE IF NOT EXISTS `settings` (
        `name` varchar(25) NOT NULL,
        `val` varchar(200) NOT NULL,
        KEY `name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Holds game settings';";

        $insertSettings = "INSERT INTO `settings` (`name`, `val`) VALUES
        ('game_description', 'Description soon.'),
        ('tos', 'Updated soon...');";

        $createSettingTable = $db->query($settingsTableQuery);
        $insertSettingInfo = $db->query($insertSettings);

        if($createSettingTable && $insertSettingInfo) {
            echo '<font color="green">Created Settings table & inserted settings.</font><br/>';
        } else {
            echo '<font color="red">Could not create Settings table or insert settings.</font><br/>';
            exit();
        }

        $statQuery = "CREATE TABLE IF NOT EXISTS `stats` (
        `stat_id` int(11) NOT NULL AUTO_INCREMENT,
        `stat_name` varchar(25) NOT NULL,
        `description` varchar(100) NOT NULL,
        `default_val` varchar(50) NOT NULL,
        `on_char_creator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no',
        `in_gym` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=no|1=yes',
        PRIMARY KEY (`stat_id`),
        KEY `stat_id` (`stat_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Stores all stats' AUTO_INCREMENT=6 ;";

        $insertStatsQuery = "INSERT INTO `stats` (`stat_id`, `stat_name`, `description`, `default_val`, `on_char_creator`, `in_gym`) VALUES
        (1, 'HP', 'Your health points.', '10', 1, 1),
        (2, 'backpack', 'The amount of items you can hold', '10', 1, 1),
        (3, 'attack', 'How much you can attack', '5', 1, 1),
        (4, 'defend', 'How much attack you can withstand', '5', 1, 1),
        (5, 'upgrade_points', '', '15', 0, 0);";

        $createStatsTable = $db->query($statQuery);
        $insertStats = $db->query($insertStatsQuery);

        if($createStatsTable && $insertStatsQuery) {
            echo '<font color="green">Created Stats table & inserted stats.</font><br/>';
        } else {
            echo '<font color="red">Could not create stats table or insert stats.</font><br/>';
            exit();
        }

        $createUsersTableQuery = 'CREATE TABLE IF NOT EXISTS `users` (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `email` varchar(120) NOT NULL,
        `password` varchar(60)NOT NULL,
        `char_name` varchar(25) NOT NULL DEFAULT "",
        `money` INT(11) NOT NULL DEFAULT 100,
        `new_mail` INT(11) NOT NULL DEFAULT 0,
        `new_events` INT(11) NOT NULL DEFAULT 0,
        `avatar` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT="stores core user details" AUTO_INCREMENT=2;';

        $insertUserQuery = 'INSERT INTO `users` (`id`, `email`, `password`, `char_name`, `avatar`) VALUES
        (1, "1$AsiRlODyi/2", "1$jZpN/buYGDo", "admin", "public/avatars/avatar-3.jpg");';

        $createUsersTable = $db->query($createUsersTableQuery);

        $insertUser = $db->query($insertUserQuery);

        if($createUsersTable && $insertUser) {
            echo '<font color="green">Created Users table.</font><br/>';
        } else {
            echo '<font color="red">Could not create Users table.</font><br/>';
            exit();
        }

        $createUserEquipQuery = "CREATE TABLE IF NOT EXISTS `users_equip` (
        `uid` int(11) NOT NULL,
        `head` mediumint(5) NOT NULL DEFAULT '0',
        `weapon` mediumint(5) NOT NULL DEFAULT '0',
        `shield` mediumint(5) NOT NULL DEFAULT '0',
        `torso` mediumint(5) NOT NULL DEFAULT '0',
        `legs` mediumint(5) NOT NULL DEFAULT '0',
        `boots` mediumint(5) NOT NULL DEFAULT '0',
        KEY `uid` (`uid`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

        $insertUserEquipQuery = "INSERT INTO `users_equip` (`uid`, `head`, `weapon`, `shield`, `torso`, `legs`, `boots`) VALUES
        (1, 0, 0, 0, 0, 0, 0);";

        $createUserEquip = $db->query($createUserEquipQuery);
        $insertUserEquip = $db->query($createUserEquipQuery);

        if($createUserEquip && $insertUserEquip) {
            echo '<font color="green">Created table User Equip & inserted User Equip.</font><br/>';
        } else {
            echo '<font color="red">Could not create User Equip table or insert User Equip.</font><br/>';
            exit();
        }

        $userStatsQuery = "CREATE TABLE IF NOT EXISTS `users_stats` (
        `uid` int(11) NOT NULL AUTO_INCREMENT,
        `stat_1` varchar(10) NOT NULL COMMENT 'HP',
        `stat_2` varchar(10) NOT NULL COMMENT 'backpack',
        `stat_3` varchar(5) NOT NULL COMMENT 'attack',
        `stat_4` varchar(15) NOT NULL COMMENT 'defend',
        `stat_5` varchar(15) NOT NULL COMMENT 'upgrade_points',
        PRIMARY KEY (`uid`),
        KEY `uid` (`uid`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;";

        $insertUserStatsQuery = "INSERT INTO `users_stats` (`uid`, `stat_1`, `stat_2`, `stat_3`, `stat_4`, `stat_5`) VALUES
        (1, '12', '11', '12', '10', '0');";

        $createUserStats = $db->query($userStatsQuery);
        $insertUserStats = $db->query($insertUserStatsQuery);

        if($createUserStats && $insertUserStats) {
            echo '<font color="green">Created table User Stats & inserted User Stats.</font><br/>';
        } else {
            echo '<font color="red">Could not create or insert User Stats.</font><br/>';
            exit();
        }
        
        $createMailboxQuery = "CREATE TABLE IF NOT EXISTS `mailbox` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `SendTo` int(11) NOT NULL,
        `SentFrom` int(11) NOT NULL,
        `Subject` varchar(225) NOT NULL,
        `Message` text NOT NULL,
        `SentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`ID`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        
        $createMailbox = $db->query($createMailboxQuery);
        
        if($createMailbox) {
            echo '<font color="green">Created table Mailbox.</font><br/>';
        } else {
            echo '<font color="red">Could not create table Mailbox.</font><br/>';
            exit();
        }
        
        $createEventsTableQuery = "CREATE TABLE IF NOT EXISTS `events` (
        `ID` int(11) NOT NULL AUTO_INCREMENT,
        `SentFrom` int(11) NOT NULL,
        `SendTo` int(11) NOT NULL,
        `Message` varchar(225) NOT NULL,
        `SentOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`ID`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        
        $createEventsTable = $db->query($createEventsTableQuery);
        
        if($createEventsTable) {
            echo '<font color="green">Created table Events.</font><br/>';
        } else {
            echo '<font color="red">Could not create table Events.</font><br/>';
            exit();
        }
        
        $isInstalled = TRUE;

        if($isInstalled == TRUE) {
            //unlink("installer.php");
            //unlink("dbSQL.sql");            
            echo '<font color="green">Game has been correctly installed. Go back to index page and create an account to start.</font><br/>';
            exit();
        } else {
            echo '<font color="red">Something went wrong.</font><br/>';
            exit();
        }
    }
}

echo '</center>';