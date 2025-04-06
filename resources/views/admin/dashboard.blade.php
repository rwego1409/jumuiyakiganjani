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
                            <h3 class="text-sm font-medium text-gray-500">Upcoming Events</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $upcomingEventsCount ?? 0 }}</p>
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
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
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
                    @if($recentMembers->hasPages())
                    <div class="mt-6 border-t border-gray-100 pt-6 flex justify-center">
                        {{ $recentMembers->onEachSide(1)->links('vendor.pagination.tailwind') }}
                    </div>
                    @endif
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
                            <form action="{{ route('admin.reports.generate') }}" method="GET" class="space-y-4">
                                <input type="hidden" name="type" value="contributions">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1 truncate">From Date</label>
                                        <input type="date" name="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1 truncate">To Date</label>
                                        <input type="date" name="end_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 text-sm">
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 pt-2">
                                    <button type="submit" name="format" value="pdf" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-700 transition-colors truncate">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        PDF
                                    </button>
                                    <button type="submit" name="format" value="excel" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 transition-colors truncate">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Excel
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