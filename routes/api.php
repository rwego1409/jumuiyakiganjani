<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MpesaCallbackController;
use App\Http\Controllers\MpesaController;

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
// routes/api.php
Route::post('/pay', [PaymentController::class, 'pay']);

// ZenoPay Payment Endpoints
Route::prefix('payments')->group(function () {
    // ZenoPay API Integration: Initiate payment (matches ZenoPay docs)
    Route::post('mobile_money_tanzania', [PaymentController::class, 'initiate']);
    // Check order status (matches ZenoPay docs)
    Route::get('order-status', [PaymentController::class, 'checkStatus']);
    // Webhook for ZenoPay
    Route::post('webhook/zenopay', [PaymentController::class, 'handleWebhook']);
});