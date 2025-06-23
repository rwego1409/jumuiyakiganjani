@extends('layouts.admin')

@section('content')
    <div class="py-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-blue-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-300/60 dark:border-blue-700/60 overflow-hidden">
                <div class="p-6">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                        <div class="flex items-center mb-6 sm:mb-0">
                            <svg class="h-8 w-8 text-blue-500 dark:text-blue-300 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-200">Notifications</h2>
                        </div>
                        <a href="{{ route('admin.notifications.create') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl shadow hover:from-blue-700 hover:to-blue-600 transition duration-300">
                            Create New Notification
                        </a>
                    </div>

                    <!-- Display notifications -->
                    @if ($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div class="flex justify-between items-center p-4 bg-white/70 dark:bg-blue-800/70 rounded-xl shadow border border-blue-100 dark:border-blue-700/30">
                                    <div>
                                        <h5 class="text-xl font-semibold text-blue-600 dark:text-blue-200">{{ $notification->title }}</h5>
                                        <p class="text-sm text-blue-900 dark:text-blue-100">{{ Str::limit($notification->message, 100) }}</p>
                                        <small class="text-xs text-blue-400">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                    <a href="{{ route('admin.notifications.show', $notification->id) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-xl shadow hover:from-blue-700 hover:to-blue-600 transition duration-200">View</a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination links -->
                        <div class="mt-6">
                            {{ $notifications->links('pagination::tailwind') }}
                        </div>
                    @else
                        <div class="p-4 text-center bg-blue-100 text-blue-800 rounded-lg">
                            No notifications found. <a href="{{ route('admin.notifications.create') }}" class="text-blue-600 hover:text-blue-700">Create one now</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
