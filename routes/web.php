<?php

use App\Http\Controllers\AddonServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryScaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FinancialYearController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderInvoiceController;
use App\Http\Controllers\OrderLabelController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\ServiceItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('welcome');
Route::get('/service', [PageController::class, 'services'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('banners', BannerController::class);
    Route::resource('delivery-scales', DeliveryScaleController::class);

    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('stores', StoreController::class);

    Route::resource('customers', CustomerController::class);
    Route::resource('order-labels', OrderLabelController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('service-items', ServiceItemController::class);
    Route::resource('service-details', ServiceDetailController::class);
    Route::resource('addon-services', AddonServiceController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('timeslots', TimeslotController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('payments', PaymentController::class);

    Route::resource('orders', OrderController::class);
    Route::get('orders/{order}/invoice', [OrderInvoiceController::class, 'index'])->name('orders.invoice');

    Route::get('orders-status', [OrderStatusController::class, 'index'])->name('orders-status.index');
    Route::put('orders-status/{order}', [OrderStatusController::class, 'update'])->name('orders-status.update');

    Route::resource('expenses', ExpenseController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('financial-years', FinancialYearController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('points', UserController::class);
    Route::resource('rewards', UserController::class);
    Route::resource('redemptions', UserController::class);


    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/general', [SettingController::class, 'storeGeneral'])->name('settings.store.general');
    Route::post('/settings/business', [SettingController::class, 'storeBusiness'])->name('settings.store.business');
    Route::post('/settings/finance', [SettingController::class, 'storeFinance'])->name('settings.store.finance');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
    });
});
