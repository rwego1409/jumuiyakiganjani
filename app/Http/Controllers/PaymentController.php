<?php

namespace App\Http\Controllers;

use App\Services\PalmPesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class PaymentController extends Controller
{
    protected $palmPesa;

    public function __construct(PalmPesaService $palmPesa)
    {
        $this->palmPesa = $palmPesa;
    }

    public function initiatePayment(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'regex:/^(0\d{9}|255\d{9})$/'],
            'amount' => ['required', 'numeric', 'min:1000', 'max:3000000'],
        ]);

        $reference = 'PALMPESA-' . Str::uuid();

        $response = $this->palmPesa->processPayment(
            $validated['phone'],
            $validated['amount'],
            $reference
        );

        if (isset($response['error'])) {
            return response()->json([
                'success' => false,
                'message' => $this->getStkErrorMessage($response),
                'data' => [
                    'reference' => $reference,
                    'status' => 'failed'
                ]
            ], 400);
        }

        // Special handling for STK push pending state
        if ($response['status'] === 'pending') {
            return response()->json([
                'success' => true,
                'pending' => true,
                'message' => $this->getStkPendingMessage($validated['phone']),
                'data' => [
                    'reference' => $reference,
                    'phone' => $validated['phone'],
                    'amount' => $validated['amount'],
                    'status' => 'pending'
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'data' => [
                'reference' => $reference,
                'status' => 'completed'
            ]
        ]);
    }

    public function mobilePayment(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:10',
            'transaction_id' => 'nullable|string',
            'address' => 'nullable|string',
            'postcode' => 'nullable|string',
            'buyer_uuid' => 'nullable|integer'
        ]);

        $result = $this->palmpesa->processMobilePayment($validated);

        if ($result['status'] === 'success') {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }

    public function showForm()
    {
        return view('payment.form', [
            'submitUrl' => config('services.clickpesa.callback_url')
        ]);
    }

    public function handleCallback(Request $request)
    {
        // Signature verification is now handled by middleware
        $order = Order::where('reference', $request->reference)->first();
        if ($order) {
            $order->update(['status' => $request->status]);
        }
        return response()->json(['success' => true]);
    }

    protected function getStkPendingMessage($phone)
    {
        return "We've sent an STK push request to 0" . substr($phone, 3) . ". " .
            "Please check your phone and enter your PIN to complete the payment. " .
            "If you don't receive the prompt within 2 minutes, please try again.";
    }

    protected function getStkErrorMessage($response)
    {
        $error = $response['error'];

        if (str_contains($error, 'STK push failed')) {
            return 'Could not send payment request to your phone. Please ensure: ' .
                '1. Your number is registered with PalmPesa ' .
                '2. You have mobile money enabled ' .
                '3. Your phone is connected to the internet';
        }

        return $error;
    }

    public function paymentCallback(Request $request)
    {
        $payload = $request->all();

        Log::info('Payment callback received', ['payload' => $payload]);

        // Validate callback
        if (!isset($payload['reference']) || !isset($payload['status'])) {
            Log::error('Invalid callback payload', ['payload' => $payload]);
            return response()->json(['error' => 'Invalid callback'], 400);
        }

        // Process based on status
        switch ($payload['status']) {
            case 'completed':
                // Update database
                Log::info('Payment completed', ['reference' => $payload['reference']]);
                return response()->json(['status' => 'success']);

            case 'failed':
                Log::error('Payment failed', ['reference' => $payload['reference']]);
                return response()->json(['status' => 'failed']);

            default:
                Log::info('Payment pending', ['reference' => $payload['reference']]);
                return response()->json(['status' => 'pending']);
        }
    }

    protected function getErrorMessage(array $response): string
    {
        $error = $response['error'];

        if (str_contains($error, '401')) {
            return 'Authentication failed. Please check API configuration.';
        }

        if (str_contains($error, '404')) {
            return 'Payment service unavailable. Please try again later.';
        }

        return $response['details']['message'] ?? 'Payment processing failed';
    }

    protected function getErrorStatusCode(array $response): int
    {
        $error = $response['error'];

        if (str_contains($error, '401')) return 401;
        if (str_contains($error, '404')) return 503;

        return 400;
    }
}