<?php
require_once('config.class.php');
require_once('constants.php');

/* 
 * Create an array to store the settings
 * Initiate the $config var */
$settings = array();
$config = null;

/* Create the database connection */
$settings['host'] = '127.0.0.1';
$settings['user'] = 'root';
$settings['password'] = '';
$settings['database'] = 'panther_engine';
$configuration = new config($settings);

/* Choose the default template */
$settings['template'] = 'default';
$configuration->set('template', $settings['template']);

/* Create the site/project title */
$settings['site_title'] = 'panther game engine';
$configuration->set('site_title', $settings['site_title']);

/* Create the site/project footer */
$settings['footer'] = '&copy '. date('Y');
$configuration->set('footer', $settings['footer']);

/* Set the config var to fetch configuration stuff */
$config = function($component) {
  global $configuration;
  return $configuration->get($component);  
};

/* Now, set the database stuff to $db var */
$db = new mysqli ($settings['host'], $settings['user'], $settings['password'], $settings['database']);

/* Now, set the error handler, to our error handler */
require "lib/error_handling.php";

/*
$config = array();
$config['template'] = 'call_of_duty';
$config['site_title'] = 'panther game engine';
$config['footer'] = $config['site_title'] .' is &copy; '. date('Y');

$db = new mysqli('localhost', 'root', '', 'panther_engine');
 */
