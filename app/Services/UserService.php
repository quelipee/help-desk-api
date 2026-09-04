<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\ValueObjects\Email;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function createUser(int $id, string $name, string $email) : User
    {
        $email_user = new Email($email);
        $user = new User($id, $name, $email_user);
        $this->userRepository->save($user);
        return $user;
    }

    public function findUser(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}