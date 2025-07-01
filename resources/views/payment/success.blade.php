@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto py-8">
    <div class="bg-white shadow rounded-lg p-6 text-center">
        <h2 class="text-2xl font-bold mb-4">Payment Successful</h2>
        <p class="mb-2">Your payment was processed successfully.</p>
        <p class="text-sm text-gray-500">Reference: {{ $reference }}</p>
        <a href="/" class="mt-6 inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Back to Dashboard</a>
    </div>
</div>
@endsection
