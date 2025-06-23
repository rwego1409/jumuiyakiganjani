<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ClickPesaService
{
    public function __construct(
        protected string $vendorId,
        protected string $apiKey,
        protected string $apiSecret,
        protected string $baseUrl
    ) {}

    public function initiatePayment(string $phone, float $amount, string $reference): array
    {
        Log::info('ClickPesa initiatePayment called', [
            'phone' => $phone,
            'amount' => $amount,
            'reference' => $reference
        ]);

        $payload = [
            'vendor' => $this->vendorId,
            'order_id' => Str::uuid(),
            'buyer_phone' => $phone,
            'payment_method' => 'CLICKPESA',
            'amount' => $amount,
            'currency' => 'TZS',
            'redirect_url' => route('payment.clickpesa-callback'),
            'webhook' => route('payment.webhook'),
            'timestamp' => now()->toISOString(),
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . base64_encode("{$this->apiKey}:{$this->apiSecret}"),
                'Signature' => $this->generateSignature($payload),
            ])->post("{$this->baseUrl}/v1/payments", $payload);
        } catch (\Throwable $e) {
            Log::error('ClickPesa HTTP Exception', ['exception' => $e->getMessage(), 'payload' => $payload]);
            return [
                'success' => false,
                'error' => 'Payment initiation failed: ' . $e->getMessage()
            ];
        }

        return $this->parseResponse($response, $payload);
    }

    private function generateSignature(array $payload): string
    {
        ksort($payload);
        $signatureData = implode('', array_values($payload));
        return hash_hmac('sha256', $signatureData, $this->apiSecret);
    }

    private function parseResponse($response, $payload = []): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'transaction_id' => $response->json('data.transaction_id'),
                'gateway_url' => $response->json('data.gateway_url')
            ];
        }

        $errorMsg = $response->json('message') ?? $response->json('error') ?? 'Payment initiation failed';
        Log::error('ClickPesa Payment Error', [
            'status' => $response->status(),
            'body' => $response->body(),
            'payload' => $payload
        ]);
        return [
            'success' => false,
            'error' => $errorMsg
        ];
    }

    /**
     * Static method for direct USSD push payment (raw cURL, for preview-ussd-push-request endpoint)
     * Improved: robust error handling, logging, and consistent return structure.
     */
    public static function ussdPush($amount, $orderReference, $checksum, $accessToken)
    {
        Log::info('ClickPesa ussdPush called', [
            'amount' => $amount,
            'orderReference' => $orderReference,
            'checksum' => $checksum
        ]);

        $url = "https://api.clickpesa.com/third-parties/payments/preview-ussd-push-request";
        $payload = [
            "amount" => $amount,
            "currency" => "TZS",
            "orderReference" => $orderReference,
            "checksum" => $checksum
        ];

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$accessToken}",
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($err) {
                Log::error('ClickPesa USSD Push cURL error', ['error' => $err]);
                return [
                    'success' => false,
                    'error' => $err
                ];
            }

            $decoded = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('ClickPesa USSD Push invalid JSON', ['response' => $response]);
                return [
                    'success' => false,
                    'error' => 'Invalid JSON response from ClickPesa',
                    'raw_response' => $response
                ];
            }

            if ($httpCode < 200 || $httpCode >= 300) {
                $apiError = $decoded['message'] ?? ($decoded['error'] ?? 'Unknown API error');
                Log::error('ClickPesa USSD Push API error', [
                    'http_code' => $httpCode,
                    'api_error' => $apiError,
                    'response' => $decoded
                ]);
                return [
                    'success' => false,
                    'error' => $apiError,
                    'http_code' => $httpCode,
                    'response' => $decoded
                ];
            }

            // Optionally log successful response for diagnostics
            Log::info('ClickPesa USSD Push success', ['response' => $decoded]);
            return [
                'success' => true,
                'response' => $decoded
            ];
        } catch (\Throwable $e) {
            Log::error('ClickPesa USSD Push exception', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}