<?php

namespace App\Http\Controllers;

use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    protected $mpesaService;

    // Inject the MpesaService into the controller
    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    public function makePayment(Request $request)
    {
        $phone = $request->input('phone');
        $amount = $request->input('amount');
        
        // Call the STK push method
        $response = $this->mpesaService->initiateSTKPush($phone, $amount);

        // Handle the response from STK Push
        if (isset($response['error'])) {
            // Handle error case
            return response()->json(['message' => $response['error']]);
        }

        // Proceed with payment success (or handle further)
        return response()->json($response);
    }


// Method to initiate the STK Push for payment
public function initiatePayment(Request $request)
{
    // Validate input
    $request->validate([
        'phone' => 'required|numeric|digits:12',  // Accepts 12 digits (e.g., 2557XXXXXXXX)
        'amount' => 'required|numeric|min:1',     // Amount should be greater than 0
    ]);

    // Get data from request
    $phone = $request->input('phone');
    $amount = $request->input('amount');
    $reference = $request->input('reference', 'Contribution');  // Default reference

    // Trigger STK Push request using the MpesaService
    $response = $this->mpesaService->initiateSTKPush($phone, $amount, $reference);

    // Check the response and give feedback
    if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
        // Payment initiated successfully
        return response()->json([
            'message' => 'Payment request sent successfully!',
            'data' => $response
        ]);
    }

    // If there was an error in initiating the payment
    return response()->json([
        'message' => 'Failed to initiate payment request',
        'error' => $response
    ], 500);
}


    // Callback endpoint to receive payment status
    public function callback(Request $request)
    {
        // Log the callback response for debugging
        Log::info('M-Pesa Callback Response:', $request->all());

        // Check if the response has the required data
        $data = $request->all();

        if (isset($data['Body']['stkCallback']['ResultCode']) && $data['Body']['stkCallback']['ResultCode'] == 0) {
            $metadata = $data['Body']['stkCallback']['CallbackMetadata'] ?? [];
            Log::info('Payment successful', $metadata);
            return response()->json([
                'message' => 'Payment was successful',
                'data' => $metadata
            ]);
        }
        

        // Payment failed or was canceled by the user
        Log::warning('Payment failed or canceled', $data['Body']['stkCallback']);

        return response()->json([
            'message' => 'Payment failed or was canceled',
            'error' => $request->Body->stkCallback
        ], 400);
    }

    
}
