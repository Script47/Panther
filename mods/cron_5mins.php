<?php

if (cron_is_ready('cron_5mins.php', 300)) {
    //Put cron stuff here.
    update();
}

function update() {
    global $db;
    $qry = "UPDATE `crons` SET `last_update`=unix_timestamp() WHERE `file`='cron_5mins.php'";
    $query = $db->prepare($qry);
    if ($query) {
        $query->execute();
    }
}

