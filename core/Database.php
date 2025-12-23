<?php

class Database {
    private static ?PDO $instanse = null;

    private function __construct() {}

    public static function getConnection () : PDO {
        if(self::$instanse = null) {
            $config = require __DIR__ . '../config/database.php';

            $dsn ="mysql:host={$config['host']};dbname={$config['username']}";

            self::$instanse = new PDO(
                $dsn,
                $config['username'],
                $config['password'],

                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );



        }


        return self::$instanse;
    }
}