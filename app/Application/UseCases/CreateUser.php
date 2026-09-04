<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CreateUserInput;
use App\Models\User;
use App\Repositories\UserRepository;
use App\ValueObjects\Email;

class CreateUser
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function execute(CreateUserInput $userDTO): User
    {
        $email = new Email($userDTO->email);
        $user = new User($userDTO->id, $userDTO->name,$email);
        $this->userRepository->save($user);
        return $user;
    }
}