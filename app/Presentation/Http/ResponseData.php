<?php

namespace App\Presentation\Http;

readonly class ResponseData
{
    public function __construct(
        public array $body,
        public int $statusCode,
        public array $headers = [],
    )
    {
    }
}