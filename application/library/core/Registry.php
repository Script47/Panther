<?php

class Registry
{
    public $configuration_parser = null;
    
    public function __construct()
    {
        $this->configuration_parser = new ConfigurationParser();
    }
}

