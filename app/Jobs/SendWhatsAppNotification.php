<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $phone,
        protected string $title,
        protected string $message
    ) {}

    public function handle(): void
    {
        try {
            // This is a placeholder WhatsApp Business API integration
            // You would need to replace this with your actual WhatsApp Business API integration
            $response = Http::post('https://whatsapp-api-url/send', [
                'phone' => $this->formatPhone($this->phone),
                'message' => "*{$this->title}*\n\n{$this->message}",
            ]);

            if (!$response->successful()) {
                Log::error('WhatsApp notification failed', [
                    'phone' => $this->phone,
                    'error' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed', [
                'phone' => $this->phone,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function formatPhone(string $phone): string
    {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);
        
        // If starts with 0, replace with country code
        if (str_starts_with($phone, '0')) {
            $phone = '255' . substr($phone, 1);
        }
        
        // If doesn't start with country code, add it
        if (!str_starts_with($phone, '255')) {
            $phone = '255' . $phone;
        }
        
        return $phone;
    }
}
