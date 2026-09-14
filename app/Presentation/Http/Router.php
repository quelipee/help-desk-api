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

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $params = $this->matchRoute($route, $uri);
            if ($params === null) {
                continue;
            }
            return $handler($request, $params);
        }
        throw new RuntimeException('No route matched');
    }

    public function matchRoute(string $route, string $uri): ?array
    {
        $pattern = str_replace('{id}', '(\d+)', $route);
        $pattern = "#^" . $pattern . "$#";

        if (!preg_match($pattern, $uri, $matches)) {
            return null;
        }
        return [
            'id' => $matches[1],
        ];
    }
}