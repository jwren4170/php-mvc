<?php

namespace Config;

use Framework\Router;

$router = new Router();

$router->addRoute('/', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/home/index', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/home', ['controller' => 'home', 'action' => 'index']);
$router->addRoute('/products', ['controller' => 'products', 'action' => 'index']);
$router->addRoute('/{controller}/{id:\d+}/{action}', []);
$router->addRoute('/{controller}/{action}', []);

return $router;
