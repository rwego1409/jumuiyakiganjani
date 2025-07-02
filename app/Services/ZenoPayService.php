<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ZenoPayService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.zenopay.base_url'), '/');
        $this->apiKey = config('services.zenopay.api_key');
    }

    public function initiatePayment(array $payload)
    {

        // Always append webhook_url if not set, using ngrok or fallback
        if (!isset($payload['webhook_url'])) {
            $payload['webhook_url'] = $this->getAutoWebhookUrl();
        }

        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
            'Accept' => 'application/json'
        ])->post("{$this->baseUrl}/payments/mobile_money_tanzania", $payload);

        return $response->throw()->json();
    }

    public function checkOrderStatus(string $orderId)
    {
        return Http::withHeaders([
            'X-API-Key' => $this->apiKey
        ])->get("{$this->baseUrl}/payments/order-status", [
            'order_id' => $orderId
        ])->throw()->json();
    }

    protected function getAutoWebhookUrl(): string
    {
        // Always use the current host, works for any ngrok or prod
        $scheme = request()->getScheme();
        $host = request()->getHost();
        $port = request()->getPort();
        $base = $scheme . '://' . $host;
        if ($port && !in_array($port, [80, 443])) {
            $base .= ":$port";
        }
        return rtrim($base, '/') . '/api/webhook/zenopay';
    }
}
