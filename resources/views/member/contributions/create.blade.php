@extends('layouts.member')

@section('content')
<div class="py-4 px-4 sm:py-6 sm:px-0">
  <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6 text-center sm:text-left">Make Contribution</h2>

    <!-- Progress Stepper -->
    <div class="mb-6 sm:mb-8">
      <div class="flex justify-between items-center">
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
          <span class="text-xs mt-1 text-center">Details</span>
        </div>
        <div class="flex-1 h-0.5 bg-gray-300 self-center mx-3 sm:mx-4"></div>
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">2</div>
          <span class="text-xs mt-1 text-center">Confirmation</span>
        </div>
      </div>
    </div>

    <!-- Messages Container -->
    <div id="messageContainer" aria-live="polite">
      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 sm:px-4 rounded mb-4 text-sm" role="alert">
          <ul class="space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Contribution Form -->
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
      <div class="mb-4 flex items-center justify-center sm:justify-start gap-2">
        <img src="{{ asset('clickpesa.jpeg') }}" alt="ClickPesa Logo" class="h-6 sm:h-8">
        <span class="text-blue-700 font-semibold text-sm sm:text-base">Secured by ClickPesa</span>
      </div>
      
      <form id="contributionForm" method="POST" action="{{ route('clickpesa.ussd-push') }}">
        @csrf
        <div class="mb-4 sm:mb-6">
          <label for="amount" class="block text-gray-700 text-sm font-medium mb-2">Amount (TZS)</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm">TZS</span>
            <input type="number" 
                   id="amount" 
                   name="amount" 
                   class="w-full pl-12 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base" 
                   min="1000" 
                   max="3000000" 
                   placeholder="Enter amount"
                   required>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Minimum: 1,000 TZS | Maximum: 3,000,000 TZS</p>
        </div>

        <div class="mb-6">
          <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Mobile Number</label>
          <div class="relative">
            <input type="tel" 
                   id="phone" 
                   name="phoneNumber" 
                   class="w-full pl-4 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base" 
                   pattern="0\d{9}|255\d{9}" 
                   placeholder="0693662424 or 255693662424" 
                   title="Enter 10 digits starting with 0 or 12 digits starting with 255" 
                   required>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Formats: 0693662424 (10 digits) or 255693662424 (12 digits)</p>
        </div>

        <input type="hidden" name="orderReference" value="{{ 'ORD-' . uniqid() }}">

        @auth
          <input type="hidden" name="buyer_email" value="{{ auth()->user()->email }}">
          <input type="hidden" name="buyer_name" value="{{ auth()->user()->name }}">
        @endauth

        <button type="submit" 
                id="proceedToPaymentBtn" 
                class="w-full bg-indigo-600 text-white py-3 sm:py-4 rounded-lg font-medium hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-colors text-base">
          Proceed to Payment
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Modals and JS remain unchanged but I recommend moving your fetch/ajax logic to Laravel form submission or handle the POST in JS if you want a SPA experience -->

@endsection

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Auto-format phone number to 255XXXXXXXXX on blur
  const phoneInput = document.getElementById('phone');
  phoneInput.addEventListener('blur', function() {
    let val = this.value.trim();
    if (/^0\d{9}$/.test(val)) {
      this.value = '255' + val.substring(1);
    }
  });

  // Optional: you can handle AJAX POST here instead of form submit if you want, but ensure route accepts POST

  // Just a tip: If you want to keep using fetch and modal flow, your backend route must accept POST on /jumuiyakiganjani/api/clickpesa/ussd-push
});
</script>
@endpush

@push('styles')
<style>
  /* Your styles here or keep the styles from your original */
</style>
@endpush
