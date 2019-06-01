<?php

use App\Library\Router;
use App\Controller\IndexController;
use App\Controller\PostsController;

// require the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';
// require bootstrap.php which only defines some constants
require_once dirname(__DIR__) . '/app/bootstrap.php';

$router = new Router($_SERVER['REQUEST_URI']);

$router->add('/', IndexController::class, 'index');
$router->add('/posts', PostsController::class, 'index');
$router->add('/posts/{id}', PostsController::class, 'single');

$router->add404(function () {
    echo 'Page not Found';
});

$router->run();
exit;
