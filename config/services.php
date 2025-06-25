<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'whatsapp' => [
        'api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v17.0'),
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
    ],

    'mpesa' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'short_code' => env('MPESA_SHORTCODE'),
        'passkey' => env('MPESA_PASSKEY'),
        'env' => env('MPESA_ENV', 'sandbox'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
    ],

    'daraja' => [
        'sandbox' => env('MPESA_ENV', 'sandbox') === 'sandbox',
        'shortcode' => env('MPESA_SHORTCODE'),
        'key' => env('MPESA_CONSUMER_KEY'),
        'secret' => env('MPESA_CONSUMER_SECRET'),
        'passkey' => env('MPESA_PASSKEY'),
        'callback_url' => env('MPESA_CALLBACK_URL'),
    ],

    'clickpesa' => [
        'client_id' => env('CLICKPESA_CLIENT_ID'),
        'api_key' => env('CLICKPESA_API_KEY'),
        'vendor_id' => env('CLICKPESA_VENDOR_ID'),
        'base_url' => env('CLICKPESA_BASE_URL', 'https://api.clickpesa.com'),
    ],

    'vodacom' => [
        'api_key' => env('VODACOM_API_KEY'),
        'api_secret' => env('VODACOM_API_SECRET'),
        'base_url' => env('VODACOM_BASE_URL', 'https://api.vodacom.co.tz'),
    ],

    'palmpesa' => [
    // 'url' => env('PALMPESA_URL'),
    'token' => env('PALMPESA_TOKEN'),
],

    'zenopay' => [
        'api_key' => env('ZENOPAY_API_KEY', 'YOUR_API_KEY_HERE'),
        'base_url' => env('ZENOPAY_BASE_URL', 'https://zenoapi.com/api/payments'),
    ],
];