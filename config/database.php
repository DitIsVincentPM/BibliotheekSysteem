<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $dbname = 'bibliotheek';
            $username = 'root';
            $password = 'root';

            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Could not connect to the database $dbname :" . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}