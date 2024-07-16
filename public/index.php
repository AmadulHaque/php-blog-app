<?php


define('APP_START', microtime(true));

require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

use Illuminate\Http\Request;

session_start();

$request = Request::capture();
$router = $container->make('router');

try {
    $response = $router->dispatch($request);
    $response->send();
} catch (HttpException $e) {
    // Handle HTTP exceptions
    http_response_code($e->getStatusCode());
    echo $e->getMessage();
} catch (\Exception $e) {
    http_response_code(404);
    abrot(404);
}