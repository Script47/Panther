<?php
require_once('config.class.php');
require_once('constants.php');

/* 
 * Create an array to store the settings
 * Initiate the $config var */
$settings = array();
$config = null;

/* Create the database connection */
$settings['host'] = 'localhost';
$settings['user'] = 'root';
$settings['password'] = '';
$settings['database'] = 'demodb';
$configuration = new config($settings);

/* Choose the default template */
$settings['template'] = 'default';
$configuration->set('template', $settings['template']);

/* Create the site/project title */
$settings['site_title'] = 'Panther';
$configuration->set('site_title', $settings['site_title']);

/* Create the site/project footer */
$settings['footer'] = '<div class="pull-left">&copy 2013 &middot; All rights reserved. <br />
                      '. $settings['site_title'] .' is built with Panther Open-Source Engine.</div>
                       <div class="pull-right"><a href="http://www.sniko.net/" target="_blank">Developer Site</a> <br />
                                               <a href="https://github.com/snikonet" target="_blank">Developer GitHub</a> <br /></div>';
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
