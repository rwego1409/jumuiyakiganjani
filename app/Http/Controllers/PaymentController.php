<?php

namespace App\Http\Controllers;

use App\Services\ZenoPayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected ZenoPayService $zenoPay
    ) {}

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'buyer_email' => 'required|email',
            'buyer_name' => 'required|string|max:255',
            // Accept only 07XXXXXXXX (ZenoPay format)
            'buyer_phone' => ['required', 'string', 'regex:/^07\d{8}$/'],
            'amount' => 'required|numeric|min:1',
            'webhook_url' => 'nullable|url'
        ]);

        return $this->zenoPay->initiatePayment($validated);
    }

    public function checkStatus(Request $request)
    {
        $request->validate(['order_id' => 'required|uuid']);
        return $this->zenoPay->checkOrderStatus($request->order_id);
    }

    public function handleWebhook(Request $request)
    {
        // Verify API key in production
        if (!app()->environment('local') && 
            $request->header('x-api-key') !== config('services.zenopay.api_key')) {
            abort(403);
        }

        $validated = $request->validate([
            'order_id' => 'required|uuid',
            'payment_status' => 'required|in:PENDING,COMPLETED,FAILED,CANCELLED',
            'reference' => 'required|string'
        ]);

        // Process payment status update
        \App\Jobs\ProcessZenoPayment::dispatch($validated);

        return response()->json(['status' => 'received']);
    }
}