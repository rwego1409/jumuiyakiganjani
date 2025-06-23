<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MpesaCallbackController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\Api\ZenoPayWebhookController;
use App\Http\Controllers\ClickPesaController;

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
Route::post('/zenopay/webhook', [ZenoPayWebhookController::class, 'handle']);

// ClickPesa USSD-PUSH API endpoint
Route::post('/clickpesa/ussd-push', [ClickPesaController::class, 'initiateUssdPush']);
// ClickPesa Preview USSD-PUSH API endpoint
Route::post('/clickpesa/preview-ussd-push', [ClickPesaController::class, 'previewUssdPush']);
// ClickPesa Query Payment Status by Order Reference
Route::get('/clickpesa/payment-status/{orderReference}', [ClickPesaController::class, 'queryPaymentStatus']);

// Route::post('/mpesa/callback', [App\Http\Controllers\Api\MpesaController::class, 'callback']);
// Route::post('/mpesa/stk-push', [App\Http\Controllers\Api\MpesaController::class, 'stkPush']);
// Route::get('/mpesa/status/{checkoutRequestId}', [MpesaController::class, 'checkStatus']);
// Route::post('/mpesa/payment', [PaymentController::class, 'initiate']);