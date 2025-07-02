@extends('layouts.member')

@section('content')
<div class="py-6" x-data="zenoPayFlow()">
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
    <!-- Error Modal -->
    <div x-show="showError" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold mb-2">Payment Failed</h2>
            <p class="mb-4" x-text="errorMessage"></p>
            <button @click="showError=false" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function uuidv4() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}
function zenoPayFlow() {
    return {
        amount: '',
        name: '',
        phone: '',
        loading: false,
        showSuccess: false,
        showError: false,
        errorMessage: '',
        submitPayment() {
            if (!this.amount || !this.name || !this.phone) {
                this.errorMessage = 'Please fill all fields';
                this.showError = true;
                return;
            }
            if (this.amount < 1000 || this.amount > 3000000) {
                this.errorMessage = 'Amount must be between 1,000 and 3,000,000 TZS';
                this.showError = true;
                return;
            }
            // Format phone to 255XXXXXXXXX
            let phone = this.phone.trim();
            if (/^0\d{9}$/.test(phone)) {
                phone = '255' + phone.substring(1);
            }
            if (!/^2557\d{8}$/.test(phone) && !/^255\d{9}$/.test(phone)) {
                this.errorMessage = 'Please enter a valid phone number (10 digits starting with 0 or 12 digits starting with 255).';
                this.showError = true;
                return;
            }
            this.loading = true;
            fetch('/api/payments/initiate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    order_id: uuidv4(),
                    buyer_email: '{{ auth()->user()->email ?? '' }}',
                    buyer_name: this.name,
                    buyer_phone: phone,
                    amount: this.amount
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data && (data.status === 'success' || data.payment_status === 'PENDING' || data.payment_status === 'COMPLETED')) {
                    this.showSuccess = true;
                } else {
                    this.errorMessage = data.message || data.error || 'Payment initiation failed.';
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
            this.name = '';
            this.phone = '';
            this.showSuccess = false;
        }
    }
}
</script>
@endpush
@endsection
