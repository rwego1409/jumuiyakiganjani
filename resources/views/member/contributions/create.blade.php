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
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md" x-data="zenoPayContributionFlow()" style="box-sizing: border-box; max-width: 100%;">
      <div class="mb-4 flex items-center justify-center sm:justify-start gap-2">
        <div class="h-8 w-8 bg-gray-200 rounded flex items-center justify-center">
          <img src="{{ asset('zeno.jpg') }}" alt="ZenoPay Logo" class="h-6 sm:h-8">
        </div>
        <span class="text-indigo-700 font-semibold text-sm sm:text-base">Secured by ZenoPay</span>
      </div>
      <form id="contributionForm" @submit.prevent="submitContribution" style="display: flex; flex-direction: column; gap: 0;">
        @csrf
        <input type="hidden" name="contribution_id" value="{{ $contribution->id ?? '' }}">
        <div class="mb-4 sm:mb-6">
          <label for="amount" class="block text-gray-700 text-sm font-medium mb-2">Amount (TZS)</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600 text-sm">TZS</span>
            <input type="number" 
                   id="amount" 
                   name="amount" 
                   x-model="amount"
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
                   name="phone" 
                   x-model="phone"
                   class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base outline-none shadow-none" 
                   pattern="255\d{9}" 
                   maxlength="12"
                   inputmode="numeric"
                   placeholder="255XXXXXXXXX" 
                   title="Enter 12 digits starting with 255" 
                   required
                   style="max-width: 100%; box-sizing: border-box; overflow-x: hidden; border-bottom: none !important;">
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Format: 255XXXXXXXXX (12 digits)</p>
        </div>
        <button type="submit" 
                id="proceedToPaymentBtn" 
                class="w-full bg-indigo-600 text-white py-3 sm:py-4 rounded-lg font-medium hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-colors text-base"
                style="min-height:48px;"
                x-bind:disabled="loading">
          <span x-show="!loading" style="display:inline;">Proceed to Payment</span>
          <span x-show="loading" style="display:none;">
            <svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg> Processing...
          </span>
          <noscript>Proceed to Payment</noscript>
        </button>
      </form>
      <!-- Success Modal -->
      <div x-show="showSuccess" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold mb-2">Contribution Successful!</h2>
          <p class="mb-4">Your contribution has been processed successfully.</p>
          <button @click="resetForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Make Another Contribution</button>
        </div>
      </div>
      <!-- Error Modal -->
      <div x-show="showError" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold mb-2">Contribution Failed</h2>
          <p class="mb-4" x-text="errorMessage"></p>
          <button @click="showError=false" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Close</button>
        </div>
      </div>
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
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function uuidv4() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}
function zenoPayContributionFlow() {
    return {
        amount: '',
        phone: '',
        loading: false,
        showSuccess: false,
        showError: false,
        errorMessage: '',
        submitContribution() {
            if (!this.amount || !this.phone) {
                this.errorMessage = 'Please fill all fields';
                this.showError = true;
                return;
            }
            if (this.amount < 1000 || this.amount > 3000000) {
                this.errorMessage = 'Amount must be between 1,000 and 3,000,000 TZS';
                this.showError = true;
                return;
            }
            let phone = this.phone.trim();
            // Convert 255XXXXXXXXX to 07XXXXXXXX for ZenoPay API
            if (/^255\d{9}$/.test(phone)) {
                phone = '0' + phone.substring(3);
            }
            if (!/^0\d{9}$/.test(phone)) {
                this.errorMessage = 'Please enter a valid phone number (format: 07XXXXXXXX).';
                this.showError = true;
                return;
            }
            this.loading = true;
            fetch('/api/payments/mobile_money_tanzania', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    order_id: uuidv4(),
                    buyer_email: '{{ auth()->user()->email ?? '' }}',
                    buyer_name: '{{ auth()->user()->name ?? '' }}',
                    buyer_phone: phone,
                    amount: this.amount
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data && data.status === 'success') {
                    this.showSuccess = true;
                } else {
                    this.errorMessage = data.message || data.error || 'Contribution initiation failed.';
                    this.showError = true;
                }
            })
            .catch(() => {
                this.errorMessage = 'Something went wrong. Try again.';
                this.showError = true;
            })
            .finally(() => this.loading = false);
        },
        resetForm() {
            this.amount = '';
            this.phone = '';
            this.showSuccess = false;
        }
    }
}
</script>
@endpush

@push('styles')
<style>
  /* Your styles here or keep the styles from your original */
</style>
@endpush
