<?php
/*
 * All sessions are destoryed
 * Including session id
 * Basic logout module
 */
foreach($_SESSION as $key => $value) {
    unset($_SESSION['key']);
}
session_destroy();
ob_end_clean();
header('Location: index');
exit;
?>
