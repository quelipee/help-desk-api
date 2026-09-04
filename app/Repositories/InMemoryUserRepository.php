<?php

namespace App\Repositories;

use App\Models\User;

class InMemoryUserRepository implements UserRepository
{
    private array $users = [];
    public function save(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function findById(int $id): ?User
    {
        return $this->users[$id] ?? null;
    }
}