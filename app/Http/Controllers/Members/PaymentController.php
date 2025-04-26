<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $phone = $validated['phone'];
        $amount = $validated['amount'];

        $timestamp = now()->format('YmdHis');
        $passkey = 'YOUR_PASSKEY';
        $shortcode = '174379';
        $password = base64_encode($shortcode . $passkey . $timestamp);

        $url = url('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');

        $payload = [
            'BusinessShortCode' => $shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => url('/mock/daraja/callback'),
            'AccountReference' => 'TestRef',
            'TransactionDesc' => 'Test payment',
        ];

        $response = Http::post($url, $payload);

        Log::info('STK Push Response', $response->json());

        return back()->with('status', 'Payment initiated!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumuiya_id' => 'required|exists:jumuiyas,id',
            'amount' => 'required|numeric|min:1000|max:3000000',
            'contribution_date' => 'required|date',
            'payment_method' => 'required|string',
        ]);
    
        // Save the contribution
        Contribution::create([
            'member_id' => auth()->user()->member->id,
            'jumuiya_id' => $validated['jumuiya_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'contribution_date' => $validated['contribution_date'],
        ]);
    
        return redirect()->route('member.contributions.index')
            ->with('success', 'Contribution submitted successfully!');
    }

    public function index()
{
    $contributions = auth()->user()->member->contributions()->latest()->get();

    return view('member.contributions.index', compact('contributions'));
}


}
