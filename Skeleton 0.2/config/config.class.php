<?php
/**
 * @author Harry Denley
 */
class config {
    static $component = array();
    
    function __construct() {    
    }
    
    function set($what, $value) {
        global $component;
        $component[$what] = $value;
    }
    
    function get($what) {
        global $component;
        return $component[$what];
    }
}

?>
