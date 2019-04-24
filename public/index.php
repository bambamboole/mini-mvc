<?php

use App\Library\Router;

// require the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// require bootstrap.php which only defines some constants
require_once dirname(__DIR__) . '/app/bootstrap.php';

$router = new Router();

$router->add('/', [\App\Controller\IndexController::class, 'index']);
$router->add('/posts', [\App\Controller\PostsController::class, 'index']);
$router->add('/posts/{id}', [\App\Controller\PostsController::class, 'single']);

$router->add404(function () {
    echo 'Page not Found';
});

$router->run();
exit;
