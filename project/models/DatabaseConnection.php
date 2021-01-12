<?php


namespace Project\Models;


class DatabaseConnection
{
    protected static $instance;
    private static $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.'';
    private static $username = DB_USER;
    private static $password = DB_PASS;

    private function __construct() {
        try {
            self::$instance = new \PDO(self::$dsn, self::$username, self::$password);
        } catch (\PDOException $e) {
            echo "MySql Connection Error: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            new DatabaseConnection();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}