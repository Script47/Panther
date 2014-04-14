<?php

class user_class {

    var $uid;

    function __construct($uid) {
        $this->uid = $uid;
    }

    function getLevel() {
        $exp = user_class::getStat('exp');
        $level = ($exp < 100) ? 1 : floor($exp / 100);
        return $level;
    }
    
    public function getMoney($userID) {
        global $db;
        
        $selectMoney = $db->query("SELECT * FROM `users` WHERE id=$userID");
        $money = mysqli_fetch_assoc($selectMoney);
        
        return $money['money'];
    }

    public function addMoney($ammountToAdd, $userID) {
        global $db;
        
        $updateUser = $db->prepare("UPDATE `users` SET money=money+$ammountToAdd WHERE id=?");
        $updateUser->bind_param('i', $userID);
        $updateUser->execute();
    }
    
    public function minusMoney($ammountToMinus, $userID) {
        global $db;
        
        $updateUser = $db->prepare("UPDATE `users` SET money=money-$ammountToMinus WHERE id=?");
        $updateUser->bind_param('i', $userID);
        $updateUser->execute();
    }
    
    public function getEquipSlot($slot) {
        global $db;
        $sql = "SELECT $slot FROM users_equip WHERE `uid`=?";
        $query = $db->prepare($sql);
        if ($query) {
            $query->bind_param('i', $this->uid);
            $query->execute();
            $query->bind_result($r);
            $query->store_result();
            $query->fetch();
            return $r;
        } else {
            return "0";
        }
    }

    public function getStat($stat_name) {
        global $db;
        //First, check users table
        $qry = "SELECT `{$stat_name}` FROM `users` WHERE `id`={$this->uid}";
        $query = $db->query($qry);

        if ($query AND $query->num_rows) {
            $r = $query->fetch_row();
            return $r['0'];
        } else {
            //Check the users_stats table, cool.
            $qry = "SELECT  `stat_id` FROM  `stats` WHERE  `stat_name` =  '{$stat_name}'";
            $query = $db->query($qry);
            //stat exists
            if ($query AND $query->num_rows) {
                $r = $query->fetch_row();
                //get it from users_stats
                $qry = "SELECT `stat_{$r['0']}` FROM `users_stats` WHERE `uid`={$this->uid}";
                $us = $db->query($qry);

                if ($us->num_rows) {
                    $r = $us->fetch_row();
                    return $r['0'];
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    public function getStatId($name) {
        global $db;
        /*
         * Gets the id of a stat from `users_stats` and `stats`
         */
        $name = (string) $name;
        $sid = 0;
        $qry = "SELECT `stat_id` FROM `stats` WHERE `stat_name`='$name'";
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

    public function getStatName($id) {
        global $db;
        /*
         * Gets the name of a stat from `users_stats` and `stats`
         */
        $id = (int) $id;
        $sid = 0;
        $qry = "SELECT `stat_name` FROM `stats` WHERE `stat_id`=$id";
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

    public function setStat($stat_name, $stat_value) {
        global $db;
        $qry = "UPDATE `users` SET `{$stat_name}`='{$stat_value}' WHERE `id`=?";
        $query = $db->prepare($qry);
        //print_r($query);
        if ($query) {
            $query->bind_param('i', $this->uid);
            $query->execute();
            $query->store_result();
            if ($query->affected_rows) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        $stat_name = 'stat_' . $stat_name;
        $q = "UPDATE `users_stats` SET $stat_name='{$stat_value}' WHERE `uid`=?";
        $query_us = $db->prepare($q);
        if ($query_us) {
            $query_us->bind_param('i', $this->uid);
            $query_us->execute();
            $query_us->store_result();
            if ($query_us->affected_rows) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

}