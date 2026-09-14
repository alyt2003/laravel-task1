<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/api-endpoints', [DashboardController::class, 'apiEndpoints'])->name('dashboard.endpoints');

// Admin dashboard CRUD (Blade web UI). Separate from routes/api.php and its
// controllers, which are untouched and keep serving the JSON API.
Route::prefix('dashboard')->group(function () {
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
});
