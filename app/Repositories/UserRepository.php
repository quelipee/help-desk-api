<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function save(User $user): void;

    public function findById(int $id): ?User;
}