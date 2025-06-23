@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg mb-8 md:text-5xl lg:text-6xl flex items-center gap-3">
            <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Member Details
        </h2>
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-900/50 p-8">
            <!-- Personal Information -->
            <div class="px-2 sm:px-4 py-4 sm:py-5">
                <h3 class="text-base sm:text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-2 sm:px-4 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Full name</dt>
                        <dd class="mt-1 text-xs sm:text-sm text-gray-900 sm:col-span-2">{{ $member->user->name }}</dd>
                    </div>
                    <div class="bg-white px-2 sm:px-4 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Email address</dt>
                        <dd class="mt-1 text-xs sm:text-sm text-gray-900 sm:col-span-2">{{ $member->user->email }}</dd>
                    </div>
                    <div class="bg-gray-50 px-2 sm:px-4 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Phone number</dt>
                        <dd class="mt-1 text-xs sm:text-sm text-gray-900 sm:col-span-2">{{ $member->phone }}</dd>
                    </div>
                    <div class="bg-white px-2 sm:px-4 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Joined Date</dt>
                        <dd class="mt-1 text-xs sm:text-sm text-gray-900 sm:col-span-2">{{ $member->joined_date->format('M d, Y') }}</dd>
                    </div>
                    <div class="bg-gray-50 px-2 sm:px-4 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <!-- Recent Contributions -->
        <div class="mt-4 sm:mt-8">
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-2xl shadow-2xl border border-pink-200/50 dark:border-pink-900/50 p-8">
                <div class="px-2 sm:px-4 py-4 sm:py-5">
                    <h3 class="text-base sm:text-lg leading-6 font-medium text-pink-700 dark:text-pink-300">Recent Contributions</h3>
                </div>
                <div class="border-t border-pink-100 dark:border-pink-900/30">
                    @if($recentContributions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-pink-200 dark:divide-pink-900 text-xs sm:text-sm">
                                <thead class="bg-pink-50 dark:bg-pink-900/20">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-pink-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-pink-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-pink-500 uppercase tracking-wider">Method</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-pink-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-pink-500 uppercase tracking-wider">Purpose</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/70 dark:bg-gray-700/70 divide-y divide-pink-100 dark:divide-pink-900">
                                    @foreach($recentContributions as $contribution)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $contribution->contribution_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                TZS {{ number_format($contribution->amount) }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ ucfirst($contribution->payment_method) }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($contribution->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($contribution->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $contribution->purpose ?: 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6 text-pink-500 text-center">
                            No recent contributions found
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('chairperson.members.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-pink-600 to-purple-500 hover:from-pink-700 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all">
                ← Back to Members
            </a>
        </div>
    </div>
</div>
@endsection
