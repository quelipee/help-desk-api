<?php

namespace App\Presentation\Http;

class Response
{
    public function json(ResponseData $responseData) : string
    {
        foreach ($responseData->headers as $header => $value) {
            header("{$header}: {$value}");
        }
        http_response_code($responseData->statusCode);

        return json_encode($responseData->body, JSON_THROW_ON_ERROR);
    }
}