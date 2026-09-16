<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCases\CreateUser;
use App\Application\UseCases\ListUsers;
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
$listUsers = new ListUsers($repository);

$userController = new UserController($createUser, $listUsers, $userService);
$response = new Response();
$request = new Request();
$router = new Router();

$exceptionHandler = new ExceptionHandler($response);
set_exception_handler([$exceptionHandler, 'handle']);

$router->post('/users', [$userController, 'create']);
$router->get('/users/{id}', [$userController, 'show']);

$router->get('/users', [$userController, 'index']);

$responseData = $router->dispatch($request);

echo $response->json($responseData);