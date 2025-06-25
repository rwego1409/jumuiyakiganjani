<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClickPesaService
{
    protected string $baseUrl;
    protected bool $mock;

    public function __construct()
    {
        $this->baseUrl = config('services.clickpesa.base_url', 'https://api.clickpesa.com');
        $this->mock = filter_var(env('CLICKPESA_MOCK', false), FILTER_VALIDATE_BOOLEAN);
    }

    public function initiateUssdPushPayment(string $phone, float $amount, string $reference): array
    {
        if ($this->mock) {
            Log::info('ClickPesaService: Running in MOCK mode.');
            return [
                'success' => true,
                'method' => 'clickpesa_mock',
                'reference' => 'MOCK-' . rand(100000, 999999),
                'phone' => $phone,
                'amount' => $amount,
                'message' => 'Mocked payment initiated'
            ];
        }

        $token = $this->getToken();
        if (!$token) {
            return [
                'success' => false,
                'error' => 'Unable to authenticate with ClickPesa.'
            ];
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/third-parties/payments/initiate-ussd-push-request', [
                    'amount' => $amount,
                    'currency' => 'TZS',
                    'orderReference' => $reference,
                    'phoneNumber' => $phone,
                    'callbackUrl' => route('clickpesa.webhook'),
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'method' => 'clickpesa',
                    'reference' => $data['reference'] ?? $reference,
                    'phone' => $phone,
                    'amount' => $amount,
                    'gateway_response' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $response->json()['message'] ?? 'Payment request failed'
                ];
            }
        } catch (\Exception $e) {
            Log::error('ClickPesaService Exception:', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => 'Payment request failed: ' . $e->getMessage()
            ];
        }
    }

    protected function getToken(): ?string
    {
        try {
            $response = Http::timeout(30)->post($this->baseUrl . '/oauth/token', [
                'client_id' => env('CLICKPESA_CLIENT_ID'),
                'client_secret' => env('CLICKPESA_CLIENT_SECRET'),
                'grant_type' => 'client_credentials',
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('ClickPesaService Token Error:', $response->json());
            return null;
        } catch (\Exception $e) {
            Log::error('ClickPesaService Token Exception:', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
