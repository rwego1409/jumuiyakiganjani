<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ClickPesaService
{
    public function __construct(
        protected string $vendorId,
        protected string $clientId,
        protected string $apiKey,
        protected string $baseUrl
    ) {}

    protected function getJwtToken()
    {
        $url = $this->baseUrl . '/third-parties/generate-token';
        try {
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'client-id' => $this->clientId,
            ])->post($url);
            Log::info('ClickPesa getJwtToken request', ['url' => $url, 'headers' => ['api-key' => $this->apiKey, 'client-id' => $this->clientId]]);
            if ($response->successful()) {
                Log::info('ClickPesa getJwtToken success', ['response' => $response->json()]);
                return $response->json('token');
            }
            Log::error('ClickPesa JWT Token Error', ['response' => $response->body()]);
        } catch (\Throwable $e) {
            Log::error('ClickPesa JWT Token Exception', ['exception' => $e->getMessage()]);
        }
        return null;
    }

    /**
     * Generate checksum for ClickPesa payment request.
     * Adjust the logic as per ClickPesa documentation if a specific formula is required.
     */
    protected function generateChecksum(string $amount, string $currency, string $orderReference, string $phoneNumber): string
    {
        // Example: concatenate and hash (replace with ClickPesa's required logic if different)
        $data = $amount . $currency . $orderReference . $phoneNumber . $this->apiKey;
        return hash('sha256', $data);
    }

    public function initiatePayment(string $phone, float $amount, string $reference): array
    {
        Log::info('ClickPesa ENV DEBUG', [
            'vendorId' => $this->vendorId,
            'clientId' => $this->clientId,
            'apiKey' => $this->apiKey,
            'baseUrl' => $this->baseUrl,
        ]);
        Log::info('ClickPesa initiatePayment called', [
            'phone' => $phone,
            'amount' => $amount,
            'reference' => $reference
        ]);

        $jwt = $this->getJwtToken();
        if (!$jwt) {
            return [
                'success' => false,
                'error' => 'Could not authenticate with payment service'
            ];
        }

        $amountStr = (string) $amount;
        $currency = 'TZS';
        $checksum = $this->generateChecksum($amountStr, $currency, $reference, $phone);

        $payload = [
            'amount' => $amountStr,
            'currency' => $currency,
            'orderReference' => $reference,
            'phoneNumber' => $phone,
            'checksum' => $checksum
        ];

        $url = $this->baseUrl . '/third-parties/payments/initiate-ussd-push-request';
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $jwt,
                'Content-Type' => 'application/json',
            ])->post($url, $payload);
            Log::info('ClickPesa initiatePayment request', ['url' => $url, 'payload' => $payload, 'headers' => ['Authorization' => 'Bearer ' . $jwt]]);
        } catch (\Throwable $e) {
            Log::error('ClickPesa HTTP Exception', ['exception' => $e->getMessage(), 'payload' => $payload]);
            return [
                'success' => false,
                'error' => 'Payment initiation failed: ' . $e->getMessage()
            ];
        }

        return $this->parseResponse($response, $payload);
    }

    private function parseResponse($response, $payload = []): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json()
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
     * Check payment status by orderReference.
     */
    public function checkPaymentStatus(string $orderReference): array
    {
        $jwt = $this->getJwtToken();
        if (!$jwt) {
            return [
                'success' => false,
                'error' => 'Could not authenticate with payment service'
            ];
        }
        $url = $this->baseUrl . '/third-parties/payments/' . $orderReference;
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $jwt,
                'Content-Type' => 'application/json',
            ])->get($url);
            Log::info('ClickPesa checkPaymentStatus request', ['url' => $url, 'headers' => ['Authorization' => 'Bearer ' . $jwt]]);
        } catch (\Throwable $e) {
            Log::error('ClickPesa checkPaymentStatus Exception', ['exception' => $e->getMessage(), 'orderReference' => $orderReference]);
            return [
                'success' => false,
                'error' => 'Payment status check failed: ' . $e->getMessage()
            ];
        }
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json()
            ];
        }
        $errorMsg = $response->json('message') ?? $response->json('error') ?? 'Payment status check failed';
        Log::error('ClickPesa Payment Status Error', [
            'status' => $response->status(),
            'body' => $response->body(),
            'orderReference' => $orderReference
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