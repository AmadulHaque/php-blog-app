<?php

use App\Controllers\HomeController;

use App\Facades\Route;


Route::get('/', [HomeController::class, 'index']); 
Route::get('/admin', [HomeController::class, 'admin']);