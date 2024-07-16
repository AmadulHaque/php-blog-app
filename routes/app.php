<?php

use App\Controllers\HomeController;

use App\Facades\Router;


Router::get('/', [HomeController::class, 'index']); // implement route name like ->nmae('home')
Router::get('/admin', [HomeController::class, 'admin']);