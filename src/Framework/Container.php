<?php

namespace Framework;

use ReflectionClass;

class Container
{
    public function get(string $class): object
    {
        $reflector = new ReflectionClass($class);

        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor === null) {
            return new $class;
        }

        foreach ($constructor->getParameters() as $parameter) {
            $type = (string) $parameter->getType();

            $dependencies[] = $this->get($type);
        }

        return new $class(...$dependencies);
    }
}