<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $url = config('services.palm_pesa.url');
        $token = config('services.palm_pesa.token');

        $validated = $request->validate([
            'user_id' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string',
            'address' => 'nullable|string',
            'postcode' => 'nullable|string',
            'buyer_uuid' => 'required|numeric',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url, $validated);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
