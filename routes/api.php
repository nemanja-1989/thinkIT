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
    /**
     * FOR ROUTES WE CAN USE apiResource also, and put middleware into controllers, but for this test i prefer cleaner controllers.
     */

    /**
     * AUTHORS
     */
    Route::get('/authors', [AuthorsApiController::class, 'index']);
    Route::get('/authors/{author}/show', [AuthorsApiController::class, 'show']);
    Route::post('/authors/store', [AuthorsApiController::class, 'store']);
    Route::patch('/authors/{author}/update', [AuthorsApiController::class, 'update']);
    Route::delete('/authors/{author}/delete', [AuthorsApiController::class, 'destroy']);
    /**
     * BOOKS
     */
    Route::get('/books', [BooksApiController::class, 'index']);
    Route::get('/books/{book}/show', [BooksApiController::class, 'show']);
    Route::post('/books/store', [BooksApiController::class, 'store']);
    Route::patch('/books/{book}/update', [BooksApiController::class, 'update']);
    Route::delete('/books/{book}/delete', [BooksApiController::class, 'destroy']);
    /**
     * USERS
     */
    Route::get('/users', [UsersApiController::class, 'index']);
    Route::get('/users/{user}/show', [UsersApiController::class, 'show']);
    Route::post('/users/store', [UsersApiController::class, 'store']);
    Route::patch('/users/{user}/update', [UsersApiController::class, 'update']);
    Route::delete('/users/{user}/delete', [UsersApiController::class, 'destroy']);
});
