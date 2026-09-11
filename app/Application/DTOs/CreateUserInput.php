<?php

namespace App\Application\DTOs;


use InvalidArgumentException;

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
        if (!isset($data['id'])) {
            throw new InvalidArgumentException('id is required');
        }

        if (!is_int($data['id'])) {
            throw new InvalidArgumentException('id must be an integer');
        }

        if (!isset($data['name'])) {
            throw new InvalidArgumentException('name is required');
        }
        if (!is_string($data['name'])) {
            throw new InvalidArgumentException('name must be a string');
        }
        if (!isset($data['email'])) {
            throw new InvalidArgumentException('email is required');
        }
        if (!is_string($data['email'])) {
            throw new InvalidArgumentException('email must be a string');
        }

        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
        );
    }
}