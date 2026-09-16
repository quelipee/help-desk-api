<?php

namespace App\Application\UseCases;

use App\Repositories\UserRepository;

class ListUsers
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function execute() : array
    {
        return $this->userRepository->findAll();
    }
}