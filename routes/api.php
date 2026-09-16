<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/posts', [PostController::class, 'getAllPosts']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'editPost']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'createPost']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'deletePost']);

// One-to-One: User hasOne Profile / Profile belongsTo User.
Route::middleware('auth:sanctum')->post('/profile', [ProfileController::class, 'store']);
Route::get('/users/{user}/profile', [ProfileController::class, 'show']);

// Courses (the "many" side of the User <-> Course many-to-many below).
Route::get('/courses', [CourseController::class, 'index']);
Route::middleware('auth:sanctum')->post('/courses', [CourseController::class, 'store']);

// Many-to-Many: User belongsToMany Course / Course belongsToMany User,
// via the "course_user" pivot table.
Route::middleware('auth:sanctum')->post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll']);
Route::get('/users/{user}/courses', [EnrollmentController::class, 'index']);
Route::middleware('auth:sanctum')->delete('/courses/{course}/enroll', [EnrollmentController::class, 'destroy']);
