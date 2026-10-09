<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class): void {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $classPath . '.php';

    if (is_file($file)) {
        require $file;
    }
});

require_once __DIR__ . '/config/routes.php';

$router = new Framework\Router();

$router->addRoute('/{controller}/{id:\d+}/{action}');
$router->addRoute('/home/index', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/products', ['controller' => 'products', 'action' => 'index']);
$router->addRoute('/', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/{controller}/{action}');

foreach (Config\Routes::getRoutes() as $route => $params) {
    $router->addRoute($route, $params);
}

$dispatcher = new Framework\Dispatcher($router);
$dispatcher->handleRequest($path);
