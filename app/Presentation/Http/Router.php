<?php

namespace App\Presentation\Http;

use RuntimeException;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = new Route($method, $path, $handler);
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

        foreach ($this->routes as $route) {
            if (!$route->matches($method, $uri)) {
                continue;
            }
            $params = $route->getParams($uri);
            $handler = $route->getHandler();

            return $handler($request, $params);
        }

        throw new RuntimeException('No route matched');
    }
}