<?php

namespace App\Presentation\Http;

use App\Exceptions\InvalidJsonException;
use JsonException;

class Request
{
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): string
    {
        // serve para descobrir qual pagina o usuario esta tentando acessar
        // ja o parse_url serve para fatiar a url, assim ignorando tudo que vem depois do ? ex: ?codigo=45
        return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }

    public function json(): array
    {
        $content = file_get_contents('php://input');
        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidJsonException($e->getMessage(), 0, $e);
        }

    }
}