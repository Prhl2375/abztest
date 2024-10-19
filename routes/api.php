<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', [\App\Http\Controllers\ResourceController::class, "indexAction"]);
Route::get('/token', [\App\Http\Controllers\TokenController::class, "indexAction"]);
Route::get('/users/{id}', [\App\Http\Controllers\ResourceController::class, "showAction"]);
Route::post('/users', [\App\Http\Controllers\ResourceController::class, "storeAction"])->middleware(\App\Http\Middleware\CustomTokenMiddleware::class);
Route::get('/positions', [\App\Http\Controllers\ResourceController::class, "showPositionsAction"]);
