<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCases\CreateUser;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;
use App\Presentation\Controllers\UserController;
use App\Presentation\Http\ExceptionHandler;
use App\Presentation\Http\Request;
use App\Presentation\Http\Response;
use App\Presentation\Http\Router;
use App\Services\UserService;

$repository = new PdoUserRepository(Connection::getConn());
$createUser = new CreateUser($repository);
$userService = new UserService($repository);

$userController = new UserController($createUser, $userService);
$response = new Response();
$request = new Request();
$router = new Router();

$exceptionHandler = new ExceptionHandler($response);
set_exception_handler([$exceptionHandler, 'handle']);

$router->post('/users', [$userController, 'create']);
$router->get('/users/{id}', [$userController, 'show']);

$router->get('/users', function (Request $request) {
    return $request->getMethod();
});

$result = $router->dispatch($request);
$status = $request->getMethod() === 'POST' ? 201 : 200;

echo $response->json([
    'data' => $result->toArray()
], $status);
echo $status;