<?php

if (cron_is_ready('cron_5mins.php', 1)) {
    //Put cron stuff here.

    $user->setStat($user->getStatId('upgrade_points'), $user->getStat('upgrade_points')+10);

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

