<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCases\CreateUser;
use App\Exceptions\UserAlreadyExistsException;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repositories\PdoUserRepository;
use App\Presentation\Controllers\UserController;
use App\Presentation\Http\ExceptionHandler;
use App\Presentation\Http\Request;
use App\Presentation\Http\Response;
use App\Presentation\Http\Router;

//$repository = new PdoUserRepository(Connection::getConn());
//$createUser = new CreateUser($repository);

//$userController = new UserController($createUser);
//$response = new Response();
$request = new Request();
$router = new Router();

//$exceptionHandler = new ExceptionHandler($response);
//set_exception_handler([$exceptionHandler, 'handle']);

//if ($request->getMethod() !== 'POST') {
//    echo $response->json(['message' => 'Method not allowed'], 405);
//    exit;
//}

$router->post('/users', function (Request $request) {
    return $request->getMethod();
});

$router->get('/users', function (Request $request) {
    return $request->getMethod();
});

$result = $router->dispatch($request);
echo $result;

//$data = $request->json();
//$user = $userController->create($data);
//echo $response->json($user->toArray(), 201);
