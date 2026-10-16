<?php

use Framework\Container;

$container = new Container();

$container->set(App\Database::class, function () {
    return new App\Database($_ENV);
});

return $container;
