@extends('layouts.member')

@section('content')
<div class="py-6">
  <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold mb-6">Make Contribution</h2>

    <!-- Progress Stepper -->
    <div class="mb-8">
      <div class="flex justify-between">
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center">1</div>
          <span class="text-xs mt-1">Details</span>
        </div>
        <div class="flex-1 h-0.5 bg-gray-300 self-center mx-2"></div>
        <div class="flex flex-col items-center">
          <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center">2</div>
          <span class="text-xs mt-1">Confirmation</span>
        </div>
      </div>
    </div>

    <!-- Messages Container -->
    <div id="messageContainer" aria-live="polite">
      @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <!-- Contribution Form -->
    <div class="bg-white p-6 rounded-lg shadow-md">
      <div class="zenopay-brand">
        <img src="https://zenoapi.com/logo.png" alt="ZenoPay Logo" class="zenopay-logo">
        <span class="text-green-700 font-semibold">Secured by ZenoPay</span>
      </div>
      <form id="contributionForm">
        @csrf

        <!-- Amount Input -->
        <div class="mb-6">
          <label for="amount" class="block text-gray-700 text-sm font-medium mb-2">Amount (TZS)</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">TZS</span>
            <input type="number" 
                  id="amount" 
                  name="amount"
                  class="w-full pl-12 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                  min="1000"
                  max="3000000"
                  required>
          </div>
          <p class="text-gray-500 text-sm mt-1">Minimum: 1,000 TZS | Maximum: 3,000,000 TZS</p>
        </div>

        <!-- Phone Input -->
        <div class="mb-6">
          <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Mobile Number</label>
          <div class="relative">
            <input type="tel" 
                  id="phone" 
                  name="phone"
                  class="w-full pl-4 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"
                  pattern="0\d{9}|255\d{9}"
                  placeholder="0693662424 or 255693662424"
                  title="Enter 10 digits starting with 0 or 12 digits starting with 255"
                  required>
          </div>
          <p class="text-gray-500 text-xs mt-1">Formats: 0693662424 (10 digits) or 255693662424 (12 digits)</p>
        </div>

        @auth
        <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">
        @endauth

        @if (isset($contributionId))
        <input type="hidden" 
               name="member_course_contribution_id" 
               value="{{ $contributionId }}">
        @endif

        <button type="button"
                id="proceedToPaymentBtn"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
          Proceed to Payment
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Payment Confirmation Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" role="dialog" aria-modal="true">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold">Confirm Payment</h3>
        <button id="closePaymentModal" class="text-gray-500 hover:text-gray-700">
          ✕
        </button>
      </div>
      <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-md mb-4">
          <div class="flex justify-between">
            <span class="text-gray-700">Amount:</span>
            <span class="font-semibold" id="summaryAmount">-</span>
          </div>
          <div class="flex justify-between mt-2">
            <span class="text-gray-700">Mobile Number:</span>
            <span class="font-semibold" id="summaryPhone">-</span>
          </div>
        </div>
        <div class="bg-blue-50 p-3 rounded text-blue-800 text-sm flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
          You will receive a payment prompt on your phone. Enter your mobile money PIN to complete the payment.
        </div>
        <button type="button" 
                id="confirmPaymentBtn"
                class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition-colors relative">
          <span class="btn-text">Confirm Mobile Money Payment</span>
          <svg class="animate-spin h-5 w-5 text-white absolute right-4 top-3 hidden" 
               xmlns="http://www.w3.org/2000/svg" 
               fill="none" 
               viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Payment Pending Modal -->
<div id="pendingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" role="dialog" aria-modal="true">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
    <div class="p-6 text-center">
      <div class="my-6">
        <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto" 
             xmlns="http://www.w3.org/2000/svg" 
             fill="none" 
             viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>
      <h3 class="text-xl font-semibold mb-2">Waiting for Payment</h3>
      <p class="text-gray-600 mb-4">Please check your mobile device to complete the payment</p>
      <div class="bg-blue-50 p-4 rounded-md mb-4 text-left">
        <h4 class="font-medium text-blue-800 mb-2">Instructions:</h4>
        <ol class="list-decimal pl-5 text-blue-800 text-sm">
          <li>You will receive a payment request on your phone</li>
          <li>Enter your PIN to authorize the payment</li>
          <li>Wait for the confirmation message</li>
        </ol>
      </div>
      <div id="statusDetails" class="bg-gray-50 p-4 rounded-md text-sm text-left hidden">
        <div class="grid grid-cols-2 gap-y-2">
          <div class="font-medium">Status:</div>
          <div id="currentStatus">Pending</div>
        </div>
      </div>
      <button id="cancelPaymentBtn" 
              class="mt-4 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
          Cancel Payment
      </button>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" role="dialog" aria-modal="true">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
    <div class="p-6 text-center">
      <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h3 class="text-xl font-semibold mb-2 text-green-600">Payment Successful!</h3>
      <p class="text-gray-600 mb-6">Your contribution has been received successfully.</p>
      <button onclick="location.reload()" 
              class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
          Make Another Contribution
      </button>
    </div>
  </div>
</div>

