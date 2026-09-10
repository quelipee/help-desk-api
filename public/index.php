<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCases\CreateUser;
use App\Exceptions\UserAlreadyExistsException;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;
use App\Presentation\Controllers\UserController;

$repository = new PdoUserRepository(Connection::getConn());
$createUser = new CreateUser($repository);
$userController = new UserController($createUser);

$data = [
    'id' => 911112212111,
    'name' => 'felipe',
    'email' => 'fe@gmail.com'
];

try {
    $user = $userController->create($data);

    header('Content-Type: application/json');
    http_response_code(201);

    echo json_encode(['data' => $user->toArray()]);
} catch (UserAlreadyExistsException $e) {
    header('Content-Type: application/json');
    http_response_code(409);
    echo json_encode(['message' => $e->getMessage()]);
}