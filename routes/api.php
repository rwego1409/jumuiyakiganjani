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

// Route::post('/mpesa/callback', [App\Http\Controllers\Api\MpesaController::class, 'callback']);
// Route::post('/mpesa/stk-push', [App\Http\Controllers\Api\MpesaController::class, 'stkPush']);
// Route::get('/mpesa/status/{checkoutRequestId}', [MpesaController::class, 'checkStatus']);
// Route::post('/mpesa/payment', [PaymentController::class, 'initiate']);