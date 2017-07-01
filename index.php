<?php
define('ROOT', __DIR__);

function __autoload($class_name)
{
    if (file_exists(ROOT . '/application/library/core/' . $class_name . '.php'))
        require_once ROOT . '/application/library/core/' . $class_name . '.php';
    
    if (file_exists(ROOT . '/application/library/app/' . $class_name . '.php'))
        require_once ROOT . '/application/library/app/' . $class_name . '.php';
}

$registry = new Registry();

echo $registry->configuration_parser->get('game_name');