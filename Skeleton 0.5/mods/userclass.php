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

    public function setStats ( $setValues ) {

        if ( is_array ( $setValues ) ) {
            return $this->setMultiple ( 'users_stats', $setValues );
        }

        return false;
    }

    public function setInfo ( $setValues ) {

        if ( is_array ( $setValues ) ) {
            return $this->setMultiple ( 'users', $setValues );
        }

        return false;
    }


    protected function setMultiple ( $table, $setValues ) {
        global $db;

        /* Default Variables */
        $queryFields = '';
        $queryTypes = '';

        $queryBinds = array();
        $queryValues = array(); //Work around for reference when passing variables through $setValues.

        foreach ( $setValues as $field => $value ) {
            $type = gettype ( $value );
            switch ( $type ) {
                case 'boolean' : $queryTypes.='b'; break;
                case 'string' : $queryTypes.='s'; break;
                case 'integer' : $queryTypes.='i'; break;
                default: return false;
            }

            $queryValues[$field] = $value;
            $queryFields .= $db->real_escape_string ( $field ).' = ?,';
            $queryBinds[] = &$queryValues[$field];
        }

        /* Manual addition of the users id. */
        $queryTypes .= 'i';
        $queryBinds[] = &$this->uid;

        /* Remove trailing comma on $queryFields */
        $queryFields = substr_replace ( $queryFields, '', -1 );

        /* Initial update variables. */
        $affectedRows = 0;
        $query = 'UPDATE '.$db->real_escape_string ( $table ).' SET '.$queryFields.' WHERE ( uid = ? )';

        /* Update query */
        if ( $upd = $db->prepare ( $query ) ) {
            /* Apply bindings to query */
            call_user_func_array ( array ( $upd, 'bind_param' ), array_merge ( array ( &$queryTypes ), $queryBinds ) );
            $upd->execute();
            $affectedRows = $upd->affected_rows;
            $upd->close();
        }

        if ( $affectedRows ) 
            return true;

        return false;
    }

}