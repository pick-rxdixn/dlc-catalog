<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('catalog');
});

Route::get('/dlcs/{id}', function ($id) {
    return view('dlc', ['id' => $id]);
})->whereNumber('id');

Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::get('/register', function () {
        return view('register');
    })->name('register');

});

Route::get('/library', function () {
    return view('library');
})->middleware('auth')->name('library');

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

        Route::post('/dlcs/{id}/claim', [LibraryController::class, 'claim'])
            ->whereNumber('id');

        Route::get('/library', [LibraryController::class, 'index']);
    });

});