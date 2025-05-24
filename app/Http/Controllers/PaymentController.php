<?php

namespace App\Http\Controllers;

use App\Services\PalmPesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
            'member_id' => ['required', 'exists:members,id'],
        ]);

        $reference = 'PALMPESA-' . Str::uuid()->toString();

        Log::info('Initiating payment', [
            'phone' => $validated['phone'],
            'amount' => $validated['amount'],
            'reference' => $reference,
            'member_id' => $validated['member_id']
        ]);

        $response = $this->palmPesa->processPayment(
            $validated['phone'],
            $validated['amount'],
            $reference
        );

        if (isset($response['error'])) {
            Log::error('Payment failed', ['error' => $response['error'], 'details' => $response['details'] ?? null]);
            
            return response()->json([
                'success' => false,
                'message' => $this->getErrorMessage($response),
                'data' => $response['details'] ?? null
            ], $this->getErrorStatusCode($response));
        }

        Log::info('Payment processed', ['response' => $response]);

        if ($response['status'] === 'pending') {
            return response()->json([
                'success' => true,
                'pending' => true,
                'message' => 'Please check your phone to complete payment',
                'data' => [
                    'reference' => $reference,
                    'phone' => $validated['phone'],
                    'amount' => $validated['amount']
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'data' => [
                'reference' => $reference,
                'phone' => $validated['phone'],
                'amount' => $validated['amount'],
                'status' => 'completed'
            ]
        ]);
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