<?php

namespace App\Application\DTOs;
readonly class CreateUserInput
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $email,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
        );
    }
}