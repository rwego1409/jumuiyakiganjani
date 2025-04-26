@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Make a Payment</h2>

        <form id="payment-form">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium mb-2">Amount (Min 1,000 TZS / Max 3,000,000 TZS)</label>
                <input type="number" name="amount" id="amount" 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       min="1000" max="3000000" required>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">First Name and Surname</label>
                <input type="text" name="name" id="name" 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="tel" name="phone" id="phone" 
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       pattern="^2557\d{8}$" placeholder="2557XXXXXXXX" required>
            </div>

            <div class="mt-6">
                <button type="button" id="confirm-payment" 
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-200">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('confirm-payment').addEventListener('click', async function () {
        const button = this;
        const form = document.getElementById('payment-form');
        const formData = new FormData(form);

        const amount = formData.get('amount');
        const name = formData.get('name');
        const phone = formData.get('phone');

        if (!amount || !name || !phone) {
            alert('Please fill all fields');
            return;
        }

        if (amount < 1000 || amount > 3000000) {
            alert('Amount must be between 1,000 and 3,000,000 TZS');
            return;
        }

        button.innerHTML = `<svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
            <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg> Processing...`;
        button.disabled = true;

        // Choose API route based on phone prefix
        const method = phone.startsWith('25574') ? 'clickpesa' : 'mpesa';
        const url = (method === 'mpesa') ? '/mpesa/payment' : '/clickpesa/payment';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    phone: phone,
                    amount: amount,
                })
            });

            const data = await response.json();

            if (data.ResponseCode === '0') {
                const checkoutRequestId = data.checkoutRequestId;
                checkStatus(checkoutRequestId);
            } else {
                alert(data.ResponseDescription || 'Payment initiation failed.');
                resetBtn();
            }

        } catch (error) {
            alert('Something went wrong. Try again.');
            resetBtn();
        }

        function resetBtn() {
            button.disabled = false;
            button.innerHTML = 'Confirm';
        }

        function checkStatus(checkoutRequestId) {
            fetch(`/api/payment/status/${checkoutRequestId}`)
                .then(res => res.json())
                .then(status => {
                    if (status.success) {
                        alert('Payment successful!');
                        form.reset();
                    } else {
                        alert('Payment not completed.');
                    }
                    resetBtn();
                })
                .catch(() => {
                    alert('Error checking status.');
                    resetBtn();
                });
        }
    });
</script>
@endpush
@endsection
