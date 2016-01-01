<?php
$config = array();
$config['template'] = 'default';
$config['site_title'] = 'panther game engine';
$config['footer'] = $config['site_title'] .' is &copy; '. date('Y');

$db = new mysqli('localhost', 'root', '', 'panther_engine');
?>
