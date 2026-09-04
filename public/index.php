<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\DTOs\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Repositories\InMemoryUserRepository;

$repository = new InMemoryUserRepository();
$createUser = new CreateUser($repository);

$data = [
    'id' => 1,
    'name' => 'felipe',
    'email' => 'fe@gmail.com'
];

$userDTO = CreateUserInput::fromArray($data);

$user = $createUser->execute($userDTO);
var_dump($user);