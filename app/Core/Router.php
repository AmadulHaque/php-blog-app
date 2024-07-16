<?php

namespace App\Core;

use Illuminate\Routing\Router as IlluminateRouter;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Router extends IlluminateRouter
{
    public function __construct($dispatcher, $container)
    {
        parent::__construct($dispatcher, $container);
    }

    public function dispatch(Request $request)
    {
        try {
            return parent::dispatch($request);
        } catch (HttpException $e) {
            // Handle HTTP exceptions here
            return response($e->getMessage(), $e->getStatusCode());
        } catch (\Exception $e) {
            // Handle other exceptions (optional)
            return response('Internal Server Error', 500);
        }
    }
}
