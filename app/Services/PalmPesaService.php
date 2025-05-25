<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PalmPesaService
{
    protected $client;
    protected $apiToken;
    protected $config = [
        'base_url' => 'https://palmpesa.drmlelwa.co.tz',
        'stk_endpoint' => '/api/process_payment/complete',
        'mobile_payment_endpoint' => '/api/pay-via-mobile'
    ];

    public function __construct()
    {
        $this->apiToken = config('services.palmpesa.token');
        $this->client = new Client([
            'base_uri' => $this->config['base_url'],
            'timeout' => 30,
            'http_errors' => false
        ]);
    }

    /**
     * Process STK Push payment (original processPayment method)
     */
    public function processPayment($phone, $amount, $reference, $callbackUrl = null)
    {
        return $this->processStkPush($phone, $amount, $reference, $callbackUrl);
    }

    /**
     * Process STK Push payment
     */
    public function processStkPush($phone, $amount, $reference, $callbackUrl = null)
    {
        try {
            $formattedPhone = $this->formatPhoneNumber($phone);
            
            $payload = [
                'phone' => $formattedPhone,
                'amount' => (int)$amount,
                'reference' => $reference,
                'callback_url' => $callbackUrl ?? route('payment.callback'),
                'request_stk' => true,
                'force_stk' => true,
                'msisdn' => $formattedPhone,
                'channel' => 'stk'
            ];

            Log::channel('palmpesa')->debug('STK Push Request', $payload);

            $response = $this->client->post($this->config['stk_endpoint'], [
                'headers' => $this->getAuthHeaders(),
                'json' => $payload,
                'timeout' => 30
            ]);

            return $this->handleStkResponse($response, $formattedPhone, $amount);

        } catch (RequestException $e) {
            Log::error('STK Push Error', ['error' => $e->getMessage()]);
            return $this->errorResponse('STK push failed', $e->getMessage());
        }
    }

    /**
     * Process direct mobile payment
     */
    public function processMobilePayment(array $paymentData)
    {
        $validation = $this->validatePaymentData($paymentData);
        if ($validation !== true) {
            return $validation;
        }

        try {
            $response = $this->client->post($this->config['mobile_payment_endpoint'], [
                'headers' => $this->getAuthHeaders(),
                'json' => $this->formatPaymentData($paymentData)
            ]);

            return $this->handlePaymentResponse($response);

        } catch (RequestException $e) {
            Log::error('Mobile Payment Error', ['error' => $e->getMessage()]);
            return $this->errorResponse('Payment processing failed', $e->getMessage());
        }
    }

    protected function getAuthHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    protected function formatPaymentData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $this->formatPhoneNumber($data['phone']),
            'amount' => (int)$data['amount'],
            'transaction_id' => $data['transaction_id'] ?? 'TXN-' . Str::random(10),
            'address' => $data['address'] ?? null,
            'postcode' => $data['postcode'] ?? null,
            'buyer_uuid' => $data['buyer_uuid'] ?? null
        ];
    }

    protected function validatePaymentData(array $data)
    {
        $required = ['user_id', 'name', 'email', 'phone', 'amount'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->errorResponse("Missing required field: $field");
            }
        }

        if (!is_numeric($data['amount']) || $data['amount'] <= 0) {
            return $this->errorResponse('Amount must be a positive number');
        }

        return true;
    }

    protected function handleStkResponse($response, $msisdn, $amount)
    {
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);

        Log::channel('palmpesa')->debug('STK API Response', [
            'status_code' => $statusCode,
            'response' => $responseBody
        ]);

        $defaultResponse = [
            'status' => $statusCode === 200 ? 'pending' : 'failed',
            'message' => $responseBody['message'] ?? ($statusCode === 200 
                ? 'STK push initiated. Please check your phone.' 
                : 'STK push failed'),
            'data' => [
                'order_id' => $responseBody['order_id'] ?? 'STK-' . time(),
                'msisdn' => $msisdn,
                'amount' => $amount,
                'payment_status' => $responseBody['payment_status'] ?? 'PENDING',
                'transid' => $responseBody['transid'] ?? null,
                'channel' => 'stk',
                'creation_date' => $responseBody['creation_date'] ?? now()->format('Y-m-d H:i:s')
            ]
        ];

        return array_merge($defaultResponse, $responseBody);
    }

    protected function handlePaymentResponse($response)
    {
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);

        Log::channel('palmpesa')->info('Payment API Response', [
            'status_code' => $statusCode,
            'response' => $responseBody
        ]);

        return [
            'status' => $statusCode === 200 ? 'success' : 'error',
            'message' => $responseBody['message'] ?? ($statusCode === 200 
                ? 'Payment processed successfully' 
                : 'Payment processing failed'),
            'code' => $statusCode,
            'data' => $responseBody
        ];
    }

    protected function formatPhoneNumber($phone)
    {
        $cleaned = preg_replace('/\D/', '', $phone);
        
        if (strlen($cleaned) === 10 && str_starts_with($cleaned, '0')) {
            return '255' . substr($cleaned, 1);
        }
        
        if (strlen($cleaned) === 12 && str_starts_with($cleaned, '255')) {
            return $cleaned;
        }
        
        return $cleaned;
    }

    protected function errorResponse($message, $details = null)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'details' => $details
        ];
    }
}