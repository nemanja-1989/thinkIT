<?php

use App\Http\Controllers\AuthorsApiController;
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
    Route::get('/authors', [AuthorsApiController::class, 'index']);
    Route::get('/authors/{author}/show', [AuthorsApiController::class, 'show']);
    Route::post('/authors/store', [AuthorsApiController::class, 'store']);
    Route::patch('/authors/{author}/update', [AuthorsApiController::class, 'update']);
    Route::delete('/authors/{author}/delete', [AuthorsApiController::class, 'destroy']);
});
