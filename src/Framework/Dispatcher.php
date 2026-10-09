<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
    public function __construct(
        private Router $router
    ) {}

    public function handleRequest(string $path)
    {
        $params = $this->router->matchRoute($path);

        if ($params === false) {
            exit('No route matched');
        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $args = $this->getActionArgs($controller, $action, $params);

        $controller_object = new $controller;
        $controller_object->$action(...array_values($args));
    }

    private function getActionArgs(string $controller, string $action, array $params): array
    {
        $args = [];

        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            $args[$name] = $params[$name] ?? null;
        }

        return $args;
    }

    private function getControllerName(array $params): string
    {
        $controller = $params['controller'];
        $controller = str_replace('-', '', ucwords(strtolower($controller), '-'));

        $namespace = 'App\Controllers';

        if (array_key_exists('namespace', $params)) {
            $namespace .= '\\' . $params['namespace'];
        }

        return $namespace . '\\' . $controller;
    }

    private function getActionName(array $params): string
    {
        $action = $params['action'];
        $action = lcfirst(str_replace('-', '', ucwords(strtolower($action), '-')));

        return $action;
    }
}
