<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Repositories\InMemoryUserRepository;
use App\Services\UserService;

$repository = new InMemoryUserRepository();
$service = new UserService($repository);
$user = $service->createUser(1,'felipe','fe@gmail.com');
var_dump($service->findUser($user->getId()));