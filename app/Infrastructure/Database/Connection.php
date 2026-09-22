<?php

namespace App\Infrastructure\Database;

use App\Infrastructure\Config\Config;
use PDO;

readonly class Connection
{
    public function __construct(
        private Config $config,
    )
    {
    }

    public function create(): PDO {
        return new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                $this->config->get('DB_HOST'),
                $this->config->get('DB_NAME')
            ),
            $this->config->get('DB_USER'),
            $this->config->get('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
}