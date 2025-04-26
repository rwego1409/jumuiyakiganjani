<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . base64_encode("{$this->apiKey}:{$this->apiSecret}"),
            'Signature' => $this->generateSignature($payload),
        ])->post("{$this->baseUrl}/v1/payments", $payload);

        return $this->parseResponse($response);
    }

    private function generateSignature(array $payload): string
    {
        ksort($payload);
        $signatureData = implode('', array_values($payload));
        return hash_hmac('sha256', $signatureData, $this->apiSecret);
    }

    private function parseResponse($response): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'transaction_id' => $response->json('data.transaction_id'),
                'gateway_url' => $response->json('data.gateway_url')
            ];
        }

        return [
            'success' => false,
            'error' => $response->json('message', 'Payment initiation failed')
        ];
    }
}