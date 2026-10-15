<?php
// enforce strict types
declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $classPath = str_replace('\\', '/', $class);
    $file = dirname(__DIR__) . '/src/' . $classPath . '.php';

    if (is_file($file)) {
        require $file;
    }
});

use Framework\ErrorHandler;

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

use Config\Routes;
use Framework\Container;
use Framework\Dispatcher;
use Framework\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER['REQUEST_URI']}'");
}

require_once dirname(__DIR__) . '/config/routes.php';

$router = new Router();

foreach (Routes::getRoutes() as $route => $params) {
    $router->addRoute($route, $params);
}

$container = new Container();

$container->set(App\Database::class, function () {
    return new App\Database(parse_ini_file(dirname(__DIR__) . '/.env'));
});

$dispatcher = new Dispatcher($router, $container);
$dispatcher->handleRequest($path);
