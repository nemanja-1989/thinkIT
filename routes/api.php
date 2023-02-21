<?php

use App\Http\Controllers\AuthorsApiController;
use App\Http\Controllers\BooksApiController;
use App\Http\Controllers\UsersApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('authors', AuthorsApiController::class);
    Route::apiResource('books', BooksApiController::class);
    Route::apiResource('users', UsersApiController::class);
});
