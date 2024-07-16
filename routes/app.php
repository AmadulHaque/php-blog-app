<?php

use App\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']); 
Route::get('/admin', [HomeController::class, 'admin']);