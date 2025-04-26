<?php

namespace App\Services;

use App\Services\DarajaService;
use App\Services\ClickPesaService;
use App\Services\MpesaService;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(
        protected DarajaService $daraja,
        protected ClickPesaService $clickPesa,
        protected MpesaService $vodacom
    ) {}

    public function initiateMobilePayment(string $phone, float $amount, string $reference): array
    {
        $countryCode = Str::substr($phone, 0, 3);
        $amount = round($amount, 2);

        try {
            return match($countryCode) {
                '254' => $this->handleKenya($phone, $amount, $reference),
                '255' => $this->handleTanzania($phone, $amount, $reference),
                default => throw new \InvalidArgumentException('Unsupported country code')
            };
        } catch (\Exception $e) {
            return $this->handlePaymentError($e, $phone, $countryCode);
        }
    }

    protected function handleKenya(string $phone, float $amount, string $reference): array
    {
        return $this->daraja->stkPush(
            phone: $this->formatPhone($phone, '254'),
            amount: $amount,
            reference: $reference,
            callback: route('payment.daraja-callback')
        );
    }

    protected function handleTanzania(string $phone, float $amount, string $reference): array
    {
        // First try ClickPesa
        $response = $this->clickPesa->initiatePayment(
            phone: $this->formatPhone($phone, '255'),
            amount: $amount,
            reference: $reference
        );

        // If ClickPesa fails, fallback to Vodacom
        if (isset($response['error'])) {
            return $this->vodacom->makePayment(
                phone: $phone,
                amount: $amount,
                reference: $reference
            );
        }

        return $response;
    }

    private function formatPhone(string $phone, string $prefix): string
    {
        return $prefix . substr(preg_replace('/[^0-9]/', '', $phone), -9);
    }

    private function handlePaymentError(\Exception $e, string $phone, string $countryCode): array
    {
        logger()->error('Payment failed', [
            'phone' => $phone,
            'country' => $countryCode,
            'error' => $e->getMessage()
        ]);

        return [
            'success' => false,
            'error' => config('app.debug') ? $e->getMessage() : 'Payment processing failed'
        ];
    }

    // In DarajaService.php
public function stkPush(string $phone, float $amount, string $reference, string $callback): array
{
    try {
        // Get the raw response body before parsing
        $rawResponse = $this->makeApiRequest(/* your parameters */);
        
        // Log the raw response for inspection
        \Log::debug('Daraja API raw response', [
            'response' => $rawResponse,
            'length' => strlen($rawResponse),
            'first_few_bytes' => bin2hex(substr($rawResponse, 0, 20)) // Check for BOM or invisible chars
        ]);
        
        // Try decoding with safety checks
        $decodedResponse = json_decode($rawResponse, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('JSON decode error: ' . json_last_error_msg(), [
                'response' => $rawResponse
            ]);
            throw new \Exception('Invalid response format: ' . json_last_error_msg());
        }
        
        // Continue with your existing code
        
    } catch (\Exception $e) {
        \Log::error('STK Push error: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
}