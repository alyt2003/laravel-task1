<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/api-endpoints', [DashboardController::class, 'apiEndpoints'])->name('dashboard.endpoints');
