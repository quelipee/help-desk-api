<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCases\CreateUser;
use App\Application\UseCases\ListUsers;
use App\Infrastructure\Config\Config;
use App\Infrastructure\Container\Container;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;
use App\Presentation\Controllers\UserController;
use App\Presentation\Http\ExceptionHandler;
use App\Presentation\Http\Request;
use App\Presentation\Http\Response;
use App\Presentation\Http\Router;
use App\Repositories\UserRepository;

$config = new Config(__DIR__ . '/../.env');

$container = new Container();
$container->singleton(PDO::class, fn() => (new Connection())->create());
$container->singleton(UserRepository::class, PdoUserRepository::class);

$userController = $container->get(UserController::class);


$response = new Response();
$request = new Request();
$router = new Router();

$exceptionHandler = new ExceptionHandler($response);
set_exception_handler([$exceptionHandler, 'handle']);

$router->post('/users', [$userController, 'create']);
$router->get('/users/{id}', [$userController, 'show']);
$router->get('/users/{id}/tickets/{ticketId}', [$userController, 'show']);

$router->get('/users', [$userController, 'index']);

$responseData = $router->dispatch($request);

//echo $response->json($responseData);