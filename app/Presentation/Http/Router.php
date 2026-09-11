<?php

namespace App\Presentation\Http;

use RuntimeException;

class Router
{
    private array $routes = [];
    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function dispatch(Request $request): mixed
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        $handler = $this->routes[$method][$uri] ?? null;
        if ($handler === null) {
            throw new RuntimeException('Route not found');
        }
        return $handler($request);
    }
}