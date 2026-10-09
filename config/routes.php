<?php

namespace Config;

class Routes
{
    public static function getRoutes()
    {
        return [
            '/' => ['controller' => 'home', 'action' => 'index'],
            '/home/index' => ['controller' => 'home', 'action' => 'index'],
            '/products' => ['controller' => 'products', 'action' => 'index'],
            '/{controller}/{id:\d+}/{action}' => [],
            '/{controller}/{slug:[\w-]+}' => ['controller' => 'products', 'action' => 'show'],
            '/{controller}/{action}' => [],
        ];
    }
}
