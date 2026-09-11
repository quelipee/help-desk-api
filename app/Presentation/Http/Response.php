<?php

namespace App\Presentation\Http;

class Response
{
    public function json(array $data, int $status)
    {
        header('Content-Type: application/json');
        http_response_code($status);

        return json_encode($data);
    }
}