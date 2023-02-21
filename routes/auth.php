<?php

use Illuminate\Support\Facades\Route;

/**
 *  LOGIN | LOGOUT
 */
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);
});
