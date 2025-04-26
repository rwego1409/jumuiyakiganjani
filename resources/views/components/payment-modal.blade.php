<div x-cloak x-show="showPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Make Payment</h3>
            <button @click="showPaymentModal = false" class="text-gray-500 hover:text-gray-700">
                ✕
            </button>
        </div>

        <form wire:submit.prevent="processPayment">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Amount (TZS)</label>
                    <input type="number" 
                           wire:model="paymentAmount"
                           class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Payment Method</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['mpesa' => 'M-Pesa', 'airtel' => 'Airtel Money', 'tigopesa' => 'Tigo Pesa', 'cash' => 'Cash'] as $value => $label)
                        <label class="flex items-center p-3 border rounded-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" 
                                   wire:model="paymentMethod" 
                                   value="{{ $value}}" 
                                   class="h-4 w-4 text-indigo-600">
                            <span class="ml-2">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition-colors">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>