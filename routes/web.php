<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Traits\HasRoles;

// Index route
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            $role = session('role', 'admin');

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }
    }

    return redirect()->route('login');
});

Route::get('/logout-temp', function () {
    Auth::logout(); // Log out the user
    session()->flush(); // Hapus semua session
    return redirect('/'); // Redirect ke halaman login atau home
});

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

    // CRUD Company Profile
    Route::get('/company/data', [CompanyProfileController::class, 'data'])->name('company.data');
    Route::resource('company', CompanyProfileController::class)->only(['index', 'store', 'destroy']);

    // CRUD Catalog
    Route::get('/catalog/data', [CatalogController::class, 'data'])->name('catalog.data');
    Route::resource('catalog', CatalogController::class)->only(['index', 'store', 'destroy']);;
});

// User Dashboard Routes
Route::middleware(['auth', 'role:user|superadmin'])->prefix('user')->name('user.')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'user')->name('dashboard');
    });
});
