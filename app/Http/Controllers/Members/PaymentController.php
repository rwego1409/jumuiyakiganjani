<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Contribution;
use App\Models\Payment;

class ClickPesaController extends Controller
{
    // Step 1: Get OAuth Token
    protected function getClickPesaBaseUrl()
    {
        // Use config/services.php value, fallback to production API
        return config('services.clickpesa.base_url', 'https://api.clickpesa.com');
    }

    protected function getToken()
    {
        try {
            $response = Http::timeout(30)->post($this->getClickPesaBaseUrl() . '/oauth/token', [
                'client_id' => env('CLICKPESA_CLIENT_ID'),
                'client_secret' => env('CLICKPESA_CLIENT_SECRET'),
                'grant_type' => 'client_credentials',
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('ClickPesa Token Error:', $response->json());
            return null;
        } catch (\Exception $e) {
            Log::error('ClickPesa Token Exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }

    // Step 2: Initiate USSD-PUSH Payment (Updated to match frontend expectations)
    public function initiateUssdPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:3000000',
            'orderReference' => 'required|string',
            'phoneNumber' => 'required|string|regex:/^255\\d{9}$/',
            'buyer_email' => 'nullable|email',
            'buyer_name' => 'nullable|string',
        ]);

        // Ensure boolean parsing for mock mode
        $mock = filter_var(env('CLICKPESA_MOCK', false), FILTER_VALIDATE_BOOLEAN);
        if ($mock) {
            Log::info('ClickPesaController: Running in MOCK mode for USSD-PUSH payment.');
            // Return a mock response for frontend testing
            $mockResponse = [
                'reference' => 'MOCK-REF-' . rand(100000, 999999),
                'status' => 'success',
                'message' => 'Mocked payment initiated successfully',
                'amount' => $request->amount,
                'orderReference' => $request->orderReference,
                'phoneNumber' => $request->phoneNumber,
            ];
            $payment = Payment::create([
                'transaction_id' => $request->orderReference,
                'amount' => $request->amount,
                'currency' => 'TZS',
                'phone_number' => $request->phoneNumber,
                'buyer_email' => $request->buyer_email,
                'buyer_name' => $request->buyer_name,
                'status' => 'completed',
                'payment_method' => 'ussd_push',
                'user_id' => auth()->id(),
                'clickpesa_reference' => $mockResponse['reference'],
                'gateway_response' => $mockResponse,
                'completed_at' => now(),
            ]);
            // Mark contribution as paid if exists
            $contribution = \App\Models\Contribution::where('payment_reference', $request->orderReference)->first();
            if ($contribution) {
                $contribution->update([
                    'status' => 'paid'
                ]);
            }
            // TODO: Add cashbook update logic here if/when model is available
            return response()->json([
                'success' => true,
                'message' => 'Payment completed successfully (mocked)',
                'order_id' => $request->orderReference,
                'data' => $mockResponse
            ], 200);
        }

        $token = $this->getToken();
        if (!$token && !$mock) {
            return response()->json([
                'success' => false,
                'error' => 'Could not authenticate with payment service'
            ], 500);
        }

        try {
            $payment = Payment::create([
                'transaction_id' => $request->orderReference,
                'amount' => $request->amount,
                'currency' => 'TZS',
                'phone_number' => $request->phoneNumber,
                'buyer_email' => $request->buyer_email,
                'buyer_name' => $request->buyer_name,
                'status' => 'pending',
                'payment_method' => 'ussd_push',
                'user_id' => auth()->id(),
            ]);

            // The real API call
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('https://api.clickpesa.com/third-parties/payments/initiate-ussd-push-request', [
                'amount' => (float) $request->amount,
                'currency' => 'TZS',
                'orderReference' => $request->orderReference,
                'phoneNumber' => $request->phoneNumber,
                'callbackUrl' => route('clickpesa.webhook'),
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $payment->update([
                    'clickpesa_reference' => $responseData['reference'] ?? null,
                    'gateway_response' => $responseData,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Payment initiated successfully',
                    'order_id' => $request->orderReference,
                    'data' => $responseData
                ], 200);
            } else {
                $payment->update(['status' => 'failed']);
                $errorData = $response->json();
                Log::error('ClickPesa USSD Push Error:', [
                    'status' => $response->status(),
                    'response' => $errorData
                ]);
                return response()->json([
                    'success' => false,
                    'error' => $errorData['message'] ?? 'Payment initiation failed'
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('ClickPesa Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing your payment'
            ], 500);
        }
    }

    // Step 3: Query Payment Status by Order Reference
    public function queryPaymentStatus($orderReference)
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'Could not authenticate with payment service'
            ], 500);
        }

        try {
            $payment = Payment::where('transaction_id', $orderReference)->first();
            if (!$payment) {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment not found'
                ], 404);
            }

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://api.clickpesa.com/third-parties/payments/' . $orderReference);

            if ($response->successful()) {
                $responseData = $response->json();
                $apiStatus = $responseData['status'] ?? 'pending';
                $mappedStatus = $this->mapClickPesaStatus($apiStatus);
                if ($payment->status !== $mappedStatus) {
                    $payment->update([
                        'status' => $mappedStatus,
                        'gateway_response' => $responseData,
                        'completed_at' => $mappedStatus === 'completed' ? now() : null
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'status' => $mappedStatus,
                    'message' => $this->getStatusMessage($mappedStatus),
                    'data' => $responseData
                ], 200);
            } else {
                return response()->json([
                    'success' => true, // fallback to local status
                    'status' => $payment->status,
                    'message' => $this->getStatusMessage($payment->status)
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error('Payment Status Query Exception:', [
                'order_reference' => $orderReference,
                'message' => $e->getMessage()
            ]);
            $payment = Payment::where('transaction_id', $orderReference)->first();
            return response()->json([
                'success' => true, // fallback to local status
                'status' => $payment ? $payment->status : 'unknown',
                'message' => 'Status check temporarily unavailable'
            ], 200);
        }
    }

    // Step 4: Webhook Handler
    public function webhook(Request $request)
    {
        Log::info('ClickPesa Webhook Received:', $request->all());
        try {
            $payload = $request->all();
            $orderReference = $payload['orderReference'] ?? $payload['order_reference'] ?? null;
            $status = $payload['status'] ?? null;
            $amount = $payload['amount'] ?? null;
            if (!$orderReference || !$status) {
                Log::warning('ClickPesa Webhook: Missing required fields', $payload);
                return response()->json(['success' => false, 'error' => 'Missing required fields'], 400);
            }
            $mappedStatus = $this->mapClickPesaStatus($status);
            $payment = Payment::where('transaction_id', $orderReference)->first();
            if ($payment) {
                $payment->update([
                    'status' => $mappedStatus,
                    'gateway_response' => $payload,
                    'completed_at' => $mappedStatus === 'completed' ? now() : null
                ]);
                $contribution = Contribution::where('payment_reference', $orderReference)->first();
                if ($contribution) {
                    $contribution->update([
                        'status' => $mappedStatus === 'completed' ? 'paid' : $mappedStatus
                    ]);
                }
                Log::info('ClickPesa Webhook: Payment updated', [
                    'order_reference' => $orderReference,
                    'status' => $mappedStatus
                ]);
            } else {
                Log::warning('ClickPesa Webhook: Payment not found', [
                    'order_reference' => $orderReference
                ]);
            }
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('ClickPesa Webhook Exception:', [
                'message' => $e->getMessage(),
                'payload' => $request->all()
            ]);
            return response()->json(['success' => false, 'error' => 'Webhook error'], 500);
        }
    }

    // Helper method to map ClickPesa status to our application status
    private function mapClickPesaStatus($clickPesaStatus)
    {
        $statusMap = [
            'success' => 'completed',
            'completed' => 'completed',
            'failed' => 'failed',
            'cancelled' => 'cancelled',
            'expired' => 'failed',
            'pending' => 'pending',
            'processing' => 'pending',
        ];

        return $statusMap[strtolower($clickPesaStatus)] ?? 'pending';
    }

    // Helper method to get user-friendly status messages
    private function getStatusMessage($status)
    {
        $messages = [
            'pending' => 'Payment is being processed',
            'completed' => 'Payment completed successfully',
            'failed' => 'Payment failed',
            'cancelled' => 'Payment was cancelled',
            'unknown' => 'Payment status unknown'
        ];

        return $messages[$status] ?? 'Payment status: ' . $status;
    }

    // Legacy methods for backward compatibility
    /**
     * @deprecated Use initiateUssdPush instead.
     */
    public function ussdCheckout(Request $request)
    {
        return $this->initiateUssdPush($request);
    }

    /**
     * @deprecated Use queryPaymentStatus instead.
     */
    public function queryStatus($transactionId)
    {
        return $this->queryPaymentStatus($transactionId);
    }

    // Preview USSD-PUSH request (validate details and check channel availability)
    public function previewUssdPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:3000000',
            'orderReference' => 'required|string',
        ]);
        $token = $this->getToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'error' => 'Could not authenticate with payment service'
            ], 500);
        }
        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post('https://api.clickpesa.com/third-parties/payments/preview-ussd-push-request', [
                'amount' => (float) $request->amount,
                'currency' => 'TZS',
                'orderReference' => $request->orderReference,
            ]);
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Preview request failed'
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Preview USSD Push Exception:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => 'Preview request failed'
            ], 500);
        }
    }
}