@endsection

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const proceedBtn = document.getElementById('proceedToPaymentBtn');
  const confirmBtn = document.getElementById('confirmPaymentBtn');
  const cancelBtn = document.getElementById('cancelPaymentBtn');
  const amountInput = document.getElementById('amount');
  const phoneInput = document.getElementById('phone');
  const paymentModal = document.getElementById('paymentModal');
  const pendingModal = document.getElementById('pendingModal');
  const successModal = document.getElementById('successModal');
  const closePaymentModal = document.getElementById('closePaymentModal');
  let paymentCheckInterval = null;
  let currentReference = null;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  function formatPhoneNumber(input) {
    let numbers = input.replace(/\D/g, '');
    
    if (numbers.startsWith('0') && numbers.length === 10) {
      return '255' + numbers.substring(1);
    }
    
    if (numbers.startsWith('255') && numbers.length === 12) {
      return numbers;
    }
    
    return null;
  }

  function isValidPhoneNumber(phone) {
    return /^255\d{9}$/.test(phone);
  }

  document.getElementById('proceedToPaymentBtn').addEventListener('click', async function(e) {
    e.preventDefault();
    const amount = document.getElementById('amount').value;
    const phone = document.getElementById('phone').value;
    // You may want to get jumuiya_id and contribution_date from the form as well
    const reference = 'CONTRIB-' + Date.now();
    try {
      const response = await fetch('/zenopay/initiate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          phone: phone,
          amount: amount,
          reference: reference
        })
      });
      const data = await response.json();
      if (response.ok && data.status === 'success') {
        // Show payment modal or success
        // Optionally, start polling status using data.order_id
        startPaymentStatusCheck(data.order_id);
      } else {
        showError(data.message || 'Payment failed.');
      }
    } catch (error) {
      showError(error.message);
    }
  });

  closePaymentModal.addEventListener('click', () => {
    paymentModal.classList.add('hidden');
  });

  cancelBtn.addEventListener('click', () => {
    clearInterval(paymentCheckInterval);
    pendingModal.classList.add('hidden');
    paymentModal.classList.add('hidden');
  });

  confirmBtn.addEventListener('click', async function() {
    const amount = amountInput.value;
    const rawPhone = phoneInput.value;
    const formattedPhone = formatPhoneNumber(rawPhone);
    const contributionId = document.querySelector('[name="member_course_contribution_id"]')?.value;

    // Clear previous errors
    document.getElementById('messageContainer').innerHTML = '';

    // Show loading state
    confirmBtn.disabled = true;
    confirmBtn.querySelector('.btn-text').textContent = 'Processing...';
    confirmBtn.querySelector('svg').classList.remove('hidden');

    try {
      const response = await fetch("{{ route('payment.process') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          phone: formattedPhone,
          amount: amount,
          member_id: document.querySelector('[name="member_id"]').value,
          member_course_contribution_id: contributionId
        })
      });

      const data = await response.json();
      
      if (!response.ok) throw new Error(data.message || 'Server Error');
      
      if (data.pending) {
        // Payment requires user confirmation
        paymentModal.classList.add('hidden');
        pendingModal.classList.remove('hidden');
        pendingModal.classList.add('flex');
        currentReference = data.reference;
        startPaymentStatusCheck(currentReference);
      } else if (data.success) {
        // Immediate success
        paymentModal.classList.add('hidden');
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');
      } else {
        throw new Error(data.message || 'Payment Failed');
      }

    } catch (error) {
      console.error('Payment Error:', error);
      showError(error.message);
    } finally {
      confirmBtn.disabled = false;
      confirmBtn.querySelector('.btn-text').textContent = 'Confirm Mobile Money Payment';
      confirmBtn.querySelector('svg').classList.add('hidden');
    }
  });

  function startPaymentStatusCheck(reference) {
    if (paymentCheckInterval) clearInterval(paymentCheckInterval);
    paymentCheckInterval = setInterval(async () => {
      try {
        const response = await fetch(`/payment/status/${reference}`);
        const data = await response.json();
        if (data.status === 'completed') {
          clearInterval(paymentCheckInterval);
          pendingModal.classList.add('hidden');
          successModal.classList.remove('hidden');
          successModal.classList.add('flex');
        } else if (data.status === 'failed') {
          clearInterval(paymentCheckInterval);
          pendingModal.classList.add('hidden');
          showError('Payment failed. Please try again.');
        } else {
          // Update status in modal
          document.getElementById('currentStatus').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
        }
      } catch (error) {
        console.error('Status check error:', error);
      }
    }, 3000);
  }

  function showError(message) {
    const container = document.getElementById('messageContainer');
    container.innerHTML = `
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
        ${message}
      </div>
    `;
    paymentModal.classList.add('hidden');
    pendingModal.classList.add('hidden');
  }

  // Auto-format phone to 255XXXXXXXXX if user enters 0XXXXXXXXX
  document.getElementById('phone').addEventListener('blur', function(e) {
    let val = e.target.value.trim();
    if (/^0\d{9}$/.test(val)) {
      e.target.value = '255' + val.substring(1);
    }
  });
});
</script>
@endpush

@push('styles')
<style>
    .zenopay-brand {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .zenopay-logo {
        width: 32px;
        height: 32px;
    }
</style>
@endpush