@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-200/50 dark:border-blue-900/50 p-8">
            <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6">Edit Contribution</h1>
            <form method="POST" action="{{ route('admin.contributions.update', $contribution->id) }}">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label for="member_id" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Member</label>
                        <select name="member_id" id="member_id" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ $member->id == old('member_id', $contribution->member_id) ? 'selected' : '' }}>{{ $member->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="amount" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Amount (TZS)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $contribution->amount) }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="contribution_date" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Contribution Date</label>
                        <input type="date" name="contribution_date" id="contribution_date" value="{{ old('contribution_date', $contribution->contribution_date ? $contribution->contribution_date->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    </div>
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-blue-700 dark:text-blue-300">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-lg border border-blue-200 dark:border-blue-700 bg-white/80 dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                            <option value="cash" {{ old('payment_method', $contribution->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="mobile" {{ old('payment_method', $contribution->payment_method) == 'mobile' ? 'selected' : '' }}>Mobile Payment</option>
                            <option value="bank" {{ old('payment_method', $contribution->payment_method) == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-6 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Update Contribution
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection