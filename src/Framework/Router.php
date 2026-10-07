<?php

namespace Framework;

class Router
{
    private array $routes = [];

    public function addRoute(string $path, array $params = []): void
    {
        $this->routes[] = ['path' => $path, 'params' => $params];
    }

    public function matchRoute(string $path): array | bool
    {
        $path = urldecode($path);

        $path = trim($path, '/');

        foreach ($this->routes as $route) {

            $pattern = $this->getRoutePattern($route['path']);

            if (preg_match($pattern, $path, $matches)) {
                $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $params = array_merge($matches, $route['params']);

                return $params;
            }
        }

        return false;
    }

    private function getRoutePattern(string $path): string
    {
        $segments = explode('/', trim($path, '/'));

        $segments = array_map(function (string $segment): string {

            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {

                return "(?<" . $matches[1] . ">[^/]*)";
            }

            if (preg_match("#^\{([a-z][a-z0-9]*):(.+)\}$#", $segment, $matches)) {

                return "(?<" . $matches[1] . ">" . $matches[2] . ")";
            }

            return $segment;
        }, $segments);

        return '#^' . implode('/', $segments) . '$#iu';
    }
}
