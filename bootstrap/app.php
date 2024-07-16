<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Facade;

$container = new Container();

// Set the container instance globally
Container::setInstance($container);

// Register facades
Facade::setFacadeApplication($container);

// Load the configuration file
$config = require __DIR__ . '/../config/app.php';

// Register the dispatcher
$dispatcher = new Dispatcher($container);
$container->instance('events', $dispatcher);

// Register the router
$router = new Router($dispatcher, $container);
$container->instance('router', $router);

// Register service providers
foreach ($config['providers'] as $provider) {
    $instance = new $provider($container);
    $instance->register();
    $instance->boot();
}

// Register aliases
foreach ($config['aliases'] as $alias => $class) {
    class_alias($class, $alias);
}

return $container;
