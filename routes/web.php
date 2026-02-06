<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\QuotaController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [DashboardController::class, 'changePassword'])->name('password.change');
        
        // Packages
        Route::get('/packages', [PackageController::class, 'index'])->name('packages');
        Route::get('/packages/{package}/payment', [PackageController::class, 'showPayment'])->name('packages.payment');
        Route::post('/packages/{package}/payment', [PackageController::class, 'storePayment']);
        Route::get('/packages/history', [PackageController::class, 'history'])->name('packages.history');
        
        // Quota
        Route::get('/quota', [QuotaController::class, 'index'])->name('quota');
        Route::post('/quota/confirm', [QuotaController::class, 'confirmUsage'])->name('quota.confirm');
        Route::get('/quota/history', [QuotaController::class, 'history'])->name('quota.history');
        
        // Coupons
        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons');
    });
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::post('/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
        Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
        Route::get('/draw', [AdminController::class, 'drawWinner'])->name('draw');
    });
});
