<?php
namespace App\Http\Controllers;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiate(Request $request, PaymentService $paymentService)
    {
        try {
            $validated = $request->validate([
                'phone' => 'required|string|min:9',
                'amount' => 'required|numeric|min:1',
                'reference' => 'sometimes|string|max:255'
            ]);
            
            // Log the request data for debugging
            Log::info('Payment request data:', $validated);
            
            $response = $paymentService->initiateMobilePayment(
                phone: $validated['phone'],
                amount: $validated['amount'],
                reference: $validated['reference'] ?? 'Payment'
            );
            
            // Log the full service response
            Log::info('Payment service response:', $response);
            
            if ($response['success']) {
                return response()->json([
                    'ResponseCode' => '0',
                    'gateway_url' => $response['gateway_url'] ?? null
                ]);
            }
            
            return response()->json([
                'ResponseCode' => '1',
                'ResponseDescription' => $response['error'] ?? 'Payment failed'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment initiation error: ' . $e->getMessage());
            return response()->json([
                'ResponseCode' => '1',
                'ResponseDescription' => 'An error occurred processing your payment'
            ], 500);
        }
    }
    
    public function handleCallback(Request $request, string $provider)
    {
        try {
            Log::info("Callback received from $provider:", $request->all());
            
            // Implement provider-specific callback handling
            // Verify signatures/webhook data
            // Update transaction status
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Callback error from $provider: " . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}