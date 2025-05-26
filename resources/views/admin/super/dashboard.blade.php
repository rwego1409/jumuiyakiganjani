@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        Super Admin Dashboard
    </h2>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Users</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</div>
            <div class="mt-2 text-xs text-gray-500">
                Admins: {{ $stats['admins'] }} | Chairpersons: {{ $stats['chairpersons'] }} | Members: {{ $stats['members'] }}
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Jumuiyas</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_jumuiyas'] }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Members</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_members'] }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Contributions</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_contributions']) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Events -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Events</h3>
            <div class="space-y-4">
                @foreach($stats['recent_events'] as $event)
                <div class="flex items-start space-x-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $event->start_time->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Users</h3>
            <div class="space-y-4">
                @foreach($stats['recent_users'] as $user)
                <div class="flex items-start space-x-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $user->role }} - {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Contributions -->
        <div class="col-span-full bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Contributions</h3>
            <div class="space-y-4">
                @foreach($stats['recent_contributions'] as $contribution)
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $contribution->member->user->name }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $contribution->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ number_format($contribution->amount) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
