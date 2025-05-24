<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentLog;

class PalmPesaCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();

        Log::info('PalmPesa Callback Received:', $data);

        $orderId = $data['data'][0]['order_id'] ?? null;
        $status = $data['data'][0]['payment_status'] ?? null;
        $transid = $data['data'][0]['transid'] ?? null;

        if ($orderId) {
            // Update existing payment log if found
            PaymentLog::where('order_id', $orderId)->update([
                'payment_status' => $status,
                'transid' => $transid,
            ]);
        }

        return response()->json(['message' => 'Callback handled successfully'], 200);
    }
}
