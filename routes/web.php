<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Router
Route::any('/', static fn () => response('Qualification Work API'));

// Microservices Proxy Router
Route::any( '{any}', [\App\Http\Controllers\Proxy::class, 'index'])->where('any', '.*');
