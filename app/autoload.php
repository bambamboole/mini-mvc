<?php

spl_autoload_register(function ($className) {
    if (substr($className, 0, 4) !== 'App\\') {
        return;
    }
    $fileName = APP_DIR . DS . str_replace('\\', DS, substr($className, 4)) . '.php';

    if (file_exists($fileName)) {
        require_once $fileName;
    }
});
