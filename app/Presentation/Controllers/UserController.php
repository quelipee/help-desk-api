<?php

namespace App\Presentation\Controllers;

use App\Application\DTOs\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Models\User;
use App\Presentation\Http\Request;
use App\Services\UserService;

class UserController
{
    public function __construct(
        private CreateUser  $createUser,
        private UserService $userService
    )
    {
    }

    public function create(Request $request): User
    {
        return $this->createUser->execute(CreateUserInput::fromArray($request->json()));
    }

    public function show(Request $request, array $params)
    {
        return $this->userService->findUser((int)$params['id']);
    }
}