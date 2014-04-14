<?php
session_start();
ob_start();
ob_implicit_flush(0);
/*
 * NOTES
 * Look into memcache
 * 
 */

require_once('lib/template.php');
require_once('config/config.php');
require_once('global_func.php');

$template = array();
$temp['content'] = '';
$temp['top_right'] = '';
$temp['menu'] = '';

$template = new template('templates/' . $config('template') . '/'. 
(isset($_SESSION['uid']) ? 'main.php' : 'outgame.php') );

$template->set('title', $config('site_title'));
$template->set('footer', $config('footer'));

if(! array_key_exists('uid', $_SESSION) AND !in_array($_GET['page'], array('signup', 'index')) ) {
    ob_clean();
    session_destroy();
    unset($_SESSION['uid']);
    header('Location: index');
    exit;
}

if (array_key_exists('page', $_GET)) {

    $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING) ? htmlspecialchars($_GET['page']) : '';
    $page = in_array($page, scandir('mods', 1)) ? $page : (isset($_SESSION['uid']) ? 'home' : 'index');

    ob_start();
    include_once('mods/' . $page . '/main.php');
    $file = ob_get_contents();
    ob_end_clean();
    $temp['content'] = $file;
} else {
    ob_start();
    include_once('mods/index/main.php');
    $file = ob_get_contents();
    ob_end_clean();
    $temp['content'] = $file;
}

//Determine where the menu should go
$menu_selector = "menu";
if( !array_key_exists('page', $_GET) OR (array_key_exists('page', $_GET) AND in_array($_GET['page'], array('index', 'signup'))) ) {
   $menu_selector = "top_navbar";
}

$menu = array_key_exists('loggedin', $_SESSION) ? 'home' : 'index';
//Fetch the menu data :)
ob_start();
include_once('mods/' . $menu . '/menu.php');
$file = ob_get_contents();
ob_end_clean();
$temp['menu'] = $file;

//Create the module title
if( !defined('module_title') ) {
  define('module_title', '!Module title not defined.');
}
$template->set('current_module', module_title);
$template->set('menu', $temp['menu']);
$template->set('content', $temp['content']);
$template->set('top_right', $temp['top_right']);

echo $template->output();
ob_end_flush();
?>