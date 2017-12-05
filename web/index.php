<?php

use App\Library\Config;
use App\Library\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . DS . 'app');
define('VIEW_DIR', ROOT_DIR . DS . 'resources' . DS . 'views');

require_once APP_DIR . DS . 'autoload.php';

$config = yaml_parse(file_get_contents(ROOT_DIR . DS .'config.yml'));
foreach ($config as $key => $value){
    Config::set($key,$value);
}

Router::init();

Router::add('/', [\App\Controller\IndexController::class, 'index']);
Router::add('/posts', [\App\Controller\PostsController::class, 'index']);

Router::add('/posts/(.*)', [\App\Controller\PostsController::class, 'single']);

Router::add('/test.html', function () {
    //Do something
    echo 'Hello from test.html';
});



Router::add404(function ($url) {
    $view = new \App\Library\View();
    $view->render('404', [], false, false, false);
});

Router::run();
