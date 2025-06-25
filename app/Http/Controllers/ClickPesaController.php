<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Contribution;
use App\Models\Payment;
use App\Services\ClickPesaService;

class ClickPesaController extends Controller
{
    protected function getClickPesaBaseUrl()
    {
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

            $this->logHttpError('ClickPesa Token Error', $response);
            return null;
        } catch (\Exception $e) {
            Log::error('ClickPesa Token Exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function initiateUssdPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . config('payments.min', 1000) . '|max:' . config('payments.max', 3000000),
            'orderReference' => 'required|string',
            'phoneNumber' => 'required|string|regex:/^255\d{9}$/',
            'buyer_email' => 'nullable|email',
            'buyer_name' => 'nullable|string',
        ]);

        $mock = filter_var(env('CLICKPESA_MOCK', false), FILTER_VALIDATE_BOOLEAN);

        if ($mock) {
            Log::info('ClickPesaController: Running in MOCK mode for USSD-PUSH payment.');
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
                'user_id' => auth()->check() ? auth()->id() : null,
                'clickpesa_reference' => $mockResponse['reference'],
                'gateway_response' => $mockResponse,
                'completed_at' => now(),
            ]);

            if ($contribution = $this->findContribution($request->orderReference)) {
                $contribution->update(['status' => 'paid']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment completed successfully (mocked)',
                'order_id' => $request->orderReference,
                'data' => $mockResponse,
            ]);
        }

        $token = $this->getToken();
        if (!$token) {
            return response()->json(['success' => false, 'error' => 'Could not authenticate with payment service'], 500);
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
                'user_id' => auth()->check() ? auth()->id() : null,
            ]);

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->getClickPesaBaseUrl() . '/third-parties/payments/initiate-ussd-push-request', [
                'amount' => (float) $request->amount,
                'currency' => 'TZS',
                'orderReference' => $request->orderReference,
                'phoneNumber' => $request->phoneNumber,
                'callbackUrl' => secure_url(route('clickpesa.webhook', [], false)),
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
                    'data' => $responseData,
                ]);
            } else {
                $payment->update(['status' => 'failed']);
                $this->logHttpError('ClickPesa USSD Push Error', $response);
                return response()->json([
                    'success' => false,
                    'error' => $response->json()['message'] ?? 'Payment initiation failed',
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('ClickPesa Exception:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'An error occurred while processing your payment'], 500);
        }
    }

    public function queryPaymentStatus($orderReference)
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json(['success' => false, 'error' => 'Could not authenticate with payment service'], 500);
        }

        try {
            $payment = $this->findPayment($orderReference);
            if (!$payment) {
                return response()->json(['success' => false, 'error' => 'Payment not found'], 404);
            }

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->getClickPesaBaseUrl() . '/third-parties/payments/' . $orderReference);

            if ($response->successful()) {
                $responseData = $response->json();
                $apiStatus = $responseData['status'] ?? 'pending';
                $mappedStatus = $this->mapClickPesaStatus($apiStatus);

                if ($payment->status !== $mappedStatus) {
                    $payment->update([
                        'status' => $mappedStatus,
                        'gateway_response' => $responseData,
                        'completed_at' => $mappedStatus === 'completed' ? now() : null,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'status' => $mappedStatus,
                    'message' => $this->getStatusMessage($mappedStatus),
                    'data' => $responseData,
                ]);
            }

            return response()->json([
                'success' => true,
                'status' => $payment->status,
                'message' => $this->getStatusMessage($payment->status),
            ]);
        } catch (\Exception $e) {
            Log::error('Payment Status Query Exception:', ['order_reference' => $orderReference, 'message' => $e->getMessage()]);
            $payment = $this->findPayment($orderReference);
            return response()->json([
                'success' => true,
                'status' => $payment ? $payment->status : 'unknown',
                'message' => 'Status check temporarily unavailable',
            ]);
        }
    }

    public function webhook(Request $request)
    {
        Log::info('ClickPesa Webhook Received:', $request->all());

        try {
            $payload = $request->all();
            $orderReference = $payload['orderReference'] ?? $payload['order_reference'] ?? null;
            $status = $payload['status'] ?? null;

            if (!$orderReference || !$status) {
                Log::warning('Webhook missing fields:', $payload);
                return response()->json(['success' => false, 'error' => 'Missing required fields'], 400);
            }

            $mappedStatus = $this->mapClickPesaStatus($status);
            $payment = $this->findPayment($orderReference);

            if ($payment) {
                $payment->update([
                    'status' => $mappedStatus,
                    'gateway_response' => $payload,
                    'completed_at' => $mappedStatus === 'completed' ? now() : null,
                ]);

                if ($contribution = $this->findContribution($orderReference)) {
                    $contribution->update(['status' => $mappedStatus === 'completed' ? 'paid' : $mappedStatus]);
                }

                Log::info('Webhook updated payment:', ['order_reference' => $orderReference, 'status' => $mappedStatus]);
            } else {
                Log::warning('Webhook payment not found:', ['order_reference' => $orderReference]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook Exception:', ['message' => $e->getMessage(), 'payload' => $request->all()]);
            return response()->json(['success' => false, 'error' => 'Webhook error'], 500);
        }
    }

    public function previewUssdPush(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . config('payments.min', 1000) . '|max:' . config('payments.max', 3000000),
            'orderReference' => 'required|string',
        ]);

        $token = $this->getToken();
        if (!$token) {
            return response()->json(['success' => false, 'error' => 'Could not authenticate with payment service'], 500);
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->getClickPesaBaseUrl() . '/third-parties/payments/preview-ussd-push-request', [
                'amount' => (float) $request->amount,
                'currency' => 'TZS',
                'orderReference' => $request->orderReference,
            ]);

            if ($response->successful()) {
                return response()->json(['success' => true, 'data' => $response->json()]);
            }

            $this->logHttpError('Preview USSD Push Error', $response);
            return response()->json(['success' => false, 'error' => 'Preview request failed'], $response->status());
        } catch (\Exception $e) {
            Log::error('Preview USSD Push Exception:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Preview request failed'], 500);
        }
    }

    /**
     * Query payment status using ClickPesaService by orderReference.
     */
    public function paymentStatusByOrderReference($orderReference, ClickPesaService $clickPesaService)
    {
        $result = $clickPesaService->checkPaymentStatus($orderReference);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'status' => $result['data']['status'] ?? null,
                'data' => $result['data'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => $result['error'] ?? 'Unknown error',
            ], 500);
        }
    }

    private function findPayment($orderReference)
    {
        return Payment::where('transaction_id', $orderReference)->first();
    }

    private function findContribution($orderReference)
    {
        return Contribution::where('payment_reference', $orderReference)->first();
    }

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

        $mapped = $statusMap[strtolower($clickPesaStatus)] ?? null;
        if (!$mapped) {
            Log::warning("Unknown ClickPesa status received: $clickPesaStatus");
            return 'pending';
        }

        return $mapped;
    }

    private function getStatusMessage($status)
    {
        return [
            'pending' => 'Payment is being processed',
            'completed' => 'Payment completed successfully',
            'failed' => 'Payment failed',
            'cancelled' => 'Payment was cancelled',
            'unknown' => 'Payment status unknown',
        ][$status] ?? 'Payment status: ' . $status;
    }

    private function logHttpError($context, $response)
    {
        try {
            $data = $response->json();
        } catch (\Throwable $e) {
            $data = ['raw_body' => $response->body()];
        }
        Log::error($context, $data);
    }

    // Legacy support
    public function ussdCheckout(Request $request)
    {
        return $this->initiateUssdPush($request);
    }

    public function queryStatus($transactionId)
    {
        return $this->queryPaymentStatus($transactionId);
    }
}
