<?php

namespace App\Library;

use Symfony\Component\HttpFoundation\Request;

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
    protected $routes = [];

    /**
     * Contains the 404 callback
     *
     * @var callable
     */
    protected $callback404;

    /**
     * Contains the requested path
     *
     * @var Request
     */
    protected $request;

    /**
     * Router constructor.
     * @param Request $path
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Adds a route to the router
     *
     * @param $expression string
     * @param string $class
     * @param string $method
     */
    public function add(string $expression, string $class, string $method)
    {
        array_push($this->routes, [
            'expression' => $expression,
            'class' => $class,
            'method' => $method,
        ]);
    }

    /**
     * Adds the 404 callback to the router
     *
     * @param $function callable
     */
    public function add404($function)
    {
        $this->callback404 = $function;
    }

    /**
     * Run the router by iterating over all added routes. If it finds a match
     * the callback or Class Method will be called, If no route is hit, a
     * registered 404 callback will be called
     */
    public function run()
    {
        $routeFound = false;

        foreach ($this->routes as $route) {
            //thx to https://github.com/bramus/router/blob/master/src/Bramus/Router/Router.php#L342
            $route['expression'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['expression']);
            //check match
            if (preg_match('#^' . $route['expression'] . '$#', $this->request->getPathInfo(), $matches)) {
                //Always remove first element. This contains the whole string
                array_shift($matches);
                // instantiate the controller
                $controller = new $route['class']();
                // execute the given method on the controller
                call_user_func_array([$controller, $route['method']], $matches);

                $routeFound = true;
                break;
            }
        }
        // If no route is found and a 404 callback is registered. call it.
        if (!$routeFound && $this->callback404) {
            call_user_func_array($this->callback404, [$this->path]);
        }
    }
}
