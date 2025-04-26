<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DarajaService
{
    protected string $baseUrl;
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $passKey;
    protected string $shortCode;

    public function __construct()
    {
        $this->baseUrl = config('services.mpesa.base_url');
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passKey = config('services.mpesa.pass_key');
        $this->shortCode = config('services.mpesa.short_code');
    }

    public function stkPush(string $phone, float $amount, string $reference, string $callback): array
    {
        try {
            // Log the request parameters
            Log::info('Initiating M-Pesa STK Push', [
                'phone' => $phone,
                'amount' => $amount,
                'reference' => $reference
            ]);

            // Get access token first
            $accessToken = $this->getAccessToken();
            
            if (!$accessToken) {
                throw new \Exception('Failed to obtain access token');
            }

            // Prepare STK Push request
            $timestamp = date('YmdHis');
            $password = base64_encode($this->shortCode . $this->passKey . $timestamp);
            
            // Prepare request payload
            $payload = [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortCode,
                'PhoneNumber' => $phone,
                'CallBackURL' => $callback,
                'AccountReference' => substr($reference, 0, 12),
                'TransactionDesc' => substr($reference, 0, 13)
            ];

            // Log prepared payload
            Log::debug('STK Push request payload', $payload);

            // Make the API request
            $response = Http::withToken($accessToken)
                ->timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            // Get the raw response body
            $rawResponse = $response->body();
            
            // Log raw response for debugging
            Log::debug('M-Pesa STK Push raw response', [
                'status_code' => $response->status(),
                'raw_body' => $rawResponse,
                'content_type' => $response->header('Content-Type'),
                'first_bytes_hex' => bin2hex(substr($rawResponse, 0, 32)),
                'length' => strlen($rawResponse),
            ]);

            // Check if response is likely JSON
            $trimmedResponse = trim($rawResponse);
            $firstChar = substr($trimmedResponse, 0, 1);
            
            if (!in_array($firstChar, ['{', '['])) {
                Log::error('Non-JSON response detected', [
                    'first_char' => $firstChar, 
                    'response' => $trimmedResponse
                ]);
                
                // Attempt to extract JSON if there might be other content before it
                if (preg_match('/(\{.*\}|\[.*\])$/s', $trimmedResponse, $matches)) {
                    $trimmedResponse = $matches[0];
                    Log::info('Extracted possible JSON from response', ['extracted' => $trimmedResponse]);
                } else {
                    throw new \Exception('Invalid response format: Not JSON');
                }
            }

            // Try to parse response as JSON
            $decodedResponse = json_decode($trimmedResponse, true);
            
            // Check for JSON parsing errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error: ' . json_last_error_msg(), [
                    'error_code' => json_last_error(),
                    'response' => $trimmedResponse
                ]);
                throw new \Exception('Failed to parse response: ' . json_last_error_msg());
            }
            
            // Log successful decoded response
            Log::info('M-Pesa STK Push response decoded', $decodedResponse);

            // Check if response contains expected fields
            if (isset($decodedResponse['ResponseCode']) && $decodedResponse['ResponseCode'] == '0') {
                // Success response
                return [
                    'success' => true,
                    'checkout_request_id' => $decodedResponse['CheckoutRequestID'] ?? null,
                    'merchant_request_id' => $decodedResponse['MerchantRequestID'] ?? null,
                    'message' => $decodedResponse['CustomerMessage'] ?? 'Success'
                ];
            } else {
                // Error response
                $errorMessage = $decodedResponse['errorMessage'] ?? 
                                $decodedResponse['ResponseDescription'] ?? 
                                'Unknown error occurred';
                
                Log::warning('M-Pesa STK Push failed', [
                    'error' => $errorMessage,
                    'response' => $decodedResponse
                ]);
                
                return [
                    'success' => false,
                    'error' => $errorMessage
                ];
            }
        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push exception: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }

    protected function getAccessToken(): ?string
    {
        try {
            $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
            
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');
            
            $rawResponse = $response->body();
            
            // Log raw token response
            Log::debug('M-Pesa get token raw response', [
                'status' => $response->status(),
                'body' => $rawResponse
            ]);
            
            $decodedResponse = json_decode($rawResponse, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Token JSON decode error: ' . json_last_error_msg(), ['raw' => $rawResponse]);
                return null;
            }
            
            if (!isset($decodedResponse['access_token'])) {
                Log::error('No access token in response', $decodedResponse);
                return null;
            }
            
            return $decodedResponse['access_token'];
        } catch (\Exception $e) {
            Log::error('Failed to get M-Pesa access token: ' . $e->getMessage());
            return null;
        }
    }
}