@extends('layouts.member')

@section('content')
<div class="py-6">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <h2 class="text-xl font-bold mb-4">Make Payment - {{ $course->name }}</h2>
            
            <form action="{{ route('member.courses.pay.store', $course) }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <!-- Amount Input -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Amount (TZS)</label>
                        <input type="number" name="amount" 
                               class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                               min="1000" 
                               max="{{ $course->target_amount - $contribution->paid_amount }}"
                               required>
                    </div>

                    <!-- Payment Method Selection -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Payment Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border rounded-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="mpesa" class="h-4 w-4 text-indigo-600" required>
                                <span class="ml-2">M-Pesa</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="airtel" class="h-4 w-4 text-indigo-600">
                                <span class="ml-2">Airtel Money</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="tigopesa" class="h-4 w-4 text-indigo-600">
                                <span class="ml-2">Tigo Pesa</span>
                            </label>
                            <label class="flex items-center p-3 border rounded-md has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-indigo-600">
                                <span class="ml-2">Cash</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition-colors">
                        Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection