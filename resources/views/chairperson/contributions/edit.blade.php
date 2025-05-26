@extends('layouts.chairperson')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">{{ __('Edit Contribution') }}</h2>
        </div>

        <form action="{{ route('chairperson.contributions.update', $contribution) }}" method="POST" class="max-w-2xl">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Member Selection -->
                <div>
                    <label for="member_id" class="block text-sm font-medium text-gray-700">
                        {{ __('Member') }}
                    </label>
                    <select id="member_id" name="member_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
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
                    <label for="amount" class="block text-sm font-medium text-gray-700">
                        {{ __('Amount (TZS)') }}
                    </label>
                    <input type="number" name="amount" id="amount" min="1" step="1" value="{{ old('amount', $contribution->amount) }}" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contribution Date -->
                <div>
                    <label for="contribution_date" class="block text-sm font-medium text-gray-700">
                        {{ __('Contribution Date') }}
                    </label>
                    <input type="date" name="contribution_date" id="contribution_date" 
                        value="{{ old('contribution_date', $contribution->contribution_date->format('Y-m-d')) }}" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @error('contribution_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">
                        {{ __('Payment Method') }}
                    </label>
                    <select id="payment_method" name="payment_method" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
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
                    <label for="purpose" class="block text-sm font-medium text-gray-700">
                        {{ __('Purpose (Optional)') }}
                    </label>
                    <input type="text" name="purpose" id="purpose" value="{{ old('purpose', $contribution->purpose) }}"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @error('purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">
                        {{ __('Status') }}
                    </label>
                    <select id="status" name="status" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="pending" {{ old('status', $contribution->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $contribution->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="rejected" {{ old('status', $contribution->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('chairperson.contributions.index') }}" class="mr-3 text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        {{ __('Update Contribution') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
