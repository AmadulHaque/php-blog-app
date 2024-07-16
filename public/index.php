<?php

// index.php or wherever you bootstrap your application
define('APP_START', microtime(true));

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Http\Request;

session_start();

$request = Request::capture();
$router = $container->make('router'); 

$response = $router->dispatch($request);

if ($response instanceof Illuminate\Http\Response) {
    $response->send();
} else {
    echo $response; 
}
