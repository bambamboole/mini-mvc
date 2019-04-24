<?php

namespace App\Library;

/**
 * Class Router
 * @package App\Library
 */
class Router
{

    /**
     * Contains all registered routes
     *
     * @var array
     */
    public static $routes = [];

    /**
     * Contains the 404 callback
     *
     * @var callable
     */
    public static $callback404;

    /**
     * Contains the requested path
     *
     * @var string
     */
    public static $path;

    /**
     * Initializes the router by parsing and assigning the requested uri
     */
    public static function init()
    {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);//Parse Uri
        if (isset($parsedUrl['path'])) {
            self::$path = $parsedUrl['path'];
        } else {
            self::$path = '/';
        }
    }

    /**
     * Adds a route to the router
     *
     * @param $expression string
     * @param $function callable|array
     */
    public static function add($expression, $function)
    {
        array_push(self::$routes, [
            'expression' => $expression,
            'function' => $function,
        ]);
    }

    /**
     * Adds the 404 callback to the router
     *
     * @param $function callable
     */
    public static function add404($function)
    {
        self::$callback404 = $function;
    }

    /**
     * Run the router by iterating over all added routes. If it finds a match
     * the callback or Class Method will be called, If no route is hit, a
     * registered 404 callback will be called
     */
    public static function run()
    {
        $routeFound = false;

        foreach (self::$routes as $route) {
            /*
             * thx to https://github.com/bramus/router/blob/master/src/Bramus/Router/Router.php#L342
             */
            $route['expression'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['expression']);
            //Add 'find string start' and 'find string end' automatically
            $route['expression'] = '^' . $route['expression'] . '$';
            //check match
            if (preg_match('#' . $route['expression'] . '#', self::$path, $matches)) {
                //Always remove first element. This contains the whole string
                array_shift($matches);
                //check if function is array which is the way to use class method
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
        // If no route is found and a 404 callback is registered. call it.
        if (!$routeFound && self::$callback404) {
            call_user_func_array(self::$callback404, [self::$path]);
        }
    }
}
