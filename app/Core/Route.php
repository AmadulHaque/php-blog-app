<?php

namespace App\Core;

class Route
{
    protected $method;
    protected $uri;
    protected $action;

    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    /**
     * Check if the route matches the incoming request.
     *
     * @param Request $request
     * @return bool
     */
    public function matches($request)
    {
        return $this->method === $request->getMethod() &&
               $this->uri === $request->getPathInfo();
    }

    /**
     * Get the action associated with the route.
     *
     * @return \Closure|string
     */
    public function getAction()
    {
        return $this->action;
    }
}
