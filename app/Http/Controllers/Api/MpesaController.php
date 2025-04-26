<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DarajaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    protected $darajaService;

    public function __construct(DarajaService $darajaService)
    {
        $this->darajaService = $darajaService;
    }

    public function stkPush(Request $request)
    {
        Log::info('STK Push Request', $request->all());
        
        try {
            $response = $this->darajaService->initiateSTKPush(
                $request->phone,
                $request->amount
            );
            
            Log::info('STK Push Response', $response);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('STK Push Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        Log::info('M-Pesa Callback', $request->all());
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}
