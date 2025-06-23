@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">{{ __('Contribution Details') }}</h2>
            </div>
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <a href="{{ route('chairperson.contributions.edit', $contribution) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-600 to-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:shadow-md transition-all duration-300 ease-in-out">
                        {{ __('Edit') }}
                    </a>
                    
                    <form action="{{ route('chairperson.contributions.destroy', $contribution) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:shadow-md transition-all duration-300 ease-in-out"
                                onclick="return confirm('Are you sure you want to delete this contribution?')">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Member Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ $contribution->member->user->name }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            TZS {{ number_format($contribution->amount) }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Contribution Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ $contribution->contribution_date->format('M d, Y') }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ ucfirst($contribution->payment_method) }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ $contribution->purpose ?: 'Not specified' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($contribution->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($contribution->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ $contribution->created_at->format('M d, Y H:i:s') }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            {{ $contribution->updated_at->format('M d, Y H:i:s') }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="mt-4">
                <a href="{{ route('chairperson.contributions.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Back to Contributions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
