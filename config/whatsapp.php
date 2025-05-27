<?php

return [
    'api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v17.0'),
    'api_token' => env('WHATSAPP_API_TOKEN'),
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    
    // Default templates for different notification types
    'templates' => [
        'payment_reminder' => [
            'name' => 'payment_reminder',
            'language' => 'en',
        ],
        'event_reminder' => [
            'name' => 'event_reminder',
            'language' => 'en',
        ],
    ],

    // Notification settings
    'settings' => [
        'retry_attempts' => 3,
        'retry_delay' => 60, // seconds
        'queue' => 'whatsapp',
    ],
];
