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

        <!-- Analytics Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sessions Over Time -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-sky-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Sessions
                    </h2>
                </div>
                <div class="p-6">
                    <div class="text-right mb-2">
                        <span class="text-2xl font-bold text-gray-900">741</span>
                    </div>
                    <div id="sessions-chart" class="h-64"></div>
                </div>
            </div>

            <!-- Traffic Sources -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-purple-50 to-fuchsia-50 px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="h-6 w-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        Sessions by Source
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex justify-center mb-6">
                        <div class="relative" style="height: 200px; width: 200px;">
                            <div id="traffic-sources-chart"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <span class="block text-3xl font-bold text-gray-900">249</span>
                                    <span class="text-sm text-gray-500">Total Sessions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Email</span>
                            <span class="ml-auto font-medium">40</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Referral</span>
                            <span class="ml-auto font-medium">42</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-amber-300 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Paid Search</span>
                            <span class="ml-auto font-medium">32</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">(Other)</span>
                            <span class="ml-auto font-medium">38</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-cyan-300 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Direct</span>
                            <span class="ml-auto font-medium">32</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-300 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Social</span>
                            <span class="ml-auto font-medium">28</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Display</span>
                            <span class="ml-auto font-medium">27</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Organic Search</span>
                            <span class="ml-auto font-medium">10</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modified Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Main Sessions Chart -->
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
                        Traffic Sources Trend
                    </h2>
                </div>
                <div class="p-6">
                    <div id="traffic-sources-chart" class="h-96"></div>
                </div>
            </div>
        </div>

        <!-- Mini Charts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Members Growth</h3>
                    <span class="text-sm text-indigo-600">+24%</span>
                </div>
                <div id="members-trend"></div>
                <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalMembers ?? 0 }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Contributions</h3>
                    <span class="text-sm text-emerald-600">+38%</span>
                </div>
                <div id="contributions-trend"></div>
                <div class="text-2xl font-bold text-gray-900 mt-2">TZS {{ number_format($totalContributions ?? 0) }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Events</h3>
                    <span class="text-sm text-amber-600">+12%</span>
                </div>
                <div id="events-trend"></div>
                <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalEvents ?? 0 }}</div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Resources</h3>
                    <span class="text-sm text-red-600">+8%</span>
                </div>
                <div id="resources-trend"></div>
                <div class="text-2xl font-bold text-gray-900 mt-2">{{ $totalResources ?? 0 }}</div>
            </div>
        </div>

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
                    <div class="h-full bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-blue-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-md bg-blue-600 text-white mr-3">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 truncate">Members Report</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-6 truncate">Generate comprehensive reports of all members with their details and contribution history.</p>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.reports.generate', ['type' => 'members', 'format' => 'pdf']) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 transition-colors truncate">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    PDF
                                </a>
                                <a href="{{ route('admin.reports.generate', ['type' => 'members', 'format' => 'excel']) }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-emerald-700 transition-colors truncate">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Excel
                                </a>
                                <a href="{{ route('admin.reports.generate', ['type' => 'members', 'format' => 'csv']) }}" class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-700 transition-colors truncate">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    CSV
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contributions Report -->
                    <div class="h-full bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg shadow-sm border border-green-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-md bg-green-600 text-white mr-3">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 truncate">Contributions Report</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 truncate">Detailed report of all contributions with filtering options by date range.</p>
                            <form action="{{ route('admin.reports.generate', ['type' => 'contributions']) }}" method="GET" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                        <input type="date" name="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                        <input type="date" name="end_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2 pt-2">
                                    <button type="submit" name="format" value="pdf" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V7.414A2 2 0 0014.414 6L11 2.586A2 2 0 009.586 2H7z"/></svg>
                                        PDF
                                    </button>
                                    <button type="submit" name="format" value="excel" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                        Excel
                                    </button>
                                    <button type="submit" name="format" value="csv" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                        CSV
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Events Report -->
                    <div class="h-full bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg shadow-sm border border-amber-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 rounded-md bg-amber-600 text-white mr-3">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 truncate">Events Report</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-6 truncate">Generate comprehensive reports of all events with attendance details and statistics.</p>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.reports.generate', ['type' => 'events', 'format' => 'pdf']) }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-amber-700 transition-colors truncate">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    PDF
                                </a>
                                <a href="{{ route('admin.reports.generate', ['type' => 'events', 'format' => 'excel']) }}" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-red-700 transition-colors truncate">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Excel
                                </a>
                            </div>
                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Main Sessions Chart with Multiple Lines
        if (document.getElementById('sessions-chart')) {
            const sessionsOptions = {
                series: [{
                    name: 'Website Sessions',
                    data: [40, 70, 20, 90, 36, 80, 30, 91, 60, 28, 52, 70, 60, 110, 36, 50, 22, 70, 60, 54, 60, 40, 14, 40, 60]
                }, {
                    name: 'Member Logins',
                    data: [20, 45, 15, 60, 25, 50, 20, 65, 40, 18, 35, 45, 40, 80, 25, 35, 15, 45, 40, 35, 40, 25, 10, 25, 40]
                }, {
                    name: 'Resource Views',
                    data: [15, 30, 10, 40, 18, 35, 15, 45, 30, 12, 25, 30, 25, 60, 18, 25, 10, 30, 25, 22, 25, 15, 5, 15, 25]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: { enabled: false },
                    toolbar: { show: true },
                    animations: { enabled: true }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b'],
                grid: {
                    borderColor: '#f1f1f1',
                    row: { colors: ['#f8fafc', 'transparent'], opacity: 0.2 }
                },
                markers: { size: 5 },
                xaxis: {
                    categories: ['Jan 1', '', '', '', 'Jan 7', '', '', '', '', 'Jan 14', '', '', '', '', 'Jan 21', '', '', '', '', 'Jan 28'],
                    labels: { style: { colors: '#6b7280', fontSize: '12px' } }
                },
                yaxis: {
                    min: 0,
                    max: 120,
                    tickAmount: 6,
                    labels: { 
                        style: { colors: '#6b7280', fontSize: '12px' },
                        formatter: function(val) { return val.toFixed(0); }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: { radius: 12 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function(val) { return val + " sessions" } }
                }
            };

            new ApexCharts(document.querySelector("#sessions-chart"), sessionsOptions).render();
        }

        // Feature-Specific Mini Charts
        const createMiniChart = (elementId, data, color) => {
            const options = {
                series: [{ data: data }],
                chart: {
                    type: 'line',
                    height: 80,
                    sparkline: { enabled: true }
                },
                stroke: { curve: 'smooth', width: 2, colors: [color] },
                markers: { size: 0 },
                tooltip: { enabled: false },
                grid: { show: false },
                yaxis: { show: false },
                xaxis: { labels: { show: false } }
            };
            new ApexCharts(document.querySelector(elementId), options).render();
        };

        // Initialize mini charts
        if (document.getElementById('members-trend')) {
            createMiniChart('#members-trend', [5, 10, 8, 12, 15, 18, 20], '#6366f1');
            createMiniChart('#contributions-trend', [200, 300, 250, 400, 350, 450, 500], '#10b981');
            createMiniChart('#events-trend', [2, 3, 1, 4, 5, 3, 6], '#f59e0b');
            createMiniChart('#resources-trend', [10, 15, 12, 18, 20, 25, 22], '#ef4444');
        }

        // Traffic Sources Line Chart
        if (document.getElementById('traffic-sources-chart')) {
            const trafficOptions = {
                series: [
                    { name: 'Email', data: [10, 15, 12, 18, 20, 25, 22] },
                    { name: 'Referral', data: [8, 12, 10, 15, 18, 20, 17] },
                    { name: 'Direct', data: [5, 7, 6, 9, 11, 13, 10] }
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: { show: true }
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b'],
                stroke: { curve: 'smooth', width: 3 },
                markers: { size: 5 },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                },
                yaxis: {
                    min: 0,
                    max: 30,
                    tickAmount: 6
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                }
            };
            new ApexCharts(document.querySelector("#traffic-sources-chart"), trafficOptions).render();
        }

    
    });
</script>
@endpush

