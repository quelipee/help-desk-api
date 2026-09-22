<?php

namespace App\Infrastructure\Config;

use RuntimeException;

class Config
{
    private array $values = [];

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new RuntimeException("Config file {$file} does not exist");
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            $this->values[trim($key)] = trim($value);
        }
    }

    public function get(string $key): ?string
    {
        return $this->values[$key] ?? null;
    }
}