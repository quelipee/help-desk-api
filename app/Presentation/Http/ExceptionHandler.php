<?php

namespace App\Presentation\Http;

use App\Exceptions\InvalidJsonException;
use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use InvalidArgumentException;
use Throwable;

class ExceptionHandler
{
    public function __construct(
        private Response $response,
    )
    {
    }

    public function handle(Throwable $exception): void
    {
        if ($exception instanceof UserAlreadyExistsException) {
            echo $this->response->json(['message' => $exception->getMessage()], 409);
            return;
        }
        if ($exception instanceof InvalidArgumentException || $exception instanceof InvalidJsonException) {
            echo $this->response->json(['message' => $exception->getMessage()], 400);
            return;
        }
        if ($exception instanceof UserNotFoundException) {
            echo $this->response->json(['message' => $exception->getMessage()], 404);
            return;
        }
        echo $this->response->json(['message' => 'Internal server error'], 500);
    }
}