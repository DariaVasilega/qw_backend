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


// Custom Api Routes
Route::any('/lection/last/statistic', [\App\Http\Controllers\Api\LastLectionStatistic::class, 'get']);

// Microservices Proxy Router
Route::any('{any}', [\App\Http\Controllers\Proxy::class, 'index'])->where('any', '.*');

// TODO 404 error page

