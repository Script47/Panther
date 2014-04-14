<?php

class item_class {

    function __construct() {
        
    }

    public function getName($id) {
        /*
         * Gets the items name
         */
        global $db;
        $id = (int) $id;
        $qry = "SELECT `name` FROM `items` WHERE `item_id`=$id";
        $query = $db->prepare($qry);
        if ($query) {
            $query->execute();
            $query->bind_result($sid);
            $query->fetch();
            $query->store_result();
            return $sid;
        } else {
            return false;
        }
        $query->close();
    }

    public function getSlot($id) {
        /*
         * Gets the items equip_slot
         */
        global $db;
        $id = (int) $id;
        $qry = "SELECT `equip_slot` FROM `items` WHERE `item_id`=$id";
        $query = $db->prepare($qry);
        if ($query) {
            $query->execute();
            $query->bind_result($slot);
            $query->fetch();
            $query->store_result();
            return $slot;
        } else {
            return false;
        }
        $query->close();
    }

    public function getDesc($id) {
        /*
         * Gets the items desc
         */
        global $db;
        $id = (int) $id;
        $qry = "SELECT `description` FROM `items` WHERE `item_id`=$id";
        $query = $db->prepare($qry);
        if ($query) {
            $query->execute();
            $query->bind_result($desc);
            $query->fetch();
            $query->store_result();
            return $desc;
        } else {
            return false;
        }
        $query->close();
    }

    public function itemsInBackpack() {
        global $db;
        $sql = "SELECT `user_id`
        FROM `inventory`
        WHERE `user_id`={$_SESSION['uid']}";
        $get_items = $db->prepare($sql);
        $get_items->execute();
        $get_items->store_result();
        return $get_items->num_rows;
    }

    public function addItem($userid, $item_id, $qty) {
        global $db, $user;
        /*
         * Inserts an item into their inventory 
         */
        if ($user->getStat('backpack') <= item_class::itemsInBackpack() + 1) {
            echo '<div class="alert alert-error">Your backback is full! You cannot get ' . $qty . ' x ' . item_class::getName($item_id) . '!</div>';
            return false;
        }

        if (!item_class::hasItem($userid, $item_id)) {
            $qry = "INSERT INTO `inventory` (`item_id`,`user_id`,`qty`) VALUES (?,?,?)";
            $do = $db->prepare($qry);
            if ($do) {
                $do->bind_param('iii', $item_id, $userid, $qty);
                $do->execute();
            } else {
                return FALSE;
            }
        } else {
            $qry = "UPDATE `inventory` SET `qty`=`qty`+" . $qty . " WHERE `item_id`=" . $item_id . " AND `user_id`=" . $userid;
            $do = $db->prepare($qry);
            if ($do) {
                $do->execute();
            } else {
                return FALSE;
            }
        }
    }

    public function removeItem($userid, $item_id, $qty) {
        global $db;
        /*
         * Inserts an item into their inventory 
         */
        if (item_class::hasItem($userid, $item_id, $qty)) {
            $qry = "UPDATE `inventory` SET `qty`=`qty`-" . $qty . " WHERE (`item_id`=" . $item_id . ") AND (`user_id`=" . $userid . ")";
            $do = $db->prepare($qry);
            $do->execute();
            $do->store_result();
            return $do->affected_rows;
        } else {
            return false;
        }
    }

    public function hasItem($userid, $item_id, $qty = NULL) {
        global $db;
        /*
         * Checks to see if they have an item
         */
        $qry = "SELECT `item_id` FROM `inventory` WHERE `item_id`=$item_id AND `user_id`=$userid " . ($qty ? 'AND `qty`>=' . $qty : null);
        $query = $db->prepare($qry);
        if ($query) {
            $query->execute();
            $query->store_result();
            if ($query->num_rows) {
                return true;
            }
        } else {
            return false;
        }
        $query->close();
    }

}