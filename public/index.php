<?php

define('APP_START', microtime(true));



require_once '../vendor/autoload.php';
require_once '../app/Core/Router.php';

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

session_start();

$container = new Container();
$dispatcher = new Dispatcher($container);
$request = Request::capture();

$router = new App\Core\Router($dispatcher, $container);

require_once '../routes/app.php';

$response = $router->dispatch($request);

$response->send();
?>