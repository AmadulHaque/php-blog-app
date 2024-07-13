<?php

namespace App\Core;

use Illuminate\Routing\Router as IlluminateRouter;
use Illuminate\Http\Request;
use Illuminate\Container\Container;

class Router {
    protected $router;
    protected $dispatcher;
    protected $container;

    public function __construct($dispatcher, $container) {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
        $this->router = new IlluminateRouter($dispatcher, $container);
    }

    public  function get($uri, $action, $middlewares = []) {
        $this->router->get($uri, $action)->middleware($middlewares);
    }

    public  function post($uri, $action, $middlewares = []) {
        $this->router->post($uri, $action)->middleware($middlewares);
    }

    public  function dispatch(Request $request) {
        return $this->router->dispatch($request);
    }

    public function aliasMiddleware($name, $class) {
        $this->router->aliasMiddleware($name, $class);
    }
}

