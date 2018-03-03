<?php

use App\Library\Router;

// require the composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// require bootstrap.php which only defines some constants
require_once dirname(__DIR__) . '/app/bootstrap.php';

Router::init();

Router::add('/', [\App\Controller\IndexController::class, 'index']);
Router::add('/posts', [\App\Controller\PostsController::class, 'index']);
Router::add('/posts/(.*)', [\App\Controller\PostsController::class, 'single']);

Router::add404(function () {
    echo 'Page not Found';
});

Router::run();
exit;
