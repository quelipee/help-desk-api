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
            $this->response->json(new ResponseData(['message' => $exception->getMessage()], 409));
            return;
        }
        if ($exception instanceof InvalidArgumentException || $exception instanceof InvalidJsonException) {
            $this->response->json(new ResponseData(['message' => $exception->getMessage()], 400));
            return;
        }
        if ($exception instanceof UserNotFoundException) {
            $this->response->json(new ResponseData(['message' => $exception->getMessage()], 404));
            return;
        }
        $this->response->json(new ResponseData(['message' => 'Internal server error'], 500));
    }
}