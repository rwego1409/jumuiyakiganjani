<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    // Generate Access Token from Safaricom API
    public function generateAccessToken()
    {
        // Log credentials (mask sensitive info for security)
        Log::info('Generating Access Token', [
            'consumer_key_length' => strlen(config('services.mpesa.consumer_key')),
            'consumer_secret_length' => strlen(config('services.mpesa.consumer_secret')),
            'environment' => config('services.mpesa.env')
        ]);
        
        // Base64 encode the consumer key and secret
        $credentials = base64_encode(
            config('services.mpesa.consumer_key') . ':' . config('services.mpesa.consumer_secret')
        );
        
        // Construct the URL to request the access token
        $url = $this->baseUrl() . '/oauth/v1/generate?grant_type=client_credentials';
        
        Log::info('Requesting token from URL', ['url' => $url]);
        
        // Make GET request to get the access token
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials
        ])->get($url);
        
        // Log the full response for debugging
        Log::info('Raw Access Token Response', ['status' => $response->status(), 'body' => $response->body()]);
        
        if ($response->successful()) {
            $token = $response['access_token'] ?? null;
            Log::info('Token generated successfully', ['token_length' => $token ? strlen($token) : 0]);
            return $token;
        }
        
        // Log error if access token fetch fails
        Log::error('Failed to get access token', [
            'status' => $response->status(),
            'response' => $response->body()
        ]);
        
        return null;
    }

    // Initiate the STK Push request to Safaricom API
    public function initiateSTKPush($phone, $amount, $reference = 'Contribution')
{
    // Generate a fresh access token first
    $accessToken = $this->generateAccessToken();
    
    // If access token is invalid or empty, return an error
    if (!$accessToken) {
        Log::error('Failed to generate access token');
        return ['error' => 'Failed to generate access token'];
    }
    
    // Get current timestamp in 'YYYYMMDDHHMMSS' format
    $timestamp = now()->format('YmdHis');
    
    // Create password
    $password = base64_encode(config('services.mpesa.short_code') . config('services.mpesa.passkey') . $timestamp);
    
    // Log request details (for debugging)
    Log::info('Preparing STK Push', [
        'phone' => $phone,
        'amount' => $amount,
        'shortcode' => config('services.mpesa.short_code'),
        'timestamp' => $timestamp,
        'callback_url' => env('MPESA_CALLBACK_URL')
    ]);
    
    // Prepare the payload for the STK Push request
    $payload = [
        "BusinessShortCode" => config('services.mpesa.short_code'),
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => config('services.mpesa.short_code'),
        "PhoneNumber" => $phone,
        "CallBackURL" => env('MPESA_CALLBACK_URL'),
        "AccountReference" => $reference,
        "TransactionDesc" => "Contribution payment"
    ];
    
    $url = $this->baseUrl() . '/mpesa/stkpush/v1/processrequest';
    
    Log::info('Sending STK Push request', [
        'url' => $url,
        'token_length' => strlen($accessToken),
        'payload' => $payload
    ]);
    
    // Send STK Push request to Safaricom
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json'
    ])->post($url, $payload);
    
    Log::info('STK Push Response', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);
    
    // Return response as JSON
    return $response->json();
}

    // Determine the base URL based on the environment
    private function baseUrl()
    {
        return config('services.mpesa.env') === 'live' ? 
            'https://api.safaricom.co.ke' : 
            'https://sandbox.safaricom.co.ke';
    }

    // Add this method to your MpesaService class
    public function testMpesaEndpoint()
    {
        // Hard-code everything for testing
        $accessToken = "vJRALpIOcxaAmKQ2QCcX644NA9Hi";
        $timestamp = now()->format('YmdHis');
        
        // Hard-code these values from your .env file
        $shortcode = "174379"; // Replace with your actual shortcode
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; // Replace with your actual passkey
        
        $password = base64_encode($shortcode . $passkey . $timestamp);
        
        $payload = [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => "10",
            "PartyA" => "255752539698",
            "PartyB" => $shortcode,
            "PhoneNumber" => "255752539698",
            "CallBackURL" => "https://b649-196-249-109-18.ngrok-free.app/mpesa/callback",
            "AccountReference" => "Test",
            "TransactionDesc" => "Test payment"
        ];
        
        // Explicitly use the sandbox URL
        $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        
        Log::info('TEST WITH HARDCODED VALUES', [
            'token' => $accessToken,
            'url' => $url,
            'shortcode' => $shortcode
        ]);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($url, $payload);
        
        Log::info('Hard-coded Test Response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);
        
        return $response->json();
    }

    public function testWithDirectToken()
{
    // Use the token you got from curl
    $accessToken = "vJRALpIOcxaAmKQ2QCcX644NA9Hi";
    
    // Rest of your STK push code but using this token directly
    $timestamp = now()->format('YmdHis');
    $password = base64_encode(config('services.mpesa.short_code') . config('services.mpesa.passkey') . $timestamp);
    
    $payload = [
        "BusinessShortCode" => config('services.mpesa.short_code'),
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => "10", // Small test amount
        "PartyA" => "255752539698",
        "PartyB" => config('services.mpesa.short_code'),
        "PhoneNumber" => "255752539698",
        "CallBackURL" => env('MPESA_CALLBACK_URL'),
        "AccountReference" => "Test",
        "TransactionDesc" => "Test payment"
    ];
    
    $url = $this->baseUrl() . '/mpesa/stkpush/v1/processrequest';
    
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json'
    ])->post($url, $payload);
    
    Log::info('Test Direct Token Response', [
        'status' => $response->status(),
        'body' => $response->body()
    ]);
    
    return $response->json();
}

public function testMultipleFormats()
{
    $accessToken = "vJRALpIOcxaAmKQ2QCcX644NA9Hi";
    $timestamp = now()->format('YmdHis');
    $password = base64_encode(config('services.mpesa.short_code') . config('services.mpesa.passkey') . $timestamp);
    
    $payload = [
        "BusinessShortCode" => config('services.mpesa.short_code'),
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => "10",
        "PartyA" => "255752539698",
        "PartyB" => config('services.mpesa.short_code'),
        "PhoneNumber" => "255752539698",
        "CallBackURL" => env('MPESA_CALLBACK_URL'),
        "AccountReference" => "Test",
        "TransactionDesc" => "Test payment"
    ];
    
    $url = $this->baseUrl() . '/mpesa/stkpush/v1/processrequest';
    
    // Test with just Authorization header
    $response1 = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken
    ])->post($url, $payload);
    
    Log::info('Test 1 - Auth Only', [
        'status' => $response1->status(),
        'body' => $response1->body()
    ]);
    
    // Test with different auth format 
    $response2 = Http::withHeaders([
        'Authorization' => 'Bearer' . $accessToken  // No space
    ])->post($url, $payload);
    
    Log::info('Test 2 - No Space', [
        'status' => $response2->status(),
        'body' => $response2->body()
    ]);
    
    // Test with additional headers
    $response3 = Http::withHeaders([
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ])->post($url, $payload);
    
    Log::info('Test 3 - Additional Headers', [
        'status' => $response3->status(),
        'body' => $response3->body()
    ]);
    
    return [
        'test1' => $response1->json(),
        'test2' => $response2->json(),
        'test3' => $response3->json()
    ];
}
}