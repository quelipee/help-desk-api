<?php

namespace App\Presentation\Controllers;

use App\Application\DTOs\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Models\User;

class UserController
{
    public function __construct(
        private CreateUser $createUser
    )
    {
    }

    public function create(array $data) : User
    {
        return $this->createUser->execute(CreateUserInput::fromArray($data));
    }
}