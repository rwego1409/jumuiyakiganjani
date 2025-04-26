<!-- resources/views/member/payments/success.blade.php -->
@extends('layouts.member')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow text-center">
    <svg class="mx-auto h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    
    <h2 class="mt-3 text-xl font-semibold text-gray-900">Payment Successful!</h2>
    
    <div class="mt-4 bg-gray-50 p-4 rounded-lg">
        <p class="text-gray-600">Amount: {{ number_format($payment->amount) }} TZS</p>
        <p class="text-gray-600">Method: {{ ucfirst($payment->payment_method) }}</p>
        @if($payment->transaction_id)
        <p class="text-gray-600">Reference: {{ $payment->transaction_id }}</p>
        @endif
    </div>
    
    <div class="mt-6">
        <a href="{{ route('member.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Back to Dashboard
        </a>
    </div>
</div>
@endsection