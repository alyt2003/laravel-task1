
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/posts', [PostController::class, 'getAllPosts']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'editPost']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'createPost']);

Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'deletePost']);
