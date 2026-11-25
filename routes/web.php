<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/games', [CatalogController::class, 'games']);
    Route::get('/categories', [CatalogController::class, 'categories']);
    Route::get('/dlcs', [CatalogController::class, 'index']);
    Route::get('/dlcs/{id}', [CatalogController::class, 'show'])
        ->whereNumber('id');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });

});