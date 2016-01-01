<?php

/*
 * Global file to declare and initialize things.
 */
require "mods/userclass.php";
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
    /* Check to see if they've created their character */
    if (!current_module('character_creator')) {
        if (module_installed('character_creator') AND character_is_set_up($_SESSION['uid']) == FALSE) {
            ob_clean();
            header('Location: character_creator');
            exit;
        }
    }
}
?>
