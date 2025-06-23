<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ZenoPayService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.zenopay.api_key');
        $this->baseUrl = config('services.zenopay.base_url', 'https://zenoapi.com/api/payments');
    }

    public function initiatePayment($phone, $amount, $reference, $webhookUrl = null, $buyerEmail = null, $buyerName = null)
    {
        $orderData = [
            'order_id'    => $reference,
            'buyer_email' => $buyerEmail ?? (auth()->user()->email ?? 'customer@example.com'),
            'buyer_name'  => $buyerName ?? (auth()->user()->name ?? 'Member'),
            'buyer_phone' => $phone,
            'amount'      => $amount,
            'webhook_url' => $webhookUrl ?? route('zenopay.webhook'),
        ];

        $ch = curl_init(rtrim($this->baseUrl, '/') . '/mobile_money_tanzania');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key: ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS     => json_encode($orderData),
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            Log::error('ZenoPay Error', ['error' => $error, 'response' => $response, 'http' => $httpCode]);
            return [
                'status' => 'error',
                'message' => $error ?: $response,
            ];
        }

        $data = json_decode($response, true);
        return $data;
    }

    public function checkStatus($orderId)
    {
        $url = rtrim($this->baseUrl, '/') . '/order-status?order_id=' . urlencode($orderId);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'x-api-key: ' . $this->apiKey,
            ],
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($response === false || $httpCode !== 200) {
            return [
                'status' => 'error',
                'message' => $error ?: $response,
            ];
        }
        $responseData = json_decode($response, true);
        if (!empty($responseData['data']) && ($responseData['result'] ?? '') === 'SUCCESS') {
            return $responseData;
        } else {
            return [
                'status' => 'error',
                'message' => $responseData['message'] ?? 'Unknown error',
            ];
        }
    }
}
