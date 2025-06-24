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
      <!-- ClickPesa Branding -->
      <div class="mb-4 flex items-center justify-center sm:justify-start gap-2">
        <img src="/images/clickpesa.jpeg" alt="ClickPesa Logo" class="h-6 sm:h-8">
        <span class="text-blue-700 font-semibold text-sm sm:text-base">Secured by ClickPesa</span>
      </div>
      
      <form id="contributionForm">
        @csrf
        <!-- Amount Input -->
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

        <!-- Phone Input -->
        <div class="mb-6">
          <label for="phone" class="block text-gray-700 text-sm font-medium mb-2">Mobile Number</label>
          <div class="relative">
            <input type="tel" 
                   id="phone" 
                   name="phone" 
                   class="w-full pl-4 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-base" 
                   pattern="0\d{9}|255\d{9}" 
                   placeholder="0693662424 or 255693662424" 
                   title="Enter 10 digits starting with 0 or 12 digits starting with 255" 
                   required>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm mt-1">Formats: 0693662424 (10 digits) or 255693662424 (12 digits)</p>
        </div>

        @auth
        <input type="hidden" name="buyer_email" value="{{ auth()->user()->email }}">
        <input type="hidden" name="buyer_name" value="{{ auth()->user()->name }}">
        @endauth

        <button type="button" 
                id="proceedToPaymentBtn" 
                class="w-full bg-indigo-600 text-white py-3 sm:py-4 rounded-lg font-medium hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-colors text-base">
          Proceed to Payment
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Payment Confirmation Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" role="dialog" aria-modal="true">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 sm:mx-0">
    <div class="p-4 sm:p-6">
      <div class="flex justify-between items-center mb-4 sm:mb-6">
        <h3 class="text-lg sm:text-xl font-semibold">Confirm Payment</h3>
        <button id="closePaymentModal" class="text-gray-500 hover:text-gray-700 p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      
      <div class="space-y-4">
        <div class="bg-gray-50 p-3 sm:p-4 rounded-md mb-4">
          <div class="flex justify-between items-center">
            <span class="text-gray-700 text-sm sm:text-base">Amount:</span>
            <span class="font-semibold text-sm sm:text-base" id="summaryAmount">-</span>
          </div>
          <div class="flex justify-between items-center mt-2">
            <span class="text-gray-700 text-sm sm:text-base">Mobile Number:</span>
            <span class="font-semibold text-sm sm:text-base" id="summaryPhone">-</span>
          </div>
        </div>
        
        <div class="bg-blue-50 p-3 rounded text-blue-800 text-xs sm:text-sm flex items-start gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
          </svg>
          <span>You will receive a payment prompt on your phone. Enter your mobile money PIN to complete the payment.</span>
        </div>
        
        <button type="button" 
                id="confirmPaymentBtn"
                class="w-full bg-green-600 text-white py-3 sm:py-4 rounded-lg font-medium hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-colors relative text-base">
          <span class="btn-text">Confirm Mobile Money Payment</span>
          <svg class="animate-spin h-5 w-5 text-white absolute right-4 top-3 sm:top-4 hidden" 
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
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 sm:mx-0">
    <div class="p-4 sm:p-6 text-center">
      <div class="my-4 sm:my-6">
        <svg class="animate-spin h-10 w-10 sm:h-12 sm:w-12 text-indigo-600 mx-auto" 
             xmlns="http://www.w3.org/2000/svg" 
             fill="none" 
             viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>
      
      <h3 class="text-lg sm:text-xl font-semibold mb-2">Waiting for Payment</h3>
      <p class="text-gray-600 mb-4 text-sm sm:text-base">Please check your mobile device to complete the payment</p>
      
      <div class="bg-blue-50 p-3 sm:p-4 rounded-md mb-4 text-left">
        <h4 class="font-medium text-blue-800 mb-2 text-sm sm:text-base">Instructions:</h4>
        <ol class="list-decimal pl-4 sm:pl-5 text-blue-800 text-xs sm:text-sm space-y-1">
          <li>You will receive a payment request on your phone</li>
          <li>Enter your PIN to authorize the payment</li>
          <li>Wait for the confirmation message</li>
        </ol>
      </div>
      
      <div id="statusDetails" class="bg-gray-50 p-3 sm:p-4 rounded-md text-sm text-left hidden">
        <div class="grid grid-cols-2 gap-y-2">
          <div class="font-medium">Status:</div>
          <div id="currentStatus">Pending</div>
        </div>
      </div>
      
      <button id="cancelPaymentBtn" 
              class="mt-4 px-4 py-2 sm:px-6 sm:py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:ring-4 focus:ring-gray-200 transition-colors text-sm sm:text-base">
        Cancel Payment
      </button>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" role="dialog" aria-modal="true">
  <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 sm:mx-0">
    <div class="p-4 sm:p-6 text-center">
      <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      
      <h3 class="text-lg sm:text-xl font-semibold mb-2 text-green-600">Payment Successful!</h3>
      <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Your contribution has been received successfully.</p>
      
      <button onclick="location.reload()" 
              class="px-4 py-2 sm:px-6 sm:py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-colors text-sm sm:text-base">
        Make Another Contribution
      </button>
    </div>
  </div>
</div>

@endsection

@section('js-vars')
<script>
  // Use the full API base URL, trimming trailing slashes
  window.backendBaseUrl = "{{ rtrim(config('app.url'), '/') }}";
</script>
@endsection

@section('js-vars')
<script>
  window.backendBaseUrl = "{{ config('app.url') }}";
