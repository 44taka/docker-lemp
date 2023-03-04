<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [TestController::class, 'index']);

// Todo
Route::controller(TodoController::class)->group(function () {
    Route::get('/todos', 'index');
    Route::get('/todos/{id}', 'show');
    Route::post('/todos', 'create');
    Route::put('/todos/{id}', 'update');
    Route::delete('/todos/{id}', 'delete');
});

// Author
Route::controller(AuthorController::class)->group(function () {
    Route::get('/authors', 'index');
    Route::get('/authors/{id}', 'show');
});


// Book
Route::controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{id}', 'show');
    Route::post('/books', 'create');
    Route::put('/books/{id}', 'update');
    Route::delete('/books/{id}', 'delete');
});
