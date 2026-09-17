<?php

namespace App\Presentation\Http;

class Route
{
    public function __construct(
        private string $method,
        private string $path,
        private        $handler,
    )
    {
    }

    public function matches(string $method, string $uri): bool
    {
        if ($this->method !== $method) {
            return false;
        }
        return $this->matchRoute($this->path, $uri) !== null;
    }

    public function getParams(string $uri): ?array
    {
        return $this->matchRoute($this->path, $uri);
    }

    public function getHandler(): callable
    {
        return $this->handler;
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