<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZenoPayService;
use Illuminate\Validation\ValidationException;

class ZenoPayController extends Controller
{
    protected $zenoPayService;

    public function __construct(ZenoPayService $zenoPayService)
    {
        $this->zenoPayService = $zenoPayService;
    }

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^255\d{9}$/'],
            'amount' => 'required|numeric|min:1000',
            'reference' => 'required|string|max:255',
            'buyer_email' => 'nullable|email',
            'buyer_name' => 'nullable|string|max:255',
        ]);
        $webhookUrl = route('zenopay.webhook');
        $response = $this->zenoPayService->initiatePayment(
            $validated['phone'],
            $validated['amount'],
            $validated['reference'],
            $webhookUrl,
            $validated['buyer_email'] ?? null,
            $validated['buyer_name'] ?? null
        );
        return response()->json($response);
    }

    public function status(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|string',
            ]);
            $response = $this->zenoPayService->checkStatus($validated['order_id']);
            return response()->json($response);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $apiKey = $request->header('x-api-key');
        if ($apiKey !== config('services.zenopay.api_key')) {
            	\Log::warning('ZenoPay Webhook: Invalid API key', ['received' => $apiKey]);
            return response('Invalid API key', 403);
        }
        // Log the raw payload
        \Log::info('ZenoPay Webhook Payload', ['payload' => $payload]);
        // Optionally, process the payload (update DB, send email, etc.)
        return response('OK', 200);
    }
}
