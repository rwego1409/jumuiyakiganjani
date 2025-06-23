@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900 dark:to-pink-800 transition-colors duration-300 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-pink-900/80 rounded-xl border border-pink-200 dark:border-pink-700 shadow-lg overflow-hidden">
            <div class="p-6 border-b border-pink-200 dark:border-pink-700 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('super_admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-400 hover:from-pink-600 hover:via-red-600 hover:to-yellow-500 text-white font-extrabold rounded-lg shadow-lg border-2 border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Dashboard
                    </a>
                    <h2 class="text-2xl font-bold text-pink-700 dark:text-pink-200 flex items-center ml-2">
                        <svg class="w-7 h-7 mr-2 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        System Activity Log
                    </h2>
                </div>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-pink-200 dark:divide-pink-700 text-xs sm:text-sm md:text-base">
                    <thead class="bg-pink-50 dark:bg-pink-900">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-left font-bold text-pink-500 dark:text-pink-300 uppercase tracking-wider whitespace-nowrap">User</th>
                            <th class="px-2 sm:px-4 py-3 text-left font-bold text-pink-500 dark:text-pink-300 uppercase tracking-wider whitespace-nowrap">Action</th>
                            <th class="px-2 sm:px-4 py-3 text-left font-bold text-pink-500 dark:text-pink-300 uppercase tracking-wider whitespace-nowrap">Description</th>
                            <th class="px-2 sm:px-4 py-3 text-left font-bold text-pink-500 dark:text-pink-300 uppercase tracking-wider whitespace-nowrap">Date</th>
                            <th class="px-2 sm:px-4 py-3 text-right font-bold text-pink-500 dark:text-pink-300 uppercase tracking-wider whitespace-nowrap">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-pink-900 divide-y divide-pink-200 dark:divide-pink-700">
                        @forelse($activities as $activity)
                        <tr class="hover:bg-pink-50 dark:hover:bg-pink-800/50 transition-colors duration-200">
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap">
                                <span class="font-bold text-pink-800 dark:text-pink-100">{{ $activity->user->name ?? 'System' }}</span>
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-pink-100 text-pink-800 dark:bg-pink-700/30 dark:text-pink-200">
                                    <i class="fas fa-{{ $activity->getActivityIcon() }} mr-1"></i> {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-pink-700 dark:text-pink-200 max-w-xs truncate">
                                {{ $activity->description }}
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-xs text-pink-500 dark:text-pink-300">
                                {{ $activity->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('super_admin.activities.show', $activity->id) }}"
                                   class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-400 hover:from-pink-600 hover:via-red-600 hover:to-yellow-500 text-white font-extrabold rounded-lg shadow-lg border-2 border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all duration-200 text-xs sm:text-sm">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-pink-400 dark:text-pink-300">
                                No activity found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 border-t border-pink-200 dark:border-pink-700">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
