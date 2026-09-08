<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\DTOs\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;

$conn = new Connection();
$repository = new PdoUserRepository($conn->getConn());
$createUser = new CreateUser($repository);

$data = [
    'id' => 1,
    'name' => 'felipe',
    'email' => 'fe@gmail.com'
];

$userDTO = CreateUserInput::fromArray($data);
$user = $createUser->execute($userDTO);
print_r($user);