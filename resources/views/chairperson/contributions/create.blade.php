@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-4 sm:py-8">
    <div class="w-full max-w-md sm:max-w-3xl mx-auto px-1 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-2 xs:p-3 sm:p-6 md:p-8">
            <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-center gap-1 sm:gap-3 justify-between w-full">
                <div class="flex items-center gap-2">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-pink-500 dark:text-pink-300 mb-1 sm:mb-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                    <h2 class="text-lg sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">{{ __('Record New Contribution') }}</h2>
                </div>
                <a href="{{ route('chairperson.contributions.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 border border-blue-200 dark:border-blue-700 rounded-lg text-blue-700 dark:text-blue-100 font-semibold text-xs sm:text-sm shadow hover:from-blue-200 hover:to-blue-400 dark:hover:from-blue-800 dark:hover:to-blue-600 transition mt-2 sm:mt-0">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to Contributions') }}
                </a>
            </div>
            <form action="{{ route('chairperson.contributions.store') }}" method="POST" class="w-full">
                @csrf
                <div class="space-y-3 sm:space-y-6">
                    <!-- Member Selection -->
                    <div>
                        <label for="member_id" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Member') }}
                        </label>
                        <select id="member_id" name="member_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-xs sm:text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="">Select a member</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Amount (TZS)') }}
                        </label>
                        <input type="number" name="amount" id="amount" min="1" step="1" value="{{ old('amount') }}" required
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm text-xs sm:text-base dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('amount')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Contribution Date -->
                    <div>
                        <label for="contribution_date" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Contribution Date') }}
                        </label>
                        <input type="date" name="contribution_date" id="contribution_date" value="{{ old('contribution_date', date('Y-m-d')) }}" required
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm text-xs sm:text-base dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('contribution_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Payment Method') }}
                        </label>
                        <select id="payment_method" name="payment_method" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-xs sm:text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Purpose -->
                    <div>
                        <label for="purpose" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Purpose (Optional)') }}
                        </label>
                        <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}"
                            class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm text-xs sm:text-base dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                        @error('purpose')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs sm:text-sm font-medium text-pink-700 dark:text-pink-200">
                            {{ __('Status') }}
                        </label>
                        <select id="status" name="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-xs sm:text-base border-pink-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 rounded-md dark:bg-pink-900/40 dark:border-pink-700 dark:text-pink-100">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-2 sm:gap-3 pt-2">
                        <a href="{{ route('chairperson.contributions.index') }}" class="w-full sm:w-auto text-xs sm:text-sm inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-100 to-blue-300 dark:from-blue-900 dark:to-blue-700 border border-blue-200 dark:border-blue-700 rounded-xl font-semibold text-xs sm:text-sm text-blue-700 dark:text-blue-100 uppercase tracking-widest shadow hover:from-blue-200 hover:to-blue-400 dark:hover:from-blue-800 dark:hover:to-blue-600 transition text-center">
                            <i class="fas fa-arrow-left mr-2"></i> {{ __('Back') }}
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-700 border border-transparent rounded-xl font-semibold text-xs sm:text-sm text-white uppercase tracking-widest shadow hover:from-blue-600 hover:to-blue-800">
                            {{ __('Record Contribution') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
