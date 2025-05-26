<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsAppReminder;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiToken = config('services.whatsapp.api_token');
    }

    public function sendMessage(WhatsAppReminder $reminder)
    {
        try {
            // Format the phone number (remove + and spaces)
            $phone = preg_replace('/[^0-9]/', '', $reminder->phone_number);
            
            // Make the API request to WhatsApp Cloud API
            $response = Http::withToken($this->apiToken)
                ->post($this->apiUrl . '/messages', [
                    'messaging_product' => 'whatsapp',
                    'to' => $phone,
                    'type' => 'text',
                    'text' => [
                        'body' => $reminder->message
                    ]
                ]);

            if ($response->successful()) {
                $reminder->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
                return true;
            }

            // If the request failed, log the error and update the reminder
            $errorMessage = $response->json('error.message', 'Unknown error');
            throw new \Exception($errorMessage);

        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getMessage(), [
                'reminder_id' => $reminder->id,
                'phone' => $reminder->phone_number
            ]);

            $reminder->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            return false;
        }
    }
}
