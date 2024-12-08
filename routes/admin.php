<?php

use App\Http\Controllers\Admin\AddonServiceController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AdminNewPasswordController;
use App\Http\Controllers\Admin\AdminPasswordController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryScaleController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ExpenseTypeController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderInvoiceController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceItemController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\TimeslotController;
use App\Http\Controllers\Admin\UserController;
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

    Route::resource('banners', BannerController::class);
    Route::resource('delivery-scales', DeliveryScaleController::class);

//    Route::resource('redemptions', PackageController::class);
//    Route::resource('rewards', PackageController::class);
//    Route::resource('points', PackageController::class);
//    Route::resource('audits', PackageController::class);
    Route::resource('stores', StoreController::class);

    Route::resource('customers', CustomerController::class);
    Route::resource('service-types', ServiceTypeController::class);
    Route::resource('service-items', ServiceItemController::class);
    Route::resource('addon-services', AddonServiceController::class);

    Route::resource('coupons', CouponController::class);
    Route::resource('timeslots', TimeslotController::class);
    Route::resource('orders', OrderController::class);
    Route::get('orders-status', [OrderStatusController::class, 'index'])->name('orders-status.index');
    Route::get('orders/{order}/invoice', [OrderInvoiceController::class, 'index'])->name('orders.invoice');
    Route::put('orders-status/{order}', [OrderStatusController::class, 'update'])->name('orders-status.update');

    Route::resource('expenses', ExpenseController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('financial-years', FinancialYearController::class);
    Route::resource('users', UserController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.application');
    Route::get('settings-finance', [SettingController::class, 'finance'])->name('settings.finance');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.submit');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('orders', [ReportController::class, 'orders'])->name('orders');
        Route::get('customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('inventory', [ReportController::class, 'inventory'])->name('inventory');
        Route::get('expenses', [ReportController::class, 'expenses'])->name('expenses');
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('profits', [ReportController::class, 'profits'])->name('profits');
        Route::get('audit-logs', [ReportController::class, 'auditLogs'])->name('audit-logs');
    });

});
