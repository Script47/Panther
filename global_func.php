<?php

function cron_is_ready($file, $time) {
   /*
   * Check to see if the cron is ready to be run
   */
    global $db;
    $get = "SELECT `file`, `last_update` FROM `crons` WHERE `file` = '" . $file . "' AND (unix_timestamp() - ( `last_update` + 100 ) )";
    $get = $db->prepare($get);
    if ($get) {
        $get->execute();
        $get->store_result();
        if($get->num_rows) {
            return true;
        }
    }

    return false;
}

function toFriendlyTime($var) {
  /*
   * Converts timestamp to friendly time
   */
  if( strlen($var) >= 10 ) { $var = $var - time(); }
  $minutes = $var/60;
  $minutes = explode(".", $minutes);
  $minutes = $minutes[0];
  $seconds = $var % 60; //substr( number_format($hours/60, 2), -2, 2);
  if($minutes > 0) {
     return "<span class='min'>". number_format($minutes,0) ."</span> minutes and <span class='sec'>". round(number_format($seconds,0)) ."</span> seconds";
  } else {
     return "<span class='sec'>". round(number_format($seconds,0)) ."</span> seconds";
  }
} 


function money_formatter($val) {
    /*
     * Returns a value as money
     */
     return number_format($val) .' coins';
}

function getItemInfo($item_id, $default) {
    global $db;
    /*
     * returns the item picture
     */
    
    if ($item_id > 0 AND $stmt = $db->prepare("SELECT `description` FROM `items` WHERE (`item_id`=?)")) {
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $stmt->bind_result($desc);
        $stmt->fetch();
        $stmt->close();
        $value = $desc;
    } else {
       $value = $default;
    }
    return $value;
}

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
    return hash(sha1, ($raw));
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
function get_current_module() {
    return $_GET['page'];
}

/**
 * Easy way to give success messages.
 * @param String $message - Default success message.
 */

function successMessage($message) {
    echo "<div class='alert alert-success'>$message</div>";
}

/**
 * Easy way to give error messages.
 * @param String $message - Default error message.
 */

function errorMessage($message) {
    echo "<div class='alert alert-error'>$message</div>";
}

/**
 * Easy way to update users mail.
 * @global DBCon $db - DB connection link.
 * @param INT $id - ID of the user.
 * @return type
 */

function updateNewMail($id) {
    global $db;

    return $db->query("UPDATE `users` SET new_mail=new_mail+1 WHERE id = $id");
}

/**
 * Set all the events to be read from the set users ID.
 * @global DBCon $db - DB connection link.
 * @param INT $id - ID of the user.
 */
function  updateAllEvents($id) {
    global $db;
    
    $updateNewEvent = $db->prepare("UPDATE `users` SET new_events=0 WHERE id = ?");
    $updateNewEvent->bind_param('i', $id);
    $updateNewEvent->execute();
    $updateNewEvent->close();
}

/**
 * Create an event to people and send them easily using this function.
 * @global DBCon $db - DB connection link.
 * @param INT $sendTo - ID of the person you send too.
 * @param INT $sentFrom - ID of the person you're sending it too.
 * @param String VarChar(225) $message - Message to go with the event.
 */
function createNewEvent($sentFrom, $sendTo, $message) {
    global $db;
    
    $createEvent = $db->prepare("INSERT INTO `events` (sentFrom, sendTo, Message) VALUES (?, ?, ?)");
    $createEvent->bind_param('iis', $sentFrom, $sendTo, $message);
    
    if($createEvent->execute()) {
        $updateNewEvent = $db->prepare("UPDATE `users` SET new_events=new_events+1 WHERE id = ?");
        $updateNewEvent->bind_param('i', $sendTo);
        $updateNewEvent->execute();
        $updateNewEvent->close();
    } else if(!$createEvent->execute()) {
        return false;
    }
    $createEvent->close();
}
?>