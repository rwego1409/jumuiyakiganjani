@extends('layouts.admin')

@section('content')


<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 px-4">
        @if(session('success'))
        <div class="mb-6">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Dashboard Header -->
        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6">
                <div class="flex flex-wrap justify-between items-center gap-y-4">
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                        Admin Dashboard
                    </h1>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Last Updated: {{ now()->format('F j, Y, g:i a') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 overflow-x-auto pb-4">
            <!-- Total Members -->
            <div class="min-w-[300px] bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-1 bg-gradient-to-r from-indigo-500 to-blue-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Members</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalMembers ?? 0 }}</p>
                            <div class="flex items-center text-sm text-green-600 mt-1">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span class="truncate">+{{ $memberIncreasePercentage ?? 0 }}% from last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Contributions -->
            <div class="min-w-[300px] bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Total Contributions</h3>
                            <p class="text-2xl font-bold text-gray-900">TZS {{ number_format($totalContributions ?? 0) }}</p>
                            <div class="flex items-center text-sm text-green-600 mt-1">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span class="truncate">+{{ $contributionIncreasePercentage ?? 0 }}% this month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="min-w-[300px] bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-1 bg-gradient-to-r from-amber-500 to-yellow-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-amber-500 to-amber-700 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Events</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalEvents ?? 0 }}</p>
                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">Next: {{ $nextEventDate ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Resources -->
            <div class="min-w-[300px] bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-1 bg-gradient-to-r from-rose-500 to-red-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-rose-500 to-rose-700 p-3 rounded-lg shadow-md">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500">Resources</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalResources ?? 0 }}</p>
                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span class="truncate">{{ $recentResourcesCount ?? 0 }} new this week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Recent Registrations -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Recent Registrations
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        @forelse($recentMembers as $member)
                        <div class="flex items-start gap-4 group">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-medium shadow-lg">
                                    {{ strtoupper(substr($member->user->name ?? '', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-1">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $member->name }}</h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $member->role }}
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 text-sm text-gray-600 truncate">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="truncate">{{ $member->email }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="truncate">{{ $member->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <div class="border-t border-gray-100"></div>
                        @endif
                        @empty
                        <div class="text-center py-8">
                            <div class="mb-4 text-gray-400">
                                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <p class="text-gray-600 font-medium">No recent registrations</p>
                            <p class="text-sm text-gray-500 mt-1">New members will appear here</p>
                        </div>
                        @endforelse
                    </div>
                    {{ $recentMembers->links() }}
                </div>
            </div>

            <!-- System Activities -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-purple-50 to-fuchsia-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        System Activities
                    </h2>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-[800px] lg:w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Target</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($activities as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $activity->created_at->format('M j, H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-medium">
                                                {{ $activity->user ? strtoupper(substr($activity->user->name, 0, 1)) : 'S' }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $activity->user ? $activity->user->name : 'System' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 truncate">{{ $activity->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($activity->loggable)
                                        <a href="{{ $activity->loggable_url }}" class="text-blue-600 hover:text-blue-900 hover:underline flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="truncate">{{ class_basename($activity->loggable_type) }} #{{ $activity->loggable_id }}</span>
                                        </a>
                                        @else
                                        <span class="text-gray-400 flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Deleted
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        <svg class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <p class="font-medium">No recent activities found</p>
                                        <p class="text-sm text-gray-400 mt-1">System activities will be logged here</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!-- Analytics Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sessions Chart -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-sky-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Activity Trends
                    </h2>
                </div>
                <div class="p-6">
                    <div id="sessions-chart" class="h-96"></div>
                </div>
            </div>

            <!-- Traffic Sources Chart -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-purple-50 to-fuchsia-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                        Traffic Sources
                    </h2>
                </div>
                <div class="p-6">
                    <div id="traffic-sources-chart" class="h-96"></div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-6">
                        @foreach([['Email', '#3b82f6', 40], ['Referral', '#10b981', 42], 
                                ['Paid Search', '#f59e0b', 32], ['(Other)', '#1d4ed8', 38],
                                ['Direct', '#06b6d4', 32], ['Social', '#9ca3af', 28],
                                ['Display', '#6b7280', 27], ['Organic Search', '#22c55e', 10]] as $source)
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $source[1] }}"></div>
                            <span class="text-sm text-gray-600">{{ $source[0] }}</span>
                            <span class="ml-auto font-medium">{{ $source[2] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Charts Grid -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach([
                ['Members Growth', 'members-trend', '#6366f1', '+24%', 325],
                ['Contributions', 'contributions-trend', '#10b981', '+38%', 'TZS 1,248,000'],
                ['Events', 'events-trend', '#f59e0b', '+12%', 14],
                ['Resources', 'resources-trend', '#ef4444', '+8%', 32]
            ] as $chart)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $chart[0] }}</h3>
                    <span class="text-sm" style="color: {{ $chart[2] }}">{{ $chart[3] }}</span>
                </div>
                <div id="{{ $chart[1] }}" class="h-20"></div>
                <div class="text-2xl font-bold text-gray-900 mt-2">{{ $chart[4] }}</div>
            </div>
            @endforeach
        </div> -->

        <!-- Mini Charts Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Members Growth Chart -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Members Growth</h3>
            <span class="text-sm" style="color: #6366f1">+{{ $memberIncreasePercentage }}%</span>
        </div>
        <div id="members-trend" class="h-20"></div>
        <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalMembers }}</div>
    </div>
    
    <!-- Contributions Chart -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Contributions</h3>
            <span class="text-sm" style="color: #10b981">+{{ $contributionIncreasePercentage }}%</span>
        </div>
        <div id="contributions-trend" class="h-20"></div>
        <div class="text-2xl font-bold text-gray-900 mt-2">TZS {{ number_format($totalContributions) }}</div>
    </div>
    
    <!-- Events Chart -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Events</h3>
            <span class="text-sm" style="color: #f59e0b">
                @php
                    $previousMonthEvents = \App\Models\Event::whereMonth('created_at', now()->subMonth()->month)->count();
                    $currentMonthEvents = \App\Models\Event::whereMonth('created_at', now()->month)->count();
                    $eventsGrowth = $previousMonthEvents > 0 ? 
                        round(($currentMonthEvents - $previousMonthEvents) / $previousMonthEvents * 100) : 0;
                @endphp
                +{{ $eventsGrowth }}%
            </span>
        </div>
        <div id="events-trend" class="h-20"></div>
        <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalEvents }}</div>
    </div>
    
    <!-- Resources Chart -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Resources</h3>
            <span class="text-sm" style="color: #ef4444">
                @php
                    $previousMonthResources = \App\Models\Resource::whereMonth('created_at', now()->subMonth()->month)->count();
                    $currentMonthResources = \App\Models\Resource::whereMonth('created_at', now()->month)->count();
                    $resourcesGrowth = $previousMonthResources > 0 ? 
                        round(($currentMonthResources - $previousMonthResources) / $previousMonthResources * 100) : 0;
                @endphp
                +{{ $resourcesGrowth }}%
            </span>
        </div>
        <div id="resources-trend" class="h-20"></div>
        <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalResources }}</div>
    </div>
</div>

<!-- Reports Center -->
<!-- Reports Center -->
<div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-sky-50 px-6 py-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
            <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Reports Center
        </h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="grid-auto-rows: minmax(300px, auto)">
            <!-- Members Report -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-sky-50 px-6 py-4 border-b">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Members Report</h2>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-6">
                        Generate detailed member reports including personal information and membership history.
                    </p>

                    <!-- Date Filter -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" id="membersStartDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" id="membersEndDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Member Status</label>
                        <select id="membersStatus" class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">All Members</option>
                            <option value="active">Active Only</option>
                            <option value="inactive">Inactive Only</option>
                        </select>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="generateReport('members', 'pdf')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            PDF Export
                        </button>

                        <button onclick="generateReport('members', 'excel')"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel Export
                        </button>

                        <button onclick="generateReport('members', 'csv')"
                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            CSV Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contributions Report -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Contributions Report</h2>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-6">
                        Generate detailed reports of all contributions with filtering options.
                    </p>

                    <!-- Date Filter -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" id="contributionsStartDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" id="contributionsEndDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Contribution Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contribution Type</label>
                        <select id="contributionsType" class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            <option value="all">All Types</option>
                            <option value="monthly">Monthly</option>
                            <option value="special">Special</option>
                            <option value="donation">Donation</option>
                            <option value="event">Event</option>
                        </select>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="generateReport('contributions', 'pdf')"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            PDF Export
                        </button>

                        <button onclick="generateReport('contributions', 'excel')"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel Export
                        </button>

                        <button onclick="generateReport('contributions', 'csv')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            CSV Export
                        </button>
                    </div>
                </div>
            </div>

            <!-- Events Report -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 px-6 py-4 border-b">
                    <div class="flex items-center space-x-3">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Events Report</h2>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-6">
                        Generate comprehensive reports of all events with attendance details.
                    </p>

                    <!-- Date Filter -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" id="eventsStartDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" id="eventsEndDate" 
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    <!-- Event Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                        <select id="eventsType" class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="all">All Events</option>
                            <option value="meeting">Meeting</option>
                            <option value="workshop">Workshop</option>
                            <option value="seminar">Seminar</option>
                            <option value="social">Social Gathering</option>
                        </select>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="generateReport('events', 'pdf')"
                                class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            PDF Export
                        </button>

                        <button onclick="generateReport('events', 'excel')"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel Export
                        </button>

                        <button onclick="generateReport('events', 'csv')"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            CSV Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load ApexCharts from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>
<script>
function generateReport(type, format) {
    const startDate = document.getElementById(`${type}StartDate`).value;
    const endDate = document.getElementById(`${type}EndDate`).value;
    
    const baseUrl = @json(route('admin.reports.generate', ['type' => '--type--', 'format' => '--format--']))
        .replace('--type--', type)
        .replace('--format--', format);

    const url = new URL(baseUrl);
    if(startDate) url.searchParams.append('start_date', startDate);
    if(endDate) url.searchParams.append('end_date', endDate);

    window.location.href = url.toString();
}


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Main Sessions Chart
    const sessionsData = {
        websiteSessions: [40,70,20,90,36,80,30,91,60,28,52,70,60,110,36,50,22,70,60,54,60,40,14,40,60],
        memberLogins: [20,45,15,60,25,50,20,65,40,18,35,45,40,80,25,35,15,45,40,35,40,25,10,25,40],
        resourceViews: [15,30,10,40,18,35,15,45,30,12,25,30,25,60,18,25,10,30,25,22,25,15,5,15,25],
        dates: ['Jan 1','','','','Jan 7','','','','','Jan 14','','','','','Jan 21','','','','','Jan 28']
    };

    new ApexCharts(document.querySelector("#sessions-chart"), {
        series: [
            { name: 'Website Sessions', data: sessionsData.websiteSessions },
            { name: 'Member Logins', data: sessionsData.memberLogins },
            { name: 'Resource Views', data: sessionsData.resourceViews }
        ],
        chart: { type: 'line', height: 350, toolbar: { show: true }},
        colors: ['#3b82f6', '#10b981', '#f59e0b'],
        stroke: { curve: 'smooth', width: 3 },
        xaxis: { categories: sessionsData.dates },
        yaxis: { min: 0, max: 120, tickAmount: 6 },
        grid: { borderColor: '#f1f1f1' },
        legend: { position: 'top' }
    }).render();

    // Traffic Sources Pie Chart
    const trafficSourcesData = [
        { name: 'Email', value: 40, color: '#3b82f6' },
        { name: 'Referral', value: 42, color: '#10b981' },
        { name: 'Paid Search', value: 32, color: '#f59e0b' },
        { name: '(Other)', value: 38, color: '#1d4ed8' },
        { name: 'Direct', value: 32, color: '#06b6d4' },
        { name: 'Social', value: 28, color: '#9ca3af' },
        { name: 'Display', value: 27, color: '#6b7280' },
        { name: 'Organic Search', value: 10, color: '#22c55e' }
    ];

    new ApexCharts(document.querySelector("#traffic-sources-chart"), {
        series: trafficSourcesData.map(item => item.value),
        chart: { type: 'pie', height: 350 },
        labels: trafficSourcesData.map(item => item.name),
        colors: trafficSourcesData.map(item => item.color),
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' }}}
    }).render();

    // Mini Charts Configuration
    const createMiniChart = (elementId, data, color) => {
        new ApexCharts(document.querySelector(elementId), {
            series: [{ data }],
            chart: { type: 'line', height: 80, sparkline: { enabled: true }},
            stroke: { curve: 'smooth', width: 2, colors: [color] },
            tooltip: { enabled: false }
        }).render();
    };

    createMiniChart('#members-trend', [5,10,8,12,15,18,20], '#6366f1');
    createMiniChart('#contributions-trend', [200,300,250,400,350,450,500], '#10b981');
    createMiniChart('#events-trend', [2,3,1,4,5,3,6], '#f59e0b');
    createMiniChart('#resources-trend', [10,15,12,18,20,25,22], '#ef4444');
});
</script>
@endpush