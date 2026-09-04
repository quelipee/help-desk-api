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

    public function findUser(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}