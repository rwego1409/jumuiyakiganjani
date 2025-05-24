@extends('layouts.member')

@section('content')
<div class="max-w-xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white p-6 rounded-lg shadow-md text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-xl font-semibold mb-4">Payment Successful!</h2>
        <p class="mb-6">Your contribution has been processed successfully.</p>
        <a href="{{ route('member.contributions.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Make Another Contribution
        </a>
    </div>
</div>
@endsection