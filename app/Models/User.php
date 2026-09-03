<?php

namespace App\Models;

use App\ValueObjects\Email;
use InvalidArgumentException;

class User
{
    public function __construct(
        private readonly int $id,
        private string $name,
        private Email $email
    )
    {
        $this->validateName($name);
    }

    public function getId() : int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name) : void
    {
        $this->validateName($name);
        $this->name = $name;
    }

    public function getEmail() : string
    {
        return $this->email->getValue();
    }

    public function changeEmail(Email $email) : void
    {
        $this->email = $email;
    }

    private function validateName(string $name): void
    {
        if (empty($name) || trim($name) === '') {
            throw new InvalidArgumentException('Name cannot be empty');
        }
        if (mb_strlen(trim($name)) < 3) {
            throw new InvalidArgumentException('Name cannot be less than 3 characters');
        }
    }
}