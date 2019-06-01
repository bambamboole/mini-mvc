<?php

use App\Library\Router;
use App\Controller\IndexController;
use App\Controller\PostsController;
use Symfony\Component\HttpFoundation\Request;

// require the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';
// require bootstrap.php which only defines some constants
require_once dirname(__DIR__) . '/app/bootstrap.php';

$request = Request::createFromGlobals();

$router = new Router($request);

$router->add('/', IndexController::class, 'index');
$router->add('/posts', PostsController::class, 'index');
$router->add('/posts/{id}', PostsController::class, 'single');

$router->add404(function () {
    echo 'Page not Found';
});

$router->run();
exit;
