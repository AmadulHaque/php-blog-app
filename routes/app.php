<?php

use App\Controllers\HomeController;




$router->get('/', [HomeController::class, 'index']);
$router->get('/admin', [HomeController::class, 'admin']);
