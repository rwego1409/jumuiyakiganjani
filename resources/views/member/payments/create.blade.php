@extends('layouts.member')

@section('content')
<div class="py-6" x-data="paymentFlow()">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Make a Payment</h2>

        <form id="payment-form" @submit.prevent="submitPayment">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium mb-2">Amount (Min 1,000 TZS / Max 3,000,000 TZS)</label>
                <input type="number" name="amount" id="amount" x-model="amount"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       min="1000" max="3000000" required>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">First Name and Surname</label>
                <input type="text" name="name" id="name" x-model="name"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="tel" name="phone" id="phone" x-model="phone"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       pattern="^2557\d{8}$" placeholder="2557XXXXXXXX" required>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-200"
                        x-bind:disabled="loading">
                    <template x-if="!loading">Confirm</template>
                    <template x-if="loading">
                        <svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                            <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg> Processing...
                    </template>
                </button>
            </div>
        </form>
    </div>

    <!-- Mock STK Push Modal -->
    <div x-show="showStkModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <h3 class="text-lg font-semibold mb-4 text-center">Mock STK Push</h3>
            <p class="mb-2 text-gray-700 text-center">Enter your <span class="font-bold">Secret Key</span> to complete payment:</p>
            <input type="password" x-model="secretKey" class="w-full p-2 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Secret Key">
            <div class="flex justify-between">
                <button @click="showStkModal=false" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</button>
                <button @click="submitSecretKey" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700" x-bind:disabled="stkLoading">
                    <template x-if="!stkLoading">Submit</template>
                    <template x-if="stkLoading">
                        <svg class="animate-spin h-5 w-5 inline text-white mr-2" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                            <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg> Processing...
                    </template>
                </button>
            </div>
        </div>
    </div>

    <!-- Success Confirmation -->
    <div x-show="showSuccess" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold mb-2">Payment Successful!</h2>
            <p class="mb-4">Your payment has been processed successfully.</p>
            <button @click="resetForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Make Another Payment</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function paymentFlow() {
    return {
        amount: '',
        name: '',
        phone: '',
        secretKey: '',
        loading: false,
        stkLoading: false,
        showStkModal: false,
        showSuccess: false,
        paymentData: {},
        submitPayment() {
            if (!this.amount || !this.name || !this.phone) {
                alert('Please fill all fields');
                return;
            }
            if (this.amount < 1000 || this.amount > 3000000) {
                alert('Amount must be between 1,000 and 3,000,000 TZS');
                return;
            }
            // Format phone to 255XXXXXXXXX
            let phone = this.phone.trim();
            if (/^0\d{9}$/.test(phone)) {
                phone = '255' + phone.substring(1);
            }
            if (!/^255\d{9}$/.test(phone)) {
                alert('Please enter a valid phone number (10 digits starting with 0 or 12 digits starting with 255).');
                return;
            }
            this.loading = true;
            const method = phone.startsWith('25574') ? 'clickpesa' : 'mpesa';
            const url = (method === 'mpesa') ? '/mpesa/payment' : '/clickpesa/payment';
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: this.name,
                    phone: phone,
                    amount: this.amount,
                    email: '{{ auth()->user()->email ?? '' }}',
                })
            })
            .then(res => res.json())
            .then(data => {
                if (method === 'clickpesa' && data.mockStkPush) {
                    this.paymentData = data;
                    this.showStkModal = true;
                } else if (data.ResponseCode === '0') {
                    this.showSuccess = true;
                } else {
                    alert(data.ResponseDescription || 'Payment initiation failed.');
                }
            })
            .catch(() => alert('Something went wrong. Try again.'))
            .finally(() => this.loading = false);
        },
        submitSecretKey() {
            if (!this.secretKey) {
                alert('Please enter your secret key.');
                return;
            }
            this.stkLoading = true;
            // Simulate secret key verification and payment success
            setTimeout(() => {
                this.showStkModal = false;
                this.showSuccess = true;
                this.stkLoading = false;
            }, 1200);
        },
        resetForm() {
            this.amount = '';
            this.name = '';
            this.phone = '';
            this.secretKey = '';
            this.showSuccess = false;
        }
    }
}
</script>
@endpush
@endsection
