<?php

use Config\Routes;
use Framework\Container;
use Framework\Dispatcher;
use Framework\Router;

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

$container = new Container();

$container->set(App\Database::class, function () {
    return new App\Database((parse_ini_file(__DIR__ . '/.env', true, INI_SCANNER_RAW)));
});

$dispatcher = new Dispatcher($router, $container);
$dispatcher->handleRequest($path);