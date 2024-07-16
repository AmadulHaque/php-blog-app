<?php

namespace App\Core;

use Illuminate\Http\Request as IlluminateRequest;

class Router
{
    protected array $routes = [];
    protected $dispatcher;
    protected $container;

    public function __construct($dispatcher, $container)
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    /**
     * Define a GET route.
     *
     * @param string $uri
     * @param \Closure|string $action
     */
    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Define a POST route.
     *
     * @param string $uri
     * @param \Closure|string $action
     */
    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Add a route to the collection.
     *
     * @param string $method
     * @param string $uri
     * @param \Closure|string $action
     */
    protected function addRoute($method, $uri, $action)
    {
        $this->routes[] = new Route($method, $uri, $action);
    }

    /**
     * Dispatch the router to find and execute the route.
     *
     * @return mixed
     */
    public function dispatch()
    {
        $request = $this->container->get('request'); // Retrieve the custom Request from the container

        $route = $this->findRoute($request);

        if (!$route) {
            // Handle 404
            return $this->notFound();
        }

        return $this->callAction($route, $request);
    }

    /**
     * Find a matching route for the request.
     *
     * @param Illuminate\Http\Request $request
     * @return Route|null
     */
    protected function findRoute(IlluminateRequest $request)
    {
        foreach ($this->routes as $route) {
            if ($route->matches($request)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Call the action associated with the route.
     *
     * @param Route $route
     * @param Illuminate\Http\Request $request
     * @return mixed
     */
    // protected function callAction($route, IlluminateRequest $request)
    // {
    //     $action = $route->getAction();

    //     if ($action instanceof \Closure) {
    //         // Execute closure and return its response
    //         return $action($request);
    //     } elseif (is_string($action) && strpos($action, '@') !== false) {
    //         // Handle controller action format "Controller@method"
    //         $segments = explode('@', $action);

    //         if (count($segments) !== 2) {
    //             throw new \InvalidArgumentException("Invalid action format: {$action}. Must be in 'Controller@method' format.");
    //         }

    //         $controllerName = $segments[0];
    //         $methodName = $segments[1];

    //         if (!class_exists($controllerName)) {
    //             throw new \InvalidArgumentException("Controller class '{$controllerName}' does not exist.");
    //         }

    //         $controller = new $controllerName();

    //         if (!method_exists($controller, $methodName)) {
    //             throw new \InvalidArgumentException("Method '{$methodName}' does not exist on controller '{$controllerName}'.");
    //         }

    //         return call_user_func([$controller, $methodName], $request);
    //     } else {
    //         // throw new \InvalidArgumentException("Unsupported action type provided.");
    //     }
    // }

    protected function callAction($route, IlluminateRequest $request)
    {
        $action = $route->getAction();

        if (is_array($action) && count($action) === 2) {
            $controllerName = $action[0];
            $methodName = $action[1];

            if (!class_exists($controllerName)) {
                throw new \InvalidArgumentException("Controller class '{$controllerName}' does not exist.");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                throw new \InvalidArgumentException("Method '{$methodName}' does not exist on controller '{$controllerName}'.");
            }

            return call_user_func([$controller, $methodName], $request);
        } elseif ($action instanceof \Closure) {
            // Execute closure and return its response
            return $action($request);
        } elseif (is_string($action) && strpos($action, '@') !== false) {
            // Handle controller action format "Controller@method"
            $segments = explode('@', $action);

            if (count($segments) !== 2) {
                throw new \InvalidArgumentException("Invalid action format: {$action}. Must be in 'Controller@method' format.");
            }

            $controllerName = $segments[0];
            $methodName = $segments[1];

            if (!class_exists($controllerName)) {
                throw new \InvalidArgumentException("Controller class '{$controllerName}' does not exist.");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                throw new \InvalidArgumentException("Method '{$methodName}' does not exist on controller '{$controllerName}'.");
            }

            return call_user_func([$controller, $methodName], $request);
        } else {
            throw new \InvalidArgumentException("Unsupported action type provided.");
        }
    }

    /**
     * Handle 404 Not Found.
     *
     * @return string
     */
    protected function notFound()
    {
        return "404 - Not Found";
    }
}
