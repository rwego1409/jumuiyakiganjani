<?php

namespace App\Services;

use App\Services\DarajaService;
use App\Services\ClickPesaService;
use App\Services\MpesaService;
use App\Services\ZenoPayService;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(
        protected DarajaService $daraja,
        protected ClickPesaService $clickPesa,
        protected MpesaService $vodacom,
        protected ZenoPayService $zenopay
    ) {}

    public function initiateMobilePayment(string $phone, float $amount, string $reference): array
    {
        $countryCode = Str::substr($phone, 0, 3);
        $amount = round($amount, 2);

        try {
            if ($countryCode === '254') {
                return $this->handleKenya($phone, $amount, $reference);
            } elseif ($countryCode === '255') {
                return $this->handleTanzania($phone, $amount, $reference);
            } else {
                throw new \InvalidArgumentException('Unsupported country code');
            }
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
        // Use ZenoPay for Tanzania
        $response = $this->zenopay->initiatePayment(
            $this->formatPhone($phone, '255'),
            $amount,
            $reference
        );
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
}