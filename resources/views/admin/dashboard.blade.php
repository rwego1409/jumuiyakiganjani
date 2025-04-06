@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Dashboard Header -->
                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center">
                        <!-- Your Custom Logo Here -->
                        <!-- <img src="{{ asset('images/your-logo.png') }}" alt="Jumuiya Connect Logo" class="h-12 w-auto mr-4"> -->
                        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                    </div>
                    <div class="text-sm text-gray-500">Last Updated: {{ now()->format('F j, Y, g:i a') }}</div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Members -->
                    <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="bg-indigo-600 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-indigo-600">Total Members</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalMembers ?? 0 }}</p>
                                <span class="text-sm text-green-600">+{{ $memberIncreasePercentage ?? 0 }}% from last month</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Contributions -->
                    <div class="bg-green-50 p-6 rounded-lg border border-green-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="bg-green-600 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-green-600">Total Contributions</h3>
                                <p class="text-2xl font-semibold text-gray-900">TZS {{ number_format($totalContributions ?? 0) }}</p>
                                <span class="text-sm text-green-600">+{{ $contributionIncreasePercentage ?? 0 }}% this month</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="bg-yellow-600 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-yellow-600">Upcoming Events</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $upcomingEventsCount ?? 0 }}</p>
                                <span class="text-sm text-gray-500">Next event: {{ $nextEventDate ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- System Resources -->
                    <div class="bg-red-50 p-6 rounded-lg border border-red-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="bg-red-600 p-3 rounded-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-red-600">Resources</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalResources ?? 0 }}</p>
                                <span class="text-sm text-gray-500">{{ $recentResourcesCount ?? 0 }} new this week</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Sections -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Registrations -->
                    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Recent Registrations
                        </h2>
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @forelse($recentMembers as $member)
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center text-white">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div>
                                                    <div class="text-sm">
                                                        <span class="font-medium text-gray-900">{{ $member->name }}</span>
                                                        <span class="text-gray-500">joined</span>
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-500">
                                                        <time>{{ $member->created_at->diffForHumans() }}</time>
                                                        <span class="mx-1">·</span>
                                                        <span>{{ $member->email }}</span>
                                                        <span class="mx-1">·</span>
                                                        <span class="text-indigo-600">{{ $member->role }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="text-center text-gray-500 py-4">No recent registrations.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- System Activities -->
                    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                        <h2 class="text-xl font-semibold mb-4 flex items-center">
                            <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            System Activities
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($activities as $activity)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->created_at->format('M j, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $activity->user ? $activity->user->name : 'No User' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-500">
                                            @if($activity->loggable)
                                            <a href="{{ $activity->loggable_url }}" class="hover:underline">
                                                {{ class_basename($activity->loggable_type) }} #{{ $activity->loggable_id }}
                                            </a>
                                            @else
                                            <span class="text-gray-400">Deleted</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent activities found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection