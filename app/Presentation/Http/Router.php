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
            if ($method === 'GET') {
                return $handler($params);
            }
            return $handler($request, $params);
        }
        throw new RuntimeException('No route matched');
    }

    private function matchRoute(string $route, string $uri): ?array
    {
        preg_match_all('/\{([^}]+)\}/', $route, $paramNames);

        $pattern = preg_replace(
            '/\{([^}]+)\}/',
            '(\d+)',
            $route
        );

        $pattern = "#^" . $pattern . "$#";

        if (!preg_match($pattern, $uri, $matches)) {
            return null;
        }

        $params = [];

        foreach ($paramNames[1] as $index => $name) {
            $params[$name] = $matches[$index + 1];
        }
        return $params;
    }
}