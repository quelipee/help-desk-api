<?php

namespace App;

use App\Infrastructure\Config\Config;
use App\Infrastructure\Container\Container;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;
use App\Repositories\UserRepository;
use PDO;


class Bootstrap
{
    public static function createContainer() : Container
    {
        $container = new Container();
        $config = new Config(__DIR__ . "/../.env");

        $container->singleton(Config::class, fn () => $config);
        $container->singleton(PDO::class, function () use ($container) {
            $connection = $container->get(Connection::class);
            return $connection->create();
        });

        $container->singleton(UserRepository::class, PdoUserRepository::class);
        return $container;
    }
}