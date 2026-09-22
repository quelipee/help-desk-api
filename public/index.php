<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Bootstrap;
use App\Presentation\Controllers\UserController;
use App\Presentation\Http\ExceptionHandler;
use App\Presentation\Http\Request;
use App\Presentation\Http\Response;
use App\Presentation\Http\Router;

$container = Bootstrap::createContainer();
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

echo $response->json($responseData);