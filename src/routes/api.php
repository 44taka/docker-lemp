<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TodoController;

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

// サンプル
Route::controller(TodoController::class)->group(function () {
    Route::get('/todos', 'index');
    Route::get('/todos/{id}', 'show');
    Route::post('/todos', 'create');
    Route::put('/todos/{id}', 'update');
    Route::delete('/todos/{id}', 'delete');
});
