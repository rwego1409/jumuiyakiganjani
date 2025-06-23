@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 md:mb-6 gap-2 md:gap-0">
        <h2 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2 md:mb-0 truncate">Super Admin Dashboard</h2>
        @if(auth()->user()->isChairperson())
            <a href="{{ route('chairperson.notifications.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 transition-colors w-full md:w-auto">
                <i class="fas fa-bell mr-2"></i> Create Notification
            </a>
        @endif
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 mb-4 md:mb-8">
        <!-- Jumuiyas (Blue) -->
        <div class="bg-blue-600 dark:bg-blue-700 shadow-lg rounded-lg p-4 md:p-6 flex flex-col items-center border border-blue-400/40 dark:border-blue-800/40">
            <div class="mb-2">
                <i class="fas fa-church text-4xl text-white drop-shadow-lg"></i>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg">{{ $totalJumuiyas }}</div>
            <div class="text-white/90 mt-2 text-xs md:text-base font-semibold tracking-wide">Total Jumuiyas</div>
        </div>
        <!-- Chairpersons (Yellow) -->
        <div class="bg-yellow-500 dark:bg-yellow-600 shadow-lg rounded-lg p-4 md:p-6 flex flex-col items-center border border-yellow-400/40 dark:border-yellow-800/40">
            <div class="mb-2">
                <i class="fas fa-user-tie text-4xl text-white drop-shadow-lg"></i>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg">{{ $totalChairpersons }}</div>
            <div class="text-white/90 mt-2 text-xs md:text-base font-semibold tracking-wide">Total Chairpersons</div>
        </div>
        <!-- Admins (Red) -->
        <div class="bg-red-500 dark:bg-red-600 shadow-lg rounded-lg p-4 md:p-6 flex flex-col items-center border border-red-300/40 dark:border-red-700/40">
            <div class="mb-2">
                <i class="fas fa-user-shield text-4xl text-white drop-shadow-lg"></i>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg">{{ $totalAdmins }}</div>
            <div class="text-white/90 mt-2 text-xs md:text-base font-semibold tracking-wide">Total Admins</div>
        </div>
        <!-- Members (Purple) -->
        <div class="bg-purple-600 dark:bg-purple-700 shadow-lg rounded-lg p-4 md:p-6 flex flex-col items-center border border-purple-400/40 dark:border-purple-800/40">
            <div class="mb-2">
                <i class="fas fa-users text-4xl text-white drop-shadow-lg"></i>
            </div>
            <div class="text-2xl md:text-3xl font-extrabold text-white drop-shadow-lg">{{ $totalMembers }}</div>
            <div class="text-white/90 mt-2 text-xs md:text-base font-semibold tracking-wide">Total Members</div>
        </div>
    </div>
    <!-- Charts Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 md:p-6 mb-4 md:mb-8 overflow-x-auto">
        <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-2 md:mb-4">Statistics Overview</h3>
        <canvas id="superAdminChart" height="100"></canvas>
    </div>
    <div class="bg-gradient-to-br from-pink-100 via-yellow-100 to-green-100 dark:from-pink-900 dark:via-yellow-900 dark:to-green-900 shadow-lg rounded-lg p-4 md:p-6 mb-6">
        <h3 class="text-base md:text-lg font-semibold text-pink-700 dark:text-pink-200 mb-2 md:mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Recent Jumuiyas
        </h3>
        <ul class="text-xs md:text-base">
            @forelse($recentJumuiyas as $jumuiya)
                <li class="mb-2 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gradient-to-br from-pink-400 via-yellow-300 to-green-300 text-white font-bold shadow">
                        <i class="fas fa-users"></i>
                    </span>
                    <span class="font-semibold text-pink-700 dark:text-pink-200">{{ $jumuiya->name }}</span>
                    <span class="text-gray-500 ml-2">({{ $jumuiya->chairperson->name ?? 'No Chairperson' }})</span>
                </li>
            @empty
                <li class="text-gray-500">No recent Jumuiyas found.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-gradient-to-br from-yellow-100 via-pink-100 to-purple-100 dark:from-yellow-900 dark:via-pink-900 dark:to-purple-900 shadow-lg rounded-lg p-4 md:p-6 overflow-x-auto mb-4 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <h3 class="text-base md:text-lg font-semibold text-pink-600 dark:text-pink-300 flex items-center">
                <svg class="w-5 h-5 mr-2 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Recent System Activity
            </h3>
            <a href="{{ route('super_admin.activities.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-400 hover:from-pink-600 hover:via-red-600 hover:to-yellow-500 text-white font-bold rounded-lg shadow border-2 border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all duration-200 w-full sm:w-auto justify-center">
                <i class="fas fa-list mr-2"></i> View All
            </a>
        </div>
        <ul class="divide-y divide-pink-100 dark:divide-pink-800">
            @forelse($recentActivities as $activity)
                <li class="py-3 flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-gradient-to-br from-pink-200 via-yellow-200 to-purple-200 dark:from-pink-800 dark:via-yellow-800 dark:to-purple-800">
                        <i class="fas fa-{{ $activity->getActivityIcon() }} text-pink-500 dark:text-pink-300 text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1">
                            <div class="truncate">
                                <span class="font-bold text-pink-800 dark:text-pink-100">{{ $activity->user->name ?? 'System' }}</span>
                                <span class="mx-2 text-xs font-semibold px-2 py-0.5 rounded bg-pink-100 text-pink-800 dark:bg-pink-700/30 dark:text-pink-200">
                                    {{ ucfirst($activity->action) }}
                                </span>
                                <span class="text-pink-700 dark:text-pink-200 truncate block md:inline">{{ $activity->description }}</span>
                            </div>
                            <div class="text-xs text-pink-500 dark:text-pink-300 mt-2 md:mt-0 md:ml-4 whitespace-nowrap">
                                {{ $activity->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-8 text-center text-pink-400 dark:text-pink-300">
                    No recent system activity.
                </li>
            @endforelse
        </ul>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('superAdminChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jumuiyas', 'Chairpersons', 'Members'],
            datasets: [{
                label: 'Count',
                data: {!! json_encode([$totalJumuiyas, $totalChairpersons, $totalMembers]) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(236, 72, 153, 0.7)',
                    'rgba(34, 197, 94, 0.7)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(34, 197, 94, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
