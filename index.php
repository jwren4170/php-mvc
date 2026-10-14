<?php
// enforce strict types
declare(strict_types=1);

set_exception_handler(function (Throwable $e): void {
    $envFilePath = __DIR__ . '/.env';
    $config = file_exists($envFilePath) ? parse_ini_file($envFilePath, false, INI_SCANNER_RAW) : [];
    $showErrors = isset($config['SHOW_ERRORS']) && filter_var($config['SHOW_ERRORS'], FILTER_VALIDATE_BOOLEAN);

    if ($showErrors === true) {
        echo '<h1>An Error Occurred</h1>';
        echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ' on line ' . $e->getLine() . '</p>';

        throw new RuntimeException('Unable to parse the .env configuration file.');
    } else {
        http_response_code(500);

        require_once __DIR__ . '/views/500.php';
    }

    var_dump($showErrors);
});

use Config\Routes;
use Framework\Container;
use Framework\Dispatcher;
use Framework\Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException('Failed to parse the request URI: ' . $_SERVER['REQUEST_URI']);
}

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
    return new App\Database(parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW));
});

$dispatcher = new Dispatcher($router, $container);
$dispatcher->handleRequest($path);
