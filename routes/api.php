<?php

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
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
    /** AUTHORS */
    Route::apiResource('authors', AuthorsApiController::class);
    /** USERS */
    Route::apiResource('users', UsersApiController::class);
    /** BOOKS */
    Route::get('/books', [BooksApiController::class, 'index'])
        ->middleware([
            'role_or_permission:' .
            RoleConstants::LIBRARIAN['name'] . '|' .
            RoleConstants::READER['name'] . '|' .
            PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name']
        ]);
    Route::post('/books', [BooksApiController::class, 'store'])->middleware([
        'role_or_permission:' .
        RoleConstants::LIBRARIAN['name'] . '|' .
        PermissionConstants::BOOK_PRIVILEGES_CREATE['name']
    ]);
    Route::get('/books/{book}', [BooksApiController::class, 'show'])->middleware([
        'role_or_permission:' .
        RoleConstants::LIBRARIAN['name'] . '|' .
        RoleConstants::READER['name'] . '|' .
        PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name']
    ]);
    Route::put('/books/{book}', [BooksApiController::class, 'update'])->middleware([
        'role_or_permission:' .
        RoleConstants::LIBRARIAN['name'] . '|' .
        PermissionConstants::BOOK_PRIVILEGES_EDIT['name']
    ]);
    Route::delete('/books/{book}', [BooksApiController::class, 'destroy'])->middleware([
        'role_or_permission:' .
        RoleConstants::LIBRARIAN['name'] . '|' .
        PermissionConstants::BOOK_PRIVILEGES_DELETE['name']
    ]);
    Route::post('/books/filter', [BooksApiController::class, 'filterBooks'])->middleware([
        'role_or_permission:' .
        RoleConstants::LIBRARIAN['name'] . '|' .
        RoleConstants::READER['name'] . '|' .
        PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name']]);
});
