<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contribution;
use Illuminate\Support\Facades\Log;

class ZenoPayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Validate API key header
        $apiKey = $request->header('x-api-key');
        if ($apiKey !== config('services.zenopay.api_key')) {
            Log::warning('ZenoPay webhook: Invalid API key', ['ip' => $request->ip()]);
            return response('Invalid API key', 403);
        }

        $payload = $request->all();
        Log::info('ZenoPay webhook received', $payload);

        // Find contribution by order_id
        $contribution = Contribution::where('order_id', $payload['order_id'] ?? null)->first();
        if (!$contribution) {
            return response('Contribution not found', 404);
        }

        // Update status if payment completed
        if (($payload['payment_status'] ?? null) === 'COMPLETED') {
            $contribution->update([
                'status' => 'paid',
                'payment_method' => 'zenopay',
                'payment_date' => now(),
                'reference' => $payload['reference'] ?? null,
            ]);
        }

        return response('OK', 200);
    }
}
