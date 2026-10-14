<?php
// enforce strict types
declare(strict_types=1);

namespace Framework;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;

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
            $type = (object) $parameter->getType();

            if ($type === null || $type->isBuiltin() || !$type instanceof ReflectionNamedType) {
                throw new InvalidArgumentException('Unable to resolve dependency for parameter: ' . $parameter->getName());
            }

            $dependencies[] = $this->get($type->getName());
        }

        return new $class(...$dependencies);
    }
}