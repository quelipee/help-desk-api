<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function findUser(int $id): ?User
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException('User not found');
        }
        return $user;
    }
}