@extends('layouts.member')

@section('content')
<div class="py-6">
  <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold">Make a Contribution</h2>

    @if ($errors->any())
      <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('member.contributions.store') }}" method="POST" class="mt-4 space-y-4" id="contributionForm">
      @csrf

      <div>
        <label for="jumuiya_id" class="block text-sm font-medium text-gray-700">Select Jumuiya</label>
        <select name="jumuiya_id" id="jumuiya_id" class="form-select w-full mt-1 border-gray-300 rounded-md">
          @foreach($jumuiyas as $jumuiya)
            <option value="{{ $jumuiya->id }}">{{ $jumuiya->name }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">Amount (TZS)</label>
        <input type="number" name="amount" id="amount" 
          class="form-input w-full mt-1 border-gray-300 rounded-md" 
          min="1000" max="3000000"
          required>
        <p class="text-sm text-gray-500 mt-1">Min: 1,000 TZS | Max: 3,000,000 TZS</p>
      </div>

      <div>
        <label for="contribution_date" class="block text-sm font-medium text-gray-700">Date</label>
        <input type="date" name="contribution_date" id="contribution_date"
          class="form-input w-full mt-1 border-gray-300 rounded-md"
          value="{{ now()->toDateString() }}">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
        <div class="mt-2 grid grid-cols-4 gap-2">
          @foreach(['vodacom', 'airtel', 'tigo', 'halotel'] as $method)
            <div class="flex items-center justify-center p-2 border rounded cursor-pointer payment-option hover:scale-105 transition-transform" data-method="{{ $method }}">
              <img src="{{ asset("images/$method.png") }}" alt="{{ ucfirst($method) }}" class="h-10">
            </div>
          @endforeach
        </div>
        <input type="hidden" name="payment_method" id="payment_method">
      </div>

      <button type="button" id="proceedPayment"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
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

    <div class="flex justify-center mb-6">
      <img src="" alt="Payment Logo" class="h-12" id="modalLogo">
    </div>

    <form id="paymentForm" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Amount</label>
        <input type="text" id="modalAmount" class="form-input w-full mt-1 border-gray-300 rounded-md" readonly>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="fullName" class="form-input w-full mt-1 border-gray-300 rounded-md" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="text" id="phoneNumber" class="form-input w-full mt-1 border-gray-300 rounded-md" placeholder="255xxxxxxxxx" required>
      </div>

      <button type="button" id="confirmPayment" class="w-full bg-red-500 text-white py-3 rounded font-medium hover:bg-red-600">
        CONFIRM
      </button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const paymentOptions = document.querySelectorAll('.payment-option');
  const paymentMethodInput = document.getElementById('payment_method');
  const proceedPaymentBtn = document.getElementById('proceedPayment');
  const paymentModal = document.getElementById('paymentModal');
  const closeModal = document.getElementById('closeModal');
  const confirmPayment = document.getElementById('confirmPayment');
  const modalAmount = document.getElementById('modalAmount');
  const modalLogo = document.getElementById('modalLogo');
  const contributionForm = document.getElementById('contributionForm');

  paymentOptions.forEach(option => {
    option.addEventListener('click', function () {
      paymentOptions.forEach(opt => opt.classList.remove('border-indigo-500', 'border-2'));
      this.classList.add('border-indigo-500', 'border-2');
      const selectedMethod = this.dataset.method;
      paymentMethodInput.value = selectedMethod;
    });
  });

  proceedPaymentBtn.addEventListener('click', function () {
    const amount = document.getElementById('amount').value;
    const paymentMethod = paymentMethodInput.value;

    if (!amount || !paymentMethod) {
      alert('Please enter amount and select a payment method');
      return;
    }

    if (amount < 1000 || amount > 3000000) {
      alert('Amount must be between 1,000 and 3,000,000 TZS');
      return;
    }

    modalAmount.value = parseFloat(amount).toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });

    modalLogo.src = `/images/${paymentMethod}.png`;
    modalLogo.alt = paymentMethod.toUpperCase();

    paymentModal.classList.remove('hidden');
  });

  closeModal.addEventListener('click', function () {
    paymentModal.classList.add('hidden');
  });

  document.getElementById('phoneNumber').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (!value.startsWith('255')) value = '255' + value;
    e.target.value = value.substring(0, 12);
  });

  confirmPayment.addEventListener('click', async function () {
    const fullName = document.getElementById('fullName').value;
    const phoneNumber = document.getElementById('phoneNumber').value;
    const amount = document.getElementById('amount').value;
    const paymentMethod = paymentMethodInput.value;

    if (!fullName || !phoneNumber || !amount || !paymentMethod) {
      alert('All fields are required');
      return;
    }

    confirmPayment.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg> Initiating Payment...`;
    confirmPayment.disabled = true;

    try {
      const payload = {
        name: fullName,
        phone: phoneNumber,
        amount: amount,
        method: paymentMethod
      };

      const url = (paymentMethod === 'vodacom') ? '/mpesa/payment' : '/clickpesa/payment';

      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (data.ResponseCode === '0') {
        const checkoutRequestId = data.checkoutRequestId;
        checkPaymentStatus(checkoutRequestId);
      } else {
        throw new Error(data.ResponseDescription || 'Payment initiation failed');
      }

    } catch (error) {
      alert('Payment Error: ' + error.message);
      confirmPayment.innerHTML = 'CONFIRM';
      confirmPayment.disabled = false;
    }
  });

  function checkPaymentStatus(checkoutRequestId) {
    fetch(`/api/payment/status/${checkoutRequestId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          contributionForm.submit();
        } else {
          alert('Payment not completed. Try again.');
          window.location.reload();
        }
      })
      .catch(() => {
        alert('Error checking payment status');
        window.location.reload();
      });
  }
});
</script>
@endpush
