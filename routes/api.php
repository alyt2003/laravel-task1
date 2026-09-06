
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AdminMiddleware;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'getAllUsers'])->middleware(['auth:sanctum', 'admin']);;
Route::get('/posts', [PostController::class, 'getAllPosts']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'editPost']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'createPost']);

Route::get('/admin-page', function () {
    return "Welcome Admin";
})->middleware([
    'auth:sanctum',
    AdminMiddleware::class
]);
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'deletePost']);
