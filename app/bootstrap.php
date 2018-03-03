<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . DS . 'app');
define('VIEW_DIR', ROOT_DIR . DS . 'resources' . DS . 'views');

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(ROOT_DIR . DS .'.env');
