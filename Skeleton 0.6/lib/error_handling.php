<?php

/**
 * Handles errors.
 *
 * @author Harry Denley
 */

function panther_error_handling($errno, $errstr, $errfile, $errline) {
    $message = "An error occurred in script <strong>{$errfile}</strong>, on line {$errline}: <pre>{$errstr}</pre>";
    echo "<div class='alert alert-error'>
               {$message} <br />
               <small>Error Number: {$errno}</small>
              </div> <br /><br />";
    //debug_print_backtrace();
    return true;
}

set_error_handler('panther_error_handling');
?>
