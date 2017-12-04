<?php

use App\Library\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', __DIR__ . DS . '..');
define('APP_DIR', ROOT_DIR . DS . 'app');
define('VIEW_DIR', ROOT_DIR . DS . 'resources' . DS . 'views');

require_once APP_DIR . DS . 'autoload.php';

Router::init();

Router::add('/', [\App\Controller\IndexController::class, 'index']);
Router::add('/foo', [\App\Controller\FooController::class, 'indexAction']);
Router::add('/foo', [\App\Controller\FooController::class, 'indexAction']);

Router::add('/test.html', function () {
    //Do something
    echo 'Hello from test.html';
});

Router::add404(function ($url) {
    $view = new \App\Library\View();
    $view->render('404', [], false, false, false);
});

Router::run();
