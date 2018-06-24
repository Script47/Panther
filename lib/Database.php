<?php
class Database
{
    protected static $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function instance()
    {
        if (self::$instance === null) {
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_LAZY,
                PDO::ATTR_EMULATE_PREPARES => FALSE
            ];

            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
            } catch (PDOException $ex) {
                exit($ex->getMessage());
            }
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        return call_user_func_array([self::instance(), $method], $args);
    }

    public static function run($sql, $args = [])
    {
        $stmt = self::instance()->prepare($sql);
        $stmt->execute($args);
        
        return $stmt;
    }

    public static function transaction(callable $callback)
    {
        Database::beginTransaction();

        try {
            $callback();

            Database::commit();
        } catch (PDOException $e) {
            Database::rollBack();

            throw new PDOException($e->getMessage());
        }
    }
}