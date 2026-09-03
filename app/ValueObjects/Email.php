<?php

namespace App\ValueObjects;

use InvalidArgumentException;

class Email
{
    public function __construct(
        private readonly string $value
    )
    {
        $this->validate($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('Email cannot be empty.');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }
    }
}