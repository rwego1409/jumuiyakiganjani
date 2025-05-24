<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class PalmPesaService
{
    protected $client;
    protected $apiToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiToken = config('services.palmpesa.token');
        $this->apiUrl = 'https://palmpesa.drmlelwa.co.tz/api/process_payment/complete';
        
        $this->client = new Client([
            'timeout' => 30,
            'http_errors' => false
        ]);
    }

    public function processPayment($phone, $amount, $reference)
    {
        try {
            $formattedPhone = $this->formatPhoneNumber($phone);
            
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Accept' => 'Application/json',
                'Content-Type' => 'application/json'
            ];
            
            $body = json_encode([
                'phone' => $formattedPhone,
                'amount' => (int)$amount,
                'reference' => $reference
            ]);

            $request = new Request('POST', $this->apiUrl, $headers, $body);
            
            Log::debug('Sending PalmPesa request', [
                'url' => $this->apiUrl,
                'headers' => $headers,
                'body' => $body
            ]);

            $response = $this->client->send($request);
            $responseBody = $response->getBody()->getContents();
            
            Log::debug('PalmPesa response', [
                'status' => $response->getStatusCode(),
                'response' => $responseBody
            ]);

            $data = json_decode($responseBody, true) ?? [];

            if ($response->getStatusCode() !== 200) {
                return [
                    'error' => 'Payment failed: ' . $response->getStatusCode(),
                    'details' => $data
                ];
            }

            // Ensure response has status field
            if (!isset($data['status'])) {
                $data['status'] = 'pending'; // Default status
            }

            return $data;

        } catch (RequestException $e) {
            Log::error('PalmPesa API Error', ['error' => $e->getMessage()]);
            return [
                'error' => 'API request failed',
                'details' => $e->getMessage()
            ];
        }
    }

    protected function formatPhoneNumber($phone)
    {
        $cleaned = preg_replace('/\D/', '', $phone);
        
        if (strlen($cleaned) === 10 && str_starts_with($cleaned, '0')) {
            return '255' . substr($cleaned, 1);
        }
        
        return $cleaned;
    }
}