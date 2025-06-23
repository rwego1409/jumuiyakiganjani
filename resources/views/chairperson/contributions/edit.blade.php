@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Edit Contribution') }}</h2>
            </div>
            <form action="{{ route('chairperson.contributions.update', $contribution->id) }}" method="POST" class="max-w-2xl">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Member Selection -->
                    <div>
                        <label for="member_id" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Member') }}
                        </label>
                        <select id="member_id" name="member_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="">Select a member</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id', $contribution->member_id) == $member->id ? 'selected' : '' }}>
                                    {{ $member->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Amount (TZS)') }}
                        </label>
                        <input type="number" name="amount" id="amount" min="1" step="1" value="{{ old('amount', $contribution->amount) }}" required
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Contribution Date -->
                    <div>
                        <label for="contribution_date" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Contribution Date') }}
                        </label>
                        <input type="date" name="contribution_date" id="contribution_date" value="{{ old('contribution_date', $contribution->contribution_date->format('Y-m-d')) }}" required
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('contribution_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Payment Method') }}
                        </label>
                        <select id="payment_method" name="payment_method" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="cash" {{ old('payment_method', $contribution->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="mobile" {{ old('payment_method', $contribution->payment_method) == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="bank" {{ old('payment_method', $contribution->payment_method) == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Purpose -->
                    <div>
                        <label for="purpose" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Purpose (Optional)') }}
                        </label>
                        <input type="text" name="purpose" id="purpose" value="{{ old('purpose', $contribution->purpose) }}"
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('purpose')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Status') }}
                        </label>
                        <select id="status" name="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="pending" {{ old('status', $contribution->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $contribution->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="rejected" {{ old('status', $contribution->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('chairperson.contributions.index') }}" class="mr-3 text-sm text-pink-700 hover:text-pink-900 dark:text-pink-200 dark:hover:text-pink-100">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-600 to-purple-500 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest shadow hover:from-pink-700 hover:to-purple-600">
                            {{ __('Update Contribution') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Cashbook Ledger Table (Read-only) -->
        <div class="mt-10">
            <h3 class="text-lg font-bold mb-4 text-pink-700 dark:text-pink-200">Member Cashbook Ledger</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-pink-900/40 rounded-xl shadow">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Amount (TZS)</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Purpose</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $balance = 0; @endphp
                        @foreach($cashbook as $entry)
                            @php $balance += $entry->amount; @endphp
                            <tr class="border-b border-pink-100 dark:border-pink-800">
                                <td class="px-4 py-2">{{ $entry->contribution_date ? $entry->contribution_date->format('Y-m-d') : '' }}</td>
                                <td class="px-4 py-2">{{ number_format($entry->amount) }}</td>
                                <td class="px-4 py-2">{{ ucfirst($entry->payment_method ?? 'N/A') }}</td>
                                <td class="px-4 py-2">{{ ucfirst($entry->status) }}</td>
                                <td class="px-4 py-2">{{ $entry->purpose }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                <em>Note: Contributions are read-only to prevent fraud. For corrections, please contact the system administrator.</em>
            </div>
        </div>
    </div>
</div>
@endsection
