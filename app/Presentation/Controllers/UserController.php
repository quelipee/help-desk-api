<?php

namespace App\Presentation\Controllers;

use App\Application\DTOs\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Application\UseCases\FindUser;
use App\Application\UseCases\ListUsers;
use App\Presentation\Http\Request;
use App\Presentation\Http\ResponseData;

class UserController
{
    public function __construct(
        private CreateUser $createUser,
        private ListUsers  $listUsers,
        private FindUser   $findUser,
    )
    {
    }

    public function index(): ResponseData
    {
        $users = $this->listUsers->execute();
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->toArray();
        }
        return new ResponseData(
            body: ['data' => $data],
            statusCode: 200,
            headers: ['Content-Type' => 'application/json'],
        );
    }

    public function create(Request $request): ResponseData
    {
        $user = $this->createUser->execute(CreateUserInput::fromArray($request->json()));

        return new ResponseData(
            body: ['data' => $user->toArray()],
            statusCode: 201,
            headers: ['Content-Type' => 'application/json'],
        );
    }

    public function show(Request $request, array $params): ResponseData
    {
        $user = $this->findUser->execute((int)$params['id']);

        return new ResponseData(
            body: ['data' => $user->toArray()],
            statusCode: 200,
            headers: ['Content-Type' => 'application/json'],
        );
    }
}