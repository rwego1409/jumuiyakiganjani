@extends('layouts.member')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 transition duration-300">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 px-4">
        @if(session('success'))
        <div class="mb-6">
            <div class="bg-green-100 dark:bg-green-800 border-l-4 border-green-500 dark:border-green-300 text-green-700 dark:text-green-300 p-4 rounded-md shadow-sm transition duration-300">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Dashboard Header -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg transition duration-300">
            <div class="p-6">
                <div class="flex flex-wrap justify-between items-center gap-y-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent transition duration-300">
                        Member Dashboard
                    </h1>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 transition duration-300">
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
            <!-- Total Contributions -->
            <div class="min-w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition duration-300 border dark:border-gray-700">
                <div class="p-1 bg-gradient-to-r from-green-500 to-emerald-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 p-3 rounded-lg shadow-md transition duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Total Contributions</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white transition duration-300">TZS {{ number_format($stats['total_contributions'] ?? 0) }}</p>
                            @if(isset($stats['contribution_increase']) && $stats['contribution_increase'] != 0)
                            <div class="flex items-center text-sm text-green-600 dark:text-green-300 mt-1 transition duration-300">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span class="truncate">+{{ $stats['contribution_increase'] ?? 0 }}% this month</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Since -->
            <div class="min-w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition duration-300 border dark:border-gray-700">
                <div class="p-1 bg-gradient-to-r from-blue-500 to-cyan-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-3 rounded-lg shadow-md transition duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Member Since</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white transition duration-300">{{ $stats['member_since'] ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Members in Jumuiya -->
            <div class="min-w-[300px] bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition duration-300 border dark:border-gray-700">
                <div class="p-1 bg-gradient-to-r from-purple-500 to-pink-600"></div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 p-3 rounded-lg shadow-md transition duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Members in Jumuiya</h3>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white transition duration-300">{{ number_format($community_data['total_members'] ?? 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Section: Contributions Overview -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition duration-300 border dark:border-gray-700">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-5 transition duration-300">Contributions Overview</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Total Courses -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-md transition duration-300">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Total Courses</h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition duration-300">{{ count($contributions ?? []) }}</p>

                        </div>
                        <div class="text-indigo-600 dark:text-indigo-300 transition duration-300">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-3m3 3v-6m3 6v-8m-3 6H6a2 2 0 00-2 2v5a2 2 0 002 2h2M21 12h-5.5m-4 0H9m1.5-5.159a2.25 2.25 0 013 0m-3 5.159l-1.5-1.5M21 12l-4.5 4.5M3 12l4.5 4.5M20 19l-7-7m-3.913 5.913A2.25 2.25 0 0113 12.04l-1.913-1.913a2.25 2.25 0 00-3.213 3.213L9 19" />
                            </svg>
                        </div>
                    </div>

                    <!-- Completed Courses -->
                    <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-700 rounded-md transition duration-300">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Completed Courses</h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition duration-300">{{ $completedContributions ?? 0 }}</p>
                        </div>
                        <div class="text-green-600 dark:text-green-300 transition duration-300">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Pending Courses -->
                    <div class="flex items-center justify-between p-4 bg-yellow-50 dark:bg-yellow-700 rounded-md transition duration-300">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Pending Courses</h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition duration-300">{{ $pendingContributions ?? 0 }}</p>
                        </div>
                        <div class="text-yellow-600 dark:text-yellow-300 transition duration-300">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Overdue Courses -->
                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-700 rounded-md transition duration-300">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 transition duration-300">Overdue Courses</h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition duration-300">{{ $overdueContributions ?? 0 }}</p>
                        </div>
                        <div class="text-red-600 dark:text-red-300 transition duration-300">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition duration-300 border dark:border-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white transition duration-300">Upcoming Events</h2>
                    @if($member && $member->jumuiya)
                    <span class="text-sm text-gray-500 dark:text-gray-400 transition duration-300">Showing events for {{ $member->jumuiya->name }} and community-wide events</span>
                    @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($events as $event)
                    <div class="border rounded-md p-4 transition duration-300 hover:shadow-md dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition duration-300">{{ $event->title }}</h3>
                        <p class="mt-2 text-gray-600 leading-relaxed dark:text-gray-400 transition duration-300">
                            {{ $event->start_time->format('M d, Y h:i A') }}
                            @if($event->jumuiya)
                            <br>For {{ $event->jumuiya->name }}
                            @else
                            <br>Community Event
                            @endif
                        </p>
                        <p class="mt-2 text-gray-500 leading-relaxed dark:text-gray-500 transition duration-300">{{ Str::limit($event->description, 100) }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500 dark:text-gray-400 transition duration-300">No upcoming events</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Resources Section -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition duration-300 border dark:border-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-5 transition duration-300">Recent Resources</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($resources as $resource)
                    <div class="border rounded-md p-4 transition duration-300 hover:shadow-md dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition duration-300">{{ $resource->title }}</h3>
                        <p class="mt-2 text-gray-600 leading-relaxed dark:text-gray-400 transition duration-300">
                            Uploaded {{ $resource->created_at->diffForHumans() }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('member.resources.download', $resource->id) }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200 transition duration-300">Download Resource</a>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 dark:text-gray-400 transition duration-300">No resources available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Contributions Section -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition duration-300 border dark:border-gray-700">
            <div class="px-4 py-5 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-5 transition duration-300">Your Recent Contributions</h2>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200 dark:divide-gray-700 transition duration-300">
                        @forelse ($recentContributions as $contribution)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-2 1H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-2m-2-4v-6a2 2 0 012-2h2m-2-4v-2a2 2 0 012-2h2" />
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white transition duration-300">
                                        {{ $contribution->title }}
                                    </p>
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400 transition duration-300">
                                        Contributed on {{ $contribution->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <!-- You might want to add a link to view the contribution -->
                                    <a href="route('member.contributions.show')" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 dark:border-gray-500 text-sm leading-5 font-medium rounded-full text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">View</a>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="py-4 text-gray-500 dark:text-gray-400 transition duration-300">No recent contributions.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-6">
                    <a href="route('member.contributions.index')" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-500 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300">
                        View all contributions
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    // Chart.js configurations
    const lineChartData = {
        labels: {!! json_encode($lineChartLabels) !!},
        datasets: [{
            label: 'Sessions',
            data: {!! json_encode($lineChartData) !!},
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.4,
            fill: true,
        }]
    };

    const lineChartCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineChartCtx, {
        type: 'line',
        data: lineChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // FullCalendar configuration
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: {!! json_encode($calendarEvents) !!}, // Example: [{ title: 'Event 1', start: '2024-05-10', url: '/event/1' }]
            eventClick: function (info) {
                info.jsEvent.preventDefault(); // Prevent default browser behavior
                if (info.event.url) {
                    window.location.href = info.event.url; // Navigate to event URL
                }
            }
        });
        calendar.render();
    });
</script>
@endpush


@endsection

