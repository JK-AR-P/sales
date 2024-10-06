<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/auth', 'auth')->name('auth');
    Route::get('/logout', 'logout')->name('logout');
});

// Admin Dashboard Routes
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'admin')->name('dashboard');
    });

    // CRUD User Marketing
    Route::get('/marketing/data', [UserController::class, 'data'])->name('marketing.data');
    Route::resource('marketing', UserController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
});

// User Dashboard Routes
Route::middleware(['auth', 'role:user|superadmin'])->prefix('user')->name('user.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'user')->name('dashboard');
    });
});