</script>
@endsection

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    const rawPhone = document.getElementById('phone').value;
    const phone = formatPhoneNumber(rawPhone); // always send 255 format
    const reference = 'ORDER-' + Date.now();
    const buyer_email = document.querySelector('[name="buyer_email"]')?.value || (window.userEmail || 'customer@example.com');
    const buyer_name = document.querySelector('[name="buyer_name"]')?.value || (window.userName || 'Member');

    // Clear previous errors
    document.getElementById('messageContainer').innerHTML = '';

    // Validation
    let errorMsg = '';
    if (!amount || isNaN(amount) || amount < 1000 || amount > 3000000) {
      errorMsg += '<div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm" role="alert">Please enter a valid amount between 1,000 and 3,000,000 TZS.</div>';
    }
    if (!rawPhone || !phone || !isValidPhoneNumber(phone)) {
      errorMsg += '<div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded mb-4 text-sm" role="alert">Please enter a valid phone number (10 digits starting with 0 or 12 digits starting with 255).</div>';
    }
    if (errorMsg) {
      document.getElementById('messageContainer').innerHTML = errorMsg;
      return;
    }

    try {
      // Use correct API URL for XAMPP/Apache
      const apiUrl = '/jumuiyakiganjani/api/clickpesa/ussd-push';
      const response = await fetch(apiUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
          phoneNumber: phone,
          amount: amount,
          orderReference: reference,
          buyer_email: buyer_email,
          buyer_name: buyer_name,
        })
      });
      const data = await response.json();
      if (response.ok && data.status === 'success') {
        // Show confirmation modal with details
        document.getElementById('summaryAmount').textContent = formatCurrency(amount) + ' TZS';
        document.getElementById('summaryPhone').textContent = formatPhoneForDisplay(phone);
        paymentModal.classList.remove('hidden');
        paymentModal.classList.add('flex');
        // Store reference for status checking
        currentReference = data.order_id;
      } else {
        showError(data.message || 'Failed to initiate payment. Please try again.');
      }
    } catch (error) {
      showError('An error occurred. Please try again.');
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
    
    // Clear previous errors
    document.getElementById('messageContainer').innerHTML = '';

    // Show loading state
    const btnText = confirmBtn.querySelector('.btn-text');
    const spinner = confirmBtn.querySelector('svg');
    btnText.textContent = 'Processing...';
    spinner.classList.remove('hidden');
    confirmBtn.disabled = true;

    try {
      // Hide payment modal, show pending modal
      paymentModal.classList.add('hidden');
      pendingModal.classList.remove('hidden');
      pendingModal.classList.add('flex');
      
      // Start polling for payment status
      startPaymentStatusCheck(currentReference);
      
    } catch (error) {
      console.error('Payment Error:', error);
      showError(error.message);
    } finally {
      // Reset button state
      btnText.textContent = 'Confirm Mobile Money Payment';
      spinner.classList.add('hidden');
      confirmBtn.disabled = false;
    }
  });

  function startPaymentStatusCheck(reference) {
    if (paymentCheckInterval) clearInterval(paymentCheckInterval);
    
    paymentCheckInterval = setInterval(async () => {
      try {
        const response = await fetch(`/api/payment/status/${reference}`);
        const data = await response.json();
        
        if (data.status === 'completed') {
          // Payment successful
          clearInterval(paymentCheckInterval);
          pendingModal.classList.add('hidden');
          successModal.classList.remove('hidden');
          successModal.classList.add('flex');
        } else if (data.status === 'failed') {
          // Payment failed
          clearInterval(paymentCheckInterval);
          pendingModal.classList.add('hidden');
          showError('Payment failed. Please try again.');
        } else {
          // Update status in modal
          document.getElementById('currentStatus').textContent = 
            data.status.charAt(0).toUpperCase() + data.status.slice(1);
          document.getElementById('statusDetails').classList.remove('hidden');
        }
      } catch (error) {
        console.error('Status check error:', error);
      }
    }, 3000);
  }

  function formatCurrency(amount) {
    return parseFloat(amount).toLocaleString('en-US');
  }
  
  function formatPhoneForDisplay(phone) {
    if (phone.startsWith('255') && phone.length === 12) {
      return '0' + phone.substring(3);
    }
    return phone;
  }

  function showError(message) {
    const container = document.getElementById('messageContainer');
    container.innerHTML = `
      <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 sm:px-4 rounded mb-4 text-sm" role="alert">
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

  // Prevent zoom on iOS when focusing inputs
  if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
    document.querySelectorAll('input[type="number"], input[type="tel"]').forEach(input => {
      input.addEventListener('focus', function() {
        this.style.fontSize = '16px';
      });
      input.addEventListener('blur', function() {
        this.style.fontSize = '';
      });
    });
  }
});
</script>
@endpush

@push('styles')
<style>
  .animate-spin {
    animation: spin 1s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  .hidden {
    display: none;
  }
  
  .flex {
    display: flex;
  }

  /* Enhanced mobile styling */
  @media (max-width: 640px) {
    body {
      font-size: 14px;
    }
    
    input[type="number"], input[type="tel"] {
      font-size: 16px !important; /* Prevents zoom on iOS */
    }
    
    .modal-content {
      margin: 1rem;
      max-height: calc(100vh - 2rem);
      overflow-y: auto;
    }
  }

  /* Focus styles for better accessibility */
  input:focus, button:focus {
    outline: none;
  }
  
  /* Improve touch targets on mobile */
  @media (max-width: 640px) {
    button {
      min-height: 44px;
    }
    
    input {
      min-height: 44px;
    }
  }
</style>
@endpush