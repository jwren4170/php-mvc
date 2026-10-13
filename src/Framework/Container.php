<?php

namespace Framework;

use Closure;
use ReflectionClass;

class Container
{
    private array $registry = [];

    public function set(string $name, Closure $value): void
    {
        $this->registry[$name] = $value;
    }

    public function get(string $class): object
    {
        if (array_key_exists($class, $this->registry)) {
            return $this->registry[$class]();
        }

        $reflector = new ReflectionClass($class);

        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor === null) {
            return new $class;
        }

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->get($type->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new \LogicException('Unable to resolve dependency for parameter: ' . $parameter->getName());
            }
        }

        return new $class(...$dependencies);
    }
}