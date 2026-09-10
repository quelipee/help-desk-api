<?php

namespace App\Infrastructure\Database;

use PDO;

class Connection
{
    private static ?PDO $instance = null;
    public static function getConn(): PDO {
        if (!isset(self::$instance)) {
            self::$instance = new PDO('mysql:host=localhost;dbname=helpdesk', 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        return self::$instance;
    }
}