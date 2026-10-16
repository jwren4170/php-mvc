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

$dotenv = new Framework\Dotenv;
$dotenv->load(dirname(__DIR__) . '/.env');

use Framework\ErrorHandler;

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

use Framework\Dispatcher;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER['REQUEST_URI']}'");
}

$router = require_once dirname(__DIR__) . '/config/routes.php';
$container = require_once dirname(__DIR__) . '/config/services.php';

$dispatcher = new Dispatcher($router, $container);
$dispatcher->handleRequest($path);
