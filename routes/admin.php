<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\TimeslotController;
use App\Http\Controllers\Auth\AdminNewPasswordController;
use App\Http\Controllers\Auth\AdminPasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('login', [AdminAuthController::class, 'store']);
    Route::get('forgot-password', [AdminForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [AdminForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [AdminNewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);
    Route::put('password', [AdminPasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('stores', StoreController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('service-types', ServiceTypeController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('timeslots', TimeslotController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('financial-years', FinancialYearController::class);
});
