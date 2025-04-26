<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VodacomMpesaService
{
    public function __construct(
        protected string $apiKey,
        protected string $apiSecret,
        protected string $baseUrl
    ) {}

    public function makePayment(string $phone, float $amount, string $reference): array
    {
        $response = Http::withToken($this->authenticate())
            ->post("{$this->baseUrl}/payments", [
                'msisdn' => $phone,
                'amount' => $amount,
                'reference' => $reference,
                'callback_url' => route('payment.vodacom-callback')
            ]);

        return $response->successful()
            ? ['success' => true, 'data' => $response->json()]
            : ['success' => false, 'error' => $response->json('message')];
    }

    private function authenticate(): string
    {
        $response = Http::withBasicAuth($this->apiKey, $this->apiSecret)
            ->post("{$this->baseUrl}/auth/token");

        return $response->json('access_token');
    }
}