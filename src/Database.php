<?php

namespace Avitotask;

use PDO;
use PDOException;

class Database {

    private static $db;

    private function __construct() { }

    public static function getConnection() {
        if (empty(self::$db)) {
            $params = include('config/config.php');

            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset=utf8";
            try {
                $opt = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                );
                self::$db = new PDO($dsn, $params['user'], $params['password'], $opt);

            } catch (PDOException $e) {
                echo "DB error: " . $e->getMessage();
                exit();
            }
        }

        return self::$db;
    }

}