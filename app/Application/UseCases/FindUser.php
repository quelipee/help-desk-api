<?php

namespace App\Application\UseCases;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\UserRepository;

class FindUser
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function execute(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if ($user === null) {
            throw new UserNotFoundException('User not found');
        }
        return $user;
    }
}