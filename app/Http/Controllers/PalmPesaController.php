<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PalmPesaService;

class PalmPesaController extends Controller
{
    protected $palmPesaService;

    public function __construct(PalmPesaService $palmPesaService)
    {
        $this->palmPesaService = $palmPesaService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^255\d{9}$/',
            'amount' => 'required|numeric|min:100',
            'transaction_id' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'buyer_uuid' => 'required|integer'
        ]);

        $response = $this->palmPesaService->processPayment($validated);
        
        return response()->json($response);
    }

    public function status($orderId)
    {
        $status = $this->palmPesaService->checkPaymentStatus($orderId);
        return response()->json($status);
    }
}