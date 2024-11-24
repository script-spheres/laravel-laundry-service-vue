<?php

use App\Http\Controllers\Api\FinancialYearController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceTypeController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TimeslotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('stores', StoreController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('service-types', ServiceTypeController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('coupons', CouponController::class);
Route::apiResource('timeslots', TimeslotController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('expenses', ExpenseController::class);
Route::resource('financial-years', FinancialYearController::class);
