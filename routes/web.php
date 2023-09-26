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

// Admin Panel
Route::get('/admin', [\App\Http\Controllers\Admin\Index::class, 'render']);
Route::post('/admin/login', [\App\Http\Controllers\Admin\Login::class, 'action']);
Route::post('/admin/logout', [\App\Http\Controllers\Admin\Logout::class, 'action']);

// Microservices Proxy Router
Route::any('/api/{any}', [\App\Http\Controllers\Proxy::class, 'index'])->where('any', '.*');

// Common Router
Route::view('{any}', 'errors/404', [], 404)->where('any', '.*');

