<?php

define('DB_NAME', 'panther');
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8');

require_once '../lib/Database.php';
require_once '../lib/Cron.php';

(new Cron('cron-1-second'))->every(1)->save()->complete(function ($overdue_by) {
    Database::run("UPDATE `users` SET `char_name` = '$overdue_by' WHERE `id` = 1");
});
