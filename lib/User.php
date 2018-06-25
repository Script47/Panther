<?php

class User {
    const TABLE = 'user';
    const PRIMARY_KEY = 'id';

    public static function create()
    {

    }

    public static function update()
    {

    }

    public static function delete($id)
    {
        Database::run
    }

    /**
     * 
     */
    public static function get($id)
    {
       $user = Database::run('SELECT * FROM `' . self::TABLE . '` WHERE `' . self::PRIMARY_KEY . '` = ?', [$id]);

       return $user->rowCount() === 1 ? $user->fetch() : false;
    }

    public static function get_by($key_val_array)
    {
        $sql = 'SELECT * FROM `user` WHERE ';
        $count = 1;
        $values = [];

        foreach ($key_val_array as $column => $val) {
            if ($count === count($key_val_array)) {
                $sql .= '`' . $column . '` = ?';
            } else {
                $sql .= '`' . $column . '` = ? AND ';
            }

            array_push($values, $val);

            $count++;
        }

        $user = Database::run($sql, $values);

        return $user->rowCount() >= 1 ? $user->fetch() : false;
    }
}