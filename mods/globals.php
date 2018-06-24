<?php
//mysqli_report(MYSQLI_REPORT_ALL);
/*
 * Global file to declare and initialize things.
 */
require "mods/userclass.php";
require "mods/itemclass.php";
$uid = 0;
$user = null;

if(!module_installed($_GET['page'])) {
    ob_clean();
    //header('Status: HTTP/1.0 404 Not Found');
    header('Location: 404');
    exit;
}

if (array_key_exists('uid', $_SESSION)) {
    $uid = $_SESSION['uid'];
    $user = new user_class($_SESSION['uid']);
    $items = new item_class();
    /* Check to see if they've created their character */
    if (!current_module('character_creator')) {
        if (module_installed('character_creator') AND character_is_set_up($_SESSION['uid']) == FALSE) {
            ob_clean();
            header('Location: character_creator');
            exit;
        }
    }
    $top_navbar = '<li><a href="profile?id='. $_SESSION['uid'] .'">'. $user->getStat('char_name') .'</a></li> &middot; <li><a href="#">'. money_formatter($user->getStat('money')) .'</a></li>';
}

include_once('mods/cron_5mins.php');