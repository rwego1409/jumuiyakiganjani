@extends('layouts.member')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Success Notification -->
        @if(session('success'))
        <div class="animate-slide-down bg-emerald-100 dark:bg-emerald-900/30 backdrop-blur-lg border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4 shadow-xl">
            <div class="flex items-center gap-3 text-emerald-800 dark:text-emerald-200">
                <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
            <div class="space-y-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Welcome Back, {{ auth()->user()->name }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Here's your activity overview for {{ now()->format('F j, Y') }}
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800/50 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 shadow-sm">
                <svg class="h-6 w-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Updated {{ now()->format('g:i A') }}
                </span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                [
                    'title' => 'Total Contributions',
                    'value' => 'TZS ' . number_format($stats['total_contributions'] ?? 0),
                    'icon' => 'currency-dollar',
                    'trend' => $stats['contribution_increase'] ?? null,
                    'color' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400'
                ],
                [
                    'title' => 'Member Since',
                    'value' => $stats['member_since'] ?? 'March 2025',
                    'icon' => 'calendar',
                    'color' => 'bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400'
                ],
                [
                    'title' => 'Community Members',
                    'value' => number_format($community_data['total_members'] ?? 0),
                    'icon' => 'users',
                    'color' => 'bg-pink-100 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400'
                ],
                [
                    'title' => 'Completed Payments',
                    'value' => $stats['completed_payments'] ?? 5,
                    'icon' => 'check-circle',
                    'color' => 'bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400'
                ]
            ] as $card)
            <div class="group relative bg-white dark:bg-gray-800/30 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-5 transition-all duration-300 hover:border-blue-200 dark:hover:border-blue-800 hover:shadow-lg">
                <div class="flex items-start justify-between space-x-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="{{ $card['color'] }} p-3 rounded-xl shadow-inner">
                                @switch($card['icon'])
                                    @case('currency-dollar')
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @break
                                    @case('calendar')
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @break
                                    @case('users')
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    @break
                                    @case('check-circle')
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @break
                                @endswitch
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $card['title'] }}</h3>
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $card['value'] }}</p>
                    </div>
                    @isset($card['trend'])
                    <div class="flex items-center gap-1 text-sm {{ $card['trend'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $card['trend'] > 0 ? '13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : '13 17H5m0 0V9m0 8l8-8 4 4 6-6' }}" />
                        </svg>
                        <span>{{ abs($card['trend']) }}%</span>
                    </div>
                    @endisset
                </div>
                <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-blue-400 to-purple-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-2xl"></div>
            </div>
            @endforeach
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Calendar Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Interactive Calendar -->
                <div class="bg-white dark:bg-gray-800/30 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xl">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Events Schedule</h2>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('member.events.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                View All Events
                            </a>
                        </div>
                    </div>
                    <div id="calendar" class="fc"></div>
                </div>

                <!-- Recent Contributions -->
                <div class="bg-white dark:bg-gray-800/30 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Contributions</h2>
                        <a href="{{ route('member.contributions.index') }}" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1">
                            View All
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse ($recentContributions as $contribution)
                        <div class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/20 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/40 transition-colors border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white">{{ $contribution->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $contribution->created_at->format('M j, Y - g:i A') }}</p>
                                </div>
                            </div>
                            <a href="{{ route('member.contributions.show', $contribution->id) }}" class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">No recent contributions found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Resources & Quick Actions -->
            <div class="space-y-6">
                <!-- Recent Resources -->
                <div class="bg-white dark:bg-gray-800/30 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Resources Library</h2>
                        <a href="{{ route('member.resources.index') }}" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-1">
                            View All
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($resources as $resource)
                        <div class="group flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/20 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/40 transition-colors border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900 dark:text-white truncate max-w-[160px]">{{ $resource->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $resource->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('member.resources.download', $resource->id) }}" class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">No resources available</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800/30 backdrop-blur-lg border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xl">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('member.contributions.create') }}" class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors border border-blue-200 dark:border-blue-800 group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-800/30 rounded-lg">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-blue-800 dark:text-blue-200">New Contribution</span>
                            </div>
                        </a>
                        <a href="{{ route('member.events.index') }}" class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors border border-purple-200 dark:border-purple-800 group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-purple-100 dark:bg-purple-800/30 rounded-lg">
                                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-purple-800 dark:text-purple-200">View Calendar</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.fc {
    --fc-border-color: theme('colors.gray.200');
    --fc-page-bg-color: theme('colors.white');
    --fc-today-bg-color: theme('colors.blue.50');
    --fc-event-bg-color: theme('colors.blue.600');
    --fc-event-border-color: theme('colors.blue.600');
}

.dark .fc {
    --fc-border-color: theme('colors.gray.700');
    --fc-page-bg-color: theme('colors.gray.800/30');
    --fc-today-bg-color: theme('colors.blue.900/20');
    --fc-event-bg-color: theme('colors.blue.400');
    --fc-event-border-color: theme('colors.blue.400');
}

.fc .fc-daygrid-day-frame {
    @apply transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700/20 rounded-lg p-1;
}

.fc .fc-event {
    @apply rounded-lg px-2 py-1 text-sm font-medium shadow-sm transition-all duration-200 hover:scale-[0.98] border-0;
}

.fc .fc-toolbar-title {
    @apply text-xl font-bold text-gray-900 dark:text-white;
}

.fc .fc-button {
    @apply rounded-xl border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-all duration-200;
}

.fc .fc-button-primary {
    @apply border-transparent bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500;
}

@keyframes slide-down {
    0% { transform: translateY(-20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}

.animate-slide-down {
    animation: slide-down 0.3s ease-out;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: @json($calendarEvents),
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        eventDidMount: (info) => {
            info.el.classList.add('cursor-pointer', 'hover:shadow-md');
        },
        dateClick: (info) => {
            const events = @json($calendarEvents).filter(event => 
                event.start.startsWith(info.dateStr)
            );
            if(events.length > 0) {
                window.location = events.length === 1 
                    ? events[0].url 
                    : `/member/events?date=${info.dateStr}`;
            }
        },
        eventClick: (info) => {
            info.jsEvent.preventDefault();
            window.location.href = info.event.url;
        },
        height: 'auto',
        navLinks: true,
        nowIndicator: true,
        dayMaxEvents: 2,
        themeSystem: 'bootstrap5'
    });

    // Dark mode handler
    const updateTheme = () => {
        calendar.setOption('themeSystem', 
            document.documentElement.classList.contains('dark') 
                ? 'bootstrap5-dark' 
                : 'bootstrap5'
        );
    };
    
    new MutationObserver(updateTheme).observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });

    calendar.render();
    updateTheme();
});
</script>
@endpush