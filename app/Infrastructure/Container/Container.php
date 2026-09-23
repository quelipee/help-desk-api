<?php

namespace App\Infrastructure\Container;

use Closure;
use RuntimeException;
use ReflectionClass;
use ReflectionException;

class Container
{
    private array $bindings = [];
    private array $singletons = [];
    private array $instances = [];
    private array $resolving = [];

    public function bind(string $abstract, callable|string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, callable|string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
        $this->singletons[$abstract] = true;
    }

    /**
     * @throws ReflectionException
     */
    public function get(string $abstract): object
    {
        if (in_array($abstract, $this->resolving, true)) {
            $cycle = implode(' -> ', [...$this->resolving, $abstract]);
            throw new RuntimeException("Circular dependency detected: {$cycle}");
        }

        if (isset($this->singletons[$abstract]) && isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $this->resolving[] = $abstract;
        try {
            $concrete = $this->bindings[$abstract] ?? $abstract;

            if ($concrete instanceof Closure) {
                $instance = $concrete();
            } else {
                $instance = $this->resolver($concrete);
            }

            if (isset($this->singletons[$abstract])) {
                $this->instances[$abstract] = $instance;
            }

            return $instance;
        } finally {
            array_pop($this->resolving);
        }
    }

    /**
     * @throws ReflectionException
     */
    private function resolver(callable|string $class): object
    {
        $reflection = new ReflectionClass($class);

        if ($reflection->isInterface()) {
            throw new RuntimeException("Class {$class} must implement interface {$class}");
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            /* Esse método verifica se o tipo é um tipo primitivo do PHP, ou seja, um tipo básico que não é uma classe ou interface.*/
            if (is_null($type) || $type->isBuiltin()) {
                throw new RuntimeException('Cannot resolve dependency ' . $type->getName());
            }
            $dependencies[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}