<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('customers', App\Http\Controllers\CustomerController::class);
Route::resource('customers.orders', App\Http\Controllers\CustomerOrderController::class)->only('index');
Route::resource('orders', App\Http\Controllers\OrderController::class);

Route::post('/save-api', [App\Http\Controllers\ApiUrlController::class, 'saveApiUrls']);
Route::get('/fetch-api', [App\Http\Controllers\ApiUrlController::class, 'fetchApiUrls']);
Route::get('/fetch-customers', [App\Http\Controllers\ApiUrlController::class, 'fetchCustomers']);
Route::get('/fetch-orders', [App\Http\Controllers\ApiUrlController::class, 'fetchOrders']);


