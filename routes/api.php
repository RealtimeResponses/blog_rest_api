<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/hello', function() {
    return 'Hello world!';
});

// Public routes of authtication
Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

// Public routes of product
Route::controller(PostController::class)->group(function() {
    Route::get('/posts', 'index');
    Route::get('/posts/{id}', 'show');
    Route::get('/posts/search/{name}', 'search');
});

// Protected routes of product and logout
Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(PostController::class)->group(function() {
        Route::post('/posts', 'store');
        Route::post('/posts/{id}', 'update');
        Route::delete('/posts/{id}', 'destroy');
    });
});
