<?php

namespace App\Library;

class Router {

    public static $routes = [];
    public static $callback404;
    public static $path;

    public static function init() {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);//Parse Uri
        if (isset($parsedUrl['path'])) {
            self::$path = $parsedUrl['path'];
        } else {
            self::$path = '/';
        }
    }

    public static function add($expression, $function) {
        array_push(self::$routes, [
            'expression' => $expression,
            'function' => $function
        ]);
    }

    public static function add404($function) {
        self::$callback404 = $function;
    }

    public static function run() {
        $routeFound = false;

        foreach (self::$routes as $route) {
            //Add 'find string start' automatically
            $route['expression'] = '^' . $route['expression'];
            //Add 'find string end' automatically
            $route['expression'] = $route['expression'] . '$';
            //check match
            if (preg_match('#' . $route['expression'] . '#', self::$path, $matches)) {
                //Always remove first element. This contains the whole string
                array_shift($matches);
                if (is_array($route['function'])) {
                    $controller = new $route['function'][0]();
                    call_user_func_array([$controller, $route['function'][1]], $matches);
                } else {
                    call_user_func_array($route['function'], $matches);
                }
                $routeFound = true;
                break;
            }
        }
        if (!$routeFound && self::$callback404) {
            call_user_func_array(self::$callback404, [self::$path]);
        }
    }
}
