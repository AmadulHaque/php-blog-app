<?php


define('APP_START', microtime(true));

require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

use Illuminate\Http\Request;

session_start();

$request = Request::capture();
$router = $container->make('router');

$response = $router->dispatch($request);

$response->send();