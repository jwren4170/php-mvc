<?php

use Framework\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function (string $class) {
    $classPath = str_replace('\\', '/', $class);
    $file =  './src/' . $classPath . '.php';

    if (is_file($file)) {
        require $file;
    }
});

$router = new Router();

$router->addRoute('/{controller}/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->addRoute('/{controller}/{id:\d+}/{action}');
$router->addRoute('/home/index', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/products', ['controller' => 'products', 'action' => 'index']);
$router->addRoute('/', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/{controller}/{action}');

$params = $router->matchRoute($path);

if ($params === false) {
    exit("No route found for the requested path: $path");
}

$action = $params['action'];
$controller = 'App\\Controllers\\' . ucwords($params['controller']);

$controller_object = new  $controller();

$controller_object->$action();

$dispatcher = new Framework\Dispatcher($router);
