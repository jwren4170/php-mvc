<?php

use Framework\Router;
use Framework\Dispatcher;
use Config\Routes;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class): void {
    $classPath = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . 'src' . '/' . $classPath . '.php';
    
    if (is_file($file)) {
        require $file;
    }
});

require_once __DIR__ . '/config/routes.php';

$router = new Router();

foreach (Routes::getRoutes() as $route => $params) {
    $router->addRoute($route, $params);
}

$dispatcher = new Dispatcher($router);
$dispatcher->handleRequest($path);