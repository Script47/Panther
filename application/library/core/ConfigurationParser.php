<?php

class ConfigurationParser
{
    private $file_location = 'application/config/game.ini';
    
    private $vars = [];
    
    public function __construct()
    {
        $this->vars = parse_ini_file($this->file_location);
    }
    
    public function get(string $key) {
        return $this->vars[$key];
    }
}