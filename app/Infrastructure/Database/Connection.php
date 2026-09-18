<?php

namespace App\Infrastructure\Database;

use PDO;

class Connection
{
    public function create(): PDO {
        return new PDO(
            'mysql:host=localhost;dbname=helpdesk',
            'root',
            '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
}