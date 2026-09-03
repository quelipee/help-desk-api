<?php

namespace App\Models;

use InvalidArgumentException;

class User
{
    private string $name;
    private string $email;

    public function __construct(
        string $name,
        string $email,
    )
    {
        $this->name = $this->validateName($name);
        $this->email = $this->validateEmail($email);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    private function validateName(string $name): string
    {
        if (empty($name) || trim($name) === '') {
            throw new InvalidArgumentException('Name cannot be empty');
        }
        return $name;
    }

    private function validateEmail(string $email): string
    {
        if (empty($email) || trim($email) === '') {
            throw new InvalidArgumentException('Email cannot be empty');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is not valid');
        }
        return $email;
    }
}