<?php
/**
 * Logout Module
 * Developed By: Script47
 */

session_unset();
session_destroy();
ob_end_clean();
header("Location: index.php");
exit;
