<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/customer/production/{customer_code}/pdf', [ProductionController::class, 'printProduction'])->name('production.print');
