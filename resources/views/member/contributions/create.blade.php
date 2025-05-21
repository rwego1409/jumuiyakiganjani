@extends('layouts.member')

@section('content')
<div class="py-6">
  <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold">Make a Contribution via PalmPesa</h2>

    @if ($errors->any())
      <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div class="bg-green-500 text-white p-4 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('member.contributions.store') }}" method="POST" class="mt-4 space-y-4" id="contributionForm">
      @csrf

      <div>
        <label for="jumuiya_id" class="block text-sm font-medium text-gray-700">Select Jumuiya</label>
        <select name="jumuiya_id" id="jumuiya_id" class="form-select w-full mt-1 border-gray-300 rounded-md" required>
          <option value="">-- Select Jumuiya --</option>
          @foreach($jumuiyas as $jumuiya)
            <option value="{{ $jumuiya->id }}" {{ old('jumuiya_id') == $jumuiya->id ? 'selected' : '' }}>
              {{ $jumuiya->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (TZS)</label>
        <input type="number" name="amount" id="amount" 
          class="form-input w-full mt-1 border-gray-300 rounded-md" 
          min="1000" max="3000000" 
          value="{{ old('amount') }}"
          required>
        <p class="text-sm text-gray-500 mt-1">Min: 1,000 TZS | Max: 3,000,000 TZS</p>
      </div>

      <div>
        <label for="contribution_date" class="block text-sm font-medium text-gray-700">Date</label>
        <input type="date" name="contribution_date" id="contribution_date"
          class="form-input w-full mt-1 border-gray-300 rounded-md"
          value="{{ old('contribution_date', now()->toDateString()) }}"
          required>
      </div>

      <div class="pt-2">
        <div class="flex justify-center">
          <img src="{{ asset('images/palm-pesa.png') }}" alt="PalmPesa" class="h-16">
        </div>
        <p class="text-center text-sm text-gray-500 mt-2">
          You will be prompted to enter your PalmPesa PIN on your phone
        </p>
      </div>

      <button type="button" id="proceedPayment"
        class="w-full bg-indigo-600 text-white px-4 py-3 rounded-md hover:bg-indigo-700 font-medium">
        Proceed to Payment
      </button>
    </form>
  </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <div class="flex justify-center mb-4">
      <img src="{{ asset('images/palm-pesa.png') }}" alt="PalmPesa" class="h-14">
    </div>

    <div class="text-center mb-6">
      <h3 class="text-lg font-medium">Confirm PalmPesa Payment</h3>
      <p class="text-sm text-gray-500">Enter your details to proceed</p>
    </div>

    <form id="paymentForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Amount (TZS)</label>
        <input type="text" id="modalAmount" class="form-input w-full mt-1 border-gray-300 rounded-md text-center font-bold text-lg" readonly>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="fullName" class="form-input w-full mt-1 border-gray-300 rounded-md" 
          value="{{ auth()->user()->name }}" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
        <div class="flex items-center mt-1">
          <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
            +255
          </span>
          <input type="text" id="phoneNumber" class="form-input flex-1 rounded-none rounded-r-md" 
            placeholder="xxxxxxxxx" 
            value="{{ substr(auth()->user()->phone, 3) ?? '' }}"
            required>
        </div>
      </div>

      <button type="button" id="confirmPayment" class="w-full bg-green-600 text-white py-3 rounded-md font-medium hover:bg-green-700 mt-4">
        CONFIRM PAYMENT
      </button>
    </form>
  </div>
</div>

<!-- Payment Processing Modal -->
<div id="processingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 text-center">
    <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-green-500 mx-auto mb-4"></div>
    <h3 class="text-lg font-medium mb-2">Processing Payment</h3>
    <p class="text-gray-600 mb-4">Please wait while we process your payment</p>
    <p class="text-sm text-gray-500">You may receive a PIN prompt on your phone</p>
  </div>
</div>

<!-- Payment Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 text-center">
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
      <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <h3 class="text-lg font-medium mb-2">Payment Successful!</h3>
    <p class="text-gray-600 mb-4" id="successMessage">Your contribution has been received</p>
    <button id="closeSuccessModal" class="w-full bg-green-600 text-white py-2 rounded-md font-medium hover:bg-green-700">
      Continue
    </button>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Elements
  const proceedPaymentBtn = document.getElementById('proceedPayment');
  const paymentModal = document.getElementById('paymentModal');
  const processingModal = document.getElementById('processingModal');
  const successModal = document.getElementById('successModal');
  const closeModal = document.getElementById('closeModal');
  const closeSuccessModal = document.getElementById('closeSuccessModal');
  const confirmPayment = document.getElementById('confirmPayment');
  const modalAmount = document.getElementById('modalAmount');
  const contributionForm = document.getElementById('contributionForm');

  // Open payment modal
  proceedPaymentBtn.addEventListener('click', function () {
    const amount = document.getElementById('amount').value;
    const jumuiya = document.getElementById('jumuiya_id').value;

    // Validate inputs
    if (!jumuiya) {
      alert('Please select your Jumuiya');
      return;
    }

    if (!amount || amount < 1000 || amount > 3000000) {
      alert('Please enter a valid amount between 1,000 and 3,000,000 TZS');
      return;
    }

    // Format amount with commas
    modalAmount.value = parseFloat(amount).toLocaleString('en-US') + ' TZS';
    paymentModal.classList.remove('hidden');
  });

  // Close modals
  closeModal.addEventListener('click', function () {
    paymentModal.classList.add('hidden');
  });

  closeSuccessModal.addEventListener('click', function () {
    successModal.classList.add('hidden');
    window.location.reload();
  });

  // Format phone number input
  document.getElementById('phoneNumber').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').substring(0, 9);
  });

  // Confirm payment
  confirmPayment.addEventListener('click', async function () {
    const fullName = document.getElementById('fullName').value;
    const phoneNumber = '255' + document.getElementById('phoneNumber').value;
    const amount = document.getElementById('amount').value;

    // Validate inputs
    if (!fullName) {
      alert('Please enter your full name');
      return;
    }
    
    if (phoneNumber.length !== 12) {
      alert('Please enter a valid phone number (9 digits after 255)');
      return;
    }

    // Show processing modal
    paymentModal.classList.add('hidden');
    processingModal.classList.remove('hidden');

    try {
      const payload = {
        name: fullName,
        phone: phoneNumber,
        amount: parseFloat(amount),
        transaction_id: 'TXN' + Date.now(),
        user_id: {{ auth()->id() }},
        email: '{{ auth()->user()->email }}',
        address: '{{ auth()->user()->address ?? "Not specified" }}',
        postcode: '{{ auth()->user()->postcode ?? "00000" }}',
        buyer_uuid: {{ auth()->id() }},
        jumuiya_id: document.getElementById('jumuiya_id').value,
        contribution_date: document.getElementById('contribution_date').value
      };

      const response = await fetch('{{ route("make-payment") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      processingModal.classList.add('hidden');

      if (data.success) {
        document.getElementById('successMessage').textContent = data.message || 'Your contribution has been received';
        successModal.classList.remove('hidden');
        
        // Optionally submit the form if needed
        contributionForm.submit();
      } else {
        throw new Error(data.message || 'Payment initiation failed');
      }
    } catch (error) {
      processingModal.classList.add('hidden');
      alert('Payment Error: ' + error.message);
      paymentModal.classList.remove('hidden');
    }
  });
});
</script>
@endpush