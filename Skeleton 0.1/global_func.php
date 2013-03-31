<?php

function settings($name) {
    global $db;
    /*
     * Get site settings
     */
    $value = '';
    if ($stmt = $db->prepare("SELECT `val` FROM `settings` WHERE (`name`=?)")) {
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($value);
        $stmt->fetch();
        $stmt->close();
    }
    return $value;
}

function encryptpasscode($raw) {
    /*
     * Encrypts passwords/passcodes
     */
    return crypt($raw, CRYPT_SHA256);
}

function character_is_set_up($user_id) {
    global $db;
    /*
     * Check to see if the user has completed
     * character set-up
     */
    $char_name = '';
    $query = $db->query("SELECT `char_name` FROM `users` WHERE `id`=$user_id");
    if ($query->num_rows) {
        $r = $query->fetch_row();
        if ($r['0'] == '') {
            return FALSE;
        } else {
            return TRUE;
        }
    } else {
        return FALSE;
    }
}

function module_installed($module) {
    if (file_exists('mods/' . $module . '/main.php')) { /* The main file exists */
        /* Check to see if it's enabled */
        if (!file_exists('mods/' . $module . '/disabled.panther')) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}
function current_module($module) {
    if( $_GET['page'] == $module ) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>
